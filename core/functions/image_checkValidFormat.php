<?php
/**
* Проверка корректности формата файла
* 
* @param string $file - имя файла или путь до файла
* @param array $validFormat - массив с корректными форматами
*
* @return boolean - результат проверки
*/
function image_checkValidFormat($file, $validFormat){
    $format = end(explode(".", $file));
    if(in_array(strtolower($format), $validFormat)){
        return true;
    }
    return false;
}
 
/**
* Проверка корректности размера файла
* 
* @param string $file - имя файла или путь до файла
* @param array $validSize - массив с корректными размерами. <br/>
* array(<br/>
*   'width'=>$width,  // - максимально допустимая ширина <br/>
*   'heigth'=>$heigth // - максимально допустимая высота <br/>
* )
*
* @return boolean - результат проверки
*/
function image_checkValidSize($file, $validSize){
    $sizeImg = @getimagesize($file);
    if(!$sizeImg) return false;
    if($validSize['width']>=$sizeImg[0] && $validSize['height']>=$sizeImg[1] ){
        return true;
    }
    return false;
}
?>