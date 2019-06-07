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
	#Табличка с подробностями платежа
	?><table>
		<tr><td>Описание платежа</td><td>:</td><td><?=$order_desc?></td>
		<? if($product_id){?>
		<tr><td>Продукт/услуга</td><td>:</td><td><?=$productinfo['product_full_title_'.$language]?></td><?}?>
		<?if($user_id){?><tr><td>Пользователь</td><td>:</td><td><? 
		if($user_detail['fullname']) echo $user_detail['fullname'];
		elseif($user_detail['second_name'] or $user_detail['first_name']) echo $user_detail['second_name'].' '.$user_detail['first_name'].' '.$user_detail['patronymic_name'];
		else echo $user_detail['login'];
		?></td><?}?>
		<tr><td>Номер заказа</td><td>:</td><td><?=$order_id?></td>
		<? if($isTest==1){?><tr><td>Тестовый платёж<td></td><td>:</td><td>ДА</td><?}?>
		<tr><td>Сумма платежа</td><td>:</td><td><?=$summ?> руб.</td>
	</table><?
	if ($nitka=='1'){
	$pay_detail_arr=array(
	'button_type'=>'with_label',
	'order_id'=>$order_id,
	'order_desc'=>$order_desc,
	'summ'=>$summ,
	'button_form'=>'SS', //S;M;SS;MS;L;V
	'IsTest'=>$isTest //0;1
	);
	insert_module('robokassa','get_pay_button',$pay_detail_arr);
	?><br><a href='#' onclick="history.back()">Вернуться</a><?
}?>