<? # ������� ��������� ����� � ���������� ������ ���������� ������ � �������
function getCoordinatesByAddress_google($address){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    if (!is_string($address))die("All Addresses must be passed as a string");
    $_url = sprintf('http://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
    $_result = false;
    if($_result = file_get_contents($_url)) {
        if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
        preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
        $_coords['lat'] = $_match[1];
        $_coords['long'] = $_match[2];
    }
    return $_coords;
}

function getCoordinatesByAddress_yandex($address){
    // �������� ������ �������� ����� �������
    $address = preg_replace("/ {2,}/", " ", $address);
    // ������ �������� �� �����
    $address = str_replace(" ", "+", $address);
    // ����������� ��� ��� �������
    $url_get_coord = "https://geocode-maps.yandex.ru/1.x/?geocode={$address}&format=json&results=1";
    $result = @file_get_contents($url_get_coord);
    // ���� ��������� ������ ��� �������� ������� ��� ������ �������
    if(!$result) return false;
    $result = json_decode($result);
    // ���� �� ���� �� �������
    if(count($result->response->GeoObjectCollection->featureMember) == 0) return false;
    // ��������� ��������� �����
    $coord = $result->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
    return explode(" ", $coord);
}

?>