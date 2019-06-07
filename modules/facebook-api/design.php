<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : insert_module("vk-api","api_id","secret_key");?>	*
  * insert_module("vk-api","4977152","mo8Ru7fGxBriLR93uEOh");		*
  ******************************************************************/

  
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
function fb_fan_count($facebook_name){

    $data = json_decode(file_get_contents("https://graph.facebook.com/".$facebook_name));
    echo $data->likes;
}

 }?>