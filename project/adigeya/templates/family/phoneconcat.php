<?
if ($nitka=="1"){
	//echo "Обработка телефона";
	$reqvalue=$_REQUEST['4'].$_REQUEST['7'].$_REQUEST['8'];
	//echo "Tel=".$formdata['field_table'];
	$insertdata[$formdata['field_table']][]= array ( $formdata['field_name'] => $reqvalue);
}?>