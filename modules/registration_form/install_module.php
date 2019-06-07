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
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'wrong_activation_qry', 'Неправильная строка активации или пользователь уже был активирован ранее', 'Неправильная строка активации или пользователь уже был активирован ранее.', 'Wrong get string or user was activated earlier'),
		(NULL, '$modulename', 'activation_complete', 'Сообщение об удачной активации нового пользователя', 'C Вами свяжется менеджер SaaS по указанному номеру телефона:', 'Our manager will communicate with you by the phone:'),
		(NULL, '$modulename', 'user_cant_be_added', 'Неудачная попытка добавить нового пользователя', 'Не удалось добавить пользователя', 'We can''t add that user'),
		(NULL, '$modulename', 'user_already_exists', 'Пользователь с указанным email уже существует', 'Пользователь с указанным email уже существует', 'User with that e-mail address already exists in database'),
		(NULL, '$modulename', 'success_deactivation', 'Сообщение об успешной деактивации нового абонента', '<h1>Пользователь успешно деактивирован</h1><p>Спасибо за сообщение</p>', '<h1>User was successfully deactivated</h1><p>Thanks a lot!</p>'),
		(NULL, '$modulename', 'failed_deactivation', 'Сообщение о неудачной попытке деактивации нового пользователя', '<h1>Пользователь не деактивирован:</h1> <p>Неправильная строка деактивации или пользователь уже был деактивирован ранее.</p>', '<h1>User was not deactivated:</h1> <p>Wrong query or user was already deactivated before.</p>'),
		(NULL, '$modulename', 'mail_was_sent', 'Сообщение об отправке подтверждающего e-mail', 'На указанный e-mail выслано письмо для подтверждения.</p><p>После подтверждения e-mail с Вами свяжется менеджер SaaS по указанному номеру телефона.', 'Activation mail was sent on your e-mail. After activation our manager will communicate with you by the phone.')
		;");
		
	$put_settings=mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
	(NULL, 'Показывать', '2', 'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)', 'usrcntctafteractiv', NULL, 'Показывать;;Не показывать', '1', NULL, 'design', '1', '$module_id'),
	(NULL, 'Не оповещать', '1', 'Оповещать ли о регистрации нового пользователя', 'new_cust_notify', NULL, 'Оповещать;;Не оповещать', '1', 'Оповещать', 'system', '1', '$module_id'),
	(NULL, 'Подтверждения емейла пользователем', '2', 'Доступ к порталу предоставляется после', 'adminallowaccess', NULL, 'Подтверждения админом;;Подтверждения емейла пользователем', '1', 'Подтверждения емейла пользователем', 'system', '1', '$module_id');");
}
?>