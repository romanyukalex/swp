<? # update статуса обоудовани€ (повесить в крон)
//require("/home/ovzorru/public_html/core/db/dbconn-read.php");
require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
$query17 = mysql_query("select `classroomid`,`forepostip`,`forepostport`,`equipstatus` FROM `ovzor-classroom`	WHERE 1 ;");
# ѕеребираем список камер
while($classdata = mysql_fetch_array($query17))
	{ 
	$fp = fsockopen($classdata[forepostip], $classdata[forepostport], &$errno, &$errstr, 4 );
	if (!$fp)
		{$newstatus="NOK";
		echo "$classdata[forepostip] - NOK<br>";
		}
	else{$newstatus="OK";
		fclose($fp);
		echo "$classdata[forepostip] - OK<br>";
		}
	if ($newstatus!==$classdata[equipstatus])
		{// update
		echo "update db<br>";
		mysql_query("UPDATE `ovzor-classroom` SET `equipstatus`='$newstatus' WHERE `classroomid`='$classdata[classroomid]' LIMIT 1");
		echo "query - UPDATE `ovzor-classroom` SET `equipstatus`='$newstatus' WHERE `classroomid`='$classdata[classroomid]' LIMIT 1<br>";
		}
	else echo "UN - update db<br>";
	}
# ѕолучаем список уникальных forepostip и провер€ем таким же способом их
	?>