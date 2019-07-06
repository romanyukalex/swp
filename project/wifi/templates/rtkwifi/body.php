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
<body class="p-body">
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>

<div class="p-sideslide__inner">
    <div id="mq_helper" class="mq-helper"></div>
    <div class="p-wrap p-sideslide-center p-wrap_b2b">
        <div class="p-section p-section_bg-lightgray">
    <div class="location-box">
        <div class="p-section p-section_bg-white">
            <div class="location-top">
                <div class="c-wrap">
                    <div class="units-row units-split">
                        <div class="location-top__searchwrap unit-5">
                            <div class="btn-group btn-group_width-full">
                                <input class="input-clear input-search location-top__inputsearch" id="location-top__inputsearch" type="text" name="search" autocomplete="off" placeholder="Поиск населенного пункта">
                                <button class="btn location-top__searchbtn" type="submit"></button>
                            </div>
                            <div class="location-top__helpsearch">
                                <p class="location-top__helptxt">
                                    <i class="spinner-circle-blue spinner-circle-blue_inline-block"></i>
                                    Пожалуйста, подождите.
                                </p>
                                <ul class="location-top__helplist">
                                    <li class="location-top__helplist-item"></li>
                                </ul>
                            </div>
                        </div>
                        <label class="location-top__label unit-7" for="location-top__inputsearch">
                            — Вы можете быстро найти свой населенный пункт по названию.
                        </label>
                    </div>
                    </div>
                <div class="location-top__close"></div>
            </div>
        </div>

        <div class="c-wrap">
            <div class="units-row units-split">
                <dl class="location-list unit-3">
                    <dt class="location-list__head">А</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('01');" href="javascript:;">Адыгея Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('04');" href="javascript:;">Алтай Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('22');" href="javascript:;">Алтайский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('28');" href="javascript:;">Амурская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('29');" href="javascript:;">Архангельская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('30');" href="javascript:;">Астраханская область</a>
                        </dd>
                    <dt class="location-list__head">Б</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('02');" href="javascript:;">Башкортостан Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('31');" href="javascript:;">Белгородская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('32');" href="javascript:;">Брянская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('03');" href="javascript:;">Бурятия Республика</a>
                        </dd>
                    <dt class="location-list__head">В</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('33');" href="javascript:;">Владимирская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('34');" href="javascript:;">Волгоградская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('35');" href="javascript:;">Вологодская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('36');" href="javascript:;">Воронежская область</a>
                        </dd>
                    <dt class="location-list__head">Д</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('05');" href="javascript:;">Дагестан Республика</a>
                        </dd>
                    <dt class="location-list__head">Е</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('79');" href="javascript:;">Еврейская АО</a>
                        </dd>
                    <dt class="location-list__head">З</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('75');" href="javascript:;">Забайкальский край</a>
                        </dd>
                    <dt class="location-list__head">И</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('37');" href="javascript:;">Ивановская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('06');" href="javascript:;">Ингушетия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('38');" href="javascript:;">Иркутская область</a>
                        </dd>
                    <dt class="location-list__head">К</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('07');" href="javascript:;">Кабардино-Балкария Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('39');" href="javascript:;">Калининградская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('08');" href="javascript:;">Калмыкия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('40');" href="javascript:;">Калужская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('41');" href="javascript:;">Камчатский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('09');" href="javascript:;">Карачаево-Черкесия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('10');" href="javascript:;">Карелия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('42');" href="javascript:;">Кемеровская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('43');" href="javascript:;">Кировская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('11');" href="javascript:;">Коми Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('44');" href="javascript:;">Костромская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('23');" href="javascript:;">Краснодарский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('24');" href="javascript:;">Красноярский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('45');" href="javascript:;">Курганская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('46');" href="javascript:;">Курская область</a>
                        </dd>
                    <dt class="location-list__head">Л</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('47');" href="javascript:;">Ленинградская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('48');" href="javascript:;">Липецкая область</a>
                        </dd>
                    <dt class="location-list__head">М</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('49');" href="javascript:;">Магаданская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('12');" href="javascript:;">Марий Эл Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('13');" href="javascript:;">Мордовия Республика</a>
                        <a class="location-list__link location-list__link_state-act" onclick="window.adrMgr.show('77');" href="javascript:;">Москва</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('50');" href="javascript:;">Московская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('51');" href="javascript:;">Мурманская область</a>
                        </dd>
                    <dt class="location-list__head">Н</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('52');" href="javascript:;">Нижегородская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('53');" href="javascript:;">Новгородская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('54');" href="javascript:;">Новосибирская область</a>
                        </dd>
                    <dt class="location-list__head">О</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('55');" href="javascript:;">Омская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('56');" href="javascript:;">Оренбургская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('57');" href="javascript:;">Орловская область</a>
                        </dd>
                    <dt class="location-list__head">П</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('58');" href="javascript:;">Пензенская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('59');" href="javascript:;">Пермский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('25');" href="javascript:;">Приморский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('60');" href="javascript:;">Псковская область</a>
                        </dd>
                    <dt class="location-list__head">Р</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('61');" href="javascript:;">Ростовская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('62');" href="javascript:;">Рязанская область</a>
                        </dd>
                    <dt class="location-list__head">С</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('63');" href="javascript:;">Самарская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('78');" href="javascript:;">Санкт-Петербург</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('64');" href="javascript:;">Саратовская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('14');" href="javascript:;">Саха (Якутия) Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('65');" href="javascript:;">Сахалинская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('66');" href="javascript:;">Свердловская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('15');" href="javascript:;">Северная Осетия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('67');" href="javascript:;">Смоленская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('26');" href="javascript:;">Ставропольский край</a>
                        </dd>
                    <dt class="location-list__head">Т</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('68');" href="javascript:;">Тамбовская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('16');" href="javascript:;">Татарстан Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('69');" href="javascript:;">Тверская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('70');" href="javascript:;">Томская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('71');" href="javascript:;">Тульская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('17');" href="javascript:;">Тыва Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('72');" href="javascript:;">Тюменская область</a>
                        </dd>
                    <dt class="location-list__head">У</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('18');" href="javascript:;">Удмуртская Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('73');" href="javascript:;">Ульяновская область</a>
                        </dd>
                    <dt class="location-list__head">Х</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('27');" href="javascript:;">Хабаровский край</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('19');" href="javascript:;">Хакасия Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('86');" href="javascript:;">Ханты-Мансийский АО</a>
                        </dd>
                    <dt class="location-list__head">Ч</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('74');" href="javascript:;">Челябинская область</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('21');" href="javascript:;">Чувашская Республика</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('87');" href="javascript:;">Чукотский АО</a>
                        </dd>
                    <dt class="location-list__head">Я</dt>
                    <dd class="location-list__body">
                        <a class="location-list__link " onclick="window.adrMgr.show('89');" href="javascript:;">Ямало-Ненецкий АО</a>
                        <a class="location-list__link " onclick="window.adrMgr.show('76');" href="javascript:;">Ярославская область</a>
                        </dd>
                    </dl>

                <section class="location-expd unit-8">
                    <h1 class="location-expd__head head-18b" id="dt_cities_title">Москва</h1>

                    <div class="location-expd__list" id="dt_cities_list">
                        <div class="unit-25">
                            <ul class="location-expd__first-list">
                                <li class="location-expd__item location-expd__item_first-item">
                                    <strong><a href="http://moscow.rt.ru/b2bcorp/cabinet" class="location-expd__cur-link">Москва</a>
                                    </strong></li>
                                <li class="location-expd__item ">
                                    <strong><a href="http://moscow.rt.ru/zelenograd/b2bcorp/cabinet" class="location-expd__link">Зеленоград</a>
                                    </strong></li>
                                <li class="location-expd__item ">
                                    <strong><a href="http://moscow.rt.ru/moskovskij/b2bcorp/cabinet" class="location-expd__link">Московский</a>
                                    </strong></li>
                                <li class="location-expd__item ">
                                    <strong><a href="http://moscow.rt.ru/moskvatroick/b2bcorp/cabinet" class="location-expd__link">Троицк</a>
                                    </strong></li>
                                <li class="location-expd__item ">
                                    <strong><a href="http://moscow.rt.ru/shherbinka/b2bcorp/cabinet" class="location-expd__link">Щербинка</a>
                                    </strong></li>
                                </ul>
                        </div>
                        <span class="location-expd__search btn-txt">Другой населенный пункт</span>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<div class="location">

    <div class="location__body">
        <div class="location__head" style="margin-top: -50px;">
            <h2 class="location__title pre-ico-region-blue">Регион</h2>

            <div class="location__search-wrap">
                <input class="location__search-input" type="text" data-fake="true" id="mb_cities_search2" placeholder="Поиск населенного пункта">
                <div class="location__search-ico"></div>
            </div>

            <div id="loc_box_close" class="location__close"></div>
        </div>
        <div class="location__srollbox">
            <ul class="location__regions-list">
                <li class="location__regions-capital">А</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('01', true);" href="javascript:;">Адыгея Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('04', true);" href="javascript:;">Алтай Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('22', true);" href="javascript:;">Алтайский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('28', true);" href="javascript:;">Амурская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('29', true);" href="javascript:;">Архангельская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('30', true);" href="javascript:;">Астраханская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Б</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('02', true);" href="javascript:;">Башкортостан Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('31', true);" href="javascript:;">Белгородская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('32', true);" href="javascript:;">Брянская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('03', true);" href="javascript:;">Бурятия Республика</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">В</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('33', true);" href="javascript:;">Владимирская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('34', true);" href="javascript:;">Волгоградская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('35', true);" href="javascript:;">Вологодская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('36', true);" href="javascript:;">Воронежская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Д</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('05', true);" href="javascript:;">Дагестан Республика</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Е</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('79', true);" href="javascript:;">Еврейская АО</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">З</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('75', true);" href="javascript:;">Забайкальский край</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">И</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('37', true);" href="javascript:;">Ивановская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('06', true);" href="javascript:;">Ингушетия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('38', true);" href="javascript:;">Иркутская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">К</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('07', true);" href="javascript:;">Кабардино-Балкария Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('39', true);" href="javascript:;">Калининградская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('08', true);" href="javascript:;">Калмыкия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('40', true);" href="javascript:;">Калужская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('41', true);" href="javascript:;">Камчатский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('09', true);" href="javascript:;">Карачаево-Черкесия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('10', true);" href="javascript:;">Карелия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('42', true);" href="javascript:;">Кемеровская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('43', true);" href="javascript:;">Кировская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('11', true);" href="javascript:;">Коми Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('44', true);" href="javascript:;">Костромская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('23', true);" href="javascript:;">Краснодарский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('24', true);" href="javascript:;">Красноярский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('45', true);" href="javascript:;">Курганская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('46', true);" href="javascript:;">Курская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Л</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('47', true);" href="javascript:;">Ленинградская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('48', true);" href="javascript:;">Липецкая область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">М</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('49', true);" href="javascript:;">Магаданская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('12', true);" href="javascript:;">Марий Эл Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('13', true);" href="javascript:;">Мордовия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('77', true);" href="javascript:;">Москва</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('50', true);" href="javascript:;">Московская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('51', true);" href="javascript:;">Мурманская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Н</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('52', true);" href="javascript:;">Нижегородская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('53', true);" href="javascript:;">Новгородская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('54', true);" href="javascript:;">Новосибирская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">О</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('55', true);" href="javascript:;">Омская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('56', true);" href="javascript:;">Оренбургская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('57', true);" href="javascript:;">Орловская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">П</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('58', true);" href="javascript:;">Пензенская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('59', true);" href="javascript:;">Пермский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('25', true);" href="javascript:;">Приморский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('60', true);" href="javascript:;">Псковская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Р</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('61', true);" href="javascript:;">Ростовская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('62', true);" href="javascript:;">Рязанская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">С</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('63', true);" href="javascript:;">Самарская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('78', true);" href="javascript:;">Санкт-Петербург</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('64', true);" href="javascript:;">Саратовская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('14', true);" href="javascript:;">Саха (Якутия) Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('65', true);" href="javascript:;">Сахалинская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('66', true);" href="javascript:;">Свердловская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('15', true);" href="javascript:;">Северная Осетия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('67', true);" href="javascript:;">Смоленская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('26', true);" href="javascript:;">Ставропольский край</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Т</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('68', true);" href="javascript:;">Тамбовская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('16', true);" href="javascript:;">Татарстан Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('69', true);" href="javascript:;">Тверская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('70', true);" href="javascript:;">Томская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('71', true);" href="javascript:;">Тульская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('17', true);" href="javascript:;">Тыва Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('72', true);" href="javascript:;">Тюменская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">У</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('18', true);" href="javascript:;">Удмуртская Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('73', true);" href="javascript:;">Ульяновская область</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Х</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('27', true);" href="javascript:;">Хабаровский край</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('19', true);" href="javascript:;">Хакасия Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('86', true);" href="javascript:;">Ханты-Мансийский АО</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Ч</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('74', true);" href="javascript:;">Челябинская область</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('21', true);" href="javascript:;">Чувашская Республика</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('87', true);" href="javascript:;">Чукотский АО</a>
                        </li>
                </ul>
            <ul class="location__regions-list">
                <li class="location__regions-capital">Я</li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('89', true);" href="javascript:;">Ямало-Ненецкий АО</a>
                        </li>
                <li class="location__regions-item">
                            <a onclick="window.adrMgr.show('76', true);" href="javascript:;">Ярославская область</a>
                        </li>
                </ul>
            <ul class="location__cities-list">

            </ul>
        </div>
    </div>
    <div id="mobile_city_list" class="location" reg>

        <div class="location__body location__body_level-2">
            <div class="location__head location__head_level-2">
                <h2 class="location__title" id="mb_cities_title">Москва</h2>

                <div class="location__search-wrap">
                    <input class="location__search-input" id="mb_cities_search" type="text" placeholder="Поиск населенного пункта">
                    <div class="location__search-ico"></div>
                </div>
                
                <div class="location__close"></div>
            </div>
            <div class="location__srollbox" id="mb_cities_list">
                <ul class="location__cities-list">
                    <li class="location__cities-capital">
                        <a href="http://moscow.rt.ru/moscow/b2bcorp/cabinet">Москва</a>
                    </li>
                    <li>
                        <a href="http://moscow.rt.ru/zelenograd/b2bcorp/cabinet">/Зеленоград</a>
                    </li>
                    <li>
                        <a href="http://moscow.rt.ru/moskovskij/b2bcorp/cabinet">/Московский</a>
                    </li>
                    <li>
                        <a href="http://moscow.rt.ru/moskvatroick/b2bcorp/cabinet">/Троицк</a>
                    </li>
                    <li>
                        <a href="http://moscow.rt.ru/shherbinka/b2bcorp/cabinet">/Щербинка</a>
                    </li>
                    </ul>
            </div>
        </div>
    </div>
</div>
<script>
    
    var adrMgr = {
        regCities: {},
        regions: [],
        

                
        show: function (regKlId, isMobile) {
            if (stat){
                stat.fixStat('change_region');
            }
            if (this.regCities !== null && this.regCities !== undefined &&
                    this.regCities[regKlId] !== null && this.regCities[regKlId] !== undefined) {
                this.render(regKlId);

                if (isMobile) {
                    $("#mobile_city_list").setMod('inner', 'active');
                    mobileSidebarShift($('.location').eq(0), 'left');
                    $("#mobile_city_list").attr("reg", regKlId);
                }
            } else {
                var regCode = regKlId;

                $.ajax({
                    url: '/ajax/getRegionCity',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        regKlId: regCode,
                        usePonFilter: false
                    },
                    async: true,
                    cache: false,
                    success: function (resp) {
                        adrMgr.regCities[regCode] = resp.result;
                        adrMgr.render(regCode);

                        if (isMobile) {
                            $("#mobile_city_list").setMod('inner', 'active');
                            mobileSidebarShift($('.location').eq(0), 'left');
                            $("#mobile_city_list").attr("reg", regCode);
                        }

                        $('a.location-expd__link, #mb_cities_list a').on('click', function (e) {
                            e.preventDefault();
                            stat.fixStat('change_city');
                            utils.sendPostWithUserCollector(this.href, {});
                        });
                    }
                });
            }
            return false;
        },

        
        render: function (regKlId) {
            if (this.regCities != null && this.regCities !== undefined &&
                    this.regCities[regKlId] != null && this.regCities[regKlId] !== undefined) {
                var cityList = this.regCities[regKlId];
                var dtHtml = "";
                var mbHtml = "";
                var unit25Idx = 0;
                for (var i = 0; i < cityList.length;) {

                    if (unit25Idx++ >= 4) break;

                    var idx = 0;
                    dtHtml += '<div class="unit-25">'
                    if (i == 0) {
                        dtHtml += '<ul class="location-expd__first-list">';
                    } else {
                        dtHtml += '<ul>';
                    }
                    while (i < cityList.length && idx++ < 14) {
                        var city = cityList[i++];
                        var selectStyle = "location-expd__link";
                        if (regKlId === '77' && city.id == this.selectedCity.id) {
                            selectStyle = "location-expd__cur-link";
                        }
                        if (city.synonym == adrMgr.regions[regKlId].synonym) {
                            idx++;
                        }
                        if (i == 1) {
                            dtHtml += '<li class="location-expd__item location-expd__item_first-item">';
                        } else {
                            dtHtml += '<li class="location-expd__item">';
                        }

                        if (city.prefix == 'Г' || city.prefix == 'г') {
                            dtHtml += '<strong>';
                        }

                        if (city.synonym != adrMgr.regions[regKlId].synonym) {
                            dtHtml += '<a href="//' + adrMgr.regions[regKlId].synonym + '.rt.ru/' + city.synonym + '/b2bcorp/cabinet' + '" class="' + selectStyle + '" onclick="stat.fixStat(\'change_city\');">' + city.name + '</a>';
                        } else {
                            dtHtml += '<a href="//' + adrMgr.regions[regKlId].synonym + '.rt.ru' + '/b2bcorp/cabinet' +  '" class="' + selectStyle + '" onclick="stat.fixStat(\'change_city\');">' + city.name + '</a>';
                        }

                        if (city.prefix == 'Г' || city.prefix == 'г') {
                            dtHtml += '</strong>';
                        }

                        dtHtml += '</li>';
                    }
                    dtHtml += '</ul></div>';
                }
                dtHtml += '<span class="location-expd__search btn-txt">Другой населенный пункт</span>';

                
                mbHtml += '<ul class="location__cities-list" >';
                for (i = 0; i < cityList.length; i++) {
                    city = cityList[i];
                    mbHtml += '<li ' + (i == 0 ? 'class="location__cities-capital"' : '') + ' >';
                    mbHtml +=  '<a data-reg_synonym="'+adrMgr.regions[regKlId].synonym+'" href="//' + adrMgr.regions[regKlId].synonym + '.rt.ru/' + city.synonym + '/b2bcorp/cabinet'+'" onclick="stat.fixStat(\'change_city\');">' + city.name + '</a></li>';
                }
                mbHtml += '</ul>';
                $("#dt_cities_list").html(dtHtml);
                $("#mb_cities_list").html(mbHtml);
                $("#dt_cities_title").html(adrMgr.regions[regKlId].name);
                $("#mb_cities_title").html(adrMgr.regions[regKlId].name);
                if (ie_ver()){
                    $("#dt_cities_list").find("a").click(function(){
                       var el = $(this);
                       utils.setIECookie(el.data("reg_synonym"), function(){
                            location.href = el.attr("href");
                        });
                        event.preventDefault();
//                        $.ajax("//"+el.data("reg_synonym")+"/pages/sc.jsp?rtsession="+$.cookie("rtsession"), {dataType: 'jsonp'}).done();
                    });
                }
                
                
                $('.location-expd').elem('search').on('click',function(){
                  $.smoothScroll({
                    afterScroll: function() {
                        $('.location-top').first().elem('inputsearch').focus();
                    }
                  });
                });
                
                $.smoothScroll();
            }
        }
    };

    
        adrMgr.regions['01'] = {
            synonym: 'maykop',
            name: 'Адыгея Республика'
        };
    
        adrMgr.regions['04'] = {
            synonym: 'raltay',
            name: 'Алтай Республика'
        };
    
        adrMgr.regions['22'] = {
            synonym: 'altai',
            name: 'Алтайский край'
        };
    
        adrMgr.regions['28'] = {
            synonym: 'amur',
            name: 'Амурская область'
        };
    
        adrMgr.regions['29'] = {
            synonym: 'archangelsk',
            name: 'Архангельская область'
        };
    
        adrMgr.regions['30'] = {
            synonym: 'astrakhan',
            name: 'Астраханская область'
        };
    
        adrMgr.regions['02'] = {
            synonym: 'ufa',
            name: 'Башкортостан Республика'
        };
    
        adrMgr.regions['31'] = {
            synonym: 'belgorod',
            name: 'Белгородская область'
        };
    
        adrMgr.regions['32'] = {
            synonym: 'bryansk',
            name: 'Брянская область'
        };
    
        adrMgr.regions['03'] = {
            synonym: 'buryatiya',
            name: 'Бурятия Республика'
        };
    
        adrMgr.regions['33'] = {
            synonym: 'vladimir',
            name: 'Владимирская область'
        };
    
        adrMgr.regions['34'] = {
            synonym: 'volgograd',
            name: 'Волгоградская область'
        };
    
        adrMgr.regions['35'] = {
            synonym: 'vologda',
            name: 'Вологодская область'
        };
    
        adrMgr.regions['36'] = {
            synonym: 'voronezh',
            name: 'Воронежская область'
        };
    
        adrMgr.regions['05'] = {
            synonym: 'mahachkala',
            name: 'Дагестан Республика'
        };
    
        adrMgr.regions['79'] = {
            synonym: 'eao',
            name: 'Еврейская АО'
        };
    
        adrMgr.regions['75'] = {
            synonym: 'chita',
            name: 'Забайкальский край'
        };
    
        adrMgr.regions['37'] = {
            synonym: 'ivanovo',
            name: 'Ивановская область'
        };
    
        adrMgr.regions['06'] = {
            synonym: 'ingushetia',
            name: 'Ингушетия Республика'
        };
    
        adrMgr.regions['38'] = {
            synonym: 'irkutsk',
            name: 'Иркутская область'
        };
    
        adrMgr.regions['07'] = {
            synonym: 'nalchik',
            name: 'Кабардино-Балкария Республика'
        };
    
        adrMgr.regions['39'] = {
            synonym: 'kaliningrad',
            name: 'Калининградская область'
        };
    
        adrMgr.regions['08'] = {
            synonym: 'elista',
            name: 'Калмыкия Республика'
        };
    
        adrMgr.regions['40'] = {
            synonym: 'kaluga',
            name: 'Калужская область'
        };
    
        adrMgr.regions['41'] = {
            synonym: 'kamchatka',
            name: 'Камчатский край'
        };
    
        adrMgr.regions['09'] = {
            synonym: 'cherkessk',
            name: 'Карачаево-Черкесия Республика'
        };
    
        adrMgr.regions['10'] = {
            synonym: 'karelia',
            name: 'Карелия Республика'
        };
    
        adrMgr.regions['42'] = {
            synonym: 'kemerovo',
            name: 'Кемеровская область'
        };
    
        adrMgr.regions['43'] = {
            synonym: 'kirov',
            name: 'Кировская область'
        };
    
        adrMgr.regions['11'] = {
            synonym: 'komi',
            name: 'Коми Республика'
        };
    
        adrMgr.regions['44'] = {
            synonym: 'kostroma',
            name: 'Костромская область'
        };
    
        adrMgr.regions['23'] = {
            synonym: 'krasnodar',
            name: 'Краснодарский край'
        };
    
        adrMgr.regions['24'] = {
            synonym: 'krasnoyarsk',
            name: 'Красноярский край'
        };
    
        adrMgr.regions['45'] = {
            synonym: 'kurgan',
            name: 'Курганская область'
        };
    
        adrMgr.regions['46'] = {
            synonym: 'kursk',
            name: 'Курская область'
        };
    
        adrMgr.regions['47'] = {
            synonym: 'lenoblast',
            name: 'Ленинградская область'
        };
    
        adrMgr.regions['48'] = {
            synonym: 'lipetsk',
            name: 'Липецкая область'
        };
    
        adrMgr.regions['49'] = {
            synonym: 'magadan',
            name: 'Магаданская область'
        };
    
        adrMgr.regions['12'] = {
            synonym: 'maryel',
            name: 'Марий Эл Республика'
        };
    
        adrMgr.regions['13'] = {
            synonym: 'mordoviya',
            name: 'Мордовия Республика'
        };
    
        adrMgr.regions['77'] = {
            synonym: 'moscow',
            name: 'Москва'
        };
    
        adrMgr.regions['50'] = {
            synonym: 'mosoblast',
            name: 'Московская область'
        };
    
        adrMgr.regions['51'] = {
            synonym: 'murmansk',
            name: 'Мурманская область'
        };
    
        adrMgr.regions['52'] = {
            synonym: 'nnovgorod',
            name: 'Нижегородская область'
        };
    
        adrMgr.regions['53'] = {
            synonym: 'novgorod',
            name: 'Новгородская область'
        };
    
        adrMgr.regions['54'] = {
            synonym: 'novosibirsk',
            name: 'Новосибирская область'
        };
    
        adrMgr.regions['55'] = {
            synonym: 'omsk',
            name: 'Омская область'
        };
    
        adrMgr.regions['56'] = {
            synonym: 'orenburg',
            name: 'Оренбургская область'
        };
    
        adrMgr.regions['57'] = {
            synonym: 'orel',
            name: 'Орловская область'
        };
    
        adrMgr.regions['58'] = {
            synonym: 'penza',
            name: 'Пензенская область'
        };
    
        adrMgr.regions['59'] = {
            synonym: 'perm',
            name: 'Пермский край'
        };
    
        adrMgr.regions['25'] = {
            synonym: 'primorye',
            name: 'Приморский край'
        };
    
        adrMgr.regions['60'] = {
            synonym: 'pskov',
            name: 'Псковская область'
        };
    
        adrMgr.regions['61'] = {
            synonym: 'rostov',
            name: 'Ростовская область'
        };
    
        adrMgr.regions['62'] = {
            synonym: 'ryazan',
            name: 'Рязанская область'
        };
    
        adrMgr.regions['63'] = {
            synonym: 'samara',
            name: 'Самарская область'
        };
    
        adrMgr.regions['78'] = {
            synonym: 'spb',
            name: 'Санкт-Петербург'
        };
    
        adrMgr.regions['64'] = {
            synonym: 'saratov',
            name: 'Саратовская область'
        };
    
        adrMgr.regions['14'] = {
            synonym: 'sakha',
            name: 'Саха (Якутия) Республика'
        };
    
        adrMgr.regions['65'] = {
            synonym: 'sakhalin',
            name: 'Сахалинская область'
        };
    
        adrMgr.regions['66'] = {
            synonym: 'ekt',
            name: 'Свердловская область'
        };
    
        adrMgr.regions['15'] = {
            synonym: 'vladikavkaz',
            name: 'Северная Осетия Республика'
        };
    
        adrMgr.regions['67'] = {
            synonym: 'smolensk',
            name: 'Смоленская область'
        };
    
        adrMgr.regions['26'] = {
            synonym: 'stavropol',
            name: 'Ставропольский край'
        };
    
        adrMgr.regions['68'] = {
            synonym: 'tambov',
            name: 'Тамбовская область'
        };
    
        adrMgr.regions['16'] = {
            synonym: 'kazan',
            name: 'Татарстан Республика'
        };
    
        adrMgr.regions['69'] = {
            synonym: 'tver',
            name: 'Тверская область'
        };
    
        adrMgr.regions['70'] = {
            synonym: 'tomsk',
            name: 'Томская область'
        };
    
        adrMgr.regions['71'] = {
            synonym: 'tula',
            name: 'Тульская область'
        };
    
        adrMgr.regions['17'] = {
            synonym: 'tuva',
            name: 'Тыва Республика'
        };
    
        adrMgr.regions['72'] = {
            synonym: 'tumen',
            name: 'Тюменская область'
        };
    
        adrMgr.regions['18'] = {
            synonym: 'udmurtiya',
            name: 'Удмуртская Республика'
        };
    
        adrMgr.regions['73'] = {
            synonym: 'ulyanovsk',
            name: 'Ульяновская область'
        };
    
        adrMgr.regions['27'] = {
            synonym: 'khabarovsk',
            name: 'Хабаровский край'
        };
    
        adrMgr.regions['19'] = {
            synonym: 'hakasiya',
            name: 'Хакасия Республика'
        };
    
        adrMgr.regions['86'] = {
            synonym: 'hanty',
            name: 'Ханты-Мансийский АО'
        };
    
        adrMgr.regions['74'] = {
            synonym: 'chelyabinsk',
            name: 'Челябинская область'
        };
    
        adrMgr.regions['21'] = {
            synonym: 'chuvashiya',
            name: 'Чувашская Республика'
        };
    
        adrMgr.regions['87'] = {
            synonym: 'chukotka',
            name: 'Чукотский АО'
        };
    
        adrMgr.regions['89'] = {
            synonym: 'yamal',
            name: 'Ямало-Ненецкий АО'
        };
    
        adrMgr.regions['76'] = {
            synonym: 'yaroslavl',
            name: 'Ярославская область'
        };
    

    adrMgr.selectedCity = {"synonym": "moscow", "parentCode": null, "klCode": "7700000000000", "prefix": "г", "klLvl": "30", "name": "Москва", "mpzCode": 2492396, "id": 2341, "streetPresent": true, "prepositional": "Москве", "klRegion": "77"};
    adrMgr.selectedRegion = {
        id: 1,
        klRegion: '77',
        mainLocality: {"synonym": "moscow", "parentCode": null, "klCode": "7700000000000", "prefix": "г", "klLvl": "30", "name": "Москва", "mpzCode": 2492396, "id": 2341, "streetPresent": true, "prepositional": "Москве", "klRegion": "77"},
        name: 'Москва',
        synonym: 'moscow'
    };
    
    adrMgr.getSelectedCode = function(){
       if (!this.other) {
           return this.selectedCity.klCode;
       } 
       return this.other.klCode;
    };
    
    adrMgr.getSelectedLvl = function(){
       if (!this.other) {
           return this.selectedCity.klLvl;
       } 
       return this.other.klLvl;
    };

    var selected_services = [];
    
        selected_services.push("isTv");
    
        selected_services.push("isInet");
    
        selected_services.push("isPhone");
        
    var default_selected_service = null
    
    window.selected_services = selected_services;
    window.default_selected_service = default_selected_service;
    window.adrMgr = adrMgr;
    window.isTest = false;

</script>
<header class="p-head">
            <script>
    (function () {
        var docContext = {};
        docContext.isAuth = false;
        docContext.userUuid = 'fec89b34-e95e-476e-9ac0-4205beafa9b3';
        docContext.requestUuid = '82381c45-ebea-41bf-9c34-5a170c2ae547';
        docContext.filter = 'b2bcorp';
        docContext.urlPath = '/cabinet';
        docContext.properties = {};
        docContext.properties.adengineUrl = '//adengine.rt.ru/js/gb.js?jsonpcallback=?';
        docContext.properties.searchUrl = '//search.rt.ru/';
        docContext.properties.shortUrl = 'rt.ru';
        docContext.isB2B = true;
        docContext.isB2C = false;
        docContext.isB2O = false;
        docContext.userEKL = null;
        docContext.tags = ["b2bcorp", "moscow", "np_moscow"]
        docContext.message = [];
        docContext.profile = {"lastName": null, "firstName": null, "phone": null, "customData": {}, "email": null};
        window.docContext = docContext;
        window.traffic = {"referrer":"","keyWord":"","utms":{},"params":{}};
        window.statistic = {
            goal: ''
        };
    })();
    var listCities = [];
    var elkUrl = "https://lk.rt.ru";
    var domain = "moscow.rt.ru";
    var siteurl = "rt.ru";
</script>
<!--div class="p-section p-section_bg-darkviolet">
    <div class="c-wrap-without-hack">
        <div class="p-head__fl units-row">
            <div class="location-label-box">
                <div class="location-label">Москва</div>
            </div>
            <div class="main-nav-box">
                <nav class="main-nav" id="main-nav">
                    <ul class="main-nav__list">
                        <!--li class="main-nav__item">
                            <a href="http://moscow.rt.ru/" class="main-nav__link">Для себя</a>
                        </li-->
                        <!--li class="main-nav__item main-nav__item_act-item main-nav__item_hasmenu">
                            <a href="http://moscow.rt.ru/b2bcorp" class="main-nav__link">Для крупного бизнеса</a>
                                        <ul class="main-nav-l2">
                                            <li>
                                                <a href="http://moscow.rt.ru/b2b" class="main-nav-l2__item">Для малого бизнеса</a>
                                            </li>
                                            <li>
                                                <a href="http://moscow.rt.ru/b2bgov" class="main-nav-l2__item">Для государственного сектора</a>
                                            </li>
                                        </ul>
                            </li-->
                        <!--li class="main-nav__item">
                            <a class="main-nav__link" href="http://moscow.rt.ru/b2o">Для операторов</a>
                        </li>
                    </ul>
                </nav>

                <div class="p-head__elk-box mq-hide-mobile">
                <a href="http://moscow.rt.ru/b2bcorp/cabinet" class="p-head__elk-box-link">Личный кабинет</a>
                    </div>

                <div class="phone-services phone-services_view-b2b text-center">
                    <span class="phone-services__item phone-services__item_ico-tube phone-services__item_stand-alone">8 800 707 50 50</span>
                </div>
                    </div>
        </div>
    </div>
</div-->
<div class="p-section p-section_bg-white p-section_main-menu">
    <div class="c-wrap-without-hack">
        <div class="p-head__second-line p-head__second-line_slim units-row">
            <div class="head-logo">
                <a href="/" class="head-logo__link">
                    <h1 class="head-logo__logo">Ростелеком</h1>
                </a>
            </div>
			
			<div class="phone-services phone-services_view-b2b text-center">
                    <span class="phone-services__item phone-services__item_ico-tube phone-services__item_stand-alone"><?=$contactphone?></span>
                </div>
			
			
			
            <!--div id="main-menu-box" class="main-menu-box main-menu-box_view-b2b">
                <nav id="site-second-nav" class="second-nav">
                    <div class="second-nav-row">
                    <a class="second-nav__item  mq-hide-mobile second-nav__item-bd-left" data-l2="fix" href="http://moscow.rt.ru/b2bcorp/fix">
                        <span class="second-nav__link second-nav__link_view-b2b second-nav__link_hovermenu">
                            <span class="second-nav__ico second-nav__ico_phone"></span>
                                    <span class="m-align-txt">Телефония</span>
                            </span>
                    </a>
                    <a class="second-nav__item  mq-hide-mobile" data-l2="internet" href="http://moscow.rt.ru/b2bcorp/internet">
                        <span class="second-nav__link second-nav__link_view-b2b second-nav__link_hovermenu">
                            <span class="second-nav__ico second-nav__ico_inet"></span>
                                    <span class="m-align-txt">Интернет и каналы связи</span>
                            </span>
                    </a>
                    <a class="second-nav__item  mq-hide-tablet" data-l2="conference" href="http://moscow.rt.ru/b2bcorp/conference">
                        <span class="second-nav__link second-nav__link_view-b2b second-nav__link_hovermenu">
                            <span class="second-nav__ico second-nav__ico_conferencecall"></span>
                                    <span class="m-align-txt">Конференц-связь</span>
                            </span>
                    </a>
                    <a class="second-nav__item  mq-hide-tablet" href="http://moscow.rt.ru/b2bcorp/corp_iptv">
                        <span class="second-nav__link second-nav__link_view-b2b">
                            <span class="second-nav__ico second-nav__ico_tv"></span>
                                    <span class="m-align-txt">Интерактивное ТВ</span>
                            </span>
                    </a>
                    <a class="second-nav__item  mq-hide-tablet" data-l2="service_cloudy" href="http://moscow.rt.ru/b2bcorp/service_cloudy">
                        <span class="second-nav__link second-nav__link_view-b2b second-nav__link_hovermenu">
                            <span class="second-nav__ico second-nav__ico_cloud"></span>
                                    <span class="m-align-txt">Облачные услуги и дата- центры</span>
                            </span>
                    </a>
                    <a class="second-nav__item  mq-hide-tablet mq-hide-desctop second-nav__item-bd-right" href="http://moscow.rt.ru/b2bcorp/infrastructure">
                        <span class="second-nav__link second-nav__link_view-b2b">
                            <span class="second-nav__ico second-nav__ico_infrastructure"></span>
                                    <span class="m-align-txt">Предоставление инфраструктуры</span>
                            </span>
                    </a>
                    <a class="second-nav__item   second-nav__item_b2border second-nav__item-bd-right" href="http://moscow.rt.ru/b2bcorp/order_link">
                        <span class="second-nav__link">
                            <span class="second-nav__ico second-nav__ico_connect" title="Подключиться"></span>
                                    <span class="mq-hide-small">Подключиться</span>
                            </span>
                    </a>
                    <div id="show-mobile-menu" class="second-nav__item second-nav__item_menu second-nav__item-bd-right">
                        <span class="second-nav__link second-nav__link_view-b2b">
                            <span class="second-nav__ico second-nav__ico_menu" title="Меню"></span>
                            <span class="m-align-txt mq-hide-small">Меню</span>
                        </span>
                    </div>
                    </div>
                </nav>

                <!--div id="second-nav-l2" class="second-nav-l2 white-box units-row">
                <div id="fix" class="second-nav-l2__wrap">

                <nav class="second-nav-l2__item">
                                    <h1 class="content-head-18">Классическая телефония</h1>
                                        <ul class="second-nav-l2-list">
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/classic_phone/local">Местная связь</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/classic_phone/long_distance">Междугородная и международная связь</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/classic_phone/office_zone">Внутризоновая телефонная связь</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/classic_phone/office_atc">Офисная АТС</a>
                                            </li>
                </ul>
                                </nav>
                <nav class="second-nav-l2__item">
                                    <h1 class="content-head-18">Современная телефония</h1>
                                        <ul class="second-nav-l2-list">
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/modern_phone/new_telephonya">Новая телефония — виртуальная АТС от Ростелеком</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/modern_phone/virtual_center">Виртуальный контактный центр</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/modern_phone/free_call">Бесплатный вызов (8-800)</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/modern_phone/ifs">Международный бесплатный вызов (IFS)</a>
                                            </li>
                </ul>
                                </nav>
                <nav class="second-nav-l2__item">
                                    <h1 class="content-head-18">Дополнительные возможности</h1>
                                        <ul class="second-nav-l2-list">
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/possible_phone/additional">Дополнительные услуги</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/possible_phone/set">Правила набора номера</a>
                                            </li>
                <li>
                                                <a href="http://moscow.rt.ru/b2bcorp/fix/possible_phone/faq">Часто задаваемые вопросы</a>
                                            </li>
                </ul>
                                </nav>
                </div>
                <div id="internet" class="second-nav-l2__wrap">

                <nav class="second-nav-l2__item">
                            <ul class="second-nav-l2-list">
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/internet/shpd_inet">Интернет</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/internet/protection">Защита от DDoS-атак</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/internet/vpn">Виртуальные частные сети</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/internet/rent">Аренда каналов</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/internet/managed_services">Управляемые услуги связи</a>
                                </li>
                </ul>
                        </nav>
                </div>
                <div id="conference" class="second-nav-l2__wrap">

                <nav class="second-nav-l2__item">
                            <ul class="second-nav-l2-list">
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/conference/videoconference">Видеоконференция</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/conference/audioconference">Аудиоконференция</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/conference/web_videoconference">Web-видеоконференция</a>
                                </li>
                </ul>
                        </nav>
                </div>
                <div id="service_cloudy" class="second-nav-l2__wrap">

                <nav class="second-nav-l2__item">
                            <ul class="second-nav-l2-list">
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/service_cloudy/virtual_cod">Виртуальный ЦОД</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/service_cloudy/virtuall_office">Виртуальный офис</a>
                                </li>
                <li>
                                    <a href="http://moscow.rt.ru/b2bcorp/service_cloudy/data_center">Услуги Дата-центров</a>
                                </li>
                </ul>
                        </nav>
                </div>
                </div>
            </div-->
            </div>
    </div>
</div>
<nav id="mobile-menu" class="mobile-menu mobile-menu_container-true">
    <div class="mobile-menu__close"></div>
    <h1 class="mobile-menu__head">Меню</h1>
    <!--ul class="mobile-menu__list">
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="javascript:;" onclick="mobile_menu.show('b2bcorp', 'fix', 'Телефония', 'null');" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-phone">Телефония</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="javascript:;" onclick="mobile_menu.show('b2bcorp', 'internet', 'Интернет и каналы связи', 'null');" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-inet">Интернет и каналы связи</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="javascript:;" onclick="mobile_menu.show('b2bcorp', 'conference', 'Конференц-связь', 'null');" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-conferencecall">Конференц-связь</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="http://moscow.rt.ru/b2bcorp/corp_iptv" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-tv">Интерактивное ТВ</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="javascript:;" onclick="mobile_menu.show('b2bcorp', 'service_cloudy', 'Облачные услуги и дата- центры', 'null');" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-cloud">Облачные услуги и дата- центры</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="http://moscow.rt.ru/b2bcorp/infrastructure" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-infrastructure">Предоставление инфраструктуры</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="http://moscow.rt.ru/b2bcorp/order_link" class="mobile-menu__link mobile-menu__link_container mobile-menu_ico-connect">Подключиться</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
                    <a href="http://moscow.rt.ru/b2b" class="mobile-menu__link">Для малого бизнеса</a>
                </li>
                <li class="mobile-menu__item mobile-menu__item_container">
                    <a href="http://moscow.rt.ru/b2bgov" class="mobile-menu__link">Для государственного сектора</a>
                </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="http://moscow.rt.ru/b2o" class="mobile-menu__link">Для операторов</a>
        </li>
        <li class="mobile-menu__item mobile-menu__item_container">
            <a href="http://moscow.rt.ru/" class="mobile-menu__link">Для себя</a>
        </li>
    </ul-->

    <script>
        (function () {
            var mobile_menu = {};
            mobile_menu.subMenu = {};
            mobile_menu.show = function (filterStrId, nodeStr, title, style) {
                var thus = mobile_menu;
                if (thus.subMenu[filterStrId+"_"+nodeStr]) {
                    thus.render(filterStrId, nodeStr, title, style);

                    $("#mobile_sub_menu").setMod('inner', 'active');
                    mobileSidebarShift($('.mobile-menu').eq(0), 'right');
                } else {
                    var lFilterStrId = filterStrId;
                    var lTitle = title;
                    var lStyle = style;

                    $.ajax({
                        url: '/ajax/menu/SubMenuB2B',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            filterStrId: filterStrId,
                            nodeStr: nodeStr
                        },
                        async: true,
                        cache: false,
                        success: function (resp) {
                            thus.subMenu[lFilterStrId+"_"+nodeStr] = resp.result;
                            thus.render(lFilterStrId, nodeStr, lTitle, lStyle);

                            $("#mobile_sub_menu").setMod('inner', 'active');
                            mobileSidebarShift($('.mobile-menu').eq(0), 'right');
                        },
                        error: function (e) {
                            utils.log(e);
                        }
                    });
                }
                return false;
            };

            mobile_menu.render = function (filterStrId, nodeStr, title, style) {
                var thus = mobile_menu;
                if (thus.subMenu[filterStrId+"_"+nodeStr]) {
                    var html = "";
                    var nodes = thus.subMenu[filterStrId+"_"+nodeStr];
                    for (var i = 0; i < nodes.length; i++) {
                        html += '<li class="mobile-menu__item">';
                        var l3 = nodes[i].l3;
                        if (l3.length > 0) {
                            html += '<h2 class="mobile-menu__head-2">' + nodes[i].name + '</h2>';
                            for (var j = 0; j < l3.length; j++) {
                                html += '<a href="' + l3[j].href + '" class="mobile-menu__link-2">' + l3[j].name + '</a>';
                            }
                        } else {
                            html += '<a href="' + nodes[i].href + '" class="mobile-menu__link">' + nodes[i].name + '</a>';
                        }
                        html += '</li>';
                    }
                    $("#mobile_sub_menu_list").html(html);
                    $("#mobile_sub_menu_title").html(title);
                    $("#mobile_sub_menu_title").addClass(style);
                }
            };

            window.mobile_menu = mobile_menu;
        })();
    </script>
    <nav id="mobile_sub_menu" class="mobile-menu mobile-menu_container-true">
        <div class="mobile-menu__close"></div>
        <h1 class="mobile-menu__head mobile-menu_act-yes" id="mobile_sub_menu_title"></h1>
        <ul class="mobile-menu__list" id="mobile_sub_menu_list"></ul>
    </nav>
</nav>
</header>

        <script src="/project/wifi/templates/rtkwifi/files/jquery-1.js"></script>
<script src="/project/wifi/templates/rtkwifi/files/jquery00.js"></script>
<script src="/project/wifi/templates/rtkwifi/files/utils000.js"></script>
<script src="/project/wifi/templates/rtkwifi/files/banner00.gif"></script>
<script type="text/javascript">
    $('a.location-expd__link, #mb_cities_list a').on('click', function (e) {
        e.preventDefault();
        stat.fixStat('change_city');
        utils.sendPostWithUserCollector(this.href, {});
    });

    var founded = false;

    if (docContext.filter === 'mobile' && docContext.urlPath.match(/\/cdma/)) {
        switch (adrMgr.selectedCity.klRegion) {

            case '59':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong> С&nbsp;1&nbsp;августа 2015&nbsp;года все&nbsp;действующие абоненты CDMA Пермского филиала ЗАО&nbsp;«РТ-Мобайл» обслуживаются под&nbsp;брендом Skylink. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Пермского края больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны. <a href="http://skylink.ru/perm" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт Skylink</a>' +
                        '</p>' +
                        '</div> ');
                founded = true;
                break;

        }
    }

    if ((docContext.filter === 'mobile' || docContext.urlPath.match(/\/mobile/)) && !founded) {

        switch (adrMgr.selectedCity.klRegion) {

            case '59':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong>' +
                        ' C&nbsp;24&nbsp;июля 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Пермского края переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Пермского края больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                        ' <a href="http://perm.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                        '</p>' +
                        '</div>');
                break;

            case '66':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong>' +
                        ' C&nbsp;17&nbsp;июля 2015&nbsp;года все&nbsp;действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Свердловской области переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Свердловской области больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                        ' <a href="http://ekt.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на&nbsp;сайт tele2.ru</a>' +
                        '</p>' +
                        '</div>');
                break;

            case '72':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong>' +
                        ' C&nbsp;7&nbsp;августа 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» юга Тюменской области переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» юга Тюменской области больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                        ' <a href="http://tyumen.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                        '</p>' +
                        '</div>');
                break;

            case '45':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong>' +
                        ' C&nbsp;26&nbsp;августа 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Курганской области переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Курганской области больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                        ' <a href="http://kurgan.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                        '</p>' +
                        '</div>');
                break;

            case '86':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                        '<p class="notify-bar__item notify-bar__item_type-attention">' +
                        '<strong>Уважаемые абоненты!</strong>' +
                        ' C&nbsp;28&nbsp;августа 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Ханты-Мансийского&nbsp;АО переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Ханты-Мансийского&nbsp;АО больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                        ' <a href="http://hmao.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                        '</p>' +
                        '</div>');
                break;

            case '89':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                    '<p class="notify-bar__item notify-bar__item_type-attention">' +
                    '<strong>Уважаемые абоненты!</strong>' +
                    ' C&nbsp;11&nbsp;сентября 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Ямало-Ненецкого&nbsp;АО переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Ямало-Ненецкого&nbsp;АО больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                    ' <a href="http://yanao.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                    '</p>' +
                    '</div>');
                break;

            case '74':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                    '<p class="notify-bar__item notify-bar__item_type-attention">'+
                    '<strong>Уважаемые абоненты!</strong>' +
                    ' C&nbsp;29&nbsp;сентября 2015&nbsp;года все действующие абоненты ЗАО&nbsp;«РТ-Мобайл» Челябинской области переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт ЗАО&nbsp;«РТ-Мобайл» Челябинской области больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.' +
                    ' <a href="http://chelyabinsk.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                    '</p>' +
                    '</div>');
                break;

            case '12':
                $('.p-wrap.p-sideslide-center').eq(0).prepend('<div class="notify-bar notify-bar_attention notify-bar_state-on">' +
                    '<p class="notify-bar__item notify-bar__item_type-attention">'+
                    '<strong>Уважаемые абоненты!</strong>' +
                    ' C&nbsp;1&nbsp;октября 2015&nbsp;года все действующие абоненты Йошкар-Олинского филиала ООО&nbsp;«Т2 Мобайл» переведены на&nbsp;обслуживание под&nbsp;бренд Tele2. При&nbsp;этом абоненты по-прежнему могут пользоваться телефоном в&nbsp;привычном режиме и&nbsp;сохранят свой мобильный номер. Старый сайт Йошкар-Олинского филиала ООО&nbsp;«Т2 Мобайл» больше не&nbsp;обновляется, все условия обслуживания на&nbsp;этом сайте неактуальны.'+
                    ' <a href="http://mariel.tele2.ru" target="_blank" class="more-link more-link_no-mgr">Перейти на сайт tele2.ru</a>' +
                    '</p>' +
                    '</div>');
                break;
        }
    }

</script><div id="lendingNode" class="none-elem"></div>
        <div id="corp_cabinet1" class="p-section p-section_bg-lightgray p-section_bg-fadewhite ">
        <div class="c-wrap">
        <div>
		<div class="c-section">
   
		<div id="content1"></div>
			<div id="content">
  <? include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); ?>
   </div>
   
   
   
   
   
   </div>
        </div>
        </div>
        <div class="singlepagenav__skelet mfp-hide">
                        <div class="singlepagenav">
                            <div class="singlepagenav__wrap">
                                <nav class="singlepagenav__nav"></nav>
                                <div class="singlepagenav__promo">
        </div>
                            </div>
                        </div>
                    </div>
        <div id="modal-login" class="modal-form mfp-hide">
    <!--<section class="modal-form__wrap">-->
    <div id="elk_auth_form" class="modal-form__form validate_form">
        <div class="modal-form-close"></div>
        <h1 class="modal-form__title">Авторизация</h1>

        <p id="elkAuthErr" class="modal-form__error-data" style="display: none">Введены неправильные логин и (или)
            пароль. Проверьте язык ввода и клавишу Caps Lock.</p>

        <div class="modal-form__row">
            <div class="modal-form__block modal-form__block_pos-l">
                <label class="modal-form__label" for="elkLogin">Логин личного кабинета</label>
                <input id="elkLogin" class="modal-form__input filter-login-elk validator-filtered" type="text" placeholder="Имя пользователя" required data-invalid-error="Некорректно заполнено имя пользователя" data-empty-error="Не заполнено поле имя пользователя" tabindex="1">
                <label class="modal-form__extra-row" style="display: none">
                    <input id="elkRememberMy" class="checkbox-inline" type="checkbox" value="true" tabindex="4">
                    Запомнить меня
                </label>
            </div>
            <div class="modal-form__block modal-form__block_pos-r">
                <label class="modal-form__label" for="elkPasswd">Пароль</label>

                <div class="btn-group btn-group_width-full">
                    <input class="modal-form__input modal-form__input_type-pass hideShowPassword-field hideShowPassword-hidden filter-pass-elk validator-filtered" type="password" id="elkPasswd" required autocomplete="off" data-invalid-error="Пароль должен состоять из не менее шести и не более шестнадцати латинских букв, цифр и символов из списка: ! @ # $ % ^ &amp; * ( ) _ - + : ; ." data-empty-error="Не заполнено поле Пароль" spellcheck="true" tabindex="2">
                    <button class="btn-showpass modal-form__btn-showpass js-showpass" title="Показать пароль"></button>
                </div>
                <p class="modal-form__extra-row">
                    <a class="modal-form__link" href="https://lk.rt.ru/?action=restore" target="blank">Не могу вспомнить пароль</a>
                </p>
            </div>
        </div>
        <div class="modal-form__row modal-form__row_stand-last">
            <div class="modal-form__block modal-form__block_pos-l">
                <button id="auth-submit" class="button-3 button-disabled modal-form__btn modal-form__btn_width-full filter-submit js-submit-auth" disabled data-loader-txt="Подождите" tabindex="3">
                    <div class="spinner-circle-blue"></div>
                    Войти
                </button>
                <p class="modal-form__extra-row">
                    <a href="https://lk.rt.ru/?action=reg" target="blank"><strong>Зарегистрироваться</strong></a>
                    в Личном кабинете
                </p>
            </div>
            </div>
    </div>
<!--</section>-->
<div class="v-tabs" id="tab50">
    <section class="v-tabs__item v-tabs__item_fullwidth-dashedtop">
        <div class="v-tabs__head">
            <h1 class="content-head-18 content-head-18_mrg-no">Зачем нужна авторизация</h1>

            <div class="v-tabs__label"></div>
        </div>
        <div class="v-tabs__content">
            <div class="modal-form__extra-info">
                <p class="content-p-0 content-txt-14">Пять основных причин воспользоваться авторизацией:</p>
                <ol class="content-list-numbered content-txt-14">
                    <li>Управление тарифным планом в удобное для Вас время.</li>
                    <li>Контроль и управление состоянием Вашего счета, заказ детализации счета.</li>
                    <li>Самые выгодные акции и предложения, подобранные согласно Вашим интересам.</li>
                    <li>Участие в Бонусной программе.</li>
                    <li>Доступ к важной для Вас информации с любого компьютера или телефона.</li>
                </ol>
                <p class="content-p-0 content-p-0_last content-txt-14">Для получения дополнительных возможностей
                    авторизуйтесь на сайте, используя свою учетную запись личного кабинета. Если у вас еще нет учетной
                    записи, то <a href="https://lk.rt.ru/?action=reg" target="blank" class="modal-form__link">зарегистрируйтесь</a> не откладывая.</p>
            </div>
        </div>
    </section>
</div>
</div>
</div>
    <footer class="p-footer p-sideslide-center p-footer_b2b">
    <div class="p-section">
        <div class="c-wrap">
    <div class="p-footer__main-footer">
        <div class="p-footer__box1">
            <div class="p-footer__box-logo-lang">
                <div class="p-footer__logo">
                    <h2 class="p-footer__logo-img">Ростелеком</h2>
                </div>
                <div class="p-footer__lang-switcher">
                    <a href="javascript:;" class="p-footer__lang-switcher-link p-footer__lang-switcher-link_cur" style="visibility: hidden">RU</a>
                    <a href="javascript:;" class="p-footer__lang-switcher-link" style="visibility: hidden">EN</a>
                    <a href="javascript:;" class="p-footer__lang-switcher-link none-elem" style="visibility: hidden">AR</a>
                </div>
            </div>
            <div class="p-footer__box-serv-links">
                <div class="p-footer__service-link-wrap">
					<a href="http://www.rt.ru/b2bcorp/contact_info" class="p-footer__service-link p-footer__service-link_noicon">Контактная информация</a>
				</div>
            </div>
        </div>
        <div class="p-footer__box2">
            <nav class="p-footer__main-nav p-footer__main-nav_col1">
                <div class="p-footer__main-nav-content">
                    <!--<h1 class="p-footer__nav-head head-14">Компания</h1>-->
					<a href="http://moscow.rt.ru/b2bcorp/cabinet#feedback" id="feedback-link" class="p-footer__main-nav-link feedback__link">Обратная связь</a>
					<a id="contacts-link" class="p-footer__main-nav-link" href="http://www.rt.ru/b2bcorp/contacts_b2b">Офисы продаж</a>
					<a class="p-footer__main-nav-link" href="http://www.rt.ru/b2bcorp/progress">Истории успеха</a>
					<a href="http://www.rt.ru/b2bcorp/support" class="p-footer__main-nav-link">Помощь и поддержка</a>
                   <!-- <a id="about-us-link" class="p-footer__main-nav-link" href="http://www.rostelecom.ru/about/info/">О нас</a>-->
                </div>
            </nav>
            <nav class="p-footer__main-nav p-footer__main-nav_col2">
                <div class="p-footer__main-nav-content">
                    <!--<h1 class="p-footer__nav-head head-14">Наши контакты</h1>-->
					<a id="press-center-link" class="p-footer__main-nav-link" href="http://www.rostelecom.ru/press/">Пресс-центр</a>
					<a id="corp-site-link" class="p-footer__main-nav-link" href="http://www.rostelecom.ru/">Корпоративный сайт</a>
                    <a class="p-footer__main-nav-link" href="http://www.rostelecom.ru/ir/">Инвесторам и акционерам</a>
                    <a class="p-footer__main-nav-link" href="http://www.rostelecom.ru/social/">Социальная ответственность</a>
<a class="p-footer__main-nav-link" href="http://www.rostelecom.ru/projects/">В национальных интересах</a>
                </div>
            </nav>
<!--a class="p-footer-ethical" href="http://www.rt.ru/b2bcorp/ethics_code_hotline">Сообщить о&nbsp;нарушении этического кодекса ПАО «Ростелеком»</a-->
        </div>
        <div class="p-footer__box3">
            <form class="p-footer__search" method="get" action="http://www.rt.ru/b2bcorp/search">
                <!--div class="btn-group btn-group_width-full">
                    <input type="hidden" name="text" value>
                    <input type="search" placeholder="Поиск по порталу" class="input-clear input-search">
                    <button class="btn btn-search" type="submit"></button>
                </div-->
            </form>
            <section class="p-footer__soc-box">
                <h1 class="p-footer__soc-title">Будьте в&nbsp;курсе</h1>
                  <a class="soc-link link-vk" href="http://vk.com/rostelecom.official" target="_blank">ВКонтакте</a>
                <a href="http://www.facebook.com/Rostelecom.Official" target="_blank" class="soc-link soc-link_fb">Facebook</a>
                <a href="http://twitter.com/#!/Rostelecom_News" target="_blank" class="soc-link soc-link_tw">Twitter</a>
                <a href="http://www.youtube.com/user/rostelec" target="_blank" class="soc-link link-youtube">Youtube</a>
                <a href="http://www.flickr.com/photos/rostelecom_photostream/" target="_blank" class="soc-link link-flickr">Flickr</a>
                            <a class="soc-link link-classmates" target="_blank" href="http://ok.ru/rostelecom.official">Одноклассники</a>
                            <a class="soc-link link-instagram" target="_blank" href="http://instagram.com/rostelecom_news">          <img class="mq-retina-hide" src="/project/wifi/templates/rtkwifi/files/instagra.png" alt="Instagram">
                            <img class="mq-retina-show" src="/project/wifi/templates/rtkwifi/files/instagrb.png" alt="Instagram">
</a>
            </section>
        </div>
    </div>
</div>


<script type="text/javascript" src="/project/wifi/templates/rtkwifi/files/frame000.js"></script></div>
    <div class="p-section p-section_bg-darkviolet">
        <div class="c-wrap">
            <div class="p-footer__second-line">
                <div class="p-footer__site-info-wrap">
                    <p class="p-footer__site-info">
                        <span class="p-footer__site-info-copyright">© 2016 ПАО «Ростелеком».</span>
                        <span class="p-footer__site-info-media">
                            <!--a class="p-footer__nav1-link" href="http://moscow.rt.ru/data/doc/Svidetelstvo_o_registratsii_sayta_kak_SMI.pdf">
                                Портал является зарегистрированным в РФ СМИ.
                            </a-->
                        </span>
                        <span class="p-footer__site-info-age-limit">18+</span>
                    </p>
                </div>
                <div class="p-footer__second-nav-wrap">
                    <nav class="p-footer__second-nav">
                        <a class="p-footer__second-nav-link" href="http://www.rostelecom.ru/about/disclosure">Раскрытие информации</a>
                        <a class="p-footer__second-nav-link" href="http://www.rostelecom.ru/about/lic_and_cert">Лицензии и сертификаты</a>
                        <!--a class="p-footer__second-nav-link" href="http://zakupki.rostelecom.ru/">Закупки</a-->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- universal modal alert window -->
<div id="app-info__alert" class="app-info__alert modal-form mfp-hide">
    <div class="app-info__alert-wrap">
        <div class="app-info__alert-close modal-form-close"></div>
        <h1 class="modal-form__title" id="app-info__alert-title"></h1>

        <p class="content-p-0 r-12" id="app-info__alert-message"></p>

        <p class="text-center">
            <button class="button-4 app-info__alert-btn">ОК</button>
        </p>
    </div>
</div>

<!-- ToDo create universal modal alert window -->
<div id="config-info__alert" class="config-equipment__alert mfp-hide">
    <div class="config-equipment__alert-wrap">
        <div class="config-equipment__alert-close"></div>
        <h1 class="config-equipment__alert-title" id="config-info__alert-title"></h1>

        <p class="content-p-0 r-12" id="config-info__alert-message"></p>

        <p class="text-center">
            <button class="button-4 config-equipment__alert-btn">ОК</button>
        </p>
    </div>
</div>

<script type="text/javascript">
    $('.p-footer__search').submit(function() {
        $(this).find('input[name="text"]').val(encodeURIComponent(utils.Base64.Base.encode($(this).find('.input-clear.input-search').val())));
    });
    $(document).ready(function(){
      $('.button-1.feedback__link').on('click', function(){
        $('#feedback-link').trigger('click');
        try {
          var service = '';
          if ($('.adaptive-tabs__tab-content-wrap.st-open').size()>0){
            service = $('.st-open').data('service');
          } else {
            var form_url = location.pathname.split("/");

            service = form_url[2];
            if (service == 'service'){
              service = form_url[3];
            }
          }
          switch (service){
            case 'srvhomeinet':
              $('#p-feedback__select-serv').val(2).change().selectric('refresh');
              break;
            case 'srvhometv':
              $('#p-feedback__select-serv').val(3).change().selectric('refresh');
              break;
            case 'srvhometel':
              $('#p-feedback__select-serv').val(1).change().selectric('refresh');
              break;
            case 'srvmobile':
              $('#p-feedback__select-serv').val(4).change().selectric('refresh');
              break;
            default:
              break;
          }
        } catch (error) {}
      });
    });
</script>
<div class="modal-overlay"></div>
<div id="send-sms" class="p-send-sms mfp-hide init-module" data-module="send-sms">
    <form action="http://moscow.rt.ru/b2bcorp/cabinet#" onclick="" class="p-send-sms__form validate_form">
        <div class="p-send-sms__close"></div>
        <h1 class="p-send-sms__title">Отправить SMS</h1>

        <p id="message_sms" class="callback-form__addr-available" style="display:none;margin:15px 0px;"></p>

        <div class="p-send-sms__row">
            <div class="unit-content-5 p-send-sms__block1-1">
                <label class="label-type2" for="p-send-sms__input-number">Номер абонента Ростелеком:</label>

                <div class="rel-wrapper width-100">
                    <div class="tel-prefix">+7</div>
                    <input type="tel" maxlength="10" required value data-invalid-error="Неверный формат телефона" name class="form-inp1 p-send-sms__input-number prefix-tel filter-simple-phone validator-filtered" id="p-send-sms__input-number">
                </div>
                <p class="notes-info-fields">Отправка SMS с сайта возможна абонентам мобильной связи ЗАО «РТ-Мобайл», «Скай Линк», «Нижегородская сотовая связь», «Байкалвестком», «БИТ», «Волгоград GSM», «ЕТК», «АКОС». Услуга предоставляется бесплатно.</p>
            </div>
            <div class="unit-content-5 p-send-sms__block1-2">
                <p class="p-send-sms__subtitle">Ваше сообщение: <span class="p-send-sms__textarea-limit">300</span></p>
                <textarea name="p-send-sms__textarea-message" id="p-send-sms__textarea-message" class="form-textarea1 p-send-sms__textarea-message filter-none validator-filtered" cols="30" rows="5" maxlength="300" placeholder="Максимум 300 символов" required data-invalid-empty="Заполните, пожалуйста, это поле"></textarea>

                <p class="notes-info-fields">Все сообщения приходят получателю от отправителя «rt.ru», поэтому добавьте
                    к
                    сообщению подпись.</p>
            </div>
        </div>
        <hr class="hr-1 mq-hide-mobile">
        <div class="p-send-sms__row">

            <div class="unit-content-5 p-send-sms__block2-1">
                <label class="label-type2 width-100" for="sms__input-captcha">
                    <span id="captcha_reload_sms" class="modal-form__reload-captcha-img modal-form__reload-captcha-img_disable"></span>
                    Введите текст с картинки:
                </label>
                <input type="text" id="sms__input-captcha" placeholder class="form-inp1 unit-12 filter-captcha validator-filtered" required data-invalid-empty="Введите текст с картинки">

                <div class="modal-form__captcha-img">
                    <img id="captcha_sms" src>
                </div>
            </div>

            <div class="unit-content-5 p-send-sms__block2-2">
                <p class="p-send-sms__subtitle">Отправить сообщение позже
                    <input class="js-iCheck i-check_blue p-send-sms__delaymassage-input" id="p-send-sms__delaymassage-input" type="checkbox" name="p-send-sms__delaymassage-input">
                </p>

                <div class="units-row p-send-sms__delaymassage-wrap p-send-sms__delaymassage-wrap_hid">
                    <div class="clearfix">
                        <div class="p-send-sms__delaymassage-select1">
                            <select name="p-send-sms__delaymassage-select1" id="p-send-sms__delaymassage-select1" class="js-selectric0">
                                <option value="0">
                                    00</option>
                                <option value="1">
                                    01</option>
                                <option value="2">
                                    02</option>
                                <option value="3">
                                    03</option>
                                <option value="4">
                                    04</option>
                                <option value="5">
                                    05</option>
                                <option value="6">
                                    06</option>
                                <option value="7">
                                    07</option>
                                <option value="8">
                                    08</option>
                                <option value="9">
                                    09</option>
                                <option value="10">10</option>
                                <option value="11" selected="selected">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                </select>
                        </div>
                        <div class="p-send-sms__delaymassage-select2">
                            <select name="p-send-sms__delaymassage-select2" id="p-send-sms__delaymassage-select2" class="js-selectric0">
                                <option value="0">
                                    00</option>
                                <option value="1">
                                    01</option>
                                <option value="2">
                                    02</option>
                                <option value="3">
                                    03</option>
                                <option value="4">
                                    04</option>
                                <option value="5">
                                    05</option>
                                <option value="6">
                                    06</option>
                                <option value="7">
                                    07</option>
                                <option value="8">
                                    08</option>
                                <option value="9">
                                    09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                                <option value="32">32</option>
                                <option value="33">33</option>
                                <option value="34">34</option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                                <option value="48">48</option>
                                <option value="49" selected="selected">49</option>
                                <option value="50">50</option>
                                <option value="51">51</option>
                                <option value="52">52</option>
                                <option value="53">53</option>
                                <option value="54">54</option>
                                <option value="55">55</option>
                                <option value="56">56</option>
                                <option value="57">57</option>
                                <option value="58">58</option>
                                <option value="59">59</option>
                                </select>
                        </div>
                        <div class="p-send-sms__delaymassage-select3">
                            <select name="p-send-sms__delaymassage-select3" id="p-send-sms__delaymassage-select3" class="js-selectric0">
                                <option data-day="19" data-month="0" selected="selected">19Января</option>
                                <option data-day="20" data-month="0">20Января</option>
                                <option data-day="21" data-month="0">21Января</option>
                                <option data-day="22" data-month="0">22Января</option>
                                <option data-day="23" data-month="0">23Января</option>
                                <option data-day="24" data-month="0">24Января</option>
                                <option data-day="25" data-month="0">25Января</option>
                                <option data-day="26" data-month="0">26Января</option>
                                <option data-day="27" data-month="0">27Января</option>
                                <option data-day="28" data-month="0">28Января</option>
                                <option data-day="29" data-month="0">29Января</option>
                                </select>
                        </div>
                    </div>
                    <p class="p-send-sms__delaymassage-time-zone" id="p-send-sms_desc">Время московское</p>
                </div>

                <div class="p-send-sms__respond hidden-elem">
                    <div class="success">Ваше сообщение отправлено. <a href="http://moscow.rt.ru/b2bcorp/cabinet#">Отправить еще</a></div>
                    <div class="filed">Время московское</div>
                </div>
                <div class="p-send-sms__submit-load">
                    <div class="loading loading_blue">
                        <div class="spinner"></div>
                    </div>
                </div>
                <button id="p-send-sms__submit_btn" class="button-3 p-send-sms__submit button-disabled filter-submit" disabled>Отправить SMS
                </button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var dayOfMothNow = '19';
    var monthNow = '0';
    var hourNow = '11';
    var minutesNow = '49';
</script>
<script>
    var reg = "77";
</script>

<!--AdRivercode START. Type:auditSite: RT.ru PZ: 0 BN: 0 -->
<div style="position: absolute; visibility: hidden;">
    <script type="text/javascript">
        (function(n){
            var l = window.location, a = l.hostname.split('.');
            a.splice(a.length-2, 2);
            window[n] = (a.length? '/' + a.join('/') : '') + l.pathname+ escape(l.search);
        })('sz');
        var RndNum4NoCash = Math.round(Math.random() * 1000000000);
        var ar_Tail='unknown'; if (document.referrer) ar_Tail= escape(document.referrer);
        document.write('<img src="' + ('https:' == document.location.protocol? 'https:' : 'http:') + '//ad.adriver.ru/cgi-bin/rle.cgi?' + 'sid=201976&bt=55&pz=0&sz=' + sz+'&rnd=' + RndNum4NoCash + '&tail256=' + ar_Tail+ '" border=0 width=1 height=1>')
    </script>
    <noscript><img src="//ad.adriver.ru/cgi-bin/rle.cgi?sid=201976&amp;bt=55&amp;pz=0&amp;rnd=46395823" border="0" width="1" height="1"></noscript>
</div>
<!--AdRivercode END -->
<div id="feedback" class="p-feedback mfp-hide init-module">
    <div id="form_callme" class="validate_form p-feedback__form">

        <div class="js-replace_feedback1"></div>

        <div class="p-feedback__close"></div>
        <h1 class="p-feedback__title">Обратная связь</h1>

            <div class="js-replace_feedback2"></div>

        <div class="p-feedback__row">
            <div class="p-feedback__block-who-are-you p-feedback__block-who-are-you_col1">
                <label class="label-type2" for="p-feedback__input-name">Представьтесь, пожалуйста</label>
                <input type="text" name="p-feedback__input-name" id="p-feedback__input-name" placeholder="Фамилия, имя, отчество" class="js-save form-inp1 p-feedback__input-name   filter-name validator-filtered isAuth_not_clear" required data-invalid-empty="Укажите ФИО" data-invalid-error="Неверно указаны ФИО" data-fieldname="clientName">
            </div>
            <div class="p-feedback__block-who-are-you p-feedback__block-who-are-you_col2">
                <label class="label-type2" for="p-feedback__input-number">Ваш номер телефона</label>
                <div class="rel-wrapper width-100">
                    <div class="tel-prefix">+7</div>
                    <input type="tel" name="p-feedback__input-number" id="p-feedback__input-number" maxlength="10" class="js-save form-inp1 p-feedback__input-number prefix-tel filter-simple-phone validator-filtered isAuth_not_clear" required="true" data-invalid-empty="Укажите телефон" data-invalid-error="Неверно указан телефон" data-fieldname="clientPhone">
                </div>
            </div>
            <div class="p-feedback__block-who-are-you p-feedback__block-who-are-you_col3">
                <label class="label-type2" for="p-feedback__input-number2">Электронная почта</label>
                <input type="text" name="p-feedback__input-number" id="p-feedback__input-number2" placeholder="Адрес электронной почты" class="js-save form-inp1 p-feedback__input-number filter-email validator-filtered isAuth_not_clear" data-invalid-error="Неверно указан email" data-fieldname="clientEmail">
            </div>

            <div class="p-feedback__block-who-are-you-desc color-gray-light">
                Обязательно укажите номер телефона, адрес электронной почты по желанию.
            </div>
        </div>


            <div class="js_delete_tele2_form">
        <div class="p-feedback__row">
            <p class="p-feedback__subtitle">Адрес подключения услуги <span class="f-14 color-gray-light normal arial">(необязательно)</span>
            </p>

            <div class="p-feedback__block-addr p-feedback__block-addr_col1">
                <input class="js-save form-inp1 p-feedback__input-addr-text isAuth_not_clear" type="text" name="city" id="city" placeholder="Населенный пункт" data-fieldname="city">
            </div>
            <div class="p-feedback__block-addr p-feedback__block-addr_col2">
                <input class="js-save form-inp1 p-feedback__input-addr-text isAuth_not_clear" type="text" name="addr2" id="addr2" placeholder="Улица (проспект, бульвар и т. п.)" data-fieldname="street">
            </div>
            <div class="p-feedback__block-addr p-feedback__block-addr_col3">
                <input class="js-save form-inp1 p-feedback__input-addr-number isAuth_not_clear" type="text" name="addr3" id="addr3" placeholder="Дом" data-fieldname="house">
                <input class="js-save form-inp1 p-feedback__input-addr-number isAuth_not_clear" type="text" name="addr4" id="addr4" placeholder="Кв." data-fieldname="flat">
            </div>
        </div>

        <div class="p-feedback__row">
            <div class="unit-content-5 p-feedback__block1-1">
                <p class="p-feedback__subtitle">По какой услуге обращение</p>
                <select name="p-feedback__select-serv" id="p-feedback__select-serv" class="p-feedback__select-serv  filter-select validator-filtered" data-invalid-empty="Выберите тип услуги" required="true" data-fieldname="serviceId">
                    <option value="-1" disabled>Выберите тип услуги</option>
                </select>
            </div>
            <div class="unit-content-5 p-feedback__block1-2">
                <p class="p-feedback__subtitle">Категория клиента</p>
                <select name="p-feedback__select-cat" id="p-feedback__select-cat" class="p-feedback__select-cat" data-fieldname="clientType">
                    <option value="1" selected>Частный клиент</option>
                    <option value="2">Юридическое лицо</option>
                </select>
            </div>
            <!--<div class="p-feedback__block-who-are-you-desc color-gray-light" style="float:left;padding-left:0px;">
                Обязательно укажите тип услуги и категорию клиента
            </div>-->
        </div>

        <div class="p-feedback__row">
            <p class="p-feedback__subtitle">Тема обращения</p>
            <select name="p-feedback__select-theme" id="p-feedback__select-theme" class="p-feedback__select-theme  filter-select validator-filtered" data-fieldname="topicId" data-empty-error="Выберите тему обращения">
                <option value="-1" disabled> Выберите наиболее подходящую тему вашего обращения</option>
            </select>

            <!--<div class="p-feedback__block-who-are-you-desc color-gray-light" style="float:left;padding-left:0px;">
                Обязательно укажите тему обращения
            </div>-->
        </div>

        <div class="p-feedback__row">
            <label class="label-type2" for="p-feedback__org-name">Название организации</label>
            <input type="text" name="p-feedback__org-name" id="p-feedback__org-name" placeholder="Название организации" class="js-save form-inp1 p-feedback__input-name filter-any validator-filtered" required data-invalid-empty="Укажите название организации" data-invalid-error="Неверно указано название организации" data-fieldname="nameCorp">
        </div>
                </div>

        <div class="p-feedback__row">
            <div class="unit-content-5 p-feedback__block2-1">
                <p class="p-feedback__subtitle">Текст обращения</p>
                <textarea name="p-feedback__textarea-message" id="p-feedback__textarea-message" class="js-save form-textarea1  p-feedback__textarea-message filter-any-first-char validator-filtered" cols="30" rows="8" data-invalid-empty="Введите текст обращения" required="true" data-fieldname="orderComment"></textarea>
            </div>
            <div class="unit-content-5 p-feedback__block2-2">

                <!--Start Block : file-upload -->
                <div class="p-feedback__row" id="files_block">
                    <p class="file-upload__title">Файл <span class="file-upload__desc">(необязательно, файл не более 700 Кб)</span></p>
                    <div class="file-upload file-upload__wrap file-upload_related permanent">
                        <div class="file-upload__stop file-upload__stop_inset"></div>
                        <div class="file-upload__dropZone">
                            <div class="file-upload__progress"></div>
                            <div class="file-upload__info-in">Прикрепить файл</div>
                            <input type="hidden" name="p-feedback__upload" value="1">
                            <input name="p-feedback__filepath" type="file" class="file-upload__input" data-size="716800">
                        </div>
                        <input type="hidden" name="order_id" id="order_id" value>
                    </div>
                </div>
                <!--End Block : file-upload -->



                <div>
                    <label class="label-type2 width-100" for="callme__input-captcha">
                        <span class="modal-form__reload-captcha-img modal-form__reload-captcha-img_disable" id="captcha_reload_callme"></span>
                        Введите текст с картинки:
                    </label>
                    <input type="text" id="callme__input-captcha" name="captcha_answer_field" placeholder class="form-inp1 unit-12 filter-captcha validator-filtered js-mail-order-field" required data-invalid-empty="Введите текст с картинки">
                    <div class="modal-form__captcha-img">
                        <img id="captcha_callme" src>
                    </div>
                </div>
                <div class="p-feedback__respond"></div>
                <button id="feedback-submit" class="button-3 button-3_width-100 button-disabled filter-submit" disabled data-loader-txt="Отправляем">
                    Отправить
                </button>
            </div>
        </div>
    </div>
</div>


<!--<style>
.p-modal_window__close {
background-position: -3px -39px;
position: absolute;
right: 7.8%;
cursor: pointer;
background-image: url('/img/sprites/most-often-icons-s5ac68132fd.png');
background-repeat: no-repeat;
width: 13px;
height: 13px;
}
</style>-->

<!--<div id="message_popup" class="p-send-sms mfp-hide">
<form action="" onclick="" class="p-send-sms__form" style="vertical-align: middle;">
<div class="p-modal_window__close"></div>
<h1 id="form_title" class="p-send-sms__title"></h1>

<div id="message_popup_content"></div>
</form>
</div>-->
</div>
<!--script src="/project/wifi/templates/rtkwifi/files/jquery01.js" type="text/javascript"></script-->
<script src="/project/wifi/templates/rtkwifi/files/jquery02.js" type="text/javascript"></script>
<!--script src="/project/wifi/templates/rtkwifi/files/jquery03.js" type="text/javascript"></script-->
<script src="/project/wifi/templates/rtkwifi/files/file-upl.js" type="text/javascript"></script>


<!--script src="/project/wifi/templates/rtkwifi/files/config00.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/init_vie.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/model000.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/view1000.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/jquery-c.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/history0.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/plugins0.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/function.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/validato.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/webstore.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/construc.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/mrf00000.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/callme00.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/social00.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/handleba.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/undersco.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/webstorf.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/tariff_d.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/tariff_o.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/tariff_p.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/webstorg.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/template.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/form_sta.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/tariff_q.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/address_.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/checknum.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/send-sms.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/tariff_l.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/videoren.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/anketa00.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/app00000.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/OrderAPI.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/create_o.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/fire_mes.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/orderMai.js" type="text/javascript"></script>

<script src="/project/wifi/templates/rtkwifi/files/configur.js" type="text/javascript"></script-->
<script type="text/javascript">

    setTimeout(function(){
        if (location.hash && location.hash[0] == "#"){
            $("a[href='"+location.hash+"']").trigger('click');
        }
    }, 200);
    document.cookie="scheme="+location.protocol;
    utils.setIECookie("www");
    utils.setIECookie();
    
    function onJsError(message, url, line) {
    	$.post('/ajax/debug/jsErrorLog', {
				message: message,
				url: url,
				line: line
			});
    }

	
	$('#location-top__inputsearch').each(function(){
		$(this).on('focus' , function() {
			stat.gaqEvent('change_region', 'search_city');
		});
	});
	
	if(utils) {
		utils.jsServerLogOn = function() {
			if(!window.onerror) {
				window.onerror = onJsError;
			}
		};
	}

</script>

<script src="/project/wifi/templates/rtkwifi/files/stat0000.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/b2bCusto.js" type="text/javascript"></script>
<script src="/project/wifi/templates/rtkwifi/files/biz_data.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    var isb4 = $('.b-4_tablet-shift').size() > 0;
    var html;
    
                html = (isb4 ? '' : '<div class="b-4_tablet-shift js-desctop-scrolled-block">') +
                                        '<article class="index-ad-block units-row">' +
                                            '<h1 class="content-head-18">Остались вопросы?</h1>' +
                                            '<p class="content-p-0">Если Вы не нашли ответ на свой вопрос, мы&nbsp;рады будем помочь Вам лично.</p>' +
                                            '<a class="button-1 button-1_size-small feedback__link" href="#feedback_b2b">Задать вопрос</a>' +
                                        '</article>' +
                                        '<article class="index-ad-block units-row section-block-divider">' +
                                            '<h1 class="content-head-18">Телефон службы поддержки</h1>' +
                                            '<div class="way-spend__desc gap_cb gap_dt">' +
                                                '<div class="way-spend__ico">' +
                                                    '<div class="choise-ico choise-ico_phone-tube"></div>' +
                                                '</div>' +
                                                '<p class="price-m">8 800 707 50 50</p>' +
                                                '<p class="f-18 dinpro gap_et">Звонок бесплатный</p>' +
                                            '</div>' +
                                        '</article>' +
                        (isb4 ? '' : '</div>');

    

    var arrayOpt = ['configChoise', 'blockDesc', 'dataSelectOpt', 'carusel3imgInit', 'setBlocksNav', 'tariffsConfigurator', 'siteSecondNavInit'];

    if ($('#calc_solution').size() > 0) {
        arrayOpt.push('bizSolutionCalc');
        arrayOpt.push('seltargetChange');
    }

    if ($('.float-bar').size() > 0) {
        arrayOpt.push('setFloatBar');
    }

    if ($('.tipsy-wrapper').size() > 0) {
        arrayOpt.push('tipsyInit');
    }

    window.construct.reloadByName(arrayOpt, true);
    $('#garbage-send-btn').click(function (event) { var $form = $(this).closest('.validate_form');
    	var correct = validatorFilter.validateForm($form);
    	if(!correct) {
        	event.preventDefault();
        	return;
    	}
    	$form.submit();
    	setTimeout(function(){
    		$('.garbage-order-field').val('').filter('.validator-filtered').validatorFilter('reinit');
    	}, 2400);
	});



    if ($('.swiper-wrapper').size() > 0) {
        var tar = 'null';
        if (tar) {
            var $item = $('[data-desc-click="#' + tar + '"]');
            if($item.size() > 0) {
                $item.setMod('active');
                $item.block().setMod('selected');

                var fullWidth = $item.closest('.swiper-container').width(),
                        itemWidth = $item.closest('.swiper-slide').width();

                var selectedIndex = $item.parents('div.swiper-slide').index(),
                        index = selectedIndex > 0 ? Math.max(0, selectedIndex - Math.floor(fullWidth / itemWidth)) + 1 : 0;

                actions.pageSwiper().slider(0).swipeTo(index);

                $item.triggerHandler('click');
            }
        }
    }

    if ($('a.submit_utms').length > 0){
        if (!utils.isEmpty(traffic.utms)){
            var params = $.param(traffic.utms);
            if (params.length > 0){
                $('a.submit_utms').each(function(){
                    try {
                        var parts = $(this).attr('href').split('#');
                        parts[0] += ($(this).attr('href').indexOf('?') > -1 ? '&' : '?') + params;
                        $(this).attr('href', parts.join('#'));
                    } catch (error){};

                });
            }
        }
    }

    $('.b-4_tablet-shift').find('.button-1.button-1_size-small.feedback__link').on('click', function(){
        $('#feedback-link').trigger('click');
    });
    $('.b-4_tablet-shift').find('a[href="#feedback"]').on('click', function(){
        $('#feedback-link').trigger('click');
    });
    try {
        actions.adaptiveTables();
    } catch (error){};
});
$(document).ready(function(){
	$('#toolbar-rt-generated').remove();
 /* if ($('#checkDomainForm').size()>0){
    window.regDomain.init();
  }

  if (window.traffic.utms){
    for (var u in window.traffic.utms){
      document.cookie = u + "=" + window.traffic.utms[u] + ";domain=." + docContext.properties.shortUrl + "path=/";
    }
  }*/
})
	$('#toolbar-rt-generated').remove();
</script>

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