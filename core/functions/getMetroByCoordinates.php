<? 
/*
*
* ��������� ���������� ����� �� �����������
*
* @param array - ������ � ������������ [�������,  ������]
* @return bool | string - false ��� �������� ���������� �����


$address = "�������� �����, 38, ������"; // �����
// ��������� ��������� ������
$coord = getCoordNameByAddress_yandex($address);
// ��������� ���������� ����� �� �����������
$metro = getMetroNameByCoord($coord);
// ����� ����������
var_dump($metro);

*/
function getMetroByCoordinates($coord){
    $coord_str = implode(",", $coord);
    $url_get_metro = "https://geocode-maps.yandex.ru/1.x/?geocode={$coord_str}&kind=metro&format=json&results=1"; 
    $result = @file_get_contents($url_get_metro);
    // ���� ��������� ������ ��� �������� ������� ��� ������ �������
    if(!$result) return false;
    $result = json_decode($result);
    // ���� �� ���� �� �������
    if(count($result->response->GeoObjectCollection->featureMember) == 0) return false;
    return $result->response->GeoObjectCollection->featureMember[0]->GeoObject->name;
}
?>