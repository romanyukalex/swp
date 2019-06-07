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
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	# $module_id - id модуля
	/*
	$put_page_qry=mysql_query("INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `folder`, `filename`, `ext`, `pagetitle`, `pagebody`,`page_module`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES 
	(NULL, 'forgor_pass', '', NULL, NULL, 'Восстановление пароля', NULL,'forgot_password', 'defaultmenu', '0', '1');");
	*/
}
}
?>