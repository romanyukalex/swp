<?php
 /***************************************************************************************
  * Snippet Name : Запись массива в файл и чтение из файла в массив	           			* 
  * Scripted By  : RomanyukAlex		           											* 
  * Website      : http://popwebstudio.ru	   											* 
  * Email        : admin@popwebstudio.ru     											* 
  * License      : GPL (General Public License)											* 
  * Purpose 	 : 									 									*
  * Access		 : testArray = array(1, 2, 3, 'five', 'six'); // тестовый массив		*
//writeArrayInFile($testArray);														 	*
  **************************************************************************************/
$log->LogInfo('Got this file');
/**
* Запись массива в файл (дописать название файла в параметры)
*/
function file_writeArrayToFile($testArray){
    $serArray = serialize($testArray); // преобразовываем массив в строку
    $file = fopen ("array.txt","w+"); // открываем файл, если надо то создаем
    fputs($file, $serArray); // записываем в него строку
    fclose($file); // закрываем файл
}
 
/**
* Чтение массива из файла
$phrases_arr=file($fileName);
*/
?>