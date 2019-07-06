<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
if(!$book_id){
	$book_id=process_data($_REQUEST['topic_id'],8);
	$book_info=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `topic_id`='".$book_id."' AND (`status`='active' or `status`='need_confirm') LIMIT 0,1;"));

	mb_internal_encoding("UTF-8");
	
	insert_function("parse_torrent_name");
	$book_info_p=parse_torrent_name($book_info['name']);
	$bookauthor=$book_info_p['author'];
	$bookname=$book_info_p['title'];
	$book_attr=$book_info_p['tor_attr'];
	$torrent_name=$book_info_p['torrent_name'];
	
}

if($book_info['topic_id'] and $book_info['name']){
	if($book_info['orig_img'] and $book_info['orig_img']!=='-1251' and $book_info['orig_img']!=='no'){$book_img=$book_info['orig_img'];}

?>
<!-- Основоной блок с 3 столбцами -->
<div class="row flex-items-md-center" style="margin-top:20px" itemscope="" itemtype="http://schema.org/Book">
	<!-- Блочок 1 -->
	<div class="col col-md-3">
	  <!-- РЕКЛАМНЫЙ БЛОК 3 -->
	<?
	if($banner->get_banner(3,"banner_id")){
		#Нижний баннер
		?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff;margin:0 0 15px 0">
			<a target="_blank" class="justlink" onclick="save_click('<?=$banner->get_banner(3,"banner_id")?>');" href="<?=$banner->get_banner(3,"link")?>"<? if($banner->get_banner(3,'a_title')){?>title="<?=$banner->get_banner(3,'a_title')?>"<?}?>>
			
			<? if($banner->get_banner(3,'text_1')){?>
			<b style="font-size:14px"><?=$banner->get_banner(3,'text_1')?></b><br>
			<?}?>
			<img src="<?=$banner->get_banner(3,'img')?>" style="width: 100%;padding 5px;">
			<? if($banner->get_banner(3,'text_2')){?>
			<span style="font-size:12px"><?=$banner->get_banner(3,'text_2')?></span>
			<?}?>
			</a>
		</div>
		<!-- // РЕКЛАМНЫЙ БЛОК 3 -->
<?	}?>
	<b>Похожие публикации:</b>
	<? 
	if($bookauthor) {
		$same_author_q=mysql_query("SELECT `name`,`topic_id`,`year`,`orig_img` FROM `$tableprefix-torrents` WHERE `status`='active' and `name` like '%$bookauthor%' and `topic_id`!='".$book_info['topic_id']."' LIMIT 0,10;");
		
		if(@mysql_num_rows($same_author_q)>0){
			?><br><br><? 
			if ($bookauthor) {?>Книги <? echo $bookauthor;
			} else { ?>Этого автора<? }?>:<br><?
			while ($same_author_books=mysql_fetch_array($same_author_q)){
				$sa_book_info=parse_torrent_name($same_author_books['name']);
				?><a class="justlink" style="font:10px" href="/?page=book&topic_id=<?=$same_author_books['topic_id']?>" onclick="yandex_target('book_from_bookpage');return true;"><img src="<?=$same_author_books['orig_img']?>" width="50px"><?
				
				if(!empty($sa_book_info['title'])) {echo $sa_book_info['title'];
					if(!empty($same_author_books['year'])){?>[<?=$same_author_books['year'];?>]<?}
				}
				else echo $same_author_books['name'];
				
				?></a><br><br><?
			}
		}
	}
	$same_razdel_book_q=mysql_query("SELECT `name`,`topic_id`,`year`,`orig_img` FROM `$tableprefix-torrents` WHERE `status`='active' and  `cat_id`='".$book_info['cat_id']."' ORDER BY RAND() limit 0,5;");
	?><br><br>[<?=$book_info['cat_name']?>]:<br><?
		while ($same_razdel_books=mysql_fetch_array($same_razdel_book_q)){
			$sa_razd_book_info=parse_torrent_name($same_razdel_books['name']);
			?><a class="justlink" style="font:50px" href="/?page=book&topic_id=<?=$same_razdel_books['topic_id']?>" onclick="yandex_target('book_from_bookpage');return true;">
			<? if($same_razdel_books['orig_img']!=='-1251' and $same_razdel_books['orig_img']!=='no'){?>
			<img src="<?=$same_razdel_books['orig_img']?>" width="100%"><?
			} else {
				if(!empty($sa_razd_book_info['title'])){
					echo $sa_razd_book_info['author'].' - '.$sa_razd_book_info['title'];
					if(!empty($same_razdel_books['year'])){?>[<?=$same_razdel_books['year'];?>]<?}
				} else echo $same_razdel_books['name'];
			}
			?></a><br><br><?
		}
	?>
	</div>
	<!-- // Блочок 1 -->
	<!-- Блочок 2 описание книги -->
	<div class="col col-md-7">
		<dd style="display:none" itemprop="name"><?=$bookname?></dd>
		
		<a href="https://www.ozon.ru/new-referral/?code=ozong6o21p" class="justlink">Получить <img src="/project/freecon/files/500.jpg" height="64px"> на книги от <img src="/project/freecon/files/ozon_app.png" height="64px"></a>
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
		$orig_desc=str_replace("Формат:", "<br>Формат:",$orig_desc);
		$orig_desc=str_replace("Издательство:", "<br>Издательство:",$orig_desc);
		$orig_desc=str_replace('href="viewtopic.php','href="http://rutracker.org/forum/viewtopic.php',$orig_desc);
		?><span itemprop="description"><?=$orig_desc;?></span>
		
		<? #Выводим комментарии
		include ($_SERVER['DOCUMENT_ROOT'].'/commenton/index.php'); 
		?>

	</div>
	<!-- // Блочок 2 описание книги -->
	<!-- Блочок СКАЧАТЬ, АВТОР, ПОДЕЛИТЬСЯ -->
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
	# СКАЧАТЬ
	?>
	<a class="button large hvr-outline-in" style="color:white;background-color:  #36cdb6;" data-toggle="modal"
	<? if($_SESSION['hearts']>=5){?>data-target="#bookDwnldModal" onclick="start_book_timer();"<?}
	else {?>data-target="#bookDwnldModal_noHrts"<?}
	/*href="<?
	if(!$bot_name){?>/?page=dnld_book&book_link=<?
		insert_function("abracadabra");
		$book_link=abracadabra(8,'mix');
		$_SESSION[$book_link]=$book_info['topic_id'];
		$log->LogDebug('SESSION param is $_SESSION['.$book_link.']='.$book_info['topic_id']);
		echo $book_link;
	} else echo "/";
	?>"*/?>><i class="fas fa-download" style="color:white"></i> Скачать <i class="fas fa-book" style="color:white"></i></a>
	<br><br>

	
	<!--Обложка-->
	<img class="vp_block" <?if($book_img){?>data-toggle="modal" data-target="#bookImageModal"<?}?> src="<?
	if($book_img) echo $book_img; else echo '/project/'.$projectname.'/files/no_oblojki.png';?>" width="100%" class="thumbnail" alt="Обложка книги <?=$bookname?>" title="Обложка книги <?=$bookname.$book_img." - ".$book_info['orig_img']?>">
	
	Опубликовано: <a class="justlink"href="/?page=psybooks&search_string=<?=substr($book_info['year'],0,10)?>" itemprop="copyrightYear"><?=substr($book_info['year'],0,10)?></a><br>
	Автор книги: <a href="/?page=psybooks&search_string=<?=$bookauthor?>" class="justlink" title="Все книги <?=$bookauthor?> на сайте" itemprop="author"><?=$bookauthor;?></a>
	
	<? // Кто запостил сюда?>
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
	
		<script>
		<? /* //Скачиваем файл торрента
		setTimeout(function (){
			ajaxreq("<? echo $book_info['topic_id'];?>",'',"download_torrent","torr_dld_ap","project_script");
		},10);
		*/?>
		function start_book_timer(){
			setTimeout(showHideSelectionSoft,20000,'torr_link_button_div',1000);
			setTimeout(showHideSelectionSoft,20000,'countdown',1000);
			setTimeout(showHideSelectionSoft,20000,'book_img_modal',1000);
			setTimeout(pay_hearts,20000,5);
			setTimeout(yandex_target,20000,'book_dnld');
		}
		</script>
		
		
	</div>
	<!-- // Блочок 3 СКАЧАТЬ, АВТОР, ПОДЕЛИТЬСЯ -->
</div>
<!-- // Основоной блок с 3 столбцами -->

<!--Всплывашка со ссылкой-->
<div class="modal fade" tabindex="-1" role="dialog" id="bookDwnldModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Скачивание через 20 секунд. Будет списано <i class="fas fa-heart" style="color:grey"></i> 5</h5>
      </div>
      <div class="modal-body">
        <div id="torr_dld_ap" style="display: none"></div>
		<div id="torr_link_button_div" style="display: none">
			<? /*<a class="button large yellow" style="color:white;" href="/project/<?=$projectname?>/files/books_torrents/<?=$book_info['topic_id']?>.torrent" target="_blank">Скачать книгу через Torrent</a>*/?>
			<a class="button large yellow" style="color:white;" href="http://rutracker.org/forum/viewtopic.php?t=<?=$book_info['topic_id']?>" target="_blank">Скачать книгу с Torrent-трекера</a>
				<br><br>
				Если Вы ещё не пользовались сетью torrent, то Вы можете <a class="button large yellow" href="/project/<?=$projectname?>/files/uTorrent.exe">скачать программу &mu;Torrent</a> и открыть полученный torrent-файл с его помощью.
				<a href="" class="button large red"  data-toggle="modal" data-target="#torr_blc" <?//onclick="showHideSelectionSoft('torr_instruct',1000);return false;"?>>Не открывается сайт по ссылке?</a>
				
		</div>
		
		<? if($book_img){?>
		<img id="book_img_modal" src="<?=$book_info['orig_img'];?>" width="50%" alt="Обложка книги <?=$bookname?>">
		<? }?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



<!--Модальное окно для с обходом -->
<div class="modal fade" id="torr_blc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Как получить доступ к порталу для скачивания</h4></span>
      </div>
      <div class="modal-body">
	  <div class="entry-content">
        
        <h4>Почему Рутрекер заблокирован</h4>
        <div id="idTextPanel" class="jqDnR">
            <p>Сайт заблокирован по требованию правообладателей и решению Мосгорсуда (удовлетворен иск издательства "Эксмо"). Рутрекер заблокирован для российских пользователей "навечно" с использованием недавно появившейся в законодательстве РФ процедуры "пожизненной блокировки сайтов".</p>

        </div>

        <h4>Как зайти на Рутрекер</h4>
        <div id="idTextPanel" class="jqDnR">
            <p>Очень просто! Мы подготовили плагины (расширения) для браузеров, используя которые, вы спокойно сможете пользоваться сайтом, не ощутив разницы. </p>
			
			
			
<article>

    <div class="entry-content">

        <div class="table">
            <div class="table-left">
                <figure class="browser-thumbnail">
                    <a target="_blank" href="https://chrome.google.com/webstore/detail/%D0%B4%D0%BE%D1%81%D1%82%D1%83%D0%BF-%D0%BA-%D1%80%D1%83%D1%82%D1%80%D0%B5%D0%BA%D0%B5%D1%80%D1%83/lbdmhpkmonokeldelekgfefldfboblbj" class="more-link"><img width="18%" src="https://dostup-rutracker.org/assets/img/chrome.png"></a>
					<a target="_blank" href="https://addons.mozilla.org/ru/firefox/addon/%D0%B4%D0%BE%D1%81%D1%82%D1%83%D0%BF-%D0%BA-%D1%80%D1%83%D1%82%D1%80%D0%B5%D0%BA%D0%B5%D1%80%D1%83/" class="more-link"><img width="18%" src="https://dostup-rutracker.org/assets/img/firefox.png"></a>
					<a target="_blank" href="https://addons.opera.com/ru/extensions/details/dostup-k-rutrekeru/?display=ru" class="more-link"><img width="18%" src="https://dostup-rutracker.org/assets/img/opera.png"></a>
					<a target="_blank" href="https://chrome.google.com/webstore/detail/%D0%B4%D0%BE%D1%81%D1%82%D1%83%D0%BF-%D0%BA-%D1%80%D1%83%D1%82%D1%80%D0%B5%D0%BA%D0%B5%D1%80%D1%83/lbdmhpkmonokeldelekgfefldfboblbj" class="more-link"><img width="18%" src="https://dostup-rutracker.org/assets/img/yandex.browser.png"></a>
					<a href="https://extensions.apple.com/" class="more-link"><img width="18%" src="https://dostup-rutracker.org/assets/img/safari.png"></a>
                </figure>
				
            </div>
            
        </div>
    </div>
    
</article>


        </div>

        <h4>Законно ли это</h4>
        <div id="idTextPanel" class="jqDnR">
            <p>Абсолютно, закон предписывает блокирование доступа провайдерам, а не пользователям.</p>
        </div>
    </div>
	  </div>
    </div>
  </div>
</div>

<!--Если нет сердечек на скачивание -->
<div class="modal fade" tabindex="-1" role="dialog" id="bookDwnldModal_noHrts" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Пока Вы не можете скачать книгу</h5>
      </div>
      <div class="modal-body">
        
		<img src="<?=$book_info['orig_img'];?>" width="20%" alt="Обложка книги <?=$bookname?>">
		Книга будет доступна для скачивания, когда на Вашем счету будет <i class="fas fa-heart" style="color:grey"></i> 5 или более<br>
		Сейчас на Вашем счету <i class="fas fa-heart" style="color:grey"></i> <?=$_SESSION['hearts']?><br>
		
		<a data-toggle="modal" data-target="#how_get_hearts" class='button justlink'>Получить <i class="fas fa-heart" style="color:grey"></i></a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



<? if($book_img){?>
<!--Всплывашка с картинкой-->
<div class="modal fade" tabindex="-1" role="dialog" id="bookImageModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Обложка книги <?=$bookname?></h5>
      </div>
      <div class="modal-body">
        
		<img src="<?=$book_info['orig_img'];?>" width="100%" alt="Обложка книги <?=$bookname?>">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<? }

} else {
	?>Страница заблокирована<?
}
}//nitka?>