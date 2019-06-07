<?php
/*
// проверка фоток на то, что они сделаны с мобильного устройства
// проверяем ориентацию фотки и если нужно вернем градус, на который нужно повернуть фото

простой пример использования:

$size = getSizePhotoMobile($source);//узнаем размеры исходной картинки
// если это фото сделано с мобильного телефона
if($size['degree'] > 0){
    $photo = rotatePhotoMobile($source, $size['degree']);
}else{
    // код для обычных фоток
}
*/



function getSizePhotoMobile($file_name){
        // получаем EXIF-заголовки
    $exif_read_data = @exif_read_data($file_name);
    $size = @getimagesize($file_name);
    $width = $size[0];
    $height = $size[1];
    $degree = 0;
        // если заголовки получили, и среди них нашлось упоминание об ориентации
    if($exif_read_data){
        if(isset($exif_read_data["Orientation"]) AND $exif_read_data["Orientation"] > 4){                    
            $size = getimagesize($file_name, $info);
            $width = $size[1];
            $height = $size[0];     
            switch ($exif_read_data["Orientation"]){
                case 5:
                    $degree = 270;
                    break;
                case 6:
                    $degree = 270;
                    break;
                case 7:
                    $degree = 90;
                    break;
                case 8:
                    $degree = 90;
                    break;                      
            }
        }
    }
    return array(
        0 => $width,
        1 => $height,
        'degree' => $degree
    );
}

function rotatePhotoMobile($img, $degree){
    // получаем данные о картинке
    $size = getimagesize($img);
    //определяем тип (расширение) картинки
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;   //определение функции для расширения файла
    //если нет такой функции, то прекращаем работу скрипта
    if (!function_exists($icfunc)) return false;        
    // Загрузка изображения
    $source = $icfunc($img);
    // Поворот. Пустые углы заливаем цветом 0xffffff
    $rotate = imagerotate($source, $degree, '0xd72630');
    return $rotate;
}
?>