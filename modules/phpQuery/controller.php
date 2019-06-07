<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  \*************************************************************/
$log->LogInfo('Got this file');
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact=='connect_lib'){# Страничка с продуктом
	  
    require('phpquery-master/phpQuery/phpQuery.php');
		$show_view='vendor';
		
	}
}
?>