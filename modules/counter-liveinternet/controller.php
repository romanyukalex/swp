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

	$log->LogDebug('Action is '.$contact);
	
	if ($contact=='show_counter'){# Страничка с продуктом
	
		$show_view='counter';
		
	}
}
?>