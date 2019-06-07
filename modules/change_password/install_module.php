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
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));

if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	# $module_id - id модуля
	
	/*
	
	Инсталляционные действия
	
	*/
	$put_pages=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, 'change_password', NULL, 0, 1)");
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'fill_all_required', 'Не заполнены все поля при смене пароля', 'Пожалуйста, заполните все обязательные поля', 'Please, fill all required fields'),
		(NULL, '$modulename', 'wrong_cur_pass', 'Неверно введенный текущий пароль', 'Вы указываете неверный текущий пароль', 'You are filled in wrong current password'),
		(NULL, '$modulename', 'pass_changed_succ', 'Пароль изменен успешно', 'Пароль успешно изменен', 'Password changed successfully'),
		(NULL, '$modulename', 'password_wasnt_changed', 'Пароль не был изменен, не прошел запрос в БД', 'Пароль не был изменен', 'Password changed successfully'),			
		(NULL, '$modulename', 'new_passes_not_equal', 'Присланные пароли не совпадают', 'Присланные пароли не совпадают', 'The new passwords are not equal')
		;");
}
?>