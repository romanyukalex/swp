<style>

.crop{
  float:left;
  overflow:hidden; /* this is important */
  }
</style>

<? 
$log->LogDebug('Got this file');
if ($nitka=="1"){
	
	$log->LogDebug('Got the following tags in this page config: '.$pagequery['tags']);
	#Парсим теги страницы
	if($pagequery['tags']) { #Есть теги к странице
	
		$page_tags_arr=explode(";",$pagequery['tags']);
		if(count($page_tags_arr)>1) {#Несколько тегов у страницы
			
			foreach($page_tags_arr as $tag){
				$tag_q.=" or `tags` LIKE '%$tag%' or `pagetitle_ru` LIKE '%$tag%'";
			}
			$tag_q="and (".mb_substr($tag_q,4).")";
		} elseif(count($page_tags_arr)==1){#Всего 1 тег
			$log->LogDebug('Got 1 tag - '.$page_tags_arr[0]);
			$tag_q="and (`tags` LIKE '%".$page_tags_arr[0]."%' or `pagetitle_ru` LIKE '%".$page_tags_arr[0]."%')";
		}
		
		$articles_data_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `is_articles`='1' $tag_q ORDER BY `viewCount` DESC LIMIT 0,15;");
		$log->LogDebug("Got few tag - ".mysql_num_rows($articles_data_q)." results");
	} else {//нет тегов,
		$log->LogInfo('No page tags');
		
		#Ищем item с тамими же словами
		$pt_words_arr=explode(" ",$pagequery['pagetitle_ru']);
		
		foreach($pt_words_arr as $pt_word){
			if(strlen($pt_word)>5){//Длинные слова включаем в массив запроса
				$tag_q.=" or `tags` LIKE '%$pt_word%' or `pagetitle_ru` LIKE '%$pt_word%'";
			}
		}
		$tag_q="and (".mb_substr($tag_q,4).")";//Обрезаем первые
		$articles_data_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `is_articles`='1' $tag_q ORDER BY `viewCount` DESC LIMIT 0,15;");
		
		
		if(mysql_num_rows($articles_data_q)==0){# Значит в названии такие слова, что по ним ничего не найдешь. Показываем просто первые статьи за сегодня
			$articles_data_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `is_articles`='1' ORDER BY `viewCount` DESC LIMIT 0,15;");
		}
	}
	#Если есть что показать (уж должно быть)
	if(mysql_num_rows($articles_data_q)>0){
	?>
		<div class="row  flex-items-md-center">
			<h4 style="font-weight: bold;">Рекомендуем Вам похожие статьи:</h4><br>
		</div>
		<div class="row  flex-items-md-center">	
	<?	$link_counter=0; //Счетчик выведенных ссылок на статьи
		while($item_info=mysql_fetch_array($articles_data_q)){
			$log->LogDebug("Take ".$item_info['page']." page");
			if($page!==$item_info['page']){
					
				$link_counter++;?>
				<div class="col col-md-2 <?if($item_line_count!==1){?>col-md-offset-1-my<?}?> vp_block ">

					<a target="_blank" 
					title="Смотреть статью: <?=strip_tags($item_info['pagetitle_'.$language])?>"
					href="https://soznanie.club/?page=<?=$item_info['page']?>" onclick="yandex_target('CTATbR_from_related');return true;" 
					class="crop">
					<? if(!strstr($item_info['page_img'],"selfgrow") and $item_info['page_img']){
						#Получаем размер изображения
						$img_size = getimagesize ($item_info['page_img']);
						?>
					<img src="<?=$item_info['page_img']?>" width="100%" 
					<? #Отрежем картинку, если она больше стандарта
					if($img_size[1]>460){
						#Вычисляем процент?>
						style="margin:0px 0px -<?//=2*($img_size[1]-460);?>px 0px;" 
					<? }?>
					class="thumbnail art_img"><?}?></a>
					
					<div class="caption">
						<h4 class="video_title" 
						title="Смотреть статью: <?=strip_tags($item_info['pagetitle_'.$language])?>">
						<a class="video_title hvr-pulse-shrink" href="https://soznanie.club/?page=<?=$item_info['page']?>" target="_blank" ><?=$item_info['pagetitle_'.$language];?></a></h4>
						
					</div>
				</div>
			<?	
			}
			
			if($link_counter==15) break; //Если ссылок более 15, останавливаем вывод, остальные в догонялку
		}
		mysql_data_seek($articles_data_q,0);		
	?></div>
	<!-- Догонялка -->
	<script>
	$(document).bind("mouseleave", function(e) {
		if (e.pageY - $(window).scrollTop() <= 1) {    
			$('#BeforeYouLeaveDiv').modal('show');
		}
	});
	</script>
	
	
<div class="modal fade" id="BeforeYouLeaveDiv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#BeforeYouLeaveDiv').attr('id','BeforeYouLeaveDiv_hid');" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Вас может заинтересовать</h4></span>
      </div>
      <div class="modal-body">
		<div class="row" style="padding:0 10px">
	  <? $link_counter=0; //Счетчик выведенных ссылок на статьи
		while($item_info=mysql_fetch_array($articles_data_q)){//Продолжим выдачу лучшего
		
			if($page!==$item_info['page']){
					
				$link_counter++;?>
				<div class="col col-md-4 vp_block" style="box-shadow:none">

					<a target="_blank" 
					title="Смотреть статью: <?=$item_info['pagetitle_'.$language]?>"
					href="https://soznanie.club/?page=<?=$item_info['page']?>" onclick="yandex_target('CTATbR_from_related');return true;" 
					class="crop">
					<? if(!strstr($item_info['page_img'],"selfgrow")){
						#Получаем размер изображения
						$img_size = getimagesize ($item_info['page_img']);
						?>
					<img src="<?=$item_info['page_img']?>" width="100%" 
					<? #Отрежем картинку, если она больше стандарта
					if($img_size[1]>460){
						#Вычисляем процент?>
						style="margin:0px 0px -<?//=2*($img_size[1]-460);?>px 0px;" 
					<? }?>
					class="thumbnail art_img"><?}?></a>
					
					<div class="caption">
						<h4 class="video_title" 
						title="Смотреть статью: <?=$item_info['pagetitle_'.$language]?>">
						<a class="video_title hvr-pulse-shrink" style="font-size:<?
						if(!$item_info['page_img']) echo "30";else echo "18";
						?>px" href="https://soznanie.club/?page=<?=$item_info['page']?>" target="_blank" ><?=$item_info['pagetitle_'.$language];?></a></h4>
						
					</div>
				</div>
			<?	
			}
			if($link_counter==3) break; //Если ссылок более 3
		}?>
		</div>
      </div>
    </div>
  </div>
</div>
	
	
	
	
	<?
	}
}?> 