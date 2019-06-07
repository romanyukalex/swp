<?php
/*
* Поворот картинки на заданный угол
*
* $img - путь к картинке
* $degree - угол поворота
* $path - путь для сохранения картинки
* $formatImg - расширение картинки, для сохранения.
*/
function image_rotate($img, $degree, $path, $formatImg = 'jpeg'){
    // получаем данные о картинке
    $size = getimagesize($img);
    //определяем тип (расширение) картинки
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;   //определение функции для расшерения файла
    //если нет такой функции, то прекращаем работу скрипта
    if (!function_exists($icfunc)) return false;        
    // Загрузка изображения
    $source = $icfunc($img);
    // Поворот. Пустые углы заливаем цветом 0xffffff
    $rotate = imagerotate($source, $degree, '0xffffff');
    // сохраняем картинку
    $func = 'image'.$formatImg;
    $func($rotate, $path, 100);
    // очищаем пямять
    imagedestroy($rotate);
    // возвращаем путь к новой картинке
    return $path;
}
/*
* Поворот PNG картинки на заданный угол
*
* @var string $img - картинка
* @var string $degree - угол поворота
* @var string $path - путь для сохранения картинки
*
* @return string $path - путь к новой картинке
*/
function rotatePhotoPNG($img, $degree, $path){
    // загружаем картинку
    $simage = imagecreatefrompng($img); 
    // задаем ей прозрачность
    imagealphablending($simage, true); 
    imagesavealpha($simage, true); 
    // создаем прозрачный фон
    $bg = imagecolorallocatealpha($simage, 0, 0, 0, 127); 
    // поворот на нужный угол
    $rotate = imagerotate($simage, $degree, $bg); 
    // задаем прозрачность для повернутой картинки
    imagealphablending($rotate, true); 
    imagesavealpha($rotate, true);      
    // сохраняем результат
    imagepng($rotate, $path);
    // очищаем память
    imagedestroy($rotate);
    // возвращаем путь к новой картинке
    return $path;
}
?>