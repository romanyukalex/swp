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
$letter_num=$_REQUEST['someid1'];

	$letter_qry=mysql_query("SELECT * FROM `$moduletableprefix-letters` WHERE `letter_id`='$letter_num';");
	while ($letter_info=mysql_fetch_array($letter_qry)){
	$mailtheme=$letter_info['letter_theme'];
	$mailbody=$letter_info['letter_text'];
	$to_comp_id=$letter_info['to_company_id'];
	$to_comp_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-companies` WHERE `company_id`='$to_comp_id';"));
	$to_company_fn=$to_comp_info['company_full_name'];

	$to_contact_id=$letter_info['to_contact'];
	$to_contact_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-contactlist` WHERE `contact_id`='$to_contact_id';"));
	
	$to_company_pos=$to_contact_info['position'];

	$to_contact_fio=$to_contact_info['second_name']." ".mb_substr($to_contact_info['first_name'],0,1,'utf-8').".".mb_substr($to_contact_info['patronymic_name'],0,1,'utf-8').".";
	# Обращение
	if($to_contact_info['gender']=="male" or $to_contact_info['gender']=="-") $accost="Уважаемый";
	else $accost="Уважаемая";
	$accost.=" ".$to_contact_info['first_name']." ".$to_contact_info['second_name'];
	
	
	if($letter_info['letter_number']) $letter_num=$letter_info['letter_number'];
	else $letter_num=$letter_info['letter_id'];
	
	$from_comp_id=$letter_info['from_company_id'];
	$from_comp_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-companies` WHERE `company_id`='$from_comp_id';"));
	
	if($letter_info['letter_type']=="garant_letter") {
		
		$guaranty_text="Оплату гарантируем.";
		$guaranty_text2="Банковские реквизиты:";
		$bankname=$from_comp_info['bank_name'];
		$bik="БИК ".$from_comp_info['bik'];
		$korr="К/С ".$from_comp_info['correspondent_account'];
		$rasch_acc="Р/С ".$from_comp_info['settlement_account'];
		$inn="ИНН ".$from_comp_info['inn'];
		$kpp="КПП ".$from_comp_info['kpp'];
		$okpo="Код ОКПО ".$from_comp_info['okpo'];
		$ogrn="ОГРН ".$from_comp_info['ogrn'];
		$buh_contact_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-contactlist` WHERE `company_id`='$from_comp_id' and `position`='Главный бухгалтер';"));
		$guar_sender_buh=$buh_contact_info['position'];
		$guar_sender_buh_fio=$buh_contact_info['second_name']." ".mb_substr($buh_contact_info['first_name'],0,1,'utf-8').".".mb_substr($buh_contact_info['patronymic_name'],0,1,'utf-8').".";
	}
	elseif($letter_info['letter_type']=="plain_letter") {
		$guaranty_text="";
		$guaranty_text2="";
		$bankname="";
		$bik="";
		$korr="";
		$rasch_acc="";
		$inn="";
		$kpp="";
		$okpo="";
		$ogrn="";
		$guar_sender_buh="";
		$guar_sender_buh_fio="";
	}
	$director_id=$letter_info['from_director'];
	$director_contact_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-contactlist` WHERE `contact_id`='$director_id';"));
	$sender_position=$director_contact_info['position'];
	$sender_fio=$director_contact_info['second_name']." ".mb_substr($director_contact_info['first_name'],0,1,'utf-8').".".mb_substr($director_contact_info['patronymic_name'],0,1,'utf-8').".";
	
	$ispolnitel_id=$letter_info['from_contact_id'];
	$ispolnitel_contact_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-contactlist` WHERE `contact_id`='$ispolnitel_id';"));
	$ispolnitel=$ispolnitel_contact_info['second_name']." ".$ispolnitel_contact_info['first_name']." ".$ispolnitel_contact_info['patronymic_name'];
	if($ispolnitel_contact_info['mobile']) $ispolnit_phone=$ispolnitel_contact_info['mobile'];
	if($ispolnitel_contact_info['desk_phone']) $ispolnit_phone.=", ".$ispolnitel_contact_info['desk_phone'];
	
	$docfilename=$letter_info['file_name'];
	echo "fn=".$docfilename;
	}

	# Число
	$time_var = time();
	$monthes = array(
		1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
		5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
		9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
	);
	$data1= (date('d', $time_var));
	$month = ($monthes[(date('n', $time_var))]);
	$curent_year=date('Y', $time_var);
	
	
	
	
	
	# Откроем Doc
	$zip = new ZipArchive;
	$opened =$zip->open($_SERVER["DOCUMENT_ROOT"].'/modules/word_doc_generate/1.docx');
	if ($opened == TRUE) {
		//открываем наш шаблон для чтения (он находится вне документа)  и помещаеем его содержимое в переменную $content
		$handle = fopen($_SERVER["DOCUMENT_ROOT"]."/modules/word_doc_generate/word_templates/template1/word/document.xml", "r");
		$body_content = fread($handle, filesize($_SERVER["DOCUMENT_ROOT"]."/modules/word_doc_generate/word_templates/template1/word/document.xml"));
		fclose($handle);
		//Далее заменяем в шаблоне все что нам нужно:
		
		$body_content = str_replace("DAT1",$data1,$body_content);
		$body_content = str_replace("MONTH",$month,$body_content);
		$body_content = str_replace("YEAR",$curent_year,$body_content);
		$body_content = str_replace("LETNUM",$letter_num,$body_content);
		$body_content = str_replace("MAILTHEME",$mailtheme,$body_content);		
		$body_content = str_replace("MAILACCOST",$accost,$body_content);		
		$body_content = str_replace("TOCONTACTPOSITION",$to_company_pos,$body_content);
		$body_content = str_replace("TOCOMPANYFN",$to_company_fn,$body_content);
		$body_content = str_replace("TOCONTACTFIO",$to_contact_fio,$body_content);
		
		$body_content = str_replace("LETNUM",$letter_num,$body_content);
		
		# Текст письма
		$body_content = str_replace("MAILBODY",$mailbody,$body_content);
		$body_content = str_replace("GUARTXT",$guaranty_text,$body_content);
		$body_content = str_replace("GUARTEXT",$guaranty_text2,$body_content);
		$body_content = str_replace("GUARBANK",$bankname,$body_content);
		$body_content = str_replace("GUARBIK",$bik,$body_content);
		$body_content = str_replace("GUARKORR",$korr,$body_content);
		$body_content = str_replace("GUARRASCH",$rasch_acc,$body_content);
		$body_content = str_replace("GUARINN",$inn,$body_content);
		$body_content = str_replace("GUARKPP",$kpp,$body_content);
		$body_content = str_replace("GUAROKPO",$okpo,$body_content);
		$body_content = str_replace("GUAROGRN",$ogrn,$body_content);
		$body_content = str_replace("SENDERPOS",$sender_position,$body_content);
		$body_content = str_replace("SENDERFIO",$sender_fio,$body_content);
		$body_content = str_replace("GUARSENDERBUH",$guar_sender_buh,$body_content);
		$body_content = str_replace("GUARSNDBUHFIO",$guar_sender_buh_fio,$body_content);
		$body_content = str_replace("ISPOLNITEL",$ispolnitel,$body_content);
		$body_content = str_replace("ISPOLNPHONE",$ispolnit_phone,$body_content);
		
		
		//Удаляем имеющийся в архиве document.xml
		$zip->deleteName('word/document.xml');
		//if($zip->deleteName('word/document.xml')) echo "xml deleted<br>";
		//echo " numfiles=".$zip->numFiles."<br>"; // Количество файлов в архиве
		//Пакуем созданный нами ранее файл и закрываем
		$zip->addFromString('word/document.xml',$body_content);
		//echo " numfiles=".$zip->numFiles."<br>"; // Количество файлов в архиве
		$zip->close();
		
		//$body_content=iconv("windows-1251", "UTF-8",$body_content);
		
		/*
		<script>
		$("#new_letter_form_ap2").load('/modules/docmailgenerator/download_file.php',{filename:"<?=$docfilename?>"},function(){ })
		</script><?
		*/
		?>
		<a href="/modules/docmailgenerator/download_file.php?filename=<?=$docfilename?>" target="_blank" class="button green">Скачать файл</a>
		<?
		//if($zip->close()) echo "WORD closed"; 
		//else echo "WORD NOT closed";
	} else echo "Не открылся шаблон DOCX";



}?>