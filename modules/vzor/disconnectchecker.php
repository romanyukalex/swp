<?php
$agent=$_SERVER['HTTP_USER_AGENT'];
if (!$agent)
	{
	@require("/home/ovzorru/public_html/core/db/dbconn.php");
	$prov1=mysql_query("SELECT max(`date`) as data,`ip`,`userid` FROM `ovzor-log` where unix_timestamp(`date`) BETWEEN (unix_timestamp(now()) - 120) 
	AND (unix_timestamp(now())-60) group by `ip` order by `date` DESC  "); // Список всех последних дат и IP за прошлую минуту
	while ($provdata1=mysql_fetch_array($prov1))
		{
		$prov3=mysql_query("SELECT `action` FROM `ovzor-log` WHERE `date`='$provdata1[data]' and `ip`='$provdata1[ip]' and `userid`='$provdata1[userid]' LIMIT 1;"); 
		// получили последнее действие этого человека за прошлую минуту
		$lastactions1=mysql_fetch_array($prov3);
			
			if ($lastactions1[action]=="startshow" or $lastactions1[action]=="startshowcam" or $lastactions1[action]=="inprogress")
				{ // То последнее что делал этот человек в прошлую минуту - смотрел камеры
				$n=1;// Флаг, что, возможно, надо списать бабки
				//echo " надо проверить эту надпись ".$lastactions1[action]." ip ".$provdata1[ip]." дата ".$provdata1[data];
				$prov4=mysql_query("SELECT `action` FROM `ovzor-log` WHERE `ip`='$provdata1[ip]' and `userid`='$provdata1[userid]' and 
				unix_timestamp(`date`) BETWEEN (unix_timestamp(now()) - 59) AND unix_timestamp(now()) 
				group by `ip` order by `date` DESC  "); // Список всех дат для этого IP за эту минуту
				while ($lastactions2=mysql_fetch_array($prov4))
					{if ($lastactions2[action]=="startshowcam" or $lastactions2[action]=="inprogress" or $lastactions2[action]=="stopshow")
						{// Все в порядке.Бабки списывать не надо
						$n=2;
						//echo "<br>Бабки списывать не надо, есть продолжение сессии в этой минуте";
						}
					}				
				}
//			else echo "Не надо проверять действие ".$lastactions1[action]." ip ".$provdata1[ip]." дата ".$provdata1[data];
			
		if ($n==1)
				{// Надо записать останов сессии 
				//echo "<br>Надо записать останов сессии ";
				$userid=$provdata1[userid];
				$userip=$provdata1[ip];
				mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`, `date`, `action`)
				VALUES ('$userip', '$userid', NULL , CURRENT_TIMESTAMP- INTERVAL 1 second, 'stopshow');");
					//и сосчитать
				@require("/home/ovzorru/public_html/vzor/payit.php");
				}
		}
mysql_query("UPDATE `ovzor-log` SET `date` = CURRENT_TIMESTAMP , `ip` = '$browser' WHERE `ovzor-log`.`action` = 'discocheck' LIMIT 1 ;"); // Записали время работы (для контроля)
	} ?>