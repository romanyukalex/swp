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
	global $companiesprefix,$company_id;?>
	<select name="34" id="new_letter_form_34" onchange="get_contacts('new_letter_form_37');"><option>Выберите из списка</option>
 <? 
 $organization_q=mysql_query("SELECT * FROM `$companiesprefix-companies` WHERE `parent_company_id`='$company_id';");
  while($targ_organization=mysql_fetch_array($organization_q))
 {?>
 <option value='<?=$targ_organization['company_id']?>'><?=$targ_organization['company_full_name']?></option>
 <?}?>
</select>
<script>
function get_contacts(answerplace){
	contidval=$("#new_letter_form_34").val();
	alert(contidval);
	//ajaxreq(contidval,'','get_company_contacts',answerplace,'docmailgenerator');
}
</script>
<?
}?>