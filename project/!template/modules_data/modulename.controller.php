<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller (project specific addition)		*
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
		
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact==''){
	
		$show_view='vendor';
		
	}
}
?>