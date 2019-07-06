<? /******************************************************************
  * Snippet Name : body           				 					 * 
  * Scripted By  : RomanyukAlex		           						 * 
  * Website      : http://popwebstudio.ru	   						 * 
  * Email        : admin@popwebstudio.ru     					     * 
  * License      : License on popwebstudio.ru	from autor		 	 *
  * Purpose 	 : Тело страницы обрамленное тегами <body></body>	 *
  * Insert		 : include_once('/templates/$currenttemplate/body.php');						 *
  *******************************************************************/ 
/* Как писать Body:
1. Открываем и закрываем </head><body></body>, между ними вся страничка.
2. В DIV, в котором надо открывать страничку, пишем include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); 
3. Если надо, чтобы ссылка показывала в нужном div#content какую то страницу, то пишем ей onClick="changerazdel('pagename');return false;" или класс (будет сделано). На странице д.б. блок <div id="content1"></div>
4. Если надо использовать какой-нибудь сторонний класс, то кидаем его в папку "/core/functions/". Название файла должно совпадать с названием класса, тогда класс сам подцепится
5. Если надо кроссбр-но вставить "Добавить в избранное" <a href="javascript:void(0)" onClick="return BookmarkApp.addBookmark(this)">bookmarkIt</a>
6. Подключить любой модуль - include($_SERVER["DOCUMENT_ROOT"]."/modules/modulename/design.php");
   Например, кнопка google+1 - include($_SERVER["DOCUMENT_ROOT"]."/modules/google_plusone/design.php");
   Или так - insert_module("modulename");
7. Если нужно выводить название страницы на странице то обозначаем место так - id="titleonpage"

Доступные переменные:
$page - страница в гет "&page="
$_SESSION['changepassmust']=="yes" - юзер должен поменять пароль
*/
###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
?>
</head><? 
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################?>
<body class="t_home mod_home public">
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>
<span id="timer"></span> 
<div id="rootcontainer">
	<!-- Верх меню -->
	<div id="toprow">
		<ul id="navrow">
		<li id="navrow_pages_about-tlc" class="navlink<? if($page=="about"){echo ' modselected';}?>">
			<a href="/?page=about" onClick="changerazdel('about');return false;" id="about_link">Об СВСБС</a></li>
		<li id="navrow_pages_teams-coaches" class="navlink<? if($page=="divisions"){echo ' modselected';}?>">
			<a href="/?page=divisions" onClick="changerazdel('divisions');return false;" id="divisions_link">В/Ч c СВСБС</a></li>
		<li id="navrow_pages_in-the-community" class="navlink<? if($page=="demo"){echo ' modselected';}?>">
			<a href="/?page=demo" onClick="changerazdel('demo');return false;" id="demo_link">Демоверсия<br />СВСБС</a></li>			
		<li id="navrow_pages_recognition" class="navlink<? if($page=="services"){echo ' modselected';}?>">
			<a href="/?page=services" onClick="changerazdel('services');return false;" id="services_link">Договора<br />Квитанции<br />Заявления</a></li>
		<li id="navrow_eventcal" class="navlink<? if($page=="news"){echo ' modselected';}?>">
			<a href="/?page=news" onClick="shownews('0');linkcolor('news'); return false;" id="news_link">Армейские<br />новости</a></li>
		<li id="navrow_blog" class="navlink<? if($page=="contacts"){echo ' modselected';}?>">
			<a href="/?page=contacts" onClick="changerazdel('contacts');return false;" id="contacts_link">Контакты</a></li>
		<li id="navrow_portfolio" class="navlink<? if($page=="communication"){echo ' modselected';}?>">
			<a href="/?page=communication" onClick="changerazdel('communication');return false;" id="communication_link">Отзывы<br>пользователей</a></li>
		<li id="navrow_home" class="navlink<? if($page=="main" or !$page){echo ' modselected';}?>">
			<a href="/" onClick="changerazdel('main');return false;" id="main_link" alt="<?=$logoalt?>">Главная</a>
		</li>	
		</ul>
	</div>
	<!-- / Верх меню -->
	<!-- Параллакс -->
	<div id="parallax">
		<div class="layer" id="sky">
			<div class="about-tlc" id="sky1"></div>
			<div class="teams-coaches" id="sky2"></div>
		</div>
	
		<div class="layer" id="grass">    	</div>
	
		<div class="layer" id="type">
		   <div class="home" id="type0">С<em>оциальный проект</em><br /><strong>СВСБС</strong></div>
		   <div class="about-tlc" id="type1">Ц<em>ели общества и</em><br /><strong>Услуги</strong></div>
		   <div class="teams-coaches" id="type2">Новости из<br /><strong>Ч<em>астей</em></strong></div>
		   <div class="in-the-community" id="type3">К<em>ак выглядит</em><br /><strong>сервис</strong></div>
		   <div class="recognition" id="type4">П<em>одать</em><br /><strong>з<em>аявку</em></strong></div>
		   <div class="eventcal" id="type5">Новости<br /> <strong>армии рф</strong></div>
		   <div class="blog" id="type6">С<em>вязаться</em><br /><strong>с нами</strong></div>
		   <div class="portfolio" id="type7">О<em>ставить отзыв или</em> <br /><strong>В<em>опрос</em></strong></div>
		</div>
	
		<div class="layer" id="players_middle">
			<div class="teams-coaches" id="player2"><a></a></div>
			<div class="portfolio" id="player7"><a></a></div>
		</div>
			
		<div class="layer" id="players_front">
			<div class="home" id="player0"><a></a></div>
			<div class="about-tlc" id="player1"><a></a></div>
			<div class="in-the-community" id="player3"><a></a></div>
			<div class="recognition" id="player4"><a></a></div>
			<div class="eventcal" id="player5"><a></a></div>
			<div class="communication" id="player8"><a></a></div>
			<div class="blog" id="player6"><a></a></div>
		</div>
	</div>
	<!--// Параллакс -->  
	<div id="root">
		<div id="content1" style="display:none"></div>
		<div id="content">
		<? include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php");
		if ($page=="main"){include($_SERVER["DOCUMENT_ROOT"]."/newsblock.php");}?>
		</div><!--close content-->
	</div><!--close 'root' block-->

	<div class="cleardiv"></div>
</div>
<!--close rootcontainer-->
<div id="pagebottom">
	<div id="page_footer">
		<!-- Quick member_pages login -->
		<div id="quickmember_pages2" class="quick m_member_pages">
<? /*			<h1><img src="/project/svsbs/templates/svsbs/files/icon_loh.png" class="imgmiddle" width="30">Вход для родителей:</h1>
			<form <? //action="/"?> method="post">
			<fieldset class="login">
				  <input type="hidden" name="login_as" value="coach" />
				  <input type="text" name="login_username" id="member_username" value="username" size="30" />
				  <input type="password" name="login_password" id="member_password" value="password" size="30" />
				  <input type="submit" name="submitted" value="Login" />
			</fieldset>
			</form> */?>
		</div><!-- /Quick member_pages login -->
		<!-- Quick military login -->
		<div id="quickmember_pages" class="quick m_member_pages">
			<h1><img src="/project/svsbs/templates/svsbs/files/militarystar.png" class="imgmiddle" width="35">Вход для командира:</h1>
			<div id="loginmessage"></div>
			<? if(!$nickname){//Значит еще не залогинен?>
			<fieldset class="login">
				<form action="/" method="post">
				  <input type="text" name="login_username" value="Фамилия" size="30" id="formlogin" 
				  onblur="if (value == '') {value = 'Фамилия'}" onFocus="if (value == 'Фамилия') {value =''}" />
				  <input type="password" name="login_password" value="Пароль" size="30" id="formpass" 
				  onblur="if (value == '') {value = 'Пароль'}" onFocus="if (value == 'Пароль') {value =''}" />
				  <input type="button" value="Войти"  onClick="checkmylogin();return false;"/>
				</form>
			</fieldset>
				<? }
				else{?><span style="color:green">Добро пожаловать,<?=$nickname;?></span><br><br>
				<?	if ($_SESSION['changepassmust']!=="yes")
						{// Может менять пароль?>
						<div id="chpassmessage"></div>
						<div id="chpassform"><? include($_SERVER["DOCUMENT_ROOT"]."/change_password_form.php");?></div>
						<a href='/' onclick='becamebig("chpassform");return false;'>Сменить пароль</a><br><br>
					<?	}
					else {// Должен менять пароль
						include($_SERVER["DOCUMENT_ROOT"]."/change_password_form.php");
						}?>
					<a href='/logout/' onclick='logout();return false;'>Выйти</a><? }?>
		</div><!-- End Quick military login  -->
		<!-- Quick News Page Bottom -->
		<div id="quickarbitrary-bottom_5" class="quick m_arbitrary_sidebar">
			<div id="arbitrary_modbox_5" class="modbox">
				<div class="imagebox" style="width:96px;"><img src="/project/svsbs/templates/svsbs/files/logo-vzor.png" id="media_81" alt="logo_small.png" width="35" class="imgmiddle"/></div>
				<h1><a href="/?page=news" onClick="shownews('0');linkcolor('news'); return false;" class="zoom iframe">Новости армии &raquo;</a></h1>
				
			</div>
		</div>
		<!-- End News Page Bottom -->
		<!-- Quick Contacts Bottom -->
		<div id="quickarbitrary-bottom_6" class="quick m_arbitrary_sidebar">
			<h1>Контактная информация</h1>
			<div id="arbitrary_modbox_6" class="modbox">
				<h1>Контактная информация</h1>

				<ul class="vcard">
				<li class="email"><img src="/project/svsbs/templates/svsbs/files/email.png" width="30" class="imgmiddle">
					<span class="value"><a href="mailto:<?=$officialemail?>"><?=$officialemail?></a></span></li>
				<li class="tel"><img src="/project/svsbs/templates/svsbs/files/phone.png" width="30" class="imgmiddle"> <?=$contactphone?></li>
				<li class="tel">Раимов Олег 8-926-536-52-72</li>
				<li class="tel">Леонид Ковшиков 8-916-828-43-40</li>
				</ul>
		
			</div>
		</div>
		<!-- End Contacts Bottom -->
	</div><!-- End page footer -->
	<div id="designcredit">
		<p class="page_footer">Site design: <a href="/" target="_blank">PopWebStudio</a></p>
	</div>		
</div><!--close pagebottom-->
<script type="text/javascript" charset="utf-8" src="files/mootoolu.js"></script>


<?
#####################################
# // Body							#
#####################################
?></body><?
#####################################
# Required 2						#
#####################################
	}
	else{?><body><?
		insert_module("loginform_simple");
		?></body><?
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>