<?php
 /****************************************************************
  * Snippet Name : add_to_end_of_file           				 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Добавление строки в конец любого файла		 *
  * Access		 : $msg = add_to_end_of_file($data, $file);	 	 *
  ***************************************************************/
$log->LogInfo('Got this file');
/*  # Рабочий пример:
// Функция добавления строки в файл
include_once('add_to_end_of_file.php');
$data=substr($_POST['data'],0,10000);
if (isset($data)) 
	{if (add_to_end_of_file($data, $file)){$showmessage="Добавлено успешно.";}
	else {$showmessage="The file $file does not exist or it is not a valid file!";}
  	} 
*/
 function  add_to_end_of_file($data, $file) {
	global $log;
	$log->LogDebug ("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	
	if(!file_exists($file)) { # Не существует файла, создаём
		$fh = fopen($file, "w");
		fclose($fh);
	}
	if (is_writeable($file) ){
		$fh = fopen($file, "a+");
		//Есть ли в файле уже такая запись?
		$substr_count = substr_count($file,$data);
		if ($substr_count==0) {// Записать содержимое $data в файл 
			$correct_return = "\r\n";
			$data=$correct_return.$data;
			fwrite($fh, $data);
			fclose($fh);
			return true;
		}
	} else {return false;}
}?>