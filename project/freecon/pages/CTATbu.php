<?
$log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){

insert_function("StringPlural");


if($_REQUEST['search_string']){#Поиск по словам
	$search_string=trim(process_data($_REQUEST['search_string'],200));
}?>


<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<a href="javascript:history.back();" class="justlink"title="Назад"><i class="fas fa-undo-alt"></i></a>
	</div>
	<section class="col-md-11">
		<form id="search_form" action="/?page=CTATbu_srch">Ищите то, что интересует
			<input type="hidden" name="page" value="CTATbu_srch">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $search_string;}?>">
			<a class="button large" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
		</form>
	</section>

</div>
<? // SELECT `autor`, count(*) FROM `freecon-pages` WHERE 1 GROUP BY `autor` - авторы и их статьи


# Статьи для пользователей

$fromwhere="FROM `$tableprefix-pages` WHERE `is_articles`='1'";
if($search_string) {
	
	if(mb_strstr($search_string," ")){ // Несколько слов в поиске
		
		$s_words_arr=explode(" ",$search_string);
		
		foreach($s_words_arr as $s_word){
				$fromwhere.="AND `pagetitle_ru` LIKE '%".$s_word."%'";
			}
		$video_info_qt_exp=substr($video_info_qt_exp,0,-4).')';
		$qw_num++;
	}
	else $fromwhere.="AND `pagetitle_ru` LIKE '%".$search_string."%'"; //Для 1 слова
	
	#Меняем порядок 
	$result_order="`viewCount` DESC,";
}

$item_count=mysql_fetch_array(mysql_query('SELECT COUNT(*) as ITEM_COUNT '.$fromwhere.';'));//Количество записей по нужному запросу


#Пагинатор (расчёт)
$page_num = process_data($_GET['page_num'],5); // Извлекаем из URL текущую страницу
$total_pages_count = intval(($item_count['ITEM_COUNT'] - 1) / $artclspage_cnt) + 1;

if(empty($page_num) or $page_num < 0 or $page_num > $total_pages_count) $page_num = $total_pages_count; // Если значение $page_num не сущ, меньше единицы или отрицательно, переходим на первую страницу 

// Стартовая страница
$start_page_q = ($total_pages_count- $page_num) * $artclspage_cnt;
#Запрос данных в БД
$item_info_req=mysql_query("SELECT * ".$fromwhere." and `status`='ena' ORDER BY $result_order `creation_date` DESC, `page_id` DESC LIMIT $start_page_q,$artclspage_cnt;");

if($item_count['ITEM_COUNT']>0) $log->LogInfo('Got '.$item_count['ITEM_COUNT'].' ACTIVE items');
else $log->LogError('No ACTIVE items found.');


### Вывод заголовка ###

?>

<div class="row">
	<div class="col-md-12">
		<h2 class="maintitle"><img width="60px" src="/project/freecon/files/ape_nosee.jpg"  title="Не пускай зло в сознание через глаза (яп.символ)" class="imgmiddle"><?  
		if($_REQUEST['search_in']=='tags'){ echo $search_string;}
		elseif(!$_REQUEST['search_in'] and $search_string){
			$sw_arr=explode(" ",$search_string);
			echo 'Поиск по '.StringPlural::Plural(count($sw_arr), array('слову', 'словам', 'словам')).' "'.$search_string.'"';
			
			}
		else {?>Все статьи в одной ленте <?}

		?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('статья', 'статьи', 'статей'));
		?>]</h2>
	</div>
</div>


<?
#Выводим Пагинатор
if($total_pages_count>1){?>
<div class="row">
	<div class="col-md-10"><?
	//Определяем базовый URI
	foreach ($_GET as $getparam_key => $getparam_value){
		if($getparam_key!=="page_num" and $getparam_key!=="yaads" and $getparam_key!=="yacat" and $getparam_key!=="vk" and $getparam_key!=="lp_type" and $getparam_key!=="goads" and $getparam_key!=="lang" and $getparam_value){
			$log->LogDebug("ADD ".$getparam_key.' with value '.$getparam_value);
			$pgntr_base_uri.=$getparam_key.'='.$getparam_value.'&';
		}
		
	}
	// Проверяем нужны ли стрелки назад 
	if ($page_num != $total_pages_count) $nextpage = '
	<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><i class="fas fa-step-backward"></i></a>
	<a title="Следующие '.$artclspage_cnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><i class="fas fa-caret-left"></i></a>'; 
	// Проверяем нужны ли стрелки вперед 
	
if ($page_num != 1) $pervpage = '
	<a title="Предыдущие '.$artclspage_cnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'"><i class="fas fa-caret-right"></i></a> 
	<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1"><i class="fas fa-step-forward"></i></a>'; 
								
	// Находим две ближайшие станицы с обоих краев, если они есть 
	if($page_num - 3 > 0) $page3left = ' |  <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 3) .'">'. ($page_num - 3) .'</a>'; 
	if($page_num - 2 > 0) $page2left = ' |  <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 2) .'">'. ($page_num - 2) .'</a>'; 
	if($page_num - 1 > 0) $page1left = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 1) .'">'. ($page_num - 1) .'</a>'; 
	
	if($page_num + 2 <=$total_pages_count) $page2right = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 2) .'">'. ($page_num + 2) .'</a> | '; 
	if($page_num + 1 <=$total_pages_count) $page1right = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'">'. ($page_num + 1) .'</a> | '; 
	if($page_num + 3 <=$total_pages_count) $page3right = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 3) .'">'. ($page_num + 3) .'</a> | '; 
	
	// Вывод меню 
	$paging_menu=$nextpage.$page3right.$page2right.$page1right.'<b>'.$page_num.'</b>'.$page1left.$page2left.$page3left.$pervpage;
	
	echo $paging_menu;
	?></div>
</div><?
}

# Блоки с item

?><div class="row vp_block_row"><?

$item_line_count=0;
$item_on_page=0;//счетчик item на страничке
insert_function("date_to_hum_read");
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
<?=$paging_menu;?>
<!-- // Статьи -->

<? /*
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bcgr_blue">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"onclick="stop_video()">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Название статьи</h4></span>
      </div>
      <div class="modal-body">
        
		 
		 <img id="img_link" width="560" class="hidden-sm-down" height="315" src="" frameborder="0">
		 <img id="img_link_xs" class="hidden-md-up"  src="" frameborder="0" allowfullscreen>
		
		<div class="row" style="margin-left: 0px;">
		<div id="v_tags"></div><br>
		</div>
		<? if($userrole=="admin" or $userrole=="root"){# Кнопки для модерации?>
		<div class="row flex-items-md-center">
			<div class="col col-md-6" id="moderate_ap"></div>
		</div>
		<div class="row flex-items-md-center">
			<div class="col-md-4 col-lg-4"><a href="" onclick="moderate_video('publish');return false;" class="button green medium">ОПУБЛИКОВАТЬ</a></div>
			<div class="col-md-4 col-lg-4"><a href="" onclick="moderate_video('decline');return false;" class="button red medium" style="background-color: #e62727; ">ОТКЛОНИТЬ</a></div>
			<div class="col-md-6 col-lg-6"><a id="yt_api_link" href="" target="_blank">YouTube API ответ</a></div>
		</div>
		<?}?>
		<div id="v_title_div"><a id="v_title" href="" class="justlink"></a></div>
		<div id="v_author"></div><br><br>
		<div id="yt_descr"></div>
		
		<div id="modal_yt_id" yt_id=""></div>
	
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        
      </div>
    </div>
  </div>
</div>
<? */}?>