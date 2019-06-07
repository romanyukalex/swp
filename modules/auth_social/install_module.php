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
	
	# $module_id - id модуля
	
	$structures['users']="ALTER TABLE `freecon-users` ADD `provider` ENUM('no','vk', 'odnoklassniki', 'mailru', 'yandex', 'google', 'facebook') NOT NULL COMMENT 'Авторизован через соцсеть' AFTER `passw_inp_count`, 
	ADD `social_id` VARCHAR(255) NOT NULL COMMENT 'ID в соцсети' AFTER `provider`, 
	ADD `social_page` VARCHAR(255) NOT NULL COMMENT 'Страничка пользователя в соцсети' AFTER `social_id`, 
	ADD `avatar` VARCHAR(255) NULL COMMENT 'Аватар в соцсети' AFTER `social_page`;"
	
	
	$DBdata['Adding module messages']="INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
	(NULL, 'auth_social', 'user_auth_error', 'Ошибка при добавлении аутентифицировании пользователя через соц.сеть ', 'К сожалению, мы не смогли получить Ваши данные из социальной сети', 'Unfortunatelly we can\'t get user data from social network', NULL);";
	/*
	
	Инсталляционные действия
	
	$structures['Some Table']="CREATE TABLE `$moduletableprefix-sometable` (....)";
	
	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, '$modulename', NULL, NULL, '$modulename', NULL, '0', '1');";
	
	
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
		(NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');";

	*/
	
}
?>