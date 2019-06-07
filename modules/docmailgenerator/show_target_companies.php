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
	# Выдаем список компаний, в которые будет добавляться контакт
	global $tableprefix,$language,$userid;
	$comp_query=mysql_query("SELECT *,c.`company_id` as comp_company_id FROM `$tableprefix-companies` c,`$tableprefix-users` u WHERE c.`parent_company_id`=u.`company_id` and `userid`='$userid';");
	if(mysql_num_rows($comp_query)>0){
		?><select name="31" id="new_contact_form_targ_31"><?
		while($comp_info=mysql_fetch_array($comp_query)){
			?><option value="<?=$comp_info['comp_company_id']?>"><?=$comp_info['company_full_name']?></option><?
		}
		?></select><?
	} else echo "Компании не найдены";
}?>