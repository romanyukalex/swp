<? # Скрипт парсит новую страницу из RSS и сохраняет информацию в БД 

# Пример
#$rss_item['link']='http://www.b17.ru/article/103137/';
#include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/b17_articles.php';



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


	$artcl['article_title']=iconv('windows-1251', 'UTF-8',$html->find('h1',0)->innertext);
	//Убираем лишнее из заголовка, бывают пишут ссылки и тп
	$artcl['article_title']= preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $artcl['article_title']);

	if($artcl['article_title']!=="Статьи"){//Страница ещё существует
		
		# Получаем тело страницы внутри тега с классом
		
		$artcl['article_content' ]=$html->find('.from_bb',0);
		#Получаем имя автора
		$author_name=strip_tags($html->find('.fio',0));
		
		$artcl['SEO_descrtn']=$html->find('meta[name=description]',0)->content;
		
		
		$artcl['page_img']=$html->find('link[rel=image_src]',0)->href;
		if(!$artcl['page_img']) $artcl['page_img']=null;
		
		$artcl['pubDate']=$html->find('span[itemprop=datePublished]',0)->content;
		$author_id=1101;
		include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_bottom.php';
		
	}
}
