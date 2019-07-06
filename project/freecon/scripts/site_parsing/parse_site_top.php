<? # Скрипт проверяет наличие страницы в БД и если в БД ее нет, то скачивает ее текст 

$log->LogInfo('Got this file');

include_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/htmlparserlib/simple_html_dom.php');
#Перевод в транслит
//insert_function("rus2translit");
$dnld_item=0; // Флаг для скачивания страницы
$erase_flag=0; // Флаг стирания записи БД

$item_q=mysql_query("SELECT `orig_link` FROM `$tableprefix-pages` WHERE `orig_link`='".$rss_item['link']."' LIMIT 0,1;");

if(mysql_num_rows($item_q)>0){ // Такой item уже есть
	$log->LogDebug('Page already exist. Means that old RSS, we can stop to process RSS feed');
	$stop_feed_proc=1;
} else { // Статьи еще нет, надо скачать
	$log->LogDebug('Item needs to download, its a new page - '.$rss_item['link']);
	$dnld_item=1; // Флаг чтобы скачать
	$dnld_reason=$add_to_theme="Новая публикация из RSS [".$rss_config['feed_name']."]"; //Прибавка к теме письма
	//if($base_url) $add_to_theme.=' ['.$base_url.$pnum.']';
}

if($dnld_item==1){ // Парсим страницу
	$log->LogDebug('Download page for '.$rss_item['guid']);

	# Получаем данные со страницы
	$html = file_get_html($rss_item['link']);
	$log->LogDebug('Downloaded page');
}
