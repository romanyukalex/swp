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
<body>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>

<div id="main">
        <!--div class="top-trap">
    <div class="top-trap__content">
        <div class="top-trap__center">
           
            
            <div class="clear"></div>
        </div>
    </div>
</div-->
   
<div class="block1">

  <h1 style=" text-shadow:grey 1px 5px 3px;padding-top: 140px; ">Отдых в Адыгее вместо тура <br> в Египет, Болгарию или Турцию</h1>
  <!--h2 style=" font:bold serif;padding-bottom: 160px; ">Мы соединили преимущества этих мест в одном предложении</h2-->
  <h2 style=" font:bold serif;padding-bottom: 160px; ">Cервис Турции, цена Египта <b>+</b> приключение</h2>
  <a href="#form1" class="button" id="order_link_1">Отправить заявку</a>
</div>

<div class="container center">

<h1>Почему стоит выбрать Адыгею?</h1>
<img src="/project/templates/egypt/files/shar0000.jpg" alt="">
<p>«Отдохнуть от пустых разговоров и глупых понтов. Купаться, загорать. Комфортабельный отдых. <br>Уникальная природа, не сидеть в отеле. <br>Эко-продукты и домашняя кухня.<br> Сохранить фигуру после отдыха. <br>Изучить культуру наших народов.<br>Оздоровиться. <br>Это понравится Вам также, как нашей группе».<br> <span>Викентий. Заезд 2014-08</span></p>
<img src="/project/templates/egypt/files/mov00000.jpg" alt="">
<p style="width:600px;">Заряд энергией побуждает к действию<br>

<span>Туристская компания МИР КАВКАЗА</span></p>
<a class="button" href="#form2" id="order_link_2">Отправить заявку</a>


</div>
<a name="interest"></a>
<div class="sand">
  <!--div style="text-align:center"><h2 style="color:#02d08e">ВАС ИНТЕРЕСУЕТ</h2></div-->
  
  <h3>9 ДНЕЙ</h3>
  <p>спорта и веселья</p>  
  <h3>АКТИВНАЯ АНИМАЦИЯ</h3>
  <p>приключенческий квест</p>
  <h3>ПОЛЕЗНЫЙ ТРЕНИНГ</h3>
  <p>в игровой форме</p>
  <h3>70 ТЫСЯЧ РУБ.</h3>
  <p>+ проезд</p>
  
  <!--<div><h3>Комфортабельный отдых</h3>
  <p>Проживание в отеле с высокой оценкой на всемирно известном сайте путешествий<br>Booking.com - 8.1</p>
  <h3>Купаться, загорать</h3>
  <p>Безлюдные, дикие пляжи, загар держится несколько месяцев</p>
  <h3>Уникальная природа, не сидеть в отеле</h3>
  <p>В заповеднике есть горы, леса, пещеры и бурная река с водопадами.
  <br>Природа биосферного заповедника охраняется Юнеско 
  <!--br>Красота природы очарует Вас--></p>
  
  <!--h3>Эко-продукты и домашняя кухня</h3>
  <p>Вкус знаменитых мясных блюд Адыгов высоко оценивается любителями мяса</p>
  <h3>Сохранить фигуру после отдыха</h3>
  <p>Активный отдых сжигает столько каллорий, что Вы можете не беспокоиться<br>о Вашей красоте</p>
  <h3>Изучить культуру наших народов</h3>
  <p>Квест по мотивам Адыгейских сказок покажет всю колоритность традиций<br>жизни Адыгов</p>
  <h3>Оздоровиться</h3>
  <p>Через 9 дней ваша энергетика увеличится в 3 раза!<br>Вы сможете купаться в водопадах, взбираться по скалам, кататься на велосипедах,<br> париться в бане, сплавляться по рекам на рафтах и много позитива...</p>
  <!--h3>Чтобы дети развивались, отдыхая</h3>
  <p>Никакого арамзамзама! Неожиданные анимационные игры, творческие задания, обучающие программы, развивающие мышление задачи для детей любого возраста</p-->
  <!--h3>Отдохнуть от пустых разговоров и глупых понтов</h3>
  <p>В горах люди становятся душевнее и искреннее</p>
  </div-->
  
  <!--div class="square_block">
    <p class="text">Цена может измениться в любой момент. Количество мест строго ограничено. Запишись в путешествие сегодня!&nbsp;</p>
    <p class="bold_text">Полная оплата до 25 июня 2014 г.</p>
  </div-->
  
  <a class="button" href="#form3" id="order_link_3">Отправьте заявку</a>
  
</div>

<a name="enjoyus"></a>

<div class="block3">

	<h1 class="white" style="text-shadow:grey 1px 1px 5px;">Отдыхайте с нами</h1>
	<p class="white"><br></p>
	<h1 class="white" style="text-shadow:grey 1px 1px 5px;">♦ Оставьте заявку или позвоните♦</h1>
	<p class="white"><a class="button" href="#form4" id="order_link_4">Отправить заявку</a></p>
	<!--h1 class="white" style="text-shadow:black 1px 1px 10px;">♦ Позвоните ♦</h1-->
	<p class="white"><a class="button" href="tel:<?=$contactphone?>"><?=$contactphone?></a></p>
</div>

<!--div class="container"-->

<a name="offerincludes"></a>

<!--div class="block4" style="background: url("sand2000.jpg") repeat scroll top center;"-->

<div class="container">
	<h1 class="black center">Предложение включает:</h1>
	
	<p><span class="blue">♦</span>Проживание в отеле</p>
	<p><span class="blue">♦</span>Питание (всё включено без алкоголя)</p>
	<p><span class="blue">♦</span>Трансфер из г. Краснодар</p>
	<p><span class="blue">♦</span>Услуги сертифицированного проводника Виктора Тимошенко</p>
	<p><span class="blue">♦</span>Услуги врача на всё время пребывания</p>
	<p><span class="blue">♦</span>Страховой полис</p>
	<p><span class="blue">♦</span>Этно-квест по мотивам легенд народов Адыгеи</p>
	<p><span class="green">♦</span>Рафтинг</p>
	<p><span class="green">♦</span>Cкалолазание</p>
	<p><span class="green">♦</span>Cпуск в пещеры</p>
	<p><span class="green">♦</span>Трекинг по плоскогорью</p>
	<p><span class="green">♦</span>Путешествие к водопадам</p>
	<p><span class="green">♦</span>Тренинг</p>
	<a href="#popup_registration" class="fancybox-popup_login button" id="emailspam_registration_button">Узнай фишки проекта</a>
	
	<!--a class="button" href="#form" id="order_link_5">Отправить заявку</a-->
</div>





	
<!--a name="schedule"></a>
<div class="block4" style="background: url("sand2000.jpg") repeat scroll top center;"-->

<!--div class="container">
  <h1 class="black">Даты заездов</h1>
  <div class="square_block">
	<p class="bold_text">&nbsp;&nbsp;5 июня – 14 июня 2015 г.</p>
	<p class="bold_text">19 июня – 28 июня 2015 г.</p>
	<p class="bold_text">&nbsp;&nbsp;3 июля – 12 июля 2015 г.</p>
	<p class="bold_text">17 июля – 26 июля 2015 г.</p>
	<p class="bold_text">&nbsp;&nbsp;7 августа – 16 августа 2015 г.</p>
	<p class="bold_text">21 августа – 30 августа 2015 г.</p>
	<p class="bold_text">&nbsp;&nbsp;4 сентября – 13 сентября 2015 г.</p>
	<p class="bold_text">18 сентября – 27 сентября 2015 г.</p>
	
	</div>
	<br>
</div-->
	
<div class="container center">
<img src="project/templates/egypt/files/formal00.png" alt="">

	<br><br><br><br>
	<h4>ДАТЫ ЗАЕЗДОВ</h4>
	<div class="square_block">
	<p>&nbsp;5 июня – 14 июня 2015 г.</p>
	<p>19 июня – 28 июня 2015 г.</p>
	<p>&nbsp;3 июля – 12 июля 2015 г.</p>
	<p>17 июля – 26 июля 2015 г.</p>
	<p>&nbsp;7 августа – 16 августа 2015 г.</p>
	<p>21 августа – 30 августа 2015 г.</p>
	<p>&nbsp;4 сентября – 13 сентября 2015 г.</p>
	<p>18 сентября – 27 сентября 2015 г.</p>
	</div>
	<h4>МЕСТО ПРОВЕДЕНИЯ КВЕСТА</h4>
	
	<p> Кавказский государственный природный биосферный заповедник имени Х. Г. Шапошникова. Самая большая по территории и старейшая особо охраняемая природная территория на Северном Кавказе.</p>
	<h4>ФОРМАТ ПУТЕШЕСТВИЯ</h4>
	<p>1 день: приезд, расположение в отеле, знакомство, посиделки у костра на берегу горной реки; 
	3 дня : туристический квест;
	1 день: психологическая игра;
	4 дня: туристический квест;
	1 день: сборы и отъезд.
	</p>
	<h4>ПРОЖИВАНИЕ</h4>
	<p>В стилизованном отеле с красивой прилегающей территорией, выполненном в зодчем стиле. Расположен он на берегу горной реки. Уровень отеля и сервиса таков, что в него хочется возвращаться самому и не стыдно порекомендовать друзьям</p>
	<h4>ПИТАНИЕ</h4>
	<p>Сбалансированное здоровое трехразовое питание, необходимое для участников активной программы, вкусное, приготовленное как для своих детей</p>
	<h4>ДОПОЛНИТЕЛЬНО</h4>
	<p>В отеле можно попрыгать на батуте, поплавать в бассейне, попариться в баньке, взять велики напрокат, развести костер на берегу реки, пожарить шашлыки на мангале, а можно просто уединиться с чашечкой свежее сваренного кофе, послушать шум горной реки, поднять голову и увидеть россыпь звезд и понять, что ты счастлив!</p>
	<a class="button" href="#form6" id="order_link_6">Отправить заявку</a>
	
</div>

<div class="block5">

<h1 class="black">СТОИМОСТЬ ПРЕДЛОЖЕНИЯ</h1>
<div style="width: 1000px; margin: 0 auto;">
<div class="mark">
<p class="mark_text">Раннее бронирование</p>
<p class="green">За 3 месяца до даты заезда</p>
<p class="price">60 т.р.</p>
<a class="button small" href="#form71" id="order_link_71">Заказать</a></div>
<div class="mark" style="margin-left: 40px; margin-right: 40px;">
<p class="mark_text" style="margin: 0 0px 0 0px;">Стандартное бронирование</p>
<p class="green">За 2 месяца до даты заезда</p>
<p class="price">70 т.р.</p>
<a class="button small" href="#form72"id="order_link_72">Заказать</a></div>
<div class="mark">
<p class="mark_text">Горящее бронирование</p>
<p class="green">За 1 месяц до даты заезда</p>
<p class="price">80 т.р.</p>
<a class="button small" href="#form73"id="order_link_73">Заказать</a></div>
<div class="clear">&nbsp;</div>
</div>
</div>

<a name="form1"></a>
<a name="form2"></a>
<a name="form3"></a>
<a name="form4"></a>
<a name="form6"></a>
<a name="form71"></a>
<a name="form72"></a>
<a name="form73"></a>

<div class="form_block" style="padding: 180px 0">

  <div class="post">
    <div class="b_form_content">
        <h5 class="ta_c">Регистрация на мероприятие</h5>
		
		<a onclick="ga('send','event','button','call_back_footer');" class="fancybox-popup_callback order_call button" href="#popup_callback" id="callbackA">Закажите звонок</a>

    </div>
    </div>
	
</div>

</div> <!-- main -->

<div id="footer">
<div class="container">
				<div class="footer_group">
	   
		<ul style="width: 222px;" class="footer_list">
			<li class="title"><a href="http://mirkavkaza2012.ru/" target="_blank">Что такое МИР КАВКАЗА</a></li>
			
		</ul>
		<ul style="width: 130px;" class="footer_list">
			<li class="title"><a href="https://vk.com/club84222003" target="_blank">Мы в ВКонтакте</a></li>
			
		</ul>
		<!--ul style="width: 142px;" class="footer_list">
			<li class="title"><a href="/knowledge/">База знаний</a></li>
			
		</ul-->
		<ul style="width: 172px;" class="footer_list">
			<li class="title"><a href="/#schedule">Расписание</a></li>
		  
		</ul>
		<!--ul style="width: 207px;" class="footer_list">
			<li class="title"><a href="/services/">СЕРВИСЫ ДЛЯ БИЗНЕСА</a></li>
		
		</ul>
		<ul style="width: 139px;" class="footer_list">
			<li class="title"><a href="/mg/about/">Мастер-группа</a></li>
		   
		</ul-->
	</div>
	<div class="footer_group appFoot">
		<div class="footer_inn">
		Общество с ограниченной ответственностью «Мир Кавказа»<br>
		<a href="http://maps.yandex.ru/?text=%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F%2C%20%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0%20%D0%90%D0%B4%D1%8B%D0%B3%D0%B5%D1%8F%2C%20%D0%9C%D0%B0%D0%B9%D0%BA%D0%BE%D0%BF%D1%81%D0%BA%D0%B8%D0%B9%20%D1%80%D0%B0%D0%B9%D0%BE%D0%BD%2C%20%D0%BF%D0%BE%D1%81%D0%B5%D0%BB%D0%BE%D0%BA%20%D0%9A%D0%B0%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D0%BC%D0%BE%D1%81%D1%82%D1%81%D0%BA%D0%B8%D0%B9%2C%20%D0%92%D0%B5%D1%80%D1%85%D0%BD%D0%B8%D0%B9%20%D0%BF%D0%B5%D1%80%D0%B5%D1%83%D0%BB%D0%BE%D0%BA&sll=40.185973%2C44.290247&ll=40.185973%2C44.290247&spn=0.011008%2C0.004431&z=17&l=map" target="_blank">Республика Адыгея, Майкопский р-н, п. Каменномостский, пер. Верхний, 9</a><br>
Skype: <a href="skype:mir_kavkaza?chat">mir_kavkaza</a><br>
Email: <a href="mailto:vk-2011@mail.ru">vk-2011@mail.ru</a>
<br><br>
			<!--a class="footer_inn-link" href="/confidential/">Политика конфиденциальности</a>
			<a class="footer_inn-link" href="/bm/poleznoe/">Полезное</a>
			<a class="footer_inn-link" href="/bm/dictionary/">Словарь</a-->
		</div>
		<div class="footer_phone-block">
			<p class="footer_phone-text">
				<a href="tel:<?=$contactphone?>" style="color:#999999"><?=$contactphone?></a>
			</p>
			<a onclick="ga('send','event','button','call_back_footer');" class="footer_phone-link fancybox-popup_callback order_call" href="#popup_callback" id="callbackB">заказать звонок</a>

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
    <div class="loginBox" id="popup_auth">
        <div class="fancyboxClose"></div>

        <div class="loginBox__title hidden">
            Для получения доступа к полному содержанию материала войдите или зарегистрируйтесь
<!--            <span class="sub">Полное содержание данного материала доступно только для авторизованных пользователей.</span>-->
        </div>

        <ul class="loginBox_items">
            <!--li class="item active">
                Войдите
            </li>
            или-->
            <li class="item">
                <a href="#popup_registration" class="fancybox-popup_login">Зарегистрируйтесь</a>
            </li>
        </ul>
        <div class="loginBox_content">
            <form action="/login/" method="POST" class="direct" data-form="login">
                <div class="error_text"></div>
                <ul>
                    <li>
                        <span class="loginBox__label">E-MAIL</span>
                        <input name="login" type="text" placeholder="Например: ivanov@ivan.ru" class="form_input">
                    </li>
                    <li>
                        <span class="loginBox__label">ПАРОЛЬ</span>
                        <input name="password" type="password" placeholder="Пароль" class="form_input">
                        <a href="#popup_pwd_remind" class="fancybox-popup_login notpass">Я забыл свой пароль</a>
                    </li>
                    <li><button type="submit" class="form_btn">Войти</button></li>
                </ul>
                <input type="hidden" name="success_url" value="/mg/events/madagascar/">

                <a class="loginBox__bottom hidden go_to_available_materials" href="javascript: void(0)">Перейти к списку доступных материалов</a>
            </form>
            <!--ul class="loginBox_social">
                <li class="title">или войдите через</li>
                <li><a class="vk" href="/social/auth/vkontakte/" data-social="authorization"></a></li>
                <li><a class="facebook" href="/social/auth/facebook/" data-social="authorization"></a></li>
                <li><a class="mail" href="/social/auth/mail_ru/"  data-social="authorization"></a></li>
                <li><a class="odnk" href="/social/auth/odnoklassniki/" data-social="authorization"></a></li>
                <li><a class="google" href="/social/auth/google_plus/" data-social="authorization"></a></li>
                <li><a class="yandex" href="/social/auth/twitter/" data-social="authorization"></a></li>
            </ul-->
        </div>
    </div>
    <div class="loginBox" id="popup_registration">
        <div class="fancyboxClose"></div>

        <div class="loginBox__title hidden">
            Для получения доступа к полному содержанию материала войдите или зарегистрируйтесь
<!--            <span class="sub">Полное содержание данного материала доступно только для авторизованных пользователей.</span>-->
        </div>

        <ul class="loginBox_items">
            <!--li class="item">
                <a href="#popup_auth" class="fancybox-popup_login">Войдите</a>
            </li>
            или-->
            <li class="item active">
                Следить за проектом можно по Email
            </li>
        </ul>
        <div class="loginBox_content">
		
		
	<form action="/" method="POST" class="direct" data-form="login" id="subscribe_form">
                <div class="error_text" id="follow_mp"></div>
                <ul>
                    <li>
                        <span class="loginBox__label">E-MAIL</span>
                        
						<?//insert_module("form_generator","show_form","register");
						//insert_module("start_site_subscribe");
						?>
						
						<input name="email" type="text" placeholder="Например: ivanov@ivan.ru" class="form_input">
                        <input type="hidden" name="register_page" value="/:popup" />
                    </li>
                    <li><button type="submit" class="form_btn" onClick="saveform2('','subscribe_form','follow_mp','start_site_subscribe','','','');return false;">Следить</button></li>
                    <div class="form-agreement">
    <? $_SESSION['checksubsribeform']=rand(5,5555555);?>
	<input type="hidden" value="<?=$_SESSION['checksubsribeform']?>" name="chid" id="chid"/>
	<input type="hidden" name="is_allowed_email" value="0" />
    <input type="hidden" name="is_allowed_personal" value="0" />
    <!--label class="form-agreement__label">
        <input class="js-form-agreement-children form-agreement__checkbox" type="checkbox" name="is_allowed_personal"
               value="1" checked="checked" onchange="if(!this.checked) alert('Вы должны дать согласие на обработку персональных данных')" />
        Я даю свое согласие на обработку персональных данных и соглашаюсь с условиями и политикой конфиденциальности <br/>
    </label-->
    <label class="form-agreement__label">
        <input class="js-form-agreement-children form-agreement__checkbox" type="checkbox" name="is_allowed_email" value="1" checked="checked" />
        Я хочу получать email-письма о мероприятиях и/или иных услугах
    </label>
</div>                </ul>

                <a class="loginBox__bottom hidden go_to_available_materials" href="javascript: void(0)">Перейти к списку доступных материалов</a>
            </form>
			
			
			
			
			
			
			
			
			
			
            <!--ul class="loginBox_social">
                <li class="title">или зарегистрируйтесь через</li>
                <li><a class="vk" href="/social/auth/vkontakte/" data-social="authorization"></a></li>
                <li><a class="facebook" href="/social/auth/facebook/" data-social="authorization"></a></li>
                <li><a class="mail" href="/social/auth/mail_ru/"  data-social="authorization"></a></li>
                <li><a class="odnk" href="/social/auth/odnoklassniki/" data-social="authorization"></a></li>
                <li><a class="google" href="/social/auth/google_plus/" data-social="authorization"></a></li>
                <li><a class="yandex" href="/social/auth/twitter/" data-social="authorization"></a></li>
            </ul-->
        </div>
    </div>
    <div class="loginBox" id="popup_pwd_remind">
        <div class="fancyboxClose"></div>

        <div class="loginBox_content">
            <div class="password">
                <form action="/user/passrecover/" method="POST" class="direct" data-form="login">
                    <ul>
                        <li class="password_title">Восстановление пароля</li>
                        <li><div class="error_text"></div></li>
                        <li>
                            <span class="loginBox__label">E-MAIL</span>
                            <input name="email" type="text" placeholder="Например: ivanov@ivan.ru" class="form_input" />
                            <a href="#popup_auth" class="fancybox-popup_login notpass">Авторизоваться</a>
                        </li>
                        <li>
                             <div class="captchaBlock hidden">
                                 <img src="" class="captchaImage" />
                                 <input name="captchaWord" class="captchaWord form_input" type="text" placeholder="Введите код с картинки">
                                 <input name="captchaCode" class="captchaCode" type="hidden">
                             </div>
                         </li>
                        <li><button type="submit" class="form_btn">Восстановить пароль</button></li>
                    </ul>
                </form>
            </div>

        </div>
    </div>
    <div class="loginBox" id="popup_main_done">
        <div class="fancyboxClose"></div>

        <div class="guestStepRegister2a">
            <p class="title">Завершите регистрацию</p>
            <p><span>1</span> Проверьте вашу почту</p>
            <p><span>2</span> Откройте письмо от нас <i>(проверьте спам)</i></p>
            <p><span>3</span> Пройдите по ссылке в письме</p>
            <a href="#" onclick="Bm.fancybox.modals.auth.open()">Уже подтвердили?</a>
        </div>
    </div>
    <div class="loginBox" id="popup_main_done_email">
        <div class="fancyboxClose"></div>

        <div class="guestStepRegister2b">
            <p class="title">Завершите регистрацию</p>
            <a href="#" class="button email-link-js">Проверьте почту</a>
            <p><span>2</span> Откройте письмо от нас <i>(проверьте спам)</i></p>
            <p><span>3</span> Пройдите по ссылке в письме</p>
            <a href="#" class="bottom" onclick="Bm.fancybox.modals.auth.open()">Уже подтвердили?</a>
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
    <div id="popup_callback">
        <div class="fancyboxClose"></div>

        <h4>Заказать программу</h4>

		
		<? //insert_module("form_generator","show_form","egypt_order");	?>
		
		
		
        <p>Заказ обратного звонка возможен круглосуточно.<br>Менеджер перезвонит Вам с 10 до 19<br>по московскому времени</p>

        <form action="/" method="POST" class="callback-form-js direct" id="new_order_form">
            <div class="error_text" id="new_order_form_ap"></div>
            <div class="name">
                <span class="label">Имя</span>
                <input type="text" name="1" value="" placeholder="Иван" />
            </div>
            <div class="surname">
                <span class="label">Фамилия</span>
                <input type="text" name="2" value="" placeholder="Иванов" />
            </div>

            <div class="clear"></div>
			<div class="surname">
                <span class="label">Ваш город</span>
                <input type="text" name="3" value="" placeholder="Москва" />
            </div>

            <div class="clear"></div>
            <div class="phone">
                <span class="label">Введите ваш телефон</span>
                <input type="text" class="countryCode" name="4" value="+7" placeholder="+7" />
                <input type="text" class="cityCode" name="7" value="" placeholder="123" />
                <input type="text" class="number" name="8" value="" placeholder="4567890" />

                <div class="clear"></div>
            </div>

            <div class="form-agreement">
    <label class="form-agreement__label">
        <input type="hidden" name="is_allowed_calls" value="1" />
        <input type="hidden" name="is_allowed_sms" value="0" />
		<input type="hidden" name="6" value="<?=$_SERVER['HTTP_HOST']?>" />
        <input class="form-agreement__checkbox" type="checkbox" name="5" value="1" checked="checked" />
        Да, я согласен получать звонки и согласен на обработку своих персональных данных.
    </label>
</div>
            <div class="captchaBlock hidden">
                <span class="label">Введите код с картинки</span>
                <img src="" class="captchaImage" height="57" />
                <input name="captchaWord" class="captchaWord form-captcha-input form_input" type="text" placeholder="Введите код с картинки">
                <input name="captchaCode" class="captchaCode" type="hidden">
            </div>
            
            <input type="submit" value="Отправить" onclick="saveform2('egypt_order','new_order_form','new_order_form_ap','form_generator','add','resetform','');return false;" />
        </form>
    </div>
</div>

<script>
    $(function(){
        $pref = $('#prefered_time');
        var val = $pref.val();
        $pref.on('focus', function(e){
            if($pref.val() == val) {
                $pref.val('');
            }
        });
        $pref.on('blur', function(e){
            if($pref.val() == '') {
                $pref.val(val);
            }
        });

        $(document).on('click', '#callbackA', function(){
            $('#popup_callback').data('from_call','head');
        });
        $(document).on('click', '#callbackB', function(){
            $('#popup_callback').data('from_call','footer');
        });
        if($.fn.fancybox){
            $('.fancybox-popup_callback').fancybox({
                margin: 0,
                changeSpeed: 200,
                closeBtn: false,
                beforeClose : function() {
                    $('#popup_callback').find('.error_text').html('');
                    $('#popup_callback').data('from_call','');
                }

            });
        }

        var $form = $('form.callback-form-js').first();
        $form.on('submit', function( e )
        {
            e.preventDefault();
            if($form.hasClass('relogin')) {
                $.ajax({
                    url: $form.attr('logout'),
                    type: 'GET',
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    headers: {'X-Requested-With': 'XMLHttpRequest'}});
            }

            $form.find('input[type=submit]').css('visibility', 'hidden');

            $.ajax({

                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function( result )
                {
                    if( result['redirect'] )
                    {
                        window.location.href = result['redirect'];
                    } else
                    {
                        if('success_replace' == result['status'] && result['message']) {
                            from_call =  $('#popup_callback').data('from_call');
                            if(from_call=='head') {
                                ga('send','event','button','call_back_head_send');
                            }else if(from_call=='footer') {
                                ga('send','event','button','call_back_footer_send');
                            }
                            $form.html(result['message']);
                        }
                        else if( 'success' == result['status'] && result['message'] ) {
                            from_call =  $('#popup_callback').data('from_call');
                            if(from_call=='head') {
                                ga('send','event','button','call_back_head_send');
                            }else if(from_call=='footer') {
                                ga('send','event','button','call_back_footer_send');
                            }
                            $form.find('.error_text').text(result['message']).show();
                            $('.captchaBlock').addClass('hidden');
                        } else if( 'error' == result['status'] ) {
                            from_call =  $('#popup_callback').data('from_call');
                            if(from_call=='head') {
                                ga('send','event','button','call_back_head_mistake');
                            }else if(from_call=='footer') {
                                ga('send','event','button','call_back_footer_mistake');
                            }
                            if ("need_captcha" in result) {
                                $form.find('.captchaBlock').removeClass('hidden');
                                $form.find('.captchaImage').attr('src', result['captcha_url']);
                                $form.find('.captchaCode').val(result['captcha_code']);
                            }
                            else {
                                $form.find('.captchaBlock').addClass('hidden');
                            }
                            $form.find('.error_text').text('Ошибка: ' + result['message']).show();
                        }
                        $form.find('input[type=submit]').css('visibility', 'visible');
                    }
                },
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).error(function( jqXHR )
                {
                    $form.find('input[type=submit]').css('visibility', 'visible');
                    $form.find('.error_text').text('Ошибка загрузки').show();
                });

            return false;
        });

    });
</script>
</div>

</body>
<?
#####################################
# // Body							#
#####################################

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