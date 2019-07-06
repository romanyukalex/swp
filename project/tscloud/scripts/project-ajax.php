<?php
 /***********************************************************************
  * Snippet Name : Project ajax scripts		 					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some ajax functions							 		*
  * Access		 : 														*
  *  ajaxreq(some_id1,some_id2,action,answer_place,"project_script");	*
  **********************************************************************/
 $log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	// example: ajaxreq('https://rusagro.ts-cloud.ru/stats.do','',"check_SN_DB","sn_db_check_ap","project_script");
	if($_REQUEST['action']=="check_SN_DB"){
		
		$url=$_REQUEST['someid1'];
		//$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | uri=".$url);
		//echo $url;
		$ht_file=file_get_contents($url);
		$pos = strripos($ht_file, 'db_connections');
		echo substr($ht_file, $pos+29, 6);

	}

} ?>