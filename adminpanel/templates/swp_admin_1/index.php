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
?><html><head><?
@include($_SERVER['DOCUMENT_ROOT']."/core/platform_header.php");// Стандартные js и css + meta теги
if(!$ip) {
	global $ip;
	if(!$ip) include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");
}
# Разрешено ли этому IP смотреть админку?
if($adminpanelcorrectipaddress!=="NO"){$valid_ip_address=$adminpanelcorrectipaddress;include($_SERVER['DOCUMENT_ROOT']."/core/IPfilter.php");}
if (!$block) {// Выдаем страницу только если это не запрещено в предыдущих скриптах
		include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-checkuserrole.php"); // Определяем userrole
	?>
	<link rel="shortcut icon" href="/favicon.ico">
	<? if ($userrole!=="guest")
		{?>
	<!-- Плавное меню -->
		<!--script src="/adminpanel/js/adminmenu/jquery-1.js" type="text/javascript"></script-->
		
		<script src="/adminpanel/js/users_management.js" type="text/javascript"></script>
	<!-- Таблица с сортировкой -->
		<link rel="stylesheet" href="/adminpanel/js/sorttable/style000.css" />
	<!-- Чекбокс в стиле iPhone -->
		<!--  <script src="/js/checkbox/jquery-1.js" type="text/javascript" charset="utf-8"></script>  Уже есть в плавном меню-->
		<script src="/adminpanel/js/checkbox/iphone-s.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="/adminpanel/js/checkbox/checkbox.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
			$(':checkbox').iphoneStyle();
			});
		</script>
	<?	}
	if ($userrole=='guest')
		{?>

	<!-- Колорпикер -->
		<script type="text/javascript" src="/adminpanel/js/ColorPicker2/farbtastic.js"></script>
		<link rel="stylesheet" href="/adminpanel/js/ColorPicker2/farbtastic.css" type="text/css"/>
	<? 	}?>
	
	<!-- Визивиг -->
	<script type="text/javascript" src="/modules/wysiwyg-tinyMCE/tinymce/tinymce.min.js"></script>
	</head>
	<body>
	<? 
	if ($userrole!=='guest' and $userrole){// Пользователь найден?>

<div id="adminblock" class="container-fluid">
	<div class="row" style="background-color:<?=$adminheadcolor?>">
			<!--div style="background-color:<?=$adminheadcolor?>" id="ap_header_tr"-->
				<div class="col-xs-8 col-lg-8 col-md-8"><a href="/adminpanel/">
					<img src='<?if(substr_count($adminlogofile,"/adminpanel/")==0) {echo "/project/".$projectname."/".$adminlogofile;}
						else echo $adminlogofile;?>' class="imgmiddle" style='margin-left:20px' height="90px"></a>
				</div>
				
				<div class="col-xs-4 col-lg-4 col-md-4">
				
				<a href='#' title="Обновить страницу"><img src='/adminpanel/pics/Clockwise-arrow256.png' class="imgmiddle" height="24px"></a>
					<!--a href='#' title="Выключить свет в админке" id="lightbutton"><img src='/adminpanel/pics/blue-time-2.png' border='0' style='vertical-align:middle;'></a-->
					<? insert_module("bookmark");?>
					<a href='#' onClick="return BookmarkApp.addBookmark(this)" title="Добавить администраторскую панель в закладки">
					<img src='/adminpanel/pics/Hearts256.png'  align='absmiddle' alt='В закладки' height="24px"></a>
					<a href='/adminpanel/?page=DokyMeHTbI' title="Документация по платформе"><img src='/adminpanel/pics/Product-documentation256.png' class="imgmiddle" height="24px"></a>
					<a title="<?=$logoutlinktext?>"onclick="logout('messageplace');return false;"><img src='/adminpanel/pics/login256.png' class="imgmiddle" height="24px"></a>
				</div>
			<!--/div-->
		
	</div>
	
	<div class="row heavy-rounded" id='ap_topmenu_tr'style="border:3px solid #D5D5D5;">
		
		<!--div class="col-xs-12 col-lg-12 col-md-12"-->
		<!--div style="border:3px solid #D5D5D5;" class="heavy-rounded"-->
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=HACTPOuKu"><img src="/adminpanel/pics/pin-green256.png"><br>Системные настройки</a></div>
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=CTPAHuUbI"><img src="/adminpanel/pics/Theme256.png"><br>Страницы</a></div>
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=KapTuHKu"><img src="/adminpanel/pics/JPG256image.png"><br>Изображения</a></div>
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=noJlb3oBaTeJlu"><img src="/adminpanel/pics/Users256.png"><br>Пользователи</a></div>
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=MoDyJlu"><img src="/adminpanel/pics/question-type-one-correct256.png"><br>Модули</a></div>
		<div class="col-xs-2 col-lg-2 col-md-2"><a href="/adminpanel/?page=CTaTuCTuKa"><img src="/adminpanel/pics/Pie-chart256.png"><br>Статистика</a></div>
		<!--/div-->
		<!--/div-->
	
	</div>
	<div class="row" id="adminpanel_ap">
		<div class="col-xs-12 col-lg-12 col-md-12">
			<div id="justforfun"></div>
			<div id="messageplace"></div>
		</div>
	</div>
	
	<div class="row" id="ap_page_block_tr">
		
		
		<? include($_SERVER['DOCUMENT_ROOT']."/core/pagemanage.php");?>
<div id="f2"></div>
	</div>
	
	<div class="navbar-fixed-bottom row" style="background-color:<?=$adminheadcolor?>;" id="ap_footer_block">
	
		<div class="col-xs-12 col-lg-12 col-md-12">
		<center><small>Powered by SWP </small><img src="/files/shoes/Shoe512_yellow.png" height="30px" class="imgmiddle"></center>
		</div>
	</div>
</div>
	
	<?
	}
	else{// Страница AdminPanel не доступна пользователю с данным ЛогинПаролем?>
		<!-- Плавающие лейблы -->
			<link rel="stylesheet" href="/adminpanel/js/labels/labels.css" />
		<script type="text/javascript" src="/adminpanel/js/labels/jsapi.js"></script>
		<script type="text/javascript">google.load("jquery", "1");</script>
		<script type="text/javascript" src="/adminpanel/js/labels/slidingl.js"></script>
		<? //<-- Логин юзера -->?><div style="margin:0px auto; background:<?=$ap_fp_bckclr?>;background: linear-gradient(to top, <?=$ap_fp_bckclr?>, #FFFFF);">
		<? include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-login-form.php");?>
		</div>
<?	}
}//block
else {?></head><body><img src="/adminpanel/pics/stop.png" border="0"><br>Эта страница Вам не доступна (2)<?
}
require($_SERVER['DOCUMENT_ROOT']."/core/platform_jscss.php");// Стандартные js и css платформы?>
</body></html>