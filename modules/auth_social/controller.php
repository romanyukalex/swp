<?php
 /******************************************************************\
  * Modulename	: modulename				 						*
  * Part		: controller										*
  * Scripted By	: RomanyukAlex		           						*
  * Website		: http://popwebstudio.ru	   						*
  * Email		: admin@popwebstudio.ru     						*
  * License		: GPL (General Public License)						* 
  * Purpose		: control all operations							*
  * Access		: insert_module("auth_social","show_auth_links");	*
  * insert_module("auth_social","show_auth_links",$page);			*
  * OrigSnipset	: http://ruseller.com/lessons.php?id=1674			*
  \*****************************************************************/
  
  
  /* 
  //Перенести в before_http модуля auth_social
if($_GET['auth_social']){
	$derirect_url=mb_substr(str_replace("|","&",$_GET['auth_social']),1,(mb_strpos($_GET['auth_social'],"]")-1));
	header("Location: https://".$_SERVER['HTTP_HOST'].'/'.$derirect_url);
}
*/
$log->LogInfo('Got this file');
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	
	//require_once 'lib/SocialAuther/autoload.php';
	require 'lib/SocialAuther/SocialAuther.php';
	require $_SERVER['DOCUMENT_ROOT'].'/modules/auth_social/lib/SocialAuther/Adapter/AdapterInterface.php';
	require 'lib/SocialAuther/Adapter/AbstractAdapter.php';
	require 'lib/SocialAuther/Adapter/Vk.php';
	require 'lib/SocialAuther/Adapter/Facebook.php';
	
	
	
	#Определяем ссылку для редиректа успешно прошедших аутентификацию

	if(!$_SERVER['HTTPS'] or $_SERVER['HTTPS']=="off"){$redirect_url='http://';}
	else $redirect_url='https://';
	
	if(mb_strstr($_SERVER['REQUEST_URI'],"core/ajaxapi.php")) $_SERVER['REQUEST_URI']=mb_substr($_SERVER['REQUEST_URI'],16); //Для ajax вызовов модифицируем REQUEST_URI

	$redirect_url.=$_SERVER['HTTP_HOST'];
	if($param[2]) {
		if(mb_substr($param[2],0,1)=="/") $param[2]=mb_substr($param[2],1); // Если первая палка, то отрежем палку
		$redirect_url.='/?auth_social=['.str_replace("&","|",$param[2]);
		$log->LogDebug('Redirect URL is '.$redirect_url.' from param[2]');
	}
	elseif(!$_GET['auth_social']) $redirect_url.='/?auth_social=['.str_replace("&","|",substr($_SERVER['REQUEST_URI'],1));
	
	else  $redirect_url.=substr(str_replace("&","|",$_SERVER['REQUEST_URI']),0,-37);
	
	if (mb_substr($redirect_url,-1)!=="["){ //В $redirect_url что то есть 
		$redirect_url.="|";//палка перед словом provider=
	} else $redirect_url.="?";
	$log->LogDebug('Redirect URL is '.$redirect_url.' from GET');

	
	//if(!$adapters){
		#Конфиг приложений соцсетей для аутентификации
		$adapterConfigs= array();
		require $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.apps_config.php';
		$adapters = array();
		if(empty($adapterConfigs)){
			$log->LogError('Config is empty');
		} else $log->LogDebug(count($adapterConfigs).' elements in config found');
		foreach ($adapterConfigs as $adapter => $settings) {
			$class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
			$adapters[$adapter] = new $class($settings);
		}
	//}
	
	foreach ($adapters as $title => $adapter) {
			$log->LogDebug('Adapter '.$title.' is ready');
	}


	if ($contact=='show_auth_links'){# Показать ссылки авторизации

		$show_view='auth_links';
		
	}
	
	elseif ($contact=='check_auth'){
			//if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters) && !isset($_SESSION['user'])) {
		#Вычленим детали страницы возврата

		if(strstr($_SERVER['REQUEST_URI'],"?auth_social=%5B")){ // Когда URL приходит в кодированном виде (FB)
	
			$req_dec=urldecode($_SERVER['REQUEST_URI']);
			$log->LogDebug('Decoded URI is '.$req_dec);
			$left_end_pos=mb_strpos($req_dec,"[");
			$right_end_pos=mb_strpos($req_dec,"]");
			$auth_details_str=substr($req_dec,$left_end_pos+1,($right_end_pos-$left_end_pos-1));
	
		}
		
		elseif(isset($_GET['auth_social'])){ // Редирект без кодирования (ВК)
			$auth_details_str=substr($_GET['auth_social'],1,-1); //Отрезали [ и ]	
		}

		if(strpos($auth_details_str,"?")==0){// То отрезаем первый символ
			$auth_details_str=substr($auth_details_str,1);
		}

		$log->LogDebug('Auth details is '.$auth_details_str);

		$auth_details=explode("|",$auth_details_str); //бьем всё, что пришло, по составу	

		// набираем GET-ы и REQUEST-ы
		foreach($auth_details as $detail){
			$auth_det=explode("=",$detail);
			$_GET[$auth_det[0]]=$auth_det[1];
			$_REQUEST[$auth_det[0]]=$auth_det[1];
		}

		
		if (isset($_GET['page'])){ # Надо сменить страницу			
			unset($page);
			include($_SERVER['DOCUMENT_ROOT'].'/core/pagefromget.php');
			$GLOBALS["page"]=$page;
			$GLOBALS["pagequery"]=$pagequery;
		}
		if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters)) { 
			$log->LogDebug('Provider '.$_GET['provider'].' is found in GET');
			$auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);

			if ($auther->authenticate()) {
				$log->LogDebug('Auth successfully: social_id='.$auther->getSocialId()." soc_netw=".$_GET['provider']);
				$result = mysql_query(
					"SELECT *  FROM `$tableprefix-users` WHERE `provider` = '{$auther->getProvider()}' AND `social_id` = '{$auther->getSocialId()}' LIMIT 1"
				);

				$record = mysql_fetch_array($result);
				if (!$record) { $log->LogDebug('User was not found in DB. Trying to insert.');
					$values = array(
						$auther->getProvider(),
						$auther->getSocialId(),
						$auther->getName(),
						$auther->getFirstName(),
						$auther->getSecondName(),
						$auther->getEmail(),
						$auther->getSocialPage(),
						$auther->getSex(),
						date('Y-m-d', strtotime($auther->getBirthday())),
						$auther->getAvatar(),
						$auther->getUserCity(), // Надо бы дешифровать - https://vk.com/pages?oid=-1&p=getCities
						$auther->getUserCountry(),
						$auther->getHomePhone()
					);
					$query = "INSERT INTO `$tableprefix-users` (`userid`,`userrole`,`status`,`changepassmust`,`password_history`, `passw_inp_count`,`provider`, `social_id`, `fullname`,`first_name`,`second_name`, `contactmail`, `social_page`, `gender`, `birthdate`, `avatar`,`city_id`,`country_id`,`contact_phone`) VALUES (NULL,'user','active','2','NO','0','";
					$query .= implode("', '", $values) . "')";
					$result = mysql_query($query);
					$log->LogDebug('User inserted into DB');
					$userid=mysql_insert_id($result);
				} else {
					$userFromDb = new stdClass();
					$userFromDb->provider   = $record['provider'];
					$userFromDb->socialId   = $record['social_id'];
					$userFromDb->name       = $record['fullname'];
					$userFromDb->firstName       = $record['first_name'];
					$userFromDb->secondName       = $record['second_name'];
					$userFromDb->email      = $record['contactmail'];
					$userFromDb->socialPage = $record['social_page'];
					$userFromDb->sex        = $record['gender'];
					$userFromDb->birthday   = date('m.d.Y', strtotime($record['birthdate']));
					$userFromDb->avatar     = $record['avatar'];
					$userFromDb->city     = $record['city_id'];
					$userFromDb->country     = $record['country_id'];
					$userFromDb->homePhone     = $record['contact_phone'];
					$userFromDb->userrole     = $record['userrole'];
					$userid= $record['userid'];
				}

				$user = new stdClass();
				$user->provider   = $auther->getProvider();
				$user->socialId   = $auther->getSocialId();
				$user->name       = $auther->getName();
				$user->firstName       = $auther->getFirstName();
				$user->secondName       = $auther->getSecondName();
				$user->email      = $auther->getEmail();
				$user->socialPage = $auther->getSocialPage();
				$user->sex        = $auther->getSex();
				$user->birthday   = $auther->getBirthday();
				$user->avatar     = $auther->getAvatar();
				$user->city     = $auther->getUserCity();
				$user->country     = $auther->getUserCountry();
				$user->homePhone     = $auther->getHomePhone();
				$user->userrole     = "user";

				if (isset($userFromDb) & $userFromDb != $user) { // Переписывает каждый раз, не работает это условие сравнения
					
					$log->LogDebug('Difference between DB and social info found.'.serialize($userFromDb).serialize($user));

					$birthday = date('Y-m-d', strtotime($user->birthday));

					mysql_query("UPDATE `$tableprefix-users` SET `social_id` = '{$user->socialId}', `fullname` = '{$user->name}', `first_name`='{$user->firstName}',`second_name`='{$user->secondName}',`contactmail` = '{$user->email}', `social_page` = '{$user->socialPage}', `gender` = '{$user->sex}', `birthdate` = '{$birthday}', `avatar` = '$user->avatar', `city_id`='$user->city', `country_id`='$user->country',`contact_phone`='{$user->homePhone}'
						WHERE `userid`='". $record['userid']."'");
					$log->LogDebug("User info was updated: `social_id` = '{$user->socialId}', `fullname` = '{$user->name}', `first_name`='{$user->firstName}',`second_name`='{$user->secondName}',`contactmail` = '{$user->email}', `social_page` = '{$user->socialPage}', `gender` = '{$user->sex}', `birthdate` = '{$birthday}', `avatar` = '$user->avatar', `city_id`='$user->city', `country_id`='$user->country',`contact_phone`='{$user->homePhone}'");
				}

				$_SESSION['log']='1';
				$_SESSION['login']=$user->socialId;
				$_SESSION['userrole']=$user->userrole;
				$_SESSION['userid']=$userid;
				$_SESSION['fullname']=$user->name;
				$_SESSION['avatar']=$user->avatar;
			} else {$log->LogDebug('User is not authenticated via auth provider '.$_GET['provider']);
				$message = $sitemessage[$modulename]['user_auth_error'];
			}
		}
	}
}
?>