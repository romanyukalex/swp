<?php
 /**************************************************************\
  * Modulename	: VK-API					 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		:  insert_module("vk-api","show_like_button"); 	*
  \*************************************************************/
  
  /*
  #Как получить access_token
  1. Создаем приложение 
https://vk.com/editapp?act=create
Тип — Standalone-приложение.
Копируем со страницы Настройки ID приложения
  
ID
6219018

Затем делаем запрос:

https://oauth.vk.com/authorize?client_id=6219018&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=offline,messages,wall,friends,photos,audio,video,pages,status,ads,docs,groups,notifications,stats,email,market&response_type=token&v=5.37
где scope - разрешения https://vk.com/dev/permissions

В URL копируем access_token
cb595b8986b2631772656cbecc68d7759edaf8f255a3aa361d68b79725dbc561b844fe0d8621d6114204c

  */
$log->LogDebug('Got this file with params - '.json_encode($param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	global $vkapi_api_id,$vkapi_secret_key,$vkapi_access_token,$vk_group_id,$vk_group_nickname;
	
	$api_version='5.73';
	#Функция для запросов к API
	
	if(!function_exists("vkAPI")){ // для повторных вызовов модуля
		function vkAPI($method, array $data = [],$return_format='object'){	global $log,$api_version;
	
			$params = [];
			$params['method'] = $method;
			$params['v'] = $api_version;
			$params['version'] = $api_version;
			
			foreach ($data as $name => $val) {
				
				$params[$name] = $val;
				
			}
			if(!$params['access_token'] or $params['access_token']=='') {global $vkapi_access_token; $params['access_token'] = $vkapi_access_token;}
			
			$log->LogDebug("Query with param: ". json_encode($params));
			$url='https://api.vk.com/method/' . $method ;
			$json = file_get_contents($url, false, stream_context_create(array(
				'http' => array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($params)
				)
			)));
			
			if($return_format=='object') return json_decode($json); //Возвращаем объект
			elseif($return_format=='json')return $json;
			elseif($return_format=='array')return json_decode($json,TRUE); 
			elseif($return_format=='query')return $url.http_build_query($params);
		}	
	}
	
	
	if($contact=='post_to_wall_with_attach'){

		#####################################################################################
		############# Запостить на стену юзеру или группе и приложить картинку ##############
		#####################################################################################


		/* //Вызов: 
		#Картинка локальная
		$vk_post_text="Тимур сейчас ведет тренинг по новому коду НЛП!";
		$vk_post_attach=array(
			'link'=>'https://psy-space.ru/?page=gagin',
			'image'=>$_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/gagin_business.jpg'
		);
		insert_module("vk-api","post_to_wall_with_attach","$vk_group_id","$vk_post_text",$vk_post_attach);
		
		#Картинка с внешнего сервера
		$url = 'http://www.b17.ru/foto/article/89727.jpg';
		$path = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/'.basename($url);
		file_put_contents($path, file_get_contents($url));

		$vk_post_text="Тимур сейчас ведет тренинг по новому коду НЛП!";
		$vk_post_attach=array(
			'link'=>'https://psy-space.ru/?page=gagin',
			'image'=>$path
		);
		insert_module("vk-api","post_to_wall_with_attach","$vk_group_id","$vk_post_text",$vk_post_attach);
		unlink($path);
		*/
		
		/*
		function vkAPI($method, array $data = []){	global $vkapi_access_token,$log;

			$params = [];
			foreach ($data as $name => $val) {
				$params['method'] = $method;
				$params[$name] = $val;
				$params['access_token'] = $vkapi_access_token;
			}
			$url='https://api.vk.com/method/' . $method ;
			$json = file_get_contents($url, false, stream_context_create(array(
				'http' => array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($params)
				)
			)));
			
			return json_decode($json); //Возвращаем объект
		}
		
		*/
		$vk_group_id=$param[2];
		$vk_wall_post_message=$param[3];
		$vk_wall_post_attach=$param[4];
			
		//$v = '5.73';
			
		if($vk_wall_post_attach['link']) $post_attachmts.=$vk_wall_post_attach['link']; //Присоединили ссылку к посту
		if($vk_wall_post_attach['video']) { //Присоединяем видео к посту
			if($post_attachmts) $post_attachmts.=",".$vk_wall_post_attach['video'];
			else $post_attachmts.=$vk_wall_post_attach['video'];
		}
		if($vk_wall_post_attach['image']) {
			$image_name = basename($vk_wall_post_attach['image']);
			$image =$vk_wall_post_attach['image'];
		
			#ЗАГРУЖАЕМ КАРТИНКУ
		
			$upload_url = vkAPI('photos.getWallUploadServer', ['group_id' => $vk_group_id,'version'=>$api_version,
				'v'=>$api_version])->response->upload_url;
			try {
				$ch = curl_init($upload_url);
				$cfile = curl_file_create($image, mime_content_type($image), $image_name);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, ['photo' => $cfile]);
				$responseUpload = json_decode(curl_exec($ch));
				curl_close($ch);
				//echo 'Картинка успешно загружена<br>';
				$log->LogInfo("Image uploaded to VK successfully");
			} catch (Exception $e) {
				$log->LogError("Unknown error when tried to upload image to VK");
				//exit('Неизвестная ошибка при попытке загрузки картинки');
			}
			
			$responseSave = vkAPI('photos.saveWallPhoto', [
			   // 'owner_id' => $user_id,
			   'group_id'=>$vk_group_id,
				'photo' => stripslashes($responseUpload->photo),
				'server' => $responseUpload->server,
				'hash' => $responseUpload->hash,
				'version'=>$api_version,
				'v'=>$api_version,
			]);
			if ($responseSave->error) {
				$log->LogError("Unknown error when tried to save uploaded image to VK. API answer: code is ".$responseSave->error->error_code.', message is "'.$responseSave->error->error_msg .'"');
				//exit('Неизвестная ошибка при попытке сохранения картинки');
			} else {# Картинка успешно сохранена
				$log->LogInfo("Uploaded image saved in VK successfully");
				
				$post_attachmts.=",".$responseSave->response[0]->id; //убрать запятую, если нет других аттачментов
			}
		}
		#ПОСТИМ
		$responsePost = vkAPI('wall.post', [
			'owner_id' => '-'.$vk_group_id,
			'message' => $vk_wall_post_message,
			'attachments' =>$post_attachmts,
			'hash' => $responseSave->response[0]->hash,
			'v'=>$api_version
		]);
		if ($responsePost->error) {
			if ($responsePost->error->error_code == 214) {
				$log->LogError('Error. Wall closed to post. Code - '.$responsePost->error->error_code.', message - "'.$responsePost->error->error_msg.'"');
			} else {
				$log->LogError('Unknown error while post. Code - '.$responsePost->error->error_code.', message - "'.$responsePost->error->error_msg.'"');
			}
			//return false;
		} else {
			$log->LogInfo('Successfully posted. Post id - '.$responsePost->response->post_id);
			//return true;
		}
	}
	
	elseif ($contact=='post_to_wall'){
		
		##########################################################
		############# Запостить на стену сообщества ##############
		##########################################################
	
		if(isset($param[1])) { // Вызвали как модуль
			$wall_id=$param[2];
			$vk_wall_post_message=$param[3];
			$vk_wall_post_attach=$param[4];
		}
		elseif(isset($_REQUEST['action']))  $wall_id=process_data($_REQUEST['wall_id'],30);
	
//https://api.vk.com/method/wall.post?api_id=4977152&attachments=video-95462752_456239226&format=json&friends_only=0&from_group=1&message=%D0%A2%D0%B5%D1%81%D1%82&method=wall.post&owner_id=-95462752&access_token=2db9880659506727192ff86d6e395aea91ecb1b784189efc30eb952437a1c9ed35e5281dd416b8ac05152


			//$a = 'https://api.vk.com/method/wall.post?api_id='.$vkapi_api_id.'&attachments='.$vk_wall_post_attach.'&format=json&friends_only=0&from_group=1&message='.$vk_wall_post_message.'&method=wall.post&owner_id=-'.$wall_id.'&access_token='.$vkapi_access_token; //собираем ccылку для запроса (XYZ - токен, rights to call this method: wall)
		
			$url = 'https://api.vk.com/method/wall.post';
			$params = array(
			'method' => 'wall.post',
			'api_id' => $vkapi_api_id,
			'attachments'=>$vk_wall_post_attach,
			'format'=>'json',
			'friends_only'=>'0',
			'from_group'=>'1',
			'message'=> $vk_wall_post_message,
			'owner_id' =>'-'.$wall_id, 
			'access_token'=>$vkapi_access_token,
			'v'=>$api_version
			);
			
			$post_q = file_get_contents($url, false, stream_context_create(array(
				'http' => array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($params)
				)
			)));
		
			
		
			//$post_q = file_get_contents(rtrim($a)); //отправляем запрос
			if($post_q){
			
				$obj = json_decode($post_q); //обрабатываем джисон 
				$upload_id = $obj->{'response'}->{'post_id'};
				if($upload_id){
					$log->LogDebug('Successfully posted. Post id - '.$upload_id);
				} else {
					//$log->LogDebug('Error - '.$resp['error']['error_code'].' '.$resp['error']['error_msg']);
					$log->LogError('Error - '.$obj->{'error'}->{'error_code'}.' '.$obj->{'error'}->{'error_msg'});
					$log->LogDebug('Sent params:'.json_encode($params).'Answer JSON is '.$post_q);
				}
				
			} else {
				$log->LogDebug('Cant get URL');
			}

	} 
	#################################################
	############# Сохранить видео в ВК ##############
	#################################################
	
	# USAGE
	# AJAX: $("#vp_block_"+yt_id+'_soc_ap').load('/core/ajaxapi.php?',{action:'video.save',ytid:yt_id,group_id:'<?=$vk_group_id? >',mod:'vk-api'}); - исправить ? >
	# PHP: insert_module('vk-api','video.save',"$yt_id","$group_id");
	elseif($contact=="video.save"){ 
		
		if($_REQUEST['group_id']) $group_id=$_REQUEST['group_id'];
		else  $group_id=$param[3];
		if($_REQUEST['ytid']) $ytid=$_REQUEST['ytid'];
		else  $ytid=$param[2];
		
		
		$v_details_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `yt_id`='".$ytid."' limit 0,1;");
		$log->LogDebug('Found '.mysql_num_rows($v_details_q).' video');
		if(mysql_num_rows($v_details_q)>0){
			$v_details=mysql_fetch_array($v_details_q);
			if(!$v_details['vk_v_id']){
				$log->LogDebug('Video had not posted to VK before');
				$link = 'https://www.youtube.com/watch?v='.$ytid; // ccылка на ютуб
				//$name = urlencode ( $v_details['vtitle']); //название видео (не обязательно)
				$name =  $v_details['vtitle']; //название видео 
				$alltags=explode(';',$v_details['tags']);
				foreach($alltags as $tag){
					if($tag){
						if(substr_count($tag,' ')>0){#Тег содержит пробелы
							$tags.='#'.str_replace(' ','_',$tag).' ';
							$tags.='#'.str_replace(' ','',$tag).' ';
						} else $tags.='#'.$tag.' ';
					}
				}
				$tags.='#'.$vk_group_nickname;
				
				function get_album_by_tags($tags){
					if(stristr($tags,'Работа над собой')) return 3;
					if(stristr($tags,'Здоровье')) return 4;
					if(stristr($tags,'Духовное развитие')) return 5;
					if(stristr($tags,'Деньги')) return 6;
					if(stristr($tags,'Цели')) return 7;
					if(stristr($tags,'Полезные навыки')) return 8;
					if(stristr($tags,'Ораторское искусство')) return 9;
					if(stristr($tags,'Управление и лидерство')) return 10;
					if(stristr($tags,'Вредные привычки')) return 11;
					if(stristr($tags,'Тайм-менеджмент')) return 12;
					if(stristr($tags,'Уверенность в себе')) return 13;
					if(stristr($tags,'Невербальная коммуникация')) return 14;
					if(stristr($tags,'Мотивация')) return 15;
					if(stristr($tags,'Выход из кризиса')) return 16;
					if(stristr($tags,'Карьера')) return 17;
					if(stristr($tags,'Бизнес')) return 18;
					if(stristr($tags,'Управление эмоциями')) return 19;
					if(stristr($tags,'Харизма и энергетика')) return 20;
					if(stristr($tags,'Успешный мужчина')) return 21;
					if(stristr($tags,'Счастливая женщина')) return 22;
					if(stristr($tags,'Найти вторую половину')) return 23;
					if(stristr($tags,'Романтические отношения')) return 24;
					if(stristr($tags,'Отношения в браке')) return 25;
					if(stristr($tags,'Завершение отношений')) return 26;
					if(stristr($tags,'Родители и дети')) return 27;
					if(stristr($tags,'НЛП')) return 2;
					if(stristr($tags,'Эриксоновский гипноз')) return 29;
					if(stristr($tags,'Human design')) return 30;
					if(stristr($tags,'Соционика')) return 31;
					if(stristr($tags,'Психология для профи')) return 28;
					
				}
				$album_id=get_album_by_tags($v_details['tags']);
				
				if(!$album_id) $album_id=1; //Развитие, определить стиль видео исходя из ключевых слов (для проекта freecon)
				
				$description = $v_details['v_full_desc']."\r\n".$tags; //описание видео
				
				$wallpost = '0'; //опубливоать на стене (0 - нет, 1 - да)
				
				$a = 'https://api.vk.com/method/video.save?group_id='.$group_id.'&album_id='.$album_id.'&link='.$link.'&name='.$name.'&description=' . $description . '&wallpost=' . $wallpost . '&access_token='.$vkapi_access_token; //собираем ccылку для запроса (XYZ - токен, rights to call this method: video)

				//$addvideo = file_get_contents(rtrim($a)); //отправляем запрос
				
				$url = 'https://api.vk.com/method/video.save';
					$params = array(
					'group_id' => $group_id,
					'album_id'=>$album_id,
					'link'=>$link,
					'name'=>$name,
					'description'=> $description,
					'wallpost' =>$wallpost, 
					'access_token'=>$vkapi_access_token,
					'v'=>$api_version
					);
					$addvideo = file_get_contents($url, false, stream_context_create(array(
						'http' => array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => http_build_query($params)
						)
					)));
				
				if($addvideo){
					$log->LogDebug('Answer was:'.$addvideo);
					$obj = json_decode($addvideo); //обрабатываем джисон 
					if(	$upload_url = $obj->{'response'}->{'upload_url'}) {//тут получаем ссылку для подтверждения добавления
						
						if($obj->{'response'}->{'vid'}) $vk_v_id=$obj->{'response'}->{'vid'};
						elseif($obj->{'response'}->{'video_id'}) $vk_v_id=$obj->{'response'}->{'video_id'};
						else $vk_v_id=$obj->{'response'}->{'id'};
						
						$log->LogDebug('Video id is '.$vk_v_id);
						$vk_v_access_key=$obj->{'response'}->{'access_key'};
						
						$push_v_q=file_get_contents(rtrim($upload_url)); //открываем ссылку
						$push_v_obj=json_decode($push_v_q);
						if($push_v_obj->{'response'}=='1'){// Залилось успешно
							$vid_upd_q=mysql_query("UPDATE `$tableprefix-videos` SET `vk_v_id` = '$vk_v_id' WHERE `yt_id` ='".$ytid."';");
							$log->LogDebug('Video posted to VK successfully');
							echo "Видео успешно добавлено в группу ВК";
						} else {
							$log->LogDebug('Video is not posted to VK:'.$push_v_q);
						}
					} else {
						$log->LogDebug('Video is not posted to VK:'.serialize($obj));
					}
				} else {
					echo 'Видео не добавлено в ВК (ошибка)';
					$log->LogDebug('Video is not posted to VK, some error'.$addvideo.' Query was - '.$a);
					/*#Попробуем через Post
					$url = 'https://api.vk.com/method/video.save';
					$params = array(
						'param1' => '123', // в http://localhost/post.php это будет $_POST['param1'] == '123'
						'param2' => 'abc', // в http://localhost/post.php это будет $_POST['param2'] == 'abc'
					);
					$result = file_get_contents($url, false, stream_context_create(array(
						'http' => array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => http_build_query($params)
						)
					)));

					echo $result;*/
				}
			} else {
				echo 'Видео уже постили в ВК';
				$log->LogDebug('Video already posted to VK');
			}
		} else {$log->LogDebug('Video is not found in DB');
			echo "Видео не найдено в БД";
		}
	} elseif($contact=="show_group_widget"){
		$show_view='group_widget';
	} elseif($contact=="add_image_to_group"){

		/* НЕ РАБОТАЕТ */
		echo "Добавляем картинку!!!<br><br><br><br>";
		$publicID=$params[2];
		$fullServerPathToImage=$params[3];
		require_once('vkontakte-php-sdk-master/src/Vkontakte.php');

		$vkAPI = new \BW\Vkontakte(['access_token' => $vkapi_access_token]);
		$text="тест, простите";
		if ($img_id=$vkAPI->postToPublic($publicID, $text, $fullServerPathToImage, $tags = array())){
		//if ($img_id=$vkAPI->postImgToGroup($publicID, $fullServerPathToImage)) {

			echo "Ура! Всё работает, пост добавлен\n".$img_id;
			$return_data=$img_id;

		} else {

			echo "Фейл, пост не добавлен(( ищите ошибку\n";
		}
	} elseif($contact=='show_like_button'){
		// Код получается отсюда - https://vk.com/dev/Like
		$show_view='like_button'; // Код кнопки пишется в файл /project/projectname/modules_data/vk-api.view.like_button.php
	} /*elseif($contact=="send_message"){
		//при параметре scope=offline,messages
		//function send_vk_message($id , $message){
			$url = 'https://api.vk.com/method/messages.send';
			$params = array(
				'user_id' => $id,    // Кому отправляем
				'message' => $message,   // Что отправляем
				'access_token' => '0000000000000000000000000000',  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
				'v' => '5.37',
			);

			// В $result вернется id отправленного сообщения
			$result = file_get_contents($url, false, stream_context_create(array(
				'http' => array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($params)
				)
			)));
		//}
	}*/ elseif($contact=="get_wall"){ #Получаем записи со стены
		
		/*#Usage example
		
		$wall_posts=insert_module("vk-api","get_wall","yogabrau", 3); //by group name
		
		// or 
		
		$wall_posts=insert_module("vk-api","get_wall","-$group_id", 3); //by group id
		
		// or
		
		$wall_posts=insert_module("vk-api","get_wall","$user_id", 3); //by user id
		
		// or
		
		$wall_posts=insert_module("vk-api","get_wall","$user_name", 3); //by user name
		
		if($wall_posts) var_dump($wall_posts);
		*/
		
		if($param[2]){
			$wall_id=$param[2];//ID стены или имя пользователя/сообщества. ID для сообществ со знаком -
			if($param[3]) $row_count=$param[3]; else $row_count=10;
			if(ctype_digit($wall_id) or ctype_digit(mb_substr($wall_id,1))) {//Передали ID
			
				$return_data=vkAPI('wall.get', ['owner_id' => "$wall_id",    'count' => $row_count,    'filter' => 'owner']);
			
			} else {//Передали имя группы 
				$return_data=vkAPI('wall.get', ['domain' => "$wall_id",    'count' => $row_count,    'filter' => 'owner']);
			}
			//$return_data= $get_wall_q;
		} else $return_data=FALSE;
		
	} elseif($contact=="get_groupId_by_name"){
		//	$group_id=insert_module("vk-api","get_groupId_by_name","psyspace_club");
		$return_data=vkAPI('groups.getById', ['group_id' => "$param[2]"],'array')['response']['0']['gid'];
	
	} elseif($contact=="get_repost_info"){ #Инфо о репостнувших пост
	
	/* #Usage example
	$owner_id="-95462752";
	$post_id="2633";


	$repost_info=insert_module("vk-api","get_repost_info",$owner_id,$post_id);
	
	echo "<hr>";
	foreach( $repost_info ['response']['items'] as $repost_user){
		//var_dump($repost_user);
		echo "<br>Имя - ".$repost_user['first_name'];
		echo "<br>Фамилия - ".$repost_user['last_name'];
		echo "<br>UID - ".$repost_user['uid'];
	}
		
	*/
	
	
		$owner_id=$param[2];
		$post_id=$param[3];
		
		$responsePost = vkAPI('likes.getList', [
			'type'=>'post',
			'owner_id' => $owner_id,
			'item_id'=>$post_id,
			'filter'=>'copies',
			'extended'=>1,
			'count'=>1000,
			'skip_own'=>1
			
		],'array');
		if ($responsePost['error']) {
			$log->LogError('Error while post - '.$responsePost['error']['error_code']);
			return false;
		} else {
			$log->LogInfo('Successfully got reposts');
			$return_data=$responsePost;
		}
		
	} elseif($contact=="send_message"){ #Отослать сообщение пользователю
		
		/* 
		$mes_toUser=insert_module("vk-api","send_message","313329033","Привет"); 
		$mes_toUser=insert_module("vk-api","send_message",$repost_user['uid'],"Привет",$access_token_gr);
		*/
		
		$to_id=$param[2];
		$message=$param[3];
		if($param[4]) $access_token=$param[4]; // Если передали другой токен, то отправим от него. Актуально для отправки от имени группы, тк остальные дела делаются через токен пользователя, а от группы не работают почему то
		
		$responsePost = vkAPI('messages.send', [
			'user_id'=>$to_id,
			'message' => $message,
			'random_id' => rand(1000,9999999),
			'v'=> 5.45,
			'access_token'=>$access_token
		],'array');

		if ($responsePost['error']) {
			
			$log->LogError('Error while post - '.$responsePost['error']['error_code']);
			//var_export($responsePost);
			//echo $responsePost['error']['error_code'];
			return false;
		} else { //Отправлено успешно
			$log->LogInfo('Successfully sent message. Message id - '.$responsePost['response']);
			$return_data=$responsePost;
		}
		
	} elseif($contact=="get_operations_page"){
		// Пример:  insert_module("vk-api","get_operations_page", "4977152","mo8Ru7fGxBriLR93uEOh");
		if($param[2] and $param[3]) {
			$show_view='api_operations';
		}
	}
	elseif($contact=="get_api_data"){
		require 'vk-orig/vkapi.class.php';

		//$api_id = $_REQUEST['api_id']; // Insert here id of your application
		//$secret_key = $_REQUEST['secret_key']; // Insert here secret key of your application
		
		$VK = new vkapi($vkapi_api_id, $vkapi_secret_key);
		if($_REQUEST['vk_action']=="getProfiles"){
			$resp = $VK->api('getProfiles', array('uids'=>'10153418','fields'=>'uid, first_name, last_name, nickname, screen_name, sex, bdate (birthdate), city, country, timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online, counters')); // можно через "," несколько юзеров
		} 
		elseif($_REQUEST['vk_action']=="getUsers"){
			$resp3 = $VK->api('users.get',array('user_ids'=>'aoromanyuk'));
			print_r($resp3);
			echo "<br><br>";
		} 
		elseif($_REQUEST['vk_action']=="groups.getMembers"){
			$group_ids=$_REQUEST['vk_gm_grids'];
			
			
			$group_id=explode("\r\n",$group_ids);
			
			
			if(count($group_id)==1){ // Одна группа, работаем с подробностями
				
				echo "Список ID всех участников группы ".$group_id[0].":<br><br>";
				
				
				if($_REQUEST['someid']){ // Запрашивают следующую тысячу юзеров
					$gr_users_count_num=$_REQUEST['someid']; // С какой тысячи начинать запрос
					$attr_array['offset']=$gr_users_count_num*1000;
				} else $gr_users_count_num=0;
				$attr_array=array('group_id'=>$group_id[0],'fields'=>'city'); // Условия запроса
				
				# Информация о группе
				$gr_info=$VK->api('groups.getById',array('group_id'=>$group_id[0],'version'=>$api_version,
					'v'=>$api_version,'fields'=>'city,country,place,description,wiki_page,members_count,counters,start_date,finish_date,can_post,can_see_all_posts,activity,status,contacts,links,fixed_post,verified,site,ban_info'));
				$grm_u_count=$gr_info ['response'] [0]['members_count']; // Число участников в группе
				?>
				<table class="zebra"><tr><td>Фото</td><td><img src="<?=$gr_info ['response'] [0]['photo_medium']?>"></td></tr>
				
				<tr><td>ID группы</td><td><?=$gr_info ['response'] [0]['gid']?></td></tr>
				<tr><td>Имя группы</td><td><?=$gr_info ['response'] [0]['name']?></td></tr>
				<tr><td>Закрытая?</td><td><?=$gr_info ['response'] [0]['is_closed']?></td></tr>
				<tr><td>Тип группы</td><td><?=$gr_info ['response'] [0]['type']?></td></tr>
				<tr><td>Всего участников</td><td><?=$grm_u_count?></td></tr>
				<tr><td>Описание</td><td><?=$gr_info ['response'] [0]['description']?></td></tr>
				<tr><td></td><td></td></tr>
				</table>
				<?
			
				// print_r($gr_info); // Все данные из API
				
				if($_REQUEST['vk_gm_all_list'] and $grm_u_count/1000>1){ # Весь список группы с размером >1000
					$rgm_q_num=0;
					echo $grm_try_count;
					$resp=array();
					$resp2=array();
					while($rgm_q_num<$grm_u_count/1000){
						$attr_array['offset']=1000*$rgm_q_num;
						$resp1 = $VK->api('groups.getMembers',$attr_array);
						$rgm_q_num++;
						$gr_users_count=$gr_users_count+count($resp1['response']['users']);
						$resp2=$resp;
						$resp=array_merge($resp2, $resp1['response']['users']);
						unset($resp2);
					}
				}		
				else {
				
					$resp1 = $VK->api('groups.getMembers',$attr_array);
					$resp=$resp1['response']['users'];
					$gr_users_count=count($resp1['response']['users']);
				}
		
				if ($gr_users_count>0){ # Есть что выводить 
					?>Получено из API <?=$gr_users_count?> пользователей<br><br><?
					
					if($gr_users_count==1000){$gr_users_count_num++;?><a onclick="saveform2('<?=$gr_users_count_num;?>','vkapiform','vk_answer_place','<?=$modulename?>','','no_resetform','no_hideform');return false;"" href="/" class="blue medium button">Следующая 1000</a><br><br><?}
					if(!$_REQUEST['vk_gm_intofile']){ # Вывод результатов на экран
					
						?>
						Отображать поля:<br>
						<input type="checkbox" id="showcol_1" onclick="hidecolmanage('groupmembers_table','1');" checked>Фамилия<br>
						<input type="checkbox" id="showcol_2" onclick="hidecolmanage('groupmembers_table','2');" checked>Имя<br>
						<input type="checkbox" id="showcol_3" onclick="hidecolmanage('groupmembers_table','3');" checked>Город<br><br>
						
						Фильтр строк:<br>
						<input type="checkbox" id="showrow_moscow" onclick="hideTRmanage('groupmembers_table','Москва');">Только Москва<br>
						
						<table id="groupmembers_table">
							<tr>
								<th>ID</th>
								<th>Фамилия</th>
								<th>Имя</th>
								<th>Город</th>
								
							</tr><?
						//foreach ($resp['response']['users'] as $us_data){
						foreach ($resp as $us_data){
							if(!$_REQUEST['vk_gm_only_moscow'] or ($_REQUEST['vk_gm_only_moscow'] and $us_data['city']==1)){
							?><tr>
							<td><?=$us_data['uid'];?></td>
							<td><?=$us_data['last_name'];?></td>
							<td><?=$us_data['first_name'];?></td>
							<td><? if($us_data['city']==1) echo "Москва";else echo $us_data['city'];?></td>
							</tr><?
							}
						}
						?></table>
						<script>
							function hideTRmanage(table_id,string_in_row){
							$('#'+table_id+' tr:not(:contains("'+string_in_row+'"))').hide();
								}
						</script><? 
					} else { # Вывод результатов в файл
						if($_REQUEST['vk_gm_only_moscow']){ $city_mark="msk"; } else {$city_mark="all";}# Ставим метку города в файл
						$file="project/$projectname/modules_data/".$modulename."_groups.getMembers_results/".$group_id[0]."_".$city_mark."_".date('Y-m-d').".csv";
						//unset($fullpath.$file);
						$fo = fopen($fullpath.$file, "w");
						fclose($fo);
						?><a href="/<?=$file?>" target="_blank">Скачать файл</a><?
						insert_function("add_to_end_of_file");
						foreach ($resp as $us_data){
							if(!$_REQUEST['vk_gm_only_moscow'] or ($_REQUEST['vk_gm_only_moscow'] and $us_data['city']==1)){
								add_to_end_of_file($us_data['uid'], $fullpath.$file);
							}
						}
					
					}
					
				} else { echo "Участники не найдены:<br><br>";var_dump($resp); }
			
			} else { # Много групп. Выводим IDs в файл
				
				echo "Список ID всех участников ".count($group_id)." групп:<br><br>";
				
				# Почти уникальный идентификатор списка	
				foreach($group_id as $tempgrid) {$uniq_id.=substr($tempgrid,1,1);}
				
				# Файл
				if($_REQUEST['vk_gm_only_moscow']){ $city_mark="msk"; } else {$city_mark="all";}# Ставим метку города в файл
				$file="project/$projectname/modules_data/".$modulename."_groups.getMembers_results/".$uniq_id."_".$city_mark."_".date('Y-m-d').".csv";
				$fo = fopen($fullpath.$file, "w");
				fclose($fo);
				insert_function("add_to_end_of_file");
				
				# Пишем результаты в файл
				foreach($group_id as $key=>$gr_ids1){
					# Инфо о группе
					
					$gr_info=$VK->api('groups.getById',array('group_id'=>$gr_ids1,'fields'=>'city,country,place,description,wiki_page,members_count,counters,start_date,finish_date,can_post,can_see_all_posts,activity,status,contacts,links,fixed_post,verified,site,ban_info'));
					$grm_u_count=$gr_info ['response'][0]['members_count']; // Число участников в группе

					$attr_array=array('group_id'=>$gr_ids1,'fields'=>'city');
					if($grm_u_count/1000>1){ # Весь список группы с размером >1000
						$rgm_q_num=0;
						echo $grm_try_count;
						$resp=array();
						$resp2=array();
						while($rgm_q_num<$grm_u_count/1000){
							$attr_array['offset']=1000*$rgm_q_num;
							$resp1 = $VK->api('groups.getMembers',$attr_array);
							$rgm_q_num++;
							$gr_users_count=$gr_users_count+count($resp1['response']['users']);
							$resp2=$resp;
							$resp=array_merge($resp2, $resp1['response']['users']);
							unset($resp2);
						}
					}	else {
						
						$resp1 = $VK->api('groups.getMembers',$attr_array);
						$resp=$resp1['response']['users'];
						$gr_users_count=count($resp1['response']['users']);
					}
					# Пишем в файл тех, кто в нужном городе
					foreach ($resp as $us_data){
						if(!$_REQUEST['vk_gm_only_moscow'] or ($_REQUEST['vk_gm_only_moscow'] and $us_data['city']==1)){
							add_to_end_of_file($us_data['uid'], $fullpath.$file);
						}
					}
					print_r($attr_array);
					unset($attr_array);
				}
				?><a href="/<?=$file?>" target="_blank">Скачать файл</a><?
			}
		}
		elseif($_REQUEST['vk_action']=="getUserFriends"){ #Получить список друзей пользователя
			$need_user_id='235585242';
			#Получить список друзей пользователя
			$responsePost = vkAPI('friends.get', [
				'user_id' => $need_user_id,
				'fields'=>'city',
				'v'=>$api_version
			],'array'
			);
			if ($responsePost['error']) {
				
				$log->LogError('Unknown error while post. Code - '.$responsePost['error']['error_code'].', message - "'.$responsePost['error']['error_msg'].'"');
				
				
			} else {// скачали список друзей
				
				$log->LogInfo('Successfully got user frinds list.');
				# Файл
				if($_REQUEST['vk_gm_only_moscow']){ $city_mark="msk"; } else {$city_mark="all";}# Ставим метку города в файл
				$file="project/$projectname/modules_data/".$modulename."/UserFriends_".$need_user_id."_".$city_mark."_".date('Y-m-d').".csv";
				$fo = fopen($fullpath.$file, "w");
				fclose($fo);
				insert_function("add_to_end_of_file");
				#Пишем в файл построчно
				foreach ($responsePost["response"]['items'] as $us_data){
						add_to_end_of_file($us_data['id'], $fullpath.$file);
				}
				echo "<a target='_blank' href='/".$file."'>Скачать файл</a>";
			}
		}
	}
	
}
?>