<? 
/*
*
* ѕолучение ближайшего метро по координатам
*
* @param array - массив с координатами [долгота,  широта]
* @return bool | string - false или название ближайшего метро


$address = "ѕетровка улица, 38, ћосква"; // адрес
// получение координат адреса
$coord = getCoordNameByAddress_yandex($address);
// получение ближайшего метро по координатам
$metro = getMetroNameByCoord($coord);
// вывод результата
var_dump($metro);

*/
function getMetroByCoordinates($coord){
    $coord_str = implode(",", $coord);
    $url_get_metro = "https://geocode-maps.yandex.ru/1.x/?geocode={$coord_str}&kind=metro&format=json&results=1"; 
    $result = @file_get_contents($url_get_metro);
    // если произошла ошибка при отправке запроса или ответе сервера
    if(!$result) return false;
    $result = json_decode($result);
    // если ни чего не нашлось
    if(count($result->response->GeoObjectCollection->featureMember) == 0) return false;
    return $result->response->GeoObjectCollection->featureMember[0]->GeoObject->name;
}
?>