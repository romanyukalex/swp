<?
/*
1 Доступность услуги (в целом)
	
Сервис считается недоступным, если недоступен весь путь до ServiceNow из интернета. Проверять договорились так: мы запрашиваем доступность SN с использованием внешнего IP. Таким образом траффик пойдет через сетевые элементы, через балансировщик на ноды и БД SN
	
Полная недоступность может случиться по следующим причинам:
	- недоступны сетевые элементы ASR+ASA (будем проверять доступностью 8.8.8.8 из нашей сети)
	- недоступен балансировщик (будем проверять по доступности 172.31.254.24:80)
	- недоступен DNS (будем проверять, пингуя 10 хостов в интернете, по 1 хосту раз в минуту, чтобы исключить использование локального кеша DNS и гарантировать обращение к нашему DNS при каждой проверке)
	- недоступны ноды SN (будем проверять доступностью IP+порт каждой ноды) 
	- недоступна БД SN  (будем проверять доступностью IP+порт каждой ноды) 
	

2 Время генерации и доставки страницы

Время генерации страницы на сервере (мс) 
Время генерации страницы на клиенте (мс) 
Время доставки страницы по сети (мс) 

Стучим на
https://rusagro.ts-cloud.ru/rusagro/clean%20login.do
Логинимся
test_cloud
a123456!
Вынимаем усредненное для пользователя test_cloud
https://rusagro.ts-cloud.ru/api/now/stats/syslog_transaction?sysparm_limit=10&sysparm_query=client_transaction=true^sys_created_onBETWEENjavascript:gs.dateGenerate(%272015-10-14%27,%2700:00:00%27)@javascript:gs.dateGenerate(%272015-11-19%27,%2723:59:59%27)^sys_created_by=test_cloud&sysparm_avg_fields=client_response_time,client_network_time,browser_time

Под ним же
test_cloud
a123456!
Если данных за конкретный день по нашему пользователю нет, то вытаскиваем для всех
https://rusagro.ts-cloud.ru/api/now/stats/syslog_transaction?sysparm_limit=10&sysparm_query=client_transaction=true^sys_created_onBETWEENjavascript:gs.dateGenerate(%272015-10-14%27,%2700:00:00%27)@javascript:gs.dateGenerate(%272015-11-19%27,%2723:59:59%27)&sysparm_avg_fields=client_response_time,client_network_time,browser_time




Балансировщик:
IP: 95.163.143.19 (172.31.254.24)

Сервер БД:
IP:172.31.254.37 

Сервер APP:
IP:172.31.254.36 

Что касается мониторинга самих нод,  то их  сейчас  семь, но через некоторое время может стать совершенно другое количество.  Их локация и IP адреса могут меняться. Самое простое, это парсить   вывод статистики балансировщика, а именно список Backend, там указано, какие ноды сейчас работают и по каких портам.

Посмотреть как выглядит статистика балансировщика можно тут https://rusagro.ts-cloud.ru/SdfrFDx67Derfss [rusagro:Ru$@gR0] 

*/

$nitka=1;
echo "Start monitor\n";
$breakthisfile = Explode('/', $_SERVER["SCRIPT_NAME"]);
unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
$this_path=implode('/', $breakthisfile); 
if($breakthisfile[count($breakthisfile)-2]!=="project")unset ($breakthisfile[count($breakthisfile)-1]); //Мы все еще в глубине файловой системы, удаляем папку 
unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем 
unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем 
$_SERVER["DOCUMENT_ROOT"]=implode('/', $breakthisfile); // Домашняя директория всего сайта
require($_SERVER["DOCUMENT_ROOT"]."/core/start_platform_scripts_cron.php");

$SLA_mon_conf_q=mysql_query("SELECT * FROM `$tableprefix-SN_SLA_conf` WHERE `status`='active'");

function getContent($url){
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   $content = curl_exec($ch);
   curl_close($ch);
}
//echo date("Y-m-d");
while($SLA_mon_conf=mysql_fetch_array($SLA_mon_conf_q)){
	$uri1=str_replace("STARTDATE", date("Y-m-d"), $SLA_mon_conf['uri1']);
	/*echo $uri1;
	if( $curl = curl_init() ) {
		curl_setopt($curl, CURLOPT_URL, $uri1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		//$headr = array();
	//$headr[] = 'Content-length: 0';
	//$headr[] = 'Content-type: application/json';
	//$headr[] = 'Authorization: OAuth '.$accesstoken;

	//curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
	//curl_setopt($crl, CURLOPT_POST,true);
		$out = curl_exec($curl);
		echo $out;
		curl_close($curl);
	  }
	//$content = getContent($SLA_mon_conf['uri1']);
		*/
		//$data = file_get_contents($uri1);
		//echo $data;
	$basicauth=explode("/",$SLA_mon_conf['uri1bauth']);

	$opts = array(
	'http'=>array(
	'method'=>"GET",
	'header'=>"Accept-language: en\r\n" .
			  'Authorization: Basic '.base64_encode($basicauth[0].':'.$basicauth[1])."\r\n"
	  )
	);

	$context = stream_context_create($opts);

// Открываем файл с помощью установленных выше HTTP-заголовков
	if (!$file = file_get_contents($uri1, false, $context)){
		$uri2=str_replace("STARTDATE", date("Y-m-d"), $SLA_mon_conf['uri2']);
		$basicauth=explode("/",$SLA_mon_conf['uri2bauth']);
		$opts = array(
			'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" .
					  'Authorization: Basic '.base64_encode($basicauth[0].':'.$basicauth[1])."\r\n"
			)
		);
		$file = file_get_contents($uri2, false, $context);
	}
	//echo $file;
	$data_j=json_decode($file, true);
	//var_dump($data_j);
	$browser_time= $data_j['result']['stats']["avg"]['browser_time'];
	$client_network_time= $data_j['result']['stats']["avg"]['client_network_time'];
	$client_response_time= $data_j['result']['stats']["avg"]['client_response_time'];
	
	mysql_query("INSERT INTO  `$tableprefix-SN_SLA` (`id` ,`company_id` ,`date` ,`browser_time` ,`client_network_time` ,`client_response_time`)
VALUES (NULL ,  '".$SLA_mon_conf['company_id']."',  '".date("Y-m-d")."',  '$browser_time',  '$client_network_time',  '$client_response_time');");

}

?>