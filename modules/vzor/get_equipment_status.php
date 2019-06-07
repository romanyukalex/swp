<table class='classtable'>
<? @require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
$query19=mysql_query("SELECT * FROM `ovzor-equipstatus` WHERE 1 ORDER by `schoolid` desc");
while($classdata1 = mysql_fetch_array($query19))
	{if ($classdata1[type]=="cam")
		{// камера
		$query9 = mysql_query("select classtitle,realnumber, city, doutype, classroomnumber FROM `ovzor-class`,`ovzor-classroom`,`ovzor-school` 
		WHERE `ovzor-class`.classroomid=`ovzor-classroom`.classroomid AND `ovzor-classroom`.schoolid=`ovzor-school`.schoolid 
		and `ovzor-classroom`.classroomid='$classdata1[id]';");// получили данные о камере
		$classdata = mysql_fetch_array($query9);
		$classtitle=$classdata[classtitle]; ?>
		<tr>
		<td><span style="color: #FF6600;"><b><?
		print1251($classdata[city]);
		if ($classdata[doutype]==1){echo ". Школа";}elseif($classdata[doutype]==2){echo ". Детский сад";}
		echo " номер ";print1251($classdata[realnumber]);echo ". Комната ";print1251($classdata[classroomnumber]);echo " (Класс/группа - ";print1251($classtitle);echo ")"; ?>
		</b></span></td>
		<td><span style="color: #FF6600;"><b>Камера</b></span></td>
		<td><img src='i/tribal-magic.ru.servstatus<?=$classdata1[status]?>.png'></td>
		</tr>
<?		}
	else
		{$query9 = mysql_query("SELECT realnumber, city, doutype FROM `ovzor-school` , `ovzor-equipstatus` 
		WHERE `ovzor-equipstatus`.schoolid = `ovzor-school`.schoolid AND `ovzor-equipstatus`.schoolid='$classdata1[schoolid]' LIMIT 0 , 1 ;");
		//echo "select realnumber, city, doutype FROM `ovzor-class`,`ovzor-classroom`,`ovzor-school` 
		//WHERE `ovzor-equipstatus`.schoolid=`ovzor-school`.schoolid and `ovzor-equipstatus`.schoolid='$classdata1[schoolid]';";
		$classdata = mysql_fetch_array($query9);
		 ?>
		<tr><td>
		<span style="color: #FF6600;"><b><?
		print1251($classdata[city]);
		if ($classdata[doutype]==1){echo ". Школа";}elseif($classdata[doutype]==2){echo ". Детский сад";}
		echo " номер ";print1251($classdata[realnumber]); echo "."; ?>
		</b></span></td>
		<td><span style="color: #FF6600;"><b><? if($classdata1[type]=="ss"){echo "Стримсервер";}else print1251($classdata1[title]); ?></b></span></td>
		<td><img src='i/tribal-magic.ru.servstatus<?=$classdata1[status]?>.png'></td>
		</tr>
<?		}

	}
function print1251($element){echo iconv( "windows-1251", "utf-8",$element);}?>
</table>