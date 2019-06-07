<?php
$agent=$_SERVER['HTTP_USER_AGENT'];
if (!$agent)
	{
	@require("/home/ovzorru/public_html/core/db/dbconn.php");
	# Выбираем всех у кого тип тарифа unlim
	$query=mysql_query("select `userid`,`tariffprice`,`means`,`tarifftype` from `ovzor-tariff`, `ovzor-account` where `tarifftype`='unlim' and `ovzor-account`.`tariffid`=`ovzor-tariff`.`tariffid` ;");
	while($maininfo=mysql_fetch_array($query))
		{# Списываем ежедневную плату
		$userid=$maininfo[userid];
		$paid=$maininfo[tariffprice]; // Будет списано со счёта ежедневная плата
		$means=$maininfo[means]-$paid;
		echo $userid."<br>";
		mysql_query("UPDATE `ovzor-account` SET `means` = '$means' WHERE `userid` ='$userid' LIMIT 1 ;"); // списали со счета
		mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
		 VALUES ('$userip','$userid', NULL , CURRENT_TIMESTAMP, 'Paid $paid');"); // Записали в лог списание денег
		}
	
	
	mysql_query("UPDATE `ovzor-log` SET `date` = CURRENT_TIMESTAMP , `ip` = '$browser' WHERE `ovzor-log`.`action` = 'payit-unlim' LIMIT 1 ;"); // Записали время работы
	} ?>