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
	
	
	$put_siteconfig=mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES
	(NULL, 'DGup3X6fLFDB7a3WoQOEA', 1, 'Модуль TWITTER - CONSUMER_KEY', 'twitterconsumerkey', NULL, NULL, 1, NULL, 'user', 1,'$moduleid'),
	(NULL, 'RKyE2pSi2qsNMNiOFQlKeTZZkIFyANku3CG7lwEjg', 1, 'Модуль TWITTER - CONSUMER_SECRET', 'twitterconsumersecret', NULL, NULL, 1, NULL, 'user', 1,'$moduleid'),
	(NULL, '314150987-pkFTYydIffE9ITKHNz3NOluh2GtxmUsIrof5lyXu', 1, 'Модуль TWITTER - OAUTH_TOKEN', 'twitteroauthtoken', NULL, NULL, 1, NULL, 'user', 1,'$moduleid'),
	(NULL, '425QNLhdY2DeseBs8cwItemtiYxd9AiGNmOuDVmn0A', 1, 'Модуль TWITTER - OAUTH_SECRET', 'twitteroauthsecret', NULL, NULL, 1, NULL, 'user', 1,'$moduleid')
	
	;");


	
}
?>