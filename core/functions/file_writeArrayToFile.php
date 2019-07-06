<?php
 /***************************************************************************************
  * Snippet Name : Запись массива в файл и чтение из файла в массив	           			* 
  * Scripted By  : RomanyukAlex		           											* 
  * Website      : http://popwebstudio.ru	   											* 
  * Email        : admin@popwebstudio.ru     											* 
  * License      : GPL (General Public License)											* 
  * Purpose 	 : 									 									*
  * Access		 : testArray = array(1, 2, 3, 'five', 'six'); // тестовый массив		*
//file_writeArrayToFile($testArray,$fileName);														 	*
  **************************************************************************************/
$log->LogInfo('Got this file');
/**
* Запись массива в файл (дописать название файла в параметры)
*/
function file_writeArrayToFile($Array,$fileName){
    
	//var $serArray;
	# преобразовываем массив в строку
    
	if ((count($Array, COUNT_RECURSIVE) - count($Array)) > 0) {//Массив - многомерный
		foreach($Array as $array_key=>$array_value){
			$serArray.=$array_key.';'.$array_value."\r\n";
		}
	
	} else { //Массив - одномерный
		
		foreach($Array as $array_element){
			$serArray.=$array_element."\r\n";
		}
		
	}
	
	
	
	$file = fopen ($fileName,"w+"); // открываем файл, если надо то создаем
    fputs($file, $serArray); // записываем в него строку
    fclose($file); // закрываем файл
}
 
/**
* Чтение массива из файла
$phrases_arr=file($fileName);
*/
?>