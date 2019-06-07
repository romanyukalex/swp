<?php 
 /*********************************************** 
  * Snippet Name : censorMsg                    * 
  * Scripted By  : Hermawan Haryanto            * 
  * Website      : http://hermawan.dmonster.com * 
  * Email        : hermawan@dmonster.com        * 
  * License      : GPL (General Public License) * 
  * Access		 : $msg = censor($msg,"*");	*
  ***********************************************/
$log->LogInfo('Got this file');

function file_nullFilesSearch($dir) { 
	$result = array(); 
	$cdir = scandir($dir); 
	foreach ($cdir as $key => $value) 
	{ 
		if (!in_array($value,array(".",".."))) { 
			if (is_dir($dir .'/' . $value)) { 
				$result1 = file_nullFilesSearch($dir . '/' . $value); 
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

#Usage example
/*
$null_files_arr=file_nullFilesSearch("/home/a/aromanuq/popwebstudio/public_html/");

if($null_files_arr) { 
	foreach($null_files_arr as $fname){
		echo $fname."<br>";
	}
}
*/
?>