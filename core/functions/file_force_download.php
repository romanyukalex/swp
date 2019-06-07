<?php
 /***********************************************************
  * Snippet Name : file_force_download	           			* 
  * Scripted By  : RomanyukAlex		           				* 
  * Website      : http://popwebstudio.ru	   				* 
  * Email        : admin@popwebstudio.ru     				* 
  * License      : GPL (General Public License)				* 
  * Purpose 	 : Принудительная скачка файла		 		*
  * Access		 : $response = isSiteAvailable($someUrl); 	*
  **********************************************************/
$log->LogInfo('Got this file');
function file_force_download($file){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    if ((isset($file))&&(file_exists($file))) {
       header("Content-length: ".filesize($file));
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename="' . $file . '"');
       readfile("$file");
    } else echo "No file selected";
}




//Скрипт ждет пока весь файл будет прочитан и отдан пользователю.
//Файл читается в внутренний буфер функции readfile(), размер которого составляет 8кБ
function file_force_download1($file) {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
}


//Скрипт ждет пока весь файл будет прочитан и отдан пользователю.
//Позволяет сэкономить память сервера

function file_force_download2($file) {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    if ($fd = fopen($file, 'rb')) {
      while (!feof($fd)) {
        print fread($fd, 1024);
      }
      fclose($fd);
    }
    exit;
  }
}

?>