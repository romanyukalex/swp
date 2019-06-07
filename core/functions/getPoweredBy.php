<? # Как определить версию php без доступа к сайту
function getPoweredBy($url){
    $tmp = parse_url($url);
    $stream = @fopen($url, 'rb'); // открываем сайт
    if(!$stream){
        return "Сайт не отвечает!";
    }
    $array = stream_get_meta_data($stream); // получаем заголовки
    $info = false;
    // находим информацию о X-Powered-By
    foreach($array["wrapper_data"] as $k=>$v){
        if(strpos($v, 'X-Powered-By:') !== false){
            $info = explode('X-Powered-By:', $v);
        }
    }
    // вернем результат
    if($info){
        $powered_by = trim($info[1]);
        return $powered_by;
    }else{
        return "Не известно!";
    }
}

/* пример использования
$url = 'http://vk-book.ru';
$result = getPoweredBy($url);
print_r ($result);
*/
?>