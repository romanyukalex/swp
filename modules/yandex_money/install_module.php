<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module("modulename")			 	 *
  ***************************************************************/
$log->LogDebug('Got this file');
if ($moduleinstalled["$modulename"]!=='y' and $nitka=='1'){ #Требуется инсталляция
	
	# $module_id - id модуля
	
		
	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`,  `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, 'yamoney_page', 'Страница оплаты заказа', 'Order payment page', '$modulename', NULL, '0', '1')";
	
	$DBdata['Adding module messages']="INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
	(NULL, '$modulename', 'payment_success', 'Сообщение об удачном прохождении процедуры оплаты через Яндекс.Деньги', 'Вы успешно оплатили заказ. Ожидайте звонка нашего менеджера в течении 20 минут', 'You successfully paid your order. Please, wait 20 minute and our manager will communicate you',null),
	(NULL, '$modulename', 'payment_fail', 'Сообщение о неудачном прохождении процедуры оплаты через Яндекс.Деньги', 'Ваш заказ всё ещё не оплачен', 'Your order had not been paid', NULL)
	;";
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'XXXXXXXXXXXXXXXXXXXXXXXX', '1', 'Секрет для SHA1 в Yandex.Money', 'yamon_notif_secret', '30', NULL, '1', 'XXXXXXXXXXXXXXXXXXXXXXXX', 'design', '1','$moduleid');";
}
?>