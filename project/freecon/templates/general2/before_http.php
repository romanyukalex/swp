<? 
  /******************************************************************************************************************************
  * Snippet Name : Before http																						            * 
  * Scripted By  : RomanyukAlex		           																				    * 
  * Website      : http://popwebstudio.ru	   																				    * 
  * Email        : admin@popwebstudio.ru    					 														        * 
  * License      : License on popwebstudio.ru from autor		 															    *
  * Purpose 	 : Вставляется до HTML (в заголовок HTTP). Должен содержать ТОЛЬКО PHP										    *
  * Insert		 : include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/before_http.php');  *
  ******************************************************************************************************************************/ 
 
$this_visit_date=date("Y-m-d");
if(!$_COOKIE["prev_visit_date"]) {
	$_SESSION['first_entry']=1;
	setcookie("visit_count","1");
} elseif($_COOKIE["prev_visit_date"]!==$this_visit_date){
	$_SESSION['return_entry']=1;
	if($_COOKIE["visit_count"]) setcookie("visit_count",$_COOKIE["visit_count"]+1);
	else  setcookie("visit_count","1");
}
setcookie("prev_visit_date","$this_visit_date");


if($_SESSION['log']=='1' and !$_COOKIE["registered"]){//Впервые вошел после регистрации
	setcookie("registered","1");
	setcookie("fullname","$fullname");
	unset($_SESSION['return_entry']);
	
	if($_SESSION['userid']){#Навесим ему рассылочку
		
	}
}

#Введем переменные для простоты определения домена
if ($_SERVER['HTTP_HOST']=="psy-space.ru" or $_SERVER['HTTP_HOST']=="www.psy-space.ru") $ps=1;
elseif ($_SERVER['HTTP_HOST']=="soznanie.club" or $_SERVER['HTTP_HOST']=="www.soznanie.club") $sclub=1;
elseif ($_SERVER['HTTP_HOST']=="soznanie.shop" or $_SERVER['HTTP_HOST']=="www.soznanie.shop") $sshop=1;

#Для ботов есть переадресация
if($bot_name){
	#Яндекс назапоминал каких то параметров неизвестно откуда
	foreach($_GET as $get=>$get_value){
		if($get=="yaads" or $get=="yacat" or $get=="vk" or $get=="vkadd" or $get=="lp_type" or $get=="goads" or $get=="pa" or $get=="pag" or !$get_value){
			$bot_needs_redirect=1;
			unset($_GET[$get]);
		}
	}
	if($bot_needs_redirect==1){ //Нужно сделать редирект боту без ненужных параметров, пусть привыкает, что таких параметров нет
		$redirect_uri="/?";
		foreach($_GET as $get=>$get_value){
			$redirect_uri.=$get.'='.$get_value.'&';
		}
		$redirect_uri=mb_substr($redirect_uri,0,-1);
		header("Location: https://".$_SERVER['HTTP_HOST'].$redirect_uri);
		$log->LogInfo("Redirect request to https://".$_SERVER['HTTP_HOST'].$redirect_uri);
		exit;
	}
	# Откуда то взявшийся артефакт, яндекс его запомнил, надо удалять
	if (mb_strstr($_SERVER['QUERY_STRING'],"%20title=")) {
		header("Location: https://".$_SERVER['HTTP_HOST'].'/?'. mb_substr($_SERVER['QUERY_STRING'],0,-9));
	}
	# Неверно закешированная страница. Это страницы временные
	if($_REQUEST['page']=="dnld_book"){ 
		header("Location: https://".$_SERVER['HTTP_HOST'].'/?page=psybooks');
	}
}
//Перенести в before_http модуля auth_social
if($_GET['auth_social']){
	insert_module("auth_social","check_auth");
	$derirect_url=mb_substr(str_replace("|","&",$_GET['auth_social']),1,(mb_strpos($_GET['auth_social'],"]")-1));
	header("Location: https://".$_SERVER['HTTP_HOST'].'/'.$derirect_url);
}
if($_GET['from']){ //Перешли извне, фиксируем откуда и редиректим без этого параметра
	$_SESSION['traffic_source']=$_GET['from'];
	unset($_GET['from']);
	//Пересобираем URL без GET['from']
	$redirect_uri="/?";
	foreach($_GET as $get=>$get_value){
		$redirect_uri.=$get.'='.$get_value.'&';
	}
	$redirect_uri=mb_substr($redirect_uri,0,-1);
	header("Location: https://".$_SERVER['HTTP_HOST'].$redirect_uri);

} 
//Перенести в before_http модуля swpshop
if($page=="swpshop" and $_GET['action']=="show_orders" and ($userrole=="guest" or !$userrole)){
	$_SESSION['redirect_url']='/?page=swpshop&action=show_orders';
	header("Location: https://".$_SERVER['HTTP_HOST'].'/?page=login');
}
if($page=="swpshop" and $_GET['action']=="show_shoppingcart" and ($userrole=="guest" or !$userrole)){
	$_SESSION['redirect_url']='/?page=swpshop&action=show_shoppingcart';
	header("Location: https://".$_SERVER['HTTP_HOST'].'/?page=login');
}
#Начисляем баллы
if($_SESSION['first_entry']){//Первый вход - начиляем 5
	$_SESSION['hearts']=5;
	setcookie("hearts",5);
	
} else { //Не в первые на сайте
	//if($_SESSION['hearts']) $_SESSION['hearts']++;
	//elseif($_COOKIE["hearts"]) setcookie("hearts",$_COOKIE["hearts"]+1);
}