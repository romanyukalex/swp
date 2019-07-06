<? # Скрипт парсит новую страницу из RSS и сохраняет информацию в БД  (https://teletype.in/@book30m2)

//	$rss_item['link']=$item->loc;


#Проверим, нет ли его в базе, и если нет, то скачаем
require_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/htmlparserlib/simple_html_dom.php');
#Перевод в транслит
$dnld_item=0; // Флаг для скачивания страницы
$erase_flag=0; // Флаг стирания записи БД

$item_q=mysql_query("SELECT `orig_link` FROM `$tableprefix-books_short` WHERE `orig_link`='".$rss_item['link']."' LIMIT 0,1;");

if(mysql_num_rows($item_q)>0){ // Такой item уже есть
	$log->LogDebug('Page already exist ('.$rss_item['link'].'). Means that old RSS, we can stop to process RSS feed');
	$stop_feed_proc=1; //Флаг, что не надо дальше смотреть линки в ленте
	
} else { // Статьи еще нет, надо скачать
	$log->LogDebug('Item needs to download, its a new page - '.$rss_item['link']);
	$dnld_item=1; // Флаг чтобы скачать
	$dnld_reason=$add_to_theme="Новая публикация из RSS [".$rss_config['feed_name']."]"; //Прибавка к теме письма

}

if($dnld_item==1){ //Если есть флаг скачать страницу
	
	$log->LogDebug('Download page for '.$rss_item['guid']);

	# Получаем данные со страницы
//	$html = file_get_html($rss_item['link']);
//	if ($html) $log->LogDebug('Downloaded page');
	
	#Необходимые данные со страницы (скрипт обработки teletype)
	
	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_teletype.php';
	
	unset($html);
	if($artcl['article_title']) {//Спарсилось нормально, записываем результаты
		$shbook_rec_q=mysql_query("INSERT INTO `freecon-books_short` (`shb_id`, `title`, `img`, `author`, `ts`, `orig_link`, `tags`,`page`) VALUES 
		(NULL, '".$artcl['article_title']."', '".$artcl['page_img']."', '".$author_name."', CURRENT_TIMESTAMP, '".$rss_item['link']."', NULL, '".$artcl['article_page']."');");
		
		#Записываем текст в файл
		$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/books_short_ru/".$artcl['article_page'];
		file_put_contents ( $filename , $artcl['article_content']);
		if(!file_exists($filename) or (file_exists($filename) and filesize($filename)==0)){
			#Плохо записался файл
			$add_to_message.="<br>ОШИБКА ЗАПИСИ ФАЙЛА НА ДИСК";
			$add_to_theme.="(WITH_ERR)";
		}
		if($artcl['article_body_en']) { #Английскую версию в другой файл (чет не работает)
			$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/books_short_en/".$artcl['article_page'];
			file_put_contents ( $filename , $artcl['article_body_en']);
		}
	}
	sleep(2);
}

