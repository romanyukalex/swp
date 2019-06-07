<? // ������� ������ ����� ����� �� �� ��

function GetCourceCBR($type='R01235') {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	//R01235 - ������; R01239 -����
	//������ �� ��� ��� ������, ���� ������� ���������
	//��������� ���� ��� ������� (������� - 2 ���)
	$date_req1=date('d/m/Y', time()-172800);
	//�������� ���� (����� ��������� ������ �������� �������� time()+86400)
	$date_req2=date('d/m/Y');
	//�������� ��������
	$doc = file_get_contents('http://www.cbr.ru/scripts/XML_dynamic.asp?VAL_NM_RQ='.$type.'&date_req1='.$date_req1.'&date_req2='.$date_req2);
	if(!$doc) return'No data';
	// ���� ��� ���������<Record>...</Record>
	preg_match_all('/<Record (.*?)>(.*?)<\/Record>/is', $doc, $r, PREG_SET_ORDER);
	// �������� ���� �� �������
	preg_match('/<Value>(.*?)<\/Value>/is', $r['0']['0'],$value);
	return $value['1'];
}

//echo GetCourceCBR();
# ��� ���� ����������, ������ URI ��
function getCurs($moneyCode){
    // ������� ������ ��� ������ � XML
    $xml = new DOMDocument();
    // ������ �� ���� �����
    $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');
    // �������� xml � ������� ���� �����
    if ($xml->load($url)){
        // ������ ��� �������� ������ �����
        $result = array(); 
        // ��������� xml
        $root = $xml->documentElement;
        // ����� ��� ���� 'Valute' � �� ����������
        $items = $root->getElementsByTagName('Valute');
        // ��������� ���� 'Valute' �� ������
        foreach ($items as $item){
            // �������� ��� ������
            $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
            // �������� �������� ����� ������, ������������ �����
            $value = $item->getElementsByTagName('Value')->item(0)->nodeValue;
            // ���������� � ������, �������������� ������� ������� �� �����
            $result[$code] = str_replace(',', '.', $value);
        }
        // ���������� �������� �����, ��� ����������� ������
        return $result[$moneyCode];
    }else{
        // ���� �� �������� xml ���������� false
        return false;
    }
}
// ������ �������������
//echo getCurs('USD').'<br/>';
//echo getCurs('EUR');
?>