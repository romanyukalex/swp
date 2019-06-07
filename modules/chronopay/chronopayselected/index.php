<? session_start();
Header("Cache-Control: no-cache, must-revalidate"); Header("Pragma: no-cache");
@require($_SERVER["DOCUMENT_ROOT"]."/userlogin6.php");
if ($userrole!=="guest")
	{
	require($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
	$stop=2;
	if ($_REQUEST['order_id'])
		{$order_id=process_data($_REQUEST['order_id'],10);
		}
	elseif($_SESSION['order_id']){ $order_id=$_SESSION['order_id'];}
	else {echo "session error";$stop=1;}
	if (!preg_match('/^([0-9])+$/',$order_id)){$stop=1;}
	$login=$_SESSION['login'];
	$product_price=process_data($_REQUEST['product_price'],5);
	$newtariffId=process_data($_REQUEST['tid'],25);
	$tariffname=process_data($_REQUEST['tariffname'],20);
	# Проверяем что $product_price и $newtariffId - это целые числа
	if (!preg_match('/^([0-9])+$/',$product_price)){$stop=1;}
	if($stop!==1)
		{
		@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
		# Апдейт заказа в БД
		$query1=mysql_query("UPDATE `chronopays` SET `status` = '1',`lastupdate`=CURRENT_TIMESTAMP,`phone`='$login', `total`='$product_price', 
		`tariffid`='$newtariffId', `tariffname`='$tariffname' WHERE `id` ='$order_id';");
		}
	}