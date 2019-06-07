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
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES
	(NULL, 'NO', 1, 'Проверять при входе на сайт попадает ли IP пользователя в range разрешенных адресов', 'sitecorrectipaddress', NULL, NULL, 2, 'Указывать либо NO, либо IP-адрес, с которого разрешен доступ к админке, либо range адресов, с которых разрешен доступ к админке', 'system', 2)";
	
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