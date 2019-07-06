<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module(modulename)			 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
 if ($nitka=="1"){  
if ($moduleinstalled['$modulename']!=='y'){ #Требуется инсталляция
	
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
	# Ставим метку об инсталляции в реестр модулей
	$modregisterqry=mysql_query("INSERT into `$tableprefix-modulesregister` 
	(`module_id` ,`modulename` ,`module_description` ,`installed` ,`install_ts` ,`enabled` )
VALUES (NULL , '$modulename', '$module_description', 'y', CURRENT_TIMESTAMP , 'enabled');");
	$module_id=mysql_insert_id();
	
	#	Инсталляционные действия
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`( `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		('contact_form', 'message_was_not_sent', 'Сообщение не было отослано из-за проблем с почтовой функцией', 'Сообщение не было отослано', 'The message was not sent'),
		('contact_form', 'message_received', 'Сообщение при принятии сообщения в контакт-форме', 'Ваше сообщение отправлено администрации портала, ждите ответа на указанный E-MAIL', 'Your message was sent to site administrator, please, wait an answer to your email.');");
}
?>
<? } ?>