<div class="padder"><!-- Divisions blog -->
		<ul class="m_blog listing topbox">
<? @include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
@include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");

if($_REQUEST['id'] and $_REQUEST['vchid']){// Смотрят текст конкретной новости
	@include_once($_SERVER["DOCUMENT_ROOT"]."/checkuserrole.php");
	$vchid=process_data($_REQUEST['vchid'],5);
	$newsid=process_data($_REQUEST['id'],5);
	$newsdata=mysql_fetch_array(mysql_query("SELECT `nickname`,`userid`,`newsid`,`fulltext`,`newsdate` FROM `ms-vchnews`, `ms-users` 
	WHERE `vchid`='$vchid' and `newsid`='$newsid' and `userid`=`newsuserid` LIMIT 0,1;"));
	//echo "SELECT `nickname`,`userid`,`newsid`,`fulltext`,`newsdate` FROM `ms-vchnews`, `ms-users` 
	//WHERE `vchid`='$vchid' and `newsid`=`$newsid` and `userid`=`newsuserid` LIMIT 0,1;";
	?><li class="gb"><span title="Опубликовал <?=$newsdata['nickname']?>"><?=$newsdata['newsdate']." ".$newsdata['nickname']?></span>
		<a href="/" onClick="showvchnews('<?=$vchid?>');linkcolor('divisions');return false;">Назад <b>›</b></a> 
		</li></ul>
		<br><?=$newsdata['fulltext'];?><ul class="m_blog listing topbox">
	<? if($userrole=="admin" or $userrole=="administrator" or $newsdata['nickname']==$nickname)
			{// Показываем ajax скрипт для удаления новости?>
			<li style="background:none; border:none">
            <a href="/" onClick="deletevchnews('<?=$vchid?>','<?=$newsdata['newsid']?>');return false;">Удалить <b>›</b></a>
			<script>function deletevchnews(vchid,someid){
			$("#content1").load('/ajax/',{id:someid,action:"deletevchnews",page:"divisions"},function(){showvchnews(vchid);});
			return false;}</script></li>
		<?	}
	}
elseif($_REQUEST['vchid']){
	//Смотрят новости по конкретной части
	@include_once($_SERVER["DOCUMENT_ROOT"]."/checkuserrole.php");
	$vchid=process_data($_REQUEST['vchid'],5);
	if ($_SESSION['homevch']==$vchid)
		{// Командир смотрит свою часть
		$shownewnewsform="1";
		}
	$newsquery=mysql_query("SELECT `nickname`,`userid`,`newsid`,`fulltext`,`newsdate` FROM `ms-vchnews`, `ms-users` WHERE `vchid`='$vchid' and `userid`=`newsuserid` ORDER BY `newsdate` DESC;");
	while($newsdata=mysql_fetch_array($newsquery))
		{?><li class="gb"><span title="Опубликовал <?=$newsdata['nickname']?>"><?=$newsdata['newsdate']." ".$newsdata['nickname']?></span><?
		$fulltextall=explode("<br>",$newsdata['fulltext']);$fulltext=$fulltextall[0];// Берем все до перевода каретки и выыводим первые N символов
		echo substr($fulltext,0,118)."...";
		?>
		<a href="/" onClick="showvchnewstext('<?=$vchid?>','<?=$newsdata['newsid']?>');return false;">Читать <b>›</b></a>
		</li>
	<?	}
	?><li class="gb"><a href="/?page=divisions" onClick="changerazdel('divisions');return false;">Назад <b>›</b></a><?
	if($shownewnewsform=="1")
		{?>
		<li class="gb"><span title="Добавить новость">Добавить новость</span>
		<textarea id="newvchnews" rows="3" cols="80" style="vertical-align:middle"></textarea>
		<a href="/" onClick="postvchnews('<?=$vchid?>');return false;">Добавить <b>›</b></a></li>
		<script>
		function postvchnews(vchid){
		var newsdata = document.getElementById('newvchnews');
		$('#content1').load('/ajax/', {action:"newvchnews",newvchnews:newsdata.value,vch:vchid},function(){showvchnews(vchid);});
		}
		</script><?
		}
	}
else{// Смотрят список частей
$newsquery=mysql_query("SELECT * FROM `ms-vch` WHERE 1;");?>
		<? while($newsdata=mysql_fetch_array($newsquery)){?>
		<li class="gb"><span><?=$newsdata['vchname']?></span><a href="/?page=divisions&id=<?=$newsdata['vchid']?>" onClick="showvchnews('<?=$newsdata['vchid']?>');linkcolor('divisions');return false;">Читать <b>›</b></a></li>
		<? }?>
<?	}?>
</ul>
		<!-- End Divisions blog -->
</div><!--close padder-->