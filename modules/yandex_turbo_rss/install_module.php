<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module(modulename)			 	 *
  ***************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));   
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция


	mysql_query("ALTER TABLE `$tableprefix-pages` ADD `turboyaposted` BOOLEAN NULL DEFAULT FALSE COMMENT 'This article is already posted to yandex turbo' AFTER `status`;");
	
	
	mysql_query("INSERT INTO `$tableprefix-siteconfig`  (`id` , `value` , `vartype` , `describe` , `systemparamname` , `formmaxlegth` , `varpossible` , `showtositeadmin` , `example` , `depend` , `maybeempty` , `module_id` ) VALUES
	(NULL , '10', '1', 'Количество новостей, выдаваемых в RSS-ленту Yandex Turbo', 'yarssnewsquantity', NULL , NULL , '1', '10', 'system', '1', '$module_id' ),
	
	(NULL, 'Доменное имя, на которое пришел запрос', '2', 'Откуда брать доменное имя в ленте RSS', 'ya_rss_choosedomain', NULL, 'Доменное имя по-умолчанию sitedomainname;;Доменное имя, на которое пришел запрос', '1', NULL, 'design', '1', '$module_id');");

}
?>