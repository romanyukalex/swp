<?php
 /***************************************************************************
  * Snippet Name : getTinyUrl       	           			 				* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : Укорачивание урла с помощью API TinyUrl.com	 			*
  * Access		 : 	getTinyUrl($url)	                                    *
  **************************************************************************/
function getTinyUrl($url) {   
    return file_get_contents("http://tinyurl.com/api-create.php?url=".urlencode(trim($url)));   
}
?>