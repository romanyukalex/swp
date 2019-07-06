<?

// https://money.yandex.ru/myservices/online.xml - протестировать

$base_memory_usage = memory_get_usage(); # Определяем, сколько было скушано памяти в начале
$moduleflag=1;
@include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');

$comma_separated_req=null;
foreach ($_REQUEST as $Key => $Value) $comma_separated_req .= $Key . '=' . $Value.';';
$log->LogDebug('REQUEST parameters: '.$comma_separated_req);

// чтение параметров
$out_summ = $_REQUEST['amount'];
$operation_id = $_REQUEST['operation_id'];
$notification_type = $_REQUEST['notification_type'];
$datetime =  $_REQUEST['datetime'];
$sender = $_REQUEST['sender']; //Кошелек яндекса отправителя
$codepro =  $_REQUEST['codepro']; //Есть ли подтверждение платежа кодом!
$currency =  $_REQUEST['currency'];// Всегда 643 - рубль 
$withdraw_amount = $_REQUEST['withdraw_amount']; //Сумма, которая списана со счета отправителя.
$order_id=$label = $_REQUEST['label']; // Метка платежа. Если метки у платежа нет, параметр содержит пустую строку.
$lastname = $_REQUEST['lastname'];
$firstname = $_REQUEST['firstname'];
$fathersname = $_REQUEST['fathersname'];
$zip = $_REQUEST['zip'];
$city = $_REQUEST['city'];
$street = $_REQUEST['street'];
$building = $_REQUEST['building'];
$suite = $_REQUEST['suite'];
$flat = $_REQUEST['flat'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$unaccepted=$_REQUEST['unaccepted']; //Платеж еще не принят получателем!
$crc = $_REQUEST['sha1_hash'];

$IsTest_bool =$_REQUEST['test_notification'];
if($IsTest_bool=="true" or $IsTest_bool==TRUE) $IsTest=1; else $IsTest=0;

$my_crc = sha1("$notification_type&$operation_id&$out_summ&643&$datetime&$sender&$codepro&$yamon_notif_secret&$label");

// проверка корректности подписи
if ($my_crc !=$crc) {
  header("HTTP/1.0 400 Bad Request");
  echo "bad sign\n";
  $log->LogError('BAD SIGN. My CRC:'.$my_crc.' Received:'.$crc.'. So, its bad sign');
  exit();
} else $log->LogDebug("CRC is OK");

if($_POST['codepro']!='false'){ //Платёж не зачислен, требует код подтверждения. Устанавливаем статус error
	$pm_status='error';
	$log->LogError('We got YM with protection code. We cannot  automatically get this payment');
} else $pm_status='new'; // Нормальный статус
// запись в файл информации о проведенной операции
$payment_rec_q=mysql_query("INSERT INTO `$tableprefix-payments` (`payment_id`, `payment_agent`, `summ`, `currency`, `timestamp`, `order_id`, `user_id`,`details`,`IsTest`, `pm_status`) VALUES 
(NULL, 'YANDEX_MONEY', '".$out_summ."', 'RUR', CURRENT_TIMESTAMP, '".$order_id."', NULL,'PaymentMethod=".$notification_type.";IncSum=".$withdraw_amount.";IncCurrLabel=".$label."','".$IsTest."','".$pm_status."');");



echo "OK";// признак успешно проведенной операции для ЯД
?>