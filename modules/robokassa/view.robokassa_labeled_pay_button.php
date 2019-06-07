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
if ($nitka=='1'){?>
<script src='https://auth.robokassa.ru/Merchant/PaymentForm/Form<?=$param[2]['button_form']?>.js?MerchantLogin=<?=$rk_shop_id?>&<?if($param[2]['button_form']=='FL' or $param[2]['button_form']=='FLS'){?>DefaultSum<?}else{?>OutSum<?}?>=<?=$param[2]['summ']?>&InvoiceID=<?=$param[2]['order_id']?>&Description=<?=$param[2]['order_desc']?>&SignatureValue=<?=$crc?>&IsTest=<?=$param[2]['IsTest']?>'></script>
<? }?>