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
	global $userid;
	$lethist_qry=mysql_query("select * from `$tableprefix-letters` WHERE `letter_autor`='$userid' and `visibility`='1' order by `letter_id` DESC");
	if(mysql_num_rows($lethist_qry)>0){
		?><table><tr><th>Дата</th><th>Компания</th><th>Кому</th><th>Тема</th><th>Действие</th></tr><?
	
		while ($letters_info=mysql_fetch_array($lethist_qry)){
			?><tr>
			<td><?=$letters_info['ts']?></td>
			<td><?
			$to_comp_id=$letters_info['to_company_id'];
			$to_comp_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-companies` WHERE `company_id`='$to_comp_id';"));
			$to_company_fn=$to_comp_info['company_full_name'];
			echo $to_company_fn?></td>
			<td><?
			$to_contact_id=$letters_info['to_contact'];
			$to_contact_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-contactlist` WHERE `contact_id`='$to_contact_id';"));
			$to_company_pos=$to_contact_info['position'];
			$to_contact_fio=$to_contact_info['second_name']." ".mb_substr($to_contact_info['first_name'],0,1,'utf-8').".".mb_substr($to_contact_info['patronymic_name'],0,1,'utf-8').".";
			echo $to_company_pos."<br>".$to_contact_fio;			
			?></td>
			<td><?=$letters_info['letter_theme']?></td>
			<td><a href="/modules/docmailgenerator/download_file.php?filename=<?=$letters_info['file_name']?>&history=yes" target="_blank" class="button small green">Создать копию документа <?=$letters_info['letter_number']?></a></td>
			</tr><?
		}
		?></table><?
	}
}?>