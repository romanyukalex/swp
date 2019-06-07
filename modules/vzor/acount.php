<div class="content-center">
<?	if ($userrole=="admin" or $userrole=="Директор школы" or $userrole=="Пользователь системы ВЗОР"){// Допускаем 
	if ($blockcabinet=="Разрешить вход в кабинет"){
	$userid=$user[userid];
	//if ($userrole=="Пользователь системы ВЗОР")
	//Получаем  данные о счете пользователя и камеру для перенаправления на просмотр
	$prov=mysql_query("SELECT `action`,`date` FROM `ovzor-log` WHERE `userid`='$userid' and `ip`='$userip' ORDER BY `date` DESC LIMIT 0,1");
	$lastaction=mysql_fetch_array($prov);
	if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress")
		{// они смотрели камеры только что - надо обсчитать. Это защита от выхода из кабинета по поддельной ссылке
		$query[1]="BbIXOD";
		}
	@require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	if ($query[1]=="BxoD")
		{ // Зашли в кабинет
		//echo $lastaction[action].$userip;
		if ($lastaction[action]!=="enter" or !$lastaction[action])
			{// Защита от рефреша
			$lastenter=$lastaction[date];
			mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`)
			VALUES ('$userip', '$userid', NULL ,NULL, CURRENT_TIMESTAMP, 'enter');"); // Записали вход
			//echo "Отравили зарос в БД";
			}
		//else echo "оследн зарос $lastaction[action] $lastaction[date] наш IP=$userip      $ip";
		}
	if ($query[1]=="ADMuHuCTP")
		{
		if (!strstr($lastaction[action],"messagesent"))
			{// Защита от рефреша
			$messagetoadmin=substr(trim($_POST['messagetoadmin']),0,500);
			$messagetoadmin=htmlspecialchars($messagetoadmin, ENT_QUOTES);
			$userdata1=mysql_query("select `contactmail` from `ovzor-users` where `login`='$login' and `password`='$password'");
			$user1=mysql_fetch_array($userdata1);
			$usermail=$user1[contactmail];
			// Отправляем сообщение
			$subject="Сообщение пользователя из личного кабинета www.ovzor.ru";
			$from="Администрация сайта";
			$header="Content-type: text/html;  charset=utf-8\n";
			$header.="From: ".$nickname." <".$usermail.">\n";
			$header.="Subject: ".$subject."\n";
			$header.="Content-type: text/html; charset=cp1251";
			@ mail($var[3], $subject, $messagetoadmin, $header);
			$messagetouser="Здравствуйте,".$nickname."<br>Из Вашего личного кабинета в системе ВЗОР (Видео Забота О Ребенке) было отправлено сообщение 
			администрации сайта следующего содержания<br>".$messagetoadmin."<br>Это письмо носит уведомительный характер и отправлено в целях обеспечения 
			информационной безопасности системы ВЗОР. Если это сообщение отправлено не Вами, просим Вас написать нам. Спасибо за понимание.<br>
			Администрация системы ВЗОР (Видео Забота О Ребенке)";
			$header1="Content-type: text/html;  charset=utf-8\n";
			$header1.="From: ".$from." OVZOR.RU<".$var[3].">\n";
			$header1.="Subject: ".$subject."\n";
			$header1.="Content-type: text/html; charset=cp1251";
			@ mail($usermail, $subject, $messagetouser, $header1);
			mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
			VALUES ('$userip', '$userid', NULL , CURRENT_TIMESTAMP, 'messagesent');"); // Записали отправку сообщения
			$errormessage="Ваше сообщение отправлено администрации системы ВЗОР<br>На Ваш почтовый адрес отправлено уведомление об этом событии";
			}
		}
	if ($query[1]=="IIapoJlb")
		{
		if ($lastaction[action]!=="Password_changed")
			{// Защита от рефреша
			$oldpassword=substr(trim($_POST['oldpassword']),0,20);
			$oldpassword=htmlspecialchars($oldpassword, ENT_QUOTES);
			if ($oldpassword==$password)
				{// Старый пасс введен правильно
				$newpassword1=substr(trim($_POST['newpassword1']),0,20);
				$newpassword1=htmlspecialchars($newpassword1, ENT_QUOTES);
				$newpassword2=substr(trim($_POST['newpassword2']),0,20);
				$newpassword2=htmlspecialchars($newpassword2, ENT_QUOTES);
				if ($newpassword1==$newpassword2)
					{
					if (strlen($newpassword1)<9){$errormessage="Пароль должен быть более 8 символов";}
					else{// Вообще всё корректно меняем пассворд
						mysql_query("UPDATE `ovzor-users` SET `password` = '$newpassword1' WHERE `ovzor-users`.`userid` ='$userid' LIMIT 1 ");
						mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`) 
						VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP, 'Password_changed');"); // Записали смену пароля
						$errormessage="Ваш пароль успешно изменен";
						};
					}
				else{$errormessage="Ваш новый пароль введен некорректно, попробуйте ещё раз";}
				}
			else{$errormessage="Ваш текущий пароль введен неверно";}	
			}
		}
	if ($query[1]=="Tapuqp" and $userrole=="Пользователь системы ВЗОР")
		{ // Меняют тариф
		$tariffname=substr(trim($_POST['tariff']),0,20);
		$tariffname=htmlspecialchars($tariffname, ENT_QUOTES);
		if ($tariffname){
		$prov=mysql_query("SELECT `minsummforchangeto`,`tariffid` FROM `ovzor-tariff` 
		WHERE `tariffname`='$tariffname' and `status`='active' and `tarifftype`='online';");
		$tariffchange=mysql_fetch_array($prov);
		if ($tariffchange[minsummforchangeto])
			{// Тариф найден
			// Посмотрим что там на счету и защитимся от рефреша (запроса на тот же тариф)
			$query1=mysql_query("select `means`, t.`tariffid`  from `ovzor-tariff` t, `ovzor-account` 
			where `ovzor-account`.`userid`='$userid' and `ovzor-account`.`tariffid`=t.`tariffid`");

			$maininfo=mysql_fetch_array($query1);
			if ($maininfo[tariffid]==$tariffchange[tariffid])
				{// Запросили тот же тариф что и был
				$errormessage="Смена тарифа прошла неуспешно: запрашиваемый тарифный план уже используется Вами.";
				}
			else {// запросили тарифный план, не равный текущему
				if ($maininfo[means]>=$tariffchange[minsummforchangeto])
					{// Суммы на счету достаточно чтобы изменить план
					mysql_query("UPDATE `ovzor-account` SET `tariffid` = '$tariffchange[tariffid]' WHERE `ovzor-account`.`userid` ='$userid' 
					AND `ovzor-account`.`tariffid` ='$maininfo[tariffid]' LIMIT 1 ;"); // Поменяли тариф
					mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`) 
					VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP, 'Вы изменили тарифный план на $tariffname');"); // Записали смену тарифа
					$errormessage="Тарифный план изменен на $tariffname";
					}
				else{// Суммы на счету не достаточно чтобы изменить план
					$errormessage="Суммы на Вашем счету не достаточно для перехода на тарифный план $tariffname";
					}
				}		
			}
		else{// Тариф не найден - подделка запроса - хакер или полный коллапс
			$errormessage="Запрашиваемый тариф не опознан системой";
			}
		}
		else {// Запрос без POST - данных
			$errormessage="Не видим данных для запроса";
			}
		}
	if ($query[1]=="BbIXOD")
		{// Вышли из режима просмотра
		if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress")
			{// Значит не просто повторно обновили страничку, а действительно вышли из просмотра	
		
			// записали действие "вышел из просмотра" в лог
			mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`,`camera`, `date`, `action`) 
			VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP- INTERVAL 1 second, 'stopshow');");

			if ($userrole=="Пользователь системы ВЗОР"){ // Списание денег
				// Сосчитаем на сколько он посмотрел
				@require($_SERVER["DOCUMENT_ROOT"]."/vzor/payit.php");
				} // Списание денег
				// Переведем времена в человечий вид
				$starttime[date]=date('h:i:s A', $starttime[date]);
				$stoptime[date]=date('h:i:s A', $stoptime[date]);
				//$sessiontime=date('i:s', $sessiontime);
			}
		}
	if ($userrole=="Пользователь системы ВЗОР")
		{
		$query=mysql_query("
		select `classtitle`,`ovzor-classroom`.`classroomid`,`cameraname`,`means`,`tariffname`,`tarifftype`, `tariffprice`,`ovzor-users`.`userid`, `doutype` , `realnumber`
		from `ovzor-classroom`,`ovzor-class`,`ovzor-users`,`ovzor-tariff`, `ovzor-account`, `ovzor-school`
		where 
			`ovzor-users`.`userid`='$userid' and 
			`ovzor-users`.`classid`=`ovzor-class`.`classid` and 
			`ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid` and
			`ovzor-account`.`userid`=`ovzor-users`.`userid` and
			`ovzor-account`.`tariffid`=`ovzor-tariff`.`tariffid` and 
			`ovzor-classroom`.`schoolid` = `ovzor-school`.`schoolid`
		LIMIT 1	");

		$maininfo=mysql_fetch_array($query);
		$userid=$maininfo[userid];
		$mainclasstitle=$maininfo[classtitle];
		$maintariffprice=$maininfo[tariffprice];
		$mainmeans=$maininfo[means];			
		$minute= floor($mainmeans/$maintariffprice);
		$maintariffname=$maininfo[tariffname];
		$maintarifftype=$maininfo[tarifftype];
		$doutype=$maininfo[doutype];
		$realnumber=$maininfo[realnumber];
		}
	elseif ($userrole=="Директор школы")
		{
		// Первая из камер для всех:
		$query=mysql_query("
		SELECT `ovzor-classroom`.`classroomid` ,`cameraname`, `ovzor-classroom`.`describe` , `forepostip` , `forepostport` , `tariffname` 
		FROM `ovzor-school` , `ovzor-classroom` , `ovzor-account` , `ovzor-tariff` 
		WHERE `directorid` ='$userid'
		AND `ovzor-school`.`schoolid` = `ovzor-classroom`.`schoolid` 
		AND `access` = 'forall'
		AND `ovzor-account`.`userid` = `directorid` 
		AND `ovzor-account`.`tariffid` = `ovzor-tariff`.`tariffid` 
		LIMIT 1");
		$maininfo=mysql_fetch_array($query);
		// Если номер камеры не задан в строке браузера, то надо вываливать первую камеру в экран
		$mainclasstitle=$maininfo[describe];
		$minute=2;
		// тариф (раздельные запросы потому что есть стадия подключения, когда нету камер в школе, а школу уже создали
		$query5=mysql_query("SELECT `tariffname` FROM  `ovzor-account` , `ovzor-tariff` 
		WHERE `ovzor-account`.`userid` = '$userid' AND `ovzor-account`.`tariffid` = `ovzor-tariff`.`tariffid` LIMIT 1");
		$tariffinfo=mysql_fetch_array($query5);
		$maintariffname=$tariffinfo[tariffname];
		}
	$mainclassroomid=$maininfo[classroomid];
	$mainclassroomcameraname=$maininfo[cameraname];
	
	###################
	# Начнем говорить:
	###################
	?><center>Здравствуйте, <?=$nickname?><br><br><br><div class='ramka'><?	
	if ($lastenter){ echo "Мы рады снова видеть Вас. Мы не виделись с ".$lastenter; }
	elseif ($starttime[date] and $stoptime[date])
		{date_default_timezone_set("Etc/GMT0"); // чтобы он ничего не прибавлял для таймзон (для sessiontime)
		echo "Ваша сессия просмотра началась ".$starttime[date]." и закончилась в ".$stoptime[date].".<br>Время просмотра - ".date("H:i:s", $sessiontime);
		if ($maintarifftype=="time"){echo "<br>Списано со счета - ".$paid." рубля(-ей)";}
		} 
	elseif($errormessage){echo $errormessage;}
	else {echo "Личный кабинет в системе ВЗОР";}
	?></div></center><br>
	<table>
		<tr><td><img src='i/tribal-magic.ru.people.png'></td><td><span style='font:12;'>Ваша роль на сайте: &laquo;<?=$userrole?>&raquo;</span><br></td></tr>
		<tr><td><img src='i/tribal-magic.ru.money.png'></td><td>Ваш тарифный план  &laquo;<?=$maintariffname?>&raquo;<?
	if ($userrole=="Пользователь системы ВЗОР")
		{echo "(".$maintariffprice;
		if ($maintarifftype=="time"){echo " рублей за минуту просмотра).";}
		elseif($maintarifftype=="unlim"){echo " рублей в день без ограничений по времени просмотра).";}
		echo "<br>Сейчас на счету ".$mainmeans." рублей";
		if ($maintarifftype=="time"){echo ", которых хватит еще на ".$minute." минут просмотра";}
		echo "<br>Номер счёта (для указания в платёжных документах):"; 
		if (strlen($userid) < $var[4])
			{ for ($i=strlen($userid);$i<($var[4]);$i++)
				{ echo "0";};
			}
		echo $userid;
		}
			?></td>
		</tr>
	</table><?
	if ($userip=="87.118.81.21"){ ?>
		<div class="ramka">
		<table>
		<tr><td><img src='i/tribal-magic.ru.alert.png'></td><td>Ошибка 313 [ IP адрес пользователя определен неверно ]<br>
		В техподдержку направлено уведомление об ошибке
		</td></tr>
		</table>
		</div>
	<?	include_once($_SERVER["DOCUMENT_ROOT"]."/vzor/send_letter.php");
		sendletter_to_admin("Проблемы с определением IP адреса на ОВЗОР","Проблемы с определением IP адреса на ОВЗОР<br>Пользователь $userid определен с IP= $userip . Услуга ему не предоставляется");
		}
	elseif ($minute>1 and (($browser=='ie' and $browserversion>=8) or $browser=='firefox' or $browser=='chrome' or $browser=='opera' ))
		{
		?>
		<div class="ramka">
			<div style="LEFT:400px; POSITION: absolute; TOP: -120px; z-index:0; visibility:hidden">
 			<img src="i/tribal-magic.ru.play-onmouseover.png" />
			</div>
		<table><tr><td><a href="/vzor/?camera=<?=$mainclassroomcameraname;?>" onMouseOver="document.playcamera.src='i/tribal-magic.ru.play-onmouseover.png'" 
		onMouseOut="document.playcamera.src='i/tribal-magic.ru.play.png'"><img src='i/tribal-magic.ru.play.png' name="playcamera"></a></td>
		<td><center><a href="/vzor/?camera=<?=$mainclassroomcameraname;?>" onMouseOver="document.playcamera.src='i/tribal-magic.ru.play-onmouseover.png'" 
		onMouseOut="document.playcamera.src='i/tribal-magic.ru.play.png'" class='tribal-magic-Scrollover' type='scrollover'>
		Начало просмотра (<?
		if ($userrole=="Пользователь системы ВЗОР")
			{if ($doutype==1){echo "школа номер ";}
			elseif($doutype==2){echo "детский сад ";}
			echo $realnumber.", ";	
			if ($doutype==1){echo "класс ";}
			elseif($doutype==2){echo "группа ";}
			echo $mainclasstitle;?>)</a></center></td></tr>
		<? if ($maintarifftype=="time")
				{?><tr><td><br><img src='i/tribal-magic.ru.alert.png'></td><td><?=$var[1];// Сообщение под кнопкой плей ?></td></tr>
			<?	}
			}
		elseif ($userrole=="Директор школы")
			{
			echo $mainclasstitle; ?>)</a></center></td></tr>
<?			}	?>
		</table>
		</div>
		<?
		} 
	elseif (($browser!=='ie' and $browser!=='firefox' and $browser!=='chrome' and $browser!=='opera' and $browser!=='safari' and $minute>1) or ($browser=='ie' and ($browserversion=="5" or $browserversion=="6" or $browserversion=="7")))
		{ ?>
		<div class="ramka">
		<table>
		<tr><td><img src='i/tribal-magic.ru.alert.png'></td><td>Ваш браузер не соответсвует требованиям системы<br>
		<? if ($browser=="ie"){echo "Обновите версию Internet Explorer до 8 или выше";}else{echo "Используйте любой из поддерживаемых браузеров: Internet Explorer, Firefox, Google Chrome, Opera";}?>
		</td></tr>
		</table>
		</div>
	<?	}?>
		<table><tr><td>
		<br><img src='i/tribal-magic.ru.sessionsinfo.png'></td><td style="text-align:left;">
		<a onclick="downloadstats();showHideSelection(this,'statistics')" ><?=$var[2];// Заголовок статистики ?></a></td></tr></table>
		<script type="text/javascript">
		function downloadstats(){
		$("#statistics").load('get_stat.php',{user:"<?=$userid;?>"});
		}
		</script>
				<div style="display: none;" id='statistics'>
				</div>
		<table><tr><td><br><img src='i/tribal-magic.ru.settings.png'><a onclick="showHideSelection(this,'settings')" >Настройки услуги</a>
				<div style="display: none;" id='settings'>
				<table><tr><td  width="128px"> </td><td>
					<div id="example-links">
<?					if ($userrole=="Пользователь системы ВЗОР")
						{ ?>
						<a href="#">Тарифный план</a>
<?						} ?>
					<a href="#">Изменение пароля</a>
					<a href="#">Написать ВЗОР</a>
					<!--<a href="#">Что то еще</a>
					<a href="#">Что то еще</a> -->
					</div>
				</td><td>
					<div id="example-content-container">
						<div id="example-content">
<?						if ($userrole=="Пользователь системы ВЗОР")
							{ // Изменение тарифа ?>
							<div><img src='i/tribal-magic.ru.changetariff.png' style="float:left;"><b>Изменение тарифного плана</b>
							<br />Вы можете изменить тарифный план на более подходящий. Единственным условием перехода является наличие 
							&laquo;обязательной суммы&raquo; на счету<br>
							<FORM ACTION="/?%C4ET=Tapuqp" METHOD="POST">
							<? $tariffquery=mysql_query("SELECT `tariffname`,`minsummforchangeto` FROM `ovzor-tariff` 
							WHERE `tarifftype` = 'online' AND `status`='active' AND `minsummforchangeto`;");
							while ($tariffname=mysql_fetch_array($tariffquery))
								{ ?>
								<INPUT TYPE="radio" NAME="tariff"  SIZE="21" MAXLENGTH="20" <? if ($maintariffname==$tariffname[tariffname]){echo " checked ";}
								echo "value='".$tariffname[tariffname]."'>".$tariffname[tariffname]." (".$tariffname[minsummforchangeto]." р.)<br>";
								}	?>		
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<INPUT type="submit" value="Изменить" class="enter-input">
							</FORM>
							</div>
<?							} ?>
							<div>
							<img src='i/tribal-magic.ru.password.png' style="float:left;"><b>Изменить пароль</b><br />Изменить пароль очень просто. 
							Введите старый пароль и новый, желаемый пароль<br>
							<FORM ACTION="http://tribal-magic.ru/vzor/?%C4ET=IIapoJlb" METHOD="POST">
							
							<table><tr><td>Старый</td><td><INPUT TYPE="password" NAME="oldpassword"  SIZE="20" MAXLENGTH="20" 
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"></td></tr>
							<tr><td>Новый</td><td><INPUT TYPE="password" NAME="newpassword1"  SIZE="20" MAXLENGTH="20"
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"></td></tr>
							<tr><td>Новый</td><td><INPUT TYPE="password" NAME="newpassword2"  SIZE="20" MAXLENGTH="20" 
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'">(еще раз)</td></tr>
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<tr><td colspan="2"><center><INPUT type="submit" value="Отправить" class="enter-input"></center></td></tr></table>
							
							</FORM>
							</div>
							<div><img src='i/tribal-magic.ru.message.png' style="float:left;"><b>Сообщение администрации</b><br />
							<FORM ACTION="http://tribal-magic.ru/vzor/?%C4ET=ADMuHuCTP" METHOD="POST">
							<INPUT TYPE="text" NAME="messagetoadmin"  SIZE="30" MAXLENGTH="500"
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"><br>
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<INPUT type="submit" value="Отправить" class="enter-input">
							</FORM></div>

						</div>
					</div>
					<div style="clear:both"></div>
					<script language="javascript">
					$('#example-links a').click(function(){
					var index = $("#example-links a").index(this);
					$('#example-content').animate({"marginTop" : -index*220 + "px"}); 
					return false;
					});
						
					</script>
				</td></tr></table>
				</div>
		</td></tr></table>
		<script language="javascript" type="text/javascript">
function showHideSelection(ths,str){
var obj=document.getElementById(str);
    if(obj.style.display=='inline'){
        obj.style.display='none';
    }else{
        obj.style.display='inline';   
    }
}
</script>
<? }
	else{echo $blockcabinetmessage;} // Блок-кабинета
}; ?>

</DIV>