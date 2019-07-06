<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){	
	insert_function("StringPlural");?>
<script>
function setLocation(curLoc){
    try {
      history.pushState(null, null, curLoc);
      return;
    } catch(e) {}
    location.hash = '#' + curLoc;
}
function put_video_det_modal(yt_id,yt_title,v_author,v_tags){
	shut_music();
	$('#yt_link').attr("src",'//www.youtube.com/embed/'+yt_id);
	$('#yt_link_xs').attr("src",'//www.youtube.com/embed/'+yt_id);
	$("#yt_descr<? if($userrole=="admin" or $userrole=="root"){?>_ta<?}?>").load('/core/ajaxapi.php?',{action:'get_v_descript',ytid:yt_id,mod:"project_script"});
	$('#myModalLabel').text(yt_title);
	$('#v_title').text(yt_title);
	$('#v_title').attr("href",'/?page=video&vid='+yt_id+'&from=all_vid');
	$('#v_author').text(v_author);
	$('#v_tags').text(' ');
	<? if($userrole=="admin" or $userrole=="root"){?>
	$('#yt_api_link').attr("href",'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+yt_id+'&key=<?=$yt_api_key;?>');
	<? }?>
	var tags = v_tags.split(';');
	tags.forEach(function(tag, i, tags) {
		if(tag)	$('#v_tags').append("<a href='/?page=videos&search_string="+tag+"'>"+tag+"</a>");
	});
	$('#v_tags').append("<br>");
	$('#modal_yt_id').attr("yt_id",yt_id);
	$('#moderate_ap').text(' ');
	yandex_target("video_1showOnAllVidPage");
	
	//Проверим видео на доступность
	$.getJSON('https://noembed.com/embed',
		{format: 'json', url: 'https://www.youtube.com/watch?v=' + yt_id}, function (data) {
		if(data.title === undefined) { //Видео не доступно
			ajax_rq ('project_script','video_unavailable','unavailable_ap','unavailable_ap',yt_id);
			$(".hide_if_unavail").hide();
		}
	});
	
}
function stop_video(){
	$('#yt_link').attr("src",'//www.youtube.com/embed/');
}
function change_ch_group(action,c_id,group_id){
	$('#ch_ap_'+c_id).load('/core/ajaxapi.php?',{action:action,c_id:c_id,group_id:group_id,mod:"project_script"});
}
<? if($userrole=="admin" or $userrole=="root"){# скрипты админов?>
function moderate_video(reaction,yt_id_g){
	
	if (yt_id_g == undefined) {
		var yt_id=$('#modal_yt_id').attr("yt_id");
		$("#moderate_ap").load('/core/ajaxapi.php?',{action:'moderate_video',ytid:yt_id,reaction:reaction,mod:"project_script"});
				
	} else {
		var yt_id=yt_id_g;
		$("#vp_block_"+yt_id+'_ap').load('/core/ajaxapi.php?',{action:'moderate_video',ytid:yt_id,reaction:reaction,mod:"project_script"});
	}
	window.setTimeout(function(){
			var ans_text=$("#moderate_ap").html();
			$("#vp_block_"+yt_id+'_ap').text(ans_text);
			$("#vp_block_"+yt_id).addClass('bcgr_light_yell');
			 //alert(ans_text);
		},1000);
	if(reaction=='publish_soc'){
		$("#vp_block_"+yt_id+'_soc_ap').load('/core/ajaxapi.php?',{action:'video.save',ytid:yt_id,group_id:'<?=$vk_group_id?>',mod:'vk-api'});
	}
}

<?}?>
</script>






<? if(!$_SESSION['show_v_s_banner']){?>
<div class="row flex-items-md-center">

	<div class="blockquote">
		
			<p>
				Вы можете <a href="" data-toggle="modal" data-target="#add_video_modal" class="justlink">добавить полезное видео</a> в коллекцию и оно появится в ленте всех подписчиков. <? if(!$_SESSION['log']) {?>Для этого - <a href="" data-toggle="modal" data-target="#auth_modal"class="justlink">войди на портал</a><?}?>
			</p>
			<small>Команда <?if($ps){?>Psy-space<?}elseif($sclub){?>soznanie.club<?}?></small>
		
	</div>


</div>
<? $_SESSION['show_v_s_banner']=1;
}
?><div class="row">
<div class="col-md-1">
	<a href="javascript:history.back();" class="justlink" title="Назад"><i class="fas fa-undo-alt"></i></a>
</div>
<section class="col-md-11">
	<form id="search_form" action="/?page=videos_srch">Поиск видеозаписей
		<input type="hidden" name="page" value="videos_srch">
		<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска видеозаписей" class="biginput" style="width:50%" value="<? 
		if($_REQUEST['search_string'] and $_REQUEST['search_in']!=='tags'){echo $_REQUEST['search_string'];}?>">
		<a class="button large" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
	</form>
</div>
<?

# Фильтр видеозиписей:
if($_REQUEST['group']) {
	insert_function("process_user_data");
	$group=process_data($_REQUEST['group'],20);
	
	$video_info_qt="FROM `$tableprefix-videos` v,`$tableprefix-video-channels` ch,`$tableprefix-users-grouprights` gr,`freecon-users-groups` g WHERE ch.`c_id`=v.`ch_id` and ch.`c_id`= gr.`oid`  and g.`group_id`=gr.`group_id` and  g.`groupname`='$group' and";
	
} else {
	$video_info_qt="FROM `$tableprefix-videos` WHERE";
}
if($_REQUEST['searchby']=="channel"){
	$need_ch_id=process_data($_REQUEST['ch_id'],20);
	$video_info_qt.=" `ch_id`='$need_ch_id' and ";
}
if($_REQUEST['search_string']){#Поиск по словам
	$qw_num=0;//Количество условий для выбора
	
	$s_words_arr=explode(" ",process_user_data($_REQUEST['search_string'],100));
	if($_REQUEST['search_in']=='vdesc' or !$_REQUEST['search_in']){	# В описании видео
		$video_info_qt_exp.='(';
		foreach($s_words_arr as $s_word){
			$video_info_qt_exp.="`v_full_desc` like '%$s_word%' and ";
		}
		$video_info_qt_exp=substr($video_info_qt_exp,0,-4).')';
		$qw_num++;
	}
	if($_REQUEST['search_in']=='vtitle' or !$_REQUEST['search_in']){ # В названии видео
		if($qw_num!==0) $video_info_qt_exp.=' or ';
		$video_info_qt_exp.='(';
		
		foreach($s_words_arr as $s_word){
			$video_info_qt_exp.="`vtitle` like '%$s_word%' and ";
		}
		$video_info_qt_exp=substr($video_info_qt_exp,0,-4).')';
		$qw_num++;
	}
	
	if($_REQUEST['search_in']=='vauthor' or !$_REQUEST['search_in']){ # В названии автора
		if($qw_num!==0) $video_info_qt_exp.=' or ';
		$video_info_qt_exp.='(';
		
		foreach($s_words_arr as $s_word){
			$video_info_qt_exp.="`autor` like '%$s_word%' and ";
		}
		$video_info_qt_exp=substr($video_info_qt_exp,0,-4).')';
		$qw_num++;
	}
	if($_REQUEST['search_in']=='tags' or !$_REQUEST['search_in']){ # В тегах
		if($qw_num!==0) $video_info_qt_exp.=' or ';
		$video_info_qt_exp.='(';
		
		foreach($s_words_arr as $s_word){
			$video_info_qt_exp.="`tags` like '%$s_word%' and ";
		}
		$video_info_qt_exp=substr($video_info_qt_exp,0,-4).')';
		$qw_num++;
	}
	if($qw_num>1) $video_info_qt_exp='('.$video_info_qt_exp.')';
	
	$log->LogInfo('No products found. IN EXT - '.$video_info_qt_exp.' IN QT - '.$video_info_qt);
	$video_info_qt=$video_info_qt.$video_info_qt_exp.' AND';

} else { //ничего не ищут, надо будет добавить первым видео с канала клуба
	
}





# Видео для пользователей

$item_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as ITEM_COUNT ".$video_info_qt." `vstatus`='active';"));//Количество записей по нужному запросу

#Пагинатор (расчёт)
$page_num = process_data($_GET['page_num'],5); // Извлекаем из URL текущую страницу
$total_pages_count = intval(($item_count['ITEM_COUNT'] - 1) / $artclspage_cnt) + 1;
//echo $item_count['ITEM_COUNT'];
if(empty($page_num) or $page_num < 0 or $page_num > $total_pages_count) $page_num = $total_pages_count; // Если значение $page_num не сущ, меньше единицы или отрицательно, переходим на первую страницу 

// Стартовая страница
$start_page_q = ($total_pages_count- $page_num) * $artclspage_cnt;

#Запрос данных в БД
$video_info_req=mysql_query("SELECT * ".$video_info_qt." `vstatus`='active' ORDER BY `yt_publishedAt` DESC LIMIT $start_page_q,$videopage_vcnt;");

if($item_count['ITEM_COUNT']>0) $log->LogInfo('Got '.$item_count['ITEM_COUNT'].' ACTIVE videos');
else $log->LogError('No ACTIVE videos found. Query was SELECT * '.$video_info_qt." `vstatus`='active' ORDER BY `yt_publishedAt` DESC LIMIT 0,$videopage_vcnt;");?>

<div class="row">
	<div class="col-md-12">
		<h2 class="maintitle"><img width="60px" src="/project/freecon/files/ape_nosee.jpg"  title="Не пускай зло в сознание через глаза (яп.символ)" class="imgmiddle"><?  
		if($_REQUEST['group']) {?>Видео тематики <?=$_REQUEST['group'];}
		elseif($_REQUEST['searchby']=="channel" and $need_ch_id){
			
			$ch_detail=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-video-channels` WHERE `c_id`='$need_ch_id';"));
			
			if($ch_detail['yt_c_name']) echo 'Все видео "'.$ch_detail['yt_c_name'].'"';
			
		}
		elseif($_REQUEST['search_in']=='tags'){ echo $_REQUEST['search_string'];}
		elseif(!$_REQUEST['search_in'] and $_REQUEST['search_string']){
			$sw_arr=explode(" ",$_REQUEST['search_string']);
			echo 'Поиск по '.StringPlural::Plural(count($sw_arr), array('слову', 'словам', 'словам')).' "'.$_REQUEST['search_string'].'"';
			
			}
		else {?>Видео всех разделов <?}

		?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('ролик', 'ролика', 'роликов'));
		?>]</h2>
	</div>
</div>
<? #Подразделы (теги)
if($_REQUEST['search_in']=='tags'){#Показываем подразделы
	$sub_titles=array(
	
		'Личностное развитие'=>array(
			'Работа над собой','Здоровье','Духовное развитие','Деньги','Цели','Полезные навыки','Ораторское искусство','Управление и лидерство','Вредные привычки','Тайм-менеджмент','Уверенность в себе','Невербальная коммуникация','Мотивация','Выход из кризиса','Карьера','Бизнес','Управление эмоциями','Харизма и энергетика'
		),
		'Успешный мужчина'=>array(
			'Мужское предназначение','Ключевые навыки успешного мужчины'
		),
		'Счастливая женщина'=>array(
			'Женский бизнес','Женское предназначение'
		),
		'Психология для профи'=>array(
			'Психосоматика','НЛП','Эриксоновский гипноз','Метафорические карты','Позитивная психология','Визуализация','Психоанализ','Краткосрочная терапия','Коучинг',
			'Провокативная терапия','Системно-векторная психология','Расстановки','Арт-терапия','РПТ','Гештальт терапия','Human design - дизайн человека','Соционика',
			'Психотерапия','Сексология'
		)
		
	);
	if($sub_titles[$_REQUEST['search_string']]) {
		?><div class="row" id='sub_tags'>
		<div class="col-md-12">
		<?
		foreach($sub_titles[$_REQUEST['search_string']] as $tag_link){
			//echo $tag_link;
			?><a href='/?page=<?=$page?>&search_string=<?=$tag_link?>&search_in=tags' class="bcgr_grey"><?=$tag_link?></a><?
		}
		?><br><br></div></div><?
	}
}

# Дисклеймер к разделу
if($_REQUEST['searchby']=="channel" and $need_ch_id){
	?>
<div class="row">

	<div class="blockquote" style="margin-left:20px">
		
			<p>
				<?=str_replace("\n", "<br>",$ch_detail['c_desc']);?> 
			</p>
			<small><?=$ch_detail['yt_c_name']?></small>
		
	</div>
</div><?
}


#Выводим Пагинатор
if($total_pages_count>1){?>
<div class="row">
	<div class="col-md-10"><?
	//Определяем базовый URI
	foreach ($_GET as $getparam_key => $getparam_value){
		if($getparam_key!=="page_num"){
			$pgntr_base_uri.=$getparam_key.'='.$getparam_value.'&';
		}
	}
	
	// Проверяем нужны ли стрелки назад 
	if ($page_num != 1) $pervpage = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1"><i class="fas fa-step-backward"></i></a> 
		<a title="Предыдущие '.$videopage_vcnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'"><i class="fas fa-caret-left"></i></a> '; 
	// Проверяем нужны ли стрелки вперед 
	if ($page_num != $total_pages_count) $nextpage = ' <a title="Следующие '.$videopage_vcnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><i class="fas fa-caret-right"></i></a> 
	<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><i class="fas fa-step-forward"></i></a>'; 

	// Находим две ближайшие станицы с обоих краев, если они есть 
	if($page_num - 2 > 0) $page2left = ' <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 2) .'">'. ($page_num - 2) .'</a> | '; 
	if($page_num - 1 > 0) $page1left = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 1) .'">'. ($page_num - 1) .'</a> | '; 
	if($page_num + 2 <=$total_pages_count) $page2right = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 2) .'">'. ($page_num + 2) .'</a>'; 
	if($page_num + 1 <=$total_pages_count) $page1right = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'">'. ($page_num + 1) .'</a>'; 

	// Вывод меню 
	echo $pervpage.$page2left.$page1left.'<b>'.$page_num.'</b>'.$page1right.$page2right.$nextpage;
	?></div>
</div><?
}

# Блоки с видосами

?><div class="row vp_block_row"><?

$video_line_count=0;
$video_on_page=0;//счетчик видео на страничке
insert_function("date_to_hum_read"); //Функция представления даты в человеч читаемом виде
insert_function("youTubeVideoExists");//Функция проверки доступности видео на YT без API
while($video_info=mysql_fetch_array($video_info_req)){

	/*
	if($pagequery['cache_time'] and $pagequery['cache_time']!=="0"){#Проверяем доступность видео (если включено кеширование)
		//if(!youTubeVideoExists($video_info['yt_id'])){ //Видео больше недоступно, надо его удалить
		//if(!insert_module("youtube-api","check_video_avail",$video_info['yt_id'])){ //Видео больше недоступно, надо его удалить (чет все удаляет...)
			$log->LogDebug("Try to delete video");
			//mysql_query("DELETE FROM `$tableprefix-videos` WHERE `yt_id` = '".$video_info['yt_id']."';");
			//continue;
		//}
	}
	*/
	
	$video_line_count++;
	$video_on_page++;
	if($video_on_page<=$videopage_vcnt){?>
		<div class="col col-md <?if($video_line_count!==1){?>col-md-offset-1-my<?}?> vp_block ">
			<span><?=date_to_hum_read(strtotime ($video_info['yt_publishedAt']));?></span>  
			
			<a data-toggle="modal" data-target="#myModal" onclick="put_video_det_modal('<?=$video_info['yt_id']?>','<?=$video_info['vtitle']?>','<?=$video_info['autor']?>','<?=substr($video_info['tags'],0,-1)?>');return false;" title="Смотреть видео: <?=$video_info['vtitle']?>"><img src="//img.youtube.com/vi/<?=$video_info['yt_id']?>/0.jpg" width="100%" class="thumbnail"></a>
			
			<div class="caption">
				<h4 class="video_title hvr-pulse-shrink" data-toggle="modal" data-target="#myModal" onclick="put_video_det_modal('<?=$video_info['yt_id']?>','<?=$video_info['vtitle']?>','<?=$video_info['autor']?>','<?=substr($video_info['tags'],0,-1)?>');return false;" title="Смотреть видео: <?=$video_info['vtitle']?>">
				<?=mb_substr($video_info['vtitle'],0,70);?><a href="/?page=<?=$video_info['yt_id']?>" style="color:#FFF">.</a></h4>
				<p><a href="/?page=videos&searchby=channel&ch_id=<?=$video_info['ch_id']?>" class="yt-user-name hvr-wobble-vertical" title="Подробнее об авторе - <?=$video_info['autor']?>"><?=$video_info['autor']?></a></p>
			</div>
		</div>
<?		if ($video_line_count==5){ // Смена строки
			?></div><div class="row vp_block_row"><?
			$general_line_count++;// Общий счётчик выведенных линий с блоками
			
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
			<? 	} elseif($general_line_count == 5){?><!-- Yandex.RTB R-A-279803-2 -->
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
			$video_line_count=0;
		}
	}

}
?>

</div><!-- // Видеоролики -->

<?  # Вывод нижнего пагинатора?>
<div class="row"><div class="col-md-10"><?=$pervpage.$page2left.$page1left.'<b>'.$page_num.'</b>'.$page1right.$page2right.$nextpage;?></div></div>



<!-- Modal for all videos -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bcgr_blue">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"onclick="stop_video()">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Название видео</h4></span>
      </div>
      <div class="modal-body">
        
		 <!--iframe id="yt_link" width="560" class="hidden-xs" height="315" src="" frameborder="0" allowfullscreen></iframe>
		 <iframe id="yt_link_xs" class="visible-xs"  src="" frameborder="0" allowfullscreen></iframe-->
		 <span id="unavailable_ap"></span>
		 <iframe id="yt_link" width="560" class="hidden-sm-down hide_if_unavail" height="315" src="" frameborder="0" allowfullscreen></iframe>
		 <iframe id="yt_link_xs" class="hidden-md-up hide_if_unavail"  src="" frameborder="0" allowfullscreen></iframe>
		
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

<!-- Modal for adding videos -->
<div class="modal fade" id="add_video_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Добавить новое видео</h4></span>
      </div>
      <div class="modal-body">
	  <div id="addvideo_ap"></div>
	  Вставьте ссылку на видео YouTube <br><br>
    	<form id="new_yt_v_form">
		<input name="new_yt_v_id" id="new_yt_v_id" class="biginput" style="width:75%" placeholder="www.youtube.com/watch?v=pulvWJxTn5w">
		</form><br>
		<a class="button" href="" onclick="saveform3('','new_yt_v_form','addvideo_ap','addvideo_ap','project_script','add_new_video','resetform','nohide');return false;">Отправить</a>
      </div>
    </div>
  </div>
</div>

<?
}//nitka?>