<?php
$agent=$_SERVER['HTTP_USER_AGENT'];
if (!$agent)
	{
	@require("/home/ovzorru/public_html/core/db/dbconn.php");
	# �������� ���� � ���� ��� ������ unlim
	$query=mysql_query("select `userid`,`tariffprice`,`means`,`tarifftype` from `ovzor-tariff`, `ovzor-account` where `tarifftype`='unlim' and `ovzor-account`.`tariffid`=`ovzor-tariff`.`tariffid` ;");
	while($maininfo=mysql_fetch_array($query))
		{# ��������� ���������� �����
		$userid=$maininfo[userid];
		$paid=$maininfo[tariffprice]; // ����� ������� �� ����� ���������� �����
		$means=$maininfo[means]-$paid;
		echo $userid."<br>";
		mysql_query("UPDATE `ovzor-account` SET `means` = '$means' WHERE `userid` ='$userid' LIMIT 1 ;"); // ������� �� �����
		mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
		 VALUES ('$userip','$userid', NULL , CURRENT_TIMESTAMP, 'Paid $paid');"); // �������� � ��� �������� �����
		}
	
	
	mysql_query("UPDATE `ovzor-log` SET `date` = CURRENT_TIMESTAMP , `ip` = '$browser' WHERE `ovzor-log`.`action` = 'payit-unlim' LIMIT 1 ;"); // �������� ����� ������
	} ?>