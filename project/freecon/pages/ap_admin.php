<? $log->LogInfo('Got '.(__FILE__));
if($nitka==1){
if($userrole=="admin" or $userrole=="root"){
	?>
	<div  style="margin:20px 20px">
		<h1><img src="<?=$logofile?>" height="64px" class="imgmiddle">Управление проектом "Клуб Здорового Сознания"</h1><br>

		<a href="/adminpanel/?page=video_admin">
			<img src="/adminpanel/pics/play256.png" height="48px" class="imgmiddle">Модерация видео
		</a><br>
		
		<a href="/adminpanel/?page=books_admin">
			<img src="/adminpanel/pics/books.png" height="48px" class="imgmiddle">Модерация книг
		</a><br>
		<a href="/adminpanel/?page=jokes_admin">
			<img src="/project/<?=$projectname?>/files/jokes.png" height="48px" class="imgmiddle">Добавить шутку
		</a><br>
		<a  href="/adminpanel/?page=swp_shop_admin">
			<img src="/project/<?=$projectname?>/files/training_shop256.png" height="48px" class="imgmiddle">Управление записями тренингов
		</a><br>
	<?
	
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/get_statistics.php');
	?>Статистика портала за <?=date("Y-m-d");
	$new_lt_message='<br>
	-----VIDEOS -----<br>
	Today script found videos - '.$v_today_stat_q['VCOUNT'].'<br>
	Now in status "NEED_MODERATE" - '.$v_need_mod_stat_q['NMCOUNT'].'<br>
	
	-----BOOKS ------<br>
	Books in DB - '.$b_all_q['BCOUNT'].'<br>
	Need confirm - '.$b_all_needconfirm_q['BCOUNT'].'<br>
	Active books - '.$b_all_act_q['BCOUNT'].'<br>
	Disabled (DELETED) books - '.$b_disabled_q['BCOUNT'].'<br>
	Today script added - '.$b_today_stat_q['BCOUNT'].'<br>

	-----Articles (Pages) ------<br>
	Pages in DB - '.$pages_all_q['ARTCLS_COUNT'].'<br>
	Pages in DISABLED status - '. $pages_all_dis['COUNT'].'<br>
	Pages in ERROR status - '. $pages_all_err['COUNT'].'<br>
	Pages in BLOCKED status - '. $pages_all_blk['COUNT'].'<br>

	Pages of adminpanel - '. $pages_admin['COUNT'].'<br>
	Pages for users - '. $pages_sitePage['COUNT'].'<br>
	Articles in DB - '. $pages_artcls_db['COUNT'].'<br>
	Articles on disk (rus) - '.$pages_artcls_disk.'<br>
	Articles on disk (en) - '.$pages_artcls_disk_en.'<br>
	Pages with video - '. $pages_video['COUNT'].'<br>
	
	
	Today added - '.$pages_today_q['ARTCLS_COUNT'].'<br>
	Today activated - '.$pages_today_act_q['ARTCLS_COUNT'].'<br>
	Deleted in DB - '.$pages_all_deleted_q['ARTCLS_COUNT'].'<br>
	Today deleted - '.$pages_today_deleted_q['ARTCLS_COUNT'].'<br>
	Waiting for moderate - '.$pages_all_waitmoder_q['ARTCLS_COUNT'].'<br>
	Waiting for moderate fresh (todays) - '.$pages_today_waitmoder_q['ARTCLS_COUNT'].'<br>
	
	------JOKES ------<br>
	Jokes in DB - '.$jokes_all_act_q['COUNT'].'<br>
	Jokes added today - '.$jokes_today_act_q['COUNT'].'<br>
	------Users ------<br>
	User in DB - '.$users_all_act_q['COUNT'].'<br>
	Users added today - '.$users_today_act_q['COUNT'].'<br>
	
	------Orders -----<br>
	Orders in DB - '.$orders_all['COUNT'].'<br>';
	foreach($orders_status as $status=>$count){
		$new_lt_message.='Orders in status '.$status.' - '.$count.'<br>';
	}
	echo $new_lt_message;
	?><br><br><br></div><?
}
}//nitka?>