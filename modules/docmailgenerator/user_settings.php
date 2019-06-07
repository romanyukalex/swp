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
	global $userrole,$company_id,$tableprefix;
	if($userrole=="superuser"){
		$letnumber_qry=mysql_fetch_array(mysql_query("select * from `$tableprefix-letters` WHERE `from_company_id`='$company_id' order by `letter_id` DESC LIMIT 0,1;"));
		//echo "select * from `$tableprefix-letters` WHERE `from_company`='$company_id' order by `letter_id` DESC LIMIT 0,1;";
		?>
		<!--b>Текущий номер письма:</b>
		<?echo $current_let_num=$letnumber_qry['letter_number'];?><br><br-->
		<b>Задать новый номер следующего письма:</b>
		<form id="save_letnum_form"><div id="saveletnumform_ap"></div>
		<input type="text" name='next_let_num' value="<?=($current_let_num+1)?>"></form>
		<a href="/" onclick="saveform2('<?=$company_id?>','save_letnum_form','saveletnumform_ap','docmailgenerator','save_let_num','','');return false;" class="button small green">Сохранить</a>
		<br><br><br><br>
		
		
		<? insert_module("change_password");
	} elseif ($userrole=="user") {echo "У Вас нет прав на редактирование настроек сервиса. Обратитесь к администратору сервиса в Вашей компании";}
}?>