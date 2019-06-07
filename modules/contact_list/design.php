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
	if($param[1]=="show_contact_list"){include($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/show_contact_list.php");}
	elseif($param[1]=="new_contact_form"){include($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/new_contact_form.php");}
	elseif($param[1]=="new_contact_form_targ"){include($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/new_contact_form_targ.php");}
	elseif($param[1]=="get_user_data"){#Дополнительные данные по юзеру из таблицы users
		include($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/get_user_data.php");
	}
?>
<? }?>