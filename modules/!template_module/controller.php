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
	
	if ($contact==''){# Страничка с продуктом
	
		$show_view='vendor';
		$return_data= "OK";
		$return_data=json_encode(array('status' => $order_status, 'message' => $order_message, 'getfunction'=>$order_function));
		
	}
}
?>