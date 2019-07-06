<? # Скрипт обрабатывает данные с новой страницы из RSS и сохраняет информацию в БД 


$log->LogInfo('Got this file');
#Перевод в транслит
insert_function("rus2translit");

$log->LogDebug('Got article title - '.$artcl['article_title']);
	
if(!$artcl['article_title'] or !$artcl['article_content'] or !$author_name or !$artcl['SEO_descrtn']){ //Чето недопарсилось, мог поменяться дизайн
	insert_function("send_letter");
	$message="Не найден обязательный параметр при парсинге страницы<br>
	article_title=".$artcl['article_title']."<br>
	article_content=".$artcl['article_content']."<br>
	author_name=".$author_name."<br>
	SEO_descrtn".$artcl['SEO_descrtn'];
	sendletter_to_admin('При парсинге не найден параметр',$message);
}
	
	
	
# Очищаем от классов, оставляем только чистые теги
$artcl['article_content'] = stripslashes( $artcl['article_content']); 
$artcl['article_content'] = strip_tags( $artcl['article_content'], '<div><span><p><b><a><strong><i><u><strike><em><center><h2><li><ol><ul><br><hr><center>'); // вырезаем все теги кроме... 
$artcl['article_content'] =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl['article_content']); // у всех тегов вырезаем атрибуты
$artcl['article_content']= str_replace("<p>&nbsp;</p>",'',$artcl['article_content']);
$artcl['article_content']= str_replace("<p> </p>",'',$artcl['article_content']);
$artcl['article_content']= str_replace("<p></p>",'',$artcl['article_content']);
#Добавляем имя автора в конец страницы
$artcl['article_content'].='<span itemprop="author">'.$author_name.'</span><br>'.$author_name_link;

#Проверяем, нет ли автора в черном списке
$authors_blacklist=array("Юлия Станиславовна");
if(!in_array($author_name,$authors_blacklist)){ #Автор не в блеклисте

	#Параметр page
	$artcl['article_page']=str2url($artcl['article_title']);
	#Проверим page на уникальность
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/check_same_article_title.php');
	

	if(!$artcl['pubDate']) $artcl['pubDate']="CURRENT_TIMESTAMP"; else  $artcl['pubDate']="'".$artcl['pubDate']." ". date("H:i:s")."'";

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
	if ($rss_item['title']) $phrase=$rss_item['title'];
	else $phrase=$artcl['article_title'];
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
	if(!$post_artcls) $post_artcls=1;
	if(!$artcl['status'])$artcl['status']="ena";
	
	# Записываем в БД
	$artcl_add_qt="INSERT INTO `$tableprefix-pages` ( `page`, `pagetitle_ru`, `pagetitle_en`, `pagebody_ru`, `pagebody_en`, 
		`folder`, `filename`, `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-descrtn_ru`, 
		`SEO-descrtn_en`,`SEO-keywds_ru`, `showin_all_pages_page`, `is_articles`, `script_after_page`,`page_img`, `creation_date`,`orig_link`,`tags`,`meta`,`status`) 
	VALUES 
	('".$artcl['article_page']."', '". $artcl['article_title']."', '".htmlspecialchars($artcl['article_title_en'], ENT_QUOTES)."',  NULL, NULL, 
		'/pages/','CTATbR.php', 'yes','$author_id','". $artcl['article_title']."', '". $artcl['article_title']."', '". $artcl['SEO_descrtn']."',
		'". $artcl['SEO_descrtn']."', '".str_replace(";",",",$artcl['tags'])."', '".$post_artcls."', '".$post_artcls."', 'show_likes.php;show_related_articles.php;show_article_autor.php','".$artcl['page_img']."', ".$artcl['pubDate'].",'".$rss_item['link']."', '".$artcl['tags'].";".implode(";",$fin_assoc_arr)."','robots:index,nofollow;Document-state:Static','".$artcl['status']."');";
	mysql_query($artcl_add_qt);

	#Если возникла ошибка добавления
	if(!mysql_insert_id()){
		$add_to_message.="<br>ОШИБКА ДОБАВЛЕНИЯ! ". mysql_errno().mysql_error ()."<br>Запрос был:".$artcl_add_qt;
		$add_to_theme.="(WITH_ERR)";
	} else {
		#Сохраняем тело статьи в файл
		$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html/".$artcl['article_page'];
		#Обогатим ссылками текст
		$textForLinks=$artcl['article_content']; //Входные данные для скрипта обогащения
		include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/put_links.php'; //Обогощаем
		$artcl['article_content']=$textWithLinks; //Возвращенные данные присваиваем нашему элементу массива
		unset($textForLinks, $textWithLinks); //Стираем временные переменные
		file_put_contents ( $filename , $artcl['article_content']); //Записываем в файл
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
		
		
	
	if($psy_NewArticle_notify!=="Нет"){# Формируем тело письма
		$message_to_adm.=$torr_info['name']."<br>
		КОНТЕНТ: ".$artcl['article_title']."<br>
		ОРИГИНАЛ: <a href='".$rss_item['link']."'>".$rss_item['link']."</a><br>
		ССЫЛКА НА ПОРТАЛЕ: <a href='https://".$sitedomainname.'/?page='.$artcl['article_page']."'>".$artcl['article_title']."</a><br>
		СКАЧАНО ЛЕНТОЙ:".$rss_config['feed_name'].' ['.$rss_config['feed_id'].']<br>
		ПРИЧИНА СКАЧИВАНИЯ: '.$dnld_reason.'<br>
		'.$add_to_message.'<br><br><br>';
	}
	/*
	#Данные для твита (какой то рудимент)
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
	*/
	unset($artcl,$artcl_add_qt,$fin_assoc_arr);

} else echo "Автор в стоплисте";
