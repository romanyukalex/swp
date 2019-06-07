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
	global $companiesprefix,$company_id;
	?><select id="new_letter_form_35" name="35"><option>Выберите из списка</option>
 <? //mysql_data_seek($contacts_q,0);
	$contacts_q=mysql_query("SELECT * FROM `$companiesprefix-contactlist` WHERE `company_id`='$company_id';");
	insert_module("contactlist_targ");
	while($targ_contacts=mysql_fetch_array($contacts_q))
		{?>
		<option value="<?=$targ_contacts['contact_id']?>"><?=$targ_contacts['second_name']." ".$targ_contacts['first_name'];?></option>
	<? 	}?></select><?
}?>