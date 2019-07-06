<?php
 /*******************************************************************************
  * Snippet Name : swpshop									 				*
  * Part		 : Crontab script												*
  * Scripted By  : RomanyukAlex		           					 				*
  * Website      : http://popwebstudio.ru	   					 				*
  * Email        : admin@popwebstudio.ru     					 				*
  * License      : GPL (General Public License)					 				*
  * Purpose 	 : some crontab functions						 				*
  * Access		 : insert /core/swp_cron_tasks.php into crontab					*
  * * * * * * php /var/www/html/vobla1/core/swp_cron_tasks.php project			*
  ******************************************************************************/

$log->LogInfo('Start of script -------------------');

#
#Обработаем платежи
#
$payments_q=mysql_query("SELECT * FROM `$tableprefix-payments` WHERE `pm_status`='new';");

if($payments_q and mysql_num_rows($payments_q)>0){ #Есть новые платежи

	while($payments=mysql_fetch_assoc($payments_q)){
		$new_orders[$payments['order_id']]=$payments['summ']; //Создали массив order_id=>summ
		$new_orders_q.=" or `order_group`='".$payments['order_id']."'";
	}
	$orders_info_q=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE ".mb_substr($new_orders_q,4)." order by `order_group`;");
	$log->LogInfo("SELECT * FROM `$tableprefix-orders` WHERE ".mb_substr($new_orders_q,3)." order by `order_group`;");
	while($orders_info=mysql_fetch_assoc($orders_info_q)){

		#Считаем сумму в заказе, чтобы сверить ее с платежом
		$order_summ[$orders_info['order_group']]=$order_summ[$orders_info['order_group']]+$orders_info['price'];
		
	}
	foreach($new_orders as $order_id=>$order_summ_paid){
		if($order_summ[$order_id]==$order_summ_paid){#Сумма в заказе верна
			$log->LogInfo("Summ in order ".$order_id." is equal paid summ");

			#Статус заказа - оплачен
			mysql_query("UPDATE `$tableprefix-orders` SET `status`='inprogress' WHERE `order_group`='".$order_id."';");

			#Статус платежа - обработан
			mysql_query("UPDATE `$tableprefix-payments` SET `pm_status`='processed' WHERE `order_id`='".$order_id."';");
			
			#Отправляем письмо админу о проведенном платеже
			insert_function("sendletter");
			sendletter_to_admin("Новый заказ на портале","Новый заказ");
			
			#Обработка заказа по бизнес-процессу проекта
			if(is_readable($_SERVER['DOCUMENT_ROOT']."/project/".$projectname."/modules_data/swpshop.action.order_paid.php")){
				include($_SERVER['DOCUMENT_ROOT']."/project/".$projectname."/modules_data/swpshop.action.order_paid.php");
			}
			
		} else {#Сумма в заказе не верна, выставляем статус платежа error
			$log->LogInfo("Summ in order ".$order_id." is NOT equal paid summ");
			mysql_query("UPDATE `$tableprefix-payments` SET `pm_status`='error' WHERE `order_id`='".$order_id."';");
		}
	}
}
#
#Сотрем все некупленные orders из прошлых суток
#
if($now_min=="23" and $now_hour=="00"){
	mysql_query("DELETE FROM `$tableprefix-orders` WHERE `creations_ts` < (NOW() - INTERVAL 1 DAY) and `last_status_change_ts`< (NOW() - INTERVAL 1 DAY) and `status`='opened'");
}
$log->LogInfo('End of script -------------------');
		
 ?>