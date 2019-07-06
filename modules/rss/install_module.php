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

	mysql_query("INSERT INTO `$tableprefix-siteconfig`  (`id` , `value` , `vartype` , `describe` , `systemparamname` , `formmaxlegth` , `varpossible` , `showtositeadmin` , `example` , `depend` , `maybeempty` , `module_id` ) VALUES
	(NULL , '10', '1', 'Количество новостей, выдаваемых в RSS-ленту', 'rssnewsquantity', NULL , NULL , '1', '10', 'system', '1', '$module_id' ),
	(NULL , '/modules/rss/rss.png', '1', 'Пиктограмма RSS', 'rss_picture', NULL , NULL , '1', '10', 'system', '1', '$module_id' ),
	(NULL, 'Доменное имя, на которое пришел запрос', '2', 'Откуда брать доменное имя в ленте RSS', 'rss_choosedomain', NULL, 'Доменное имя по-умолчанию sitedomainname;;Доменное имя, на которое пришел запрос', '1', NULL, 'design', '1', '$module_id'),
	(NULL, '/project/rr/files/logo.jpg', '1', 'RSS. Файл логотипа в формате JPG ', 'rss_logofile', '100', NULL, '1', NULL, 'design', '1', NULL, '$module_id'),
	(NULL, '200', '1', 'Минимальное количество символов в полном описании новости, выводимого в RSS', 'rss_text_min', NULL, NULL, '1', '200', 'design', '1', '$module_id');");

}
?>