<?php
// Только для HTTP

// Отправка POST запроса с получением печенек:
function get_http_cookie($URL='', $PostData=Array())
{
    // Отсекаем пустые вызовы:
    if (strlen($URL)<=0) return false;
    // Скопировал строку из FireBug:
    $ua = 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 MRA 5.7 (build 03796) Firefox/3.6.13';
    // Инициализация объекта:
    $ch = curl_init($URL);
    // показывать заголовки (в них куки):
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    // не показывать тело страницы (для экономии траффика):
    curl_setopt($ch, CURLOPT_NOBODY, 1); 
    // это чтобы прикинуться браузером:
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    // можно ставить еще вот это, если удаленный сервер проверяет:
     curl_setopt($ch, CURLOPT_REFERER, $URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    // включение полей POST в запрос:
    curl_setopt($ch, CURLOPT_POSTFIELDS, $PostData);
    // если нужны печеньки, установим:
  //  curl_setopt($ch, CURLOPT_POST, true);
//	curl_setopt($ch, CURLOPT_COOKIESESSION,TRUE);
    // тормозим стандартный вывод:
    ob_start();
    // запускаем запрос:
        curl_exec ($ch);
        curl_close ($ch);
        // получаем заголовки в массив:
        $headers = explode("\n", ob_get_contents());
    ob_end_clean();
    // выдираем строку печенек:
    for ($i=0, $cnt=count($headers); $i<$cnt; $i++) 
        if (strpos($headers[$i], 'Set-Cookie:') !== FALSE)
            $cookie .= substr($headers[$i], strpos($headers[$i], 'Set-Cookie:')+strlen('Set-Cookie:')); 
    // и возвращаем результат:
    return $cookie;
}
/*
$sitecookie = get_http_cookie($url);
echo $sitecookie."<br>";*/
?>
