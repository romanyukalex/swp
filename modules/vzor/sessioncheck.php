<? @require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");

$prov=mysql_query("SELECT `action`,`userid`,`classroomid` FROM `ovzor-log` WHERE putdate < NOW() -  INTERVAL '2' MINUTE ORDER BY `date` DESC ");
$lastaction=mysql_fetch_array($prov);
if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress")
	{// �������
	$messagetolog="inprogress";
	$userid=$lastaction[userid];
	$webcam[1]=$lastaction[classroomid];

	}
else{// �� �������
	die ();
	}
mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`) 
			VALUES ('$userip', '$userid', '$webcam[1]', CURRENT_TIMESTAMP, '$messagetolog');"); // �������� �������� � ���
 //��������� ���� �� ������ ������
  //���� ���� �������� ������ - ip, �����,
  //���� ���- �������� ������
  //���� ��������� ������ - �� ��� ������ ��������� ��� ���� ������ � ������ ��� ��������� ���� ������
  //���� ��������� - ��������� ���� ������, �� ������ �� ������

   ?>