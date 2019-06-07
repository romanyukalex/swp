<?php 
/****************************************************************************************************
  * Snippet Name : insert_function_function															* 
  * Scripted By  : RomanyukAlex		           														* 
  * Website      : http://popwebstudio.ru	   														* 
  * Email        : admin@popwebstudio.ru    					 									* 
  * License      : License on popwebstudio.ru from autor		 									*
  * Purpose 	 : Функция подключения файла с функцией по запросу						 			*
  * Insert		 : include_once $_SERVER['DOCUMENT_ROOT'].'/core/insert_function_function.php';		*
  * Usage		 : insert_function("functionname");													*
  ***************************************************************************************************/
$log->LogInfo('Got this file');

function insert_function($function_name) {
	global $log;//?
	return include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/'.$function_name.'.php';
}?>