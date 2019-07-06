-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: wifi
-- ------------------------------------------------------
-- Server version 	5.5.44-MariaDB
-- Date: Tue, 02 Feb 2016 17:20:40 +0000

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wifi-companies`
--

DROP TABLE IF EXISTS `wifi-companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-companies`
--

LOCK TABLES `wifi-companies` WRITE;
/*!40000 ALTER TABLE `wifi-companies` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-companies` VALUES (1,NULL,'М.Видео',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-01-28 06:42:33','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wifi-companies` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-galleries`
--

DROP TABLE IF EXISTS `wifi-galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-galleries` (
  `gallery_id` int(6) NOT NULL,
  `gallery_title` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-galleries`
--

LOCK TABLES `wifi-galleries` WRITE;
/*!40000 ALTER TABLE `wifi-galleries` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-galleries` VALUES (0,'Галерея');
/*!40000 ALTER TABLE `wifi-galleries` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-menus`
--

DROP TABLE IF EXISTS `wifi-menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-menus`
--

LOCK TABLES `wifi-menus` WRITE;
/*!40000 ALTER TABLE `wifi-menus` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-menus` VALUES (1,'cabinet',1,'/?page=cabinet&cact=show_user_info','Сведения о пользователе','Новый пункт','New item',NULL,NULL,'',NULL,NULL,NULL,'not_ready');
INSERT INTO `wifi-menus` VALUES (2,'cabinet',2,'/?page=cabinet&cact=users_management','Управление пользователями','Новый пункт','New item',NULL,NULL,'',NULL,NULL,NULL,'not_ready');
/*!40000 ALTER TABLE `wifi-menus` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-messages`
--

DROP TABLE IF EXISTS `wifi-messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID сообщения',
  `module_name` varchar(30) DEFAULT 'system' COMMENT 'Имя модуля (или system)',
  `message_code` text NOT NULL COMMENT 'Код сообщения внутри модуля',
  `message_meaning` text COMMENT 'В каком случае появляется сообщение',
  `message_ru` text COMMENT 'Текст сообщения на русском',
  `message_en` text COMMENT 'Текст сообщения на английском',
  `company_id` int(11) DEFAULT NULL COMMENT 'Сообщение определено только для одной компании',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COMMENT='Таблица сообщений портала';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-messages`
--

LOCK TABLES `wifi-messages` WRITE;
/*!40000 ALTER TABLE `wifi-messages` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-messages` VALUES (1,'system','fill_all_fields','Сообщение при неполном заполнении формы логина (пропущен логин или пароль)','Заполните все поля','Please, fill all required fields',NULL);
INSERT INTO `wifi-messages` VALUES (2,'system','Pass_is_digits_or_letters','Сообщение при некорректных символах в пароле','Пароль должен состоять из цифр и/или английских букв','Password should contain only digits and/or letters',NULL);
INSERT INTO `wifi-messages` VALUES (3,'system','Session_parameters_is_wrong(1)','Сообщение для роботов, заполнивших секретное поле','Подделка параметров сессии (1)','Session parameters is wrong (1)',NULL);
INSERT INTO `wifi-messages` VALUES (4,'system','Unknown_error','Неизвестная ошибка во время логина','Неизвестная ошибка','Unknown error',NULL);
INSERT INTO `wifi-messages` VALUES (5,'system','Should_change_pass','Сообщение об обязательной смене пароля','Пожалуйста, измените Ваш пароль','Please, change your password',NULL);
INSERT INTO `wifi-messages` VALUES (6,'system','LoginPass_is_wrong','Неправильно введены логин/пароль','Пользователь с таким логином и/или паролем не найден','User with that login and/or password is not found',NULL);
INSERT INTO `wifi-messages` VALUES (7,'system','Pass_is_wrong','Неверный пароль пользователя','Неверно введен пароль пользователя','Password is wrong',NULL);
INSERT INTO `wifi-messages` VALUES (8,'system','Login_is_wrong','Пользователь с таким логином не найден','Пользователь с таким логином не найден','Login is wrong',NULL);
INSERT INTO `wifi-messages` VALUES (9,'system','Login_is_only_digits','Логин должен состоять из цифр','Логин должен состоять из цифр','Login should contain only digits',NULL);
INSERT INTO `wifi-messages` VALUES (10,'system','User_is_not_active','Пользователь не активен','Извините, Ваш аккаунт не активен','Sorry, your account is not in ACTIVE state',NULL);
INSERT INTO `wifi-messages` VALUES (11,'system','template_has_no_found','Если не определен template портала','Невозможно определить шаблон портала ()','Site template is not found ()',NULL);
INSERT INTO `wifi-messages` VALUES (12,'system','template_doctype_has_no_found','Если не найден файл doctype шаблона','Не найден doctype шаблона портала (doctype.php)','Doctype file is not found (doctype.php)',NULL);
INSERT INTO `wifi-messages` VALUES (13,'system','template_scripts_has_no_found','Если не найден файл scripts_and_styles шаблона','Не найден файл script_and_styles.php шаблона','scripts_and_styles.php is not found',NULL);
INSERT INTO `wifi-messages` VALUES (14,'system','template_body_has_no_found','Если не найден файл body шаблона','Не найден файл body.php шаблона','body.php is not found',NULL);
INSERT INTO `wifi-messages` VALUES (15,'system','module_name_missed','Модуль не найден. Пропущено название модуля при вызове функции insert_module().','Модуль не найден. Пропущено название модуля при вызове функции insert_module().','Module is not found. Module name was missed when calling insert_module() function.',NULL);
INSERT INTO `wifi-messages` VALUES (16,'system','module_not_installed','Сообщение о неуспешной установке любого модуля','Модуль НЕ установлен при первом запуске','Module NOT installed at first start',NULL);
INSERT INTO `wifi-messages` VALUES (17,'system','module_hasnot_config','Сообщение о неуспешной исталляции модуля по причине отсутствия конфиг-файла','Модуль не установлен, отсутствует конфиг файл','Module was not installed, but there is no config file for',NULL);
INSERT INTO `wifi-messages` VALUES (18,'system','logout_complete','Сообщение о выходе из сессии','Вы успешно вышли из сессии','You are logged off completelly',NULL);
INSERT INTO `wifi-messages` VALUES (19,'system','module_installed','Сообщение после успешной установки любого модуля','Модуль успешно установлен при первом запуске','Module successfully installed at first start',NULL);
INSERT INTO `wifi-messages` VALUES (20,'system','you_have_no_privileges_for_operation','Не хватает привилегий для выполнения операции','Не хватает привилегий для выполнения операции','You have no enough privileges for this operation',NULL);
INSERT INTO `wifi-messages` VALUES (21,'system','you_have_no_privileges_to_see','Не хватает привилегий для просмотра элемента','Извините, у Вас недостаточно привилегий для просмотра','You have no enough privileges to see this element',NULL);
INSERT INTO `wifi-messages` VALUES (22,'system','new_user_succ_added','Новый пользователь успешно добавлен в БД','Пользователь успешно добавлен','The new user has been added successfully',NULL);
INSERT INTO `wifi-messages` VALUES (23,'system','email_already_exists','Невозможно добавить нового пользователя, такой е-мейл найден в БД','Пользователь с таким email уже существует в системе','The user with that e-mail is already exist in the site database',NULL);
INSERT INTO `wifi-messages` VALUES (24,'system','Logon blocked.Small period','Попытка входа, прошло слишком мало времени.','Извините, вход под этой учетной записью временно заблокирован, превышен предел количества попыток входа','Attempt to logon was blocked because too small time period',NULL);
INSERT INTO `wifi-messages` VALUES (25,'system','new_user_is_not_inserted','Не прошел запрос на добавление нового пользователя','Не удалось добавить пользователя','The new user has not been added',NULL);
INSERT INTO `wifi-messages` VALUES (26,'start_site_subscribe','DB_issue','Сообщение о невозможности подписаться на оповещение о запуске портала','Извините, возникли проблемы с Базой Данных','Sorry, there is some database issue',NULL);
INSERT INTO `wifi-messages` VALUES (27,'start_site_subscribe','trying_failed','Сообщение при повторной попытке подписаться без перезапуска страницы','Извините, попытка не удалась, повторная подписка','Sorry, trying is failed',NULL);
INSERT INTO `wifi-messages` VALUES (28,'start_site_subscribe','email_already_exists','Емейл уже подписан на оповещение о запуске портала','Вы уже подписаны на оповещение','You already subscribed',NULL);
INSERT INTO `wifi-messages` VALUES (29,'start_site_subscribe','successfully_inserted','Сообщение об удачной подписке на оповещение о запуске портала','Мы уведомим Вас о запуске сайта по указанному e-mail','We let you know when site will start to work',NULL);
INSERT INTO `wifi-messages` VALUES (30,'change_password','fill_all_required','Не заполнены все поля при смене пароля','Пожалуйста, заполните все обязательные поля','Please fill all required fields',NULL);
INSERT INTO `wifi-messages` VALUES (31,'change_password','wrong_cur_pass','Неверно введенный текущий пароль','Вы указываете неверный текущий пароль','You are filled in wrong current password',NULL);
INSERT INTO `wifi-messages` VALUES (32,'change_password','pass_changed_succ','Пароль изменен успешно','Пароль успешно изменен','Password changed successfully',NULL);
INSERT INTO `wifi-messages` VALUES (33,'change_password','password_wasnt_changed','Пароль не был изменен, не прошел запрос в БД','Пароль не был изменен','Password changed successfully',NULL);
INSERT INTO `wifi-messages` VALUES (34,'change_password','new_passes_not_equal','Присланные пароли не совпадают','Присланные пароли не совпадают','The new passwords are not equal',NULL);
INSERT INTO `wifi-messages` VALUES (35,'registration_form','wrong_activation_qry','Неправильная строка активации или пользователь уже был активирован ранее','Неправильная строка активации или пользователь уже был активирован ранее.','Wrong get string or user was activated earlier',NULL);
INSERT INTO `wifi-messages` VALUES (36,'registration_form','activation_complete','Сообщение об удачной активации нового пользователя','C Вами свяжется менеджер SaaS по указанному номеру телефона:','Our manager will communicate with you by the phone:',NULL);
INSERT INTO `wifi-messages` VALUES (37,'registration_form','user_cant_be_added','Неудачная попытка добавить нового пользователя','Не удалось добавить пользователя','We can\'t add that user',NULL);
INSERT INTO `wifi-messages` VALUES (38,'registration_form','user_already_exists','Пользователь с указанным email уже существует','Пользователь с указанным номером уже существует, воспользуйтесь порталом авторизации','User with that e-mail address already exists in database',NULL);
INSERT INTO `wifi-messages` VALUES (39,'registration_form','success_deactivation','Сообщение об успешной деактивации нового абонента','<h1>Пользователь успешно деактивирован</h1><p>Спасибо за сообщение</p>','<h1>User was successfully deactivated</h1><p>Thanks a lot!</p>',NULL);
INSERT INTO `wifi-messages` VALUES (40,'registration_form','failed_deactivation','Сообщение о неудачной попытке деактивации нового пользователя','<h1>Пользователь не деактивирован:</h1> <p>Неправильная строка деактивации или пользователь уже был деактивирован ранее.</p>','<h1>User was not deactivated:</h1> <p>Wrong query or user was already deactivated before.</p>',NULL);
INSERT INTO `wifi-messages` VALUES (41,'registration_form','mail_was_sent','Сообщение об отправке подтверждающего e-mail','На указанный e-mail выслано письмо для подтверждения.</p><p>После подтверждения e-mail с Вами свяжется менеджер SaaS по указанному номеру телефона.','Activation mail was sent on your e-mail. After activation our manager will communicate with you by the phone.',NULL);
INSERT INTO `wifi-messages` VALUES (43,'registration_form','activation_complete','Сообщение об удачной активации нового пользователя','Вы успешно зарегистрировались. Пожалуйста, переключитесь на сеть RT-EAP','Registration complete. Please, choose RT-EAP network',NULL);
INSERT INTO `wifi-messages` VALUES (77,'system','access_granted','Сообщение об успешном прохождении аутентификации и возможности доступа в интернет','Логин и пароль введены корректно. Доступ в интернет предоставлен.','Your login and pass is valid. Internet access granted.',NULL);
INSERT INTO `wifi-messages` VALUES (78,'registration_form','activation_complete','Сообщение об удачной активации нового пользователя','Вы успешно зарегистрировались. Пожалуйста, введите логин и пароль в форму слева','Registration complete. Please, fill the left login form',1);
INSERT INTO `wifi-messages` VALUES (79,'system','logout_no_complete','Сообщение о невозможности выхода из сессии','Невозможно выйти из сессии','The session can\'t be clossed. ERROR',NULL);
INSERT INTO `wifi-messages` VALUES (80,'system','sc_access_granted','Сообщение об успешном прохождении аутентификации и входе в личный кабинет','Добро пожаловать в личный кабинет услуги WiFi','Welcome to Self Care portal',NULL);
/*!40000 ALTER TABLE `wifi-messages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-modulesregister`
--

DROP TABLE IF EXISTS `wifi-modulesregister`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-modulesregister` (
  `module_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ID модуля',
  `modulename` varchar(30) NOT NULL COMMENT 'Название модуля SWP',
  `moduletype` text COMMENT 'Тип модуля',
  `module_description` text COMMENT 'Описание модуля',
  `installed` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'y=инсталлирован',
  `install_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата инсталляции/последнего включения',
  `enabled` enum('enabled','disabled') NOT NULL DEFAULT 'enabled' COMMENT 'Включение работы модуля',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-modulesregister`
--

LOCK TABLES `wifi-modulesregister` WRITE;
/*!40000 ALTER TABLE `wifi-modulesregister` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-modulesregister` VALUES (1,'templates_manager','templates_manager','Модуль управления шаблонами сайта','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (2,'rss','','RSS-лента новостей портала','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (3,'counter-googleanalytics','counter-googleanalytics','Google Analytics','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (4,'counter-liveinternet','','Счетчик LiveInternet','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (5,'counter-yandex','','Счетчик Yandex-метрика','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (6,'start_site_subscribe','start_site_subscribe','Модуль подписки на оповещение о запуске портала','y','2016-01-19 07:06:15','enabled');
INSERT INTO `wifi-modulesregister` VALUES (7,'bookmark','','Мультибраузерная функция добавления в закладки','y','2016-01-19 07:06:43','enabled');
INSERT INTO `wifi-modulesregister` VALUES (8,'counter-ga_tagmanager','counter-ga_tagmanager','Google Analytics Tag Manager Counter','y','2016-01-19 07:22:36','enabled');
INSERT INTO `wifi-modulesregister` VALUES (9,'loginform_simple','loginform_simple','loginform_simple','y','2016-01-19 17:33:57','enabled');
INSERT INTO `wifi-modulesregister` VALUES (10,'sms_smscru','sms_smscru','Send SMS via smsc.ru','y','2016-01-19 17:36:13','enabled');
INSERT INTO `wifi-modulesregister` VALUES (11,'change_password','change_password','Модуль с функцией изменения пароля','y','2016-01-19 18:37:55','enabled');
INSERT INTO `wifi-modulesregister` VALUES (12,'registration_form','','Форма регистрации на портале','y','2016-01-22 12:27:38','enabled');
/*!40000 ALTER TABLE `wifi-modulesregister` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-pages`
--

DROP TABLE IF EXISTS `wifi-pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-pages`
--

LOCK TABLES `wifi-pages` WRITE;
/*!40000 ALTER TABLE `wifi-pages` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-pages` VALUES (1,'default','Успешная установка SWP','SWP successfully installed','/html/','default','php',NULL,NULL,NULL,NULL,0,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (2,'forgot_pass','Восстановление пароля','Password recovery',NULL,NULL,NULL,NULL,NULL,'forgot_password','defaultmenu',0,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (3,'HACTPOuKu','Настройки','Settings','/adminpanel/pages/','settings','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (4,'admin_hello','Администраторская панель','Administration dashboard','/adminpanel/pages/','admin_hello','php','Добро пожаловать в администраторскую панель сайта','Welcome to site administration dashboard',NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (5,'change_admin_password','Изменение пароля','Change password','/adminpanel/pages/','change_password','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (6,'cabinet','Личный кабинет пользователя','User self care','/core/usersmanagement/','cabinet','php',NULL,NULL,NULL,'cabinet',0,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (7,'MoDyJlu','Управление модулями','Modules management','/adminpanel/pages/','modules','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (8,'CTPAHuUbI','Управление страницами','Pages management','/adminpanel/pages/','pages','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (9,'noJlb3oBaTeJlu','Управление пользователями','Users management','/adminpanel/pages/','users_management','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (10,'KapTuHKu','Управление картинками и галереями','Pictures and galaries management','/adminpanel/pages/','pictures','php',NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (11,'TeKcToBku','Сообщения платформы','Platform messages','/adminpanel/pages/','messages','php',NULL,NULL,NULL,NULL,0,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (12,'rtk_wifi_cp','Страница авторизации WiFi','WiFi Captive Portal','/pages/','rtk_wifi_cp.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'Вход в интернет сети WiFi Ростелеком',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (13,'test',NULL,NULL,'/pages/','test.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'ТЕСТ',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (14,'rtk_wifi_free','Свободно предоставляемые ресурсы WiFi',NULL,'/pages/','rtk_wifi_free_sandbox.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'УЦН',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (15,'rtk_main','Демо-стенд WiFi для Ростелеком',NULL,'/pages/','rtk_main.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'ВСЕ СТРАНИЦЫ WiFi',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (16,'wifi_reg','Страница регистрации в сети WiFi','WiFi Registration Page','/pages/','wifi_reg.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'Регистрация в сети WiFi',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (17,'rtk_wifi_sc','Личный кабинет WiFi','WiFi Self Care Portal','/pages/','rtk_wifi_sc.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'Личный кабинет WiFi Ростелеком',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (18,'wifi_sc_main','Личный кабинет WiFi. Главная','WiFi Self Care Portal','/pages/','wifi_sc_main.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'Личный кабинет WiFi Ростелеком.Главная',NULL,NULL,NULL,NULL,NULL,0,NULL);
INSERT INTO `wifi-pages` VALUES (19,'wifi_mvideo','Войти в интернет через сеть WiFi М.Видео','WiFi Caprive Care Portal M.Video','/pages/','wifi_mvideo_cp.php',NULL,NULL,NULL,NULL,NULL,0,1,NULL,'Вход в интернет WiFi М.Видео',NULL,NULL,NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `wifi-pages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-photos`
--

DROP TABLE IF EXISTS `wifi-photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-photos` (
  `photo_id` int(6) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(6) DEFAULT NULL,
  `photo_path` varchar(1000) NOT NULL,
  `photo_title` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-photos`
--

LOCK TABLES `wifi-photos` WRITE;
/*!40000 ALTER TABLE `wifi-photos` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `wifi-photos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-siteconfig`
--

DROP TABLE IF EXISTS `wifi-siteconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-siteconfig`
--

LOCK TABLES `wifi-siteconfig` WRITE;
/*!40000 ALTER TABLE `wifi-siteconfig` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-siteconfig` VALUES (1,'wifi.romanyuk.me',1,'Доменное имя сайта','sitedomainname',NULL,NULL,1,'example.ru','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (2,'Включить',3,'Включение работы сайта','shutdownsite',NULL,'Включить;;НЕ ПОКАЗЫВАТЬ',2,'Включить','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (3,'Подделка параметров сессии (1)',2,'Включить страницу реконструкции вместо сайта','reconstruction_page',NULL,'Включить;;Не включать',2,NULL,'user',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (4,'2016-2-19 12:05',1,'Дата запуска портала','sitestartdate',NULL,NULL,1,'2014-01-01','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (5,'swp',1,'Шаблон','currenttemplate',20,NULL,1,NULL,'system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (6,'ru',1,'Язык сайта по умолчанию','default_language',5,NULL,1,'en','user',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (7,'default',1,'Страница, которая будет показана пользователю первой после входа','default_page',25,NULL,1,'main','design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (8,'SWP от PWS - гибкая веб-платформа для Вашего бизнеса',1,'Заголовок странички','title',NULL,NULL,1,NULL,'seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (9,'SWP от PWS - гибкая веб-платформа для Вашего бизнеса',1,'МЕТА-тег  \'Keywords\'','keywords',NULL,NULL,1,NULL,'seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (10,'SWP от PWS - гибкая веб-платформа для Вашего бизнеса',1,'МЕТА-тег \'Description\'','description',NULL,NULL,1,NULL,'seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (11,'Все права принадлежат владельцу ресурса',1,'МЕТА-тег \'copyright\'','meta_copyright',NULL,NULL,1,'Все права принадлежат владельцу ресурса','seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (12,'SWP от PWS - гибкая веб-платформа для Вашего бизнеса',1,'ALT для логотипа','logoalt',200,NULL,2,NULL,'seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (13,'PopWebStudio.RU (Romanyuk Alexey) skype:romanyukalex tel:+79015139363',1,'META-тег Autor','autormeta',300,NULL,2,'PopWebStudio.RU (Romanyuk Alexey) skype:romanyukalex tel:+79015139363','seo',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (14,'12px',1,'Размер шрифтов на сайте, если не указано другого','htmlfontsize',8,NULL,2,'12px','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (15,'Неправильное обращение к серверу. Просим Вас не заходить за рамки сценариев сайта',1,'Текст сообщения пользователям в случае неверного обращения к серверу: неправильная строка запроса, подделка некоторых параметров системы','wrongquery',500,NULL,1,'Неправильное обращение к серверу. Просим Вас не заходить за рамки сценариев сайта.','design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (16,'#000000',4,'Цвет фона сайта','bodybackgrcolor',7,NULL,2,'#ffffff','design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (17,'/project/wifi/templates/rtkwifi/files/logo-rt0.png',1,'Файл логотипа','logofile',100,NULL,1,NULL,'design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (18,'/project/swp/templates/swp/files/favicon.png',1,'Favicon. Путь до полноцветной картинки (shortcut)','favicon_shortcut_path',NULL,NULL,1,'/files/favicon.png','design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (19,'8 800 707 50 50',1,'Официальный телефон в Блоке с контактами','contactphone',20,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (20,'admin@domain.com',1,'Официальный мейл компании','officialemail',100,NULL,1,'info@domain.ru','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (21,'Включено',2,'Возможность отсылать письма пользователям и/или админам','includeemail',NULL,'Включено;;Выключено',1,NULL,'system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (22,'Администрация портала',1,'При отправке автоматических сообщений с сайта - поле ОТ КОГО','from',200,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (23,'info@domain.com',1,'Адрес емейл, с которого будут отсылаться письма портала','emailaddress',NULL,NULL,1,'info@domain.com','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (24,'Заполнена заявка на сайте',1,'При отправке автоматических сообщений с сайта - поле ТЕМА','subject',200,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (25,'Выйти из Личного кабинета',1,'Текст ссылки выхода из кабинета','logoutlinktext',100,NULL,2,NULL,'design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (26,'Запретить',2,'Разрешить запросы других шаблонов портала через GET-запросы','ch_template',NULL,'Разрешить;;Запретить',1,'Запретить','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (27,'Разрешать',2,'Разрешать незарегистрированным вход на сайт?','showsiteforguest',NULL,'Разрешать;;Не разрешать',1,'Ставить РАЗРЕШАТЬ, если на сайте есть страницы общего доступа','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (28,'Включено',2,'Включить модуль юзерлогина','enableuserroles',NULL,'Включено;;Выключено',2,NULL,'system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (29,'Любые символы',2,'Логин должен быть только цифровым','loginisonlydigits',NULL,'Любые символы;;Только цифры',1,'Любые символы','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (30,'Пожалуйста, заполните все обязательные поля2',2,'В качестве логина использовать Имя_пользователя/емейл/оба','authlogin',NULL,'only_login;;only_email;;both',1,'only_login','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (31,'5',1,'Количество попыток ввода пароля до временной блокировки ввода пароля','passinptrymaxcount',NULL,NULL,2,'','secure',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (32,'900',1,'Время блокировки (в секундах) входа на портал при достижении максимального количества попыток входа','passinptrydelay',NULL,NULL,1,'900','secure',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (33,'Локальная',2,'Способы аутентификации','login_method',NULL,'Локальная;;LDAP;;Скрипт',1,'Локальная','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (34,'100',1,'Максимальное количество символов пароля','passmaxletter',3,NULL,1,'100','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (35,'Пароль',2,'При неверном введении пароля уведомлять о неверности только пароля, или неверности всей связки Login/Pass','showpasserror',NULL,'Пароль;;Связка',1,'Пароль','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (36,'NO',1,'Проверять при входе на сайт попадает ли IP пользователя в range разрешенных адресов','sitecorrectipaddress',NULL,NULL,2,'Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (37,'show_user_info',2,'Страничка личного кабинета пользователя по-умолчанию','default_cact',NULL,'-;;show_user_info;;change_password',1,'','design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (38,'default',1,'Страница,которая будет показана пользователю после выхода из сессии','pageafterlogout',NULL,NULL,1,'default','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (39,'DGup3X6fLFDB7a3WoQOEA',1,'Модуль TWITTER - CONSUMER_KEY','twitterconsumerkey',NULL,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (40,'RKyE2pSi2qsNMNiOFQlKeTZZkIFyANku3CG7lwEjg',1,'Модуль TWITTER - CONSUMER_SECRET','twitterconsumersecret',NULL,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (41,'314150987-pkFTYydIffE9ITKHNz3NOluh2GtxmUsIrof5lyXu',1,'Модуль TWITTER - OAUTH_TOKEN','twitteroauthtoken',NULL,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (42,'425QNLhdY2DeseBs8cwItemtiYxd9AiGNmOuDVmn0A',1,'Модуль TWITTER - OAUTH_SECRET','twitteroauthsecret',NULL,NULL,1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (43,'20',1,'Время обновления листа сообщений в гостевой книге (ajax-чат) в секундах','guestbooktimeout',10,NULL,1,NULL,'design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (44,'adminka',1,'Доменное имя второго уровня для АдминПанели','adminsubdomainname',40,NULL,2,'admin','adminpanel',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (45,'101',1,'Длина поля на странице АдминПанели HACTPOuKu (в символах)','formsize_standart',4,NULL,2,'140','adminpanel',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (46,'#FFFFFF',4,'Цвет фона страниц АдминПанели','adminpanelbckclr',NULL,NULL,1,'#FFFFFF','adminpanel',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (47,'#545557',4,'Цвет шапки в АдминПанели','adminheadcolor',NULL,NULL,1,'#333333','adminpanel',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (48,'#545557',4,'Цвет фона первого экрана в АдминПанели','ap_fp_bckclr',NULL,NULL,1,'#333333','adminpanel',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (49,'/adminpanel/pics/Male256.png',1,'Логотип в АдминПанели','adminlogofile',NULL,NULL,1,'/files/logo.png','adminpanel',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (50,'2012 SWP by PWS',1,'Текст в нижней части АдминПанели','ap_bottomtext',NULL,NULL,1,'2012 SWP by PWS','adminpanel',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (51,'NO',1,'Проверять при входе в АдминПанель попадает ли IP пользователя в range разрешенных адресов','adminpanelcorrectipaddress',100,NULL,2,'Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (52,'Локальный файл /js/lib/jquery/jquery.min.js',2,'Способ вставки библиотеки JQuery','takejquery',NULL,'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальный файл /js/lib/jquery/jquery.min.js;;Не вставлять',1,NULL,'system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (53,'Не вставлять',2,'Способ вставки библиотеки JQuery-UI','takejqueryui',NULL,'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-ui/;;Не вставлять',1,NULL,'system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (54,'Не вставлять',2,'Способ вставки библиотеки JQueryMobile','takejquerymob',NULL,'Ссылка на сервер Google;;Ссылка на портал JQuery;;Локальные файлы в /js/lib/jquery-mob/;;Не вставлять',1,NULL,'system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (55,'Сделать',2,'Сделать все текстовые ссылки кликабельными?','showtexturlclickable',NULL,'Сделать;;Не делать',2,NULL,'design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (56,'Присоединить',2,'Присоединить стиль для красивых CSS-кнопок','appendbuttonsstyle',NULL,'Присоединить;;Не присоединять',2,NULL,'design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (57,'Разрешать горизонтальную прокрутку',2,'Разрешить горизонтальную прокрутку страницы','hidehorizontalscroll',NULL,'Не разрешать горизонтальную прокрутку;;Разрешать горизонтальную прокрутку',1,NULL,'design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (58,'Подчеркнуть',2,'По-умолчанию ссылки подчекнуты?','linkdecoration',NULL,'Подчеркнуть;;Не подчеркивать',2,NULL,'system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (59,'1',1,'Переменная, указывающая скриптам, что запуск сайта произведен корректно','nitka',NULL,NULL,2,'1','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (60,'Предлагать другие браузеры',1,'Разрешать вход на сайт с помощью IE6?','showsiteforie6',NULL,'Разрешать;;Предлагать другие браузеры',2,NULL,'design',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (61,'Включено',2,'Автоматическое подключение классов из папки functions','autoincludeclasses',NULL,'Включено;;Не включено',2,NULL,'system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (62,'OFF',2,'Уровень логирования портала','loglevel',NULL,'INFO;;WARN;;DEBUG;;ERROR;;FATAL;;OFF',1,'INFO','secure',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (63,'DEBUG',2,'Уровень логирования Админ-панели портала','ap_loglevel',NULL,'DEBUG;;INFO;;WARN;;ERROR;;FATAL;;OFF',1,'INFO','secure',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (64,'Собственный лог',2,'Файлы логирования','writelogto',NULL,'Собственный лог;;SYSLOG;;Собственный и SYSLOG;;Не логировать',1,'SYSLOG','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (65,'5',1,'Таймаут PHP-сессии в минутах','sessionlifetime',4,NULL,1,NULL,'system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (66,'u@d.c',1,'Технический Емейл пользователя, если при регистрации не требуется Email','defaultusrcontmail',NULL,NULL,1,'user@domain.com','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (67,'debug1',1,'Параметр, определяющий переход в Debug mode','debugmoderequestparam',NULL,NULL,1,'Если параметр указать debugm, то перевод в debug mode - &mode=debugm','system',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (68,'xyй|аxуе|бля|блят|доебал|долбое|дохуя|ебал|ебан|ебат|ебет|ебешь|ебё|ебл|ебнет|ебут|ебуч|ёбан|заеб|муда|мудил|наебать|нахуй|нахуя|невъебен|отъебал|отъебис|охуе|охуи|пизд|пиздец|попизд|поху|распиздя|срамк|сука|суки|сцук|сучар|сучка|уебан|херасе|херн|херов|хуев|хует|хули|хуя',1,'Список нецензурных и матерных слов, которые будут заменены спецсимволами','badwordslist',NULL,NULL,1,'х/п/б','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (69,'arial',1,'Семейство шрифтов на сайте','fontfamily',NULL,NULL,2,'sans-serif ,Geneva, Helvetica, Arial','system',2,NULL);
INSERT INTO `wifi-siteconfig` VALUES (70,'10',1,'Количество новостей, выдаваемых в RSS-ленту','rssnewsquantity',NULL,NULL,1,'10','system',1,2);
INSERT INTO `wifi-siteconfig` VALUES (71,'/modules/rss/rss.png',1,'Пиктограмма RSS','rss_picture',NULL,NULL,1,'10','system',1,2);
INSERT INTO `wifi-siteconfig` VALUES (72,'Доменное имя, на которое пришел запрос',2,'Откуда брать доменное имя в ленте RSS','rss_choosedomain',NULL,'Доменное имя по-умолчанию sitedomainname;;Доменное имя, на которое пришел запрос',1,NULL,'design',1,2);
INSERT INTO `wifi-siteconfig` VALUES (73,'200',1,'Минимальное количество символов в полном описании новости, выводимого в RSS','rss_text_min',NULL,NULL,1,'200','design',1,2);
INSERT INTO `wifi-siteconfig` VALUES (74,'Из файла /project/projectname/modules_data/counter-googleanalytics.counter.php',2,'Включить google counter?','enablegooglecount',NULL,'Из базы данных;;Из файла /project/projectname/modules_data/counter-googleanalytics.counter.php;;Не включать',1,NULL,'system',2,3);
INSERT INTO `wifi-siteconfig` VALUES (75,'<!-- Вставить код счетчика-->',1,'Код счетчика Google Analytics','countergooglecode',200,NULL,1,'','system',1,3);
INSERT INTO `wifi-siteconfig` VALUES (76,'Не включать',2,'Включить Yandex counter?','enableyandexcount',NULL,'Из базы данных;;Из файла /project/projectname/modules_data/counter-yandex.counter.php;;Не включать',1,NULL,'system',2,5);
INSERT INTO `wifi-siteconfig` VALUES (106,'Allot',2,'WiFi.Вендор BRAS','wifi_access_vendor',NULL,'Allot;;Huawei;;Cisco;;HP;;Juniper',1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (77,'<!-- Вставить код счетчика-->',1,'Код счетчика Yandex','counteryandexcode',200,NULL,1,'','system',1,5);
INSERT INTO `wifi-siteconfig` VALUES (78,'Не включать',2,'Включить google counter tag manager?','enablegatagcount',NULL,'Из базы данных;;Из файла /modules/counter-ga_tagmanager/counter-ga_tagmanager.php;;Не включать',1,NULL,'system',2,8);
INSERT INTO `wifi-siteconfig` VALUES (79,'<!-- Вставить код счетчика ga tag manager-->',1,'Код счетчика Google Analytics Tag Manager','countergatagcode',200,NULL,1,'','system',1,8);
INSERT INTO `wifi-siteconfig` VALUES (80,'ucn-poc/is9dkan5',1,'Логин и пароль аккаунта на SMSC.RU (через /)','smscru_ad',NULL,NULL,1,'smscru_login/smscru_password','user',1,10);
INSERT INTO `wifi-siteconfig` VALUES (81,'Не включать',2,'Javascript-ускорение при нажатии на кнопки/ссылки ','click_eq_msdown',NULL,'Включить;;Не включать',1,NULL,'design',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (82,'192.168.5.200/freerad/123/radius',1,'Параметры подключения к БД Radius','rad_db_ad',NULL,NULL,1,'ip(or localhost)/db_user/db_pass/database','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (83,'Только цифры',2,'Состав пароля для пользователя FreeRadius','rad_pass_mode',NULL,'Только цифры;;Только буквы;;Смесь букв и цифр',1,NULL,'security',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (84,'8',1,'Длина пароля пользователя FreeRadius','rad_pass_len',NULL,NULL,1,NULL,'security',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (85,'SP-LIMITED',1,'WiFi.ALLOT_SMP.Код дефолтного тарифного плана при регистрации','rad_def_sp',NULL,NULL,1,'SP_LIM','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (86,'Allot_soap_api',2,'WiFi.Способ открытия сессии','wifi_access_mode',NULL,'radius_CoA;;radius_Acct;;Allot_soap_api',1,NULL,'user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (87,'http://192.168.5.152/services/SMFAdmin?wsdl',1,'WiFi.ALLOT_SMP. Путь до wsdl-файла','allot_wsdl_path',NULL,NULL,1,'http://192.168.5.152/services/SMFAdmin?wsdl','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (88,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,12);
INSERT INTO `wifi-siteconfig` VALUES (89,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,12);
INSERT INTO `wifi-siteconfig` VALUES (90,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,12);
INSERT INTO `wifi-siteconfig` VALUES (91,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,13);
INSERT INTO `wifi-siteconfig` VALUES (92,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,13);
INSERT INTO `wifi-siteconfig` VALUES (93,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,13);
INSERT INTO `wifi-siteconfig` VALUES (94,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,14);
INSERT INTO `wifi-siteconfig` VALUES (95,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,14);
INSERT INTO `wifi-siteconfig` VALUES (96,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,14);
INSERT INTO `wifi-siteconfig` VALUES (97,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,15);
INSERT INTO `wifi-siteconfig` VALUES (98,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,15);
INSERT INTO `wifi-siteconfig` VALUES (99,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,15);
INSERT INTO `wifi-siteconfig` VALUES (100,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,16);
INSERT INTO `wifi-siteconfig` VALUES (101,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,16);
INSERT INTO `wifi-siteconfig` VALUES (102,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,16);
INSERT INTO `wifi-siteconfig` VALUES (103,'Показывать',2,'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)','usrcntctafteractiv',NULL,'Показывать;;Не показывать',1,NULL,'design',1,17);
INSERT INTO `wifi-siteconfig` VALUES (104,'Не оповещать',1,'Оповещать ли о регистрации нового пользователя','new_cust_notify',NULL,'Оповещать;;Не оповещать',1,'Оповещать','system',1,17);
INSERT INTO `wifi-siteconfig` VALUES (105,'Подтверждения емейла пользователем',2,'Доступ к порталу предоставляется после','adminallowaccess',NULL,'Подтверждения админом;;Подтверждения емейла пользователем',1,'Подтверждения емейла пользователем','system',1,17);
INSERT INTO `wifi-siteconfig` VALUES (107,'192.168.5.152/1813/allot',1,'Параметры подключения к BRAS по Radius','rad_bras_ad',NULL,NULL,1,'bras_ip/bras_port/bras_secret_word','user',1,NULL);
INSERT INTO `wifi-siteconfig` VALUES (108,'Не предпринимать действий',2,'Действие при обнаружении атаки на систему','injection_act',NULL,'Не отображать страницу;;Отправить письмо администратору;;Не предпринимать действий',1,NULL,'secure',1,NULL);
/*!40000 ALTER TABLE `wifi-siteconfig` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-start-site-subscribers`
--

DROP TABLE IF EXISTS `wifi-start-site-subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-start-site-subscribers` (
  `subscriber_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID подписчика',
  `email` text NOT NULL COMMENT 'Email для оповещения',
  `subscription_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время подписки на запуск портала',
  `domain` text COMMENT 'Доменное имя портала',
  PRIMARY KEY (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица подписчиков для оповещения о запуске портала в работ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-start-site-subscribers`
--

LOCK TABLES `wifi-start-site-subscribers` WRITE;
/*!40000 ALTER TABLE `wifi-start-site-subscribers` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `wifi-start-site-subscribers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-templates_manager`
--

DROP TABLE IF EXISTS `wifi-templates_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-templates_manager` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `template` text NOT NULL,
  `domain` text,
  `url` text,
  `mainpage` varchar(20) DEFAULT NULL COMMENT 'Главная страница темплейта',
  `company_id` int(11) DEFAULT NULL,
  `onoff` enum('on','off') NOT NULL DEFAULT 'on' COMMENT 'Включение работы правила',
  `comment` text,
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Менеджер шаблонов сайта';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-templates_manager`
--

LOCK TABLES `wifi-templates_manager` WRITE;
/*!40000 ALTER TABLE `wifi-templates_manager` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-templates_manager` VALUES (1,'rtkwifi','wifi.romanyuk.me',NULL,'rtk_main',NULL,'on','WiFi каптив портал Ростелеком');
INSERT INTO `wifi-templates_manager` VALUES (2,'rtkwifi','cp1.lan',NULL,'wifi_reg',NULL,'on','WiFi каптив портал Ростелеком.Портал регистрации');
INSERT INTO `wifi-templates_manager` VALUES (3,'rtkwifi','cp2.lan',NULL,'rtk_wifi_cp',NULL,'on','WiFi каптив портал Ростелеком.Портал самообслуживания клиента');
INSERT INTO `wifi-templates_manager` VALUES (4,'rtkwifi','ucn.lan',NULL,'rtk_wifi_free',NULL,'on','WiFi каптив портал Ростелеком. Портал-заглушка со списком бесплатных ресурсов');
INSERT INTO `wifi-templates_manager` VALUES (5,'mvideo','cpb.lan',NULL,'wifi_mvideo',1,'on','М.Видео WiFi');
INSERT INTO `wifi-templates_manager` VALUES (6,'rtkwifi','cp1.lan:8070',NULL,'wifi_reg',NULL,'on','WiFi каптив портал Ростелеком.Портал регистрации');
INSERT INTO `wifi-templates_manager` VALUES (7,'rtkwifi','cp2.lan:8070',NULL,'rtk_wifi_sc',NULL,'on','WiFi каптив портал Ростелеком.Портал самообслуживания клиента');
INSERT INTO `wifi-templates_manager` VALUES (8,'rtkwifi','ucn.lan:8070',NULL,'rtk_wifi_free',NULL,'on','WiFi каптив портал Ростелеком. Портал-заглушка со списком бесплатных ресурсов');
INSERT INTO `wifi-templates_manager` VALUES (9,'mvideo','cpb.lan:8070',NULL,'wifi_mvideo',NULL,'on','М.Видео WiFi');
/*!40000 ALTER TABLE `wifi-templates_manager` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-users`
--

DROP TABLE IF EXISTS `wifi-users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-users`
--

LOCK TABLES `wifi-users` WRITE;
/*!40000 ALTER TABLE `wifi-users` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `wifi-users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-users-admin`
--

DROP TABLE IF EXISTS `wifi-users-admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-users-admin`
--

LOCK TABLES `wifi-users-admin` WRITE;
/*!40000 ALTER TABLE `wifi-users-admin` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-users-admin` VALUES (1,'admin','a906449d5769fa7361d7ecc6aa3f6d28','root','Администратор','Администратор','admin@example.ru','active','2016-01-19 07:05:40',NULL,NULL,NULL,1,'21232f297a57a5a743894a0e4a801fc3;','2016-01-19');
/*!40000 ALTER TABLE `wifi-users-admin` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-users-groupmembers`
--

DROP TABLE IF EXISTS `wifi-users-groupmembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-users-groupmembers` (
  `gm_id` int(7) NOT NULL COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `userid` int(5) NOT NULL COMMENT 'ID пользователя'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-users-groupmembers`
--

LOCK TABLES `wifi-users-groupmembers` WRITE;
/*!40000 ALTER TABLE `wifi-users-groupmembers` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-users-groupmembers` VALUES (0,1,1);
/*!40000 ALTER TABLE `wifi-users-groupmembers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-users-grouprights`
--

DROP TABLE IF EXISTS `wifi-users-grouprights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-users-grouprights` (
  `gright_id` int(11) NOT NULL COMMENT 'ID строки',
  `group_id` int(5) NOT NULL COMMENT 'ID группы',
  `oid` int(10) NOT NULL COMMENT 'ObjectID (0-all objects)',
  `table` varchar(40) NOT NULL COMMENT 'В какой табличке OID',
  `grant` int(1) NOT NULL DEFAULT '1' COMMENT '1-access_granted,2-access_deny'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-users-grouprights`
--

LOCK TABLES `wifi-users-grouprights` WRITE;
/*!40000 ALTER TABLE `wifi-users-grouprights` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-users-grouprights` VALUES (0,1,0,'wifi-siteconfig',1);
/*!40000 ALTER TABLE `wifi-users-grouprights` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-users-groups`
--

DROP TABLE IF EXISTS `wifi-users-groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-users-groups` (
  `group_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Номер группы',
  `groupname` varchar(100) NOT NULL COMMENT 'ID пользователя',
  `onoff` enum('on','off','','') NOT NULL DEFAULT 'on' COMMENT 'on/off',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-users-groups`
--

LOCK TABLES `wifi-users-groups` WRITE;
/*!40000 ALTER TABLE `wifi-users-groups` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-users-groups` VALUES (1,'root','on');
INSERT INTO `wifi-users-groups` VALUES (2,'public','on');
/*!40000 ALTER TABLE `wifi-users-groups` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-wifi-tariffs`
--

DROP TABLE IF EXISTS `wifi-wifi-tariffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-wifi-tariffs` (
  `tariff_id` int(11) NOT NULL AUTO_INCREMENT,
  `tariff_name` text CHARACTER SET utf8,
  `tariff_code` text,
  PRIMARY KEY (`tariff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-wifi-tariffs`
--

LOCK TABLES `wifi-wifi-tariffs` WRITE;
/*!40000 ALTER TABLE `wifi-wifi-tariffs` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-wifi-tariffs` VALUES (1,'SP-LIMITED','SP-LIMITED');
INSERT INTO `wifi-wifi-tariffs` VALUES (2,'SP-LIMITED-WSP','SP-LIMITED-WSP');
INSERT INTO `wifi-wifi-tariffs` VALUES (3,'SP-2M-BLOCK-PART','SP-2M-BLOCK-PART');
INSERT INTO `wifi-wifi-tariffs` VALUES (4,'SP-INET-200K','SP-INET-200K');
INSERT INTO `wifi-wifi-tariffs` VALUES (5,'SP-INET-2M','SP-INET-2M');
INSERT INTO `wifi-wifi-tariffs` VALUES (6,'SP-QUOTA-100M','SP-QUOTA-100M');
INSERT INTO `wifi-wifi-tariffs` VALUES (7,'SP-2M_P2P_LOW_PRI','SP-2M_P2P_LOW_PRI');
/*!40000 ALTER TABLE `wifi-wifi-tariffs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `wifi-wifi-user_tariff`
--

DROP TABLE IF EXISTS `wifi-wifi-user_tariff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi-wifi-user_tariff` (
  `raw_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` bigint(15) NOT NULL,
  `tariff_code` text NOT NULL,
  PRIMARY KEY (`raw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi-wifi-user_tariff`
--

LOCK TABLES `wifi-wifi-user_tariff` WRITE;
/*!40000 ALTER TABLE `wifi-wifi-user_tariff` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `wifi-wifi-user_tariff` VALUES (29,79036766552,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (30,79164898685,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (31,79152442621,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (32,9154144565,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (33,89031075636,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (34,79852339455,'SP-INET-2M');
INSERT INTO `wifi-wifi-user_tariff` VALUES (35,79175176983,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (36,79169639930,'SP-INET-2M');
INSERT INTO `wifi-wifi-user_tariff` VALUES (37,79266257403,'SP-INET-2M');
INSERT INTO `wifi-wifi-user_tariff` VALUES (38,79154863615,'SP-LIMITED');
INSERT INTO `wifi-wifi-user_tariff` VALUES (39,79164375328,'SP-INET-2M');
INSERT INTO `wifi-wifi-user_tariff` VALUES (40,79031075636,'SP-INET-2M');
INSERT INTO `wifi-wifi-user_tariff` VALUES (41,79036766552,'SP-LIMITED');
/*!40000 ALTER TABLE `wifi-wifi-user_tariff` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Tue, 02 Feb 2016 17:20:40 +0000
