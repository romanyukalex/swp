<?
/*****************************************************************************************************************************
  * Snippet Name : nullFileSize_monitoring																					 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Мониторинг нулевых файлов																				 *
  * Using		 : For errors detecting																						 *
  ***************************************************************************************************************************/
//$sitemapflag=1;
 
if($nitka=='1' and $now_hour=="02" and $now_min=="37"){


function search_null_file($dir) { 
	$result = array(); 
	$cdir = scandir($dir); 
	foreach ($cdir as $key => $value) 
	{ 
		if (!in_array($value,array(".",".."))) { 
			if (is_dir($dir .'/' . $value)) { 
				$result1 = search_null_file($dir . '/' . $value); 
				if($result1) $result=array_merge($result1,$result);

			} 
			else 
				{ //echo "Размер файла ".$dir.$value.' - '.filesize($dir.'/'.$value)."<br>";
					
					if (filesize($dir.'/'.$value)==0) {//Записываем в результат
						$fullfilename=$dir.'/'.$value;
						if(mb_strstr($fullfilename,"//")) $fullfilename=str_replace("//","/",$fullfilename);
						
						$result[] =$fullfilename; 
					}
				} 
		 
      } 
   }
   if(count($result)>0) return $result;
   else return False;
}

$null_files_arr=search_null_file("/home/a/aromanuq/popwebstudio/public_html/");
//var_dump($null_files_arr);




if($null_files_arr) { //Есть нулевые файлы, отправляем оповещение
	//insert_function("send_letter");
	//include $_SERVER['DOCUMENT_ROOT'].'/core/functions/send_letter.php';
	$message="Здравствуйте!<br>
	Обнаружены файлы с нулевым размером:<br>";
	foreach($null_files_arr as $fname){
		$message.=$fname."<br>";
		
	}
	//sendletter_to_admin("Файлы с нулевым размером",$message);
	//sendletter("aromanuk@mail.ru","Файлы с нулевым размером",$message);
	//sendletter_full("aromanuk@mail.ru","aromanuk@mail.ru","Файлы с нулевым размером",$message,"info@psy-space.ru","info@psy-space.ru");
	$from_email_name="Files Cron monitoring";
	$from_email_address="info@psy-space.ru";
	$to_email_address="aromanuk@mail.ru";
	$to_email_name="Администратор SWP";
	$subject="Файлы с нулевым размером";
	
	$header.="Content-type: text/html;  charset=\"UTF-8\"\r\n";
	$header.="From: =?utf-8?B?".base64_encode($from_email_name)."?= <".$from_email_address.">\r\n";
	//if($cc) $header.="CC: =?utf-8?B?".base64_encode($from_email_name)."?= <".$from_email_address.">\r\n";
	//$header.='Reply-To: noreply@'.$sitedomainname."\r\n";
	$header.="Content-Transfer-Encoding: utf-8\r\nContent-Disposition: inline\r\nMIME-Version: 1.0\r\n";
	
	@ mail("=?utf-8?B?".base64_encode($to_email_name)."?= <".$to_email_address.">", '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);

}


}
?>