<?php
 /****************************************************************
  * Snippet Name : newsblock		          					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : show news									 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
if($_REQUEST['newspage']) insert_module("newsblock","newspage",process_data($_REQUEST['newspage'],3));
elseif($_REQUEST['newsaction']=="show_news_text") insert_module("newsblock","show_news_text",process_data($_REQUEST['news_id'],3));
}
