<?php
if ($nitka=="1"){
 /***********************************************************************************
  * Snippet Name : Years	         		 										* 
  * Scripted By  : RomanyukAlex		           										* 
  * Website      : http://popwebstudio.ru	   										* 
  * Email        : admin@popwebstudio.ru     										* 
  * License      : GPL (General Public License)										* 
  * Purpose 	 : To show years at the bottom 2011-2012							*
  * Access		 : insert_module("years");											*
  **********************************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
global $sitestartdate;
$a=getdate();
if ($sitestartdate){
	$yearofcreate=date( "Y", strtotime($sitestartdate));
	if ($a['year']>$yearofcreate) echo $yearofcreate." - ".$a['year'];
	else echo $yearofcreate;
} else {echo $a['year'];}
?>
<? } ?>