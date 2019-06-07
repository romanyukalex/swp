<?
/*****************************************************************************************************************************
  * Snippet Name : bots_systemparam_updater	        																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Апдейтит файл конфига для роботов																			 *
  * Using		 : For robots																								 *
  ***************************************************************************************************************************/
$sitemapflag=1;
 
if($nitka=='1' and $now_hour=="02" and $now_min=="15"){
	
	foreach($projectexist as $projectname=>$value){
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
		include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
	
		#Сбросить конфиг сайта в файл для дальнейшего считывания при обработке траффика от ботов (сокращает нагрузку на БД)
		$systemparam_TXT="<?";
		$paramdatas=mysql_query('SELECT `value`,`systemparamname` FROM `'.$tableprefix.'-siteconfig` WHERE 1;');

		while($paramdata=mysql_fetch_array($paramdatas)){
			$systemparam_TXT.='$'.$paramdata['systemparamname']." = '".$paramdata['value']."';\r\n";
		}
		$systemparam_TXT.="?>";

		file_put_contents ( $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/bots_systemparams.php' , $systemparam_TXT);
		#Удаляем настройки проекта
		
		
		unset($paramdatas,$systemparam_TXT);
		
		mysql_close($dbconnconnect);
	}

}
?>