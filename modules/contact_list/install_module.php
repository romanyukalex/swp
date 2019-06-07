<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module("modulename")			 	 *
  ***************************************************************/
    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	# $module_id - id модуля
	
	$insert_table=mysql_query("CREATE TABLE IF NOT EXISTS `$moduletableprefix-contactlist` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Если контакт-лист пользователя',
  `company_id` int(11) DEFAULT NULL COMMENT 'Если контакт-лист компании',
  `user_data` int(5) DEFAULT NULL COMMENT 'Если контакт расширяет данные пользователя из users',
  `second_name` text COMMENT 'Фамилия',
  `first_name` text COMMENT 'Имя',
  `patronymic_name` text COMMENT 'Отчество',
  `gender` enum('-','male','female') NOT NULL DEFAULT '-',
  `position` text COMMENT 'Должность в компании',
  `mobile` int(11) DEFAULT NULL COMMENT 'Мобильный',
  `desk_phone` int(11) DEFAULT NULL COMMENT 'Городской',
  `home_phone` int(11) DEFAULT NULL COMMENT 'Домашний',
  `basic_phone` int(11) DEFAULT NULL,
  `work_fax` int(11) DEFAULT NULL,
  `home_fax` int(11) DEFAULT NULL,
  `email_personal_1` text,
  `email_personal_2` text,
  `email_work` text,
  `AIM` text,
  `windows_live` text,
  `yahoo` text,
  `skype` text,
  `QQ` text,
  `hangouts` text,
  `icq` text,
  `jabber` text,
  `birthdate` date DEFAULT NULL,
  `nickname` text,
  `comment` text,
  `website` text,
  `city` TEXT NULL DEFAULT NULL COMMENT 'Text or city_id (preferable)',
  `address_home` TEXT NULL DEFAULT NULL COMMENT 'Home address',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Контакт лист' AUTO_INCREMENT=1 ;
");
	
	
	/*
	
	Инсталляционные действия
	
	
	$put_pages=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, '$modulename', NULL, 0, 1)");
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'code1', 'Смысл сообщения 1', 'Сообщение на русском 1', 'Message text 1'),
		(NULL, '$modulename', 'code2', 'Смысл сообщения 2', 'Сообщение на русском 2', 'Message text 2'),
		(NULL, '$modulename', 'code3', 'Смысл сообщения 3', 'Сообщение на русском 3', 'Message text 3')		
		;");
		
	$put_settings=mysql_query("INSERT INTO `$tableprefix-siteconfig` 
	(`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
	(NULL, 'Показывать', '2', 'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)', 'usrcntctafteractiv', NULL, 'Показывать;;Не показывать', '1', NULL, 'design', '1', '$module_id');");
	
	*/
	
}
?>