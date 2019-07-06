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
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'code1', 'Смысл сообщения 1', 'Сообщение на русском 1', 'Message text 1'),
		(NULL, '$modulename', 'code2', 'Смысл сообщения 2', 'Сообщение на русском 2', 'Message text 2'),
		(NULL, '$modulename', 'code3', 'Смысл сообщения 3', 'Сообщение на русском 3', 'Message text 3')		
		;");
		
	
	*/
	$put_settings=mysql_query("INSERT INTO `$tableprefix-siteconfig` 
	(`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
	(NULL, '20', 1, 'Время обновления листа сообщений в гостевой книге (ajax-чат) в секундах', 'guestbooktimeout', 10, NULL, 1, NULL, '', 2,  '$module_id');");
	
	$moduletableqry=mysql_query("CREATE TABLE `$moduletableprefix-guestbook-messages` (
	`id` int(5) NOT NULL auto_increment,
	`name` char(255) character set utf8 NOT NULL,
	`text` text character set utf8,
	PRIMARY KEY  (`id`));");
	
	$put_pages=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('$modulename_page', 'Гостевая книга', NULL, NULL, NULL, NULL, '$modulename', NULL, 0, 1)");
	
}
?>