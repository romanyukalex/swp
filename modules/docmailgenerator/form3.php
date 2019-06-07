
<form action="#" method="post" id="new_letter_form">

<? global $companiesprefix,$company_id,$userid;?>
 <p><input type="radio" name="33" value="garant_letter"> Написать гарантийное письмо<br>
 <input type="radio" name="33" value="plain_letter"> Написать письмо<br></p>
 <p>Выберите организацию</p>
 <p>
 <input type="hidden" name="41" value="<?=$userid?>" />
 <input type="hidden" name="34" value="<?=$company_id?>" />
 <select name="36" id="from_company_sel" onchange="get_contacts('to_contacts');"><option>Выберите из списка</option>
 <? 
 $organization_q=mysql_query("SELECT * FROM `$companiesprefix-companies` WHERE `parent_company_id`='$company_id';");
  while($targ_organization=mysql_fetch_array($organization_q))
 {?>
 <option value='<?=$targ_organization['company_id']?>'><?=$targ_organization['company_full_name']?></option>
 <?}?>
</select></p>
 <p><select id="to_contacts" name="37"><option>Выберите контактное лицо</option>
</select></p>			
 <p>Исходящий номер письма: <input type="text" name="42"
 value="<? 
 $letnumber_qry=mysql_fetch_array(mysql_query("select * from `$tableprefix-letters` WHERE `from_company_id`='$company_id' order by `letter_id` DESC LIMIT 0,1;"));
 $current_let_num=$letnumber_qry['letter_number']+1; echo $current_let_num; 
 ?>" disabled /></p>
 <p>Тема письма: <input type="text" name="38" /></p>
 <p>Текст письма: <br><textarea placeholder="Введите текст" name="39"></textarea></p>
 <p>Исполнитель</p>
 <p><select name="35"><option>Выберите из списка</option>
 <? //mysql_data_seek($contacts_q,0);
  $contacts_q=mysql_query("SELECT * FROM `$companiesprefix-contactlist` WHERE `company_id`='$company_id';");
 insert_module("contactlist_targ");
 while($targ_contacts=mysql_fetch_array($contacts_q))
 {?>
<option value="<?=$targ_contacts['contact_id']?>"><?=$targ_contacts['second_name']." ".$targ_contacts['first_name'];?></option>
<? }?></select></p>
<p>От лица:</p>
<select name="44">
<? mysql_data_seek($contacts_q,0);

 while($targ_contacts=mysql_fetch_array($contacts_q))
 {?>
<option value="<?=$targ_contacts['contact_id']?>"><?=$targ_contacts['second_name']." ".$targ_contacts['first_name'];?></option>
<? }?></select>




 <p>Название сохраняемого файла</p>
 <p><input type="text" name="40" /></p>
 <p> <div id="new_letter_form_ap"></div><div id="new_letter_form_ap2"></div> <a href="" class="button yellow" onClick="saveform2('new_letter_form','new_letter_form','new_letter_form_ap','form_generator','add','resetform','');return false">Сгенерировать письмо</a></p>
</form>
<script>
function get_contacts(answerplace){
	contidval=$("#from_company_sel").val();
	ajaxreq(contidval,'','get_company_contacts',answerplace,'docmailgenerator');
}
</script>