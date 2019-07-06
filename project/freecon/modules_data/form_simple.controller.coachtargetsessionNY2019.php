<?php
 /**************************************************************************\
  * Snippet Name : 		           					 			*
  * Part		 : Form Processing											*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : pay something								 			*
  * Access		 : 															*
  * 																		*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){
	insert_function("send_letter");
	#Текст письма админу
	$cf_message=$_REQUEST['5']." (" .$_REQUEST['6'].") заполнил форму обратной связи на посещение коучинговой сессии ".$sitedomainname.":<br>";
	sendletter_to_admin("Новый участник коучинга ", $cf_message);

	$cf_message_toAdmin=$_REQUEST['1'].' '.$_REQUEST['3']." (" .$_REQUEST['2'].' '.$_REQUEST['4'].") заполнил форму обратной связи на сайте";
	#Пишем сообщение в табличку events
	mysql_query("INSERT INTO `$tableprefix-portal-events` 
	(`event_id`, `text`, `status`, `type`, `link`) VALUES 
	(NULL, '$cf_message_toAdmin', 'new', 'message_to_admin', NULL);");

	$message_text="Вы успешно внесены в список участников";
}?>