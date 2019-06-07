<?php
 /****************************************************************
  * Snippet Name : IP filter           							 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : block										 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo('Got this file');
if ($nitka=='1'){
global $sitecorrectipaddress;
if($sitecorrectipaddress!=='NO'){
	include_once($_SERVER['DOCUMENT_ROOT'].'/core/IPreal.php');
//include_once($_SERVER["DOCUMENT_ROOT"]."/core/functions/IPinRange.php");
	insert_function('IPinRange');
	if(ipinrange ($sitecorrectipaddress,$ip)==false){$block=1;} //протестировать, возможно надо return
}
} ?>