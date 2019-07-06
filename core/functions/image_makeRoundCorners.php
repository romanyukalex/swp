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
insert_function("image_makeRoundCorners");
$radius = 10;
$imgPath = 'images/test_img.jpg';
$background = 0xffffff;
// закругляем углы
$imgCorner = image_makeRoundCorners($imgPath, $radius, $background);
// вывод картинки в браузер
header('Content-Type: image/png');
imagepng($imgCorner);
//Сохраняем на диск
imagejpeg($imgCorner,$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/1.jpg');

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


/*
$myPath = get_bloginfo('stylesheet_directory').'/images/rectangle.png';
rounded_rectangle(10, 10, 30, 20, 'ff0000', 10, 10, 'rectangle.png', 'test text', '#00ff00'); ?>
<img src="<?php echo $myPath; ?>">
<? */ 

function rounded_rectangle($left, $top, $padding_x, $padding_y, $color, $opacity, $corner_radius, $name, $text, $text_color){

	$width = $left + strlen($text)*9 + 2*$padding_x;
	$height = $top + 26 + 2*$padding_y;
	if(substr($color, 0, 1) == "#"){
		$color = substr($color, 1);
	}

	$r = substr($color,0,2);
	$g = substr($color,2,2);
	$b = substr($color,4,2);

	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);

	if(substr($text_color, 0, 1) == "#"){
		$text_color = substr($text_color, 1);
	}

	$text_r = substr($text_color,0,2);
	$text_g = substr($text_color,2,2);
	$text_b = substr($text_color,4,2);

	$text_r = hexdec($text_r);
	$text_g = hexdec($text_g);
	$text_b = hexdec($text_b);

	$opacity = (100 - $opacity)/100 * 127;

	$final_image = imagecreatetruecolor($left + $width, $top + $height);
	imagesavealpha($final_image, true);
	$trans_color = imagecolorallocatealpha($final_image, 0, 0, 0, 127);
	imagefill($final_image, 0, 0, $trans_color);

	$rectangle_color = imagecolorallocatealpha($final_image, $r, $g, $b, $opacity);

	$points_array = array(
		$left, $top + $corner_radius, //starting from top left corner before radius
		$left + $corner_radius - cos(deg2rad(22.5))*$corner_radius, $top + $corner_radius - sin(deg2rad(22.5))*$corner_radius,
		$left + $corner_radius - cos(deg2rad(45))*$corner_radius, $top + $corner_radius - sin(deg2rad(45))*$corner_radius,
		$left + $corner_radius - cos(deg2rad(67.5))*$corner_radius, $top + $corner_radius - sin(deg2rad(67.5))*$corner_radius,
		$left + $corner_radius, $top,

		$left + $width - $corner_radius, $top,
		$left + $width - $corner_radius + cos(deg2rad(67.5))*$corner_radius, $top + $corner_radius - sin(deg2rad(67.5))*$corner_radius,
		$left + $width - $corner_radius + cos(deg2rad(45))*$corner_radius, $top + $corner_radius - sin(deg2rad(45))*$corner_radius,
		$left + $width - $corner_radius + cos(deg2rad(22.5))*$corner_radius, $top + $corner_radius - sin(deg2rad(22.5))*$corner_radius,
		$left + $width, $top + $corner_radius,

		$left + $width, $top + $height - $corner_radius,
		$left + $width - $corner_radius + cos(deg2rad(22.5))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(22.5))*$corner_radius,
		$left + $width - $corner_radius + cos(deg2rad(45))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(45))*$corner_radius,
		$left + $width - $corner_radius + cos(deg2rad(67.5))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(67.5))*$corner_radius,
		$left + $width - $corner_radius, $top + $height,

		$left + $corner_radius, $top + $height,
		$left + $corner_radius - cos(deg2rad(67.5))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(67.5))*$corner_radius,
		$left + $corner_radius - cos(deg2rad(45))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(45))*$corner_radius,
		$left + $corner_radius - cos(deg2rad(22.5))*$corner_radius, $top + $height - $corner_radius + sin(deg2rad(22.5))*$corner_radius,
		$left, $top + $height - $corner_radius

	);

	$rectangle = imagefilledpolygon($final_image, $points_array, 20, $rectangle_color);

	$text_color = imagecolorallocatealpha($final_image, $text_r, $text_g, $text_b, 0);
	$font = 'wp-content/themes/paperballdesigns/arial.ttf';
	imagettftext($final_image, 20, 0, $left + $padding_x, $top + 26 + $padding_y, $text_color, $font, $text);

	imagepng($final_image, 'wp-content/themes/paperballdesigns/images/'.$name);

	/*
if(!empty($path)){
		imagepng($final_image, $path);
	}else{
		header('Content-Type: image/png');
		imagepng($final_image);
	}
*/
	//imagedestroy($final_image);
}
?>