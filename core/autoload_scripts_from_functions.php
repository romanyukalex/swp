<?php 
/*****************************************************************************************************************************
  * Snippet Name : autoload_scripts_from_functions.php																 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Функция автоподключения файла с классом при объявлении класса						 					 *
  * Insert		 : include_once('autoload_scripts_from_functions.php');														 *
  ***************************************************************************************************************************/
$log->LogInfo('Got this file');
/* используется так:
для классов class Image в Image.php и class Test в Test.php файлы сами инклудятся через объявление нового объекта  $a = new Test();$b = new Image();*/
function __autoload($class_name) {
  include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/'.$class_name.'.php';
}?>