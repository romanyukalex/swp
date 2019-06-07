<?php
/*
* функция для создания скрина
* @var $url string - адрес сайта
* @var $screen string - размер экрана, может принимать только ширину. И может принимать ширину и высоту - 1024x768
* @var $size integer - ширина масштабированной картинки
* @var $format string - может принимать два значения (JPEG|PNG), по умолчанию "JPEG"


// пример использования 1. Скрин всей страницы, шириной 1024
getScreenShot("http://vk-book.ru", "1024", "1024", "jpeg");
 
// пример использования 2. Скрин размером 1024x768
getScreenShot("http://vk-book.ru", "1024x768", "1024", "jpeg");
*/
function getScreenShot($url, $screen, $size, $format = "jpeg"){
    $result = "http://mini.s-shot.ru/".$screen."/".$size."/".$format."/?".$url; // делаем запрос к сайту, который делает скрины
    $pic = file_get_contents($result); // получаем данные. Ответ от сайта
    file_put_contents("screen.".$format, $pic); // сохраняем полученную картинку
}?>
