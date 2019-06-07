<?php
/****************************************************************
 * Snippet Name : module template (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
if($nitka=="1"){
	if($_REQUEST['action']=="get_company_contacts"){
	//$company_id=$_SESSION['company_id'];
	//echo "SELECT * FROM `$companiesprefix-contactlist` WHERE `company_id`='$company_id' or `parent_company_id`='$company_id';";
		$get_company_id=process_data($_REQUEST['someid1'],7);
		$contacts_q=mysql_query("SELECT * FROM `$companiesprefix-contactlist` WHERE `company_id`='$get_company_id';");
		if(mysql_num_rows($contacts_q)>0){
		while($targ_contacts=mysql_fetch_array($contacts_q))
		 {?><option value='<?=$targ_contacts['contact_id']?>'><?=$targ_contacts['second_name']." ".$targ_contacts['first_name']." ".$targ_contacts['patronymic_name']." - ".$targ_contacts['position']?></option><?}
		} else {?><option>Контактные лица не найдены</option><?}
	}
	elseif($_REQUEST['action']=="get_target_companies"){
		include($_SERVER["DOCUMENT_ROOT"]."/core/checkuserrole.php");
		@include($_SERVER["DOCUMENT_ROOT"]."/modules/docmailgenerator/show_target_companies.php");
		
	}
	if($_REQUEST['action']=="save_let_num"){
		$get_company_id=process_data($_REQUEST['someid'],7);
		$next_letter_num=process_data($_REQUEST['next_let_num'],7);
		if($next_letter_num>0){$next_letter_num=$next_letter_num-1;}
		mysql_query("INSERT INTO `$tableprefix-letters` (`letter_id`, 	`letter_number`, 	`letter_autor`, `letter_type`, `from_company_id`, `from_contact_id`, `from_director`, `to_company_id`, `to_contact`, `letter_theme`, `letter_text`, `file_name`, `ts`, 				`visibility`) 
												VALUES (NULL, 			'$next_letter_num', '0', 			'plain_letter', '$get_company_id', '0', 			NULL, 				'', 			'', 		NULL, 				NULL, 		'', 		CURRENT_TIMESTAMP, 	'2');");
			echo "Успешно сохранено";
	}
	//elseif($_REQUEST['action']=="create_doc"){
	//insert_function("insert_module");
	//insert_module("word_doc_generate",$_REQUEST['someid1']);
	//}
}?>