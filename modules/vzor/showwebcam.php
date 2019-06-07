<? if ($userrole=="admin" or $userrole=="Директор школы" or $userrole=="Пользователь системы ВЗОР"){// Допускаем
// Проверка блокировки в админке
if ($blockshowcam=="Разрешить просмотр"){
$webcam[1]=htmlspecialchars($_GET['camera']);
if (stristr($webcam[1],"archive"))
	{//Смотрят записи
	$viewmode="archive";
	$webcam = explode("-", $webcam[1]);
	$webcam[1]=$webcam[0];// так что $webcam[1] - это опять название камеры
	$start=htmlspecialchars($_GET['start']);
	}
$mode=htmlspecialchars($_GET['mode']);
$userid=$user[userid];
$a = getdate();$today=$a['year']."/".$a['mon']."/".$a['mday'];if ($mode=="debug") echo "Сервер считает, что сегодня ".$today."<br>";
$howmuchdaybeforeisneed=htmlspecialchars($_GET['d']);
$neededdate=date("Y", (time()-$howmuchdaybeforeisneed*86400))."/".date("n", (time()-$howmuchdaybeforeisneed*86400))."/".date("d", (time()-$howmuchdaybeforeisneed*86400));
//if (!$neededdate or $neededdate==$today){$showminutesondate='"+d.getFullYear()+"/"+(d.getMonth()+1)+"/"+d.getDate()';}else{$showminutesondate=$neededdate."\"";}
if ($mode=="debug") echo "Сервер считает, что нужно выводить минуты за ".$neededdate."<br>";
?><h1 class="gradientblack">Страница видеонаблюдения<b></b></h1><br>
<P>Все доступные камеры:
<? 
if ($userrole=="Пользователь системы ВЗОР"){
// Юзер - родитель
	//Получаем его родную камеру
	$query=mysql_query("select `forepostip`,`forepostport`,`classtitle`,`ovzor-classroom`.`classroomid`,`cameraname`,`ovzor-classroom`.`schoolid`,`ovzor-classroom`.`describe` from 
	`ovzor-classroom`,`ovzor-class`,`ovzor-users` 
	where `userid`='$userid' and `ovzor-users`.`classid`=`ovzor-class`.`classid` and `ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid`");
	$maincaminfo=mysql_fetch_array($query);
	$mainip=$maincaminfo[forepostip];
	$mainport=$maincaminfo[forepostport];
	$mainclasstitle=$maincaminfo[classtitle];
//	$mainclassroomid=$maincaminfo[classroomid];
	$mainclassroomcameraname=$maincaminfo[cameraname];
	$schoolid=$maincaminfo[schoolid];
	$maincamdescribe=$maincaminfo[describe];
	if ($webcam[1]==$mainclassroomcameraname or !$webcam[1]){$ip=$mainip;$port=$mainport; $cameraexist=1;}
	?>
<a class='tribal-magic-Scrollover' type='scrollover' href="/vzor/?camera=<?=$mainclassroomcameraname; ?>"><?=$maincamdescribe." ".$mainclasstitle;?></a> 
<?
	//Получаем все камеры доступные forall для этой школы
	$forallinfo=mysql_query("SELECT `classroomid`,`cameraname`,`describe`,`forepostip`,`forepostport` FROM `ovzor-classroom` 
	WHERE `schoolid` ='$schoolid' AND `access` = 'forall'");

 	while ($forall=mysql_fetch_array($forallinfo))
		{if ($webcam[1]==$forall[cameraname])
			{// Тоесть запрашиваемая камера есть в этом списке доступных юзеру камер
			$ip=$forall[forepostip];$port=$forall[forepostport];
			$cameraexist=1;
			}
		?><a class='tribal-magic-Scrollover' type='scrollover' href="/vzor/?camera=<?=$forall[cameraname];?>"><?=$forall[describe];?></a> 
<?		;}
	if ($cameraexist==1)
		{// Значит запрашиваемая камеры была найдена
		@require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
		$prov=mysql_query("SELECT `action`,`classroomid` FROM `ovzor-log` WHERE `userid`='$userid' ORDER BY `date` DESC LIMIT 0,1");
		$lastaction=mysql_fetch_array($prov);
		}
 }; 
//Для директоров:
if ($userrole=="Директор школы"){// Допускаем 
	$i=0;
	// Камеры для всех:
	$query=mysql_query("SELECT `ovzor-classroom`.`classroomid`,`cameraname`,`ovzor-classroom`.`describe`,`forepostip`,`forepostport` FROM `ovzor-school`,`ovzor-classroom` 
	WHERE `directorid` ='$userid' and `ovzor-school`.`schoolid`=`ovzor-classroom`.`schoolid` and `access` = 'forall'");
	while ($forall=mysql_fetch_array($query))
		{// Если номер камеры не задан в строке браузера, то надо вываливать первую камеру в экран
		if ($webcam[1]==$forall[cameraname] or (!$webcam[1] and $i==0)){$ip=$forall[forepostip];$port=$forall[forepostport];$i=1;}  
		?><a class='tribal-magic-Scrollover' type='scrollover' href="/vzor/?camera=<?=$forall[cameraname]; ?>"><?=$forall[describe]; ?></a> 
<?		;}
	//Камеры в классах
	$query=mysql_query("SELECT `ovzor-classroom`.`classroomid`,`cameraname`,`ovzor-classroom`.`describe`,`ovzor-class`.`classtitle`,`forepostip`,`forepostport`
	FROM `ovzor-school`,`ovzor-classroom`,`ovzor-class`	WHERE `directorid` ='$userid' and `ovzor-school`.`schoolid`=`ovzor-classroom`.`schoolid` 
	and `access` = 'toparrent' and `ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid`");
	while ($forparrents=mysql_fetch_array($query))
		{if ($webcam[1]==$forparrents[cameraname]){$ip=$forparrents[forepostip];$port=$forparrents[forepostport];}  
		?><a class='tribal-magic-Scrollover' type='scrollover' href="/vzor/?camera=<?=$forparrents[cameraname]; ?>">
		<?=$forparrents[describe]." ".$forparrents[classtitle]; ?></a> 
<?		;}
	  }; ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script src='/vzor/js/erly/jquery.flot.js' type='text/javascript'></script>
<table>
	<tr>
		<td colspan="2">
		<div id="showonline">
		<h1 class="gradientblue">On-line просмотр видео-камеры<b></b></h1>
		<a href="/vzor/?camera=<?=$webcam[1]?>"<? if(!$howmuchdaybeforeisneed or $howmuchdaybeforeisneed=="0"){?> style='color:#FF6600'<? }?> type='scrollover'>
		Он-лайн просмотр</a>
		<br><br>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<div id="records">
		<h1 class="gradientblue">Записи видео-камеры<b></b></h1>
		<a href="/vzor/?camera=<?=$webcam[1]?>"<? if(!$howmuchdaybeforeisneed or $howmuchdaybeforeisneed=="0"){?> style='color:#FF6600'<? }?> type='scrollover'>
		Записи за сегодня</a><br>
		<? # Ссылки на записи предыдущих дней
		for($i = 1; $i < 8; $i++) {?><a <? if($howmuchdaybeforeisneed!=="$i"){?>href="/vzor/?camera=<?=$webcam[1]?>&d=<?=$i?>"<? }?>
		<? if($howmuchdaybeforeisneed=="$i"){?> style='color:#FF6600'<? }?> type='scrollover'>
		Записи <?=date("Y", (time()-$i*86400))."/".date("n", (time()-$i*86400))."/".date("d", (time()-$i*86400)); ?></a><br><div class="space"></div><? } ?>
		
		<span style="font-size:16px; float:right">Выбрана дата: <?=$neededdate;?></span>
			<div id="minutes">
				<p id="messages"></p>
			</div>
			<div style="display: inline-block; background-color: #006400; width: 20px; height:20px;">&nbsp;</div> - есть минута<br>
			<div style="display: inline-block; background-color: #DC143C; width: 20px; height:20px">&nbsp;</div> - нет минуты<br>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<br><br>
		<div id="player">Загрузка видео-плеера</div>		
		</td>
		<td><div style='width:150;'>Здравствуйте, <?=$nickname; ?><br><br>
		<!-- Таймер -->
		<div>Вы смотрите эту страницу <span id="timer">0</span> секунд.</div>
		<!--<script type="text/javascript" src="js/jquery-1.2.6.js"></script>-->
		<script type="text/javascript" src="js/jquery.timers.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		<? if ($start){?>
			var n=1;
			var starttimestmp=<?=$start;?>;
			var curtimestmp;
			<? }?>
			$("#timer").everyTime(1000,function(i) {$(this).text(i);
			<? if ($start){?>
			if (i==n*60)
   				{curtimestmp=starttimestmp+n*60;
				$(".hour a").attr('title':'222222');
				/*alert (curtimestmp);*/
				n++;
				};
			<? }?>
			if (i==3600)
   				{<? // Редирект на страничку аккаунт ?>
				if (starttimestmp){var url=starttimestmp+3600;}
				window.location.replace("/vzor/?%C4ET=BbIXOD=<?=$webcam[1]?>="+url);
				};
			});
		});
		</script>
		<!-- / таймер -->
		<center><a href="http://<?=$sitedomainname;?>/vzor/?%C4ET=BbIXOD"><img src='i/tribal-magic.ru.stop.png'></a><br>
		<a href="http://<?=$sitedomainname;?>/vzor/?%C4ET=BbIXOD" class='tribal-magic-Scrollover' type='scrollover'>Закончить просмотр</a></center></div>
		</td>
	</tr>
	<!--
	<tr>
		<td><center>Видеокамера <?=$webcam[1]; ?></center>
		</td><td></td>
	</tr> -->
</table>
<br>
<div id="console_log"></div>
<script type="text/javascript">
erlyvideo = {};
		
erlyvideo.connected = function() {
<? if ($mode!=="debug"){?>/*<? }?>  if (console) console.log("connected");<? if ($mode!=="debug"){?>*/<? }?> 
}

erlyvideo.init = function() {
<? if ($mode!=="debug"){?>/*<? }?> if (console) console.log("init");<? if ($mode!=="debug"){?>*/<? }?> 
}

erlyvideo.log = function(message) {
<? if ($mode!=="debug"){?>/*<? }?> if (console) console.log(">> "+message);<? if ($mode!=="debug"){?>*/<? }?> 
}

erlyvideo.playing = function(file) {
<? if ($mode!=="debug"){?>/*<? }?>  if (console) console.log("playing "+file);<? if ($mode!=="debug"){?>*/<? }?> 
}

 $(function() 
 	{
  	if(!window.console) 
		{
   		window.console = {};
    	window.console.log = function(text) 
			{
      		var c = $("#console_log");
      		c.html(c.html() + text + "<br>");
   			}
  		}
  	setInterval(load_minutes, 60000);
 	load_minutes();
  <? if ($mode!=="debug"){?>/*<? }?>
   console.log("embedding player "+server+","+camera); <? if ($mode!=="debug"){?>*/<? }?> 
  swfobject.embedSWF("Player.swf?", "player", "640", "480", "10", "expressInstall.swf", 
    {server : "rtmp://<?=$ip;?>", file : "<?=$webcam[1];if ($viewmode=="archive"){;?>-archive?start=<?=$start;}?>"}, {allowscriptaccess : "always"}); 
	}
);

var hh;hh=1;
function load_minutes() {
  var d = new Date();
  $.get("/vzor/minutes.php?%<?=$webcam[1];?>%<? if (!$neededdate or $neededdate==$today){?>"+d.getFullYear()+"/"+(d.getMonth()+1)+"/"+d.getDate()<?	}else{echo $neededdate."\"";}?>, {}, function(list) 
	{
	/* проверка list.length. Если она null то ждем 2 секунды и посылаем заново*/
	if ((list==null || list.length==0)&&hh<6)
		{//alert('Null')
		//wait 2 sec
		setTimeout(load_minutes, 5000);
		hh++;
		if (hh==6)
			{$("<p style='color:green;font-weight:bolt'>Записи за этот день не были обнаружены на сервере</p>").replaceAll( '#minutes>p#messages' );
			}
		}
    else 
		{setTimeout(load_minutes, 60000);
		var minutes = "<div class='hour-title'>&nbsp;</div><div class='hour'>";
		var i = 0;
		for (i = 0; i < 60; i++) {
		  if(i % 10 == 0) {
			minutes += "<i>"+i+"</i>";
		  } else {
			minutes += "<i>&nbsp;</i>";
		  }
		}
		minutes += "</div>";
		var current_hour = null;
		var current_minute = null;
		var hour_text = "";
		for(i = 0; i < list.length; i++) {
		  var record = list[i];
		  var time = record.path.match(/(\d+)\/(\d+)\/(\d+)\/(\d+)\/(\d+)\./);
		  var year = time[1];
		  var month = time[2];
		  var day = time[3];
		  var hour = time[4];
		  var minute = time[5];
		  if(hour != current_hour) {
			if (current_hour != null) {
			  var j;
			  for(j = current_minute; j < 60; j++) {
				hour_text += "<b>&nbsp;</b>";
			  }
			}
			if(hour_text) hour_text += "</div>";
			minutes += hour_text;
			hour_text = "<div class='hour-title'>"+hour+"</div><div class='hour'>";
			current_hour = hour;
			current_minute = -1;
		  }
		  while(current_minute < minute - 1) {
			hour_text += "<b>&nbsp;</b>";
			current_minute++;
		  }
		  hour_text += "<a title='"+record.path+"' check='1' start='"+record.timestamp+"' href='/vzor/?camera=<?=$webcam[1];?>-archive&start="+record.timestamp+"<? if ($howmuchdaybeforeisneed){echo "&d=".$howmuchdaybeforeisneed;} ?>' >&nbsp;</a>";
		  current_minute = minute;
		}
		if(hour_text) hour_text += "</div>";
		minutes += hour_text;
		minutes += '<div style="float: none; clear: both;"></div>';
		$("#minutes").html(minutes);
		} /* конец checklist*/
  }, "json");

}
</script>
<? }
else {echo $blockshowcammessage;} // конец Проверки блокировки в админке
} ?>
</DIV>