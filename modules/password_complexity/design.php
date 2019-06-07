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
	$Secret="1*skgyMSY";
	@include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Password.php");// вставили класс
	# Проверка пароля
	//$Password = new Password($Secret);
	//echo $_CONFIG['MinTotalChars'];
		# Генерация пароля
	$Password = new Password("");
	//$Password->_generatePassword();
	echo $Password->getparam();
	echo $Password->getPassword();
	
	if (!$Password) {
			echo "Password does not exist";
		}
	if (!$Password->isValid()) {
			echo "Password does not fulfill the security rules";
		}
	//insert_module("protected_mail","cloud@ts-cloud.ru","пишите на cloud@ts-cloud.ru","a_id");
	
}?>