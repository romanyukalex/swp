<? @include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
@include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
$newsid=process_data($_REQUEST[id],4);
if($newsid){
	$newsdata=mysql_fetch_array(mysql_query("SELECT * FROM `ms-news` WHERE `newsid`='$newsid' limit 0,1;"));
	if($newsdata[newsid]){
		?><br><br><span class="newstitle"><?=$newsdata[newstitle]?></span><br><br>
		<?=$newsdata[fulltext]?>
	</span><br><br>
    Дата: <?=$newsdata[newsdate]?>
    <br><br>
	<a href="/?page=news&id=<?=($newsid+1)?>" onClick="shownews('<?=($newsid+1)?>'); return false;">Следующая новость
	<?	}
	else {
		$newsonmain=100;@include($_SERVER["DOCUMENT_ROOT"]."/newsblock.php");
		}
	}
elseif(!$newsid or $newsid=="0"){// Нет id, значит выдаем все новости
	$newsonmain=100;
	@include($_SERVER["DOCUMENT_ROOT"]."/newsblock.php");
	}?>