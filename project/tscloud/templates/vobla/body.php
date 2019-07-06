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
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));

if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	$log->LogInfo(basename (__FILE__)." | Dont blocked ");
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################

#####################################
# Body								#
#####################################
insert_module("scroll-nicescroll","html","#4d5152");
		?>
<!--body class="b-inner-layout"-->


<div id="dim"></div>
<!--div class=" fb_reset" id="fb-root"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div><iframe src="/project/<?=$projectname?>/files/xd_arbiter.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_http" allowtransparency="true" name="fb_xdm_frame_http" frameborder="0" scrolling="no"></iframe><iframe src="/project/<?=$projectname?>/files/xd_arbiter_002.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_https" allowtransparency="true" name="fb_xdm_frame_https" frameborder="0" scrolling="no"></iframe></div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div-->
<!--div class=" fb_reset" id="fb-root"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div><iframe src="/project/<?=$projectname?>/files/xd_arbiter.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_http" allowtransparency="true" name="fb_xdm_frame_http" frameborder="0" scrolling="no"></iframe><iframe src="/project/<?=$projectname?>/files/xd_arbiter_002.htm" style="border: medium none;" tab-index="-1" title="Facebook Cross Domain Communication Frame" aria-hidden="true" id="fb_xdm_frame_https" allowtransparency="true" name="fb_xdm_frame_https" frameborder="0" scrolling="no"></iframe></div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div-->

<script>
$(document).ready(function(){
	
	<? if ($userrole!=="guest"){?>$('#cabinetlinks').fadeIn(300);<?}
	elseif(!$userrole or $userrole=="guest"){?>$('#logreglinks').fadeIn(300);<?}
	?>
	any_site_size("siteblock","topheader","top-menu","whitefield","footerblock","whitefield");
	})
</script>



      <div class="b-layout" id="siteblock">
	      <div class="side-shadow_left png">
        <div class="side-shadow_right png">
	    	<div id="panel"></div>
      <!-- Контент -->
      <div class="b-fixed-width">
        <!-- Главная страница -->

        <div id="siteheaderblock">
          <!-- { Заголовок с логотипом -->
          <div class="b-header" id="topheader">
            <div class="header-wrap">
            	<a href="/">
              <img alt="<?=$logoalt?>" class="b-logo b-logo_index png" src="<?=$logofile;if($language=="en"){echo".en.png";}?>" height="67" width="228">
              	</a>
              <div class="group">




<div style="position:relative; width:100px; z-index:2; left:370px; margin-right:-460px; top:-20px;">
<b><a href="<?if($language=="en"){?>http://www.technoserv.com/en/about/contacts/russia/msk/<?}else{?>http://www.technoserv.com/about/contacts/russia/msk/<?}?>" style="color: #ced64b; text-decoration:none; font-style: inherit; font-size: 100%; font-family: inherit;">
<?if($language=="en"){?>Contacts<?}else{?>Контакты<?}?></a></b> </div>









                <div class="item country-select">
                  <!--strong>Россия


</strong>
                  [
                  <span id="city_open">Изменить</span>
                  ]
<div id="city_slide"><a href="http://ua.technoserv.com/">Украина</a><br>
<a href="http://uz.technoserv.com/">Узбекистан</a><br></div-->

				
                </div>
             	<!--div style="position:relative; width:100px; z-index:3;left:-360px; top:35px;"> <img src="/files/Cloud_Metallic_Button2.png" height="300px">
<? 			//<img src="/files/TS_Cloud_512x512.png" height="100px">?>
				</div-->
				<div class="item language-select">
					<ul class="t-upper-case" id="lang-select">
						<? if($language=="en"){?>
							<li class="active"><span class="png">eng</span></li>
							<li class="hidden"><a class="t" href="<?
							$langjustchanged=strpos($_SERVER['REQUEST_URI'],"lang=");
							if($langjustchanged!== false){ // Только сменили язык на русский
								if ($urilenght==9){// Содержится только переменная lang
									echo "/?lang=ru";
								}
								else {// Только сменили язык, были не в корне сайта
									echo substr($_SERVER['REQUEST_URI'],0,-8)."&lang=ru";
								}
							}
							else { // Просто ходят, не меняли только что язык
								if($_SERVER['REQUEST_URI']!=="/") echo $_SERVER['REQUEST_URI']."&lang=ru";
								else echo "/?lang=ru";						
							}?>">рус</a></li>
						<? } 
						else{// Язык русский?>
							<li class="active"><span class="png">рус</span></li>
							<li class="hidden"><a class="t" href="<?
							$langjustchanged=strpos($_SERVER['REQUEST_URI'],"lang=");
							if($langjustchanged!== false){ // Только сменили язык на русский
								if ($urilenght==9){// Содержится только переменная lang
									echo "/?lang=en";
								}
								else {// Только сменили язык, были не в корне сайта
									echo substr($_SERVER['REQUEST_URI'],0,-8)."&lang=en";
								}
							}
							else { // Просто ходят, не меняли только что язык
								//echo $_SERVER['REQUEST_URI'];
								if($_SERVER['REQUEST_URI']!=="/") echo $_SERVER['REQUEST_URI']."&lang=en";
								else echo "/?lang=en";						
							}?>">eng</a></li>
						<?}?>
					</ul>
                </div>
                <div class="item" id="logreglinks" style="display:none">
                  <a class="t feedback js-window" href="/?page=login&menu=mainmenu"><? if($language=="en"){?>Login<?} else {?>Войти<? }?></a><a class="t feedback js-window" href="/?page=register&menu=mainmenu"><? if($language=="en"){?>Registration<?} else{?>Регистрация<? }?></a>
                </div>
				<? //if(($menureq!=="cabinet_su" and $menureq!=="cabinet")or $menu=="cabinet"){
				if($userrole and $userrole!=="guest"){?>
				<div class="item" id="cabinetlinks" style="display:none">
				<a href="/?page=cabinet"><?if($language=="en"){?>To self care portal<?} else{?>Войти в личный кабинет<?}?></a>
				</div><? }?>
                <!--div class="item search">
                  <form action="/" method="get">
                    <div class="input">
                      <input value="Поиск на сайте" name="q" class="field js-placeholder placeholder" title="Поиск на сайте" type="text">
                      <a class="submit png" href="javascript:void(0)" onclick="$(this).closest('form').submit();"></a>
                    </div-->
					<?  insert_module("search_morph","form","design_simple","content1");?>
                <?/*<div class="item">
                	<b><a href="
					<?if($language=="en"){?>http://www.technoserv.com/en/about/contacts/russia/msk/<?}else{?>http://www.technoserv.com/about/contacts/russia/msk/<?}?>" style="color: #ced64b; text-decoration:none; font-style: inherit; font-size: 100%; font-family: inherit;">
<?if($language=="en"){?>Contacts<?}else{?>Контакты<?}?></a></b>
                </div> */?>   
                  <!--/form-->
                <!--/div-->
              </div>
            </div>
          </div>
          <!-- Заголовок с логотипом } -->
          <!--Меню сверху-->
          <div class="b-top-menu" id="top-menu">		
			<div class="items">
				<div class="item<? if($page=="services" or $menureq=="services"){?> active<?}?>">
                    <div  class="submenu">
					  <? 
						if($page!=="services" and $menureq!=="services"){
							insert_module("menu","services_top","no","no");
						}?>
                    </div>
					<a href="/?page=services&menu=services" class="label t-upper-case" style="width: 245px"><? if($language=="en"){?>SaaS Applications<?} else {?>Приложения SaaS<? }?></a>
                </div><div class="item<? if($page=="tscloud" or $menureq=="tscloud"){?> active<?}?>">
          			<div class="submenu">
                   	<? 	
						if($page!=="tscloud" and $menureq!=="tscloud"){
							insert_module("menu","tscloud_top","no","no");
						}?>
					</div>	    
					<a href="/?page=tscloud&menu=tscloud" class="label t-upper-case" style="width: 245px"><? if($language=="en"){?>TS cloud<?} else{?>Облако TS<? }?></a>	    
                </div><div class="item<? if($page=="references"){?> active<?}?>">
          			<a href="?page=references&menu=mainmenu" class="label t-upper-case" style="width: 245px"><? if($language=="en"){?>Our experience<?} else{?>Наш опыт<? }?></a>
          		</div><div class="item_last"><div class="item<? if($page=="news"){?> active<?}?>">
          			<a href="/?page=news&newspage=1&menu=mainmenu" class="label t-upper-case" style="width: 245px"><? if($language=="en"){?>News<?} else{?>Новости<? }?></a>
          		</div></div>

          	</div>			

                    </div>
          <!--/Меню сверху-->
	              <div class="inner-layout" id="whitefield">
                <div class="clearfix">
                      <div class="inner-col_left">
                    <div class="inner-col_wrap">
                      
                      <!-- { Левая менюшечка -->
						
                      <ul class="b-sidebar-menu js-sidebar-menu" id="leftmenutab">
					<? 
							insert_module("menu",$menureq,"no","yes");
						 ?>
					  </ul>
                    </div>
                  </div>

<!-- Основная контентная часть-->
                  <div class="inner-col_right">
                  	<div class="inner-col_wrap">
						<div class="b-page b-text"><h2 id="titleonpage"></h2></div>
						<div id="messageplace"></div>
						<? insert_module("bookmark");?>
                    	<!--div id="content1"></div>
                    	<div id="content"-->
                    
                  	<? include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php");?>
                    	<!--/div-->
                    </div>
                    
                    
                    
                      </div>
<!-- / Основная контентная часть-->	                
                    </div>
                <div class="b-inner-bottom-banners"></div>
              </div>
              
          <div class="b-footer b-footer_inner" id="footerblock">
            <div class="cols">
              <div class="shadow png">
                <a class="toggler png" href="javascript:void(0)" id="footer-toggler" onClick="Technoserv.Footer.toggle().site_size();"><span><!--?=GetMessage("pokaznet")?--></span></a>
              </div>
              <div style="height: 205px;" class="clearfix" id="footer">
                <div class="col">
                  <ul class="wrap">
                    <li><? if($language=="en"){?>Contacts<?} else{?>Контакты<? }?></li>
                    <li class="phone">
                      <strong>+7 (495) 648-08-08</strong>
                    </li>

<li>

<b>Skype:</b> <br>


<a href="skype:phone.technoserv.com?call">phone.technoserv.com</a><br>
<b>Google Talk</b>: phone.technoserv.com@gmail.com
<br>

<table>
<tbody><tr><td align="left" width="24">
<a href="https://www.facebook.com/TechnoservGroup?ref=ts" target="_black"><img src="/project/<?=$projectname?>/files/facebook.png" border="0" width="19"></a>
</td><td>
<a href="https://twitter.com/#!/Technoserv" target="_black"><img src="/project/<?=$projectname?>/files/twitter.png" border="0" width="19"></a>
</td></tr></tbody></table>

</li>
                    <li class="feedback">
                      <h2>
                        <a class="png js-window" href="/?page=contact_form&menu=mainmenu" rel="#mail"><? if($language=="en"){?>Send request<?} else{?>Отправить вопрос<? }?></a>
                      </h2>
                    </li>
                    <li class="subitem start_section png">
	
                  </li></ul>
				  <a  href="/?page=Becb_cauT">Карта сайта</a>
                </div>
                <div class="col">
                  <ul class="wrap">
                    <li>
                      <h2>
                        <a href="http://www.technoserv.com/about/company/" target="_blank"><? if($language=="en"){?>About Technoserv<?} else{?>О ТЕХНОСЕРВЕ<? }?></a>
                      </h2>
                    </li>
                    <li>
                      <a href="http://www.technoserv.com/about/company/" target="_blank"><? if($language=="en"){?>Corporate Profile<?} else{?>О компании<? }?></a>
                    </li>
                    <li>
                      <a href="http://www.technoserv.com/about/company/group/technoserv/" target="_blank"><? if($language=="en"){?>Technoserv Group<?} else{?>Группа компаний «ТЕХНОСЕРВ»<? }?></a>
                    </li>
                    <li>
                      <a href="http://www.technoserv.com/about/partnery1/" target="_blank"><? if($language=="en"){?>Partners<?} else{?>Партнеры<? }?></a>
                    </li>
                    <li>
                      <a href="http://www.technoserv.com/about/customers/" target="_blank"><? if($language=="en"){?>Clients<?} else{?>Заказчики<? }?></a>
                    </li>
                  </ul>
                </div>
                <div class="col">
                  <ul class="wrap">
                    <li>
                      <h2>
                        <a href="/?page=services"><? if($language=="en"){?>Order of services<?} else{?>Заказ услуг<? }?></a>
                      </h2>
                    </li>
					<? insert_module("menu","instruction","no","yes");?>
                  </ul>
                </div>
                <div class="col">
                  <ul class="wrap">
                    <li>
                      <h2>
                        <a rel="#mail" href="javascript:void(0)" class="png js-window"><? if($language=="en"){?>My account<?} else{?>Личный кабинет<? }?></a>
                      </h2>
                    </li>
                    <? if($menureq!=="cabinet_su" and $menureq!=="cabinet"){?><li<? if($userrole=="guest"){echo " style='display:none'";}?> class="loggedlink"><a href="/?page=cabinet"><? if($language=="en"){?>Login<?} else{?>Войти в личный кабинет<? }?></a></li><?}?>
                    <li<? if($userrole=="guest"){echo " style='display:none'";}?> class="loggedlink"><a href="/logout" onClick="logout('messageplace');return false;"><? if($language=="en"){?>Logout<?} else{?>Покинуть личный кабинет<? }?></a></li>
				
					<li<? if($userrole!=="guest"){echo " style='display:none'";}?> class="nonloggedlink"><a href="/?page=register&menu=mainmenu"><? if($language=="en"){?>Register<?} else{?>Зарегистрироваться<? }?></a></li>	
					<li<? if($userrole!=="guest"){echo " style='display:none'";}?> class="nonloggedlink"><a href="/?page=login"><? if($language=="en"){?>Login<?} else{?>Войти в личный кабинет<? }?></a></li>
					<li<? if($userrole!=="guest"){echo " style='display:none'";}?> class="nonloggedlink"><a href="/?page=forgot_pass&menu=mainmenu"><? if($language=="en"){?>Recover your password<?} else{?>Восстановить пароль<? }?></a></li>
                  </ul>
                </div>
              </div>
              <div class="copyright" id="copyright">
                <div class="wrap">
                  © <? if($language=="en"){?>Technoserv group<?} else{?>Группа компаний «ТЕХНОСЕРВ»<? }?> <? insert_module("years");?>
                  <br>
                  <? if($language=="en"){?>All rights reserved<?} else{?>Все права защищены<? }?>.
                </div>
              </div>
            </div>
          </div>
          <!-- /Футер -->
        </div>
        <!-- /Главная страница -->
      </div>
      <!-- /Контент -->
			</div>
       </div>
	

    </div>
<!--/body-->
<?
#####################################
# // Body							#
#####################################

#####################################
# Required 2						#
#####################################
	}
	else{
		include($_SERVER["DOCUMENT_ROOT"]."/module/loginform_simple/design.php");
		
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>