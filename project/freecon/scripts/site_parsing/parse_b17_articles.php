<? # Скрипт парсит новую страницу из RSS и сохраняет информацию в БД 

# Пример
#$rss_item['link']='http://www.b17.ru/article/103137/';
#include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_b17_articles.php';



$log->LogInfo('Got this file');

/*
insert_function("get_html_code_url");
#Функция получения содержимого по названию класса
insert_function("DOM_getHTMLByClass");
#Перевод в транслит
insert_function("rus2translit");
$dnld_item=0; // Флаг для скачивания страницы
$erase_flag=0; // Флаг стирания записи БД

$item_q=mysql_query("SELECT `orig_link` FROM `$tableprefix-pages` WHERE `orig_link`='".$rss_item['link']."' LIMIT 0,1;");

if(mysql_num_rows($item_q)>0){ // Такой item уже есть
	$log->LogDebug('Page already exist. Means that old RSS, we can stop to process RSS feed');
	$stop_feed_proc=1;
} else { // Статьи еще нет, надо скачать
	$log->LogDebug('Item needs to download, its a new page - '.$rss_item['link']);
	$dnld_item=1; // Флаг чтобы скачать
	$dnld_reason=$add_to_theme="Новая публикация из RSS [".$rss_config['feed_name']."]";
	if($base_url) $add_to_theme.=' ['.$base_url.$pnum.']';
}
*/
include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_top.php';

if($dnld_item==1){ // Парсим страницу
	$log->LogDebug('Download page for '.$rss_item['guid']);

	# Получаем данные со страницы


	$artcl['article_title_new']=$html->find('h1',0)->innertext;






	
	/*
	$content=get_html_code_url($rss_item['link']);
	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);
	#Получаем название
	$art_h1 = $dom->getElementsByTagName('h1');
	foreach ($art_h1 as $item) { 
			$artcl['article_title']=trim($item->textContent);//Название статьи
			$artcl['article_title']= preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $artcl['article_title']);
			$log->LogDebug('Got article title - '.$artcl['article_title']);
	}
	*/
	if($artcl['article_title']!=="Статьи"){//Страницы больше не существует
		
		# Получаем тело страницы внутри тега с классом
		$artcl['article_content']=DOM_getHTMLByClass($dom, 'from_bb');
		if(!empty($artcl['article_content'])) $log->LogDebug('Got article content');
		# Очищаем от классов, оставляем только чистые теги
		$artcl['article_content'] = stripslashes( $artcl['article_content']); 
		$artcl['article_content'] = strip_tags( $artcl['article_content'], '<div><span><p><b><a><strong><i><u><strike><em><center><h2><li><ol><ul><br><hr><center>'); // вырезаем все теги кроме... 
		$artcl['article_content'] =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl['article_content']); // у всех тегов вырезаем атрибуты
		$artcl['article_content']= str_replace("<p>&nbsp;</p>",'',$artcl['article_content']);
		$artcl['article_content']= str_replace("<p> </p>",'',$artcl['article_content']);
		$artcl['article_content']= str_replace("<p></p>",'',$artcl['article_content']);
		#Получаем имя автора
		$author_name=strip_tags(DOM_getHTMLByClass($dom, "fio"));
		$artcl['article_content'].='<span itemprop="author">'.$author_name.'</span><br>'.$author_name_link;
		#Проверяем, нет ли автора в черном списке
		$authors_blacklist=array("Юлия Станиславовна");
		//echo $author_name;
		if(!in_array($author_name,$authors_blacklist)){ #Автор не в блеклисте

			#Описание страницы для SEO
			$meta_tags = $dom->getElementsByTagName('meta');
					
			foreach ($meta_tags as $item) {
				if(mb_strtolower($item->getAttribute('name'))=="description"){
						$artcl['SEO_descrtn']=$item->getAttribute('content');
				} elseif($item->getAttribute('property')=="og:image"){
					$artcl['page_img']=$item->getAttribute('content');
				}
			}


			#Параметр page
			$artcl['article_page']=str2url($artcl['article_title']);
			#Проверим page на уникальность
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/check_same_article_title.php');
			
			
			# Дата публикации
			$tags_span =$dom->getElementsByTagName('span');
			foreach ($tags_span as $item) {
				if($item->getAttribute('itemprop')=="datePublished"){ // Дата публикации
					$artcl['pubDate']=$item->getAttribute('content'); 
				}
				
			}

			if(!$artcl['pubDate']) $artcl['pubDate']="CURRENT_TIMESTAMP"; else  $artcl['pubDate']="'".$artcl['pubDate']." ". date("H:i:s")."'";

			
			$author_id=1101;
		//	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_bottom.php';
			
/*
			if($erase_flag==1){// Стираем строку БД, тк надо обновить торрент
				$log->LogDebug('Row deleted');	
			}

			#Перевод на английский названия и тела страницы
			insert_function("translateViaYandex");
			$apikey='trnsl.1.1.20171128T134527Z.fd2d0fd54dcf65d8.dcc32755f10fb041009f6e0cf185858f5500759d';
			$lang='ru-en';
			$artcl['article_title_en']=translateViaYandex($apikey,"$artcl[article_title]",$lang);
			if(!$artcl['article_title_en']) $artcl['article_title_en']=NULL;
			$log->LogDebug('Translate result is: title - '.$artcl['article_title_en']);
			$artcl['article_body_en']=translateViaYandex($apikey,"$artcl[article_content]",$lang);
			if(!$artcl['article_body_en']) $artcl['article_body_en']=NULL;
			$log->LogDebug('Translate result is: body - '.$artcl['article_body_en']);
			
			#Получим ассоциативные слова к названию, чтобы с расставить keywords
			$phrase=$rss_item['title'];
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/get_associative.php');
			
			#Назначим статус статье
			
			if(strlen($artcl['article_content'])<3000){ #Контент страницы маленький, возможно качество статьи низкое, устанавливаем статус dis, чтобы модерировать
				$artcl['status']="nmod";
				#добавляем в таблицу событий на портале с пометкой "Нужна модерация"
				mysql_query("INSERT INTO `$tableprefix-portal-events` 
			  (`text`, `status`, `type`, `link`) VALUES 
			  ('Модерация статьи ".$artcl['article_title']."', 'new', 'need_moderate', 'https://".$sitedomainname."/?page=".$artcl['article_page']."');");
				
			} 
			elseif($rss_config['need_apply']=='manual_confirm'){ //Статус need_moderate, согласно настройкам фида
				
				$post_artcls=0;
				$add_to_message="Страница пока не размещена на сайте и <b>требует ручной активации</b> согласно настройкам фида.\n
				Для подтверждения пройдите по ссылке: <a href='".$sitedomainname."/'>Активировать контент</a> ДОДЕЛАТЬ
				";
				$add_to_theme.=" (Требует активации)";
				$artcl['status']="nmod";
			
			}
			elseif ($rss_config['need_apply']=='auto_confirm') {
				$artcl['status']="ena";
				$post_artcls=1;
				$add_to_message="Страница размещена на сайте <b>автоматически</b> согласно настройкам фида";
			}
			
			# Записываем в БД
			$artcl_add_qt="INSERT INTO `$tableprefix-pages` ( `page`, `pagetitle_ru`, `pagetitle_en`, `pagebody_ru`, `pagebody_en`, 
				`folder`, `filename`, `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-descrtn_ru`, 
				`SEO-descrtn_en`, `showin_all_pages_page`, `is_articles`, `script_after_page`,`page_img`, `creation_date`,`orig_link`,`tags`,`meta`,`status`) 
			VALUES 
			('".$artcl['article_page']."', '". $artcl['article_title']."', '".htmlspecialchars($artcl['article_title_en'], ENT_QUOTES)."',  NULL, NULL, 
				'/pages/','CTATbR.php', 'yes','1101','". $artcl['article_title']."', '". $artcl['article_title']."', '". $artcl['SEO_descrtn']."',
				'". $artcl['SEO_descrtn']."', '".$post_artcls."', '".$post_artcls."', 'show_likes.php;show_related_articles.php;show_article_autor.php','".$artcl['page_img']."', ".$artcl['pubDate'].",'".$rss_item['link']."', '".implode(";",$fin_assoc_arr)."','robots:index,nofollow;Document-state:Static','".$artcl['status']."');";
			mysql_query($artcl_add_qt);

			#Если возникла ошибка добавления
			if(!mysql_insert_id()){
				$add_to_message.="<br>ОШИБКА ДОБАВЛЕНИЯ! ". mysql_errno().mysql_error ()."<br>Запрос был:".$artcl_add_qt;
				$add_to_theme.="(WITH_ERR)";
			} else {
				#Сохраняем тело статьи в файл
				$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html/".$artcl['article_page'];
				file_put_contents ( $filename , $artcl['article_content']);
				if(!file_exists($filename) or (file_exists($filename) and filesize($filename)==0)){
					#Плохо записался файл
					$add_to_message.="<br>ОШИБКА ЗАПИСИ ФАЙЛА НА ДИСК";
					$add_to_theme.="(WITH_ERR)";
					mysql_query("UPDATE `$tableprefix-pages` SET `status`='err' WHERE `page_id`=".mysql_insert_id());
				}
				if($artcl['article_body_en']) { #Английскую версию в другой файл
					$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html_en/".$artcl['article_page'];
					file_put_contents ( $filename , $artcl['article_body_en']);
				}
			}
				
				
			# Тело письма
			$message_to_adm.=$torr_info['name']."<br>
			КОНТЕНТ: ".$artcl['article_title']."<br>
			ОРИГИНАЛ: <a href='".$rss_item['link']."'>".$rss_item['link']."</a><br>
			ССЫЛКА НА ПОРТАЛЕ: <a href='https://".$sitedomainname.'/?page='.$artcl['article_page']."'>".$artcl['article_title']."</a><br>
			СКАЧАНО ЛЕНТОЙ:".$rss_config['feed_name'].' ['.$rss_config['feed_id'].']<br>
			ПРИЧИНА СКАЧИВАНИЯ: '.$dnld_reason.'<br>
			'.$add_to_message.'<br><br><br>';
			
			#НО
			if($psy_NewArticle_notify=="Нет") unset($message_to_adm); //уничтожаем письмо, тк в конфиге указано не отправлять письма
			
			
			#Данные для твита
			$tweet_text=$artcl['article_title']."\r\n".'https://'.$sitedomainname.'/?page='.$artcl['article_page'].'&from=post_tw';
			#Присоединим теги
			foreach($fin_assoc_arr as $tag){
				if($tag){
					if(substr_count($tag,' ')>0){#Тег содержит пробелы
						$tag=trim($tag);
						$tags.='#'.str_replace(' ','_',$tag).' ';
						$tags.='#'.str_replace(' ','',$tag).' ';
					} else $tags.='#'.$tag.' ';
				}
			}
			$tweet_text.=$tags;
			$twitter_image=$artcl['page_img'];
			unset($artcl,$artcl_add_qt,$fin_assoc_arr);

		} else echo "Автор в стоплисте";
*/
		}
	}
}
