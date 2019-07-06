<? $log->LogInfo('Got this file');
if($nitka=='1'){

if(!$video_id) $video_id=process_data($_REQUEST['vid'],12);
if(!$video_info) $video_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `vstatus`='active' and `yt_id`='".$video_id."' LIMIT 0,1;"));

if($video_info['yt_id']){?>
<script>
$(window).on('load',function(){
	   yandex_target("video_page_opened"); //Фиксируем открытие страницы в Яндекс.Метрика
});

var video_id='<?=$video_info['yt_id']?>';

var url = 'https://www.youtube.com/watch?v=' + video_id;

$.getJSON('https://noembed.com/embed',
    {format: 'json', url: url}, function (data) {
    console.log(data.title);
	if(data.title === undefined) { //Видео не доступно
		ajax_rq ('project_script','video_unavailable','unavailable_ap','unavailable_ap','<?=$video_info['yt_id']?>');
		$(".hide_if_unavail").hide();
	}
});
		
		
</script>

<div class="row flex-items-md-center articleBody_text" style="margin-top:20px">
	 <span id="unavailable_ap"></span>
	<div class="col-md-up  hidden-xs-down">
       
		<iframe id="yt_link" class="hide_if_unavail" width="560" height="315" src="//www.youtube.com/embed/<?=$video_info['yt_id']?>?rel=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
	
	</div>
	<div class="col-md-up  hidden-sm-up">
        
		<iframe id="yt_link" class="hide_if_unavail" width="110%" src="//www.youtube.com/embed/<?=$video_info['yt_id']?>?rel=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
	
	</div>

	<div class="col-md-up" class="hide_if_unavail" style="margin-left:10px">Опубликовано: <?=substr($video_info['yt_publishedAt'],0,10)?><br>
	<?if($pagequery['viewCount'] and $pagequery['viewCount']!==0) {
		?>Просмотров: <?=$pagequery['viewCount'];?><img src="/files/eye_grey.png" width="25px" class="imgmiddle" title="Статью посмотрели <?=$pagequery['viewCount']?> раз"/><br><?
	}?>
	Автор видео:<br><a href="/?page=videos&searchby=channel&ch_id=<?=$video_info['ch_id']?>" class="justlink" title="Все видео этого автора на сайте"><?=$video_info['autor'];?></a>
	
	<? // Кто запостил сюда?>
	<br>Поделиться: <script src="https://yastatic.net/share2/share.js" async="async"></script>
		<div class="ya-share2" data-services="vkontakte,twitter,facebook,gplus,odnoklassniki,skype" data-counter></div>
		<div class="ya-share2 hidden-md-up" data-services="telegram,viber,whatsapp" data-counter></div>
		
		<br>Сохранить:
			<div class="ya-share2" data-services="collections,blogger,delicious,evernote" data-counter></div>

		
	</div>
</div>
<div class="row flex-items-md-center">
	<? if($userrole=="admin" or $userrole=="root"){# Кнопки для модерации?>
	<script>
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
			},1000);
		if(reaction=='publish_soc'){
			$("#vp_block_"+yt_id+'_ap').load('/core/ajaxapi.php?',{action:'video.save',ytid:yt_id,group_id:'<?=$vk_group_id?>',mod:'vk-api'});
		}
	}
	function delete_page(yt_id){
		$("#moderate_ap").load('/core/ajaxapi.php?',{action:'moderate_video',ytid:yt_id,reaction:'decline',mod:"project_script"});
		$("#moderate_ap").load('/core/ajaxapi.php?',{action:'delete_page',ytid:yt_id,mod:"project_script"});
	}
	</script>
		<div class="row"><div class="col col-md-4" id="moderate_ap"></div></div>
		<div class="row">
		
			<div class="col col-md-1"><a href="" onclick="delete_page('<?=$video_info['yt_id']?>');return false;" class="button red medium" style="background-color: #e62727; ">УДАЛИТЬ СТРАНИЦУ</a></div>
		</div>
		<div class="row">
			<div class="col col-md-6">
			<form id="ch_v_desc_form">
			<textarea id="yt_descr_ta" name='desc_text' cols=90 rows=30 onchange="showHideSelection('sv_but_f_ta_div');return false;"><?=$video_info['v_full_desc']?>
			</textarea>
			</form>
			</div>
			<div class="col col-md-1">
			<div id="sv_form_ap"></div>
			<div id="sv_but_f_ta_div" style="display: none"><a href="" onclick="saveform3('<?=$video_info['yt_id']?>', 'ch_v_desc_form','sv_form_ap','sv_form_ap','project_script','change_video_desc','noresetform','nohideform');return false;" class="button bcgr_green medium">СОХРАНИТЬ</a></div>
			</div>
		</div>
		
	<?}?>

</div>	
<div class="row flex-items-md-center">
	<div class="col col-md-12">
	<? #Делаем из тегов ссылки
	$tags_arr=explode(';',$video_info['tags']);
	foreach ($tags_arr as $tag){
		if($tag){
		?><a href="/?page=videos&search_string=<?=$tag?>" class="bcgr_grey tag_circle"><?=$tag?></a><?
		}
	}
	
	?>
	</div>
</div>
	
<div class="row flex-items-md-center">
	<div class="col col-md-12" id="yt_descr" style="font-family: ProximaNova Reg;font-style: normal;font-weight: normal;font-size: 18px;line-height: 26px;color: #555b5e;"><?
	
	$video_info['v_full_desc'] = str_replace("\n", "<br>", $video_info['v_full_desc']);
	echo $video_info['v_full_desc'];
	
	#Выводим комментарии
	include ($_SERVER['DOCUMENT_ROOT'].'/commenton/index.php'); 
	?>
	</div>
</div>
<div class="row flex-items-md-center">
	<div class="col col-md-12" style="font-family: ProximaNova Reg;font-style: normal;font-weight: normal;font-size: 18px;line-height: 26px;color: #555b5e;"><?
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/show_related_videos.php');
	?></div>
</div>

<?
}
}//nitka?>