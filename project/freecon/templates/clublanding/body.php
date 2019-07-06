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
insert_module("arcticmodal");
?>

<!--    --> 
<script type="text/javascript" src="/adminpanel/js/highslide/highslide-full.js"></script>
<link rel="stylesheet" type="text/css" href="/adminpanel/js/highslide/highslide.css" />
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

</script>

<div id="main"class="row">
<div  class="row">
 <div class="col-md-16">
        <!--<div class="top-trap">
    <div class="top-trap__content">
        <div class="top-trap__center">
        
            <div class="clear"></div>
        </div>
    </div>
</div>
    
    <div class="scroll-top js-scroll-top">
        <div class="scroll-top__text">▲ Наверх</div>
    </div-->

    <div class="header-menu-overlay js-left-menu-close"></div>

    <div class="header-entry-block clear">
        <div class="container">
            <div class="header-entry-top-block">
                <div class="header-entry-top-link-block">
                    <!--a class="header-entry-menu-link js-left-menu-open" href="javascript:void(0);">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a-->
                </div>
                <div class="header-entry-top-logo-block" style="width:600px">
	<a href="<? if($page!=="clublanding") {?>/<?} else {?>#<?}?>" class="header-entry-top-logo-link">
                        <img class="header-entry-top-logo imgmiddle" src="<?=$logofile?>" alt="<?=$logoalt?>" title="Клуб Здорового Сознания. Речевые практики для жизни" height="60px"style="display: inline-block;">
						
					</a>
					<div style="display: inline-block; padding:5px 0 0 18px"><h2>Клуб Здорового Сознания&#153;</h2>
					<h4 style="margin: 5px 0px 0px 50px">Речевые практики для жизни</h4>
					</div>
                </div>
                <!--div class="header-entry-top-tags-block" style="width: 400px;height:20px;">
					sdfsdf
                </div-->

                
                <div class="header-entry-top-avatar-block">
                        <div class="header-entry-top-menu-block login-block">
						
						<a class="header__phone fancybox-popup_callback" 
								style="color: #231f20; font-family: ProximaNova Bold;font-size: 13px;font-style: normal;font-weight: normal;text-transform: uppercase; margin-right:20px"
								id="callbackA" href="tel:<?=$contactphone?>"><span class="span"></span><?=$contactphone?></a>
						<a class="header__phone fancybox-popup_callback" href="mailto:<?=$officialemail?>"><?=$officialemail?></a>
						<!--a class="login fancybox-popup_login highslide" href="/#popup_auth" onclick="return hs.htmlExpand(this, { contentId: 'popup_auth' } )">Войти</a-->
						<? if($userrole and $userrole!=="guest"){?><a class="" style="cursor:pointer" onclick="logout('messageplace');">Выйти</a><? }?>
						</div>
                </div>

                <div class="clear head_city"></div>

                            </div>
        </div>
		
		<!-- Верхнее меню-->
		<div class="row" id="top_menu_line">
		  <div class="col-md-1 topmenu_block" style="background: #ffe20b;">О клубе</div>
		  <div class="col-md-2 topmenu_block" style="background: #ff8875;">Магазин тренингов</div>
		  <div class="col-md-1 topmenu_block" style="background: #ffec86;;">Блог</div>
		  <div class="col-md-2 topmenu_block"style="background: #8ae6fa;">Полезные видео</div>
		  <div class="col-md-3 topmenu_block"style="background: #ff8875;">Наши мероприятия</div>
		  <div class="col-md-1 topmenu_block"style="background: #ff6641;">Тренеры</div>
		  <div class="col-md-2 topmenu_block"style="background: #ffec86;;">Контакты</div>
		</div>
		<!-- // Верхнее меню-->
    </div>
<!--script>
  $(function () {
   var formButton = $('.b_form_content .sbm .btn_yellow:first').text(),
        textSubmit = $.trim(formButton),
        buttons = $('a.button');

    if(textSubmit == 'Подать заявку'){buttons.text('Принять участие');}
    if(textSubmit == 'Оплатить участие'){buttons.text('Оплатить участие');}
  });
</script-->
</div>
</div>
<div class="clear_header"></div>
<div id="messageplace"></div>


<? include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); ?>

 <!-- / main -->


<div id="footer">
  
  <div class="container">
  
	<div class="footer_group">
	   
		<ul style="width: 222px;" class="footer_list">
			<li class="title"><a href="/#clubcontent">Программа клуба</a></li>
			
		</ul>
		<ul style="width: 130px;" class="footer_list">
			<li class="title"><a href="//vk.com/nlpcourse" target="_blank" rel="nofollow">Мы в ВКонтакте</a></li>
			
		</ul>
		<ul style="width: 152px;" class="footer_list">
			<li class="title"><a href="//www.youtube.com/playlist?list=PLQo7Zt56jwSevuoBpy3chjUq9sMWFdVkG" target="_blank" rel=”nofollow”>Наш канал YouTube</a></li>
			
		</ul>
		<ul style="width: 172px;" class="footer_list">
			<li class="title"><a href="/#schedule">Расписание</a></li>
		</ul>
	</div>
	<div class="footer_group appFoot">
		<div class="footer_inn">
		Клуб «Клуб Здорового Сознания»<br>
		<a href="/#address" target="_blank">Адрес проведения: Средний Кисловский пер., 5/6 корп.3</a><br>
Skype: <a href="skype:romanyukalex?chat">romanyukalex</a><br>
Email: <a href="mailto:info@nlp-course.ru" id="top_ofmal">info@nlp-course.ru</a>
<?
insert_module("protected_mail","$officialemail","$officialemail","top_ofmal");
?>
<br><br>
<a class="footer_inn-link" href="/?page=Becb_cauT">Карта сайта</a>
			<!--a class="footer_inn-link" href="/">П</a>
			<a href="/?page=Becb_cauT">Карта сайта</a>
			<a class="footer_inn-link" href="/">П</a>
			<a class="footer_inn-link" href="/">С</a-->
		</div>
		<div class="footer_phone-block">
			<p class="footer_phone-text">
				<a href="tel:<?=$contactphone?>" style="color:#999999"><?=$contactphone?></a>
			</p>
			<!--a class="footer_phone-link fancybox-popup_callback order_call" href="#popup_callback"  onclick="return hs.htmlExpand(this, { contentId: 'popup_callback' } )" id="callbackB">заказать звонок</a-->

		</div>


	</div>
			
	<script type="text/javascript">
		var links = $('.footer_hidden-links'),
			button = $('.footer-show_more-link'),
			buttonSpan = $('.footer-show_more-link span');

		button.on('click', function(){
			if(links.is(':hidden')){
				links.slideDown(200);
				buttonSpan.text('скрыть карту сайта');
			} else {
				links.slideUp(200);
				buttonSpan.text('показать карту сайта');
			}
			return false;
		})
	</script>

  
  </div>

</div><!-- #footer -->

<div class="hidden">

	<div class="popup" id="modal_form" style="width:600px;height:500px">
	<? include($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname."/pages/clublanding-form_modal.php")?>  
	</div>
	<div class="popup" id="popup_rules">
	<b>Концепция и правила (кратко)</b><br>
	1.Первое правило клуба - никому не говорить о клубе. В своей обычной жизни, конечно. 
	Когда люди знают, что ты где то занимаешься, они могут побаиваться, осторожничать, твои результаты будут нечистыми.<br>
	2. В клуб принимаются адекватные люди. Мы ждём всех, кто не псих.<br>
	3. Ведущие нужны, чтобы поддерживать порядок. Иногда, ведущие меняются. 
	Иногда всё занятие ведет Дмитрий, иногда Алексей. Бывают приглашенные гости. <br> 
	4. Каждый участник ставит себе цели. Сам определяет для себя, что ему прокачивать, остальные участники лишь помогают. Каждый участник должен понимать, что будет прокачивать, какой минимальный видимый результат он ожидает получить. 
	Говорит это ведущим, они готовят задания для прокачки этой вещи. По шажочку движемся к этой цели. Если видим, что шажочек не удачен, возвращаемся обратно. <br>
	5. Тренеры используют не только НЛП. У нас есть элементы ораторского искусства, актерского мастерства, эриксоновского гипноза, дистанции Козлова, физиогномики, общечеловеческих приёмов общения.<br>
	6. Все полученные навыки должны увеличивать адаптированность нас всех в нашей жизни. Нет задачи делать группу, в которой мы все будем понимать друг друга, но со знаниями, которые доступны только нам. Важно, чтобы в своей социальной жизни мы все чувствовали улучшения.<br>
	7. Мы собираемся не для того, чтобы спорить о "правде". Но форма спора бывают продуктивнее мягкости с точки зрения подготовки к жизненным ситуациям. У всех бывают в жизни непозитивные вещи, надо быть готовым к ним даже лучше, чем к позитивным. Иногда занятия в клубе проходят не так позитивно, как обычно, и бывает мы спорим, доказывая свою позицию. Всё это делается для того, чтобы и в обычной жизни каждый из нас смог выкручиваться в спорах.<br>
	8. Распространение информации - хорошо. Любой тренер далеко не всё даёт про НЛП. Мы всё время делимся тем, что нашли в интернете или заметили в жизни, обсуждаем это.<br> 
	
	<div class="ta_c">
			<a class="button" href="/?page=club_concept_n_rules" target="_blank">Полная концепция и правила</a>
		</div><br><br>
	</div>
	
	
	
	<div class="popup" id="trainers_info" style="width:800px">
	<div class="popup__title">Занятия в клубе ведут</div>
	<div>
	<img src="/project/freecon/templates/clublanding/files/RomanyukAlexey2.png" width="153px"style="float:left; margin-right:10px">
	<b>Алексей Олегович Романюк</b><br>
	Автор десятков рассказов и корректирующих сказок для детей.<br>
	Факты:<br>
	10 лет - в ИТ и телеком бизнесе.<br>
	9 лет - знакомства с НЛП<br>
	9 лет - опыт преподавания, чтения лекций, проведения семинаров<br>
	5 лет - опыт переговоров и продаж<br>
	4 года - опыт руководства людьми<br>
	Среди слушателей семинаров - крупнейшие компании: МТС, Техносерв<br>
	Ученик: Frank Pucelik, Т.В. Гагин, Н.И.Козлов, Michael Hall и нескольких других, менее известных тренеров

	</div>
	<div>
	<img src="/project/freecon/templates/clublanding/files/FrolovDmitry2.png" width="153px" style="float:right;margin:20px 0 0 10px"><br>
	<b>Дмитрий Олегович Фролов</b><br>
	Окончил Московский Институт Связи и Информатики. Более 10 лет работаю в телекоммуникационном бизнесе, последние 4 года на руководящих должностях. Провёл более  100 собеседований, в том числе на руководящие позиции.
Создатель ряда успешных бизнес проектов. Создатель и руководитель консалтинговой компании, специализирующейся на техническом консультировании продаж в сфере b2b.
Профессиональный коуч сертифицированный по американской программе Kepner-Tregoe. Данная система используется в ведущих мировых компаниях – BMW, Cisco Systems, Juniper, Sony, Nokia и т.д. Провёл ряд тренингов в своей компании обучая сотрудников быстрому и успешному поиску проблем и принятию качественных решений в системных сферах бизнеса. Консультировал сотрудников компаний -партнёров по имплементации  данной системы в операционной деятельности компании.
Ученик Тимура Владимировича Гагина. Специалист по эриксоновскому гипнозу и НЛП-тренер. Успешно адаптируя модели НЛП в бизнесе и в навыках повседневной жизни разработал и интегрировал тренинги карьерного роста, тренинги для специалистов отдела кадров, тренинги мотивации персонала. Хобби – помогать людям менять вредные привычки на полезные в жизни инструменты.								
	</div>
	</div>
	
	<? /*
	<div class="popup" id="trainers_info_dfrolov" style="width:800px">
	<div class="popup__title">Дмитрий Олегович Фролов</div>
	<div>
	<img src="/project/freecon/templates/clublanding/files/FrolovDmitry2.png" width="153px" style="float:right;margin:20px 0 0 10px"><br>
	Окончил Московский Институт Связи и Информатики. Более 10 лет работаю в телекоммуникационном бизнесе, последние 4 года на руководящих должностях. Провёл более  100 собеседований, в том числе на руководящие позиции.
Создатель ряда успешных бизнес проектов. Создатель и руководитель консалтинговой компании, специализирующейся на техническом консультировании продаж в сфере b2b.
Профессиональный коуч сертифицированный по американской программе Kepner-Tregoe. Данная система используется в ведущих мировых компаниях – BMW, Cisco Systems, Juniper, Sony, Nokia и т.д. Провёл ряд тренингов в своей компании обучая сотрудников быстрому и успешному поиску проблем и принятию качественных решений в системных сферах бизнеса. Консультировал сотрудников компаний -партнёров по имплементации  данной системы в операционной деятельности компании.
Ученик Тимура Владимировича Гагина. Специалист по эриксоновскому гипнозу и НЛП-тренер. Успешно адаптируя модели НЛП в бизнесе и в навыках повседневной жизни разработал и интегрировал тренинги карьерного роста, тренинги для специалистов отдела кадров, тренинги мотивации персонала. Хобби – помогать людям менять вредные привычки на полезные в жизни инструменты.						
	</div>
	</div>
	
	<div class="popup" id="trainers_info_aromanyuk" style="width:800px">
	<div class="popup__title">Алексей Олегович Романюк</div>
	<div>
	<img src="/project/freecon/templates/clublanding/files/RomanyukAlexey2.png" width="153px"style="float:left; margin-right:10px">
	
	Автор десятков рассказов и корректирующих сказок для детей.<br>
	Факты:<br>
	10 лет - в ИТ и телеком бизнесе.<br>
	9 лет - опыт преподавания, чтения лекций, проведения семинаров<br>
	5 лет - опыт переговоров и продаж<br>
	4 года - опыт руководства людьми<br>
	Среди лушателей семинаров - крупнейшие компании: МТС, Техносерв<br>
	Пройденые тренинги: Переговоры.Управляя результатами(Frank Pucelik); НЛП-практик, Достигатор.Харизма (Т.В. Гагин); Синтон-дистанция (Н.И.Козлов); Продажи SPIN (Ю.А. Есина); Искусство речи: риторика и ораторское мастерство (Д.Устинов); Высвобождение потенциала (Michael Hall) и другие
	</div>
	</div>
	
	*/?>

	<!--div class="popup" id="new_order_form_div">
		<div id="new_order_form_ap">
		</div>
		<br>
		<span style="color:green;font-size:bold;">Чтобы провести время интереснее<br>
		Вы можете прочесть список статей на сайте</span><br><br>
		<div class="ta_c">
			<a class="button" href="/?page=CTATbu">Статьи на сайте</a>
		</div><br><br>
	</div-->
	
	
	<div class="box-modal" id="new_order_form_div" style="visibility: 0">
		<div class="box-modal_close arcticmodal-close">закрыть</div>
		<div id="new_order_form_ap">
		</div>
		<br>
		<span style="color:green;font-size:bold;">Чтобы провести время интереснее<br>
		Вы можете прочесть список статей на сайте</span><br><br>
		<div class="ta_c">
			<a class="button" href="/?page=CTATbu">Статьи на сайте</a>
		</div><br><br>
	</div>
	
	
	
	
	
	
	
	
    <div class="popup" id="popup_auth">
        <a class="popup__close js-popup-close" href="javascript:void(0);">Закрыть</a>

        <div class="hidden-text hidden">
            Для получения доступа к полному содержанию материала войдите или зарегистрируйтесь
        </div>

        <div class="popup__title">Войти <span class="or">или</span> <a class="link fancybox-popup_login" href="/#popup_registration" onclick="return hs.htmlExpand(this, { contentId: 'popup_registration' } )">Регистрация</a></div>

    

        <div class="popup__form">
            <form action="/login/" method="POST" class="direct" data-form="login">
                <div class="popup__error"></div>

                <div class="item">
                    <div class="label">E-mail</div>
                    <input class="input" name="login" type="text" placeholder="Введите ваш e-mail" value>
                    <div class="input-error"></div>
                </div>

                <div class="item">
                    <div class="label">Пароль</div>
                    <input class="input" name="password" type="password" placeholder="Введите ваш пароль" value>
                    <div class="input-error"></div>
                </div>

                <a class="green-button submit js-form-submit" href="javascript:void(0);">
                    <span class="text">Войти</span>
                    <span class="loading"></span>
                </a>

                <input class="hidden" type="submit">

            </form>

            <div class="center">
                <a class="link fancybox-popup_login" href="/#popup_pwd_remind" onclick="return hs.htmlExpand(this, { contentId: 'popup_pwd_remind' } )">Я забыл свой пароль</a>
                <a class="link hidden-text hidden go_to_available_materials" href="javascript: void(0)">Перейти к списку доступных материалов</a>
            </div>
        </div>
    </div>

    <div class="popup" id="popup_registration">
        <a class="popup__close js-popup-close" href="javascript:void(0);">Закрыть</a>

        <div class="hidden-text hidden">
            Для получения доступа к полному содержанию материала войдите или зарегистрируйтесь
        </div>

        <div class="popup__title"><a class="link fancybox-popup_login" href="/#popup_auth"  onclick="return hs.htmlExpand(this, { contentId: 'popup_auth' } )">Войти</a> <span class="or">или</span> Регистрация</div>

        <!--div class="popup__social">
            <a class="item vk" href="/social/auth/vkontakte/" data-social="authorization"></a>
            <a class="item fb" href="/social/auth/facebook/" data-social="authorization"></a>
            <a class="item tw" href="/social/auth/twitter/" data-social="authorization"></a>
            <a class="item ok" href="/social/auth/odnoklassniki/" data-social="authorization"></a>
            <a class="item ma" href="/social/auth/mail_ru/" data-social="authorization"></a>
            <a class="item gp" href="/social/auth/google_plus/" data-social="authorization"></a>
        </div>

        <div class="line-text">
            <div class="line"></div>
            <div class="text">или</div>
        </div-->

        <div class="popup__form">
            <form action="/registration/" method="POST" class="direct" data-form="login">
                <div class="popup__error"></div>

                <div class="item">
                    <div class="label">E-mail</div>
                    <input class="input" name="email" type="text" placeholder="Введите ваш e-mail" value>
                    <div class="input-error"></div>
                </div>

                <a class="green-button submit js-form-submit" href="javascript:void(0);">
                    <span class="text">Зарегистрироваться</span>
                    <span class="loading"></span>
                </a>

                <input class="hidden" type="submit">

                <div class="form-agreement">
    <input type="hidden" name="is_allowed_email" value="0">
    <input type="hidden" name="is_allowed_personal" value="0">
    <label class="form-agreement__label">
        <input class="js-form-agreement-children form-agreement__checkbox" type="checkbox" name="is_allowed_personal" value="1" checked="checked" onchange="if(!this.checked) alert('Вы должны дать согласие на обработку персональных данных')">
        Я даю свое согласие на обработку персональных данных и соглашаюсь с условиями и политикой конфиденциальности <br>
    </label>
    <label class="form-agreement__label">
        <input class="js-form-agreement-children form-agreement__checkbox" type="checkbox" name="is_allowed_email" value="1" checked="checked">
        Я хочу получать email-письма о мероприятиях и/или иных услугах БМР
    </label>
</div>            </form>

            <div class="center">
                <a class="link hidden-text hidden go_to_available_materials" href="javascript: void(0)">Перейти к списку доступных материалов</a>
            </div>
        </div>
    </div>

    <div class="popup" id="popup_pwd_remind">
        <a class="popup__close js-popup-close" href="javascript:void(0);">Закрыть</a>

        <div class="popup__title">Восстановление пароля</div>

        <div class="popup__form">
            <form action="/user/passrecover/" method="POST" class="direct" data-form="login">
                <div class="popup__error"></div>

                <div class="item">
                    <div class="label">E-mail</div>
                    <input class="input" name="email" type="text" placeholder="Введите ваш e-mail" value>
                    <div class="input-error"></div>
                </div>

                <a class="green-button submit js-form-submit" href="javascript:void(0);">
                    <span class="text">Восстановить пароль</span>
                    <span class="loading"></span>
                </a>

                <input class="hidden" type="submit">

                <div class="captchaBlock hidden">
                    <img src class="captchaImage">
                    <input name="captchaWord" class="captchaWord form_input" type="text" placeholder="Введите код с картинки">
                    <input name="captchaCode" class="captchaCode" type="hidden">
                </div>
            </form>

            <div class="center">
                <a class="link fancybox-popup_login" href="/#popup_auth" onclick="return hs.htmlExpand(this, { contentId: 'popup_auth' } )">Я вспомнил свой пароль</a>
            </div>
        </div>
    </div>

    <div class="popup" id="popup_pwd_remind-user">
        <a class="popup__close js-popup-close" href="javascript:void(0);">Закрыть</a>

        <div class="popup__title">Восстановление пароля</div>

        <div class="popup__form">
            <form action="/" method="POST" class="direct" data-form="login">
                <div class="popup__error"></div>

                <div class="item">
                    <div class="label">E-mail</div>
                    <input class="input" name="email" type="text" placeholder="Введите ваш e-mail" value>
                    <div class="input-error"></div>
                </div>

                <a class="green-button submit js-form-submit" href="javascript:void(0);">
                    <span class="text">Восстановить пароль</span>
                    <span class="loading"></span>
                </a>

                <input class="hidden" type="submit">

            </form>
        </div>
    </div>

    <div class="loginBox" id="popup_main_done">
        <div class="fancyboxClose"></div>

        <div class="guestStepRegister2a">
            <p class="title">Завершите регистрацию</p>
            <p><span>1</span> Проверьте вашу почту</p>
            <p><span>2</span> Откройте письмо от freecon <i>(проверьте спам)</i></p>
            <p><span>3</span> Пройдите по ссылке в письме</p>
            <a href="/#" onclick="Bm.fancybox.modals.auth.open()">Уже подтвердили?</a>
        </div>
    </div>
    <div class="loginBox" id="popup_main_done_email">
        <div class="fancyboxClose"></div>

        <div class="guestStepRegister2b">
            <p class="title">Завершите регистрацию</p>
            <a href="/#" class="button email-link-js">Проверьте почту</a>
            <p><span>2</span> Откройте письмо от freecon <i>(проверьте спам)</i></p>
            <p><span>3</span> Пройдите по ссылке в письме</p>
            <a href="/#" class="bottom" onclick="Bm.fancybox.modals.auth.open()">Уже подтвердили?</a>
        </div>
    </div>

    <div class="popupBody" id="popup_email_type">
        <div class="socialSelect"></div>
    </div>

    <div class="popupBody" id="popup_password_type">
        <div class="socialSelect"></div>
    </div>
</div>
<div class="hidden">
    <div class="popup" id="popup_callback">
        <a class="popup__close js-popup-close" href="javascript:void(0);">Закрыть</a>

        <div class="popup__title">Заказать обратный звонок</div>

        <div class="popup__form">
            <form action="/callback/" method="POST" class="direct" data-form="callback">
                <div class="popup__text">
                    Заказ обратного звонка возможен круглосуточно. Менеджер перезвонит Вам с 10 до 19 по московскому времени
                </div>

                <div class="popup__error"></div>

                <div class="item">
                    <div class="label">Имя</div>
                    <input class="input" name="name" type="text" placeholder="Введите ваше имя" value>
                    <div class="input-error"></div>
                </div>

                <div class="item">
                    <div class="label">Фамилия</div>
                    <input class="input" name="fio" type="text" placeholder="Введите вашу фамилию" value>
                    <div class="input-error"></div>
                </div>

                <div class="item">
                    <div class="label">Номер телефона</div>
                    <input class="input phone-1" name="phone_country_code" type="text" placeholder="+7" value="+7">
                    <input class="input phone-2" name="phone_code" type="text" placeholder="495" value>
                    <input class="input phone-3" name="phone" type="text" placeholder="1234567" value>
                    <div class="input-error"></div>
                </div>

                <a class="green-button submit js-form-submit" href="javascript:void(0);">
                    <span class="text">Отправить</span>
                    <span class="loading"></span>
                </a>

                <input class="hidden" type="submit">

                <div class="form-agreement">
    <label class="form-agreement__label">
        <input type="hidden" name="is_allowed_calls" value="1">
        <input type="hidden" name="is_allowed_sms" value="0">
        <input type="hidden" name="is_allowed_personal" value="0">
        <input class="form-agreement__checkbox" type="checkbox" name="is_allowed_personal" value="1" checked="checked">
        Да, я согласен получать звонки из клуба и согласен на обработку своих персональных данных.
    </label>
</div>
                <div class="captchaBlock hidden">
                    <span class="label">Введите код с картинки</span>
                    <img src class="captchaImage" height="57">
                    <input name="captchaWord" class="captchaWord form-captcha-input form_input" type="text" placeholder="Введите код с картинки">
                    <input name="captchaCode" class="captchaCode" type="hidden">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function(){
        var $form = $('form[data-form="callback"]'),
            $submit = $form.find('.js-form-submit'),
            from_call;

        $(document).on('click', '#callbackA', function() {
            $('#popup_callback').data('from_call', 'head');
        });
        $(document).on('click', '#callbackB', function() {
            $('#popup_callback').data('from_call', 'footer');
        });

        $('.fancybox-popup_callback').fancybox({
            padding     : 0,
            height		: 'auto',
            width       : 'auto',
            openEffect  : 'none',
            closeEffect : 'none',
            autoSize    : false,
            fitToView   : false,
            closeBtn    : false,
            beforeClose : function() {
                $form.find('.popup__error').empty().hide();
                $form.find('.item .input').removeClass('error');
                $form.find('.item .input-error').empty().hide();
                $('#popup_callback').data('from_call', '');
            }
        });

        $form.on('submit', function() {
            if ($form.hasClass('relogin')) {
                $.ajax({
                    url: $form.attr('logout'),
                    type: 'GET',
                    dataType: 'json'
                });
            }

            Bm.ajax($submit, {
                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $form.find('.popup__error').empty().hide();
                    $form.find('.item .input').removeClass('error');
                    $form.find('.item .input-error').empty().hide();
                },
                success: function(result) {
                    if (result['redirect']) {
                        window.location.href = result['redirect'];
                    } else {
                        if (result.status == 'success_replace' && result.message) {
                            from_call = $('#popup_callback').data('from_call');

                            if (from_call == 'head') {
                                ga('send','event','button','call_back_head_send');
                            } else if (from_call == 'footer') {
                                ga('send','event','button','call_back_footer_send');
                            }

                            $form.html('<div class="popup__text">' + result.message + '</div>');
                        } else if(result.status == 'error') {
                            if (result.rawMessage instanceof Object && result.rawMessage[0] == undefined) {
                                for (var name in result['rawMessage']) {
                                    var $input = $form.find('input[name="' + name + '"]');

                                    for (var i in result['rawMessage'][name]) {
                                        var message = result['rawMessage'][name][i];
                                        break;
                                    }

                                    $input.addClass('error').next('.input-error').text(message).show();
                                }

                                from_call = $('#popup_callback').data('from_call');

                                if (from_call == 'head') {
                                    ga('send', 'event', 'button', 'call_back_head_mistake');
                                } else if (from_call == 'footer') {
                                    ga('send', 'event', 'button', 'call_back_footer_mistake');
                                }

                                if ('need_captcha' in result) {
                                    $form.find('.captchaBlock').removeClass('hidden');
                                    $form.find('.captchaImage').attr('src', result['captcha_url']);
                                    $form.find('.captchaCode').val(result['captcha_code']);
                                } else {
                                    $form.find('.captchaBlock').addClass('hidden');
                                }
                            } else {
                                $form.find('.popup__error').text(result.message).show();
                            }
                        }
                    }
                },
                error: function() {
                    $form.find('.popup__error').text('Ошибка загрузки').show();
                }
            });

            return false;
        });
    });
</script>
</div>


<div class="search-overlay js-search-hide hidden"></div>

<div class="search-popup_block hidden">
    <div class="container">
        <form class="search-popup_input-block direct" action="/search/" method="GET">
            <input name="q" type="text" class="search-popup_input" placeholder="Что ищем?">
            <input type="submit" class="search-popup_submit" value="найти">
        </form>
    </div>
</div><!--script type="text/javascript">
            Bm.user = {
            authorized: false
        };
    </script--><div class="screen-loading hidden">
    <div class="icon"></div>
    <div class="stop js-stop-screen-loading"></div>
</div>




<?
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