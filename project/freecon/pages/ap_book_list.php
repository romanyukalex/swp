<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	insert_function("StringPlural");
	insert_function("parse_torrent_name");
	?>
<script>

function moderate_item(reaction,id){
	
	$('#moderate_ap_'+id).load('/core/ajaxapi.php?',{action:'moderate_book',id:id,reaction:reaction,mod:'project_script'});
}
function moderate(topic_id,action,reaction){
				$("#moderate_ap").load('/core/ajaxapi.php?',{
					action:action,id:topic_id,reaction:reaction,mod:"project_script"});
}
</script>
<br><br>
<?
if($userrole=="admin" or $userrole=="root"){

$need_mod_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-torrents` WHERE `status`='need_confirm';"));
	
$info_req=mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `status`='need_confirm' ORDER BY `id` DESC LIMIT 0,20;");
$log->LogInfo('Got ['.mysql_num_rows($info_req).'] rows in list of NEED_MODERATE');?>
<div class="row flex-items-md-center" style="margin:0 0 30px 10px">
	<div class="col-md-12 col-lg-12">

<h2 class="maintitle">К модерации <?
	echo " ".$need_mod_stat_q['COUNT'];
?> [на странице <?=mysql_num_rows($info_req);

echo(' '.StringPlural::Plural(mysql_num_rows($info_req), array('книга', 'книги', 'книг')));?>]</h2>

</div>
<span id="moderate_ap"></span>
</div>

<?



while($item_info=mysql_fetch_array($info_req)){
	//echo $item_info['name'];
	mb_internal_encoding("UTF-8");
	
	
	$item_info_p=parse_torrent_name($item_info['name']);
	$bookauthor=$item_info_p['author'];
	$bookname=$item_info_p['title'];
	$book_attr=$item_info_p['tor_attr'];
	
	if(!$item_info['year']){ // Не вычислен еще год
		$foursymbols=mb_substr($book_attr,0,4);
		if (preg_match('/[\d]{4}/',$foursymbols) and !$item_info['year']) {//Запись года в поле
			mysql_query("UPDATE `$tableprefix-torrents` SET `year` = '$foursymbols' WHERE `id` = ".$item_info['id'].";");
		}
	}
	?>
	<div class="row" class="vp_block" id="item_row_<?=$item_info['id']?>">
		<div class="col-md-2">
			
					
			
			<a target="_blank" title="Смотреть и скачать книгу: <?=$item_info['name']?>" href="/?page=book&topic_id=<?=$item_info['topic_id']?>"><img src="<?
			if($item_info['orig_img'] and $item_info['orig_img']!=='-1251' and $item_info['orig_img']!=='no') echo $item_info['orig_img']; else echo '/project/'.$projectname.'/files/no_oblojki.png';?>" width="120px" class="thumbnail" alt="Обложка книги <?=$item_info['name']?>"></a>
			
			
			<br>
			<span id="moderate_ap_<?=$item_info['id']?>"></span>
			<a href="" onclick="moderate('<?=$item_info['topic_id']?>','moderate_book','apply');showHideSelectionSoft('item_row_<?=$item_info['id']?>',1000);return false;" class="green swp_button  large">Опубликовать</a>
			<br><br>
			<a href="" onclick="moderate('<?=$item_info['topic_id']?>','moderate_book','delete');showHideSelectionSoft('item_row_<?=$item_info['id']?>',1000);return false;" class="red swp_button large">Отклонить</a>
		</div>
		<div class="col-md-10">
			<?=$book_attr;?>	
			
			
				<h4 title="Смотреть и скачать книгу: <?=$item_info['name']?>"><a href="/?page=book&topic_id=<?=$item_info['topic_id']?>" target="_blank"><?
					if($bookname) echo $bookname; 
					elseif(!$bookname and !$bookauthor) { #Почему то не определился ни автор, ни название книги
						if(mb_strstr($item_info['name'],"[")) echo mb_substr($item_info['name'],0,mb_strpos($item_info['name'],"["));
						else echo $item_info['name'];
					}?></a></h4>
				<? if($bookauthor){?>
				<p><a target="_blank" href="/?page=psybooks&search_string=<?=$bookauthor?>" class="yt-user-name" title="Другие книги автора: <?=$bookauthor?>"><?=$bookauthor?></a></p>
				<? }
				#Описание книги
					if($item_info['orig_desc']!==NULL){
			
						$start_orig_desc=$item_info['orig_desc'];
					} elseif(filesize($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$item_info['topic_id'])>0) {
					
						$start_orig_desc=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$item_info['topic_id']);
						
					} 
					# Описание книги
					$orig_desc=str_replace("\n", "<br>",$start_orig_desc);
					$orig_desc=str_replace("Примеры страниц", "",$orig_desc);
					$orig_desc=str_replace("Описание:", "<br><br><b>Описание</b><br>",$orig_desc);
					$orig_desc=str_replace("Издательство:", "<br>Издательство:",$orig_desc);
					$orig_desc=str_replace('href="viewtopic.php','href="http://rutracker.org/forum/viewtopic.php',$orig_desc);
					
					?><div id="book_full_desc_part_<?=$item_info['id']?>">
					<?=mb_substr($orig_desc,0,1000);?>
					</div>
					<a href="" onclick="showHideSelectionSoft('book_full_desc_<?=$item_info['id']?>',100);	showHideSelectionSoft('book_full_desc_part_<?=$item_info['id']?>',1000);return false;">Открыть полное описание</a>
					<div style="display:none" class="col col-md-12" id="book_full_desc_<?=$item_info['id']?>"><?=$orig_desc;?></div>
			
		</div>
	</div>
<?	
}
?>

<?} ?>

<!-- // Книги -->

<br><br><br><br><br><br>




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
</div>
<?
}//nitka?>