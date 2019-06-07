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
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES
	(NULL, 'admin', '1', 'Робокасса. Индентификатор магазина', 'rk_login', NULL, NULL, '1', 'admin', 'system', '1','$module_id'),
	(NULL, 'P@$$w0rd1', '1', 'Робокасса. Рабочий Пароль 1', 'rk_pass1', NULL, NULL, '1','P@$$w0rd1','system', '1','$module_id'),
	(NULL, 'P@$$w0rd2', '1', 'Робокасса. Рабочий Пароль 2', 'rk_pass2', NULL, NULL, '1','P@$$w0rd2','system','1','$module_id'),
	(NULL, 'TSTP@$$w0rd1', '1', 'Робокасса. Тестовый Пароль 1', 'rk_test_pass1', NULL, NULL, '1', 'TSTP@$$w0rd1', 'system', '1', '$module_id'),
	(NULL, 'TSTP@$$w0rd2', '1', 'Робокасса. Тестовый Пароль 2', 'rk_test_pass2', NULL, NULL, '1', 'TSTP@$$w0rd2', 'system', '1', '$module_id');";
	
	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`,  `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, 'robokassa_page', 'Страница оплаты заказа', 'Order payment page', '$modulename', NULL, '0', '1')";
	
	$DBdata['Adding module messages']="INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
	(NULL, '$modulename', 'payment_success', 'Сообщение об удачном прохождении процедуры оплаты через Робокассу', 'Вы успешно оплатили заказ. Ожидайте звонка нашего менеджера в течении 20 минут', 'You successfully paid your order. Please, wait 20 minute and our manager will communicate you',null),
	(NULL, '$modulename', 'payment_fail', 'Сообщение о неудачном прохождении процедуры оплаты через Робокассу', 'Ваш заказ всё ещё не оплачен', 'Your order had not been paid', NULL)
	;
}
?>