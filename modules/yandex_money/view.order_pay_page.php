<?php
 /**************************************************************************\
  * Snippet Name : robokassa		           					 			*
  * Part		 : button (view)											*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : pay something								 			*
  * Access		 : 
  *																			*
  * insert_module('robokassa','get_pay_button',$pay_detail_arr)				*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){
#Табличка с подробностями платежа
	?><table>
		<tr><td>Описание платежа</td><td> : </td><td><?=$order_desc?></td>
		<tr><td>Номер заказа</td><td> : </td><td><?=$order_id?></td>
		<? if($isTest==1){?><tr><td> Тестовый платёж<td></td><td>:</td><td>ДА</td><?}?>
		<tr><td>Сумма платежа</td><td> : </td><td><?=$summ?> руб.</td>
	</table><?
	
	$pay_detail_arr=array(
	'button_type'=>'with_label',
	'order_id'=>$order_id,
	'order_desc'=>$order_desc,
	'summ'=>$summ,
	'button_form'=>'SS', //S;M;SS;MS;L;V
	'IsTest'=>$isTest //0;1
	);
	insert_module('robokassa','get_pay_button',$pay_detail_arr);
}?>