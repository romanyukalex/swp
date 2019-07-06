<?
/*****************************************************************************************************************************
  * Snippet Name : messages           																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создаёт массив сообщений портала, выгружая данные из БД													 *
  * Using		 : echo sitemessage("$module_name","$message_code");															 *
  ***************************************************************************************************************************/
$log->LogDebug('Got this file');
function sitemessage($modulename,$message_code){
	global $userMessage;
	
	if(!$userMessage[$modulename][$message_code]) { #Получаем текст сообщения
		global $site_company_id,$tableprefix;
		
		if($site_company_id) $messagedata_q=mysql_query('SELECT `message_'.$_SESSION['language']."` FROM `$tableprefix-messages` WHERE `company_id`='$site_company_id' and `module_name`='".$modulename."' AND `message_code`='".$message_code."';");
		else $messagedata_q=mysql_query('SELECT `module_name`,`message_code`,`message_'.$_SESSION['language']."` FROM `$tableprefix-messages` WHERE  `company_id` IS NULL and `module_name`='".$modulename."' AND `message_code`='".$message_code."';");
		
		if(mysql_num_rows($messagedata_q)==1){//Получили сообщение
			$messagedata=mysql_fetch_assoc($messagedata_q);
			$userMessage[$modulename][$message_code]=$messagedata['message_'.$_SESSION[language]];
		}// else echo "Не получили данные";
		//echo "Получали из БД<br>";
	} //else echo "Уже была<br>";
	return $userMessage[$modulename][$message_code]; //Отправляем текст в ответ
}
?>