<?
/*****************************************************************************************************************************
  * Snippet Name : messages           																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создаёт массив сообщений портала, выгружая данные из БД													 *
  * Using		 : echo $sitemessage[$module_name][$message_code];															 *
  ***************************************************************************************************************************/
$log->LogDebug('Got this file');
include_once($_SERVER['DOCUMENT_ROOT'].'/core/db/dbconn.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/langfromget.php');#Определение $language
$messagedatas=mysql_query('SELECT `module_name`,`message_code`,`message_'.$_SESSION['language']."` FROM `$tableprefix-messages` WHERE `company_id`='$site_company_id' or `company_id` IS NULL ORDER BY `company_id` ASC;");
while($messagedata=mysql_fetch_array($messagedatas)){
	if(!$sitemessage[$messagedata['module_name']][$messagedata['message_code']] or
	($messagedata['company_id']!=='NULL' and $messagedata['company_id']!=='')){ // Или такого сообщения еще нет, или есть, но тогда надо перезаписать, ибо в новом есть поле company_id
		$sitemessage[$messagedata['module_name']][$messagedata['message_code']] = $messagedata['message_'.$_SESSION[language]];
	}
}
$log->LogDebug('Got '.count($sitemessage).' messages for this company');
?>