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
  $cf_message=$cf_autor." (" .$cf_mail.") заполнил форму обратной связи на сайте ".$sitedomainname.":<br>".$_REQUEST['mailtext'];
  sendletter_to_admin("Новое сообщение на портале ".$sitedomainname, $cf_message);
  echo $sitemessage["contact_form"]["message_received"];

} ?>