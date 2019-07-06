<? 
/*****************************************************************************************************************
* Snippet Name : adminpanel																						 * 
* Scripted By  : RomanyukAlex		           																	 * 
* Website      : http://popwebstudio.ru	   																		 * 
* Email        : admin@popwebstudio.ru    			 														     * 
* License      : License on popwebstudio.ru from autor 															 *
* Purpose 	   : Администраторская панель сайта					 												 *
* Insert	   : include_once('adminpanel.php');																 *
******************************************************************************************************************/ 
$adminpanel=1;
@include($_SERVER['DOCUMENT_ROOT']."/core/start_platform_scripts.php");
?><!DOCTYPE HTML><html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="image/x-icon" rel="shortcut icon" href='/project/freecon/files/freecon-favicon.png'/>
<link rel="stylesheet" type="text/css" media="all" href="/style/style.php?adminpanel=1" />

<?
//@include($_SERVER['DOCUMENT_ROOT']."/core/platform_header.php");// Стандартные js и css + meta теги
if(!$ip) {
	global $ip;
	if(!$ip) include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");
}
# Разрешено ли этому IP смотреть админку?
if($adminpanelcorrectipaddress!=="NO"){$valid_ip_address=$adminpanelcorrectipaddress;include($_SERVER['DOCUMENT_ROOT']."/core/IPfilter.php");}
if (!$block) {// Выдаем страницу только если это не запрещено в предыдущих скриптах
	$adminsitetemplate='easy_admin_panel'; // ввести как параметр в табл templates и в siteconfig ввести default 
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/scripts_and_styles.php')){
		$log->LogDebug('Trying to call /adminpanel/templates/'.$adminsitetemplate.'/scripts_and_styles.php');
		include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/scripts_and_styles.php');// Скрипты и стили проекта
	} else $log->LogInfo('/adminpanel/templates/'.$adminsitetemplate.'/scripts_and_styles.php is not exists');
			
	include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/adminpanel-checkuserrole.php'); // Определяем userrole
	
	if ($userrole!=='guest'){?><script src="/adminpanel/js/users_management.js" type="text/javascript"></script><?}
	/*if ($userrole=='guest'){?>
		<!-- Колорпикер -->
		<script type="text/javascript" src="/adminpanel/js/ColorPicker2/farbtastic.js"></script>
		<link rel="stylesheet" href="/adminpanel/js/ColorPicker2/farbtastic.css" type="text/css"/>
	<?}?>
	
	<!-- Визивиг -->
	<script type="text/javascript" src="/modules/wysiwyg-tinyMCE/tinymce/tinymce.min.js"></script>*/?>
	<script type="text/javascript" src="/js/platformscripts.js"></script>
	<script type="text/javascript" src="/adminpanel/js/adminscripts.js"></script>
	</head>
	<body class="sticky-header" style="background: #FFF;"  onload="initMap()" >
	<? 
	if ($userrole=='admin' or $userrole=='root'){// Пользователь найден
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/body.php')){
			$log->LogDebug('Trying to call /adminpanel/templates/'.$adminsitetemplate.'/body.php');
			include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/templates/'.$adminsitetemplate.'/body.php');
		} else $log->LogError('Body was not found for this template ('.$adminsitetemplate.')');
	
	}
	else{// Страница AdminPanel не доступна пользователю с данным ЛогинПаролем
		/*?><!-- Плавающие лейблы -->
		<link rel="stylesheet" href="/adminpanel/js/labels/labels.css" />
		<script type="text/javascript" src="/adminpanel/js/labels/jsapi.js"></script>
		<script type="text/javascript">google.load("jquery", "1");</script>
		<script type="text/javascript" src="/adminpanel/js/labels/slidingl.js"></script>
		<? */
		//<-- Логин юзера -->?>
		
		<? include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-login-form.php");?>
		
<?	}
}//block
else {?></head><body><img src="/adminpanel/pics/stop.png" border="0"><br>Эта страница Вам не доступна (2)<?
}
require($_SERVER['DOCUMENT_ROOT']."/core/platform_jscss.php");// Стандартные js и css платформы?>
<!--script type="text/javascript" src="/js/platformscripts.php?adminpanel=1&"></script-->
</body></html>
<? $log->LogDebug('MemUsage (after all) '.(memory_get_usage()-$base_memory_usage).'. Memory peak was '.memory_get_peak_usage().'.');
$log->LogInfo('EndOfPage -------------------');?>