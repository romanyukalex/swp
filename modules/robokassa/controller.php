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
  
  /* Examples
  
  # Регистрация партнера - https://partner.robokassa.ru
  
# button_type=without_label;with_label
# method=POST;GET - only for button_type=without_label
# button_text and button_class - only for button_type=without_label
# button_form=S;M;SS;MS;L;V;FL;FLS    -  all is only for button_type=with_label. FL;FLS is with flexible price (user choosen) 
# shop_id (unnecess) - if used few domain and few shop id in robokassa

# Type1 просто кнопка
$pay_detail_arr=array(
'button_type'=>'without_label',
'method'=>'POST',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_text'=>'Оплатить',
'button_class'=>'',
'shop_id'=>'',
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

# Type2 с лейблом робокассы, цена фиксируется
$pay_detail_arr=array(
'button_type'=>'with_label',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_form'=>'SS', //S;M;SS;MS;L;V
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

# Type3 с лейблом робокассы, цену выбирает пользователь
$pay_detail_arr=array(
'button_type'=>'with_label',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_form'=>'FL', //FL;FLS 
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

*/

$log->LogInfo('Got this file');
if($nitka=='1'){
	insert_function('process_user_data');

	if(!isset($contact)){$contact='show_result_page';}
	
	if ($contact=='get_pay_button'){# Формируем кнопку на оплату
		global $language,$rk_login,$rk_pass1;		
		if($param[2]['IsTest']=='0'){$out_pass=$rk_pass1;}
		else{global $rk_test_pass1; $out_pass=$rk_test_pass1;}
		// формирование подписи
		if($param[2]['button_type']=='without_label') {
			$crc = md5($rk_login.':'.$param[2]['summ'].':'.$param[2]['order_id'].':'.$out_pass);
			$show_view='freeform_pay_button';
		}
		elseif($param[2]['button_type']=='with_label') {
			//$mrh_login::$inv_id:$mrh_pass1
			if($param[2]['button_form']=='FL' or $param[2]['button_form']=='FLS') $crc = md5($rk_login.':'.':'.$param[2]['order_id'].':'.$out_pass);
			else $crc = md5($rk_login.':'.$param[2]['summ'].':'.$param[2]['order_id'].':'.$out_pass);
			$show_view='robokassa_labeled_pay_button';
		}
		if(!$param[2]['shop_id']){
			$rk_shop_id=$rk_login;
		} else{
			$rk_shop_id=$param[2]['shop_id'];
		}
		
	} elseif ($contact=='show_result_page'){
		$show_view='result_page';
	} elseif ($contact=='show_pay_page'){ #Страница с формой для генерации кнопки на оплату 	//   /?page=robokassa_page&action=show_pay_page

		$productinforeq=mysql_query("select * from `$tableprefix-product` p,`$tableprefix-product-vendors` v where p.`product_vendor_id`=v.`vendor_id` and p.`status`='active' ORDER BY `product_id` DESC;");
		$orderinforeq=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE 1;");
		$usersinforeq=mysql_query("SELECT * FROM `$tableprefix-users` WHERE 1;");
		if($_REQUEST['sale_id']){
			$sale_id=process_data($_REQUEST['sale_id'],5);
			$salesinforeq=mysql_query("SELECT * FROM `freecon-users-groups` gr,`freecon-users-groupmembers` gm,`freecon-users` u WHERE `groupname`='sales_managers' and gm.`group_id`=gr.`group_id` and u.`userid`=gm.`userid` and u.`userid`='".$sale_id."'");
		} else $salesinforeq=mysql_query("SELECT * FROM `freecon-users-groups` gr,`freecon-users-groupmembers` gm,`freecon-users` u WHERE `groupname`='sales_managers' and gm.`group_id`=gr.`group_id` and u.`userid`=gm.`userid`");
		
		$show_view='pay_page';
	} elseif ($contact=='show_this_pay_button'){ #Страница оплаты заказа сгенерированной с помощью формы  /?page=robokassa_page&action=show_pay_page
		
		/*
		Пример доступа к сгенерированной странице на оплату
		По ссылке:
		/?page=robokassa_page&action=show_this_pay_button&OutSum=12&Desc=Оплата+услуг+интернет-магазина+psy-space.ru&product_id=4&user_id=1099&order_id=133&sales_manager_id=1030&IsTest=on
		*/
		
		if($_REQUEST['OutSum']){
			if($_REQUEST['IsTest']=='on') $isTest=1; 
			else $isTest=0;
			if($_REQUEST['user_id']) {$user_id=process_data($_REQUEST['user_id'],15);
				$user_detail=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `userid`='$user_id'"));
			}
			$order_desc=process_data($_REQUEST['Desc'],400);
			$summ=process_data($_REQUEST['OutSum'],10);
			if($_REQUEST['order_id']!=='-') $order_id=$_REQUEST['order_id'];
			elseif($_REQUEST['new_order']=='on'){# Создаем order_id
				
				$new_order_q=mysql_query("INSERT INTO `$tableprefix-orders` (`order_id`, `user_id`, `client_id`, `subscription_id`, `status`, `creations_ts`, `product_variant_id`, `order_type`, `order_text`, `last_status_change_ts`, `chat_id`) VALUES (NULL, '$user_id', NULL, NULL, 'inprogress', NULL, '4', 'simple_order', '".$order_desc."', CURRENT_TIMESTAMP, NULL);");
				$order_id=mysql_insert_id($new_order_q);
			}
			if($_REQUEST['product_id']) {
				$product_id=process_data($_REQUEST['product_id'],10);
				$productinfo=mysql_fetch_array(mysql_query("select * from `$tableprefix-product` p,`$tableprefix-product-vendors` v where p.`product_vendor_id`=v.`vendor_id` and p.`status`='active' and p.`product_id`='".$product_id."' ORDER BY `product_id` DESC;"));
			}
			//if($_REQUEST['sale_id']){
				
			//}
			//$salesinforeq=mysql_query("");
			$show_view='external_payment_detail';
		} else {
			echo "Нет суммы";
		}
	}  elseif ($contact=='show_pay_page_by_order'){ #Страница оплаты заказа по order_id
		/*
		Пример доступа к сгенерированной странице на оплату
		По ссылке:
		/?page=robokassa_page&action=show_pay_button_by_order&order_id=12344
		*/
		
		$order_id=$_SESSION['order_group'];
		
		#Получаем сумму по заказу
		$summ=insert_module("swpshop","order_count_summ","$order_id");
		$order_desc=process_data($_REQUEST['order_desc'],200);
		if($_REQUEST['IsTest']=='on') $isTest=1; 
		else $isTest=0;
		#Показываем стр для оплаты с кнопкой
		$show_view='order_pay_page';
		
	} elseif($contact=='show_that_button_ajax'){
		/*
		if($_REQUEST['someid2']){
			if($_REQUEST['someid1']=='on' or $_REQUEST['someid1']=='1') $isTest=1; 
			else $isTest=0;
	
			$summ=process_data($_REQUEST['someid2'],10);
			if($_REQUEST['someid3']!=='-') $order_id=process_data($_REQUEST['someid3'],10);
			$order_desc=process_data($_REQUEST['someid4'],400);
			
			//echo $isTest.$summ.$order_id.$order_desc;
			$pay_detail_arr=array(
				'button_type'=>'with_label',
				'order_id'=>$order_id,
				'order_desc'=>$order_desc,
				'summ'=>$summ,
				'button_form'=>'M', //S;M;SS;MS;L;V
				'IsTest'=>$isTest //0;1
			);
			insert_module('robokassa','get_pay_button',$pay_detail_arr);
		} else {
			echo "Нет суммы";
		}*/
	}
}
?>