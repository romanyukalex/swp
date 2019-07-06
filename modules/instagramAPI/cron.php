<?php
 /*******************************************************************************
  * Snippet Name : modulename									 				*
  * Part		 : Crontab script												*
  * Scripted By  : RomanyukAlex		           					 				*
  * Website      : http://popwebstudio.ru	   					 				*
  * Email        : admin@popwebstudio.ru     					 				*
  * License      : GPL (General Public License)					 				*
  * Purpose 	 : поддержка логина на их сервере				 				*
  * Access		 : insert /core/swp_cron_tasks.php into crontab					*
  * * * * * * php /var/www/html/vobla1/core/swp_cron_tasks.php project			*
  ******************************************************************************/

$log->LogInfo('Start of script -------------------');
require($this_path.'/config.php');//Конфиг модуля

$log->LogInfo('End of script -------------------');
		
 ?>