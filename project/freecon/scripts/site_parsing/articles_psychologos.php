<? ############################# Скрипт парсит страницы Psychologos ###########################
$log->LogInfo('Got this file');


$artcl_cnt=0;//Счетчик статей в RSS
$new_artcl_todb=0;//Счетчик добавленных статей

insert_function("get_html_code_url");

#Функция получения содержимого по названию класса
insert_function("DOM_getHTMLByClass");

#Перевод в транслит
insert_function("rus2translit");

# Все страницы (чтобы исключить повторного скачивания статей)
$page_DB_q=mysql_query("SELECT `page` FROM `$tableprefix-pages` WHERE `orig_link` LIKE '%psychologos.ru%'; ");
while($page_DB=mysql_fetch_array($page_DB_q)){
    $pageDB[$page_DB['page']]=1;
}
unset($page_DB_q);

# Сразу постить или модерировать
if($rss_config['need_apply']=='manual_confirm') {
    $post_artcls=0;
} elseif ($rss_config['need_apply']=='auto_confirm') {
    $post_artcls=1;
}
# Перебираем ленту
foreach($xml->url as $item) {
	
	$sitemap_item['loc']=$item->loc;
	    
    if(mb_strstr($sitemap_item['loc'],"http://www.psychologos.ru/articles/view/")){//Это статья на сайте    
        $artcl_cnt++;
        $page_url=mb_substr($sitemap_item['loc'],40);
      
        if(!$pageDB[$page_url]){
        //echo $sitemap_item['loc']; // Ссылка на статью
        #Скачиваем страничку
        unset($content);
        $content=mb_convert_encoding(get_html_code_url($sitemap_item['loc']), 'HTML-ENTITIES', "UTF-8");
        
        if($dom) unset($dom);
        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        
        # Удаляем javascript из всего HTML
        while (($r = $dom->getElementsByTagName("script")) && $r->length) {
            $r->item(0)->parentNode->removeChild($r->item(0));
        }
        
        $dom->saveHTML();
        
        #Получаем название
        $art_h1 = $dom->getElementsByTagName('h1');
        foreach ($art_h1 as $item) { 
                $artcl['article_title']=trim($item->textContent);//Название статьи
        }
		#Параметр page
		$artcl['article_page']=str2url($artcl['article_title']);
		#Проверим page на уникальность
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/check_same_article_title.php');

        #Удаляем видео в начале статьи
        $div_tags = $dom->getElementsByTagName('div');
                
        foreach ($div_tags as $item) {
            if($item->getAttribute('class')=="tbl-video fright vright" or $item->getAttribute('class')=="jw-media jw-reset"
            or $item->getAttribute('class')=="b-video-info"){
                $item->parentNode->removeChild($item);
            }
        }
        $dom->saveHTML();

        # Получаем тело страницы внутри тега DIV с классом 'article__content'
        $artcl['article_content']=DOM_getHTMLByClass($dom, 'article__content');
        
        # Очищаем от классов, оставляем только чистые теги
        $artcl['article_content'] = stripslashes( $artcl['article_content']); 
        // $artcl['article_content'] = strip_tags( $artcl['article_content'], '<div><span><p><b><a><strong><i><u><strike><em><center><h2><li><ol><ul><br><hr><center>'); // вырезаем все теги кроме... 
        $artcl['article_content'] =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl['article_content']); // у всех тегов вырезаем атрибуты
		$artcl['article_content']=str_replace("'","&#039;",$artcl['article_content']);
		
		
		
		
		#Описание страницы для SEO
        $meta_tags = $dom->getElementsByTagName('meta');
                
        foreach ($meta_tags as $item) {
            if($item->getAttribute('name')=="description"){
                    $artcl['SEO_descrtn']=$item->getAttribute('content');
            } elseif($item->getAttribute('property')=="og:image"){
                $artcl['page_img']=$item->getAttribute('content');
            }
        }

		if(strlen($artcl['article_content']))<3000){ #Контент маленький, возможно качество статьи низкое, устанавливаем статус dis, чтобы модерировать
				$artcl['status']="dis";
		} else $artcl['status']="ena";
			
			
        # Записываем в БД
        mysql_query("INSERT INTO `$tableprefix-pages` ( `page`, `pagetitle_ru`, `pagetitle_en`, `pagebody_ru`, `pagebody_en`, 
		`folder`, `filename`,
         `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-descrtn_ru`, 
        `SEO-descrtn_en`, `showin_all_pages_page`, `is_articles`, `script_after_page`,`page_img`, `creation_date`,`orig_link`,`meta`,`status`) VALUES 
        ('$page_url', '". $artcl['article_title']."', NULL,  NULL, NULL, 
         '/pages/','CTATbR.php',
		 'yes','1103','". $artcl['article_title']."', '". $artcl['article_title']."', '". $artcl['SEO_descrtn']."',
          '". $artcl['SEO_descrtn']."', '".$post_artcls."', '".$post_artcls."', 'show_likes.php;show_article_autor.php','".$artcl['page_img']."', CURRENT_TIMESTAMP,'".$sitemap_item['loc']."','robots:index,nofollow;Document-state:Static','".$artcl['status']."');");
       
        # Защита от повторных записей при дублях в sitemap
        $pageDB[$page_url]=1;
        
		
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
		
		if(!mysql_error()) {
			$new_artcl_todb++; // Увеличиваем счётчик добавленных статей
			$new_artcls_pages[$page_url]=$artcl['article_title'];
		}
		else {//Записываем ошибку при добавлении
			$msql_errs.="<a href='".$sitemap_item['loc']."'>".$artcl['article_title']."</a> вызвала ошибку - ".mysql_error() ."<br>";
			$ins_errs_cnt++;
		}
        // break;//Чтобы 1 прогон был
        // if($artcl_cnt==10) break; //10 статей
		
		
	  }
     
    }
	
	#Данные для твита
	$tweet_text=$artcl['article_title']."\r\n".'https://'.$sitedomainname.'/?page='.$page_url;
		
    unset($artcl);
}

$add_to_theme="Отчёт по работе с порталом ПСИХОЛОГОС [".date("Y-m-d").']';
$message_to_adm="Скрипт обработчик статей только что закончил обработку списка статей Психологоса.<br>
В файле sitemap найдено ".$artcl_cnt.' статей. Возникло ошибок при добавлении - '.$ins_errs_cnt.'.В базу было записано '.$new_artcl_todb.' новых статей:<br><br>';
foreach($new_artcls_pages as $new_page_uri=>$new_page_title){
   $message_to_adm.="<a href='https://".$sitedomainname."/?page=$new_page_uri'>$new_page_title</a><br>";
}
$message_to_adm.="<br><br>Возникали ошибки:".$msql_errs;
//sendletter_to_admin($pl_adm_theme,$pl_adm_mess);