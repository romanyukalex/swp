<?
$log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){

insert_function("StringPlural");

?>


<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<a href="javascript:history.back();" class="justlink">Назад</a>
	</div>
	<section class="col-md-11">
		<form id="search_form" action="/?page=CTATbu_srch">Ищите то, что интересует
			<input type="hidden" name="page" value="<?=$page?>_srch">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $search_string;}?>">
			<input type="submit" class="button" style="height:38px;padding-top:10px" value="Искать">
		</form>
	</section>

</div>
<? 

#Чтение файла со статьями DOAJ_psy_journ.csv

if (($handle = fopen($_SERVER['DOCUMENT_ROOT']."/project/freecon/files/DOAJ_psy_journ.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num полей в строке $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}


?>

<div class="row">
	<div class="col-md-12">
		<h2 class="maintitle"><img width="100px" src="/project/freecon/files/science_lavr.png"  title="Научные журналы с открытыми статьями" class="imgmiddle"><?  
		if($_REQUEST['search_in']=='tags'){ echo $search_string;}
		elseif(!$_REQUEST['search_in'] and $search_string){
			$sw_arr=explode(" ",$search_string);
			echo 'Поиск по '.StringPlural::Plural(count($sw_arr), array('слову', 'словам', 'словам')).' "'.$search_string.'"';
			
			}
		else {?>Все журналы в одной ленте <?}

		?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('журнал', 'журнала', 'журналов'));
		?>]</h2>
	</div>
</div>


<?
# Блоки с item

?><div class="row vp_block_row"><?

$item_line_count=0;
$item_on_page=0;//счетчик item на страничке

while($item_info=mysql_fetch_array($item_info_req)){

	$item_line_count++;
	$item_on_page++;
	
	if($item_line_count==1) $item_line_need=rand(3,5); //генерируем число item в строке
	
	if($item_on_page<=$artclspage_cnt){?>
		<div class="col col-md <?if($item_line_count!==1){?>col-md-offset-1-my<?}?> vp_block">
			
			<span>
			<?
			$humdate=date_to_hum_read(strtotime ($item_info['creation_date']));
			if(mb_strstr($humdate,'в 00:00')) echo mb_substr($humdate,0,-7);
			else echo $humdate;?>
			</span>
			<a target="_blank"
			title="Смотреть статью: <?=$item_info['pagetitle_'.$language]?>"
			href="/?page=<?=$item_info['page']?>"
			onclick="yandex_target('CTATbR_from_CTATbu');return true;"
			><img src="<?=$item_info['page_img']?>" width="100%" class="thumbnail art_img"></a>
			
			<div class="caption">
				<h4 class="video_title" title="Смотреть статью: <?=$item_info['pagetitle_'.$language]?>">
				<a class="video_title" style="font-size:<?
				if(!$item_info['page_img']) echo "30";else echo "18";
				?>px" href="/?page=<?=$item_info['page']?>" target="_blank" onclick="yandex_target('CTATbR_from_CTATbu');return true;";><?=$item_info['pagetitle_'.$language];?></a><? /* <img style="object-fit: cover" class="on_hover_morph full-rounded"src="<?=$item_info['user_photo']?>" height="20px">*/?></h4>
				<!--p><a href="" class="yt-user-name" title="Подробнее об авторе - <?=$item_info['autor']?>"><?=$item_info['autor']?></a></p-->
			</div>
		</div>
<?		if ($item_line_count==$item_line_need){ // Смена строки
			$general_line_count++; // Общий счётчик выведенных линий с блоками
			?></div><div class="row vp_block_row"><?
			
			if($yandex_rsya_en=="Включена реклама РСЯ"){
				#Реклама яндекс РСЯ	
				if($general_line_count == 2){?>
					<!-- Yandex.RTB R-A-279803-1 -->
					<div id="yandex_rtb_R-A-279803-1"></div>
					<script type="text/javascript">
						(function(w, d, n, s, t) {
							w[n] = w[n] || [];
							w[n].push(function() {
								Ya.Context.AdvManager.render({
									blockId: "R-A-279803-1",
									renderTo: "yandex_rtb_R-A-279803-1",
									async: true
								});
							});
							t = d.getElementsByTagName("script")[0];
							s = d.createElement("script");
							s.type = "text/javascript";
							s.src = "//an.yandex.ru/system/context.js";
							s.async = true;
							t.parentNode.insertBefore(s, t);
						})(this, this.document, "yandexContextAsyncCallbacks");
					</script>
					</div><div class="row vp_block_row">
			<?	} elseif($general_line_count == 5){?><!-- Yandex.RTB R-A-279803-2 -->
					<div id="yandex_rtb_R-A-279803-2"></div>
					<script type="text/javascript">
						(function(w, d, n, s, t) {
							w[n] = w[n] || [];
							w[n].push(function() {
								Ya.Context.AdvManager.render({
									blockId: "R-A-279803-2",
									renderTo: "yandex_rtb_R-A-279803-2",
									async: true
								});
							});
							t = d.getElementsByTagName("script")[0];
							s = d.createElement("script");
							s.type = "text/javascript";
							s.src = "//an.yandex.ru/system/context.js";
							s.async = true;
							t.parentNode.insertBefore(s, t);
						})(this, this.document, "yandexContextAsyncCallbacks");
					</script><?
				}
			}
			$item_line_count=0;
		}
	}
}
?>
</div>
<!-- // Статьи -->
<?}?>