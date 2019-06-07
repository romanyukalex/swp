<? # Определяем $page из GET
$log->LogInfo('Got this file');
include_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/process_user_data.php');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php');
if($page){$log->LogDebug('Page is '.$page.' which is got before');}
//if ($page!=='404' and !$page)
if ($page!=='404')
	{
	$page=process_data($_REQUEST['page'],200);
	if($page){$log->LogDebug('Page from REQUEST[] is '.$page);}
	elseif($_SESSION['templatepage'] and !$adminpanel){
		$page=$_SESSION['templatepage'];
		$log->LogDebug('Page from SESSION[] is '.$page);
	}
	$parentpage=process_data($_REQUEST['parentpage'],200);
	if (!$page and $adminpanel!==1){
		$page=$default_page;
		}
	elseif(!$page and $adminpanel==1){$page='admin_hello';}
	if ($changepassmust=='yes'){$pageshtrih=$page;
		if ($adminpanel!==1) $page='change_password_page';
		elseif($adminpanel==1) $page='change_admin_password';
	}
}
unset($pagequery,$pagequeried);
$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$page' and `status`='ena' LIMIT 0,1;"));
$pagequeried=1;
/* Эти дела ниже надо разгрести 
if ($page=="change_password_page" and !$pagequery){
	insert_module("change_password");
}
if ($page=="change_password_page"){
	// Получаем данные страницы, которую запрашивали. Для меню, например
	$pageshtrihquery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$pageshtrih' LIMIT 0,1;"));
}*/
//echo $page;
if($page){$log->LogDebug('Page is '.$page);} else $log->LogDebug('Page is undefined now');
?>