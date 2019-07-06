<? # Скрипт парсит новую страницу из RSS и сохраняет информацию в БД 

# Пример
#$rss_item['link']="https://hbr-russia.ru/management/strategiya/781143";
#$rss_item['link']="https://hbr-russia.ru/liderstvo/psikhologiya/791460";
#include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/hbr-russia.php';

$good_razdel=array(
	"management",
	"psikhologiya",
	"emotsionalnyy-intellekt",
	"fenomeny",
	"nauka",
	"etika-i-reputatsiya",
	"karera"
);
foreach($good_razdel as $razdel){
	if(strstr($rss_item['link'],$razdel)){//Этот линк $rss_item['link'] из правильного раздела
		
		if($dnld_item==1){ //Если есть флаг скачать страницу, то значит она уже скачана в parse_site_top.php
			
			#Необходимые данные со страницы
			$artcl['article_title']=$html->find('h1',0)->innertext;
			$artcl['article_content']=$html->find('div.main-article__text,no-big-first-letter',0);
			//echo $artcl['article_content'];print_r($artcl['article_content']->innertext);
			$artcl['SEO_descrtn']=$html->find('meta[name=description]',0)->content;
			$artcl['page_img'] =$html->find('meta',7)->content;
			
			$author_name=$html->find('span.b-document__caption-authors',0)->innertext;
			$artcl['tags']=$html->find('meta[name=keywords]',0)->content.",".str_replace(" / ",",",$html->find('p[property=articleSection]',0)->innertext);
			$artcl['tags']=str_replace(",",";",$artcl['tags']);
			$author_id=1172;
			#Дата
			$artcl['pubDate'] =$html->find('span.b-document__caption-date',0)->innertext;
			insert_function("date_rus_to_en");
			$dt = new DateTime(date_rus_to_en($artcl['pubDate']));
			$ts = $dt->getTimestamp();
			$artcl['pubDate']=date("Y-m-d",$ts);
			
			if(!strstr($artcl['article_content'] ,"Полная версия статьи доступна подписчикам")) include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_bottom.php';
		}
	}
}