<? $starttime=mysql_fetch_array(mysql_query("SELECT UNIX_TIMESTAMP(`date`) as date FROM `ovzor-log` WHERE 
`userid`='$userid' and `action`='startshow' ORDER BY `date` DESC LIMIT 0,1"));
$stoptime=mysql_fetch_array(mysql_query("SELECT UNIX_TIMESTAMP(`date`) as date FROM `ovzor-log` WHERE 
`userid`='$userid' and `action`='stopshow' ORDER BY `date` DESC LIMIT 0,1"));
$sessiontime=$stoptime[date]-$starttime[date];
if ($var[0]==1)
	{$sessionmin=ceil($sessiontime/60);
	}
elseif ($var[0]==2)
	{$sessionmin=round($sessiontime/60);
	}
elseif ($var[0]==3)
	{$sessionmin=floor($sessiontime/60);
	}
else{// Тоесть если не определили в каку сторону округлять, то в меньшую. Это для случая в disconnectchecker когда абон отключился крестиком
	$sessionmin=floor($sessiontime/60);
	}
$query=mysql_query("select `tariffprice`,`means`,`tarifftype` from `ovzor-tariff`, `ovzor-account` 
where `ovzor-account`.`userid`='$userid' and `ovzor-account`.`tariffid`=`ovzor-tariff`.`tariffid`;");
$maininfo=mysql_fetch_array($query);
//echo maininfo[tarifftype];
if($maininfo[tarifftype]=="time")
	{
	# Тариф повременной
	$paid=$sessionmin*$maininfo[tariffprice]; // Будет списано со счёта
	$means=$maininfo[means]-$paid;
	mysql_query("UPDATE `ovzor-account` SET `means` = '$means' WHERE `userid` ='$userid' LIMIT 1 ;"); // списали со счета
	}
elseif($maininfo[tarifftype]=="unlim")
	{// Ничего списывать не надо
	$paid="0";
	}
mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
	VALUES ('$userip','$userid', NULL , CURRENT_TIMESTAMP, 'Paid $paid');"); // Записали в лог списание денег
// Удаляем inprogress-ы
//получим последний inprogress
/*$lastinprogress=mysql_fetch_array(mysql_query("SELECT `date` FROM `ovzor-log` WHERE 
`userid`='$userid' and `ip`='$userip' and `action`='inprogress' ORDER BY `date` DESC LIMIT 0,1"));
// Удаляем все inprogress этого юзера
mysql_query("DELETE FROM `ovzor-log` WHERE `userid`='$userid' and `ip`='$userip' and `action`='inprogress'");
// Всовываем последний inprogress обратно
mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
VALUES ('$userip','$userid', NULL , '$lastinprogress[date]', 'inprogress');"); // Записали в лог списание денег
*/		
?>