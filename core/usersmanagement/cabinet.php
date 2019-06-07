<?php
 /****************************************************************
  * Snippet Name : usersmanagement (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some ajax functions							 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo('Got this file');
include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/core/checkuserrole.php"); // Определяем userrole
insert_function("process_user_data");
if($userrole and $userrole!=="guest"){
	if($_REQUEST['cact']){$cabinet_action=process_data($_REQUEST['cact'],27);}
	else $cabinet_action=$default_cact;
	if($cabinet_action=="change_password") insert_module("change_password");
	else {
		if($cabinet_action and is_readable($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/".$cabinet_action.".php")){
			include_once($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/".$cabinet_action.".php");
		} else {
			$log->LogError("File is not found: ".$_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/".$cabinet_action.".php");
		}
	}
}else{?><script>changerazdel("login");</script><?} //Не разрешаем незалогиненным посещать страницу кабинета
?>