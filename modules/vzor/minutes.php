<?php  session_start();
###############################################################################################
#������ ��� �������� ��������� �������� (��-����?) � ������ ��� ���������� �� ������� �������
###############################################################################################

# �������� �������� ���������.
$url = $_SERVER['REQUEST_URI'];
require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/vzor/IPreal.php");
$userip=$ip;
$prov=@mysql_query("SELECT `action`,`userid`,`classroomid`,`camera`,`date` FROM `ovzor-log` WHERE `ip`='$userip' ORDER BY `date` DESC LIMIT 0,1");
$lastaction=@mysql_fetch_array($prov);
if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress" or $lastaction[action]=="enter" or strstr("$lastaction[action]","Paid"))
	{# �������, ���� ��������� � ������� �����
	if ($lastaction[action]=="enter" or strstr("$lastaction[action]","Paid")){die();}
	$messagetolog="inprogress";
	$userid=$lastaction[userid];
	$webcam[1]=$lastaction[camera];
	if ($lastaction[action]=="inprogress")
		{mysql_query("UPDATE `ovzor-log` SET `date` =  NOW() WHERE `ip` = '$userip' AND `action` = 'inprogress' AND `date`='$lastaction[date]';");
		}
	else{ @mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`) 
		VALUES ('$userip', '$userid', '$webcam[1]', CURRENT_TIMESTAMP, '$messagetolog');");
		} // �������� �������� � ���
	# ������ ������
	$cryteria = explode("%", $url);
	$cameraname=$cryteria[1];
	# �������� ip c�����������
	$camerainfo=mysql_fetch_array(mysql_query("SELECT `forepostip` FROM `ovzor-classroom` WHERE `cameraname` = '$cameraname'"));
	$forepostip=$camerainfo[forepostip];
	# ������������� ����
	$day="$cryteria[2]";
	# ��������� �����
	$fp = fsockopen($forepostip, 8082, $errno, $errstr, 30);
	if($fp) 
		{# ��������� ������ � �������� �����
		$request = "GET /registrator/$cameraname/$day HTTP/1.1\r\n";
		$request .= "Host: $forepostip\r\n";
		$request .= "Connection: Close\r\n\r\n";
		# ���������� request � �����
		fwrite($fp, $request);
		#������� 3 ������ ��������� http ������ (200 ��)
		fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);
		# ������ ���� JSON � �����
		while(!feof($fp)) echo fgets($fp, 1024);
		# ��������� ��
		fclose($fp);
		}
	else echo "Error: ".$errstr." (#".$errno.")";
	die();
	}
elseif($lastaction[action]=="badpost")
	{// �� ������ badpost, ��� ������, ���������� ���� ������
	$subject="���� �� �����";
	$from="������������� �����";
	$header="Content-type: text/html;  charset=utf-8\n";
	$header.="From: ".$from." www.ovzor.ru <ovzor@ovzor.ru>\n";
	$header.="Subject: ".$subject."\n";
	$header.="Content-type: text/html; charset=cp1251";
	$messagetoadmin="IP: ".$userip." ������ �� iah.php (������ �������� ������� �����)";
	@ mail("support@ovzor.ru", $subject, $messagetoadmin, $header);
	$messagetolog="spam_mailed";
	$userid="0";
	$webcam[1]="0";
	}
elseif($lastaction[action]=="spam_mailed")
	{die();
	}
else{// �� ������� - ��� ip � �������� log � �������� ���������
	echo "ne valid";
	$messagetolog="badpost";
	$userid="0";
	$webcam[1]="0";
	// ���� badpost ����� - �������� ��� ������
	$secondprov=@mysql_query("SELECT count(`action`) as spamcheck FROM `ovzor-log` WHERE `action`='badpost' and `date` < NOW() -  INTERVAL '5' MINUTE");
	$spamstat=@mysql_fetch_assoc($secondprov);
	if ($spamstat[spamcheck]>50)
		{// ��� ������
		$subject="���� �� �����";
		$from="������������� �����";
		$header="Content-type: text/html;  charset=utf-8\n";
		$header.="From: ".$from." www.ovzor.ru <ovzor@ovzor.ru>\n";
		$header.="Subject: ".$subject."\n";
		$header.="Content-type: text/html; charset=cp1251";
		$messagetoadmin="������� ���������� ����-��������� (��������, IP=".$userip.") �� ������ �������� ������� �����";
		@ mail("support@ovzor.ru", $subject, $messagetoadmin, $header);
		$messagetolog="spam_mailed";
		};
	}
@mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`) 
	VALUES ('$userip', '$userid', '$webcam[1]', CURRENT_TIMESTAMP, '$messagetolog');"); // �������� �������� � ���
?>