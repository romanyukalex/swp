<? # ��������� ������� �� ��������
//@require($_SERVER["DOCUMENT_ROOT"]."/siteconfig.php");
@require($_SERVER["DOCUMENT_ROOT"]."/system-param.php");
@require($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$stop=2;
# ��������� IP ��������
@require($_SERVER["DOCUMENT_ROOT"]."/IPreal.php");
if ($ip!==$chronoip and $ip!=="10.241.18.55" and $ip!=="10.241.18.56" and $ip!=="10.241.18.17" and $ip!=="10.241.18.18"){$stop=1;}

if (!$_REQUEST['customer_id'] or !$_REQUEST['order_id'] or !$_REQUEST['transaction_id'] or !$_REQUEST['transaction_type'] or 
	!$_REQUEST['total']  or !$_REQUEST['sign']){$stop=1;}
if ($_REQUEST['product_id']!==$product_id){$stop=1;}
if (md5($sharedsec.$_REQUEST['customer_id'].$_REQUEST['transaction_id'].$_REQUEST['transaction_type'].$_REQUEST['total'])!==$_REQUEST['sign']){$stop=1;}
if($stop!==1)
	{?>Necessary parameters has accepted from REQUEST<br /><?
	# �������� ����� � ��
	$order_id=process_data($_REQUEST['order_id'],10);
	$phone=process_data($_REQUEST['phone'],15);
	$total=process_data($_REQUEST['total'],5);
	$transaction_type=process_data($_REQUEST['transaction_type'],10);
	$customer_id=process_data($_REQUEST['customer_id'],20);
	$sign=process_data($_REQUEST['sign'],32);
	$site_id=process_data($_REQUEST['site_id'],15);
	$date=$_REQUEST['date'];
	$time=$_REQUEST['time'];
	$transaction_id=process_data($_REQUEST['transaction_id'],15);
	$language=process_data($_REQUEST['language'],3);
	$name=process_data($_REQUEST['name'],100);
	$country=process_data($_REQUEST['country'],3);
	$state=process_data($_REQUEST['state'],2);
	$zip=process_data($_REQUEST['zip'],10);
	$city=process_data($_REQUEST['city'],40);
	$street=process_data($_REQUEST['street'],100);
	$email=process_data($_REQUEST['email'],100);
	$username=process_data($_REQUEST['username'],100);
	$password=process_data($_REQUEST['password'],100);
	$currency=process_data($_REQUEST['currency'],3);
	$payment_type=process_data($_REQUEST['payment_type'],10);
	$auth_code=process_data($_REQUEST['auth_code'],10);

	# ���� ������ � ��
	@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
	$query1=mysql_fetch_array(mysql_query("SELECT `id`,`phone`,`tariffid` FROM `chronopays` WHERE `id`='$order_id' limit 0,1;"));
	if (!$query1[id])
		{# �� ����� ������ � ��- ����� �����
		$lastorderid=mysql_fetch_array(mysql_query("select `id` FROM `chronopays` where 1 order by `id` desc limit 0,1;"));
		$lastorderid[id]++;
		$order_id="$lastorderid[id]";
		$query1=mysql_query("INSERT INTO `chronopays` 
		(`id`, `lastupdate`, `phone`, `total`,`status`,`transaction_type`,`customer_id`,`sign`,`site_id`,`date`,`time`,`transaction_id`,`language`,
		`name`,`country`,`state`,`zip`,`city`,`street`,`email`,`username`,`password`,`currency`,`payment_type`,`auth_code`
		) 
		VALUES ('$order_id', CURRENT_TIMESTAMP, '$phone', '$total', '7','$transaction_type','$customer_id','$sign','$site_id','$date','$time',
		'$transaction_id',
		'$language',
		'$name','$country','$state','$zip','$city','$street','$email','$username','$password','$currency','$payment_type','$auth_code'
		);");
		?>OrderID is not found, new row created<?
		# ���� ������ �������?
		}
	else{# ����� ������ � ��
		$query2=mysql_query("UPDATE `chronopays` SET 
		`status`='7',
		`lastupdate`=CURRENT_TIMESTAMP, 
		`transaction_type` = '$transaction_type',
		`customer_id` = '$customer_id',
		`sign` = '$sign',
		`site_id` = '$site_id',
		`date` = '$date',
		`time` = '$time',
		`transaction_id` = '$transaction_id',
		`language` = '$language',
		`name` = '$name',
		`country` = '$country',
		`state` = '$state',
		`zip` = '$zip',
		`city` = '$city',
		`street` = '$street',
		`email` = '$email',
		`username` = '$username',
		`password` = '$password',
		`currency` = '$currency',
		`payment_type` = '$payment_type',
		`auth_code` = '$auth_code'
		WHERE `id` ='$order_id';"); // ������ 7 - ��� ������ ������ ������� �� �������� ������
		?>OrderID is found, raw updated<br><?
		
		# ������ �� �������� ����� ��������
		$msisdn=$query1[phone];
		$newtariffId=$query1[tariffid];
		$paymentType="EXTN";//"EXTN" = external = ������ ����� ������� ������� (Chronopay)
		include($_SERVER["DOCUMENT_ROOT"]."/new_tariff_query.php");
		if (strstr($newtariffdata,"HTTP/1.1 200"))
			{//������� �������� ����� ����� ������ � ��
			mysql_query("UPDATE `chronopays` SET `status` = '2' WHERE `id` ='$order_id';");echo "Tariff created";		
			}
		elseif(strstr($newtariffdata,"HTTP/1.1 404")){mysql_query("UPDATE `chronopays` SET `status` = '3' WHERE `id` ='$order_id';");echo "There is no this tariffID";}//������ ���
		elseif(strstr($newtariffdata,"HTTP/1.1 400")){mysql_query("UPDATE `chronopays` SET `status` = '4' WHERE `id` ='$order_id';");echo"Tariff cannot be ordered";}//���������� �������� �����
		elseif(strstr($newtariffdata,"HTTP/1.1 402")){mysql_query("UPDATE `chronopays` SET `status` = '5' WHERE `id` ='$order_id';");echo"Subscriber has no money";}//������������ �������
		else{mysql_query("UPDATE `chronopays` SET `status` = '6' WHERE `id` ='$order_id';");echo"Unknown event";}// ����������� �������
		}
	}
?>