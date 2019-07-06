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

/*
function __autoload($class_name) {
  include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/'.$class_name.'.php';
} //Депрекейтед в php7.1
*/
// ищем файлы согласно директивы include_path
function myAutoload($classname) {
   include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/'.$classname.'.php';
}

// регистрируем загрузчик
spl_autoload_register('myAutoload', TRUE);


/*СДелать ТАК c папками

function commentonAutoload($className)
{
    $arrPath = array(
        '/components/',
        '/controllers/',
        '/models/',
        '/components/social/'
    );

    foreach ($arrPath as $path) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . $path . $className . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register('commentonAutoload');
*/

?>