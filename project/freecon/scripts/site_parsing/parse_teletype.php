<? # Скрипт парсит новую страницу teletype

# Пример
#$rss_item['link']='https://teletype.in/@book30m2/SJzGFnYHE';

#include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_teletype.php';


$log->LogInfo('Got this file');
insert_function("get_html_code_url");
#Перевод в транслит
insert_function("rus2translit");
require_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/htmlparserlib/simple_html_dom.php'); 

if(!$html) {//Значит не скачали еще страничку

	$html = file_get_html($rss_item['link']);
	$log->LogInfo('html downloaded');
	
} else $log->LogInfo('html already downloaded before');

if($html){ //Страничка скачана, собираем данные с нее
	
	#Необходимые данные со страницы

	$artcl['article_title']=$html->find('h1',0)->innertext;
	$artcl['article_page']=str2url($artcl['article_title']); //Английский транслит от названия статьи
	$author_name= $html->find('div.menu__back_text',0)->innertext;
	$artcl['page_img']=$html->find('img',0)->src;

	#Удаляем картинку из текста
	foreach($html->find('figure') as $e) $e->outertext = '';
	#Находим текст
	$artcl['article_content']=html_entity_decode ($html->find('.article__content',0)->innertext);

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
}