DROP TABLE IF EXISTS `wifi-companies`;

CREATE TABLE `wifi-companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Company_ID',
  `form_of_business_ownership` enum('ООО','ОАО','ЗАО','-') DEFAULT NULL COMMENT 'Форма собственности',
  `company_full_name` text COMMENT 'Название компании',
  `inn` int(10) DEFAULT NULL COMMENT 'ИНН',
  `kpp` int(9) DEFAULT NULL COMMENT 'КПП',
  `bik` int(12) DEFAULT NULL COMMENT 'БИК',
  `country_id` int(3) DEFAULT NULL COMMENT 'Страна, указанная при регистрации компании',
  `city_id` int(6) DEFAULT NULL COMMENT 'Город, указанный при регистрации',
  `legal_address` text COMMENT 'Официальный адрес',
  `real_address` text COMMENT 'Фактический адрес',
  `post_address` text COMMENT 'Почтовый адрес',
  `company_domain` text COMMENT 'Адрес веб-сайта компании',
  `change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата последнего изменения данных о компании',
  `creation_date` datetime NOT NULL COMMENT 'Дата создания компании',
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wifi-galleries`;

CREATE TABLE `wifi-galleries` (
  `gallery_id` int(6) NOT NULL,
  `gallery_title` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `wifi-galleries` VALUES 
(0,"Галерея");

DROP TABLE IF EXISTS `wifi-menus`;

CREATE TABLE `wifi-menus` (
  `rawid` int(4) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(20) NOT NULL COMMENT 'Название меню, к которому относится пункт',
  `menuposition` int(3) NOT NULL,
  `link` varchar(100) DEFAULT '/',
  `title` varchar(100) NOT NULL DEFAULT 'Новый пункт',
  `title_ru` varchar(100) NOT NULL DEFAULT 'Новый пункт',
  `title_en` varchar(100) NOT NULL DEFAULT 'New item',
  `page` varchar(20) DEFAULT NULL COMMENT 'При таком page пункт становится активным',
  `addclasstoli` varchar(20) DEFAULT NULL COMMENT 'Добавить класс к li',
  `addclasstoa` varchar(20) DEFAULT NULL COMMENT 'Добавить класс к a',
  `jsonclick` text,
  `onlyforrole` text COMMENT 'Пункт виден только для роли',
  `onlyforgroup` text COMMENT 'Только для группы/групп',
  `status` enum('enabled','disabled','not_ready') NOT NULL DEFAULT 'not_ready' COMMENT 'Включение пункта',
  PRIMARY KEY (`rawid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-menus` VALUES 
(1,"cabinet",1,"/?page=cabinet&cact=show_user_info","Сведения о пользователе","Новый пункт","New item","","","","","","","not_ready"),
(2,"cabinet",2,"/?page=cabinet&cact=users_management","Управление пользователями","Новый пункт","New item","","","","","","","not_ready");

DROP TABLE IF EXISTS `wifi-messages`;

CREATE TABLE `wifi-messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID сообщения',
  `module_name` varchar(30) DEFAULT 'system' COMMENT 'Имя модуля (или system)',
  `message_code` text NOT NULL COMMENT 'Код сообщения внутри модуля',
  `message_meaning` text COMMENT 'В каком случае появляется сообщение',
  `message_ru` text COMMENT 'Текст сообщения на русском',
  `message_en` text COMMENT 'Текст сообщения на английском',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='Таблица сообщений портала';

INSERT INTO `wifi-messages` VALUES 
(1,"system","fill_all_fields","Сообщение при неполном заполнении формы логина (пропущен логин или пароль)","Заполните все поля","Please, fill all required fields"),
(2,"system","Pass_is_digits_or_letters","Сообщение при некорректных символах в пароле","Пароль должен состоять из цифр и/или английских букв","Password should contain only digits and/or letters"),
(3,"system","Session_parameters_is_wrong(1)","Сообщение для роботов, заполнивших секретное поле","Подделка параметров сессии (1)","Session parameters is wrong (1)"),
(4,"system","Unknown_error","Неизвестная ошибка во время логина","Неизвестная ошибка","Unknown error"),
(5,"system","Should_change_pass","Сообщение об обязательной смене пароля","Пожалуйста, измените Ваш пароль","Please, change your password"),
(6,"system","LoginPass_is_wrong","Неправильно введены логин/пароль","Пользователь с таким логином и/или паролем не найден","User with that login and/or password is not found"),
(7,"system","Pass_is_wrong","Неверный пароль пользователя","Неверно введен пароль пользователя","Password is wrong"),
(8,"system","Login_is_wrong","Пользователь с таким логином не найден","Пользователь с таким логином не найден","Login is wrong"),
(9,"system","Login_is_only_digits","Логин должен состоять из цифр","Логин должен состоять из цифр","Login should contain only digits"),
(10,"system","User_is_not_active","Пользователь не активен","Извините, Ваш аккаунт не активен","Sorry, your account is not in ACTIVE state"),
(11,"system","template_has_no_found","Если не определен template портала","Невозможно определить шаблон портала ()","Site template is not found ()"),
(12,"system","template_doctype_has_no_found","Если не найден файл doctype шаблона","Не найден doctype шаблона портала (doctype.php)","Doctype file is not found (doctype.php)"),
(13,"system","template_scripts_has_no_found","Если не найден файл scripts_and_styles шаблона","Не найден файл script_and_styles.php шаблона","scripts_and_styles.php is not found"),
(14,"system","template_body_has_no_found","Если не найден файл body шаблона","Не найден файл body.php шаблона","body.php is not found"),
(15,"system","module_name_missed","Модуль не найден. Пропущено название модуля при вызове функции insert_module().","Модуль не найден. Пропущено название модуля при вызове функции insert_module().","Module is not found. Module name was missed when calling insert_module() function."),
(16,"system","module_not_installed","Сообщение о неуспешной установке любого модуля","Модуль НЕ установлен при первом запуске","Module NOT installed at first start"),
(17,"system","module_hasnot_config","Сообщение о неуспешной исталляции модуля по причине отсутствия конфиг-файла","Модуль не установлен, отсутствует конфиг файл","Module was not installed, but there is no config file for"),
(18,"system","logout_complete","Сообщение о выходе из сессии","Вы успешно вышли из сессии","You are logged off completelly"),
(19,"system","module_installed","Сообщение после успешной установки любого модуля","Модуль успешно установлен при первом запуске","Module successfully installed at first start"),
(20,"system","you_have_no_privileges_for_operation","Не хватает привилегий для выполнения операции","Не хватает привилегий для выполнения операции","You have no enough privileges for this operation"),
(21,"system","you_have_no_privileges_to_see","Не хватает привилегий для просмотра элемента","Извините, у Вас недостаточно привилегий для просмотра","You have no enough privileges to see this element"),
(22,"system","new_user_succ_added","Новый пользователь успешно добавлен в БД","Пользователь успешно добавлен","The new user has been added successfully"),
(23,"system","email_already_exists","Невозможно добавить нового пользователя, такой е-мейл найден в БД","Пользователь с таким email уже существует в системе","The user with that e-mail is already exist in the site database"),
(24,"system","Logon blocked.Small period","Попытка входа, прошло слишком мало времени.","Извините, вход под этой учетной записью временно заблокирован, превышен предел количества попыток входа","Attempt to logon was blocked because too small time period"),
(25,"system","new_user_is_not_inserted","Не прошел запрос на добавление нового пользователя","Не удалось добавить пользователя","The new user has not been added"),
(26,"start_site_subscribe","DB_issue","Сообщение о невозможности подписаться на оповещение о запуске портала","Извините, возникли проблемы с Базой Данных","Sorry, there is some database issue"),
(27,"start_site_subscribe","trying_failed","Сообщение при повторной попытке подписаться без перезапуска страницы","Извините, попытка не удалась, повторная подписка","Sorry, trying is failed"),
(28,"start_site_subscribe","email_already_exists","Емейл уже подписан на оповещение о запуске портала","Вы уже подписаны на оповещение","You already subscribed"),
(29,"start_site_subscribe","successfully_inserted","Сообщение об удачной подписке на оповещение о запуске портала","Мы уведомим Вас о запуске сайта по указанному e-mail","We let you know when site will start to work"),
(30,"change_password","fill_all_required","Не заполнены все поля при смене пароля","Пожалуйста, заполните все обязательные поля","Please, fill all required fields"),
(31,"change_password","wrong_cur_pass","Неверно введенный текущий пароль","Вы указываете неверный текущий пароль","You are filled in wrong current password"),
(32,"change_password","pass_changed_succ","Пароль изменен успешно","Пароль успешно изменен","Password changed successfully"),
(33,"change_password","password_wasnt_changed","Пароль не был изменен, не прошел запрос в БД","Пароль не был изменен","Password changed successfully"),
(34,"change_password","new_passes_not_equal","Присланные пароли не совпадают","Присланные пароли не совпадают","The new passwords are not equal");

DROP TABLE IF EXISTS `wifi-modulesregister`;

CREATE TABLE `wifi-modulesregister` (
  `module_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ID модуля',
  `modulename` varchar(30) NOT NULL COMMENT 'Название модуля SWP',
  `moduletype` text COMMENT 'Тип модуля',
  `module_description` text COMMENT 'Описание модуля',
  `installed` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'y=инсталлирован',
  `install_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата инсталляции/последнего включения',
  `enabled` enum('enabled','disabled') NOT NULL DEFAULT 'enabled' COMMENT 'Включение работы модуля',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-modulesregister` VALUES 
(1,"templates_manager","templates_manager","Модуль управления шаблонами сайта","y","2016-01-19 12:06:15","enabled"),
(2,"rss","","RSS-лента новостей портала","y","2016-01-19 12:06:15","enabled"),
(3,"counter-googleanalytics","counter-googleanalytics","Google Analytics","y","2016-01-19 12:06:15","enabled"),
(4,"counter-liveinternet","","Счетчик LiveInternet","y","2016-01-19 12:06:15","enabled"),
(5,"counter-yandex","","Счетчик Yandex-метрика","y","2016-01-19 12:06:15","enabled"),
(6,"start_site_subscribe","start_site_subscribe","Модуль подписки на оповещение о запуске портала","y","2016-01-19 12:06:15","enabled"),
(7,"bookmark","","Мультибраузерная функция добавления в закладки","y","2016-01-19 12:06:43","enabled"),
(8,"counter-ga_tagmanager","counter-ga_tagmanager","Google Analytics Tag Manager Counter","y","2016-01-19 12:22:36","enabled"),
(9,"loginform_simple","loginform_simple","loginform_simple","y","2016-01-19 22:33:57","enabled"),
(10,"sms_smscru","sms_smscru","Send SMS via smsc.ru","y","2016-01-19 22:36:13","enabled"),
(11,"change_password","change_password","Модуль с функцией изменения пароля","y","2016-01-19 23:37:55","enabled");

DROP TABLE IF EXISTS `wifi-pages`;

CREATE TABLE `wifi-pages` (
  `page_id` int(5) NOT NULL AUTO_INCREMENT,
  `page` varchar(25) NOT NULL,
  `pagetitle_ru` varchar(200) DEFAULT NULL,
  `pagetitle_en` varchar(200) DEFAULT NULL,
  `folder` varchar(40) DEFAULT '/',
  `filename` varchar(25) DEFAULT NULL,
  `ext` varchar(4) DEFAULT NULL,
  `pagebody_ru` text COMMENT 'Текст страницы, если она не во внешнем файле',
  `pagebody_en` text,
  `module_page` text COMMENT 'Если указан модуль, то при вызове page будет запускаться startscript модуля',
  `page_menu` text COMMENT 'Меню страницы, если не указано другое в get (&menu=somemenu)',
  `exceptionsscript` int(1) NOT NULL DEFAULT '0' COMMENT '1 - есть скрипт с исключениями',
  `canbechanged` int(1) NOT NULL DEFAULT '1' COMMENT '1-можно исправлять, 2 - нет',
  `autor` int(5) DEFAULT NULL COMMENT 'Автор страницы',
  `SEO-title_ru` text COMMENT 'SEO.Title (50-80зн)',
  `SEO-title_en` text COMMENT 'SEO.Title (50-80зн)',
  `SEO-keywds_ru` text COMMENT 'SEO.Keywords (до 250зн)',
  `SEO-keywds_en` text COMMENT 'SEO.Keywords (до 250зн)',
  `SEO-descrtn_ru` text COMMENT 'SEO.Descrptn (150-200зн)',
  `SEO-descrtn_en` text COMMENT 'SEO.Descrptn (150-200зн)',
  `is_articles` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - статья, 0 - системный файл',
  `script_after_page` text COMMENT 'Скрипт, выполняемый после выдачи странички',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-pages` VALUES 
(1,"default","Успешная установка SWP","SWP successfully installed","/html/","default","php","","","","",0,1,,"","","","","","",0,""),
(2,"forgot_pass","Восстановление пароля","Password recovery","","","","","","forgot_password","defaultmenu",0,1,,"","","","","","",0,""),
(3,"HACTPOuKu","Настройки","Settings","/adminpanel/pages/","settings","php","","","","",0,2,,"","","","","","",0,""),
(4,"admin_hello","Администраторская панель","Administration dashboard","/adminpanel/pages/","admin_hello","php","Добро пожаловать в администраторскую панель сайта","Welcome to site administration dashboard","","",0,2,,"","","","","","",0,""),
(5,"change_admin_password","Изменение пароля","Change password","/adminpanel/pages/","change_password","php","","","","",0,2,,"","","","","","",0,""),
(6,"cabinet","Личный кабинет пользователя","User self care","/core/usersmanagement/","cabinet","php","","","","cabinet",0,1,,"","","","","","",0,""),
(7,"MoDyJlu","Управление модулями","Modules management","/adminpanel/pages/","modules","php","","","","",0,2,,"","","","","","",0,""),
(8,"CTPAHuUbI","Управление страницами","Pages management","/adminpanel/pages/","pages","php","","","","",0,2,,"","","","","","",0,""),
(9,"noJlb3oBaTeJlu","Управление пользователями","Users management","/adminpanel/pages/","users_management","php","","","","",0,2,,"","","","","","",0,""),
(10,"KapTuHKu","Управление картинками и галереями","Pictures and galaries management","/adminpanel/pages/","pictures","php","","","","",0,2,,"","","","","","",0,""),
(11,"TeKcToBku","Сообщения платформы","Platform messages","/adminpanel/pages/","messages","php","","","","",0,1,,"","","","","","",0,""),
(12,"rtk_wifi_cp","Страница авторизации WiFi","WiFi Captive Portal","/pages/","rtk_wifi_cp.php","","","","","",0,1,,"","","","","","",0,""),
(13,"test","","","/pages/","test.php","","","","","",0,1,,"","","","","","",0,""),
(14,"rtk_wifi_free","Свободно предоставляемые ресурсы WiFi","","/pages/","rtk_wifi_free_sandbox.php","","","","","",0,1,,"","","","","","",0,""),
(15,"rtk_main","Демо-стенд WiFi для Ростелеком","","/pages/","rtk_main.php","","","","","",0,1,,"","","","","","",0,""),
(16,"wifi_reg","Страница регистрации в сети WiFi","WiFi Registration Page","/pages/","wifi_reg.php","","","","","",0,1,,"Страница регистрации в сети WiFi","","","","","",0,"");

DROP TABLE IF EXISTS `wifi-photos`;

CREATE TABLE `wifi-photos` (
  `photo_id` int(6) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(6) DEFAULT NULL,
  `photo_path` varchar(1000) NOT NULL,
  `photo_title` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wifi-siteconfig`;

CREATE TABLE `wifi-siteconfig` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `value` varchar(1000) DEFAULT NULL,
  `vartype` int(1) NOT NULL DEFAULT '1' COMMENT 'Тип переменной, 1-input,2-select,3-checkbox,4-color',
  `describe` varchar(1000) NOT NULL COMMENT 'Что означает параметр',
  `systemparamname` varchar(30) NOT NULL COMMENT 'Название переменной на сайте',
  `formmaxlegth` int(5) DEFAULT NULL COMMENT 'Максимальное число букв в value этого параметра',
  `varpossible` varchar(3000) DEFAULT NULL COMMENT 'Возможные значения, если это select',
  `showtositeadmin` int(1) NOT NULL DEFAULT '1' COMMENT 'Показывать админу сайта (userrole=administrator).1-да',
  `example` varchar(1000) DEFAULT NULL COMMENT 'Пример значения value или подсказка',
  `depend` varchar(15) NOT NULL DEFAULT 'system' COMMENT 'К чему относится параметр',
  `maybeempty` int(1) NOT NULL DEFAULT '1' COMMENT 'Может ли быть пустым. 1-да',
  `module_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-siteconfig` VALUES 
(1,"wifi.romanyuk.me",1,"Доменное имя сайта","sitedomainname",,"",1,"example.ru","system",2,),
(2,"Включить",3,"Включение работы сайта","shutdownsite",,"Включить;;НЕ ПОКАЗЫВАТЬ",2,"Включить","system",2,),
(3,"Не включать",2,"Включить страницу реконструкции вместо сайта","reconstruction_page",,"Включить;;Не включать",2,"","user",2,),
(4,"2016-2-19 12:05",1,"Дата запуска портала","sitestartdate",,"",1,"2014-01-01","system",1,),
(5,"swp",1,"Шаблон","currenttemplate",20,"",1,"","system",1,),
(6,"ru",1,"Язык сайта по умолчанию","default_language",5,"",1,"en","user",2,),
(7,"default",1,"Страница, которая будет показана пользователю первой после входа","default_page",25,"",1,"main","design",2,),
(8,"SWP от PWS - гибкая веб-платформа для Вашего бизнеса",1,"Заголовок странички","title",,"",1,"","seo",1,),
(9,"SWP от PWS - гибкая веб-платформа для Вашего бизнеса",1,"МЕТА-тег  \'Keywords\'","keywords",,"",1,"","seo",1,),
(10,"SWP от PWS - гибкая веб-платформа для Вашего бизнеса",1,"МЕТА-тег \'Description\'","description",,"",1,"","seo",1,),
(11,"Все права принадлежат владельцу ресурса",1,"МЕТА-тег \'copyright\'","meta_copyright",,"",1,"Все права принадлежат владельцу ресурса","seo",1,),
(12,"SWP от PWS - гибкая веб-платформа для Вашего бизнеса",1,"ALT для логотипа","logoalt",200,"",2,"","seo",1,),
(13,"PopWebStudio.RU (Romanyuk Alexey) skype:romanyukalex tel:+79015139363",1,"META-тег Autor","autormeta",300,"",2,"PopWebStudio.RU (Romanyuk Alexey) skype:romanyukalex tel:+79015139363","seo",1,),
(14,"12px",1,"Размер шрифтов на сайте, если не указано другого","htmlfontsize",8,"",2,"12px","system",2,),
(15,"Неправильное обращение к серверу. Просим Вас не заходить за рамки сценариев сайта",1,"Текст сообщения пользователям в случае неверного обращения к серверу: неправильная строка запроса, подделка некоторых параметров системы","wrongquery",500,"",1,"Неправильное обращение к серверу. Просим Вас не заходить за рамки сценариев сайта.","design",1,),
(16,"#000000",4,"Цвет фона сайта","bodybackgrcolor",7,"",2,"#ffffff","design",1,),
(17,"/project/wifi/templates/rtkwifi/files/logo-rt0.png",1,"Файл логотипа","logofile",100,"",1,"","design",1,),
(18,"/project/swp/templates/swp/files/favicon.png",1,"Favicon. Путь до полноцветной картинки (shortcut)","favicon_shortcut_path",,"",1,"/files/favicon.png","design",1,),
(19,"8 800 707 50 50",1,"Официальный телефон в Блоке с контактами","contactphone",20,"",1,"","user",1,),
(20,"admin@domain.com",1,"Официальный мейл компании","officialemail",100,"",1,"info@domain.ru","user",1,),
(21,"Включено",2,"Возможность отсылать письма пользователям и/или админам","includeemail",,"Включено;;Выключено",1,"","system",2,),
(22,"Администрация портала",1,"При отправке автоматических сообщений с сайта - поле ОТ КОГО","from",200,"",1,"","user",1,),
(23,"info@domain.com",1,"Адрес емейл, с которого будут отсылаться письма портала","emailaddress",,"",1,"info@domain.com","system",1,),
(24,"Заполнена заявка на сайте",1,"При отправке автоматических сообщений с сайта - поле ТЕМА","subject",200,"",1,"","user",1,),
(25,"Выйти из Личного кабинета",1,"Текст ссылки выхода из кабинета","logoutlinktext",100,"",2,"","design",1,),
(26,"Запретить",2,"Разрешить запросы других шаблонов портала через GET-запросы","ch_template",,"Разрешить;;Запретить",1,"Запретить","system",1,),
(27,"Разрешать",2,"Разрешать незарегистрированным вход на сайт?","showsiteforguest",,"Разрешать;;Не разрешать",1,"Ставить РАЗРЕШАТЬ, если на сайте есть страницы общего доступа","system",2,),
(28,"Включено",2,"Включить модуль юзерлогина","enableuserroles",,"Включено;;Выключено",2,"","system",2,),
(29,"Любые символы",2,"Логин должен быть только цифровым","loginisonlydigits",,"Любые символы;;Только цифры",1,"Любые символы","system",1,),
(30,"Пожалуйста, заполните все обязательные поля",2,"В качестве логина использовать Имя_пользователя/емейл/оба","authlogin",,"only_login;;only_email;;both",1,"only_login","system",1,),
(31,"5",1,"Количество попыток ввода пароля до временной блокировки ввода пароля","passinptrymaxcount",,"",2,"","secure",1,),
(32,"900",1,"Время блокировки (в секундах) входа на портал при достижении максимального количества попыток входа","passinptrydelay",,"",1,"900","secure",1,),
(33,"Локальная",2,"Способы аутентификации","login_method",,"Локальная;;LDAP;;Скрипт",1,"Локальная","system",1,),
(34,"100",1,"Максимальное количество символов пароля","passmaxletter",3,"",1,"100","system",1,),
(35,"Пароль",2,"При неверном введении пароля уведомлять о неверности только пароля, или неверности всей связки Login/Pass","showpasserror",,"Пароль;;Связка",1,"Пароль","system",1,),
(36,"NO",1,"Проверять при входе на сайт попадает ли IP пользователя в range разрешенных адресов","sitecorrectipaddress",,"",2,"Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке","system",2,),
(37,"show_user_info",2,"Страничка личного кабинета пользователя по-умолчанию","default_cact",,"-;;show_user_info;;change_password",1,"","design",1,),
(38,"default",1,"Страница,которая будет показана пользователю после выхода из сессии","pageafterlogout",,"",1,"default","system",1,),
(39,"DGup3X6fLFDB7a3WoQOEA",1,"Модуль TWITTER - CONSUMER_KEY","twitterconsumerkey",,"",1,"","user",1,),
(40,"RKyE2pSi2qsNMNiOFQlKeTZZkIFyANku3CG7lwEjg",1,"Модуль TWITTER - CONSUMER_SECRET","twitterconsumersecret",,"",1,"","user",1,),
(41,"314150987-pkFTYydIffE9ITKHNz3NOluh2GtxmUsIrof5lyXu",1,"Модуль TWITTER - OAUTH_TOKEN","twitteroauthtoken",,"",1,"","user",1,),
(42,"425QNLhdY2DeseBs8cwItemtiYxd9AiGNmOuDVmn0A",1,"Модуль TWITTER - OAUTH_SECRET","twitteroauthsecret",,"",1,"","user",1,),
(43,"20",1,"Время обновления листа сообщений в гостевой книге (ajax-чат) в секундах","guestbooktimeout",10,"",1,"","design",2,),
(44,"adminka",1,"Доменное имя второго уровня для АдминПанели","adminsubdomainname",40,"",2,"admin","adminpanel",2,),
(45,"101",1,"Длина поля на странице АдминПанели HACTPOuKu (в символах)","formsize_standart",4,"",2,"140","adminpanel",2,),
(46,"#FFFFFF",4,"Цвет фона страниц АдминПанели","adminpanelbckclr",,"",1,"#FFFFFF","adminpanel",2,),
(47,"#545557",4,"Цвет шапки в АдминПанели","adminheadcolor",,"",1,"#333333","adminpanel",2,),
(48,"#545557",4,"Цвет фона первого экрана в АдминПанели","ap_fp_bckclr",,"",1,"#333333","adminpanel",2,),
(49,"/adminpanel/pics/Male256.png",1,"Логотип в АдминПанели","adminlogofile",,"",1,"/files/logo.png","adminpanel",1,),
(50,"2012 SWP by PWS",1,"Текст в нижней части АдминПанели","ap_bottomtext",,"",1,"2012 SWP by PWS","adminpanel",1,),
(51,"NO",1,"Проверять при входе в АдминПанель попадает ли IP пользователя в range разрешенных адресов","adminpanelcorrectipaddress",100,"",2,"Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке","system",2,),
(52,"Ссылка на сервер Google",2,"Способ вставки библиотеки JQuery","takejquery",,"Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальный файл /js/lib/jquery/jquery.min.js;;Не вставлять",1,"","system",1,),
(53,"Не вставлять",2,"Способ вставки библиотеки JQuery-UI","takejqueryui",,"Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-ui/;;Не вставлять",1,"","system",1,),
(54,"Не вставлять",2,"Способ вставки библиотеки JQueryMobile","takejquerymob",,"Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-mob/;;Не вставлять",1,"","system",1,),
(55,"Сделать",2,"Сделать все текстовые ссылки кликабельными?","showtexturlclickable",,"Сделать;;Не делать",2,"","design",2,),
(56,"Присоединить",2,"Присоединить стиль для красивых CSS-кнопок","appendbuttonsstyle",,"Присоединить;;Не присоединять",2,"","design",2,),
(57,"Разрешать горизонтальную прокрутку",2,"Разрешить горизонтальную прокрутку страницы","hidehorizontalscroll",,"Не разрешать горизонтальную прокрутку;;Разрешать горизонтальную прокрутку",1,"","design",2,),
(58,"Подчеркнуть",2,"По-умолчанию ссылки подчекнуты?","linkdecoration",,"Подчеркнуть;;Не подчеркивать",2,"","system",1,),
(59,"1",1,"Переменная, указывающая скриптам, что запуск сайта произведен корректно","nitka",,"",2,"1","system",2,),
(60,"Предлагать другие браузеры",1,"Разрешать вход на сайт с помощью IE6?","showsiteforie6",,"Разрешать;;Предлагать другие браузеры",2,"","design",2,),
(61,"Включено",2,"Автоматическое подключение классов из папки functions","autoincludeclasses",,"Включено;;Не включено",2,"","system",2,),
(62,"OFF",2,"Уровень логирования портала","loglevel",,"INFO;;WARN;;DEBUG;;ERROR;;FATAL;;OFF",1,"INFO","secure",1,),
(63,"DEBUG",2,"Уровень логирования Админ-панели портала","ap_loglevel",,"DEBUG;;INFO;;WARN;;ERROR;;FATAL;;OFF",1,"INFO","secure",1,),
(64,"Собственный лог",2,"Файлы логирования","writelogto",,"Собственный лог;;SYSLOG;;Собственный и SYSLOG;;Не логировать",1,"SYSLOG","system",1,),
(65,"30",1,"Таймаут PHP-сессии в минутах","sessionlifetime",4,"",1,"","system",2,),
(66,"u@d.c",1,"Технический Емейл пользователя, если при регистрации не требуется Email","defaultusrcontmail",,"",1,"user@domain.com","system",2,),
(67,"debug1",1,"Параметр, определяющий переход в Debug mode","debugmoderequestparam",,"",1,"Если параметр указать debugm, то перевод в debug mode - &mode=debugm","system",1,),
(68,"xyй|аxуе|бля|блят|доебал|долбое|дохуя|ебал|ебан|ебат|ебет|ебешь|ебё|ебл|ебнет|ебут|ебуч|ёбан|заеб|муда|мудил|наебать|нахуй|нахуя|невъебен|отъебал|отъебис|охуе|охуи|пизд|пиздец|попизд|поху|распиздя|срамк|сука|суки|сцук|сучар|сучка|уебан|херасе|херн|херов|хуев|хует|хули|хуя",1,"Список нецензурных и матерных слов, которые будут заменены спецсимволами","badwordslist",,"",1,"х/п/б","user",1,),
(69,"arial",1,"Семейство шрифтов на сайте","fontfamily",,"",2,"sans-serif ,Geneva, Helvetica, Arial","system",2,),
(70,"10",1,"Количество новостей, выдаваемых в RSS-ленту","rssnewsquantity",,"",1,"10","system",1,2),
(71,"/modules/rss/rss.png",1,"Пиктограмма RSS","rss_picture",,"",1,"10","system",1,2),
(72,"Доменное имя, на которое пришел запрос",2,"Откуда брать доменное имя в ленте RSS","rss_choosedomain",,"Доменное имя по-умолчанию sitedomainname;;Доменное имя, на которое пришел запрос",1,"","design",1,2),
(73,"200",1,"Минимальное количество символов в полном описании новости, выводимого в RSS","rss_text_min",,"",1,"200","design",1,2),
(74,"Из файла /project/projectname/modules_data/counter-googleanalytics.counter.php",2,"Включить google counter?","enablegooglecount",,"Из базы данных;;Из файла /project/projectname/modules_data/counter-googleanalytics.counter.php;;Не включать",1,"","system",2,3),
(75,"<!-- Вставить код счетчика-->",1,"Код счетчика Google Analytics","countergooglecode",200,"",1,"","system",1,3),
(76,"Из файла /project/projectname/modules_data/counter-yandex.counter.php",2,"Включить Yandex counter?","enableyandexcount",,"Из базы данных;;Из файла /project/projectname/modules_data/counter-yandex.counter.php;;Не включать",1,"","system",2,5),
(77,"<!-- Вставить код счетчика-->",1,"Код счетчика Yandex","counteryandexcode",200,"",1,"","system",1,5),
(78,"Из файла /modules/counter-ga_tagmanager/counter-ga_tagmanager.php",2,"Включить google counter tag manager?","enablegatagcount",,"Из базы данных;;Из файла /modules/counter-ga_tagmanager/counter-ga_tagmanager.php;;Не включать",1,"","system",2,8),
(79,"<!-- Вставить код счетчика ga tag manager-->",1,"Код счетчика Google Analytics Tag Manager","countergatagcode",200,"",1,"","system",1,8),
(80,"ucn-poc/is9dkan5",1,"Логин и пароль аккаунта на SMSC.RU (через /)","smscru_ad",,"",1,"smscru_login/smscru_password","user",1,10),
(81,"Включить",2,"Javascript-ускорение при нажатии на кнопки/ссылки ","click_eq_msdown",,"Включить;;Не включать",1,"","design",1,),
(82,"192.168.5.200/freerad/123/radius",1,"Параметры подключения к БД Radius","rad_db_ad",,"",1,"ip(or localhost)/db_user/db_pass/database","user",1,),
(83,"Только цифры",2,"Состав пароля для пользователя FreeRadius","rad_pass_mode",,"Только цифры;;Только буквы;;Смесь букв и цифр",1,"","security",1,),
(84,"8",1,"Длина пароля пользователя FreeRadius","rad_pass_len",,"",1,"","security",1,),
(85,"SP_LIM",1,"WiFi.ALLOT_SMP.Код дефолтного тарифного плана при регистрации","rad_def_sp",,"",1,"SP_LIM","user",1,),
(86,"Allot_soap_api",2,"WiFi.Способ открытия сессии","wifi_access_mode",,"radius;;Allot_soap_api",1,"","user",1,),
(87,"http://192.168.5.152/services/SMFAdmin?wsdl",1,"WiFi.ALLOT_SMP. Путь до wsdl-файла","allot_wsdl_path",,"",1,"http://192.168.5.152/services/SMFAdmin?wsdl","user",1,);

DROP TABLE IF EXISTS `wifi-start-site-subscribers`;

CREATE TABLE `wifi-start-site-subscribers` (
  `subscriber_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID подписчика',
  `email` text NOT NULL COMMENT 'Email для оповещения',
  `subscription_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время подписки на запуск портала',
  `domain` text COMMENT 'Доменное имя портала',
  PRIMARY KEY (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица подписчиков для оповещения о запуске портала в работ';

DROP TABLE IF EXISTS `wifi-templates_manager`;

CREATE TABLE `wifi-templates_manager` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `template` text NOT NULL,
  `domain` text,
  `url` text,
  `mainpage` varchar(20) DEFAULT NULL COMMENT 'Главная страница темплейта',
  `onoff` enum('on','off') NOT NULL DEFAULT 'on' COMMENT 'Включение работы правила',
  `comment` text,
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Менеджер шаблонов сайта';

INSERT INTO `wifi-templates_manager` VALUES 
(1,"rtkwifi","wifi.romanyuk.me","","rtk_main","on","WiFi каптив портал Ростелеком"),
(2,"rtkwifi","CP1.LOCAL","","rtk_wifi_cp","on","WiFi каптив портал Ростелеком.Портал регистрации"),
(3,"rtkwifi","CP2.LOCAL","","rtk_wifi_sc","on","WiFi каптив портал Ростелеком.Портал самообслуживания клиента"),
(4,"rtkwifi","UCN.LOCAL","","rtk_wifi_free","on","WiFi каптив портал Ростелеком. Портал-заглушка со списком бесплатных ресурсов"),
(5,"rtkwifi_bzns","CPB.LOCAL","","rtk_wifi_business","on","WiFi каптив портал Ростелеком. Портал бизнес-клиента");

DROP TABLE IF EXISTS `wifi-users`;

CREATE TABLE `wifi-users` (
  `userid` int(7) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `userrole` varchar(30) NOT NULL DEFAULT 'user',
  `nickname` varchar(40) DEFAULT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `second_name` text COMMENT 'Фамилия',
  `first_name` text COMMENT 'Имя',
  `patronymic_name` text COMMENT 'Отчество',
  `gender` enum('-','male','female') NOT NULL DEFAULT '-' COMMENT 'Пол',
  `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
  `adult` tinyint(1) DEFAULT NULL COMMENT 'Совершеннолетний',
  `company_id` int(11) DEFAULT NULL,
  `contactmail` varchar(40) DEFAULT NULL,
  `contact_phone` varchar(30) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL COMMENT 'Страна, указанная при регистрации',
  `city_id` int(11) DEFAULT NULL COMMENT 'Город, указанный при регистрации',
  `region_id` int(11) DEFAULT NULL COMMENT 'Регион, указанный при регистрации',
  `address` text COMMENT 'Адрес, указанный при регистрации',
  `is_allowed_personal` int(1) DEFAULT '1' COMMENT '1 - разрешил обработку персональных данных',
  `status` varchar(15) NOT NULL DEFAULT 'deactivate' COMMENT 'active/deactive/between/blocked/admin_suspended',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regsecretkey` varchar(10) DEFAULT NULL,
  `ActivationLink` varchar(30) DEFAULT NULL,
  `DeactivationLink` varchar(30) DEFAULT NULL,
  `changepassmust` int(1) NOT NULL DEFAULT '1' COMMENT '1 - не надо менять пасс, 2- должен менять при след логине',
  `password_history` text NOT NULL COMMENT 'История паролей через ;',
  `passw_last_change_date` date DEFAULT NULL COMMENT 'Дата последнего изменения пароля',
  `passw_inp_last_try` timestamp NULL DEFAULT NULL COMMENT 'Дата последней попытки смены пароля',
  `passw_inp_count` int(11) NOT NULL DEFAULT '0' COMMENT 'Счетчик попыток смен паролей',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid` (`userid`),
  KEY `login` (`login`),
  KEY `password` (`password`),
  KEY `userid_2` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wifi-users-admin`;

CREATE TABLE `wifi-users-admin` (
  `userid` int(7) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `userrole` varchar(30) NOT NULL DEFAULT 'admin',
  `nickname` varchar(40) DEFAULT NULL,
  `fullname` varchar(40) DEFAULT NULL,
  `contactmail` varchar(40) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'deactivate' COMMENT 'active/deactive/between',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regsecretkey` varchar(10) DEFAULT NULL,
  `ActivationLink` varchar(30) DEFAULT NULL,
  `DeactivationLink` varchar(30) DEFAULT NULL,
  `changepassmust` int(1) NOT NULL DEFAULT '1' COMMENT '1 - не надо менять пасс, 2- должен менять при след логине',
  `password_history` text NOT NULL COMMENT 'История паролей',
  `passw_last_change_date` date DEFAULT NULL COMMENT 'Дата последнего изменения пароля',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid` (`userid`),
  KEY `login` (`login`),
  KEY `password` (`password`),
  KEY `userid_2` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-users-admin` VALUES 
(1,"admin","a906449d5769fa7361d7ecc6aa3f6d28","root","Администратор","Администратор","admin@example.ru","active","2016-01-19 12:05:40","","","",1,"21232f297a57a5a743894a0e4a801fc3;","2016-01-19");

DROP TABLE IF EXISTS `wifi-users-groupmembers`;

CREATE TABLE `wifi-users-groupmembers` (
  `gm_id` int(7) NOT NULL COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `userid` int(5) NOT NULL COMMENT 'ID пользователя'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `wifi-users-groupmembers` VALUES 
(0,1,1);

DROP TABLE IF EXISTS `wifi-users-grouprights`;

CREATE TABLE `wifi-users-grouprights` (
  `gright_id` int(11) NOT NULL COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `oid` int(10) NOT NULL COMMENT 'ObjectID (0-all objects)',
  `table` varchar(40) NOT NULL COMMENT 'В какой табличке OID',
  `grant` int(1) NOT NULL DEFAULT '1' COMMENT '1-access_granted,2-access_deny'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `wifi-users-grouprights` VALUES 
(0,1,0,"wifi-siteconfig",1);

DROP TABLE IF EXISTS `wifi-users-groups`;

CREATE TABLE `wifi-users-groups` (
  `group_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Номер группы',
  `groupname` varchar(100) NOT NULL COMMENT 'ID пользователя',
  `onoff` enum('on','off','','') NOT NULL DEFAULT 'on' COMMENT 'on/off',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `wifi-users-groups` VALUES 
(1,"root","on"),
(2,"public","on");

