<? # Скрипт парсит ленту RSS, содерж. полный текст статьи

$log->LogInfo('Got this file');
insert_function("get_html_code_url");
#Перевод в транслит
insert_function("rus2translit");

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
	$artcl['article_title']=$rss_item['title'];

	# Тело статьи
	if(!empty($rss_item['content'])) $artcl['article_content']=$rss_item['content'];
	else $artcl['article_content']=$rss_item['description'];
	if(mb_strstr($artcl['article_content'],"<![CDATA[")){
		$artcl['article_content']=mb_substr($artcl['article_content'],9,-3);
	}
	$artcl['article_content']=trim($artcl['article_content']);
	# Очищаем тело от классов, оставляем только чистые теги
	$artcl['article_content'] = stripslashes( $artcl['article_content']); 
	$artcl['article_content'] = strip_tags( $artcl['article_content'], '<img><div><span><p><b><a><strong><i><u><strike><em><center><h2><li><ol><ul><br><hr><center>'); // вырезаем все теги кроме... 
	//$artcl['article_content'] =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl['article_content']); // у всех тегов вырезаем атрибуты

  	$artcl['SEO_descrtn']=mb_substr(strip_tags($artcl['article_content']),0,200).'...';
	
	
	if($rss_item['enclosure'] and mb_strstr($rss_item['enclosure_type'],"image")) $artcl['page_img']=$rss_item['enclosure'];
	else {
		$art_dom = new DOMDocument;
		$art_dom->loadHTML($artcl['article_content']);
		//Обрабатываем картинки
		$art_imgs= $art_dom->getElementsByTagName('img');
		foreach ($art_imgs as $item1) {
			
			$artcl['page_img']=$item1->getAttribute('src');
			break; //Оставляем первую картинку
		}
	}

	#Параметр page
	$artcl['article_page']=str2url($artcl['article_title']);

	if(!$rss_item['pubDate']) $artcl['pubDate']="CURRENT_TIMESTAMP"; else  $artcl['pubDate']="'".date("Y-m-d H:i:s",strtotime($rss_item['pubDate']))."'";

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

	# Записываем в БД
	mysql_query("INSERT INTO `$tableprefix-pages` ( `page`, `pagetitle_ru`, `pagetitle_en`, `pagebody_ru`, `pagebody_en`, 
		 `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-descrtn_ru`, 
	`SEO-descrtn_en`, `showin_all_pages_page`, `is_articles`, `script_after_page`,`page_img`, `creation_date`,`orig_link`) VALUES 
	('".$artcl['article_page']."', '". $artcl['article_title']."',  NULL,  '".$artcl['article_content']."',NULL, 
		 'yes','".$artcl['article_author']."','". $artcl['article_title']."', '". $artcl['article_title']."', '". $artcl['SEO_descrtn']."',
		'". $artcl['SEO_descrtn']."', '".$post_artcls."', '".$post_artcls."', 'show_likes.php;show_article_autor.php','".$artcl['page_img']."', ".$artcl['pubDate'].",'".$rss_item['link']."');");

	# Тело письма
	$message_to_adm.=$torr_info['name']."<br>
	КОНТЕНТ: ".$artcl['article_title']."<br>
	ОРИГИНАЛ: <a href='".$rss_item['link']."'>".$rss_item['link']."</a><br>
	ССЫЛКА НА ПОРТАЛЕ: <a href='https://".$sitedomainname.'/?page='.$artcl['article_page']."'>".$artcl['article_title']."</a><br>
	СКАЧАНО ЛЕНТОЙ: <a href='".$rss_config['feed_url']."'>".$rss_config['feed_name'].'</a> ['.$rss_config['feed_id'].']<br>
	'.$add_to_message.'<br><br><br>';


 	unset($artcl);
}

