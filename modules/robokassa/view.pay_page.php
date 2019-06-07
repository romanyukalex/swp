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
Оплата через Робокассу (модуль <?=$modulename?>)
<style>
#robokassa_pay_div{}
#robokassa_pay_form input,#robokassa_pay_form select{width:400px}
</style>

<div id="<?=$modulename?>_pay_okap"></div>
<div id='<?=$modulename?>_pay_div'>
<form id='<?=$modulename?>_pay_form' action="/" method="GET">
<input type="hidden" name="page" value="<?=$modulename?>_page">
<input type="hidden" name="action" value="show_this_pay_button">
<table>
<tr><td>Сумма*</td><td><input type='text' name='OutSum'>руб.</td>
<tr><td>Описание платежа*</td><td><input type=text name=Desc value='Оплата услуг интернет-магазина <?=$sitedomainname?>'></td>
<tr><td>Продукт/услуга</td><td><select name='product_id'><option value='-' select>-</option><?
while ($productinfo=mysql_fetch_array($productinforeq)){?>
<option value='<?=$productinfo['product_id']?>'><?=$productinfo['product_full_title_'.$language]?></option>
<?}
?></select></td>
<tr><td>Пользователь</td><td><select name='user_id'><option value='-' select>-</option>
<?while ($usersinfo=mysql_fetch_array($usersinforeq)){?>
<option value='<?=$usersinfo['userid']?>'><? if($usersinfo['fullname']) echo $usersinfo['fullname']; elseif($usersinfo['second_name'] or $usersinfo['first_name']) echo $usersinfo['second_name'].' '.$usersinfo['first_name'].' '.$usersinfo['patronymic_name']; else echo $usersinfo['login'];?></option>
<?}
?>
</select></td>

<tr><td>Номер заказа</td><td><select name='order_id'><option value='-'>-</option>
<?while ($orderinfo=mysql_fetch_array($orderinforeq)){?>
<option value='<?=$orderinfo['order_id']?>'><?=$orderinfo['order_id']?></option>
<?}
?>
</select></td>
<tr><td>Продавец</td><td>
<? if($sale_id){ # Использована ссылка продавца, включавшая sale_id
	$salesinfo=mysql_fetch_array($salesinforeq);
?><input type="hidden" value='<?=$salesinfo['userid']?>'><? if($salesinfo['fullname']) echo $salesinfo['fullname']; elseif($salesinfo['second_name'] or $salesinfo['first_name']) echo $salesinfo['second_name'].' '.$salesinfo['first_name'].' '.$salesinfo['patronymic_name']; else echo $salesinfo['login'];
} else {?>
	<select name='sales_manager_id'>
	<option value='-'>-</option>
	<?while ($salesinfo=mysql_fetch_array($salesinforeq)){?>
	<option value='<?=$salesinfo['userid']?>'><?=$salesinfo['userid']?></option>
	<?}?></select><?
}
?></td>
<tr><td>Создать заказ</td><td><input type='checkbox' name='new_order'></td>

<tr><td>Тестовый запрос на оплату?</td><td><input type='checkbox' name='IsTest'></td>
<tr><td colspan='2'>
<center>
<input type="submit" value="Сгенерировать страницу оплаты"></center>
<!--a onclick="saveform3('','robokassa_pay_form','<?=$modulename?>_pay_okap','<?=$modulename?>_pay_okap','<?=$modulename?>','get_external_pay_buttons','resetform','hideform');return false;">Отправить</a-->
</td>
</table>
</form>
</div>
<?}?>