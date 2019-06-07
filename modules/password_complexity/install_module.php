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
    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	# $module_id - id модуля
	
	/*
	
	Инсталляционные действия
	
	
	$put_pages=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, '$modulename', NULL, 0, 1)");
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'code1', 'Смысл сообщения 1', 'Сообщение на русском 1', 'Message text 1'),
		(NULL, '$modulename', 'code2', 'Смысл сообщения 2', 'Сообщение на русском 2', 'Message text 2'),
		(NULL, '$modulename', 'code3', 'Смысл сообщения 3', 'Сообщение на русском 3', 'Message text 3')		
		;");
		*/
	$put_settings=mysql_query("INSERT INTO `$tableprefix-siteconfig` 
	(`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
	(NULL, '7', '2', 'The minimum number of characters a password must have', 'MinTotalChars', NULL, '3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, '20', '2', 'The maximum number of characters a password must have', 'MaxTotalChars', NULL, '15;;20;;25;;30;;35;;40;;50;;60;;100', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, '0', '2', 'The miminum number of upper-cased characters ([A-Z]) a password must have', 'MinUpperChars', NULL, '0;;1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, '4', '2', 'The minimum number of lower-cased characters ([a-z]) a password must have', 'MinLowerChars', NULL, '0;;1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),	
	(NULL, '1', '2', 'The minimum number of numeric characters ([0-9]) a password must have', 'MinNumericChars', NULL, '0;;1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, '1', '2', 'The minimum number of special characters (~!@#$%^&*()_-+=[]\;,./{}|:<>?) a password must have', 'MinSpecialChars', NULL, '0;;1;;2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, '5', '2', 'The maximum number of consecutive characters (abc, 123, DeF) a password must have (well consider consecutive the characters that have consecutive ASCII codes (789:;<=>?@ABC are consecutive)', 'MaxConsecutiveChars', NULL, '2;;3;;4;;5;;6;;7;;8;;9;;10;;11;;12;;13;;14;;15;;20;;25;;30;;35', '1', NULL, 'secure', '1', '$module_id'),
	(NULL, 'N', '2', 'The term of special words reffer to words such as username, customer name, TN.', 'BlockSpecialWords', NULL, 'Y;;N', '1', NULL, 'secure', '1', '$module_id')
	;");
	
	
	
}
?>