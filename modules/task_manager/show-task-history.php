<? include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
include($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$taskinfo[taskid]=process_data($_REQUEST[taskid],7);
$mode=process_data($_REQUEST[mode],4);
if ($mode!=="all"){$limit="LIMIT ".$mode;}
$historyinfo=mysql_query("SELECT `commenttext`,`commentdate`,`commentuserid`,`commenttype`,`letter`,`nickname` FROM `task-history`,`task-users` u WHERE `taskid`='$taskinfo[taskid]' and `commentuserid`=u.`id` ORDER BY `commentid` DESC $limit;");
if (mysql_num_rows($historyinfo)>0){//echo $historyinfo;
	if ($mode=="all"){echo "История";}else{echo "$mode последних";}
	echo " сообщений:<br><textarea rows='15' cols='60' style='text-align:left'>";
	while ($historyinf=mysql_fetch_array($historyinfo))
		{echo $historyinf[commentdate]." ".$historyinf[nickname];
		if ($historyinf[commenttype]=="2")
			{echo " написал:\n".$historyinf[commenttext];
			}
		elseif($historyinf[commenttype]=="1")
			{echo " создал задачу";
			}
		elseif($historyinf[commenttype]=="3")
			{echo " изменил данные задачи:\n".$historyinf[commenttext];
			// $historyinf[commenttext] -> id юзера кому передали
			}
		if($historyinf[letter]=="1"){echo "\nОповещение разослано группе";}
		elseif($historyinf[letter]=="2"){echo "\nОповещение запрещено пользователем";}
		elseif($historyinf[letter]=="3"){echo "\nОповещение некому было рассылать";}
		echo "\n\n";	
		}
	echo "</textarea>";
	}
else echo "<span style='color:green; font-weight:bold'>Нет истории данной задачи</span>";
?>