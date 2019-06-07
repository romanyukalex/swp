<?
$base_memory_usage = memory_get_usage(); # Определяем, сколько было скушано памяти в начале
$moduleflag=1;
@include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');

$comma_separated_req=null;
foreach ($_REQUEST as $Key => $Value) $comma_separated_req .= $Key . '=' . $Value.';';
$log->LogDebug('REQUEST parameters: '.$comma_separated_req);

//установка текущего времени
$tm=getdate(time()+9*3600);
$date="$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";

// чтение параметров
$out_summ = $_REQUEST['OutSum'];
$inv_id = $_REQUEST['InvId'];
//$shp_item = $_REQUEST["Shp_item"];
$crc = strtoupper($_REQUEST['SignatureValue']);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$rk_test_pass2"));

// проверка корректности подписи
if ($my_crc !=$crc) {
  echo "bad sign\n";
  $log->LogError($rk_test_pass2.'BAD SIGN. My CRC:'.$my_crc.' Received:'.$crc.'. So, its bad sign');
  exit();
}


// запись в файл информации о проведенной операции
$payment_rec_q=mysql_query("INSERT INTO `$tableprefix-payments` (`payment_id`, `payment_agent`, `summ`, `currency`, `timestamp`, `order_id`, `user_id`,`details`,`IsTest`) VALUES 
(NULL, 'ROBOKASSA', '".$out_summ."', 'RUB', CURRENT_TIMESTAMP, '".$inv_id."', NULL,'PaymentMethod=".$_REQUEST['PaymentMethod'].";IncSum=".$_REQUEST['IncSum'].";IncCurrLabel=".$_REQUEST['IncCurrLabel']."','".$_REQUEST['IsTest']."');");



echo "OK$inv_id\n";// признак успешно проведенной операции для Робокассы
$log->LogInfo('Good SIGN');

?>