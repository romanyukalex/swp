<?
if ($_REQUEST['gettask'])
	{include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
	$curtask=$_REQUEST['gettask'];
	$taskinfo=mysql_fetch_array(mysql_query("SELECT `taskid`,`projectid`,`date`,`priority`,`engineer`,`name`,`text`,`nickname`,`contactmail` 
	FROM `task-tasks`,`task-users` WHERE `task-tasks`.`engineer` = `task-users`.`id` AND `taskid`='$curtask' LIMIT 1;"));
	$usersinfo=mysql_query("SELECT `id`,`nickname`,`fullname` FROM `task-users` WHERE `userrole`!='admin';");
	?><script>$(function() {$("#tasktitle").text("Детали по задаче <?=$taskinfo[taskid]?>");});// Название всплывающего окна</script>
	
    <form enctype="multipart/form-data" action="/" accept-charset="utf-8" id="taskinfoform">
	<table>
	<tr><td>Задача <?=$taskinfo[taskid]?><? /*<input value="<?=$taskinfo[taskid]?>" maxlength="7" size="7" name="taskid" onchange="showsavebutton('savebutton1');">
    <input value="<?=$taskinfo[taskid]?>" name="taskid" style="display:none">*/?>
	Приоритет: <select name="PRI" onchange="showsavebutton('savebutton1');"><option value="1"<? if ($taskinfo[priority]=="1"){echo " selected";}?>>Высокий</option>
		<option value="2" <? if ($taskinfo[priority]=="2"){echo " selected";}?>>Средний</option>
		<option value="3" <? if ($taskinfo[priority]=="3"){echo " selected";}?>>Низкий</option>
        <option value="4" <? if ($taskinfo[priority]=="4"){echo " selected";}?>>Висяк</option></select>
		<?=$taskdata[priority]?>Дата открытия: <?=$taskinfo[date];?><br></td>
	</tr>
	<tr><td>Ответственный: <select name="engineerid" onchange="showsavebutton('savebutton1');">
		<? while ($userinf=mysql_fetch_array($usersinfo))
			{if(!($userinf[id]==1 and $taskinfo[projectid]==0)){
			?><option value="<?=$userinf[id]?>"<? if ($userinf[nickname]==$taskinfo[nickname]){echo " selected";}?>><?=$userinf[fullname]?></option>
<?				}
			}?></select>
		<!--<br><pre style="font-size: 10px">&#09;&#09;<?=$taskinfo[nickname]?></pre>--></td></tr>
	<tr><td>
	Описание задачи: <span id="tasknametext" style="display:inline;font-weight:bold"><? if (!$taskinfo[text]){echo $taskinfo[name];}else echo $taskinfo[text];?></span>
	<? if (!$taskinfo[text]){?><input value="<?=$taskinfo[name]?>" name="taskname" maxlength="400" size="80" style="display:none" id="tasknameinput"  onclick="showsavebutton('savebutton1');"><? }
	else{?><textarea maxlength="10000" rows="5" cols="60" name="text" style="vertical-align: middle;display:none;background-color:#fcf7f1; overflow:<? if ($browser=="opera"){echo "hidden";}else{?>auto<? }?>;" id="tasknameinput" onclick="showsavebutton('savebutton1');"><?=$taskinfo[text]?></textarea><? }?><a href="/" id="tasknameeditlink" style="display:inline" onClick="showHideSelectionSlow('tasknametext');showHideSelectionSlow('tasknameinput');showHideSelection('tasknameeditlink');return false;">[Edit]</a>
	<br><input type="submit" value="Сохранить" id="savebutton1" onclick="saveform('<?=$taskinfo[taskid]?>','taskinfoform');return false;" /><script>$(function(){$('#savebutton1').hide();});</script></form>
	</td></tr>
	<tr><td>
   <hr color="#82AFEC" />
	<div id="commentshistory">
	<? # Здесь выводится история сообщений. ?>
	
	</div>
	</td></tr>
	<tr><td>
	<a href="/" onClick="showHideSelectionSlow('newcommentlink');showHideSelectionSlow('newcommentinput');return false;" id="newcommentlink" style="display:inline">
	Оставить запись</a>
	<form enctype="multipart/form-data" action="/comments-make.php?taskid=<?=$taskinfo[taskid]?>" accept-charset="utf-8" style="display:none" id="newcommentinput" method="post">
	<!--<input value="Новая запись" maxlength="10000" size="80" name="COMMENT"  onblur="if (value == '') {value = 'Новая запись'}" onfocus="if (value == 'Новая запись') {value =''}" >-->
    <textarea maxlength="10000" rows="5" cols="60" maxlength="10000" name="COMMENT"  onblur="if (value == '') {value = 'Новая запись'}" onfocus="if (value == 'Новая запись') {value =''}" >Новая запись</textarea>
    <br />
	<input type="submit" value="Сохранить" height="150" <? /*onClick="getform('<?=$taskinfo[taskid]?>');return false;"*/?> onClick="saveform('<?=$taskinfo[taskid]?>','newcommentinput');return false;" /><input type="checkbox" name="sendletters" /> Не отправлять оповещения участникам группы
	</form>
	<a href="/" onClick="getComments('<?=$taskinfo[taskid]?>','all'); return false;">Получить полную историю</a>
	</td></tr>
	</table>


<?	}
else{echo "<span style='color:red; font-weight:bold; font-size:24'>Неверный номер задачи</span>";}

//function printAjax($element){echo iconv( "windows-1251","utf-8", $element);}
/* */ ?>