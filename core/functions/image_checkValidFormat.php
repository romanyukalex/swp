<?php
/**
* �������� ������������ ������� �����
* 
* @param string $file - ��� ����� ��� ���� �� �����
* @param array $validFormat - ������ � ����������� ���������
*
* @return boolean - ��������� ��������
*/
function image_checkValidFormat($file, $validFormat){
    $format = end(explode(".", $file));
    if(in_array(strtolower($format), $validFormat)){
        return true;
    }
    return false;
}
 
/**
* �������� ������������ ������� �����
* 
* @param string $file - ��� ����� ��� ���� �� �����
* @param array $validSize - ������ � ����������� ���������. <br/>
* array(<br/>
*   'width'=>$width,  // - ����������� ���������� ������ <br/>
*   'heigth'=>$heigth // - ����������� ���������� ������ <br/>
* )
*
* @return boolean - ��������� ��������
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