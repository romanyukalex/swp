<?php
 /****************************************************************
  * Snippet Name : unzip_file		           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Проверка работоспособности сайта на CURL		 *
  * Access		 : unzip_file($file, $destination); 			 *
  ***************************************************************/
$log->LogInfo('Got this file');

function unzip_file($file, $destination){
    // создаем объект
    $zip = new ZipArchive() ;
    // открываем архив
    if ($zip->open($file) !== TRUE) {
        die ('Невозможно открыть архив');
    }
    // распаковываем содержимое в указанную директорию
    $zip->extractTo($destination);
    // закрываем архив
    $zip->close();
    echo 'Архив распакован';
}
?>