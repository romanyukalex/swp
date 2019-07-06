<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
if(!$book_id){
	$book_id=process_data($_REQUEST['topic_id'],8);
	$book_info=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-torrents-abooks` WHERE `topic_id`='".$book_id."' AND (`status`='active' or `status`='need_confirm') LIMIT 0,1;"));

	mb_internal_encoding("UTF-8");
	
	insert_function("parse_torrent_name");
	$book_info_p=parse_torrent_name($book_info['name']);
	$bookauthor=$book_info_p['author'];
	$bookname=$book_info_p['title'];
	$book_attr=$book_info_p['tor_attr'];
	$torrent_name=$book_info_p['torrent_name'];
}

if($book_info['topic_id'] and $book_info['name']){	

?><div class="row flex-items-md-center" style="margin-top:20px" itemscope="" itemtype="http://schema.org/CreativeWork">

	<div class="col col-md-3">
	  <!-- РЕКЛАМА-->
	<? //include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/show_ads_banner.php');
	if($banner->get_banner(3,"banner_id")){
		#Нижний баннер
		?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff;margin:0 0 15px 0">
		<a target="_blank" class="justlink" onclick="save_click('<?=$banner->get_banner(3,"banner_id")?>');" href="<?=$banner->get_banner(3,"link")?>"<? if($banner->get_banner(3,'a_title')){?>title="<?=$banner->get_banner(3,'a_title')?>"<?}?>>
		<b style="font-size:14px"><?=$banner->get_banner(3,'text_1')?></b><br>
		<img src="<?=$banner->get_banner(3,'img')?>" style="width: 100%;padding 5px;">
		<span style="font-size:12px"><?=$banner->get_banner(3,'text_2')?></span>
		</a>
		</div>
<?	}?>
	<b>Похожие публикации</b>
	<? 
	if($bookauthor) {
		$same_author_q=mysql_query("SELECT `name`,`topic_id`,`year` FROM `$tableprefix-torrents-abooks` WHERE `name` like '%$bookauthor%' and `topic_id`!='".$book_info['topic_id']."' LIMIT 0,10;");
		
		if(@mysql_num_rows($same_author_q)>0){
			?><br><br><? 
			if ($bookauthor) {?>Записи <? echo $bookauthor;
			} else { ?>Тот же автор<? }?>:<br><?
			while ($same_author_books=mysql_fetch_array($same_author_q)){
				$sa_book_info=parse_torrent_name($same_author_books['name']);
				?><a class="justlink" style="font:14px" href="/?page=book&topic_id=<?=$same_author_books['topic_id']?>"><?
				
				if(!empty($sa_book_info['title'])) {echo $sa_book_info['title'];
					if(!empty($same_author_books['year'])){?>[<?=$same_author_books['year'];?>]<?}
				}
				else echo $same_author_books['name'];
				
				?></a><br><br><?
			}
		}
	}
	$same_razdel_book_q=mysql_query("SELECT `name`,`topic_id`,`year` FROM `$tableprefix-torrents-abooks` WHERE `cat_id`='".$book_info['cat_id']."' ORDER BY RAND() limit 0,5;");
	?><br><br>Тот же раздел [<?=$book_info['cat_name']?>]:<br><?
		while ($same_razdel_books=mysql_fetch_array($same_razdel_book_q)){
			$sa_razd_book_info=parse_torrent_name($same_razdel_books['name']);
			?><a class="justlink" style="font:14px" href="/?page=book&topic_id=<?=$same_razdel_books['topic_id']?>"><?
			
			if(!empty($sa_razd_book_info['title'])){
				echo $sa_razd_book_info['author'].' - '.$sa_razd_book_info['title'];
				if(!empty($same_razdel_books['year'])){?>[<?=$same_razdel_books['year'];?>]<?}
			} else echo $same_razdel_books['name'];
			
			?></a><br><br><?
		}
	?>
	</div>
	<div class="col col-md-7">
        <dd style="display:none" itemprop="name"><?=$bookname?></dd>
	<?	
		if($book_info['orig_desc']!==NULL){
			
			$start_orig_desc=$book_info['orig_desc'];
		} elseif(filesize($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$book_info['topic_id'])>0) {
		
			$start_orig_desc=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$book_info['topic_id']);
			
		} else{//Нет описания ни в БД, ни в файле. Попробуем скачать на лету
			
			$filePath='http://rutracker.org/forum/viewtopic.php?t='.$book_info['topic_id'];
			$html=file_get_contents($filePath);
			$html = mb_convert_encoding($html, 'utf-8', 'cp1251');
			#Поиск дскрипшна
			$needle2='<div class="post_body"';
			$desc_cl_pos=strpos($html,$needle2);
			$desc_frst_pos=strpos($html,'>',($desc_cl_pos+mb_strlen($needle2)));
			//echo '1='.$desc_cl_pos. ' Real 1='.$desc_frst_pos;
			$needle3='<div class="clear"';
			$desc_fin_pos=strpos($html,$needle3,$desc_frst_pos);
			$desc_lenght=$desc_fin_pos-$desc_frst_pos;
			//echo "FIN pos=".$desc_fin_pos. "Desc lenght=".$desc_lenght;
			$desc_html=strip_tags(substr($html,$desc_frst_pos+1,$desc_lenght));
			//$desc_html= htmlentities($desc_html,ENT_QUOTES);
			$desc_html=str_replace("'", "",$desc_html);
			$desc_html=str_replace('"', "",$desc_html);
			$desc_html=str_replace('Примеры страниц', "",$desc_html);
			$start_orig_desc=str_replace('Содержание', "",$desc_html);
			
			#Сохраняем описание в файл
			file_put_contents ( $_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/torrents/".$book_info['topic_id'] , $start_orig_desc);
			
			//$start_orig_desc="Описание не найдено";
		}
		# Описание книги
		$orig_desc=str_replace("\n", "<br>",$start_orig_desc);
		$orig_desc=str_replace("Примеры страниц", "",$orig_desc);
		$orig_desc=str_replace("Описание:", "<br><br><b>Описание</b><br>",$orig_desc);
		$orig_desc=str_replace("Издательство:", "<br>Издательство:",$orig_desc);
		$orig_desc=str_replace('href="viewtopic.php','href="http://rutracker.org/forum/viewtopic.php',$orig_desc);
		
		?><span itemprop="description"><?=$orig_desc;?></span>

		<? #Выводим комментарии
		include ($_SERVER['DOCUMENT_ROOT'].'/commenton/index.php'); 
		?>
		
	</div>
	<div class="col col-md-2">
	<? 
	# Модерация прямо на странице
	if($userrole and ($userrole=="admin" or $userrole=="root")){
		?>
		<script>
		function moderate(topic_id,action,reaction){
				$("#moderate_ap").load('/core/ajaxapi.php?',{
					action:action,id:topic_id,reaction:reaction,mod:"project_script"});
		}
		</script>
		<div id="moderate_ap"></div>
		Текстатус:<?=$book_info['status']?>
		<a class="button large red" onclick="moderate('<?=$book_info['topic_id']?>','moderate_book','delete');return false;">Удалить</a><br>
		<a class="button large green" onclick="moderate('<?=$book_info['topic_id']?>','moderate_book','apply');return false;">Подтвердить</a><br><br><?
	}
	?>
	<a class="button large" style="color:white;background-color:  #36cdb6;" rel="nofollow" href="<?
	if(!$bot_name){?>/?page=audio_downld&book_link=<?
		insert_function("abracadabra");
		$book_link=abracadabra(8,'mix');
		$_SESSION[$book_link]=$book_info['topic_id'];
		$log->LogDebug('SESSION param is $_SESSION['.$book_link.']='.$book_info['topic_id']);
		echo $book_link;
	}
	?>"><i class="far fa-2x fa-file-audio imgmiddle"></i> Скачать</a><br><br>
	
	<? #Год 
	if($book_info['year']!=='' and $book_info['year']) {?>Год: <a class="justlink"href="/?page=audios&search_string=<?=substr($book_info['year'],0,10)?>" itemprop="copyrightYear"><?=substr($book_info['year'],0,10)?></a><br><? }
	
	#Автор
	if($bookauthor){?>
	
	Автор: <a href="/?page=audios&search_string=<?=$bookauthor?>" class="justlink" title="Все записи <?=$bookauthor?> на сайте" itemprop="author"><?=$bookauthor;?></a>
	
	<? }
	// Кто запостил сюда?>
	<br>Поделиться: 
		<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="https://yastatic.net/share2/share.js" async="async"></script>
		<div class="ya-share2" data-services="vkontakte,twitter,facebook,gplus,odnoklassniki,skype" data-counter=""></div>
		<div class="ya-share2 hidden-md-up" data-services="telegram,viber,whatsapp" data-counter></div><? // СДЕЛАТЬ ТЕЛЕГРАММ ВАТСАП и ВАЙБЕР НЕВИДИМЫМИ ДЛЯ ДЕКСТОПА?>
	<br>Лайк:
		<? insert_module("vk-api","show_like_button");?>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.9&appId=300626623690724";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="https://psy-space.ru<?=$_SERVER['REQUEST_URI']?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
	<br>Сохранить:
		<div class="ya-share2" data-services="collections,blogger,delicious,evernote" data-counter></div>
	</div>
	
</div>




<?
} else {
	?>Страница заблокирована<?
}
}//nitka?>