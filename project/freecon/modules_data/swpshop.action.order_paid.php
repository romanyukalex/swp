<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	
	
	#Отправляем письмо заказчику со ссылкой на инфопродукт
	insert_function("send_letter");
	sendletter($to_email_address,$subject,$message);
	
	#Меняем статус заказа на исполнено
	
	//mysql_query("UPDATE `$tableprefix-orders` SET `status`='resolved' WHERE `order_group`='".$order_id."';");

}//nitka?> 