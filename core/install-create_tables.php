<?
if($nitka==1 and $install_swp==1){
include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
mysql_query('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";');

$structures['Pages Table']="
CREATE TABLE $check_tables_existing `$tableprefix-pages` (
  `page_id` int(5) NOT NULL AUTO_INCREMENT,
  `page` text NOT NULL,
  `pagetitle_ru` varchar(200) DEFAULT NULL,
  `pagetitle_en` varchar(200) DEFAULT NULL,
  `folder` varchar(40) DEFAULT '/',
  `filename` text DEFAULT NULL,
  `pagebody_ru` text  COMMENT 'Текст страницы, если она не во внешнем файле',
  `pagebody_en` text ,
  `module_page` text COMMENT 'Если указан модуль, то при вызове page будет запускаться startscript модуля',
  `page_menu` text COMMENT 'Меню страницы, если не указано другое в get (&menu=somemenu)',
  `exceptionsscript` int(1) NOT NULL DEFAULT '0' COMMENT '1 - есть скрипт с исключениями',
  `canbechanged` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'yes -can be changed, no - dont able to change',
  `autor` int(7) DEFAULT NULL COMMENT 'Page author (user ID)',
  `SEO-title_ru` text CHARACTER SET utf8 COMMENT 'SEO.Title (50-80 letters)',
  `SEO-title_en` text CHARACTER SET utf8 COMMENT 'SEO.Title (50-80 letters)',
  `SEO-keywds_ru` text CHARACTER SET utf8 COMMENT 'SEO.Keywords (up to 250 letters)',
  `SEO-keywds_en` text CHARACTER SET utf8 COMMENT 'SEO.Keywords (up to 250 letters)',
  `SEO-descrtn_ru` text CHARACTER SET utf8 COMMENT 'SEO.Descrptn (150-200 letters)',
  `SEO-descrtn_en` text CHARACTER SET utf8 COMMENT 'SEO.Descrptn (150-200 letters)',
  `showin_all_pages_page` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Show this page in HTML site map (all_pages_page)',
  `is_articles` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - article, 0 - system file',
  `page_img` TEXT NULL COMMENT 'Main image for the page (in meta og) [id or uri]',
  `script_after_page` text COMMENT 'Script executing after page',
  `creation_date` datetime DEFAULT NULL COMMENT 'Date of creation of this page',
  `orig_link` text COMMENT 'Link to original if its external material',
  `tags` text COMMENT 'Tags via ;',
  `cache_time` int(11) NOT NULL DEFAULT '0' COMMENT 'cache this page (minutes).0 - off',
  `ap` enum('ap_only','site_page','site_page_logged_only') NOT NULL DEFAULT 'site_page' COMMENT 'Is adminpanel page only OR site page OR only for loged users',
  `meta` text COMMENT 'meta tags via ; (param1:value1;param2:value2)',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";

$DBdata['Adding of default pages']="
INSERT INTO `$tableprefix-pages`(`page`, `pagetitle_ru`,`pagetitle_en`, `folder`, `filename`, `pagebody_ru`,`pagebody_en`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`,`ap`) VALUES
('default', 'Успешная установка SWP','SWP successfully installed','/html/', 'default.php', NULL, NULL,NULL, NULL, 0, 1,'site_page'),
('forgot_pass','Восстановление пароля','Password recovery', NULL, NULL, NULL,NULL,'forgot_password', 'defaultmenu', '0', '1','site_page'),
('HACTPOuKu', 'Настройки', 'Settings', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('admin_hello', 'Администраторская панель', 'Administration dashboard', NULL, NULL, 'Добро пожаловать в администраторскую панель сайта', 'Welcome to site administration dashboard', 'adminpanel', NULL, 0, 2,'ap_only'),
('change_admin_password', 'Изменение пароля', 'Change password', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('cabinet', 'Личный кабинет пользователя','User self care', '/core/usersmanagement/', 'cabinet.php', NULL,NULL, NULL, 'cabinet', 0, 1,'site_page'),
('MoDyJlu', 'Управление модулями', 'Modules management', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('CTPAHuUbI', 'Управление страницами', 'Pages management', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('noJlb3oBaTeJlu', 'Управление пользователями', 'Users management', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('KapTuHKu', 'Управление картинками и галереями', 'Pictures and galaries management', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 2,'ap_only'),
('TeKcToBku', 'Сообщения платформы', 'Platform messages', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 1,'ap_only'),
('3KCnopT', 'Экспорт кода и БД', 'Export platform code and DB', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 1,'ap_only'),
('O6HoBJleHue', 'Обновление SWP', 'SWP update', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 1,'ap_only'),
('CoobuuEHuR', 'Сообщения администратору', 'Messages to admin', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0,1,'ap_only'),
('CTaTuCTuKa', 'Статистика', 'Statistics', NULL, NULL, NULL, NULL, 'adminpanel', NULL, 0, 1,'ap_only');";

$structures['Menues Register']="
CREATE TABLE $check_tables_existing `$tableprefix-menus` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";

$DBdata['Adding of default menu']="INSERT INTO `$tableprefix-menus` (`rawid`, `menuname`, `menuposition`, `link`, `title`, `page`, `addclasstoli`, `addclasstoa`, `jsonclick`) VALUES
(NULL, 'cabinet', '1', '/?page=cabinet&cact=show_user_info', 'Сведения о пользователе', NULL, NULL, '', NULL),
(NULL, 'cabinet', '2', '/?page=cabinet&cact=users_management', 'Управление пользователями', NULL, NULL, '', NULL);";

$structures['Modules Register']="
CREATE TABLE IF NOT EXISTS `$tableprefix-modulesregister` (
  `module_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ID модуля',
  `modulename` varchar(30) NOT NULL COMMENT 'Название модуля SWP',
  `moduletype` text COMMENT 'Тип модуля',
  `module_description` text CHARACTER SET utf8 COMMENT 'Описание модуля',
  `installed` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'y=инсталлирован',
  `install_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата инсталляции/последнего включения',
  `enabled` enum('enabled','disabled') NOT NULL DEFAULT 'enabled' COMMENT 'Включение работы модуля',
  `cron` enum('enabled','disabled') DEFAULT 'disabled' COMMENT 'Включен ли у модуля крон-скрипт',
  `db_error_protect` text COMMENT 'JSON data contains tables of the module and fields. Uses in cron job for prevent table and fields corruption',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$structures['Configuration Table']="CREATE TABLE $check_tables_existing `$tableprefix-siteconfig` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `value` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  `vartype` int(1) NOT NULL DEFAULT '1' COMMENT 'Тип переменной, 1-input,2-select,3-checkbox,4-color',
  `describe` varchar(1000) CHARACTER SET utf8 NOT NULL COMMENT 'Что означает параметр',
  `systemparamname` varchar(30) NOT NULL COMMENT 'Название переменной на сайте',
  `formmaxlegth` int(5) DEFAULT NULL COMMENT 'Максимальное число букв в value этого параметра',
  `varpossible` varchar(3000) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Возможные значения, если это select',
  `inmemory` enum('always','ondemand') NOT NULL DEFAULT 'always' COMMENT 'Loading of setting to memory',
  `showtositeadmin` int(1) NOT NULL DEFAULT '1' COMMENT 'Показывать админу сайта (userrole=administrator).1-да',
  `example` varchar(1000) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Пример значения value или подсказка',
  `depend` varchar(15) NOT NULL DEFAULT 'system' COMMENT 'Category of setting',
  `maybeempty` int(1) NOT NULL DEFAULT '1' COMMENT 'Может ли быть пустым. 1-да',
  `module_id` int(5) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL COMMENT 'Нстройка конкретной company_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";

$DBdata['Default Configuration']="
INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`) VALUES
(NULL, 'domain.com', 1, 'Главное доменное имя сайта', 'sitedomainname', NULL, NULL, 1, 'example.ru', 'system', 2),
(NULL, 'Включить', 3, 'Включение работы сайта', 'shutdownsite', NULL, 'Включить;;НЕ ПОКАЗЫВАТЬ', 2, 'Включить', 'system', 2),
(NULL, 'Включить', 2, 'Включить страницу реконструкции вместо сайта', 'reconstruction_page', NULL, 'Включить;;Не включать', 2, NULL, 'user', 2),
(NULL, '".(date("Y-") . (date("m")+1) . date("-d H:i"))."', 1, 'Дата запуска портала', 'sitestartdate', NULL, NULL, '1', '2014-01-01', 'system', '1'),
(NULL, 'ru', 1, 'Язык сайта по умолчанию', 'default_language', 5, NULL, 1, 'en', 'user', 2),

(NULL, 'SWP от PWS - гибкая веб-платформа для Вашего бизнеса', 1, 'Заголовок странички', 'title', NULL, NULL, 1, NULL, 'seo', 1),
(NULL, 'SWP от PWS - гибкая веб-платформа для Вашего бизнеса', 1, 'МЕТА-тег  ''Keywords''', 'keywords', NULL, NULL, 1, NULL, 'seo', 1),
(NULL, 'SWP от PWS - гибкая веб-платформа для Вашего бизнеса', 1, 'МЕТА-тег ''Description''', 'description', NULL, NULL, 1, NULL, 'seo', 1),
(NULL , 'Все права принадлежат владельцу ресурса', '1', 'МЕТА-тег ''copyright''', 'meta_copyright', NULL , NULL , '1', 'Все права принадлежат владельцу ресурса', 'seo', '1'),
(NULL, '55.754051,37.620998', '1', 'МЕТА-теги местоположения для Google (Latitude и Longitude)', 'meta_titude', NULL, NULL, '1', '55.754051,37.620998', 'user', '1'),
(NULL, 'Открывать с адресной строкой', '2', 'МЕТА-тег, указывающий Mobile Safari открывать сайт в полноэкранном режиме', 'meta_appl_fscr', NULL, 'Открывать в полном экране;;Открывать с адресной строкой', '1', NULL, 'design', '1'),
(NULL, 'SWP от PWS - гибкая веб-платформа для Вашего бизнеса', 1, 'ALT для логотипа', 'logoalt', 200, NULL, 2, NULL, 'seo', 1),
(NULL, 'Romanyuk Alexey. Skype:romanyukalex tel:+79015139363', 1, 'META-тег Autor', 'autormeta', 300, NULL, 2, 'PopWebStudio.RU (Romanyuk Alexey) skype:romanyukalex tel:+79015139363', 'seo', 1),

(NULL, NULL, '1', 'Класс элемента BODY', 'bodyclass', NULL, NULL, '1', NULL, 'design', '1'),
(NULL, NULL, '1', 'Класс элемента HTML', 'htmlclass', NULL, NULL, '1', NULL, 'design', '1'),

(NULL, '#000000', 4, 'Цвет фона сайта', 'bodybackgrcolor', 7, NULL, 2, '#ffffff', 'design', 1),
(NULL, '/pages/reconstruction_page/files/logo.png', 1, 'Файл логотипа', 'logofile', 100, NULL, 1, NULL, 'design', 1),
(NULL , '/project/swp/templates/swp/files/favicon.png', '1', 'Favicon. Путь до полноцветной картинки (shortcut)', 'favicon_shortcut_path', NULL , NULL , '1', '/files/favicon.png', 'design', '1'),
(NULL, '8-(901)-513-93-63', 1, 'Официальный телефон в Блоке с контактами', 'contactphone', 20, NULL, 1, NULL, 'user', 1),
(NULL, 'admin@domain.com', 1, 'Официальный мейл компании', 'officialemail', 100, NULL, 1, 'info@domain.ru', 'user', 1),
(NULL, 'Администрация портала', 1, 'При отправке автоматических сообщений с сайта - поле ОТ КОГО', 'from', 200, NULL, 1, NULL, 'user', 1),
(NULL, 'info@domain.com', '1', 'Адрес емейл, с которого будут отсылаться письма портала', 'emailaddress', NULL, NULL, '1', 'info@domain.com', 'system', '1'),
(NULL, 'Заполнена заявка на сайте', 1, 'При отправке автоматических сообщений с сайта - поле ТЕМА', 'subject', 200, NULL, 1, NULL, 'user', 1),
(NULL, 'info@domain.com', '1', 'Адрес емейл администратора портала', 'admin_email', NULL, NULL, '1', 'info@domain.com', 'system', '1'),



(NULL, 'Запретить', '2', 'Разрешить запросы других шаблонов портала через GET-запросы (режим отладки)', 'ch_template', NULL, 'Разрешить;;Запретить', '1', 'Запретить', 'system', '1'),




(NULL, 'Любые символы', '2', 'Логин должен быть только цифровым', 'loginisonlydigits', NULL, 'Любые символы;;Только цифры', '1', 'Любые символы', 'system', '1'),
(NULL, 'only_email', '2', 'В качестве логина использовать Имя_пользователя/емейл/оба', 'authlogin', NULL, 'only_login;;only_email;;both', '1', 'only_login', 'system', '1'),
(NULL, '5', '1', 'Количество попыток ввода пароля до временной блокировки ввода пароля', 'passinptrymaxcount', NULL, NULL, '2', '', 'secure', '1'),
(NULL, '900', '1', 'Время блокировки (в секундах) входа на портал при достижении максимального количества попыток входа', 'passinptrydelay', NULL, NULL, '1', '900', 'secure', '1'),
(NULL, 'Локальная', '2', 'Способы аутентификации', 'login_method', NULL, 'Локальная;;LDAP;;Скрипт;;В сторонней БД', '1', 'Локальная', 'system', 1),
(NULL, '100', 1, 'Максимальное количество символов пароля', 'passmaxletter', 3, NULL, 1, '100', 'system', 1),
(NULL, 'Пароль', '2', 'При неверном введении пароля уведомлять о неверности только пароля, или неверности всей связки Login/Pass', 'showpasserror', NULL, 'Пароль;;Связка', '1', 'Пароль', 'system', '1'),
(NULL, 'show_user_info', '2', 'Страничка личного кабинета пользователя по-умолчанию', 'default_cact', NULL, '-;;show_user_info;;change_password', '1', '', 'design', '1'),
(NULL, 'default', '1', 'Страница,которая будет показана пользователю после выхода из сессии', 'pageafterlogout', NULL, NULL, '1', 'default', 'system', '1'),
(NULL, 'Не отображать страницу', '2', 'Действие при обнаружении атаки на систему', 'injection_act', NULL, 'Не отображать страницу и оповестить администратора;;Не отображать страницу;;Отправить письмо администратору;;Не предпринимать действий', '1', NULL, 'secure', '1'),
(NULL, 'Убирать WWW', '2', 'Редирект (301) страниц с WWW или без WWW', 'redirect_www', NULL, 'Убирать WWW;;Добавлять WWW,если нет;;Не преобразовывать', '1', NULL, 'seo', '1'),
(NULL, '7200', '1', 'Время кеширования редиректа 301 (WWW) в сек', 'redirect_cachetime', NULL, NULL, '1', NULL, 'system', '1'),


(NULL, '101', 1, 'Длина поля на странице АдминПанели HACTPOuKu (в символах)', 'formsize_standart', 4, NULL, 2, '140', 'adminpanel', 2),
(NULL, '#FFFFFF', 4, 'Цвет фона страниц АдминПанели', 'adminpanelbckclr', NULL, NULL, 1, '#FFFFFF', 'adminpanel', 2),
(NULL, '#545557', 4, 'Цвет шапки в АдминПанели', 'adminheadcolor', NULL, NULL, 1, '#333333', 'adminpanel', 2),
(NULL, '#545557', '4', 'Цвет фона первого экрана в АдминПанели', 'ap_fp_bckclr', NULL, NULL, '1', '#333333', 'adminpanel', '2'),
(NULL, '/adminpanel/pics/Male256.png', 1, 'Логотип в АдминПанели', 'adminlogofile', NULL, NULL, 1, '/files/logo.png', 'adminpanel', 1),
(NULL, '2012 SWP by PWS', '1', 'Текст в нижней части АдминПанели', 'ap_bottomtext', NULL, NULL, '1', '2012 SWP by PWS', 'adminpanel', '1'),
(NULL, 'NO', 1, 'Проверять при входе в АдминПанель попадает ли IP пользователя в range разрешенных адресов', 'adminpanelcorrectipaddress', 100, NULL, 2, 'Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке', 'system', 2),


(NULL, 'Ссылка на сервер Google', '2', 'Способ вставки библиотеки JQuery', 'takejquery', NULL, 'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальный файл /js/lib/jquery/jquery.min.js;;Не вставлять', '1', NULL, 'system', '1'),
(NULL, 'Не вставлять', '2', 'Способ вставки библиотеки JQuery-UI', 'takejqueryui', NULL, 'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-ui/;;Не вставлять', '1', NULL, 'system', '1'),
(NULL, 'Не вставлять', '2', 'Способ вставки библиотеки JQueryMobile', 'takejquerymob', NULL, 'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-mob/;;Не вставлять', '1', NULL, 'system', '1'),
(NULL, 'Ссылка на портал bootstrapcdn.com', '2', 'Способ вставки библиотеки bootstrap', 'takebootstrap', NULL, 'Ссылка на портал bootstrapcdn.com;;Локальные файлы из /js/lib/bootstrap/', '1', NULL, 'system', '1'),
(NULL, 'Не вставлять Bootstrap', '2', 'Где вставить скрипты и стили Bootstrap', 'takebootstrap_where', NULL, 'В header страницы;;В конце страницы;;Не вставлять Bootstrap', '1', NULL, 'system', '1', NULL, NULL),
(NULL, 'Сделать', 2, 'Сделать все текстовые ссылки кликабельными?', 'showtexturlclickable', NULL, 'Сделать;;Не делать', 2, NULL, 'design', 2),
(NULL, 'Не включать', '2', 'Javascript-ускорение при нажатии на кнопки/ссылки ', 'click_eq_msdown', NULL, 'Включить;;Не включать', '1', NULL, 'design', '1'),
(NULL, 'Присоединить', 2, 'Присоединить стиль для красивых CSS-кнопок', 'appendbuttonsstyle', NULL, 'Присоединить;;Не присоединять', 2, NULL, 'design', 2),
(NULL, 'Присоединить', 2, 'Присоединить стиль для красивых Hover-эффектов', 'append_hover_style', NULL, 'Присоединить;;Не присоединять', 2, NULL, 'design', 2),
(NULL, 'Разрешать горизонтальную прокрутку', 2, 'Разрешить горизонтальную прокрутку страницы', 'hidehorizontalscroll', NULL, 'Не разрешать горизонтальную прокрутку;;Разрешать горизонтальную прокрутку', 1, NULL, 'design', 2),
(NULL, 'Подчеркнуть', 2, 'По-умолчанию ссылки подчекнуты?', 'linkdecoration', NULL, 'Подчеркнуть;;Не подчеркивать', 2, NULL, 'system', 1),
(NULL, '1', 1, 'Переменная, указывающая скриптам, что запуск сайта произведен корректно', 'nitka', NULL, NULL, 2, '1', 'system', 2),
(NULL, 'Включено', 2, 'Автоматическое подключение классов из папки functions', 'autoincludeclasses', NULL, 'Включено;;Не включено', 2, NULL, 'system', 2),
(NULL, 'OFF', '2', 'Уровень логирования портала', 'loglevel', NULL, 'DEBUG;;INFO;;WARN;;ERROR;;FATAL;;OFF', '1', 'INFO', 'secure', '1'),
(NULL, 'DEBUG', '2', 'Уровень логирования Админ-панели портала', 'ap_loglevel', NULL, 'DEBUG;;INFO;;WARN;;ERROR;;FATAL;;OFF', '1', 'INFO', 'secure', '1'),
(NULL, 'Собственный лог', '2', 'Файлы логирования', 'writelogto', NULL, 'Собственный лог;;SYSLOG;;Собственный и SYSLOG;;Не логировать', '1', 'SYSLOG', 'system', '1'),
(NULL, 'Писать в лог', '2', 'Подробности о работе MySQL писать в лог?', 'mysqlDebugToLog', NULL, 'Писать в лог;;Не писать в лог', '2', NULL, 'system', '1'),
(NULL, '/logs/', 1, 'Директория для логов в папке проекта', 'log_dir', 100, NULL, 1, '/logs/', 'system', 2),
(NULL, '100', '1', 'Максимальный размер файла логов перед сжатием (MB)', 'max_log_size', NULL, NULL, '1', '100', 'system', '1'),
(NULL, '30', 1, 'Таймаут PHP-сессии в минутах', 'sessionlifetime', 4, NULL, 1, NULL, 'system', 2),
(NULL, 'u@d.c', '1', 'Технический Емейл пользователя, если при регистрации не требуется Email', 'defaultusrcontmail', NULL, NULL, '1', 'user@domain.com', 'system', '2'),
(NULL, 'debug1', '1', 'Параметр, определяющий переход в Debug mode', 'debugmoderequestparam', NULL, NULL, '1', 'Если параметр указать debugm, то перевод в debug mode - &mode=debugm', 'system', '1'),
(NULL, '7200', '1', 'Срок жизни кэша файла стилей (/style) в секундах', 'stylecss_cachetime', NULL, NULL, '1', NULL, 'seo', '1'),
(NULL, '7200', '1', 'Срок жизни кэша файла скриптов (/js) в секундах', 'platfscrpts_cachetime', NULL, NULL, '1', NULL, 'seo', '1'),
(NULL, 'Не присоединять', '2', 'Присоединить стильные чекбоксы', 'appendcheckboxradiocss3style', NULL, 'Присоединить;;Не присоединять', '1', 'Не присоединять', 'design', '1'),
(NULL, 'Включить логирование', '2', 'Включить логирование ошибок PHP в файл', 'php_log_enabled', NULL, 'Включить логирование;;Не включать логирование', '1', NULL, 'system', '1'),
(NULL, '/home/user/PHP_errors.log', '1', 'Файл лога для ошибок PHP', 'PHP_errors_log', NULL, NULL, '1', '/home/user/PHP_errors.log', 'system', '1'),
(NULL, '1', '1', 'Список всех таблиц для мониторинга их существования', 'all_tables_list', NULL, NULL, '1', NULL, 'system', '1'),
(NULL, 'Включено', '2', 'Обслуживание проекта периодическими служебными скриптами (CRON)', 'cronscriptenable', NULL, 'Включено;;Выключено', '1', NULL, 'system', '1'),
(NULL, 'OFF', '2', 'Уровень логирования периодических скриптов (CRON)', 'loglevel_cron', NULL, 'DEBUG;;INFO;;WARN;;ERROR;;FATAL;;OFF', '1', 'INFO', 'secure', '1'),
(NULL, 'admin@domain.com', '1', 'Список Email-ящиков, на который будут присылаться аварийные сообщения из CRON-скриптов', 'cronalarmemail', NULL, NULL, '1', NULL, 'system', '1'),


(NULL, 'xyй|аxуе|бля|блят|доебал|долбое|дохуя|ебал|ебан|ебат|ебет|ебешь|ебё|ебл|ебнет|ебут|ебуч|ёбан|заеб|муда|мудил|наебать|нахуй|нахуя|невъебен|отъебал|отъебис|охуе|охуи|пизд|пиздец|попизд|поху|распиздя|срамк|сука|суки|сцук|сучар|сучка|уебан|херасе|херн|херов|хуев|хует|хули|хуя', '1', 'Список нецензурных и матерных слов, которые будут заменены спецсимволами','badwordslist', NULL, NULL, '1', 'х/п/б', 'user', '1')


;";

/* Депрекейтед
(NULL, 'Включено', 2, 'Возможность отсылать письма пользователям и/или админам', 'includeemail', NULL, 'Включено;;Выключено', 1, NULL, 'system', 2),
(NULL, '12px', 1, 'Размер шрифтов на сайте, если не указано другого', 'htmlfontsize', 8, NULL, 2, '12px', 'system', 2),
(NULL, 'Выйти из Личного кабинета', 1, 'Текст ссылки выхода из кабинета', 'logoutlinktext', 100, NULL, 2, NULL, 'design', 1),
(NULL, 'Разрешать', 2, 'Показывать сайт незарегистрированным пользователям?', 'showsiteforguest', NULL, 'Разрешать;;Не разрешать', 1, 'Ставить РАЗРЕШАТЬ, если на сайте есть страницы общего доступа', 'system', 2),
(NULL, 'Включено', 2, 'Включить модуль юзерлогина', 'enableuserroles', NULL, 'Включено;;Выключено', 2, NULL, 'system', 2),
(NULL, 'adminka', 1, 'Доменное имя второго уровня для АдминПанели', 'adminsubdomainname', 40, NULL, 2, 'admin', 'adminpanel', 2),
*/


$structures['Templates Manager Table']="CREATE TABLE IF NOT EXISTS `$tableprefix-templates_manager` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `template` text NOT NULL,
  `domain` text,
  `url` text,
  `mainpage` varchar(20) DEFAULT NULL COMMENT 'Главная страница темплейта',
  `company_id` int(11) DEFAULT NULL COMMENT 'This rule only for company_id',
  `onoff` enum('on','off') NOT NULL DEFAULT 'on' COMMENT 'Включение работы правила',
  `comment` text,
  `sitemap_on` enum('744','168','24','12','3','1','0') NOT NULL DEFAULT '0' COMMENT 'Create sitemap for this domain',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Менеджер шаблонов сайта';";

$DBdata['Templates Manager data']="
INSERT INTO `$tableprefix-templates_manager` (`rule_id`, `template`, `domain`, `url`, `mainpage`, `onoff`, `comment`) VALUES
(NULL, 'templatename', 'domain.com', NULL, 'template_main_page', 'on', 'Описание шаблона');";



// Таблица пользователей не-админов
$structures['Users Table']="CREATE TABLE $check_tables_existing `$tableprefix-users` (
 `userid` int(7) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `userrole` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'user',
  `nickname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `fullname` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `second_name` text CHARACTER SET utf8 COMMENT 'Фамилия',
  `first_name` text CHARACTER SET utf8 COMMENT 'Имя',
  `patronymic_name` text CHARACTER SET utf8 COMMENT 'Отчество',
  `gender` enum('-','male','female') CHARACTER SET utf8 NOT NULL DEFAULT '-' COMMENT 'Пол',
  `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
  `adult` tinyint(1) DEFAULT NULL COMMENT 'Совершеннолетний',
  `company_id` int(11) DEFAULT NULL,
  `contactmail` varchar(40) DEFAULT NULL,
  `contact_phone` varchar(30) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL COMMENT 'Страна, указанная при регистрации',
  `city_id` int(11) DEFAULT NULL COMMENT 'Город, указанный при регистрации',
  `region_id` int(11) DEFAULT NULL COMMENT 'Регион, указанный при регистрации',
  `address` text CHARACTER SET utf8 COMMENT 'Адрес, указанный при регистрации',
  `is_allowed_personal` int(1) DEFAULT '1' COMMENT '1 - разрешил обработку персональных данных',
  `user_photo` text COMMENT 'From photos table or just path',
  `status` varchar(15) NOT NULL DEFAULT 'deactivate' COMMENT 'active/deactive/between/blocked/admin_suspended',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regsecretkey` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000;";

// Таблица пользователей админов
$structures['Admin Users Table']="CREATE TABLE $check_tables_existing `$tableprefix-users-admin` (
  `userid` int(7) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `userrole` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'admin',
  `nickname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `fullname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `contactmail` varchar(40) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'deactivate' COMMENT 'active/deactive/between',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regsecretkey` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `ActivationLink` varchar(30) DEFAULT NULL,
  `DeactivationLink` varchar(30) DEFAULT NULL,
  `changepassmust` int(1) NOT NULL DEFAULT '1' COMMENT '1 - не надо менять пасс, 2- должен менять при след логине',
  `password_history` text CHARACTER SET utf8 NOT NULL COMMENT 'История паролей',
  `passw_last_change_date` date DEFAULT NULL COMMENT 'Дата последнего изменения пароля',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid` (`userid`),
  KEY `login` (`login`),
  KEY `password` (`password`),
  KEY `userid_2` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

// Добавление админа (admin/admin)
$DBdata['Adding of admin (admin/admin)']="INSERT INTO `$tableprefix-users-admin` (`userid`, `login`, `password`, `userrole`, `nickname`, `fullname`, `contactmail`, `status`, `timestamp`, `regsecretkey`, `ActivationLink`, `DeactivationLink`, `changepassmust`) VALUES (NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'root', 'Администратор', 'Администратор', 'admin@example.ru', 'active', CURRENT_TIMESTAMP, NULL, NULL, NULL, '2');";

// Группы пользователей
$structures['User Groups Table']="CREATE TABLE $check_tables_existing `$tableprefix-users-groups` (
  `group_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Номер группы',
  `groupname` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'ID пользователя',
  `onoff` enum('on','off','','') NOT NULL DEFAULT 'on' COMMENT 'on/off',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

// Группа root
$DBdata['Creating of default groups ROOT and PUBLIC']="INSERT INTO `$tableprefix-users-groups`(`group_id`,`groupname` ,`onoff`)VALUES ('1','root', 'on'),('2', 'public', 'on');";

$structures['Group Rights Table']="CREATE TABLE $check_tables_existing `$tableprefix-users-grouprights` (
   `gright_id` int(11) NOT NULL COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `oid` int(10) NOT NULL COMMENT 'ObjectID (0-all objects)',
  `table` varchar(40) NOT NULL COMMENT 'В какой табличке OID',
  `grant` int(1) NOT NULL DEFAULT '1' COMMENT '1-access_granted,2-access_deny'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$DBdata['Adding rights for ROOT group']="INSERT INTO `$tableprefix-users-grouprights` (`group_id`, `oid`,`table`, `grant`) VALUES (1, 0,'$tableprefix-siteconfig', 1);";

// Таблица участников групп
$structures['Group Members Table']="CREATE TABLE $check_tables_existing `$tableprefix-users-groupmembers` (
  `gm_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `userid` int(5) NOT NULL COMMENT 'ID пользователя',
   PRIMARY KEY (`gm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$DBdata['Adding of ADMIN to ROOT group']="INSERT INTO `$tableprefix-users-groupmembers` (`group_id`, `userid`) VALUES ('1', '1');";

$structures['Companies Table']="
CREATE TABLE $check_tables_existing `$companiesprefix-companies` (
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
  `company_tag` TEXT NULL DEFAULT NULL COMMENT 'Tags, group, some com-link for company',
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$structures['Gallery Table']="CREATE TABLE $check_tables_existing `$tableprefix-galleries` (
  `gallery_id` int(6) NOT NULL AUTO_INCREMENT,
  `gallery_title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
   PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$DBdata['Adding default gallery']="INSERT INTO `$tableprefix-galleries` (`gallery_id` ,`gallery_title`)VALUES ('0', 'Галерея');";

$structures['Photos Table']="CREATE TABLE $check_tables_existing `$tableprefix-photos` (
  `photo_id` int(6) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(6) DEFAULT NULL,
  `photo_path` varchar(1000) NOT NULL,
  `photo_title` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";

$structures['Messages Table']="CREATE TABLE $check_tables_existing `$tableprefix-messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID сообщения',
  `module_name` varchar(30) DEFAULT 'system' COMMENT 'Имя модуля (или system)',
  `message_code` text NOT NULL COMMENT 'Код сообщения внутри модуля',
  `message_meaning` text COMMENT 'В каком случае появляется сообщение',
  `message_ru` text COMMENT 'Текст сообщения на русском',
  `message_en` text COMMENT 'Текст сообщения на английском',
  `company_id` int(11) DEFAULT NULL COMMENT 'Сообщение определено только для одной компании',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица сообщений портала' AUTO_INCREMENT=1;";

$DBdata['Adding Default Messages']="INSERT INTO `$tableprefix-messages` (`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
(NULL, 'system', 'sc_access_granted', 'Сообщение об успешном прохождении аутентификации и входе в личный кабинет', 'Добро пожаловать в личный кабинет услуги WiFi', 'Welcome to Self Care portal'),
(NULL, 'system', 'fill_all_fields', 'Сообщение при неполном заполнении формы логина (пропущен логин или пароль)', 'Заполните все поля', 'Please, fill all included fields'),
(NULL, 'system', 'Pass_is_digits_or_letters', 'Сообщение при некорректных символах в пароле', 'Пароль должен состоять из цифр и/или английских букв', 'Password should contain only digits and/or letters'),
(NULL, 'system', 'Session_parameters_is_wrong(1)', 'Сообщение для роботов, заполнивших секретное поле', 'Подделка параметров сессии (1)', 'Session parameters is wrong (1)'),
(NULL, 'system', 'Unknown_error', 'Неизвестная ошибка во время логина', 'Неизвестная ошибка', 'Unknown error'),
(NULL, 'system', 'Should_change_pass', 'Сообщение об обязательной смене пароля', 'Пожалуйста, измените Ваш пароль', 'Please, change your password'),
(NULL, 'system', 'LoginPass_is_wrong', 'Неправильно введены логин/пароль', 'Пользователь с таким логином и/или паролем не найден', 'User with that login and/or password is not found'),
(NULL, 'system', 'Pass_is_wrong', 'Неверный пароль пользователя', 'Неверно введен пароль пользователя', 'Password is wrong'),
(NULL, 'system', 'Login_is_wrong', 'Пользователь с таким логином не найден', 'Пользователь с таким логином не найден', 'Login is wrong'),
(NULL, 'system', 'Login_is_only_digits', 'Логин должен состоять из цифр', 'Логин должен состоять из цифр', 'Login should contain only digits'),
(NULL, 'system', 'User_is_not_active', 'Пользователь не активен', 'Извините, Ваш аккаунт не активен', 'Sorry, your account is not in ACTIVE state'),
(NULL, 'system', 'logout_complete', 'Сообщение о выходе из сессии', 'Вы успешно вышли из сессии', 'You are logged off completelly'),
(NULL, 'system', 'logout_no_complete', 'Сообщение о невозможности выхода из сессии', 'Невозможно выйти из сессии', 'The session can''t be clossed. ERROR'),
(NULL, 'system', 'Logon blocked.Small period', 'Попытка входа, прошло слишком мало времени.', 'Извините, вход под этой учетной записью временно заблокирован, превышен предел количества попыток входа', 'Attempt to logon was blocked because too small time period'),
(NULL, 'system', 'template_has_no_found', 'Если не определен template портала', 'Невозможно определить шаблон портала ($sitetemplate)', 'Site template is not found ($sitetemplate)'),
(NULL, 'system', 'template_doctype_has_no_found', 'Если не найден файл doctype шаблона', 'Не найден doctype шаблона портала (doctype.php)', 'Doctype file is not found (doctype.php)'),
(NULL, 'system', 'template_scripts_has_no_found', 'Если не найден файл scripts_and_styles шаблона', 'Не найден файл script_and_styles.php шаблона', 'scripts_and_styles.php is not found'),
(NULL, 'system', 'template_body_has_no_found', 'Если не найден файл body шаблона', 'Не найден файл body.php шаблона', 'body.php is not found'),
(NULL, 'system', 'module_name_missed', 'Модуль не найден. Пропущено название модуля при вызове функции insert_module().', 'Модуль не найден. Пропущено название модуля при вызове функции insert_module().', 'Module is not found. Module name was missed when calling insert_module() function.'),
(NULL, 'system', 'module_not_installed', 'Сообщение о неуспешной установке любого модуля', 'Модуль НЕ установлен при первом запуске', 'Module NOT installed at first start'),
(NULL, 'system', 'module_hasnot_config', 'Сообщение о неуспешной исталляции модуля по причине отсутствия конфиг-файла', 'Модуль не установлен, отсутствует конфиг файл', 'Module was not installed, but there is no config file for'),
(NULL, 'system', 'module_installed', 'Сообщение о успешной установке любого модуля', 'Модуль успешно установлен при первом запуске', 'Module successfully installed at first start'),
(NULL, 'system', 'you_have_no_privileges_for_operation', 'Не хватает привилегий для выполнения операции', 'Не хватает привилегий для выполнения операции', 'You have no enough privileges for this operation'),
(NULL, 'system', 'you_have_no_privileges_to_see', 'Не хватает привилегий для просмотра элемента', 'Извините, у Вас недостаточно привилегий для просмотра', 'You have no enough privileges to see this element'),
(NULL, 'system', 'new_user_succ_added', 'Новый пользователь успешно добавлен в БД', 'Пользователь успешно добавлен', 'The new user has been added successfully'),
(NULL, 'system', 'email_already_exists', 'Невозможно добавить нового пользователя, такой е-мейл найден в БД', 'Пользователь с таким email уже существует в системе', 'The user with that e-mail is already exist in the site database'),
(NULL, 'system', 'new_user_is_not_inserted', 'Не прошел запрос на добавление нового пользователя', 'Не удалось добавить пользователя', 'The new user has not been added');";




$structures['Log files management table']="CREATE TABLE $check_tables_existing `$tableprefix-logmanager` (
  CREATE TABLE `freecon-logmanager` (
  `rule_id` int(11) NOT NULL,
  `rule_name` text COMMENT 'Name of rule',
  `file` text NOT NULL COMMENT 'Log File',
  `log_level` enum('DEBUG','INFO','WARN','ERROR','FATAL','OFF') NOT NULL DEFAULT 'DEBUG' COMMENT 'Log level for this file',
  `ip` text COMMENT 'Log only for user with this ip',
  `page` text COMMENT 'Log only for query to this page',
  `site_domain` text COMMENT 'Log only for query to this domain',
  `login` text COMMENT 'Log only for user with this login',
  `company_id` int(11) DEFAULT NULL COMMENT 'Log only for user from this company (company_ID)',
  `userrole` enum('user','admin','root','-') NOT NULL DEFAULT '-',
  `uri` text,
  `request_type` enum('all','ajax','style','cron') NOT NULL DEFAULT 'all' COMMENT 'Log only this type of requests',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Rules for logging' AUTO_INCREMENT=1;";


}
?>