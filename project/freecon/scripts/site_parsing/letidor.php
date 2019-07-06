<? # Скрипт парсит новую страницу из RSS и сохраняет информацию в БД 

# Пример
#
#$rss_item['link']="https://letidor.ru/obrazovanie/kak-vybrat-pervogo-uchitelya-dlya-rebenka-i-popast-k-nemu-v-klass.htm";
#include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/hbr-russia.php';

foreach($xml->url as $item) {//Перебираем все URL из sitemap

	$rss_item['link']=$item->loc;

	if(strstr($rss_item['link'],"/psihologiya/")){//Этот линк $rss_item['link'] из правильного раздела

		#Проверим, нет ли его в базе, и если нет, то скачаем
		include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_top.php';
		
		if($dnld_item==1){ //Если есть флаг скачать страницу, то значит она уже скачана в parse_site_top.php
			
			#Необходимые данные со страницы
			$artcl['article_title']=$html->find('h1',0)->innertext;
			$artcl['article_content' ]=$html->find('div.jsx-3965092621',0).$html->find('div[itemprop=articleBody]',0);
			$artcl['tags']=$html->find('div.jsx-4146686924',1)->innertext;
			if($html->find('span.jsx-2100764315',0)->innertext) $artcl['tags'].=";".$html->find('span.jsx-2100764315',0)->innertext;
			if($html->find('span.jsx-2100764315',1)->innertext) $artcl['tags'].=";".$html->find('span.jsx-2100764315',1)->innertext;
			$artcl['pubDate']=$html->find('meta[itemprop=datePublished]',0)->content;
			$artcl['SEO_descrtn']=$html->find('meta[name=description]',0)->content;
			$artcl['page_img'] =$html->find('meta',11)->content;
			$author_name= $html->find('div.jsx-1148412995',1)->innertext;

			$author_id=1173;
			include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_bottom.php';
			
		}
	}
}
