<?php
 /****************************************************************
  * Snippet Name : contact_form (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : save form data								 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo('Got '.(__FILE__));
if ($nitka=="1"){
  insert_function("send_letter");

  $cf_autor=process_data($_REQUEST['author'],100);
  $cf_mail=process_data($_REQUEST['email'],100);
  
  
  #Текст письма админу
  $cf_message=$cf_autor." (" .$cf_mail.") заполнил форму обратной связи на сайте ".$sitedomainname.":<br>".$_REQUEST['mailtext'];
  sendletter_to_admin("Новое сообщение на портале ".$sitedomainname.":".substr($_REQUEST['mailtext'],0,40), $cf_message);
  
  $cf_message_toAdmin=$cf_autor." (" .$cf_mail.") прислал сообщение: ".$_REQUEST['mailtext'];
  #Пишем сообщение в табличку events
  mysql_query("INSERT INTO `$tableprefix-portal-events` 
  (`event_id`, `text`, `status`, `type`, `link`) VALUES 
  (NULL, '$cf_message_toAdmin', 'new', 'message_to_admin', NULL);");
  
  echo sitemessage("contact_form","message_received");
	
} ?>