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
$log->LogDebug('Got this file');
if ($moduleinstalled["$modulename"]!=='y' and $nitka=='1'){ #Требуется инсталляция
	
	
	
$structures['Config table']="CREATE TABLE `$moduletableprefix-$modulename-conf` (
  `feed_id` int(11) NOT NULL,
  `feed_name` text COMMENT 'Some name for feed',
  `feed_url` text NOT NULL,
  `script` text COMMENT 'Script for processing the results (folder /project/projectname/scripts/)',
  `udate_freq` int(11) NOT NULL COMMENT 'in minutes',
  `last_update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, '1', '1', 'Сколько лент RSS обрабатывать за 1 проход cron', 'feed_num_once_cron', '20', NULL, '1', '2', 'system', '2','$moduleid');";
	
	# $module_id - id модуля
	
	/*
	
	Инсталляционные действия
	
	$structures['Some Table']="CREATE TABLE `$moduletableprefix-sometable` (....)";
	
	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, '$modulename', NULL, NULL, '$modulename', NULL, '0', '1');";
	
	
	$DBdata['Adding module messages']="INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
		(NULL, '$modulename', 'fill_all_required', 'Не заполнены все поля при смене пароля', 'Пожалуйста, заполните все обязательные поля', 'Please, fill all required fields',NULL),
		(NULL, '$modulename', 'new_passes_not_equal', 'Присланные пароли не совпадают', 'Присланные пароли не совпадают', 'The new passwords are not equal', NULL)
		;";
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
		(NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');";

	*/
	
}
?>