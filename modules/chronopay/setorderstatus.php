<? 
@include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$order_id=process_data($_REQUEST['order_id'],10);
$status=process_data($_REQUEST['status'],10);
@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
mysql_query("UPDATE `chronopays` SET `status` = '$status' WHERE `id` ='$order_id';");
?>
