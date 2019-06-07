<?php
 /****************************************************************
  * Snippet Name : module template           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : include									 	 *
  ***************************************************************/

if ($nitka=="1"){
	global $tableprefix,$language;
	insert_function("process_user_data");
	$docaction=process_data($_REQUEST['docaction'],27);
	if($docaction=="addcompanybranchform"){include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/form1.php");}
	elseif($docaction=="addtargetcompany"){include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/form2.php");}
	elseif($docaction=="sendletter"){include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/form3.php");}
	elseif($docaction=="lettershistory"){include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/lettershistory.php");}
	elseif($docaction=="user_settings"){include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/user_settings.php");}
	
?>


<? }?>