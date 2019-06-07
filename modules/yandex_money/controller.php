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
  
*/

$log->LogInfo('Got this file');
if($nitka=='1'){
	insert_function('process_user_data');
	
	if(!isset($contact)){$contact='show_result_page';}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact=='get_pay_button'){# Формируем кнопку на оплату
		global $language,$rk_login,$rk_pass1;		
		
		
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
		
	}
}
?>