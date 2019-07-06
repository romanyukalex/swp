<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	
if(!$book_id){
	$book_id=$_SESSION[$_REQUEST['book_link']];
	$book_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `topic_id`='".$book_id."' LIMIT 0,1;"));
	mb_internal_encoding("UTF-8");
	insert_function("parse_torrent_name");
	$book_info_p=parse_torrent_name($book_info['name']);
	$bookauthor=$book_info_p['author'];
	$bookname=$book_info_p['title'];
	$book_attr=$book_info_p['tor_attr'];
}

if($book_info['topic_id']){
	$log->LogInfo('Got topic_id - '.$book_info['topic_id']);
?>

<div class="row flex-items-md-center" style="margin-top:20px">

	<div class="col col-md-3">
	<b>Похожие публикации</b>
	<? 
	if($bookauthor) {
	$same_author_q=mysql_query("SELECT * FROM `$tableprefix-torrents-abooks` WHERE `name` like '%$bookauthor%' LIMIT 0,10;");
		if(mysql_num_rows($same_author_q)>1){
			?><br><br>Тот же автор:<br><?
			while ($same_author_books=mysql_fetch_array($same_author_q)){
				$sa_book_info=parse_torrent_name($same_author_books['name']);
				?><a class="justlink" style="font:14px" href="/?page=book&topic_id=<?=$same_author_books['topic_id']?>"><?=$sa_book_info['title'];
				if($same_author_books['year']){
				?>[<?=$same_author_books['year'];?>]<?}?></a><br><br><?
			}
		}
	}
	$same_razdel_book_q=mysql_query("SELECT * FROM `$tableprefix-torrents-abooks` WHERE `cat_id`='".$book_info['cat_id']."' ORDER BY RAND() limit 0,5;");
	?><br><br>Тот же раздел [<?=$book_info['cat_name']?>]:<br><?
		while ($same_razdel_books=mysql_fetch_array($same_razdel_book_q)){
			$sa_razd_book_info=parse_torrent_name($same_razdel_books['name']);
			?><a class="justlink" style="font:14px" href="/?page=book&topic_id=<?=$same_razdel_books['topic_id']?>"><?=$sa_razd_book_info['author'].' - '.$sa_razd_book_info['title']?>[<?=$same_razdel_books['year'];?>]</a><br><br><?
		}
	?>
	</div>
	<div class="col col-md-6">
		<script>

		setTimeout(function (){
			ajaxreq("<? echo $book_info['topic_id'];?>",'',"download_torrent","torr_dld_ap","project_script");
		},10);
		setTimeout(showHideSelectionSoft,10000,'torr_link_button_div',1000);
		setTimeout(showHideSelectionSoft,10000,'countdown',1000);
		</script>

		<b>СТРАНИЦА СГЕНЕРИРОВАНА ВРЕМЕННО</b><br><br>
		Не пытайтесь поделиться этой ссылкой, получатель не сможет её открыть. Вместо этого используйте оригинальную страницу:<br>
		<a class="justlink" href="/?page=book&topic_id=<?=$book_info['topic_id']?>"><?=$book_info['name']?></a><br><br><br><br>

		<div id="countdown"><b>Вы получите ссылку на скачивание через - 10 секунд</b></div>
		<div id="torr_dld_ap" style="display: none"></div>
		<div id="torr_link_button_div" style="display: none">
			<a class="button large yellow" style="color:white;" href="/project/<?=$projectname?>/files/books_torrents/<?=$book_info['topic_id']?>.torrent" target="_blank">Скачать запись через Torrent</a>
			<? /*<a class="button large yellow" style="color:white;" href="http://rutracker.org/forum/viewtopic.php?t=<?=$book_info['topic_id']?>" target="_blank">Скачать книгу с Torrent-трекера</a>*/?>
				<br><br>
				Если Вы ещё не пользовались сетью torrent, то Вы можете <a class="button large yellow" href="/project/<?=$projectname?>/files/uTorrent.exe">скачать Torrent-клиент</a> и открыть полученный torrent-файл с его помощью.
		</div>

		<br><br><br><br>Если у Вас есть вопрос, то Вы можете связаться с администрацией портала <a href="" data-toggle="modal" data-target="#contact_modal"class="justlink">через Вконтакте</a> 
		или найти контактные данные в разделе <a href="/?page=contacts" class="justlink">О клубе / Контакты</a>
	</div>

	<div class="col col-md-2">
	<a href="/?page=book&topic_id=<?=$book_info['topic_id']?>">
	<img src="<?
	if($book_info['orig_img'] and $book_info['orig_img']!=='-1251' and $book_info['orig_img']!=='no') echo $book_info['orig_img']; else echo '/project/'.$projectname.'/files/no_oblojki.png';?>" width="100%" class="thumbnail" alt="Обложка книги <?=$books_info['name']?>"></a>
	
	Опубликовано: <?=substr($book_info['year'],0,10)?><br>
	Автор книги: <a href="/?page=psybooks&search_string=<?=$bookauthor?>" class="justlink" title="Все книги <?=$bookauthor?> на сайте"><?=$bookauthor;?></a>
	
	<? // Кто запостил сюда?>
	</div>
</div>


<div class="row">
	<div class="col col-md-6 col-md-offset-3">
	<? #Делаем из тегов ссылки
	$tags_arr=explode(';',$book_info['tags']);
	foreach ($tags_arr as $tag){
		if($tag){
		?><a href="/?page=videos&search_string=<?=$tag?>" class="bcgr_grey tag_circle"><?=$tag?></a><?
		}
	}
	?>
	</div>
</div>
<?	} else {
	$log->LogError('topic_id is not found. Session param is '.$_SESSION[$_REQUEST['book_link']].' REQUEST param is '.$_REQUEST['book_link']);
}
}//nitka?>