<? /******************************************************************
  * Snippet Name : body           				 					 * 
  * Scripted By  : RomanyukAlex		           						 * 
  * Website      : http://popwebstudio.ru	   						 * 
  * Email        : admin@popwebstudio.ru     					     * 
  * License      : License on popwebstudio.ru	from autor		 	 *
  * Purpose 	 : Тело страницы обрамленное тегами <body></body>	 *
  * Insert		 : include_once('/templates/$currenttemplate/body.php');						 *
  *******************************************************************/ 

###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo("Got ".(__FILE__));
 
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################

?>

<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
insert_module("counter-mail","show_counter");

include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // еСЛИ ЧТО	можно перенести в before_http

insert_function("isDeviceMobile");
if(isDeviceMobile()){$isDeviceMobile=1;}

?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NV7Z6B8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!--    --> 
<!--script type="text/javascript" src="/adminpanel/js/highslide/highslide-full.js"></script>
<link rel="stylesheet" type="text/css" href="/adminpanel/js/highslide/highslide.css" /-->
<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>

<script type="text/javascript">
    // override Highslide settings here
    // instead of editing the highslide.js file
    hs.graphicsDir = '/adminpanel/js/highslide/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.dimmingOpacity = 0.75;
hs.creditsText=' ';

// Add the controlbar
hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: false,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});

$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip({
		animated: 'fade',
		placement: 'bottom',
		html: true
	});
});


<? /* Соберем аудиторию отказников (первый вход, менее 15 секунд на страничке */
if($_SESSION['first_entry']==1){?>
$( window ).unload(function() {
  var tSecs = Math.round(initStopwatch());
  if (tSecs<15) {
	(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-203637-3PkXd'; // Аудитория Отказники в ВК
	fbq('track', 'Otkazniki');//Аудитория отказников FB
  }
});

//Счетчик секунд на страничке
startdate = new Date();
clockStart = startdate.getTime();
function initStopwatch() {
  var thisTime = new Date(); 
  return (thisTime.getTime() - clockStart)/1000; 
}
function getSecs() {
  var tSecs = Math.round(initStopwatch());
  setTimeout('getSecs()', 1000); 
}
//Запускаем счётчик секунд с начала входа
$(window).on('load',function(){
        getSecs();
    });
<? }?>
<? include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/fb_pixel.php');?>

function yandex_target(event_code){ //Дергает цель яндекс метрики
	yaCounter30423247.reachGoal(event_code);
	//alert(event_code);//Проверяем, что функция фунциклирует
	//console.log(event_code);
}
</script>

<div  class="navbar navbar-fixed-top" role="navigation" id="top_navbar">

<div  class="row flex-items-sm-between" style="<?
		/*if($page=="test"){?>background:#000;<?}
		else{?>background:#FFF;<? }*/?>
		background:#FFF;
	margin-top:0px">
	
	<div class="col-md-2 col-xs-2">
		
		<a href="/" class="header-entry-top-logo-link hidden-sm-down" title="Клуб Здорового Сознания. Речевые практики для жизни">
			<img class="header-entry-top-logo imgmiddle" src="<?=$logofile?>" alt="<?=$logoalt?>">		
		</a>
	
		<a href="/" class="header-entry-top-logo-link hidden-md-up" title="Клуб Здорового Сознания. Речевые практики для жизни">
			<img class="header-entry-top-logo imgmiddle" src="/project/<?=$projectname?>/files/soznanie.club.logo.mob.png" alt="<?=$logoalt?>" height="100px"style="display: inline-block;">		
		</a>
	</div>


	<div class="col-md-6 col-xs-6 header-entry-top-logo-block flex-items-xs-center">

		<div id="portal_title_div" class="proxima-nova-bold "><span id="portal_title_main">Клуб Здорового Сознания&#153;</span><br>
			<span id="portal_title_sub" class="hidden-xs-down"><?
			$st_fileName=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/soznanie_sub_titles.txt';
			$sub_title_arr=file($st_fileName);
			
			insert_function("getSeason");
			$season=getSeason();
			if($season=="autumn"){
				array_push($sub_title_arr,"Пройдём осень вместе");
			} elseif($season=="spring"){
				array_push($sub_title_arr,"Весне дорогу");
			}
			echo $sub_title_arr[array_rand($sub_title_arr, 1)];
			?></span>
		</div>

	</div>
	<?/*
	<div class="col-md-2">
		
		
		<a class="header__phone fancybox-popup_callback" 
				style="color: #231f20; font-family: ProximaNova Bold;font-size: 13px;font-style: normal;font-weight: normal;text-transform: uppercase; margin-right:20px"
				id="callbackA" href="tel:<?=$contactphone?>"><span class="span"></span><?=$contactphone?></a>
		
		<? insert_function("email_encode");
		echo email_encode("$officialemail","$officialemail", 'class="header__phone fancybox-popup_callback justlink"' );?>
		<!--a class="login fancybox-popup_login highslide" href="/#popup_auth" onclick="return hs.htmlExpand(this, { contentId: 'popup_auth' } )">Войти</a-->
		
		
		<br><? insert_module("search_engine");// Здесь модуль поиска должен отображать дизайн?>
	</div>*/?>
	<div class="col-md-2 col-xs-2">
	
	<div class="fa-2x" style="float: left;">
	<? 
	
		#ДЕНЬ В ИСТОРИИ
		
		$day_event_q=mysql_query("SELECT * FROM `$tableprefix-pedia-artcl` WHERE `code_ru` LIKE '%".date('d').".".date('m')."%';");
		//$day_event_q=mysql_query("SELECT * FROM `$tableprefix-pedia-artcl` WHERE `code_ru` LIKE '%17.11.%';");
		
		if(mysql_num_rows($day_event_q)>0){#Есть события за сегодня
			$day_event_exist=1;
		}

		if($day_event_exist==1){
			#Получаем текст event из файла
			insert_function("file_searchFileByName");
			$folderName=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/termins/';
			
			while($day_event=mysql_fetch_array($day_event_q)){
				$file_names=search_file_byMask($folderName, $day_event['code_en']);
				
				foreach($file_names as $eventfileName){
					$fh = fopen($folderName.$eventfileName, 'r');
					if(!empty($fh) and $fh!=='' and $fh!==NULL){
						$event_text[$day_event['code_en']] = trim(fgets($fh));
					}
				}
			}
		?>
		
			<a title="Этот день в истории" href="" data-toggle="modal" data-target="#historyDay_modal">
				<span class="fa-layers fa-fw">
					<i class="fas fa-calendar" style="color:grey"></i>
					<span class="fa-layers-text fa-inverse" data-fa-transform="shrink-8 down-3" style="font-weight:900;"><?=date("d");?></span>
					<span class="fa-layers-counter" style="background:Tomato"><?=count($event_text)?></span>
				</span>
			</a>
		<? }
			#Добавление в избранное
		if(!$isDeviceMobile){
		?>
		  
		  <span id="AddFavViaSheens" style="cursor:pointer" class="fa-layers fa-fw"><i class="fas fa-bookmark" style="color:grey"></i><i class="fa-inverse fas fa-heart" data-fa-transform="shrink-10 up-2" style="color:Tomato"></i></span>
		  <script>
				
				// Функция для добавления в закладки избранного | https://sheensay.ru?p=710
				document.getElementById( 'AddFavViaSheens' ).onclick = function () {
					var title = document.title,
							url = document.location,
							UA = navigator.userAgent.toLowerCase(),
							isFF = UA.indexOf('firefox') != -1,
							isMac = UA.indexOf('mac') != -1,
							isWebkit = UA.indexOf('webkit') != -1,
							isIE = UA.indexOf('.net') != -1;
			 
			 
					if ((isIE || isFF) && window.external) { // IE, Firefox
						window.external.AddFavorite(url, title);
						return false;
					}
			 
			 
					if (isMac || isWebkit) { // Webkit (Chrome, Opera), Mac
						document.getElementById('AddFavViaSheens').innerHTML = '<span id="AddFavPhrase" style="font-size:10px">Нажмите "' + (isMac ? 'Command/Cmd' : 'Ctrl') + ' + D"</span>';
						return false;
					}
				}
			</script>
		<? }?>
		<a href="/modules/rss/" target="_blank" class="hidden-xs-down"><i class="fas fa-rss-square"style="color:grey"></i></a>
	<!--/div--><?
	 if($page=="swpshop" and $_GET['action']!=="show_shoppingcart"){?>
	 <!--div id="shoppingcart_count" style="float: left;"-->
		<a href="/?page=swpshop&action=show_shoppingcart"><!--img src="/files/shoppingcart_grey.png" class="imgmiddle" height="40px"-->
			
			<span class="fa-layers fa-fw">
				<i class="fas fa-shopping-cart" style="color:grey"></i>
				<span id="order_count_items" class="fa-layers-counter" style="font-weight:900;" style="background:Tomato"><?if($_SESSION['order_count_items']) echo $_SESSION['order_count_items']; else echo "0";?></span>
			</span>
			
			<?/*на сумму <span id="order_count_summ"><?if($_SESSION['order_count_summ']) echo $_SESSION['order_count_summ']; else echo "0";?></span> руб.*/?>
		</a>
		
		<?}?>
		</div>
	</div>
	<div class="col-md-2 col-xs-2 topmenu_block dropdown">

	
		
	
		<a href="/?page=auth" id="user_menu_link"  data-toggle="dropdown">
		
			<? if($userrole and $userrole!=="guest"){?><span title="<?=$userid?>"><?=$fullname;?></span><?}
			elseif($_COOKIE["registered"]=="1"){?><span title="<?=$_COOKIE["fullname"]?>"><?=$_COOKIE["fullname"];?></span><?}?>
		
		<?
		if($userrole and $userrole!=="guest" and $user_avatar){?><img src="<?=$user_avatar?>" style="border-radius: 30px;" width="50px"><?}
		else {?><i style="color:grey" class="far fa-2x fa-user-circle imgmiddle"></i><?}?>
		</a>
		
		<ul class="dropdown-menu">
			
			<? if($userrole=="guest" and $userrole){?><li class="dropdown-item"><i class="fas fa-sign-in-alt"></i> <a href="" id="entrance_link" data-toggle="modal" data-target="#auth_modal">Войти на сайт
			</a></li><?}?>
			<li class="dropdown-item"><i class="fas fa-mail-bulk"></i> <a href="/?page=contacts">Связаться с нами</a></li>
			<?  if($userrole and $userrole!=="guest"){?>
			<li class="dropdown-item"><i class="fas fa-person-booth"></i> <a href="/?page=cabinet" style="cursor:pointer">Личный кабинет</a></li>
			<li class="dropdown-item"><i class="fas fa-envelope"></i> <a href="/?page=subscrip_management" style="cursor:pointer">Управление рассылками</a></li>
			<li class="dropdown-item"><i class="fas fa-sign-out-alt"></i> <a href="/logout" style="cursor:pointer" onclick="logout('messageplace');">Выйти</a></li><? }?>
		</ul>
			
		  
	</div>

</div>
<!-- Верхнее меню-->


<? 
#Подготовим каунтер для верхнего меню--
if($page=="book"){ //Смотрят книгу
	$books_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as COUNT FROM `$tableprefix-torrents` WHERE `status`='active';"));
	//echo $books_count['COUNT'].' '.StringPlural::Plural($books_count['COUNT'], array('книга', 'книги', 'книг'));
} elseif($page=="audio"){
	$audio_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as COUNT FROM `$tableprefix-torrents-abooks` WHERE `status`='active';")); //$audio_count['COUNT']
} elseif($page=="video"){
	$video_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as COUNT FROM `$tableprefix-videos` WHERE `vstatus`='active';"));
	//echo $video_count['COUNT'].' '.StringPlural::Plural($video_count['COUNT'], array('ролик', 'ролика', 'роликов'));
}
?>
<!--div class="navbar navbar-fixed-top" role="navigation" id="top_menu_line"-->
<div class="row" id="top_menu_line">
  <div class="col-md-1 col-xs-6 topmenu_block menu_red dropdown"><a href="/?page=shop"  data-toggle="dropdown" title="Правила Клуба, контакты">Клуб</a>
	  
	<ul class="dropdown-menu">
	<li class="dropdown-item"><i class="fas fa-torah"></i> <a href="/?page=club_concept_n_rules">Правила Клуба</a></li>
	<li class="dropdown-item"><i class="fas fa-graduation-cap"></i> <a href="/?page=invitation">Вход в обучающую часть</a></li>
	<li class="dropdown-item"><i class="fas fa-mail-bulk"></i> <a href="/?page=contacts">Контакты</a></li>
	</ul>
	
  
  </div>
  <!--div class="col-md-2 col-xs-6 topmenu_block menu_orange"><a href="/?page=psy_jokes" title="Шутки и анекдоты о психологах, психологии и психах">ПсихоШутки</a></div-->
  <div class="col-md-2 col-xs-6 topmenu_block menu_orange"><a href="/?page=audios" title="Аудиозаписи тренингов и аудиокниги">Аудио Ψ<? if($page=="audio"){ ?><span id="itemCount_topMenu"><?=$audio_count['COUNT']?></span><? }?></a></div>
  <div class="col-md-2 col-xs-6 topmenu_block menu_yell"><a href="/?page=CTATbu" title="Хроники интернета. Всё что пишут о психологии человека">Ψ статьи</a></div>
  <div class="col-md-1 col-xs-6 topmenu_block menu_green"><a href="/?page=swpshop" title="Инфопродукты, записи тренингов">Учись</a></div>
  <div class="col-md-2 col-xs-6 topmenu_block menu_light_blue">
 
	<a href="/?page=psybooks" title="Книги по психологии и эзотерике">Книги Ψ
	<? if($page=="book"){ ?><span id="itemCount_topMenu"><?=$books_count['COUNT']?></span><? }?>
  </a>
	<? /*<ul class="dropdown-menu hidden-xs-down">
		<?  insert_module("menu",'psybooks_topmenu',"no","yes");?>
	
	
		<!--li><a href="/?page=clublanding">Клуб НЛП-практиков</a></li>
		<li><a href="/?page=jenskiy_trening">Женский тренинг</a></li>
		<li><a href="/?page=schedule">Расписание мероприятий</a></li-->
	</ul>*/?>
  </div>
  <div class="col-md-2 col-xs-6 topmenu_block menu_blue">
  
	<a href=""  class="hidden-md-down" data-toggle="dropdown" title="Психологи, тренинговые центры, помощь по телефону">Психологи и ТЦ</a>
	
	<a href="" class="hidden-lg-up" data-toggle="dropdown" title="Психологи, тренинговые центры, помощь по телефону">Психологи</a>

		<ul class="dropdown-menu">
			<li class="dropdown-item"><i class="fas fa-hands-helping"></i> <a href="/?page=who_is_who&search_cat=trainers">Психологи и тренеры</a></li>
			<li class="dropdown-item"><i class="fas fa-building"></i> 
			  <a href="/?page=who_is_who&search_cat=trainingcenters">Тренинговые центры</a></li>
			<li class="dropdown-item"><i class="fas fa-phone"></i>  <a href="/?page=phone_help">Помощь по телефону</a></li>
		</ul>
	</div>
	 <div class="col-md-2 hidden-xs  topmenu_block menu_purple<? // active_menu?>"><a title="Видео по психологии и эзотерике" href="/?page=videos">Видео Ψ<? if($page=="video"){ ?><span id="itemCount_topMenu"><?=$video_count['COUNT']?></span><? }?></a></div>
	
</div>
<!-- // Верхнее меню-->
</div>
<!-- // Верхний блок -->

<!--div class="row">
<div id="messageplace" class="col-md-12"></div>
</div-->

<? $tb_bggr_pagearr=array(
	
	'club_concept_n_rules'=>'bcgr_red',
	'invitation'=>'bcgr_red',
	'training_shop'=>'bcgr_orange',
	'CTATbu'=>'bcgr_yell',
	'swpshop'=>'bcgr_green',
	'videos'=>'bcgr_purple',
	'video'=>'bcgr_purple',
	'who_is_who'=>'bcgr_blue',
	'contacts'=>'bcgr_red',
	'movietalk'=>'bcgr_yell',
	'psy_jokes'=>'bcgr_orange',
	'audios'=>'bcgr_orange',
	'audio'=>'bcgr_orange'
);
$tb_bggr_scrarr=array(
	'bookpage.php'=>'bcgr_light_blue',
	'books.php'=>'bcgr_light_blue',
	'book_downld.php'=>'bcgr_light_blue'
);

#Микроразметим
?>
<div itemscope itemtype="http://schema.org/<?
	if($page=="CTATbu") {?>LiveBlogPosting<?}
	else {?>Article<?}?>">

<div class="heading pagetitle <? 
	if($tb_bggr_pagearr[$page]) echo $tb_bggr_pagearr[$page]; 
	elseif($tb_bggr_scrarr[$pagequery['filename']]){//Есть фон для страниц по скрипту
		echo $tb_bggr_scrarr[$pagequery['filename']];
	}
	else echo '	bcgr_blue';?>">
	<div id="clear_div" style="margin-top:60px"></div>
	<div class="hidden-xs-up" id="clear_div2" style="margin-top:120px"></div>
	<div class="hidden-md-up" id="clear_div3" style="margin-top:120px"></div>
	<div class="hidden-md-up" id="clear_div5" style="margin-top:160px;"></div>
	<h1 class="round_center" id="titleonpage" style="font-size: 26px;" itemprop="headline"><?
	
	if($pagequery['filename']=='bookpage.php' or $pagequery['filename']=='book_downld.php' or $pagequery['filename']=='audiopage.php' or $pagequery['filename']=='audio_downld.php') {
		# На страничке с книжками H1 берется из таблички torrents, поэтому надо получить все данные книги, прежде чем формировать всю страницу
		if($pagequery['filename']=='bookpage.php' or $pagequery['filename']=='audiopage.php') $book_id=process_data($_REQUEST['topic_id'],8);
		elseif($pagequery['filename']=='book_downld.php' or $pagequery['filename']=='audio_downld.php') $book_id=$_SESSION[$_REQUEST['book_link']];
	
		if($pagequery['filename']=='bookpage.php' or $pagequery['filename']=='book_downld.php') 
		$book_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `topic_id`='".$book_id."' AND (`status`='active' or `status`='need_confirm')  LIMIT 0,1;"));
		elseif($pagequery['filename']=='audiopage.php' or $pagequery['filename']=='audio_downld.php') $book_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-torrents-abooks` WHERE `topic_id`='".$book_id."' AND (`status`='active' or `status`='need_confirm')  LIMIT 0,1;"));
		mb_internal_encoding("UTF-8");
	
		insert_function("parse_torrent_name");
		$book_info_p=parse_torrent_name($book_info['name']);
		$bookauthor=$book_info_p['author'];
		$bookname=$book_info_p['title'];
		$book_attr=$book_info_p['tor_attr'];
		$torrent_name=$book_info_p['torrent_name'];
		if($bookauthor) {
			$page_title=$bookauthor.' - '.$bookname.'['.$book_attr.']';
		}
		else $page_title=$torrent_name;
		
	}
	
	else $page_title=$pagequery['pagetitle_'.$language];//echo $pagequery['pagetitle_'.$language];
	#Выводим page title
	echo $page_title;
	?>
	
	</h1>
</div>

<? //}

#Вставляем класс для баннеров

insert_function("banners");
$banner = new swpbanner(); 

if($botname or $_SERVER['HTTP_HOST']=="test.soznanie.club") $banner->dont_count_view();
$banner->add_page($page);//Добавляем страничку на которой мы сейчас

if(!$ip) include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");
$cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);
//$banner->add_city($cityName);
$banner->filter(3);//Подготовь вот столько баннеров по всем параметрам
?>

<div class="row" style="padding-top:20px; 
<? if($page=="test"){?>background:grey;<?}
	else{?>background:#FFF;
	<? }?>
">
<!-- ЛЕВОЕ МЕНЮ -->
<? if(!$pagequery['page_menu']){$pagequery['page_menu']="main_menu";}?>
<aside class="col-md-2 hidden-md-down">
	<ul class="list-group submenu">
	<? insert_module("menu",$pagequery['page_menu'],"no","yes");?>
	</ul>
	<? if($page!=="test"){?>
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?152"></script>

<!-- VK Widget -->
<div id="vk_groups" style="padding:20px 20px 20px 0px;" class="hidden-lg-down"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 3, no_cover: 1, color3: '0AA4BB'}, 95462752);
</script>
	<? }?>
<? if($page!=="invitation" and !$isDeviceMobile){
	#плеер со звуками на сайте
	insert_function("dir_to_array");
	$sounds_dir=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/sounds/';
	$site_music_arr=dir_to_array($sounds_dir);

	insert_module("music_IWishQuery","/project/$projectname/files/sounds/".substr($site_music_arr[mt_rand(0, count($site_music_arr) - 1)],0,-4),"autoplay loop controls","0.01");
?><!--a href="#" onclick="">Отключить музыку</a--><?
}?>

</aside>

<!-- // ЛЕВОЕ МЕНЮ -->




<!-- ТЕЛО СТРАНИЦЫ-->

	<div class="col-md-8" itemprop="articleBody" id="articleBody">
	
		<? if($_REQUEST['page']=='book_dnld' AND (!$_REQUEST['book_link'] OR !$_SESSION[$_REQUEST['book_link']])){$page="404";}// Странно, но не работает
		include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); 
		
		if($pagequery['module_page']=="swpshop" and $_GET['action']=="show_product"){
			?><script>$("h1").html("<?=$productinfo['product_full_title_'.$language]; ?>");
			$(document).ready(function(){
				$("h1").html("<?=$productinfo['product_full_title_'.$language]; ?>");
			});
			</script><?
		}

		
		# Впервые на сайте, показываем приветственный баннер
		if($_SESSION['first_entry']==1 and !$isDeviceMobile and $page!=="main" and $page!=="register") {?>
			<h4 class="modal-title" id="myModalLabel">Мы думаем, что Вы впервые на портале Клуба</h4><br>
			<b>Что интересного на портале?</b>
			<script src="//cdn.wordart.com/wordart.min.js" async defer></script>
			<div style="width:70%" data-wordart-src="//wordart.com/cdn/json/ck1b0yoz7rs6"  data-wordart-show-attribution></div><br>
	<? 	unset($_SESSION['first_entry']);
		}?>

	</div><? 
	
	$page_kws=preg_replace('/[^\w\s]/u', ' ', $pagequery['pagetitle_ru']); //Удаляем знаки препинания (не работает) из названия для ключевых слов
	$page_kws=str_replace(" ",";",$pagequery['pagetitle_ru']);
	$banner->add_kw($page_kws);
	$banner->filter(3);//Подготовь вот столько баннеров по всем параметрам
	?>
	<div class="col-md-1"  style="padding:0 10px 0 10px">
		<div class="fixed" style="margin-right:15px">
							<? 
	# Модерация прямо на странице
	if($userrole and ($userrole=="admin" or $userrole=="root")){
		
		?>
		<script>
		function moderate(id,action,reaction){
				$("#moderate_ap").load('/core/ajaxapi.php?',{
					action:action,id:id,reaction:reaction,mod:"project_script"});
		}
		</script>
		<div id="moderate_ap"></div>
		<? if($pagequery['canbechanged']=="yes"){ #Можно модерировать страницу, выведем кнопки для админа?>
		<a class="button large red" onclick="moderate('<?=$pagequery['page_id']?>','moderate_page','delete');return false;">Удалить страницу</a><br>
		<a class="button large yellow" onclick="moderate('<?=$pagequery['page_id']?>','moderate_page','clear_page_data');return false;">Стереть данные страницы</a><br>
		<a class="button large green" onclick="moderate('<?=$pagequery['page_id']?>','moderate_page','apply');return false;">Активировать страницу</a><br>
		<a class="button large blue" onclick="moderate('<?=$pagequery['page_id']?>','moderate_page','deactivate');return false;">Деактивировать страницу</a><br><br>
<?		}
	if($pagequery['cache_time']>0){#Есть кеш страницы. Выведем кнопку для его стирания?>
		<a class="button large blue" onclick="moderate('<?=$pagequery['page_id']?>','moderate_page','clear_cache');return false;">Стереть кеш страницы</a><br><br>
	<?	}
	}
	?>
					<!-- РЕКЛАМА-->
					<script>
						function save_click (banner_id) {
							ajaxreq(banner_id,'','save_banner_click','empty_ap','project_script')
						  };
						
					</script>
					<div  id="empty_ap"></div>
					<?
					if(!$bot_name and $banner->get_banner(1,"banner_id")){
					#Нижний баннер
					?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff;margin:0 0 15px 0">
					<a target="_blank" class="justlink" onclick="
						save_click('<?=$banner->get_banner(1,"banner_id")?>');
						yandex_target('banner_clicked_1');
					" href="<?=$banner->get_banner(1,"link")?>"<? if($banner->get_banner(1,'a_title')){?>title="<?=$banner->get_banner(1,'a_title')?>"<?}?>>
					<b style="font-size:14px"><?=$banner->get_banner(1,'text_1')?></b><br>
					<img src="<?=$banner->get_banner(1,'img')?>" style="width: 100%;padding 5px;">
					<span style="font-size:12px"><?=$banner->get_banner(1,'text_2')?></span>
					</a>
					</div>
					<? }
					if(!$bot_name and $banner->get_banner(2,"banner_id")){
					?>
					<div class="vp_block col-md-10" style="padding:0px;background-color:#fff">
					<a target="_blank" class="justlink a_banner" onclick="
						save_click('<?=$banner->get_banner(2,"banner_id")?>');
						yandex_target('banner_clicked_2');
					" href="<?=$banner->get_banner(2,"link")?>"<? if($banner->get_banner(2,'a_title')){?>title="<?=$banner->get_banner(2,'a_title')?>"<?}?>>
					<b style="font-size:14px"><?=$banner->get_banner(2,'text_1')?></b><br>
					<img src="<?=$banner->get_banner(2,'img')?>" style="width: 100%;padding 5px;">
					<span style="font-size:12px"><?=$banner->get_banner(2,'text_2')?></span>
					</a>
					</div>
					<? }?>
					
							</div>
	</div>
<!-- // ТЕЛО СТРАНИЦЫ -->

</div>



<? /*
<div class="row flex-items-md-center commentaries">
<!-- Yandex.RTB R-A-279803-3 -->
<div class="col-md-6 col-xs-6" id="yandex_rtb_R-A-279803-3"></div>
<script type="text/javascript">
    (function(w, d, n, s, t) {
        w[n] = w[n] || [];
        w[n].push(function() {
            Ya.Context.AdvManager.render({
                blockId: "R-A-279803-3",
                renderTo: "yandex_rtb_R-A-279803-3",
                async: true
            });
        });
        t = d.getElementsByTagName("script")[0];
        s = d.createElement("script");
        s.type = "text/javascript";
        s.src = "//an.yandex.ru/system/context.js";
        s.async = true;
        t.parentNode.insertBefore(s, t);
    })(this, this.document, "yandexContextAsyncCallbacks");
</script>
</div>*/?>
</div> <?//itemscope ///?>
<!-- Footer -->
<div class="row footer_div1 flex-items-md-center">

	<div class="col-md-7 col-xs-12">
		<div class="row" style="border-bottom: 1px solid #d7d7d7;border-top: 1px solid #d7d7d7;">
		<!-- VK -->
		<div class="col-md-2 col-xs-2">
			<a href="//vk.com/<?=$vk_group_nickname?>" target="_blank" class="hidden-sm-up" >
				<img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_vk.png">
			</a>
			<a href="//vk.com/<?=$vk_group_nickname?>" target="_blank"class="hidden-sm-down">Группа ВКонтакте</a>
		</div>
		<!-- YT -->
		<div class="col-md-2 col-xs-2">
			<a href="//www.youtube.com/channel/UC39CsvZdtkVNAsCKAW4lLYw?sub_confirmation=1" target="_blank"class="hidden-sm-up">
				<img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_yt.png">
			</a>
			<a href="//www.youtube.com/channel/UC39CsvZdtkVNAsCKAW4lLYw?sub_confirmation=1" target="_blank" class="hidden-sm-down">Канал YouTube</a>
		</div>
		<!-- FB -->
		<div class="col-md-2 col-xs-2">
			<a href="//fb.me/soznanie.club" target="_blank"class="hidden-sm-up"><img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_fb.png"></a>
			<a href="//fb.me/soznanie.club" target="_blank"class="hidden-sm-down">Сообщество Facebook</a>
		</div>  
		<?/*  <div class="col-md-2 col-xs-6">
			<a href="//my.mail.ru/community/psyspace/" target="_blank">Группа МойМир</a>
		  </div>
		  */?>
		<!-- TW -->
		<div class="col-md-2 col-xs-2">
			<a href="https://twitter.com/soznanie_club" target="_blank" class="hidden-sm-up">
				<img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_tw.png">
			</a>
			<a href="https://twitter.com/soznanie_club" target="_blank" class="hidden-sm-down">Twitter Клуба</a>
		</div>
		<!-- Insta -->
		<div class="col-md-2 col-xs-2">
			<a href="https://www.instagram.com/soznanie_club/" target="_blank" class="hidden-sm-up">
				<img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_ig.png">
			</a>
			<a href="https://www.instagram.com/soznanie_club/" target="_blank" class="hidden-sm-down">Наш insta</a>
		</div>
		<!-- TG -->
		<div class="col-md-2 col-xs-2">
			<a href="https://t.me/joinchat/AAAAAEJbwRULTYWIv4kZiw" target="_blank"class="hidden-sm-up"><img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_tg.png"></a>
			<a href="https://t.me/soznanie_club" target="_blank"class="hidden-sm-down">Канал на Телеграме</a>
		</div>
		<!--div class="col-md-2 col-xs-2">
			<a href="https://plus.google.com/communities/105958663702552164677" target="_blank"class="hidden-sm-up">
				<img width="30px"src="/project/<?=$projectname?>/files/soznanieclub_gp.png">
			</a>
			<a href="https://plus.google.com/communities/105958663702552164677" target="_blank"class="hidden-sm-down">Группа Google+</a>
		</div-->
		  
		</div>
	</div>
</div>
<div  class="row footer_div2 flex-items-md-center">
  
  
  <div class="col-md-2 col-xs-6">
	Портал «Клуб Здорового Сознания»<br>
	<i class="fas fa-heartbeat"></i><?insert_module("years");?><br>
	
	<br><br>
	<i class="fas fa-map"></i> <a class="footer_inn-link" href="/?page=Becb_cauT">Карта сайта</a>
  </div>
  <div class="col-md-4  col-xs-6">
	
		<i class="fas fa-mobile-alt"></i> <a href="tel:<?=$contactphone?>" class="header__phone fancybox-popup_callback justlink"><?=$contactphone?></a><br>
		<i class="fab fa-skype"></i> Skype: <a href="skype:romanyukalex?chat" class="header__phone fancybox-popup_callback justlink">romanyukalex</a><br>
	<i class="fas fa-at"></i> Email: 
	<?	insert_function("email_encode");
	echo email_encode("$officialemail","$officialemail", 'class="header__phone fancybox-popup_callback justlink"' );
	?><br>
		<i class="fas fa-mail-bulk"></i> <a href="/?page=contacts" class="justlink">Связаться с нами</a>
	
  </div>
</div>

<!-- // Footer -->

 
<div class="modal fade" id="auth_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Войти на сайт с помощью социальных сетей</h4></span>
      </div>
      <div class="modal-body">
	  <? insert_module("auth_social","show_auth_links");?>
	  <br>
	  Заходя на портал под учётной записью социальной сети, Вы соглашаетесь на обработку персональных данных, а также подтверждаете своё совершеннолетие
      </div>
    </div>
  </div>
</div>


<? if($day_event_exist==1){?>

<!--Модальное окно для ДЕНЬ В ИСТОРИИ -->
<div class="modal fade" id="historyDay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">В истории этот день был отмечен следующими событиями</h4></span>
      </div>
      <div class="modal-body">
	  <? 
		foreach($event_text as $event_date=>$event_whatHap){
			?><b><?=$event_date?></b> (<i class="fas fa-history" style="color:grey"></i><?
				//Сколько это лет назад
				$event_yrsAgo=date("Y")-substr($event_date,-4,4);
				echo $event_yrsAgo.' '.StringPlural::Plural($event_yrsAgo, array('год', 'года', 'лет'))
			?> назад) <i><?=$event_whatHap?></i><br><br>
<?		}?>
	  </div>
    </div>
  </div>
</div>
<? }

if( $_SESSION['return_entry']==1 and $page!=="register" and !$_COOKIE["registered"]){ # Возвращенец, предлагаем залогиниться и вступить в клуб

	unset($_SESSION['return_entry']); //Убираем флаг, чтобы в before_http скрипте он заново сравнивался и видел, что на сегодня уже показали баннер

?>
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#please_register_modal').modal('show');
    });
</script>
<div class="modal fade" id="please_register_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Здравствуйте! Мы не виделись <?
			
			$datetime1 = date_create($_COOKIE["prev_visit_date"]);
			$datetime2 = date_create($this_visit_date);
			$pv_interval = date_diff($datetime1, $datetime2);
			echo $pv_interval->format('%R%a');?> дней</h4></span>
      </div>
      <div class="modal-body">
	  <img src="/project/<?=$projectname?>/files/glad_to_see.jpg" style="width:100%">
			<br>
			<? if(!$_COOKIE["visit_count"]==0){?>
			Вы на сайте уже <?=$_COOKIE["visit_count"];?> раз.<?}?><br><br>
			Вы можете <!--a href="/?page=register" class="justlink"-->зарегистрироваться<!--/a--><br><br>
			
			- Добавлять свои видеоролики на портал<br>
			- Получать ежедневную рассылку с новыми материалами<br><br>
			
			<b>Менее минуты</b><br><br>
			
			
			<a class="green-button submit js-form-submit" href="/?page=register" target="_blank">
                    <span class="text">Зарегистрироваться</span>
                    <span class="loading"></span>
            </a>
			
			<a style="color:red; cursor:pointer; vertical-align: -90% " data-dismiss="modal" aria-hidden="true">Не регистрироваться в этот раз</a>
      </div>
    </div>
  </div>
</div>

<?
}

#Обработка параметра from ( источника трафика )

if($_SESSION['traffic_source']){
	//$open_yandex_event=$_SESSION['traffic_source'];
?><script>
$(window).on('load',function(){
	yandex_target("<?=$_SESSION['traffic_source']?>");
	//alert('<?=$_SESSION['traffic_source']?>');
});

</script>
<? 	//unset($_SESSION['traffic_source']); //почему то убивает предыдущий JS
}


insert_module("scroll-nicescroll","html","#4d5152");
#####################################
# // Body							#
#####################################

#####################################
# Required 2						#
#####################################
	}
	else{
		insert_module("loginform_simple");
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>