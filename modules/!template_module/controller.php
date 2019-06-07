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
  * if its needed to return some data just add $return_data		*
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact==''){# Страничка с продуктом
	
		$show_view='vendor';
		$return_data= "OK";
		$return_data=json_encode(array('status' => $order_status, 'message' => $order_message, 'getfunction'=>$order_function));
		
	}
}
?>