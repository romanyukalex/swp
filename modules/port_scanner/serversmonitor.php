<? 
/* ���������� �������� �� SSH
��� �������
�� WEB:    tcpdump -i eth1 udp port 162 -w /home/teligent/public_html/snmpdump8.cap -vv -s 0 - ������� �� ����� 162
�� prov: ���������� tcpdump -i eth1 udp port 162 -w /snmpdump54.cap -vv -s 0 � �� ������ ������ /sbin/service karaf-service stop/start */
//@require("/home/teligent/public_html/hostnames.php");
//@require("/home/teligent/public_html/SNMP.php");
//date_default_timezone_set('UTC');


if($_REQUEST['mode']=="debug"){
	require($_SERVER["DOCUMENT_ROOT"]."/hostnames.php");
	require($_SERVER["DOCUMENT_ROOT"]."/SNMP.php");
	}
else{
	@require("/home/teligent/public_html/hostnames.php");
	@require("/home/teligent/public_html/SNMP.php");
	//date_default_timezone_set('UTC');
	}

$snmptrapip="192.168.33.17";
$community = 'public';
if($_REQUEST['mode']=="debug"){$file = "hostnames.php";}
else{$file = "/home/teligent/public_html/hostnames.php";}

$fp1 = fopen($file,"w");//������� ����
fwrite($fp1,"<? "."\r\n");

foreach ($ipaddr as $key => $ip) {
echo "���� �".$key."  ";
# ��� ����� � IP, ������� ����� �������� � ����
$intofile = "$"."hostname[".$key."]=".'"'.$hostname[$key].'";'."\r\n"."$"."ipaddr[".$key."]=".'"'.$ip.'";'."\r\n";
# ������� ������
$fp = fsockopen($ip, '22', &$errno, &$errstr, 4 );
if (!$fp)
	{$newstatus="NOK";
	if($_REQUEST['mode']=="debug"){echo "$hostname[$key] $ip - NOK";}
	}
else{$newstatus="OK";
	fclose($fp);
	if($_REQUEST['mode']=="debug"){echo "$hostname[$key] $ip - OK";}
	}
if ($newstatus!==$status[$key])
	{// ������ ���������
	if($_REQUEST['mode']=="debug"){echo " - ������ ������ � ����� � ���������� ���� �� $snmptrapip";}
	$status[$key]=$newstatus;
	if($_REQUEST['mode']=="debug"){echo " - ������ ������ � ����� - $status[$key]<br>";}
	if ($newstatus=="NOK")
		{// ��������� ����
		$snmpmessage = "Host IP is down";
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.2", 'value'=>2);// 2 - ���� (raise)
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.1", 'value'=>2); // ����
		}
	else{// ��������� ��������
		$snmpmessage = "Host is up";
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.2", 'value'=>3);// 3 - ���������� (clear)
		$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.1", 'value'=>1); // ��������
		}
	// http://www.webnms.com/net-snmp/help/developing_management_applications/datatypes/textual_conventions/tcs_dateandtime.html   - ��� ���� � DateAndTime 
	//2002-9-3,12:20:32.3

	$dateAndTime=dec2hex(floor(date("Y")/256)); 
	$dateAndTime.=dec2hex(date("Y")%256);
	$dateAndTime.=dec2hex(date("m"));
	$dateAndTime.=dec2hex(date("d"));
	$dateAndTime.=dec2hex(date("H"));
	$dateAndTime.=dec2hex(date("i"));
	$dateAndTime.=dec2hex(date("s"));
	$dateAndTime.=dec2hex(date("u")/100);
	
	if($_REQUEST['mode']=="debug"){echo "���� � MIB - ".$dateAndTime;}
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.3", 'value'=>$dateAndTime, 'type'=>'x'); // ����
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.4", 'value'=>$snmpmessage); // �������
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1.5", 'value'=>5); // ��������. 5 - critical
	$vars[] = array('oid'=>"1.3.6.1.4.1.2994.37.4.1001.1.2", 'value'=>$hostname[$key]); // ����
	# ���������� ����
	SNMP::trap($snmptrapip, $vars, $community);
	# ������ � ���
	// ������������ ������ ��� ����
	$actdate=date("Y-m-d H:i");
	$str01 = "$actdate $hostname[$key]($ipaddr[$key]): status changed to $status[$key]\r\n";
	// ������� ���� � �������� � ���� ������
	if($_REQUEST['mode']=="debug"){$log = fopen("servers_monitor.log","a+");}
	else{$log = fopen("/home/teligent/public_html/servers_monitor.log","a+");}
	
	if(!$log){
		if($_REQUEST['mode']=="debug"){echo "servers_monitor.log n/a";}
		}
	else{fwrite($log, $str01);}
	fclose($log);
	# ������� ������ vars
	while ($vars){array_pop($vars);}
	}
else{
	if($_REQUEST['mode']=="debug"){echo " - �� ������ ������<br>";}
	}
$intofile.= "$"."status[".$key."]=".'"'.$status[$key].'";'."\r\n"."\r\n"; // �������� ������� ��������� ��� ������ � ����
fwrite($fp1,$intofile);// �������� � ���� �������
} // foreach

fwrite($fp1,"?> "."\r\n");
fclose($fp1); //��������� �������� � ������

function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
?>