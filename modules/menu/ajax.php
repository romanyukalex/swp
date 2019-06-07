<?php
 /****************************************************************
  * Snippet Name : module template (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some ajax functions							 *
  * Access		 : include									 	 *
  ***************************************************************/

$log->LogInfo("Got ".(__FILE__)); // крашит вэб
if ($nitka=="1"){
	insert_function("process_user_data");
	if($_REQUEST['menuname']){#Запрос на конкретное меню
		$menu=process_data($_REQUEST['menuname'],20);
	} elseif($_REQUEST['pagename']){
		$qpage=process_data($_REQUEST['pagename'],25);
		$menu_q=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page`='$qpage'"));
		if($menu_q['page_menu']){$menu=$menu_q['page_menu'];}
	}
	$menu_with_UL="no";$menu_with_LI="yes";
	$log->LogDebug("Requested menu is ".$menu);
	if ($menu) include($_SERVER["DOCUMENT_ROOT"]."/modules/menu/design.php");
	else{echo "<!-- Меню не найдено -->";}
} ?>