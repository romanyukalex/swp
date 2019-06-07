<? if($nitka==1){
	# Создание структур таблиц в БД
	$structuresnum=0;
	foreach($structures as $created=>$querytext){
		$structuresnum++;
		$qresult=mysql_query($querytext);
		echo $created;
		if($qresult)echo " successfully created\r\n";
		else {$install_errcount++;
			?> <b>can't create</b><?="\r\n".$qresult;
			echo "<br>Trying to create ".$created." was with query <br>";?>
			<a href="#" onClick="showHideSelection('error_text_<?=$structuresnum?>');return false;" id="link_<?=$structuresnum?>">Show query text</a>
			<div style='display: none;' id='error_text_<?=$structuresnum?>'>
				<span style='color:blue'><?=$querytext?></span>
			</div>
			<br>Answer was:<br><span style='color:red'><?=mysql_error($dbconnconnect)?></span><?
		}
		echo "<br><br>";
	}

	foreach($DBdata as $donetext=>$querytext){
		$structuresnum++;
		$qresult=mysql_query($querytext);
		echo $donetext.". Result - ";
		if($qresult)echo "successful\r\n";
		else {$install_errcount++;
			?><b style='color:red'>NOT successful</b><?echo "\r\n";?>
			<br>Query was<br>
			<a href="#" onClick="showHideSelection('error_text_<?=$structuresnum?>');return false;" id="link_<?=$structuresnum?>">Show query text</a>
			<div style='display: none;' id='error_text_<?=$structuresnum?>'><span style='color:blue;'><?=$querytext?></span></div>
				<br>Answer was:<br><span style='color:red'><?=mysql_error($dbconnconnect)?></span><?
		}
		echo "<br><br>";
	}
// Структура БД создана
}?>