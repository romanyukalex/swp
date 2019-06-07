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

  
  # Способ 1
  
  
  $mailtheme="Тема письма из формы!!!";
  $targetsex=="m";
  $mailbody="Текст письма из формы";
  $to_company_pos="Директору";
  $to_company_fn="Копыта энд рога";
  $to_contact_fio="Иванову ВВ";
  $letter_num="22323";
  $data1="31"; // число месяца
  $month="июля";
  $curent_year="2014";
  $guaranty_text="Оплату гарантируем.";
  $guaranty_text2="Банковские реквизиты:";
  $bankname="НАЗВАНИЕ БАНКА";
  $bik="0000000000";
  $korr="0000000000000000000";
  $rasch_acc="00000000000000000000";
  $inn="00000000000";
  $kpp="00000000000";
  $okpo="00000000000";
  $ogrn="00000000000000";
  $sender_position="Должность лица от организации-отправителя";
  $sender_fio="Фамилия И. О.";
  $guar_sender_buh="Должность лица от организации-отправителя (бухгалтер)";
  $guar_sender_buh_fio="Фамилия И. О.";
  
  $ispolnitel="Фамилия Имя Отчество";
  $ispolnit_phone="234234234";
  
$zip = new ZipArchive;
$opened =$zip->open('1.docx');
if ($opened == TRUE) {
	//echo "Opened<br>";
	echo " numfiles=".$zip->numFiles."<br>"; // Количество файлов в архиве
	//echo " filename=".$zip->filename."<br>";
    //открываем наш шаблон для чтения (он находится вне документа)  и помещаеем его содержимое в переменную $content
    $handle = fopen("word_templates/template1/word/document.xml", "r");
    $body_content = fread($handle, filesize("word_templates/template1/word/document.xml"));
    fclose($handle);
    //Далее заменяем в шаблоне все что нам нужно:
	
	//$body_content="{MAILBODY}{MAILACCOST}{MAILTHEME}";
	echo $body_content."<br>";
	
	$body_content = str_replace("DAT1",$data1,$body_content);
	$body_content = str_replace("MONTH",$month,$body_content);
	$body_content = str_replace("YEAR",$curent_year,$body_content);
	$body_content = str_replace("LETNUM",$letter_num,$body_content);
	#Тема письма
	$body_content = str_replace("MAILTHEME",$mailtheme,$body_content);
	echo $body_content."<br><br>";
	# Обращение
	if($targetsex=="m") $accost="Уважаемый";
	else $accost="Уважаемая";
	$body_content = str_replace("MAILACCOST",$accost." ИМЯ ФАМИЛИЯ!",$body_content);
	//echo $body_content."<br><br>";
	
	//echo "<br>POSITION входит ".substr_count($body_content, 'TOCONTACTPOSITION');
	$body_content = str_replace("TOCONTACTPOSITION",$to_company_pos,$body_content);
	//echo "<br>POSITION входит ".substr_count($body_content, '{TOCONTACTPOSITION}');
	$body_content = str_replace("TOCOMPANYFN",$to_company_fn,$body_content);
	$body_content = str_replace("TOCONTACTFIO",$to_contact_fio,$body_content);
	
	$body_content = str_replace("LETNUM",$letter_num,$body_content);
	
	# Текст письма
    $body_content = str_replace("MAILBODY",$mailbody,$body_content);
	//echo $body_content."<br><br>";
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
	echo " numfiles=".$zip->numFiles."<br>"; // Количество файлов в архиве
    //Пакуем созданный нами ранее файл и закрываем
    $zip->addFromString('word/document.xml',$body_content);
    echo " numfiles=".$zip->numFiles."<br>"; // Количество файлов в архиве
	$zip->close();
	
	//$body_content=iconv("windows-1251", "UTF-8",$body_content);

	
	//if($zip->close()) echo "WORD closed"; 
	//else echo "WORD NOT closed";
} else echo "Не открылся DOCX";
	
		
/*
	# Способ 2
	
	# load zipstream class
require 'zipstream-php-0.2.2/zipstream.php';

# get path to current file
$pwd = dirname(__FILE__)."/word_templates/template1";

$filesdata = array(
  ''			=>			'[Content_Types].xml',
  '_rels'		=>			'.rels',
  'docProps'	=> 			'app.xml,core.xml',
  'word'		=>			'document.xml,endnotes.xml,fontTable.xml,footer1.xml,footnotes.xml,header1.xml,header2.xml,settings.xml,styles.xml,webSettings.xml',
  'word/_rels'	=>			'document.xml.rels,header1.xml.rels,header2.xml.rels',
  'word/media'	=>			'image1.jpeg',
  'word/theme'	=>			'theme1.xml'
  
);

# create new zip stream object
$zip = new ZipStream('Обращение N.docx', array(
  'comment' => 'Письмо в организацию N'
));

# common file options
$file_opt = array(
  # file creation time (2 hours ago)
  'time'    => time() - 2 * 3600,

  # file comment
  'comment' => 'Письмо в организацию N',
);


foreach ($filesdata as $folder=>$files) {
  $fileinfolder=explode(",",$files);
	foreach ($fileinfolder as $file){
	  # build absolute path and get file data
	  $path = ($file[0] == '/') ? $file : "$pwd/$folder/$file";
	  $data = file_get_contents($path);

	  # add file to archive
	  $zip->add_file($folder.'/' . basename($file), $data, $file_opt);
	  //echo $folder.'/' . basename($file)."<br>";
  }
}

# finish archive
$zip->finish();

	
	*/
	
	
	
	
?>