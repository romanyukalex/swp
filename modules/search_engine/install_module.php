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
	
	/*
	
	Инсталляционные действия
	
	
	$put_page=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, 'change_password', NULL, 0, 1)");
	
	
	
	CREATE TABLE IF NOT EXISTS `tscloud-$modulename-categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name_ru` text COMMENT 'Название категории на русском',
  `category_name_en` text COMMENT 'Название категории на английском',
  `cat_description` text COMMENT 'Описание категории',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tscloud-$modulename-places` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `table` text NOT NULL,
  `field` text NOT NULL,
  PRIMARY KEY (`place_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Определение мест для поиска' AUTO_INCREMENT=1 ;

	
	*/
	
	mysql_query("INSERT INTO `$moduletableprefix-$modulename-categories` (`cat_id`, `category_name_ru`, `category_name_en`, `cat_description`) VALUES 
	(NULL, 'Страницы портала', 'Pages', 'Поиск по тексту на страницах портала'),
	(NULL, 'Пользователи', 'Users', 'Поиск по таблице пользователей'),
	(NULL, 'Администраторы', 'Administrators', 'Поиск по таблице администраторов');");
	
	mysql_query("INSERT INTO `$moduletableprefix-$modulename-places` (`place_id`, `cat_id`, `table`, `field`) VALUES 
	(NULL, '1', '$tableprefix-pages', 'pagetitle'),
	(NULL, '1', '$tableprefix-pages', 'pagebody'),
	(NULL, '2', '$tableprefix-users', 'login'),
	(NULL, '2', '$tableprefix-users', 'nickname'),
	(NULL, '2', '$tableprefix-users', 'fullname'),
	(NULL, '2', '$tableprefix-users', 'second_name'),
	(NULL, '2', '$tableprefix-users', 'first_name'),
	(NULL, '2', '$tableprefix-users', 'patronymic_name'),
	(NULL, '2', '$tableprefix-users', 'contactmail'),
	(NULL, '2', '$tableprefix-users', 'address'),
	(NULL, '3', '$tableprefix-users-admin', 'login'),
	(NULL, '3', '$tableprefix-users-admin', 'nickname'),
	(NULL, '3', '$tableprefix-users-admin', 'fullname'),
	(NULL, '3', '$tableprefix-users-admin', 'contactmail')	
	;");
	
	mysql_query("INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES 
	(NULL, 'search_engine_page', 'Поиск по порталу', NULL, NULL, NULL, NULL, 'search_engine', NULL, '0', '2');");
}
?>