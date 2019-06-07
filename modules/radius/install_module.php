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
	
	$put_table_structure=mysql_query("CREATE TABLE `$moduletableprefix-sometable` (....);
	
	$put_page=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, 'change_password', NULL, 0, 1)");
	
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'fill_all_required', 'Не заполнены все поля при смене пароля', 'Пожалуйста, заполните все обязательные поля', 'Please, fill all required fields'),
		(NULL, '$modulename', 'new_passes_not_equal', 'Присланные пароли не совпадают', 'Присланные пароли не совпадают', 'The new passwords are not equal')
		;");
	
	$put_siteconfig=mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
		(NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');");

	*/
	
}
?>