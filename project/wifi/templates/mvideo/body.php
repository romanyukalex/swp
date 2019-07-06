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
3. Если надо, чтобы ссылка показывала в нужном div#content какую то страницу, то пишем ей onClick="changerazdel('pagename');return false;" или класс (будет сделано). На странице д.б. блок <div id="content1"></div>. Часто оборачиваем в div id="content" вокруг pagemanage
4. Если надо использовать какой-нибудь сторонний класс, то кидаем его в папку "/core/functions/". Название файла должно совпадать с названием класса, тогда класс сам подцепится
5. Если надо кроссбр-но вставить "Добавить в избранное" <a href="javascript:void(0)" onClick="return BookmarkApp.addBookmark(this)">bookmarkIt</a>
6. Подключить любой модуль - include($_SERVER["DOCUMENT_ROOT"]."/modules/modulename/design.php");
   Например, кнопка google+1 - include($_SERVER["DOCUMENT_ROOT"]."/modules/google_plusone/design.php");
   Или так - insert_module("modulename");
7. Подключаем фукнцию - insert_function("functionname") из /core/functions
8. Если нужно выводить название страницы на странице то обозначаем место так - id="titleonpage"

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
<body>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>
<style>

#cabinet-auth-continue,#logout_button{
	padding-left: 0;
    padding-right: 0;
    text-align: center;
    width: 100%;
    text-decoration: none;
	background-color: #ed1c24;
    border: 0 none;
    border-radius: 0.4rem;
    box-sizing: border-box;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-size: 1.4rem;
    font-weight: 700;
    height: 4.4rem;
    line-height: 1.5rem;
    margin-bottom: 0;
    outline: 0 none;
	vertical-align: middle;
    word-break: break-all;

}
</style>
	<!--script>
		dataLayer = [ {
		'pageType' : 'Profile',
		
	'user_crm_id': '',
	'userAuth': '0',   
	'cityId': '1',
	'cityName': 'Москва',
	'storeName': '',
	'storeID': '',
	
	} ];	</script>
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-6ZQL" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-6ZQL');</script-->
<div class="wrapper">
            <div class="page-content">
                <div class="sidebar">
                    
                </div>
                <div class="header-main" data-init="headerRegions">
                    <div class="header-area">
                        
	
	<div class="data-gtm-block hidden">
	
		
	</div>

	<div id="header-regions">
		


	<div class="header-section">
		
		<h2 class="region-heading">
			Выберите свой город
		</h2>
		<div class="header-map-section">
			<div class="header-region-map">

	
	
	
	
			<div class="lazy-load-image-holder">
		

		<img <? //data-original="//static.mvideo.ru/assets/img/regions-map.png"?> alt="М.Видео на карте России" class="lazy ">

		
	</div>	
	


			</div>
			<div class="header-primary-cities" data-init="regionSelectorHandler" data-init-param="input[id^=city-radio-]">

				
	<ul>	
	<li> <input id="city-radio-0" name="city-radio" type="radio" checked class="input-radio"> <label for="city-radio-0" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_975"></a> Москва
	</label></li>	
	<li> <input id="city-radio-1" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-1" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1272"></a> Волгоград
	</label></li>	
	<li> <input id="city-radio-2" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-2" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_2030"></a> Екатеринбург
	</label></li>	
	<li> <input id="city-radio-3" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-3" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1458"></a> Казань
	</label></li>	
	<li> <input id="city-radio-4" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-4" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityR_106"></a> Калуга
	</label></li>	
	</ul>	
	<ul>	
	<li> <input id="city-radio-5" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-5" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1854"></a> Красноярск
	</label></li>	
	<li> <input id="city-radio-6" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-6" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_974"></a> Нижний Новгород
	</label></li>	
	<li> <input id="city-radio-7" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-7" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_2246"></a> Новосибирск
	</label></li>	
	<li> <input id="city-radio-8" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-8" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1250"></a> Пермь
	</label></li>	
	<li> <input id="city-radio-9" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-9" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_2446"></a> Ростов-на-Дону
	</label></li>	
	</ul>	
	<ul>	
	<li> <input id="city-radio-10" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-10" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1780"></a> Самара
	</label></li>	
	<li> <input id="city-radio-11" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-11" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1638"></a> Санкт-Петербург
	</label></li>	
	<li> <input id="city-radio-12" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-12" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1370"></a> Ставрополь
	</label></li>	
	<li> <input id="city-radio-13" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-13" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_1024"></a> Тюмень
	</label></li>	
	<li> <input id="city-radio-14" name="city-radio" type="radio" class="input-radio"> <label for="city-radio-14" class="label-radio">
									<span class="fake-radio"></span> <a class="hidden" href="http://www.mvideo.ru/login/?cityId=CityCZ_2534"></a> Уфа
	</label></li>	
	</ul>	
			</div>
			<h2 class="white-text">
				Или укажите в поле
	</h2>	</div>	
		<div class="header-search-section">
			<form id="region-selection-form" action="https://www.mvideo.ru/login/?&amp;_DARGS=/sitebuilder/blocks/regionSelection.jsp" method="post"><input name="_dyncharset" value="UTF-8" type="hidden"></input><input name="_dynSessConf" value="2452836541490184435" type="hidden"></input>
				<span class="input-wrapper" data-init="validationHandler" data-init-param="#region-selection-form">
					
		<div data-init="autocompleteHandler" data-init-param="{&quot;element&quot;: &quot;.city-input&quot;,&quot;theme&quot;:&quot;dark&quot;,&quot;controller&quot;:&quot;CitiesAjaxController&quot;,&quot;idStore&quot;:&quot;#region-selection-form-frm-city-id&quot;,&quot;scrollAll&quot;:true, &quot;submitAfterFormInHeader&quot;: true}" class="input">
	<input id="region-selection-form-frm-city-id" name="/com/mvideo/domain/RegionSelectionFormHandler.cityId" value type="hidden"><input name="_D:/com/mvideo/domain/RegionSelectionFormHandler.cityId" value=" " type="hidden"><input data-rule-autocomplete-validation="true" placeholder="Введите название города" class="city-input" autocomplete="off" type="text" data-valid-autocomplete="true" data-invalid-city-msg="Введенный Вами город не найден" id="region-selection-form-city-input" data-init-param="#region-selection-form, .city-input, true" data-msg-required="Введенный Вами город не найден" data-rule-minlength="2" maxlength="1024" data-msg-autocomplete-validation="Введенный Вами город не найден" name="region-selection-form-city-input" data-init="autocompleteValidation" value data-msg-minlength="Введенный Вами город не найден" data-rule-required="true"><input name="_D:region-selection-form-city-input" value=" " type="hidden">
</div>
	</span>	<input id="region-selection-form-city-input-btn" name="/com/mvideo/domain/RegionSelectionFormHandler.changeRegion" value="Выбрать" class="btn btn-primary search-city-submit-btn disabled" type="submit" disabled="disabled"><input name="_D:/com/mvideo/domain/RegionSelectionFormHandler.changeRegion" value=" " type="hidden"><input name="_DARGS" value="/sitebuilder/blocks/regionSelection.jsp" type="hidden"></input></form>

		</div>

		<a class="region-close collapsed">Закрыть<span></span></a>	</div>

	</div>
	<div class="region-popup">
		<div id="region-popup" data-init="custom-tooltip" data-init-param="#region-popup, bottom" data-tooltip-text class="region-popup-btn"></div>
	</div>
	
	<div class="header-main-area">
		<div class="header-section">
			<div class="header-area-center">
				<div class="header-area-holder">
					<a href="https://www.mvideo.ru/" class="header-logo font-icon icon-logo-main">
						
						<img class="header-logo-img" src="/project/wifi/templates/mvideo/files/mvideo-l.png" alt="М.Видео, нам не всё равно">
						<strong>М.Видео, нам не всё равно</strong>
					</a>
				</div>
			</div>


			<div class="header-area-left">
				<a href="https://www.mvideo.ru/login/#" class="header-menu-btn">Menu</a>
				
						<script>
							var gtmRegistration = function(){
								document.getElementById('gtmRegistrationDiv').innerHTML =
										'<span class="hidden" id="gtmRegistration">{\
										"event": "OWOX",\
										"eventCategory": "Interactions",\
										"eventAction": "click",\
										"eventLabel": "registration"\
										}</span>';
							};
							var gtmLogin = function(){
								document.getElementById('gtmLoginDiv').innerHTML =
										'<span class="hidden" id="gtmLogin">{\
										"event": "OWOX",\
										"eventCategory": "Interactions",\
										"eventAction": "click",\
										"eventLabel": "authorisation",\
										"eventContext": "email"\
										}</span>';
							};
						</script>
						<!--noindex-->
						<div id="gtmRegistrationDiv" style="display: none;">
							<script>gtmRegistration();</script>
						</div>
						<div id="gtmLoginDiv" style="display: none;">
							<script>gtmLogin();</script>
						</div>
						<!--/noindex-->

						<div class="header-login">
							<!--noindex-->
								<ul class="header-login-options-list">
									
									<!--li class="header-login-option"><a data-pushable="true" data-holder="#gtmRegistration" class="header-login-option-link" href="/?page=wifi_sc_main" data-action="click">Портал самообслуживания</a></li-->
								
								</ul>
								<span class="header-login-description">&nbsp;</span>	<!--/noindex-->	</div>	
			</div>
			<div class="header-area-right">
					

	<!--script>
		var gtmMiniBasketNavigation = function(){
			document.getElementById('gtmMiniBasketNavigationDiv').innerHTML =
					'<span class="hidden" id="gtmMiniBasketNavigation">{\
					"event": "OWOX",\
					"eventCategory": "Interactions",\
					"eventAction": "click",\
					"eventLabel": "initiateCart"\
					}</span>';
		};
	</script-->
	<!--noindex-->
	<div id="gtmMiniBasketNavigationDiv" style="display: none;">
		<script>gtmMiniBasketNavigation();</script>
	</div>
	<!--/noindex-->

	<!--div id="js-mini-basket" class="mini-basket-block">
		<a href="https://www.mvideo.ru/cart" data-pushable="true" data-action="click" data-holder="#gtmMiniBasketNavigation" data-init="miniBasketBtn" data-device="true" data-init-param="#js-mini-basket" class="mini-basket-service-blocks mini-basket-link collapsed close-cart default">
			<strong class="icon-trolley-cart font-icon">
				
	</strong>	</a>	
	</div-->


	<!--div class="wishlist-block">
					
							<a href="https://www.mvideo.ru/wish-list" data-device="true" class="wishlist-link default">
								<strong class="icon-heart font-icon"></strong>
							</a>
						
	</div>	<!--form id="main-search-form" action="https://www.mvideo.ru/action/search?_DARGS=/sitebuilder/blocks/search/search.jsp" class="header-search-form-section" method="post"><input name="_dyncharset" value="UTF-8" type="hidden"></input><input value="2452836541490184435" type="hidden"></input>
		<div data-init="autocompleteHandler" class="header-search-form" data-init-param="{&quot;element&quot;: &quot;#frm-search-text&quot;,&quot;submitAfter&quot;: &quot;true&quot;,&quot;timeout&quot;:0}">
				<input type="hidden" name="Dy" value="1">
				<input type="hidden" name="Nty" value="1">
				<input type="hidden" name="Nrpp" value="24">
				<input placeholder="Поиск" class="header-search-input" autocomplete="off" type="text" id="frm-search-text" data-init-param=".header-area-right #main-search-form" data-msg-required="Введено менее 2 символов" data-validate-keyup="true" data-rule-minlength="2" maxlength="64" name="Ntt" value data-init="validationHandler" data-msg-minlength="Введено менее 2 символов" data-rule-required="true"><input name="_D:Ntt" value=" " type="hidden"><input id="productListPageURL" name="/com/mvideo/search/SearchFormHandler.searchSuccessURL" value="/product-list" type="hidden"><input name="_D:/com/mvideo/search/SearchFormHandler.searchSuccessURL" value=" " type="hidden"><input name="/com/mvideo/search/SearchFormHandler.searchErrorURL" value="/login/" type="hidden"><input name="_D:/com/mvideo/search/SearchFormHandler.searchErrorURL" value=" " type="hidden">
				<input type="hidden" id="productUrlFormat" value="/products/<subject.seoName>-<subject.repositoryId>">
				<span class="font-icon icon-zoom header-search-icon">
					<input type="submit" class="header-search-btn" value>
				</span>
				
	</div>	<input name="_DARGS" value="/sitebuilder/blocks/search/search.jsp" type="hidden"></input></form-->

	<label for="frm-search-text" data-init="autocompleteForm" data-init-param="{&quot;element&quot;: &quot;#frm-search-text&quot;, &quot;setPopupFocus&quot;: true }" class="header-search-form-label" data-device="true">
		<i class="font-icon icon-zoom"></i>
	</label>


	<div class="dimSearchSuggContainer"></div>

	</div>	</div>	</div>

		<!--div data-init="stickyHeader" data-device="true" data-instance="stickyHeader"></div-->
		
	

			
                    </div>
                </div>
                
                <div class="main-holder" data-init="lazyLoadContent">
                    <div class="content-top-section">
    <div class="section">
       
<?include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); ?>

	
    </div>
</div>
                </div>
                

	<footer class="footer grayLighter">

		
			
				
				<div class="footer-bottom">
					<div class="section">
						<div class="footer-akit-ico">
						</div>

						
						<div class="footer-copyright">
							
							<a href="/"><img src="/project/wifi/templates/mvideo/files/logo-sma.png" alt="М.Видео" title="М.Видео"></a>
							Copyright ©  М. Видео,&nbsp;2016
						</div>
						<!--ul class="footer-sub-nav">
							<li><a href="https://www.mvideo.ru/legal-notice">Официальная информация</a></li>
							<li><a href="https://www.mvideo.ru/contacts">Свяжитесь с нами</a></li>	</ul-->	</div>	</div>	
<!-- SeeWhy Abandonment Tracking Tag -->
<script type="text/javascript" src="/project/wifi/templates/mvideo/files/cywevent.js">
</script>
<script type="text/javascript">
/*
cy.control.cookieinfo.domain="www.mvideo.ru";
function queryStr(queryName) {
	queryString = window.location.search.substring(1);
	queryStringSplit = queryString.split("&");
	for (i=0;i<queryStringSplit.length;i++) {
		queryResult = queryStringSplit[i].split("=");
		if (queryResult[0] == queryName) {
			return queryResult[1];
		}
	}
}
if (queryStr("cyEmail")) {
	cy.Custom1="Guest";
	cy.UserId=unescape(queryStr('cyEmail'));
	cy.FunnelLevel="0";
	cy_getImageSrc();
}
//-->*/
</script>
					
	</footer>

            </div>
        </div>
<script src="/project/wifi/templates/mvideo/files/libs0000.js"></script><script src="/project/wifi/templates/mvideo/files/jst00000.js"></script><script src="/project/wifi/templates/mvideo/files/mvid0000.js"></script>
<!--script>$.get("/?ssb_javascript_enabled");</script-->



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