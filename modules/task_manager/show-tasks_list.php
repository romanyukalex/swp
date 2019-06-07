<? session_start(); 
@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
$userid=$_SESSION['userid'];
$userrole=$_SESSION['userrole'];
if ($userrole!=="guest")
	{
	if ($_REQUEST['mode']=="shortarchive")
		{?>Показаны самые последние закрытые задачи
	<?	$showstate="2";
		$showlimit="LIMIT 10";
		$orderby="ORDER BY t.`date` DESC";
		}
	elseif ($_REQUEST['mode']=="fullarchive")
		{?>Показан полный список закрытых задач по Вашим проектам
	<?	$showstate="2";
		$orderby="ORDER BY t.`date` DESC";
		}
	elseif($_REQUEST['mode']=="currenttask")
		{$showstate="1";
		$orderby="ORDER BY `priority` ASC";
		}
	elseif($_REQUEST['mode']=="searchtask"){
		$searchstring=$_REQUEST['string'];
		?>Показан результат поиска по фразе '<?=$searchstring?>'<?
		$showstate="2";
		$additional="and (`taskid` LIKE '%".$searchstring."%' or t.`name` LIKE '%".$searchstring."%' or `text` LIKE '%".$searchstring."%' or t.`date` LIKE '%".$searchstring."%')";
		}
		$query1=mysql_query("
		SELECT distinct `taskid`,`priority`,t.`name` as shorttext,`nickname`,`text`,pr.`name`as projectname,t.`projectid`,t.`date`
		FROM `task-tasks` t,`task-users`,`task-projectmembers` pm,`task-projects` pr
		WHERE t.`engineer` = `task-users`.`id` and `state`='$showstate' and pr.`id`=t.`projectid` and (t.`engineer`='1' or 
		(t.`projectid`=pm.`projectid` and pm.`memberid`='$userid') or (t.`projectid`='0' and t.`engineer`='$userid')) $additional 
		$orderby $showlimit");
	

	?>
	<table style="border:outset; background-color:#<? if($_REQUEST['mode']=="currenttask"){?>CCC<? }else{?>222222<? }?>;" border="1" class="tasktable" id="<?=$_REQUEST['mode']?>_table">
    <tr id="titletr">
	<th>WHO</th>
	<th width="60">PROJECT&nbsp;</th>
	<th>OPENED</th>
	<th>PRI</th>
	<th width="800">Short Description</th>
	<th>Действие</th></tr>
    <tr><td colspan="6"><hr /></td></tr>
	<? $kh=0;
	while ($taskdata=mysql_fetch_array($query1))
		{
		if($tasknumb[$taskdata[projectid]]){$tasknumb[$taskdata[projectid]]++;}else $tasknumb[$taskdata[projectid]]=1;
		$kh++;
		?><tr id="string_<?=$taskdata[taskid]?>">
			<td><?=$taskdata[nickname]?>&nbsp;</td>
			<td><?=$taskdata[projectname]?>&nbsp;<span class="hid">prid_<?=$taskdata[projectid]?></span></td>
            <td style="white-space:nowrap"><?=substr($taskdata[date],0,10)?>&nbsp;</td>
			<td><img src="/files/priority<?=$taskdata[priority]?>.png" title="
			<? if ($taskdata[priority]=="1"){echo "Высокий";} elseif ($taskdata[priority]=="2"){echo "Средний";}
			elseif ($taskdata[priority]=="3"){echo "Низкий";}elseif ($taskdata[priority]=="4"){echo "Самый нижайший";} ?> приоритет"/></td>
			<td><a href="/" onClick="openFullText(<?=$taskdata[taskid]?>);return false;" 
            class="link<? if ($_REQUEST[mode]=="currenttask"){echo "2";}?>" title="<?=$taskdata[text]?>">
			<? if($taskdata[shorttext]){echo $taskdata[shorttext];}elseif($taskdata[text]){echo substr($taskdata[text],0,64);}else{echo "Открыть задачу";}?>
            </a></td>
			<td onmouseover="linkcolor('string_<?=$taskdata[taskid]?>');" onmouseout="nolinkcolor();">
			<? if ($_REQUEST[mode]=="currenttask"){?>
				<a href="/ajax/?action=changetaskstatus&mode=delete&taskid=<?=$taskdata[taskid]?>" onclick="deletetask(<?=$taskdata[taskid]?>);return false;" 
				title="Удалить задачу"><img src="/files/magicsolutions.ru.delete.png"/></a>
				<? # Выводим последний коммент 
				$historyinfo=mysql_fetch_array(mysql_query("SELECT `taskid`,`commenttext` FROM `task-history`,`task-users` u 
				WHERE `taskid`='$taskdata[taskid]' and `commentuserid`=u.`id` ORDER BY `commentid` DESC limit 1;"));
				?>
				<a href="/" onClick="openFullText(<?=$taskdata[taskid]?>);return false;"  title="Последний комментарий: <?=$historyinfo[commenttext]?>"><img src="/files/magicsolutions.ru.history.png"/></a>
				<? $sumtasknumber=$sumtasknumber+$taskdata[taskid];
				 $lastcomments[] = array('taskid'=>$taskdata[taskid],"lcid" => $historyinfo['taskid']);//lcid - last comment ID
				 }
			elseif ($_REQUEST[mode]=="shortarchive" or $_REQUEST[mode]=="searchtask"or $_REQUEST[mode]=="fullarchive"){?>
            	<a href="/change-task.php?mode=back&taskid=<?=$taskdata[taskid]?>#top" onclick="backtask(<?=$taskdata[taskid]?>);return false;" 
				title="Вернуть задачу в работу" class="link"><img src="/files/magicsolutions.ru.back.png"></a>
				<? }?>
			</td>
		</tr>
	<?	}
	$commentsonpage=json_encode($lastcomments);?>
    <tr height="10px"><td colspan="6"><br /></td></tr>
	</table>

<? # JS для этих задач
if ($_REQUEST[mode]=="currenttask"){?>
<script><? //Активация фильтра колонок при загрузке листа задач?>
$(function() {
	checkcolfilter("currenttask_table");
});
</script>
<? }
?><script><? #Размер зоны задач
if ($kh!==0 and ($_REQUEST[mode]=="currenttask" or $_REQUEST[mode]=="searchtask" or $_REQUEST[mode]=="fullarchive")){?>
	$(function() {
		$("#<? if ($_REQUEST[mode]=="currenttask"){?>screenshots<? }else{?>features<? }?>").animate({height: "<? $countheight=(55+$kh*22);
		if ($countheight<382) echo "382"; else echo $countheight;?>px"}, 1000);
	});<?
}
elseif($_REQUEST[mode]=="shortarchive"){?>$(function() {$("#features").animate({height: "382px"},1000)})<?
}
?></script><?	
if($_REQUEST['mode']=="currenttask"){//Загрузка комментариев?>
<script>
$(function() {
	//Количество задач в каждом проекте(в скобках) и обновление фильтра проектов:
<?	foreach ($tasknumb as $prid => $tasknumber) {?>$('#tasknumber_<?=$prid?>').text(<?=$tasknumber?>);showproject(<?=$prid?>);<? }?>
	/*// Обновители комментариев
	var n=1;
	$("#timer").everyTime(1000,function(i) {
		<? if($mode=="debug"){?>$(this).text(i);<? }?>
		if (i==n*10)
			{<? // Проверяем, нет ли новых задач?>
			$("#justforfun").load('/ajax/',{"action":"doyouhavenewtask","sumtasknumber":"<?=$sumtasknumber?>"}, 
				function(newtaskstatus){
				if (newtaskstatus=="1"){<? // Есть задачи - обновить список задач, обновятся и последние комментарии?>showCurrentTasks();}
				else if(newtaskstatus=="2"){<? // Нет новых задач - отправляем список комментов и задач?>
				//	$("#justforfun").load('/ajax/',{"action":"doyouhavenewcomments","commentsonpage"=<?=$commentsonpage?>}, function(){
							<? // По пришедшему списку задач, где коммент устарел отправляем запрос на обновление коммента?>
							//getnewcomment();
					
				//	});
				}; //elseif
					
				n++;
				});// func
			};
		});*/
	});
</script>
	<?	}?>
<?	}?>
	