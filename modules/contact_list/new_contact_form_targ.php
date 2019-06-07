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
?>
<div id="newcontlistform_ap"></div>
<form id="newcontlistform">
<table class="formdcmtable">
<? insert_module("form_generator","show_form","new_contact_form_targ");?>
</table>
</form>
<? }?>