<?php 
###############################################################################################
#������ ��� �������� ��������� �������� (��-����?) � ������ ��� ���������� �� ������� �������
###############################################################################################

# �������� �������� ���������.
$url = $_SERVER['REQUEST_URI'];
$userip=$_SERVER['REMOTE_ADDR'];
@require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	# ������ ������
	$cryteria = explode("%", $url);
	$cameraname=$cryteria[1];
	# �������� ip c�����������
	$camerainfo=mysql_fetch_array(mysql_query("SELECT `forepostip` FROM `ovzor-classroom` WHERE `cameraname` = '$cameraname'"));
	$forepostip=$camerainfo[forepostip];
//	echo $forepostip;
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

?>