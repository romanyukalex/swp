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
	$('#yt_link').attr("src",'//www.youtube.com/embed/'+yt_id);
	$('#yt_link_xs').attr("src",'//www.youtube.com/embed/'+yt_id);
	$("#yt_descr<? if($userrole=="admin" or $userrole=="root"){?>_ta<?}?>").load('/core/ajaxapi.php?',{action:'get_v_descript',ytid:yt_id,mod:"project_script"});
	$('#myModalLabel').text(yt_title);
	$('#v_title').text(yt_title);
	$('#v_title').attr("href",'/?page='+yt_id);
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

$('.modal_close_button').on('touchstart click', function(){ stop_video(); }); //Хак чтобы останавливать видео при закрытии модального окна

<?}?>
</script>


<div class="row flex-items-md-center" style="margin:20px 0 10px">
<div class="col-md-1">
	<a href="javascript:history.back();" class="justlink">Назад</a>
</div>
<section class="col-md-11">
	<form id="search_form" action="/?page=videos">Поиск видеозаписей
		<input type="hidden" name="page" value="videos">
		<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска видеозаписей" class="biginput" style="width:50%" value="<? 
		if($_REQUEST['search_string'] and $_REQUEST['search_in']!=='tags'){echo $_REQUEST['search_string'];}?>">
		<!--input type="submit" class="button medium green" style="height:38px;padding-top:10px" value="Искать"-->
		<a class="button medium" style="height:38px;padding-top:10px;color:white;background-color:  #36cdb6;">Искать</a>
	</form>
</section>
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

}
#Управление каналами

if($userrole=="admin" or $userrole=="root"){?>

<div class="row flex-items-md-center" style="margin-left:10px;margin-right:0px;">
	<div class="col-md-8 col-lg-8">
	<h2 class="maintitle">Управление каналами</h2>
	<? $chs_det_q=mysql_query("SELECT * FROM `$tableprefix-video-channels` WHERE 1 ORDER by `c_id` DESC;");
	?>Всего на мониторинге <b><?=mysql_num_rows($chs_det_q)?></b> <?=(StringPlural::Plural(mysql_num_rows($chs_det_q), array('канал', 'канала', 'каналов')));?><br><br>
	
	<a href="" id="v_ad_form_link" onclick="showHideSelectionSoft('v_ad_form_div',1000);showHideSelectionSoft('v_ad_form_link',1000);return false;">Добавить видео, канал или плейлист на мониторинг</a>
	<div id="v_ad_form_div" style="display: none">
	<b>Добавить видео, канал или плейлист на мониторинг</b>
	
	<br>Вставьте ссылку на видео YouTube <br><br>
		<div id="addvideo_ap"></div>
    	<form id="new_yt_v_form">
		<input name="new_yt_v_id" id="new_yt_v_id" class="biginput" style="width:50%" placeholder="www.youtube.com/watch?v=pulvWJxTn5w"><br>
		<input name="auto_apply" type="checkbox">Авто-подтверждение видео
		</form><a class="button" href="" onclick="saveform3('','new_yt_v_form','addvideo_ap','addvideo_ap','project_script','add_new_video','resetform','nohide');return false;">Отправить</a>
	
		<br><br>
		<div id="add_ch_ap"></div>
		<form id="new_yt_c_form">Вставь ссылку на видео-канал Youtube<br><br>
		<input name="new_yt_с_id" id="new_yt_с_id" placeholder="https://www.youtube.com/channel/UCdFMTlYR0uAt_le94p3c8WA" class="biginput" style="width:50%"><br> <input name="new_yt_с_AutoApply" type="checkbox">Авто-подтверждение всех видео этого канала
		</form>
		<a class="button" href="" onclick="saveform3('','new_yt_c_form','add_ch_ap','add_ch_ap','project_script','add_new_channel','noresetform','nohide');return false;">Отправить</a>	
		
		<br><br>
		<div id="add_pl_ap"></div>
		<form id="new_yt_pl_form">Вставь ссылку на плейлист <? //либо несколько плейлистов одного канала через ";"?><br><br>
		<input name="new_yt_pl_id" id="new_yt_pl_id" placeholder="https://www.youtube.com/playlist?list=PLqSTFWHJscVfDacNWshZkU0KfVDbq0LdH" class="biginput" style="width:50%">
		<br> <input name="auto_apply" type="checkbox">Авто-подтверждение всех видео этого плейлиста
		</form>
		<a class="button" href="" onclick="saveform3('','new_yt_pl_form','add_pl_ap','add_pl_ap','project_script','add_new_playlist','resetform','nohide');return false;">Отправить</a>
		<br>
		
	</div>
	
	<br><a href="" id="c_man_form_link" onclick="showHideSelectionSoft('c_man_form_div',1000);showHideSelectionSoft('c_man_form_link',1000);return false;">Управление каналами на мониторинге</a>
	
	<div id="c_man_form_div" style="display: none">
	<b>Управление каналами на мониторинге</b>
	<? 
	#Аттрибуты групп каналов
	$gr_det_q=mysql_query("SELECT * FROM `$tableprefix-users-groups` WHERE `group_id` BETWEEN 6 AND 12;");
	
	while($chs_det=mysql_fetch_array($chs_det_q)){
		?><hr><a href="/?page=videos&searchby=channel&ch_id=<?=$chs_det['c_id']?>"><?=$chs_det['yt_c_name'];?></a> [<a target="_blank"href="https://www.youtube.com/channel/<?=$chs_det['yt_c_id']?>">YouTube</a>]
		 <? if($chs_det['playlists']) {?>[Только плейлист <a target="_blank" href="https://www.youtube.com/playlist?list=<?=$chs_det['playlists']?>"><?=$chs_det['playlists']?></a>]<?}?><br>
		<div id="ch_ap_<?=$chs_det['c_id']?>"></div><?
		#В каких группах состоит канал
		$ch_gr_q=mysql_query("SELECT * FROM `$tableprefix-users-groups` ug, `$tableprefix-users-grouprights` gr WHERE gr.`oid`='".$chs_det['c_id']."' and gr.`group_id`=ug.`group_id`");
		
		while ($ch_gr=mysql_fetch_array($ch_gr_q)){
			?>Состоит в группе каналов - <?=$ch_gr['groupname'];?><a href="" onclick="change_ch_group('delete_ch_gr','<?=$chs_det['c_id']?>','<?=$ch_gr['group_id']?>');return false;">Удалить из группы каналов "<?=$ch_gr['groupname'];?>"</a><br>
			<?
		}
		while($gr_det=mysql_fetch_array($gr_det_q)){
			?><a href="" onclick="change_ch_group('add_ch_gr','<?=$chs_det['c_id']?>','<?=$gr_det['group_id']?>');return false;">Добавить в группу - <?=$gr_det['groupname']?></a><br>
		<?
		}
		?>
		<div id="c_desc_write_<?=$chs_det['c_id']?>_ap"></div>
		<form id="c_desc_write_<?=$chs_det['c_id']?>"><textarea name="desc_text" onclick="showHideSelection('sv_but_div_<?=$chs_det['c_id']?>');return false;" class="yt_descr_ta"><?=$chs_det['c_desc']?></textarea></form>
		<div id="sv_but_div_<?=$chs_det['c_id']?>" style="display: none">
		<a class="moder_button bcgr_orange" href="" onclick="saveform3('<?=$chs_det['c_id']?>','c_desc_write_<?=$chs_det['c_id']?>' ,'c_desc_write_<?=$chs_det['c_id']?>_ap','c_desc_write_<?=$chs_det['c_id']?>_ap','project_script','change_channel_desc','noresetform','nohide');return false;">Сохранить описание</a></div>
		<?
		mysql_data_seek($gr_det_q,0);
	}
	?>
	</div>
	</div>
</div>

<? 

$v_need_mod_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as NMCOUNT FROM `$tableprefix-videos` WHERE `vstatus`='need_moderate';"));
	
$video_info_req=mysql_query("SELECT * ".$video_info_qt." `vstatus`='need_moderate' ORDER BY `v_id` DESC LIMIT 0,100;");
$log->LogInfo('Got ['.mysql_num_rows($video_info_req).'] product(s) in list of NEED_MODERATE videos');?>
<div class="row flex-items-md-center" style="margin:0 0 30px 10px">
	<div class="col-md-12 col-lg-12">

<h2 class="maintitle">К модерации<?if($_REQUEST['searchby']=="channel" and $need_ch_id){?> этого канала<?}
	echo " ".$v_need_mod_stat_q['NMCOUNT'];
?> [на странице <?=mysql_num_rows($video_info_req);

echo(' '.StringPlural::Plural(mysql_num_rows($video_info_req), array('видеозапись', 'видеозаписи', 'видеозаписей')));?>]</h2>

</div>
<div class="row">
<?
insert_function("isDeviceMobile");
$is_mobile=isDeviceMobile();

if($is_mobile){?>
<style>
.vp_block{margin:0 30px 0 30px;}
</style><?}
$video_line_count=0;
while($video_info=mysql_fetch_array($video_info_req)){
	$video_line_count++;
	?>

		<div class="col col-md-2 <?if($video_line_count!==1){?>col-md-offset-1-my<?}?> vp_block" id="vp_block_<?=$video_info['yt_id']?>">
		<?=substr($video_info['yt_publishedAt'],0,10)?>  
			<a data-toggle="modal" data-target="#myModal1" onclick="put_video_det_modal('<?=$video_info['yt_id']?>','<?=$video_info['vtitle']?>','<?=$video_info['autor']?>','<?=$video_info['tags']?>');"><img src="//img.youtube.com/vi/<?=$video_info['yt_id']?>/0.jpg"  width="196" class="thumbnail"></a>
			<div class="caption">
				<span class="video_title"  data-toggle="modal" data-target="#myModal1" onclick="put_video_det_modal('<?=$video_info['yt_id']?>','<?=$video_info['vtitle']?>','<?=$video_info['autor']?>','<?=substr($video_info['tags'],0,-1)?>');return false;">
				<? if($prev_yt_id==$video_info['yt_id']){ //echo "ДУБЛЬ!";
					mysql_query("DELETE FROM `$tableprefix-videos` WHERE `yt_id`='".$video_info['yt_id']."';");
				}
				
				echo $video_info['vtitle'];?></span>
				
				<p><b><?=$video_info['autor']?></b></p>
				<div id="vp_block_<?=$video_info['yt_id']?>_ap"></div>
				<div id="vp_block_<?=$video_info['yt_id']?>_soc_ap"></div>
				<a href="" onclick="moderate_video('publish','<?=$video_info['yt_id']?>');return false;" class="green swp_button">Опубликовать</a>
				<a href="" onclick="moderate_video('publish_soc','<?=$video_info['yt_id']?>');return false;"
				class="blue swp_button">Опубл и в ВК</a><br>
				<a href="" onclick="moderate_video('decline','<?=$video_info['yt_id']?>');return false;" class="red swp_button">Отклонить</a>
			</div>
			<br>
		</div>
<?	if ((!$is_mobile and $video_line_count==5) or ($is_mobile and $video_line_count==3)){ // Смена строки
		?></div><div class="row"><?
		$video_line_count=0;
	}
	$prev_yt_id=$video_info['yt_id'];
}
?></div>

<?} ?>

<!-- // Видеоролики -->
</DIV>
<br><br><br><br><br><br>



<!-- Modal for all videos -->
<div class="modal fade bd-example-modal-lg" id="myModal1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bcgr_blue">
        <button type="button" class="close modal_close_button" data-dismiss="modal" aria-hidden="true" onclick="stop_video()">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Название видео</h4></span>
      </div>
      <div class="modal-body">
        
		 <!--iframe id="yt_link" width="560" class="hidden-xs" height="315" src="" frameborder="0" allowfullscreen></iframe>
		 <iframe id="yt_link_xs" class="visible-xs"  src="" frameborder="0" allowfullscreen></iframe-->
		 
		 <iframe id="yt_link" width="560" class="hidden-sm-down" height="315" src="" frameborder="0" allowfullscreen></iframe>
		 <iframe id="yt_link_xs" class="hidden-md-up"  src="" frameborder="0" allowfullscreen></iframe>
		
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
        <button type="button" class="btn btn-default modal_close_button" data-dismiss="modal" onclick="stop_video()">Закрыть</button>
        
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
</div>
<?

}//nitka?>