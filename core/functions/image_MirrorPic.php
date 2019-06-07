<?php
	/***********************************************************************************************************\
	* Snippet Name	: 																			*
	* Purpose		: Зеркальное отображение картинки														*
	* Access		: image_MirrorPic('test.jpg', 'testNew.jpg');									*
	\***********************************************************************************************************/

$log->LogInfo('Got this file');
function image_MirrorPic($fileImg, $newFile){
    // загружаем картинку
    $source = imagecreatefromjpeg($fileImg);
    // получаем размеры картинки
    $size = getimagesize($fileImg);
    // создаем новое изображение
    $img = imagecreatetruecolor($size[0], $size[1]);
    // наносим попиксельно изображение в обратном порядке
    for ($x = 0; $x < $size[0]; $x++) {
        for ($y = 0; $y < $size[1]; $y++) {
            $color=imagecolorat($source, $x,$y);
            imagesetpixel($img, $size[0]-$x, $y, $color);
        }
    }
    // сохраняем изображение
    imagejpeg($img, $newFile);
    // очищаем память
    imagedestroy($img);
}?>