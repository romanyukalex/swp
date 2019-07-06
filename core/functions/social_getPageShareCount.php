<? /**
* ѕолучение количество репостов страницы в соцсет€х
*
* @param string $url_share - url страницы
* @param string $social vk|fb|ok - соц.сеть
*
* @return int - количество репостов
*/
function social_getPageShareCount($url_share, $social){
    $result = 0;
    switch($social){
        case "vk":
            $result = file_get_contents("https://vk.com/share.php?act=count&index=1&url=" . $url_share);
            $result = str_replace("VK.Share.count(1, ", "", $result);
            $result = (int)str_replace(");", "", $result);
            break;
             
        case "fb":
            $result = file_get_contents("http://graph.facebook.com/" . $url_share);
            $result = json_decode($result);
            $result = (int)$result->share->share_count;
            break;
         
        case "ok":
            $result = file_get_contents("https://connect.ok.ru/dk?st.cmd=extLike&tp=json&ref=" . $url_share);
            $result = json_decode($result);
            $result = (int)$result->count;
            break;
             
        default:
            $result = 0;
            break;
         
    }
    return $result;
}
/*
// пример использовани€
// страница, дл€ которой будут подсчитаны репосты
$url_share = urlencode("http://vk-book.ru/otpravka-pisem-cherez-smtp-s-avtorizaciej-po-protokolu-ssl-na-php/");
// в какой соц.сети считать репосты
$social = "vk";
//$social = "fb";
//$social = "ok";
 
// получение количество репостов
$count_share = social_getPageShareCount($url_share, $social);
// вывод результата
var_dump($count_share);
*/
?>