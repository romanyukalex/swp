<?php
 /***************************************************************************************************************
  * Snippet Name : image_makeRoundCorners  (скругление углов картинки)											*
  * Access		 :																								*
  * 																											*
  **************************************************************************************************************/
  $log->LogInfo('Got this file');

/**
* Скругление углов картинки
*
* @param $image - картинка
* @param $radius - радиус скругления
* @param $background - цвет фона для скруглений
*
* @return изображение

// пример использования
$radius = 50;
$imgPath = 'images/test_img.jpg';
$background = 0xffffff;
// закругляем углы
$imgCorner = image_makeRoundCorners($imgPath, $radius, $background);
// вывод картинки в браузер
header('Content-Type: image/png');
imagepng($imgCorner);

*/
function image_makeRoundCorners($image, $radius, $background){
    // загружаем картинку
    $img = imagecreatefromjpeg($image);
    // включаем режим сопряжения цветов
    imagealphablending($img, true);
    // размер исходной картинки
    $width = imagesx($img);
    $height = imagesy($img);
    // создаем изображение для углов
    $corner = imagecreatetruecolor($radius, $radius);
    imagealphablending($corner, false);
    // прозрачный цвет
    $trans = imagecolorallocatealpha($corner, 255, 255, 255, 127);
    // заливаем картинку для углов
    imagefill($corner, 0, 0, $background);
    // рисуем прозрачный эллипс
    imagefilledellipse($corner, $radius, $radius, $radius * 2, $radius * 2, $trans);
    // массив положений. Для расположения по углам
    $positions = array(
        array(0, 0),
        array($width - $radius, 0),
        array($width - $radius, $height - $radius),
        array(0, $height - $radius),
    );
    // накладываем на углы картинки изображение с прозрачными эллипсами
    foreach ($positions as $pos) {
        imagecopyresampled($img, $corner, $pos[0], $pos[1], 0, 0, $radius, $radius, $radius, $radius);
        // поворачиваем картинку с эллипсов каждый раз на 90 градусов
        $corner = imagerotate($corner, -90, $background, false);
    }
    // вернем картинку
    return $img;
}
?>