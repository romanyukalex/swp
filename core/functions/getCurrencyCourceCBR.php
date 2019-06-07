<? // Функция вывода курса валют от ЦБ РФ

function GetCourceCBR($type='R01235') {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	//R01235 - доллар; R01239 -евро
	//измени на тот код валюты, курс которой необходим
	//Начальная дата для запроса (сегодня - 2 дня)
	$date_req1=date('d/m/Y', time()-172800);
	//Конечная дата (чтобы учитывать завтра добавьте параметр time()+86400)
	$date_req2=date('d/m/Y');
	//Получаем страницу
	$doc = file_get_contents('http://www.cbr.ru/scripts/XML_dynamic.asp?VAL_NM_RQ='.$type.'&date_req1='.$date_req1.'&date_req2='.$date_req2);
	if(!$doc) return'No data';
	// Ищем все вхождения<Record>...</Record>
	preg_match_all('/<Record (.*?)>(.*?)<\/Record>/is', $doc, $r, PREG_SET_ORDER);
	// Получаем курс на сегодня
	preg_match('/<Value>(.*?)<\/Value>/is', $r['0']['0'],$value);
	return $value['1'];
}

//echo GetCourceCBR();
# Еще одна реализация, другой URI ЦБ
function getCurs($moneyCode){
    // создаем объект для работы с XML
    $xml = new DOMDocument();
    // ссылка на сайт банка
    $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');
    // получаем xml с курсами всех валют
    if ($xml->load($url)){
        // массив для хранения курсов валют
        $result = array(); 
        // разбираем xml
        $root = $xml->documentElement;
        // берем все теги 'Valute' и их содержимое
        $items = $root->getElementsByTagName('Valute');
        // переберем теги 'Valute' по одному
        foreach ($items as $item){
            // получаем код валюты
            $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
            // получаем значение курса валюты, относительно рубля
            $value = $item->getElementsByTagName('Value')->item(0)->nodeValue;
            // записываем в массив, предварительно заменив запятую на точку
            $result[$code] = str_replace(',', '.', $value);
        }
        // возвращаем значение курса, для запрошенной валюты
        return $result[$moneyCode];
    }else{
        // если не получили xml возвращаем false
        return false;
    }
}
// пример использования
//echo getCurs('USD').'<br/>';
//echo getCurs('EUR');
?>