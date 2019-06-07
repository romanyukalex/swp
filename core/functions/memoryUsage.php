<?php 
/*****************************************************************************************************************************
  * Snippet Name : autoload_scripts_from_functions.php																 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Функция автоподключения файла с классом при объявлении класса						 					 *
  * Insert		 : include_once('autoload_scripts_from_functions.php');														 *
  ***************************************************************************************************************************/
$log->LogInfo('Got this file');

function memoryUsage($memory_base) {
  return (memory_get_usage()-$memory_base);
}?>