<? # Скрипт парсит ленту RSS, содерж. полный текст статьи

$log->LogInfo('Got this file');
insert_function("get_html_code_url");
#Функция получения содержимого по названию класса
insert_function("DOM_getHTMLByClass");
#Перевод в транслит
insert_function("rus2translit");
insert_function("date_rus_to_en");

$item_q=mysql_query("SELECT `orig_link` FROM `$tableprefix-pages` WHERE `orig_link`='".$rss_item['link']."' LIMIT 0,1;");

if(mysql_num_rows($item_q)>0){ // Такой item уже есть
	$log->LogDebug('Page already exist. Means that old RSS, we can stop to process RSS feed');
	$dnld_item=0;
	$stop_feed_proc=1;
} else { // Статьи еще нет, надо скачать
	$log->LogDebug('Item needs to download, its a new page - '.$rss_item['link']);
	$dnld_item=1; // Флаг чтобы скачать
	$add_to_theme="Новая публикация из RSS [".$rss_config['feed_name']."]";
}

if($dnld_item==1){ // Парсим страницу
	# Название статьи
	if(mb_strstr($rss_item['title'],"публикована новая запись: ")){
		$artcl['article_title_arr']=explode("опубликована новая запись: ",$rss_item['title']);
		$artcl['article_title']=$artcl['article_title_arr'][1];
	} else $artcl['article_title']=$rss_item['title']; // Это для парсинга страниц http://selfgrowth.ru/page/160/

	# Получаем данные со страницы

	$content=get_html_code_url($rss_item['link']);
	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);
	

	


	# Получаем тело страницы внутри тега с классом
    $artcl['article_content']=DOM_getHTMLByClass($dom, 'entry');
	if(!empty($artcl['article_content'])) $log->LogDebug('Got article content');
	$artcl['article_content']=mb_substr($artcl['article_content'],0,mb_strpos($artcl['article_content'],"<!-- AddThis Button BEGIN -->")).'</div>';
	# Очищаем тело от классов, оставляем только чистые теги
	$artcl['article_content'] = stripslashes( $artcl['article_content']); 
	$artcl['article_content'] = strip_tags( $artcl['article_content'], '<img><div><span><p><b><a><strong><i><u><strike><em><center><h2><li><ol><ul><br><hr><center>'); // вырезаем все теги кроме... 
	//$artcl['article_content'] =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl['article_content']); // у всех тегов вырезаем атрибуты

 // 	$artcl['SEO_descrtn']=mb_substr(strip_tags($artcl['article_content']),0,200).'...';
	
	
	//Обрабатываем картинки
	$art_dom = new DOMDocument;
	@$art_dom->loadHTML($artcl['article_content'] );
	
	$art_imgs= $art_dom->getElementsByTagName('img');
	foreach ($art_imgs as $item1) {
		
		$artcl['page_img']=$item1->getAttribute('src');
		break; //Оставляем первую картинку в статье
	}

	#Описание страницы для SEO
	$meta_tags = $dom->getElementsByTagName('meta');
			
	foreach ($meta_tags as $item) {
		if(mb_strtolower($item->getAttribute('name'))=="description"){
				$artcl['SEO_descrtn']=$item->getAttribute('content');
		} elseif($item->getAttribute('name')=="keywords"){
			$artcl['SEO_kw']=$item->getAttribute('content');
		}
	}

	#Параметр page
	$artcl['article_page']=str2url($artcl['article_title']);
	#Проверим page на уникальность
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/check_same_article_title.php');
		
	if(!$rss_item['pubDate']) { // Вызов не через RSS, так что берем дату со страницы
		
		$p_tags = $dom->getElementsByTagName('p');
			
		foreach ($p_tags as $item) {
			if($item->getAttribute('class')=="date"){ // Это дата
				$artcl['pubDate']="'".date("Y-m-d H:i:s",strtotime(date_rus_to_en(mb_substr($item->textContent,0,mb_strpos($item->textContent,"|")))))."'";
				$log->LogDebug("rus=".$item->textContent." en=".date_rus_to_en($item->textContent)." PUBDATE=".$artcl['pubDate']);
			}
		}
		if(!$artcl['pubDate'] or $artcl['pubDate']=="1970-01-01 03:00:00")	$artcl['pubDate']="CURRENT_TIMESTAMP"; 
	}
	else  $artcl['pubDate']="'".date("Y-m-d H:i:s",strtotime($rss_item['pubDate']))."'";


	#Получаем ссылки
	$page_a = $dom->getElementsByTagName('a');
	foreach ($page_a as $item) {
		if(strstr($item->getAttribute('rel'),"tag")){ // тег
			 $artcl['article_tag'].=$item->textContent.';';
		}
	}

	# Сразу постить или модерировать
	if($rss_config['need_apply']=='manual_confirm') {
		$post_artcls=0;
		$add_to_message="Страница пока не размещена на сайте и <b>требует ручной активации</b> согласно настройкам фида.\n
		Для подтверждения пройдите по ссылке: <a href='".$sitedomainname."/'>Активировать контент</a> ДОДЕЛАТЬ
		";
		$add_to_theme.=" (Требует активации)";
	} elseif ($rss_config['need_apply']=='auto_confirm') {
		$post_artcls=1;
		$add_to_message="Страница размещена на сайте <b>автоматически</b> согласно настройкам фида";
	}
	
	#Автор
	if($rss_config['def_author_id']) $artcl['article_author']=$rss_config['def_author_id'];
	
	$log->LogDebug('Results: TITLE='.$artcl['article_title'].' PAGE='.$artcl['article_page'].' AUTHOR='.$artcl['article_author'].' IMG='.$artcl['page_img'].' PUB_DATE='.$artcl['pubDate']);

	
	if(strlen($artcl['article_content']))<3000){ #Контент маленький, возможно качество статьи низкое, устанавливаем статус dis, чтобы модерировать
		$artcl['status']="dis";
	} else $artcl['status']="ena";
	
	# Записываем в БД
	mysql_query("INSERT INTO `$tableprefix-pages` ( `page`, `pagetitle_ru`, `pagetitle_en`, `pagebody_ru`, `pagebody_en`, 
		`folder`, `filename`,
		 `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-descrtn_ru`, 
	`SEO-descrtn_en`, `SEO-keywds_ru`,`showin_all_pages_page`, `is_articles`, `script_after_page`,
	`page_img`, `creation_date`,`orig_link`,`tags`,`meta`,`status`) VALUES 
	('".$artcl['article_page']."', '". $artcl['article_title']."', NULL,  NULL, NULL, 
	'/pages/','CTATbR.php',
	 'yes','".$artcl['article_author']."','". $artcl['article_title']."', '". $artcl['article_title']."', '". $artcl['SEO_descrtn']."',
		'". $artcl['SEO_descrtn']."', '".$artcl['SEO_kw']."','".$post_artcls."', '".$post_artcls."', 'show_likes.php;show_article_autor.php',
		'".$artcl['page_img']."', ".$artcl['pubDate'].",'".$rss_item['link']."','". $artcl['article_tag']."','robots:index,nofollow;Document-state:Static','".$artcl['status']."');");

	#Если возникла ошибка добавления
	if(!mysql_insert_id()){
		$add_to_message.="<br>ОШИБКА ДОБАВЛЕНИЯ! ". mysql_errno().mysql_error ()."<br>Запрос был:".$artcl_add_qt;
		$add_to_theme.="(WITH_ERR)";
	} else {
		#Сохраняем тело статьи в файл
		$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html/".$artcl['article_page'];
		file_put_contents ( $filename , $artcl['article_content']);
		/*
		if($artcl['article_body_en']) { #Английскую версию в другой файл
			$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html_en/".$artcl['article_page'];
			file_put_contents ( $filename , $artcl['article_body_en']);
		}*/
	}	
		
	
	# Тело письма
	$message_to_adm.=$torr_info['name']."<br>
	КОНТЕНТ: ".$artcl['article_title']."<br>
	ОРИГИНАЛ: <a href='".$rss_item['link']."'>".$rss_item['link']."</a><br>
	ССЫЛКА НА ПОРТАЛЕ: <a href='https://".$sitedomainname.'/?page='.$artcl['article_page']."'>".$artcl['article_title']."</a><br>
	СКАЧАНО ЛЕНТОЙ: <a href='".$rss_config['feed_url']."'>".$rss_config['feed_name'].'</a> ['.$rss_config['feed_id'].']<br>
	'.$add_to_message.'<br><br><br>';


	#Данные для твита
	$tweet_text=$artcl['article_title']."\r\n".'https://'.$sitedomainname.'/?page='.$artcl['article_page'];
		
		
 	unset($artcl);
}

