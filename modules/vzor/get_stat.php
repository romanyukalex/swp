<? @require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
 $userid=$_REQUEST['user'];//$who=$_REQUEST['who'];?>
<table><tr><td  width="128px"> </td><td>
	<table><tr><td>Время</td><td>Действие</td></tr>
<? $statsquery=mysql_query("SELECT `action`,`date` FROM `ovzor-log` WHERE `userid`='$userid' ORDER BY `date` DESC");
while ($stats=mysql_fetch_array($statsquery))
	{
	if (!(strstr($stats[action],"Paid") and substr($stats[action], 5)=="0") and $stats[action]!=="badpost" and  $stats[action]!=="spammailed" and $stats[action]!=="inprogress")
		{ ?>
<tr><td><?=$stats[date]."			- "; ?></td><td>
<? if ($stats[action]=="startshow"){echo "Начало просмотра видеокамер";}
elseif ($stats[action]=="stopshow"){echo "Завершение просмотра камер";}
elseif ($stats[action]=="enter"){echo "Вы вошли в личный кабинет";}
elseif ($stats[action]=="startshowcam"){echo "Переключение видеокамеры";}
elseif ($stats[action]=="getout"){echo "Вы вышли из системы";}
//elseif (strstr($stats[action],"Вы изменили тарифный план") or strstr($stats[action],"На Ваш счёт поступили деньги") or strstr($stats[action],"Изменен")){echo $stats[action];}
elseif(strstr($stats[action],"Paid") and substr($stats[action], 5)!=="0")
	{echo "Списано за услуги on-line просмотра: ". substr ($stats[action], 5)." руб.";
	}
elseif ($stats[action]=="Password_changed"){echo "Изменение пароля пользователем";}
elseif ($stats[action]=="messagesent"){echo "Отправлено сообщение администрации";}
//elseif ($stats[action]=="inprogress"){echo "Браузер отослал маяк 'Я он-лайн'";}
else{echo $stats[action];} ?></td></tr>

<?		}
	} ?>
	</table>
</td></tr></table>