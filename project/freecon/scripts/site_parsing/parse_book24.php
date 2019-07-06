<? # Скрипт парсит новую страницу teletype

# Пример
/*$rss_item['link']='https://book24.ru/product/prodvizhenie-lichnykh-blogov-v-instagram-poshagovoe-rukovodstvo-5283395/';
$rss_item['link']='https://book24.ru/product/taynaya-opora-privyazannost-v-zhizni-rebenka-195448/';

include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_book24.php';
mysql_query("INSERT INTO `freecon-books-book24ru` (`name`, `author`, `pics`, `link`, `price`, `publisher`, `year`, `ISBN`, `kw`) VALUES 
('".$book_name."', '".$book_arr['author_name']."', '".$book_arr['img']."', '".$book_link."', '".$book_arr['price']."', '".$book_arr['publisher']."', '".$book_arr['year']."', '".$book_arr['ISBN']."', '".$book_arr['kw']."');");

unset($book_arr);
*/

$log->LogInfo('Got this file');

require_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/htmlparserlib/simple_html_dom.php'); 

if(!$html) {//Значит не скачали еще страничку

	$html = file_get_html($rss_item['link']);
	$log->LogInfo('html downloaded');

} else $log->LogInfo('html already downloaded before');

if($html){ //Страничка скачана, собираем данные с нее
	
	#Необходимые данные со страницы

	foreach($html->find('a.item-tab__chars-link') as $e)
		if(strstr($e->href,"serie")) {
			$book_arr['kw'].=$e->innertext.";";
		}
		elseif(strstr($e->href,"catalog")) {
			$book_arr['kw'].=$e->innertext.";";
			$book_arr['catalog']=$e->innertext;
		}
		elseif(strstr($e->href,"brand")) $book_arr['publisher']=trim($e->innertext);
		elseif(strstr($e->href,"author")) $book_arr['author_name']=trim($e->innertext);
	
	if(!$book_arr['author_name']) $book_arr['author_name']=$html->find('a.js-data-link',0)->innertext;
	
	$book_arr['ISBN']=$html->find('input.isbn__code',0)->value;
	$book_arr['img']=$html->find('meta[property=og:image]',0)->content;
	
	//Удалим нижнюю кнопку
	foreach($html->find('.collapse-panel__more') as $e)	$e->outertext = '';
	$book_arr['description']=$html->find('div.item-detail__about-box',0)->innertext;
	
	
	$book_arr['price']=trim($html->find('div.item-actions__price b',0)->innertext);
	
	foreach($html->find('div.item-tab__chars-item') as $e) {
		if(strstr($e->innertext,"Год")) $book_arr['year']=trim(substr($e->innertext,strpos($e->innertext,'chars-value">')+13,4));
	}
	if(!$book_arr['year']) $book_arr['year']=2019;
	unset($html);
}