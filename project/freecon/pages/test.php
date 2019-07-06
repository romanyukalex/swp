<br><br><br><br><br>

<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
<i class="fas fa-stroopwafel fa-spin"></i>

<div class="fa-4x">
  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-circle" style="color:Tomato"></i>
    <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6"></i>
  </span>

  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-bookmark"></i>
    <i class="fa-inverse fas fa-heart" data-fa-transform="shrink-10 up-2" style="color:Tomato"></i>
  </span>

  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-play" data-fa-transform="rotate--90 grow-2"></i>
    <i class="fas fa-sun fa-inverse" data-fa-transform="shrink-10 up-2"></i>
    <i class="fas fa-moon fa-inverse" data-fa-transform="shrink-11 down-4.2 left-4"></i>
    <i class="fas fa-star fa-inverse" data-fa-transform="shrink-11 down-4.2 right-4"></i>
  </span>

  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-calendar"></i>
    <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-8 down-3" style="font-weight:900">27</span>
  </span>

  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-certificate"></i>
    <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-11.5 rotate--30" style="font-weight:900">NEW</span>
  </span>

  <span class="fa-layers fa-fw" style="background:MistyRose">
    <i class="fas fa-envelope"></i>
    <span class="fa-layers-counter" style="background:Tomato">1,419</span>
  </span>
  
	 <span class="fa-layers fa-fw">
    <i class="fas fa-headphones-alt" style="cursor:pointer;color:grey"></i>
    <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6" style="color:Tomato"></i>
  </span>
</div>

<div class="fa-4x">
  <i class="fas fa-magic" data-fa-transform="shrink-8" style="background:MistyRose"></i>
  <i class="fas fa-magic" style="background:MistyRose"></i>
  <i class="fas fa-magic" data-fa-transform="grow-6" style="background:MistyRose"></i>
</div>
		

    <!-- This container will become the editable. -->
    <div id="editor">
        <p>This is the initial editor content.</p>
    </div>

 
	
		
		
		
		
		
		
		 <textarea  id="editor1">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href=&quot;https://ckeditor.com/&quot;&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>

<?

if($_REQUEST['action']=="psychologies"){
	$str=$_REQUEST['art_url'];
	$html = file_get_html($str);
	$artcl['article_title' ] =$html->find('h1',0)->innertext;
	$artcl['SEO_descrtn']=$html->find('meta[name=description]',0)->content;
	$artcl['page_img'] =$html->find('meta',11)->content;
	if($pos=strpos($str, 'article-add')) $author_name = $html->find('div.article-add',0)->find('b',0)->innertext;

	$tags=$html->find('div.article-labels a');
	
	foreach($tags as $v)
	{
		$artcl['tags'].=$v->innertext.";";
	}
	$artcl['tags']=substr($artcl['tags'],0,-1);
	$arrr=$html->find('div.article-section ');
	$str=implode($arrr," ");
	$pos=strpos($str, 'section__read-also');

	$artcl['article-content']=$html->find('div.article-content',1).substr($str, 0,$pos);
	if($pos=strpos($str, 'article-add')) $artcl['article-content']=$html->find('div.article-content',1).substr($str, 0,$pos);

	$log->logDebug("$author_name");
	$log->logDebug(print_r($artcl));
}
//$log->logDebug("TESTPOST = ".$_REQUEST['testpost']);
//$log->logDebug("TESTPOST2 = ".$_REQUEST['testpost2']);

/*
		//insert_module("wysiwyg-CKE","init_4","editor1");
		$cke_params="
		
		toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Параграф', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' }
            ]
        }";
		insert_module("wysiwyg-CKE","init_5","classic","#editor","$cke_params");

$categs = array_flip(file($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/b24_cat_ids.txt'));
//print_r($categs);
	
$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/tmp/msk.yml', "r");
if ($handle) { 
    while (($line = fgets($handle)) !== false) { //Читаем файл построчно
		
       
	   if($offer_flag==1){
		  $xmlstring.=$line;
		  if(strstr($line,"</offer>")){ //Конец XML, пора обрабатывать
			
		//	print_r($xml_txt);
			
			$p = xml_parser_create();
			xml_parse_into_struct($p, $xmlstring, $vals, $index);
			xml_parser_free($p);
			//echo "Index array\n";
			//print_r($index);
			//echo "\nVals array\n";
			print_r($vals);echo "<br><br><br><br><br>";
			echo "ID=".$vals[0]['attributes']['ID'].
			"<br>URL=".$vals[3]['value'];

			unset($xml);  
			break;
		   }
	   }
	   if(strstr($line,"<offers>"))$offer_flag=1; //Начнем обрабатывать
	   
    }

    fclose($handle);
} else {
    // error opening the file.
} 
		
		
		
		
/* //Отправить сообщение подписчикам по книгам		
		$subscr_theme='"books":"all"';
		$subscr_post_txt="Новая книга на сайте Клуба здорового сознания:
		".$torr_info['name']."
		https://".$sitedomainname."/?page=book&topic_id=".$torr_info[1]."
		
		--------------
		Вы получили это сообщение потому, что подписались на рассылку о книгах на портале Клуба здорового сознания.
		Чтобы не получать эти сообщения пройдите по ссылке: 
		";
		include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/push_infoToSubcsribers.php');
		
		
		
		
	//	$textForLinks=file_get_contents ($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/lyubov-bolezn-mkb-10');
	//	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/put_links.php';
	//	echo $textWithLinks;
		
/* //Удалить дубликаты (одинаковые `page`) строк
 
$ttt=mysql_query("SELECT `page_id`,`page`, COUNT(`page`) as CNT
FROM `freecon-pages`
GROUP BY `page`
HAVING COUNT(`page`) > 1 ORDER by CNT DESC");

while($tt=mysql_fetch_assoc($ttt)){
	
	if($tt['page_id']!==$not_delete_id) {
		$not_delete_id=$tt['page_id'];
		//Посылаем DELETE
		mysql_query("DELETE FROM `freecon-pages` WHERE `page_id` != '".$not_delete_id."' and `page`='".$tt['page']."'");
		
		//echo "SELECT * FROM `freecon-pages` WHERE `page_id` != '".$not_delete_id."' and `page`='".$tt['page']."'";
	}
}
		



/*




$str="http://www.psychologies.ru/self-knowledge/behavior/schitaete-sebya-mamochkoy-svoemu-kotu/";

//$str="http://www.psychologies.ru/self-knowledge/communication/5-fraz-manipulyatorov-kotoryie-svodyat-nas-s-uma/";

//$str="http://www.psychologies.ru/articles/kak-perestat-iskat-v-mujchine-ottsa/";
$html = file_get_html($str);
$artcl['article_title' ] =$html->find('h1',0)->innertext;
$artcl['SEO_descrtn']=$html->find('meta[name=description]',0)->content;
$artcl['page_img'] =$html->find('meta',11)->content;
if($pos=strpos($str, 'article-add')) $author_name = $html->find('div.article-add',0)->find('b',0)->innertext;

$tags=$html->find('div.article-labels a');
//$artcl['tags']=[];
foreach($tags as $v)
{
	$artcl['tags'].=$v->innertext.";";
}
$artcl['tags']=substr($artcl['tags'],0,-1);
$arrr=$html->find('div.article-section ');
$str=implode($arrr," ");
$pos=strpos($str, 'section__read-also');

$artcl['article-content']=$html->find('div.article-content',1).substr($str, 0,$pos);
if($pos=strpos($str, 'article-add')) $artcl['article-content']=$html->find('div.article-content',1).substr($str, 0,$pos);


//echo $artcl['article-content'];


echo $author_name;
print_r($artcl);

//print_r($artcl['article_content']->innertext);







/*

#####
#Парсинг психологического словаря
#####
insert_function("file_delRowByRownum");
insert_function("get_html_code_url");
#Функция получения содержимого по названию класса
insert_function("DOM_getHTMLByClass");

$links=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/termins.txt';
$fh = fopen($links, 'r');
if(!empty($fh) and $fh!=='' and $fh!==NULL){
	for($jj = 0; $jj <= 4; $jj++){
		$art_engname = trim(fgets($fh));
		
		$rss_item['link']="https://vocabulary.ru/termin/".$art_engname.".html";
		
		//echo "<br><br>".$rss_item['link'];
		
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
		
		#Выберем определения
		$art_div = $dom->getElementsByTagName('div');
		$i=0;
		foreach ($art_div as $item) {
			if($item->getAttribute('itemprop')=="articleBody"){//Это определение (термин)
				//$artcl['termin'][$i]=$item->textContent;
				$artcl['termin'][$i]= DOM_getInnerHTML($item);
				$i++;
			} 
		}
		
		#Выберем источники определения (словари)
		$i=0;
		$tags_a=$dom->getElementsByTagName('a');
		foreach ($tags_a as $item) {
			if($item->getAttribute('class')=="dic"){ // Словарь, из которого взяли определение
				$artcl['dictionary_link'][$i]=$item->getAttribute('href');
				$artcl['dictionary_name'][$i]=$item->textContent; 
				echo $artcl['dictionary_link'][$i];
				echo $artcl['dictionary_name'][$i];
				$i++;
				
			}
		}
		
		#Какие есть словари в БД
		$dic_db_q=mysql_query("SELECT * FROM `freecon-pedia-dics` WHERE 1;");
		while($dic_db=mysql_fetch_assoc($dic_db_q)){
			$dic[$dic_db['dic_link']]=$dic_db['dic_id']; //Сохранили в массив все словари
		}
		
		#Пишем запись о термине в файлы

		$i=0;
		foreach ($artcl['termin'] as $termin){
			
			#Ищем словарь
			if(!$dic[$artcl['dictionary_link'][$i]]){ //Нет такого словаря в БД
				#Запишем новый словарь в БД
				$dic_add_q=mysql_query("INSERT INTO `freecon-pedia-dics` (`dic_id`, `dic_link`, `dic_name`) 
					VALUES (NULL, '".$artcl['dictionary_link'][$i]."', '".$artcl['dictionary_name'][$i]."');"
				);
				$dic_dbId = mysqli_insert_id();//id добавленной строки
			} else {#Словарь есть, вот его ID
				$dic_dbId =$dic[$artcl['dictionary_link'][$i]];
			}
		
			
			#Сохраняем тело статьи в файл
			
			$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/termins/".$art_engname."|_".$dic_dbId;
			file_put_contents ( $filename , $termin);
			
			
			
			
			$i++;
			
		}
		
		#Пишем термин в БД
		$termin_add_q=mysql_query("INSERT INTO `freecon-pedia-artcl` (`id`, `code_en`, `code_ru`, `source_dic`, `tags`, `orig_link`) VALUES 
		(NULL, '".$art_engname."', '".$artcl['article_title']."', '', '".$art_tags."', '".$rss_item['link']."');");
		
		
		#Стираем верхнюю строку в файле
		file_delRowByRownum($links, 1);
		
	}
}
fclose($fh); // Закроем файл до следующего раза


/* Вычистить файл с терминами от того что есть в БД
insert_function("file_search_in");
insert_function("file_delRowByRownum");

$links=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/termins.txt';




$artcl_q=mysql_query("SELECT `code_en` FROM `freecon-pedia-artcl` WHERE 1;");

while($termin=mysql_fetch_assoc($artcl_q)){
	
	
	if($raw_num=file_search_in($links,$termin['code_en'])) {
		echo $raw_num;
		#Стираем строку в файле
		file_delRowByRownum($links, $raw_num);
	}
	
}


/* #Парсинг года в аудиокнигах. Определило процентов 40
insert_function("parse_torrent_name");
$gg=mysql_query("SELECT `id`,`name` from `freecon-torrents-abooks` WHERE `year` is null;");
while($book_info=mysql_fetch_assoc($gg)){
	
	$book_info_p=parse_torrent_name($book_info['name']);
	//$bookauthor=$book_info_p['author'];
	//$bookname=$book_info_p['title'];
	//$book_attr=$book_info_p['tor_attr'];
	if(is_numeric(substr($book_info_p['tor_attr'],0,4))){ //начинается с числа, ок, это число - год
		$year=substr($book_info_p['tor_attr'],0,4);
	} else{
		$book_attr_arr=explode(",",$book_info_p['tor_attr']);
		$year=$book_attr_arr[1];
	}
	//Очищаем год
	$year=trim($year);
	if(!is_numeric($year)){ //Определили не так, попробуем перед MP3
		$book_attr_arr2=explode(", MP3",$book_info_p['tor_attr']);
		$year=substr($book_attr_arr2[0],0,-4);
	}
	//постим в табл
	//echo "<br>У тор - ".$book_info['name'].' год - '.$year;
	if($year and $year!=='' and is_numeric($year)) mysql_query("UPDATE `freecon-torrents-abooks` SET `year`='$year' WHERE `id`='".$book_info['id']."';");
	
	//стираем
	unset($year);
}


/* #Блок книг Эксмо
$pages_all=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/exmo.txt');
$pages_all_arr=explode("\n",$pages_all);
foreach ($pages_all_arr as $row){
	$row_det=explode(":",$row);
	$topic_id= substr($row_det[0],2);
	mysql_query("UPDATE `freecon-torrents` SET `status`='law_block' WHERE `topic_id`='$topic_id'");
	
}
/*
insert_function("dir_to_array");
$dir_arr=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html'); // выбрали все с файлами
$pages_all=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/pages_all.txt');
$pages_all_arr=explode("\r\n",$pages_all);
echo count($dir_arr).' - '.count($pages_all_arr);
foreach($pages_all_arr as $pg){
	$pg=trim($pg);
	if(!in_array($pg,$dir_arr)) {
		
		$del_arr[]=$pg;
	}

}
echo "Без файлов ".count($del_arr);

/* #Удаляем все файлы у которых нет страницы
insert_function("dir_to_array");
$pages_all=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/pages_noFile_del.txt');
$dir_arr=explode("\r\n",$pages_all);
//$dir_arr=file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/pages_noFile_del.txt');
foreach ($dir_arr as $pg){
	$pg=trim($pg);
	mysql_query("UPDATE `freecon-pages` SET `status`='err' WHERE `page`='".$pg."';");
}

/* #Поиск page без файлов
insert_function("dir_to_array");
$dir_arr=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html'); // выбрали все с файлами
$pages_all=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/pages_all.txt');
$pages_all_arr=explode("\r\n",$pages_all);
echo count($dir_arr).' - '.count($pages_all_arr);
foreach($pages_all_arr as $pg){
	$pg=trim($pg);
	if(!in_array($pg,$dir_arr)) {
		
		$del_arr[]=$pg;
	}

}
insert_function("file_writeArrayToFile");
$fileName1=$_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/pages_noFile_del.txt';
file_writeArrayToFile($del_arr,$fileName1);
//	if(!in_array($allp['page'],$dir_arr)) {
		//echo $allp['page']."!!!";
//		$n++;
//	}
	
/*
#Поиск файлов страниц с размером менее 1к
insert_function("dir_to_array");
$dir_arr=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html');

#Получаем массив с размером файла и его именем.
foreach($dir_arr as $fname){
	
	
	if( filesize($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$fname)<1000){#Перебираем массив и ищем те, что меньше 1К
		echo $fname.filesize($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$fname)."<br>";
		#Файл меньше 1к, удаляем строку из БД
		mysql_query("UPDATE `freecon-pages` SET `status`='err' WHERE `page`='".$fname."';");
		#Стираем файл
		unlink($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$fname);
		
	}
}






/* #Ищем одинаковые страницы в БД
$odinak_q=mysql_query("SELECT * FROM `freecon-pages`  
where `page_id` in (select `page_id` from `freecon-pages` group by `page` having count(*) > 1)");
while($odinak=mysql_fetch_assoc($odinak_q)){
	if(!$odinak['orig_link']) {
		$del_arr[$odinak['page']]=$odinak['page_id'];
		mysql_query("DELETE FROM `freecon-pages` WHERE `page_id`='".$odinak['page_id']."';");
	}
	else $ost_arr[$odinak['page']]=$odinak['page_id'];
}
echo count($del_arr);

insert_function("file_writeArrayToFile");
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/odinak.txt', $del_arr, FILE_APPEND);
$fileName1=$_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/odinak_del.txt';
$fileName2=$_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/odinak_ost.txt';
file_writeArrayToFile($del_arr,$fileName1);
file_writeArrayToFile($ost_arr,$fileName2);



/*

$page="pro-telesnost-roditeley-i-rebenka--ov";

if ($language=='ru') $page_html=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$page);
elseif($language=='en') $page_html=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html_en/'.$page);


#Всасываем теги
$tags_array_a= file($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/tags.txt');
$tags_array=explode("\r",$tags_array_a[0]);
#Создаем массив ссылок
$tag_array_links=array();
$n=0;
insert_function("string_replace_nth");
foreach($tags_array as $tag){
	if(mb_strlen($tag)>4){
		$tag=trim($tag);
		
		$search_tag=" ".$tag." ";
		
		#Находим первое вхождение тега в строке 
		$frst_sbstr_pos=mb_stripos($page_html,$search_tag);
		if ($frst_sbstr_pos) { //Тег найден
			echo "Тег '".$search_tag."' найден в позиции ".$frst_sbstr_pos."<br>";
		
			$page_html=string_replace_nth($search_tag, ' <a href="/?page=search_page&search_string='.$tag.'" class="justlink" target="_blank">'.$tag.'</a> ', $page_html, 1);
		
				
			unset($frst_sbstr_pos);
			continue;
		}
	
		
	}
}

echo $page_html;




/*#Перебрал теги


$rows=file($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/tags.txt');
$rows_arr=explode("\r",$rows[0]);
asort($rows_arr);
$tags_arr=array();
foreach ($rows_arr as $row){
	$row=trim($row);
	
	if(mb_strlen($row)>4 and mb_substr($row,0,-3)!=="ить" and mb_substr($row,0,-3)!=="ять"and mb_substr($row,0,-3)!=="еть") {
		$tags_arr[]=$row."\r";
	}
	

}
echo count($tags_arr);
//print_r($tags_arr);
$result=array();
$result = array_unique($tags_arr);
echo count ($result);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/tags2.txt', $result, FILE_APPEND);




/* #Вытащить все теги какие бывают к видео
for($i = 0; $i <= 5; $i++){
	$row_start=$i*1000;
$vtags_q=mysql_query("select `tags` from `freecon-videos` where `tags` is not NULL LIMIT $row_start,1000;");
//$gg=0;
$tag_array=array();
while($vtag=mysql_fetch_assoc($vtags_q)){
	//echo $vtag['tags']."<br>";
	#Делим по тегам
	$this_tags=explode(";",$vtag['tags']);
	//echo $this_tags[0]."<br>";
	foreach($this_tags as $new_tag){
		if(!in_array(mb_strtolower($new_tag),$tag_array)){//Тега еще не было, добавляем
		//	echo $new_tag."<br>";
			array_push($tag_array, mb_strtolower($new_tag));
		}
	}
	//print_r($tag_array);
	//echo "<hr>";
	//$gg++;
	//if($gg==6) exit;
}
echo "В массиве ".count($tag_array).' элементов';
foreach ($tag_array as $tag){
	$tags_string.=$tag."\r\n";
}
}
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/tags.txt', $tags_string, FILE_APPEND);

/* #Проверить ошибки на яндекс спеллере
insert_function("get_html_code_url");

$uri="https://speller.yandex.net/services/spellservice.json/checkText?text=синхрафазатрон+в+дубне";
$code = get_html_code_url($uri);
?><pre><?
print_r($code);
?></pre>

<?
/* #Парсинг закупок, но без логина

insert_function("add_to_end_of_file");
insert_function("DOM_getHTMLByClass");


insert_function("get_html_code_url");

$auth_link="https://auth.kontur.ru/emailapprove?approvekey=D05315252FA23AC9C1E4BEC1E7A402D08EB93E9421B74053ED0F534D780473F093A320320DE815468580CDF1FC3A3D80E5149A0D8C11EA8926D4882439D74F5B3DE2E9C81BD3CD2470EEEF71790A83E49A210A87BC38A1D52CBBD92DEC955E765DC4370F7A36E6379692D6E3B243E0F7D5C4337A0EEBA035FF38B53147196280&email=sales%40spacecorp-rkd.ru&remember=false&back=https%3a%2f%2fkontur.ru%2f&customize=default";
$content2=get_html_code_url($auth_link);

$link="https://zakupki.kontur.ru/0111200000616000057";
# Получаем данные со страницы

	$content=get_html_code_url($link);
	echo $content;
	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);
	#Получаем название
	$art_h1 = DOM_getHTMLByClass($dom, 'js-roundupCompany');
	//echo mb_convert_encoding($art_h1,"utf-8","UTF-8");
	echo mb_detect_encoding($art_h1);
	$file=$_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/kontur_test.csv';
	add_to_end_of_file($art_h1, $file);

	
	$tags = $dom->getElementsByTagName('a');
foreach ($tags as $item) {
	//if($item->getAttribute('class')=="js-roundupCompany"){
		//$jokehtml= DOM_getInnerHTML($item);
		echo $item->getAttribute('class').' '.$item->getAttribute('href')."<br>";
	//} 
}
	
	
	
/*
$phrase='Почему люди видят нас искаженно.';
include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/get_associative.php'); 
print_r($fin_assoc_arr);

/*
#Не работает, не доделана youtube-api
$playlist_id="PLbtvafp98VwCUw43MBSxj-TkkACDcYmfX";
$video_id="yTtZWaBmgX0";
insert_module("youtube-api","save_video_to_playlist","$playlist_id","$video_id");




/* #Репостнувшие нужный пост VK

$owner_id="-95462752";
$post_id="2633";


$repost_info=insert_module("vk-api","get_repost_info",$owner_id,$post_id);


foreach( $repost_info ['response']['items'] as $repost_user){
	
	$user_info=mysql_query("SELECT * FROM `freecon-users` WHERE `provider`='vk' AND `social_id`='".$repost_user['uid']."';");
	if(mysql_num_rows($user_info)==0) { // НЕТ в БД,добавляем в БД пользователей
		mysql_query("INSERT INTO `freecon-users` ( `userrole`,  `second_name`, `first_name`,   `status`,  `timestamp`,  `provider`, `social_id`) VALUES 
		( 'user', '".$repost_user['last_name']."', '".$repost_user['first_name']."',  'active', CURRENT_TIMESTAMP,'vk', '".$repost_user['uid']."');");
	}
	
	if($repost_user['uid']==313329033) {
		echo "Отправляем message";
		$access_token_gr="e47be56aa14fc76345b318026db429a4f9f5a3e75f5a901f474e43e6b8de65803ef57558b670c5fb67311"; //токен сообщества
		$mes_toUser=insert_module("vk-api","send_message",$repost_user['uid'],"Привет",$access_token_gr);
	}
}


/*
# Импорт из Excel
//https://phpspreadsheet.readthedocs.io/en/develop/#hello-world
//https://phpspreadsheet.readthedocs.io/en/develop/topics/reading-files/

require $_SERVER['DOCUMENT_ROOT'].'/modules/PHPExcel/vendor/autoload.php';

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$inputFileType = 'Xlsx';
$inputFileName = $_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/products.xlsx';
$sheetname = 'Лист1';
# Load $inputFileName to a Spreadsheet Object  
//$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
#  Advise the Reader that we only want to load cell data
$reader->setReadDataOnly(true);
$reader->setLoadSheetsOnly($sheetname);
#  Load $inputFileName to a Spreadsheet Object
$spreadsheet = $reader->load($inputFileName);


$worksheetData = $reader->listWorksheetInfo($inputFileName);

echo '<h3>Worksheet Information</h3>';
echo '<ol>';
foreach ($worksheetData as $worksheet) {
    echo '<li>', $worksheet['worksheetName'], '<br />';
    echo 'Rows: ', $worksheet['totalRows'],
         ' Columns: ', $worksheet['totalColumns'], '<br />';
    echo 'Cell Range: A1:',
    $worksheet['lastColumnLetter'], $worksheet['totalRows'];
    echo '</li>';
}
echo '</ol>';

var_dump($spreadsheet );
/*
if(!$ip) include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");
echo $ip."!";
$cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);
echo $cityName;

//insert_module("counter-fb_pixel");

/*

include($_SERVER["DOCUMENT_ROOT"]."/project/freecon/scripts/show_banner.php");

$banner = new swpbanner(3,"param1"); 

$banner->print_result;
//Добавляем ключевые слова
$banner->add_kw("Мужчина;ребенок");
$banner->add_kw("Женщина");

//Добавляем страничку на которой мы сейчас
$banner->add_page($page);
//Добавляем регион смотрящего
$banner->add_region($city);
//Подготовь вот столько баннеров по всем параметрам
$banner->filter(3);

//echo $banner->get_banner(2,"a_title");
//echo $banner->get_banner(1,"banner_id");



	?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff">
	<a target="_blank" class="justlink" href="<?=$banner->get_banner(1,"link")?>"<? if($banner->get_banner(1,'a_title')){?>title="<?=$banner->get_banner(1,'a_title')?>"<?}?>>
	<b style="font-size:14px"><?=$banner->get_banner(1,'text_1')?></b><br>
	<img src="/project/<?=$projectname?>/<?=$banner->get_banner(1,'img')?>" style="width: 100%;padding 5px;">
	<span style="font-size:12px"><?=$banner->get_banner(1,'text_2')?></span>
	</a>
	</div><?

//var_dump(get_object_vars($banner));

*/


/*
#Сбросить данные торрентов из базы на диск
$page_q=mysql_query("SELECT * FROM `freecon-torrents` WHERE `orig_desc` is not null LIMIT 0,1000;");
while($pd=mysql_fetch_assoc($page_q)){
	echo $pd['topic_id'];
	$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/torrents/".$pd['topic_id'];
	if(file_put_contents ( $filename , $pd['orig_desc'])){
	mysql_query("UPDATE `freecon-torrents` SET 
	`orig_desc` = NULL 
	WHERE `id` = ".$pd['id'].";");
	}

}
*/
/*
 #Сбросить данные из базы на диск
$page_q=mysql_query("SELECT * FROM `freecon-pages` WHERE `pagebody_ru` IS NOT NULL AND `orig_link` LIKE '%b17%' LIMIT 0,10000;");
while($pd=mysql_fetch_assoc($page_q)){
	//echo $pd['page'].$pd['autor'];
	$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html/".$pd['page'];
	file_put_contents ( $filename , $pd['pagebody_ru']);
	mysql_query("UPDATE `freecon-pages` SET 
	`pagebody_ru` = NULL ,
	`folder`='/pages/html/',
	`filename`='".$pd['page']."',
	`cache_time`=0
	WHERE `page_id` = ".$pd['page_id'].";");

}
*/




/*
$kws="изменить свою жизнь,управлять жизнью,шаг на пути к изменениям,тантра,Снятие стресса,поддержание иммунитета йог,повысить уровень энергии,избавление от страха,йога упокоиться,Медитация Любовь,расслабить нервную систему,йога баланс нервной энергии,эмоциональный баланс,от внутреннего гнева,бросить курить,йога успокоение ума,йога контроль ума,йога избавления от болезней,внутренняя стабильность,йога давление,йога проснуться,йога бодрость,йога напряжение,телесные практики,мотивировать себя на спорт,Каббала,Веды,Трансерфинг,ОШО,притягивать деньги,гипноз на деньги,25 кадр деньги,притяжение денег,привлечение изобилия,удаление денежных блоков,негативные установки про деньги,изобильное мышление,что блокирует богатство,психология денег,психология богатства,нлп и деньги,деньги и богатство,психология бедности,ограничивающие убеждения про деньги,секреты богатства,психология богатства,НЛП деньги,секреты богатых людей,аффирмация на богатство,запрограммировать на богатство,НЛП богатство,стать магнитом денег,установка на успех богатство,программа на богатство,энергия изобилия,симорон на деньги,секреты миллионеров,личный финансовый план,управлять личными финансами,как ставить цели,достигать цели,долгосрочные цели,постановка целей,почему цели не достигаются,SMART цели,системы достижения целей,методики постановки целей,цели колесо жизни,колесо жизненного баланса,шагов к цели,методика ЦОЗАР,технология постановки целей,целеполагание,стратегическое планирование жизни,краткосрочные цели,планирование на год,планирование дней,планирование на 10 лет,концепция построения целей,ошибки при постановке целей,постановка намерения,НЛП достижение целей,бессознательные цели,целедостижение,самопрограммирование на достижение целей,как добиться любой цели, декомпозиция целей,как и зачем ставить цели,экологичность цели,формулировка цели,формулировка цели,определение цели,концентрация на цели,как определить свои цели,жизненные стратегии,карта мечты,карта желаний,коллаж желаний,как правильно мечтать,от мечты до цели,реализовать цели и мечты,методы управления вниманием,как высыпаться,скорочтение,развитие памяти,ораторское искусство,научиться говорить на публике,как подготовить выступление,умение говорить публично,управлять вниманием аудитории,говорить так чтобы слушали,сторителлинг,секреты ораторского мастерства,техники ответов на вопросы аудитории,структура публичной речи,преодолеть волнение во время выступления,подготовка презентации,упражнения для дикции,как улучшить голос,постановка голоса,голосовая разминка,технология импровизации, страх публичных выступлений,самопрезентация,риторика,правильно дышать во время выспуплений,упражнения для речи,упражнения для дикции,скороговорки для дикции,артикуляционная разминка,выступление на публике,приемы оратора,искусство убеждения,черная риторика,техники переговоров,жесткие переговоры,жестикуляция,работа руками на сцене,юмор при выступлениях,метафоры в выступлениях,ответ на каверзный вопрос,повысить энергетику выступления,харизматичный оратор,интонации,быть убедительным,актерское мастерство,развить чувство юмора,актерские упражнения,взаимодействие с аудиторией,вовлечение аудитории,как стать лидером, стратегия лидера, стратегии лидеров, как принимать решение, как управлять, харизма лидера, идеология лидера, как думает лидер, мышление лидера, картина мира лидера, лидерские качества, лидерство, правила лидерства, психология лидерства,агрессивность лидера, стили лидерства, привычки лидера, навыки лидера,кодекс лидера,лидерские роли,лидерские фишки, методы работы лидера,неформальный лидер,потенциал лидера, статус лидера,способы развития лидерского потенциала, энергетика лидера, черты личности лидера, лидерские навыки, стать лидером, развитие лидерских качеств,негативный лидер, ошибки лидера, лидерский прорыв, захват лидерства,внешнее окружение лидера,что такое лидерство, про лидерство,негласный авторитет, авторитет лидера, развитие лидерских качеств, как управлять командой, приемы лидера,эмоциональное лидерство, манипуляции и лидерство, показать, кто хозяин, психогеография манипуляций и лидерсво,лидер и команда, из аутсайдеров в лидеры, лидерство в коллективе, управление командой, нравственное лидерство, уроки лидерства, управлять коллективом, фишки в управлении, управление конфликтом, управление собой,управление эмоциями окружающих людей, эффективное руководство, научиться руководить, приемы руководства,руководить командой, психокомплексы при управлении людьми, психология руководителя, навыки руководителя, как руководить идеально, как мотивировать команду, как подобрать сильных сотрудников, как стать хорошим руководителем, качества начальника, качества руководителя, стать лучшим управленцем, стать начальником, ключевые компитенции руководителя, как работать с людьми, управление персоналом, как вести себя начальнику, как мотивировать сотрудников, основы управления персонала,методы мотивации, правила общения с командой,нематериальная мотивация, увеличить эффективность сотрудника,формула мотивации,как бросить курить,как бросить пить,как избавиться от вредных привычек,эффективно работать с информацией,стать уверенным,повысить самооценку,обрести уверенность,развить уверенность,комплексы,причины неуверенности в себе,как перестать стесняться,побороть неуверенность,избавиться от неуверенности,психология уверенного человека,как перестать бояться,увеличить уверенность,работа с неуверенностью,что такое уверенность,выйти из зоны комфорта,стать смелым,стать уверенным,что делать с комплексами,комплексы мешают нам жить,как полюбить свои комлексы, как полюбить себя,избавиться от комплексов,негативные убеждения и комплексы,комплексы и негативные блоки сознания,НЛП и самооценка,НЛП и уверенность в себе,безусловное принятие себя,как принимать себя такого как ты есть,гипноз на уверенность в себе,способов научиться любить себя,что значит любить себя,научиться принимать себя,быть в гармонии с собой,начать ценить любить уважать себя,почувствовать уверенность в своих силах,заниженная самоценка, комплекс неполноценности,техники повышения самооценки,способ повысить самооценку,развить смелость,управление страхом,воспитать смелость,психология уверенности,прокачать уверенность и харизму,от страха к смелости,я все могу,медитация уверенности в себе,реагировать на критику,невербальная коммуникация, Виды невербальных средств общения, язык жестов, Язык тела, небербальный язык, невербальная коммуникация мужчины и женщины, невербальная коммуникация, метасообщения в НЛП, скрытые послания тела,невербальное общение, сигналы тела, психология лжи,влияние невербальной коммуникации,каналы коммуникации:мимика, пантомимика, позы,жесты, невербальное поведение, секреты невербального общения, НЛП присоединение и ведение, что говорят жесты,межкультурная коммуникация, тайны невербальной коммуникации, невербальная коммуникация в продажах, невербальные послания,двойное послание,вербальное и невербальное,физиогномика, как читать по лицу, что жесте говорят о человеке, значение языка жестов, навыки невербальной коммуникации, распознать лжеца по движению глаз, теория лжи, жестикуляция, невербальная коммуникация в деловом общении, значение жестов, как читать лицо человека, жесты уверенности,мотивация на успех, мотивация на успех в бизнесе, мотивация и воля, выход из зоны комфорта, самомотивация, замотивировать себя, от чего зависит мотивация, найти мотивацию, вдохновить себя, потеря мотивации,достигать, мотивация к работе, сила воли, жить на высокой скорости,искуство саморегуляции, негативная мотивация, побуждающая мотивация, типы личности и мотивация, удовольствие и мотивация, позитивная мотивация, пропала мотивация, восстановить мотивацию,вдохновить себя, победить лень, от всего устал, новый ты, лучшая мотивация, помивация похудеть, мотивация для девушек, мотивация для мужчин, боимся что-то менять, мотивация к действию, измени себя, мотивационные ролики, побороть лень,прокрастинация, апатия, ничего не хочется, не верю , дипрессия, бороться с ленью, робедить лень,выход из кризиса, шаги для выхода из кризиса, самостоятельное решение своих проблем, поиск ресурсов, где взять силы, возрастной кризис, личностный кризис, кризис в отношениях, кризис доверия в паре, кризис идентичности, кризис среднего возраста, личностные кризисы,  женские кризисы, мужские кризисы, кризис института семьи, что делать в личностном кризисе, мужчины в кризис , преодолеть жизненный кризис, призис четверти жизни,  выйти из дипрессии, не хочу жить, не могу изменить, кризис середины жизни, правила жизни, как получается кризис, усталость от жизни, духовный кризис, как пережить смерть близкого человека, как снова встать на ноги, причины дипрессии, как пережить,звездная карьера, как подняться по служебной лестнице, профессиональная карьера, должностной рост, карьерная лестница, сделать карьеру, стремительная карьера, повышение по службе. стить руководителем, стать босом, стать начальником, получить повышение, повышение зарплаты, качества для быстрого роста, работа мечты, начать карьеру, разрушить карьеру, завоевать авторит у руководства, успешная карьера, залог успешной карьеры, карьерист, карьера для мужчин, карьера для женщин, самореализация,психология карьериста,Как избавляться от назойливых мыслей,отучать себя от обвинений,отучать себя от оправданий,где взять энергию, как стать энергичным, харизма лидера, источники энергетики, как увеличить энергетику, как повысить энергетику, что влияет на энергетику, каков источник нашей энергетики,секреты настоящего мужчины,скрипты и алгоритмы успеха, модель успешного мужчины, портрет успешного мужчины, самоменеджмент,навыки успешного мужчины,стать мужчиной,бизнес по женски,женский бизнес,как заработать женщине,как стать успешным руководителем женщине,женская самореализация,Женское предназначение,Женская харизма, сексуальный голос,упражнения голоса, как выработать магнитичный взгляд, невербальная коммуникация ,женщины,невербальная коммуникация с мужчинами,позы и жесты удерживающие внимание мужчин, хитрости женщин,язык тела сигналы любви,мимика, телодвижения, сексуальные сигналы,флирт,успех,лидерство в семье,семейные ценности,жены и любовницы,научить ребенка,воспитать лидера,развивать лидерство,научить ребенка лидерству";
$kw_arr=explode(",",$kws);
foreach($kw_arr as $kw){
	$kw=trim($kw);
	$abook_q="INSERT INTO `freecon-torrents-abooks` SELECT *  FROM `freecon-torrents-db` WHERE`name` LIKE '%$kw%' 

and 

	(`name` LIKE '%mp3%' or `name` LIKE '%FLAC%' or `name` LIKE '%WAV%')

";
	$abook_cnt=mysql_query($abook_q);
	echo  $abook_q;
}
*/
/*
$abook_q="SELECT count(`id`) as CNT  FROM `freecon-torrents-abooks` WHERE `cat_id` = 2152 or `cat_id`=716 or `cat_id`=403 or `cat_id`=2165 or 

((".mb_substr($abook_q,0,-3).") 

and 

	(`name` LIKE '%mp3%' or `name` LIKE '%FLAC%' or `name` LIKE '%WAV%')

)";

echo $abook_q;
//$abook_cnt=mysql_fetch_array(mysql_query($abook_q));
//echo  $abook_cnt['CNT'];
*/
/*

INSERT REPLACE INTO `freecon-torrents-abooks`
SELECT *  FROM `freecon-torrents-db` WHERE `cat_id` = 2152 or `cat_id`=716 or `cat_id`=403 or `cat_id`=2165 or 

((`name` LIKE '%психол%' or 
`name` LIKE '%ораторск%' or 
`name` LIKE '%личностное%' or 
`name` LIKE '%стресс%' or 
`name` LIKE '%цели%' or 
`name` LIKE '%нлп%' or 
`name` LIKE '%внимани%' or 
`name` LIKE '%стать лидер%' or 
`name` LIKE '%самооценк%' or 
`name` LIKE '%коммуника%' or 
`name` LIKE '%вербальн%' or 
`name` LIKE '%карьер%' or 
`name` LIKE '%менеджмент%' or 
`name` LIKE '%бизнес%' or 
`name` LIKE '%успе%' or 
`name` LIKE '%воспит%' or 
`name` LIKE '% транс%' or 
`name` LIKE '%гипноз%' or 
`name` LIKE '%терапия%' or 
`name` LIKE '%терапевтичес%' or 
`name` LIKE '%психоанали%' or 
`name` LIKE '%метафор%' or 
`name` LIKE '%сомати%' or 
`name` LIKE '%мозг%' or 
`name` LIKE '%випассан%' or 
`name` LIKE '%медитац%'
) 

and 

	(`name` LIKE '%mp3%' or `name` LIKE '%FLAC%' or `name` LIKE '%WAV%')

)*/


/*

#Загрузить торренты с rutracker из файла CSV
$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/project/freecon/files/test2.txt", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        //echo $buffer;
		$data=explode(";",$buffer);
		for($i = 0; $i <= 7; $i++){
		//($data as $element){
			if($i==7) echo $data1[]=mb_substr($data[$i],1,-2);
			else echo $data1[]=mb_substr($data[$i],1,-1);
			//if(mb_substr())
		}
		//hash,topic_id,name,size,date,time,cat_id,cat_name
		mysql_query("INSERT INTO `freecon-torrents-abooks` 
		(`id`, `name`, `hash`, `date`, `time`, `size`, `topic_id`, `cat_id`, `cat_name`, `year`, `orig_img`, `orig_desc`, `soc_posted`, `status`) VALUES 
		(NULL, '".$data1[2]."', '".$data1[0]."', '".$data1[4]."', NULL, '".$data1[3]."', '".$data1[1]."', '".$data1[6]."', '".$data1[7]."', NULL, NULL, NULL, NULL, 'active');");
		//echo $data1[0]."<br>";
		unset($data,$data1);
		//exit();
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

*/







/* #Найти дубли в шутках. Не работает, перегружает браузер ожиданием ответа
$jokesq1=mysql_query("SELECT * FROM `freecon-jokes` ORDER BY `joke_id` DESC;");
while($jokes_data1=mysql_fetch_array($jokesq1)){
	$jokes_arr1[$jokes_data1['joke_id']]=$jokes_data1['text'];
}
$jokes_arr2=$jokes_arr1;
unset($jokesq1);
//$jokesq2=mysql_query("SELECT * FROM `freecon-jokes` ORDER BY `joke_id` DESC;");
foreach($jokes_arr1 as $joke_id1=>$joke_text1){
	foreach($jokes_arr2 as $joke_id2=>$joke_text2){
		
		similar_text ( $joke_text2 , $joke_text1, $percent );
		if($percent>80) $percent_arr [$joke_id1][$joke_id2]=$percent ;
	}
	
}
print_r( $percent_arr);
*/


/*
#Анекдоты от http://anekdot.ru

insert_function("get_html_code_url");
insert_function("DOM_getHTMLByClass");

//Запрос
$base_url ="https://www.anekdot.ru/search/?query=%D0%BF%D1%81%D0%B8%D1%85%D0%B8%D0%B0%D1%82%D1%80&xcnt=100&maxlen=0&order=0&mode=phrase&ch%5Bj%5D=on&ch%5Bs%5D=on&page=";

$i="11"; // Номер страницы

$url=$base_url.$i;
$xmlstr =  get_html_code_url($url ,NULL,"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36");

	#Скачиваем страничку
	unset($content);
	$content=mb_convert_encoding($xmlstr, 'HTML-ENTITIES', "UTF-8");

	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);
	
	# Удаляем javascript из всего HTML
	while (($r = $dom->getElementsByTagName("script")) && $r->length) {
		$r->item(0)->parentNode->removeChild($r->item(0));
	}
	
	$dom->saveHTML();
	
	$artls_tags = $dom->getElementsByTagName('div');
	foreach ($artls_tags as $item) {
		if($item->getAttribute('class')=="text"){
		
			$jokehtml= DOM_getInnerHTML($item);
			$joketext=str_replace("<br>","\n",$jokehtml);
			$joketext=str_replace('<span style="background-color:#ffff80">',"",$joketext);
			$joketext=str_replace('</span>',"",$joketext);

			mysql_query("INSERT INTO `freecon-jokes` (`joke_id`, `text`, `orig_link`, `author`, `pubDate`) 
			VALUES (NULL, '".$joketext."', 'https://www.anekdot.ru/search/?query=психиатр', NULL, CURRENT_TIMESTAMP);");
		}
	}
*/






/*
# Анекдоты от www.psyh.ru/

insert_function("get_html_code_url");

$base_url = "https://www.psyh.ru/anecdotes/?page=";


$endpag=67;

for($i=2;$i<$endpag;$i++){

	$url=$base_url.$i;
	$xmlstr =  get_html_code_url($url ,NULL,"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36");

	#Скачиваем страничку
	unset($content);
	$content=mb_convert_encoding($xmlstr, 'HTML-ENTITIES', "UTF-8");

	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);
	
	# Удаляем javascript из всего HTML
	while (($r = $dom->getElementsByTagName("script")) && $r->length) {
		$r->item(0)->parentNode->removeChild($r->item(0));
	}
	
	$dom->saveHTML();
	
	while (($r = $dom->getElementsByTagName("a")) && $r->length) {
            $r->item(0)->parentNode->removeChild($r->item(0));
        }
		
	
	$dom->saveHTML();
	
	$artls_tags = $dom->getElementsByTagName('article');
	foreach ($artls_tags as $item) {
		if($item->getAttribute('class')=="singleBlockG"){
			$joketext=str_replace("Владислав Божедай",'',$item->nodeValue);
		
			mysql_query("INSERT INTO `freecon-jokes` (`joke_id`, `text`, `orig_link`, `author`, `pubDate`) 
			VALUES (NULL, '".$joketext."', 'https://www.psyh.ru/anecdotes/', NULL, CURRENT_TIMESTAMP);");
		}
	}
}
*/

/* #Прокси запрос. Не работает
if($_GET['ip']!=="trues"){
 # Скачать статьи с B17
	insert_function("get_html_code_url");
	insert_function("DOM_getHTMLByClass");
	$page_num=1;//Количество страниц для прохода
	$pnum=$b17scanpage;//Стартовая страница
//	$base_url='https://www.b17.ru/article/?page=2';
$base_url="https://test.nlp-course.ru/?page=test&ip=trues";
	$rss_config['need_apply']='auto_confirm';

	echo ($b17scanpage+$page_num);



	while($end_flag<1){
		
//		$url=$base_url.$pnum; // Новый URL
		$content=NULL;
		//$content=get_html_code_url($url); // Получаем страницу

		
			$url=$base_url.$pnum; // Новый URL
		$content=NULL;
		//$content=get_html_code_url($url); // Получаем страницу

		
		
				
		
		
		
		
		
		$aContext = array(
			'https' => array(
			
			'proxy' => 'tcp://204.12.155.204:3128',
			'request_fulluri' => true,
			),
		);
$cxContext = stream_context_create($aContext);

$sFile = file_get_contents($base_url, False, $cxContext);

echo "file ".$sFile." end file";

	}

	//Записываем страницу для следующего прогона
//	mysql_query("UPDATE `freecon-siteconfig` SET `value` = '".($b17scanpage+$page_num)."' WHERE `freecon-siteconfig`.`id` = 178;");
//}

}
else {include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");
	echo "ip=".$ip;

}

*/

/* #Кнопка оплаты
include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");

$cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);
echo "Город ".$cityName;

//echo $_SERVER['HTTP_HOST'];
//if($_SERVER['HTTP_HOST']=='psy-space.ru') $shop_id="Psy-space";
//else 
	$shop_id='nlp-course.ru';

$pay_detail_arr=array(
'button_type'=>'with_label',
'method'=>'POST',
'order_id'=>'123',
'order_desc'=>'Клубный взнос за месяц',
'summ'=>'100',
'button_text'=>'Оплатить месяц участия',
'button_form'=>'S', 
'shop_id'=>$shop_id,
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

$pay_detail_arr=array(
'button_type'=>'with_label',
'method'=>'POST',
'order_id'=>'123',
'order_desc'=>'Клубный взнос за год',
'summ'=>'500',
'button_text'=>'Оплатить год участия',
'button_form'=>'S', 
'shop_id'=>'nlp-course.ru',
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);


//print_r($log->custfunc());


/*
# Скачать все статьи с Selfgrowth
insert_function("get_html_code_url");
insert_function("DOM_getHTMLByClass");
$pnum=2;//Стартовая страница, должна быть более 1, тк первая отв.301
$page_num=160;//Стоповая страница (Количество страниц для прохода)

$base_url='http://selfgrowth.ru/page/';

$rss_config['need_apply']='auto_confirm';
$rss_config['def_author_id']='1109';

while($end_flag<1){
	
	$url=$base_url.$pnum.'/'; // Новый URL
	$content=NULL;
	$content=get_html_code_url($url); // Получаем страницу

	if(mb_strstr($content,"Извините, но вы ищете то, чего здесь нет")) break;

	if($dom) unset($dom);
	$dom = new DOMDocument;
	@$dom->loadHTML($content);

	#Получаем ссылки
	$page_a = $dom->getElementsByTagName('a');
	foreach ($page_a as $item) {
		if(strstr($item->getAttribute('rel'),"bookmark")){ // Ссылка на статью
			$rss_item['link']=$item->getAttribute('href');
			$log->LogDebug($rss_item['link']);
			$rss_item['title']=$item->textContent;
			include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/selfgrowth_ru.php';
		}
	}



	if($pnum==$page_num){ $end_flag=1;}
	$pnum++;
}

*/

/*

if(($now_hour % 2 === 0) AND $now_min=="25"){

	 # Скачать статьи с B17
	insert_function("get_html_code_url");
	insert_function("DOM_getHTMLByClass");
	$page_num=1;//Количество страниц для прохода
	$pnum=$b17scanpage;//Стартовая страница
	$base_url='https://www.b17.ru/article/?page=';

	$rss_config['need_apply']='auto_confirm';

	echo ($b17scanpage+$page_num);



	while($end_flag<1){
		
		$url=$base_url.$pnum; // Новый URL
		$content=NULL;
		$content=get_html_code_url($url); // Получаем страницу

		if($dom) unset($dom);
		$dom = new DOMDocument;
		@$dom->loadHTML($content);

		#Получаем ссылки
		$page_a = $dom->getElementsByTagName('a');
		foreach ($page_a as $item) {
			if(strstr($item->getAttribute('href'),"/article/") AND !strstr($item->getAttribute('href'),"/article/?") and !strstr($item->getAttribute('href'),"/article/&") and $item->getAttribute('href')!=='http://www.b17.ru/article/'){ // Ссылка на статью
				
				$rss_item['link']='http://www.b17.ru'.$item->getAttribute('href');
				$log->LogDebug($rss_item['link']);
				include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_b17_articles.php';
			}
		}



		if($pnum==($b17scanpage+$page_num-1)){ $end_flag=1;}
		$pnum--;
	}

	//Записываем страницу для следующего прогона
	mysql_query("UPDATE `freecon-siteconfig` SET `value` = '".($b17scanpage-$page_num)."' WHERE `freecon-siteconfig`.`id` = 178;");
}

*/



/*
insert_module('region_data');

# button_type=without_label;with_label
# method=POST;GET - only for button_type=without_label
# button_text and button_class - only for button_type=without_label
# button_form=S;M;SS;MS;L;V;FL;FLS    -  all is only for button_type=with_label. FL;FLS is with flexible price (user choosen) 

# Type1
$pay_detail_arr=array(
'button_type'=>'without_label',
'method'=>'POST',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_text'=>'Оплатить',
'button_class'=>'',
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

# Type2
$pay_detail_arr=array(
'button_type'=>'with_label',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_form'=>'SS', //S;M;SS;MS;L;V
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

# Type3
$pay_detail_arr=array(
'button_type'=>'with_label',
'order_id'=>'123',
'order_desc'=>'SWP payment',
'summ'=>'5',
'button_form'=>'FLS', //FL;FLS 
'IsTest'=>'1' //0;1
);
insert_module('robokassa','get_pay_button',$pay_detail_arr);

$table_list=mysql_query("SHOW TABLES FROM $databasename;");
var_dump($table_list);
while($r=mysql_fetch_array($table_list)){echo $r[0];}
*/

//Рутрекер
//insert_function("collect_data");
//$add_http_header="login_username: psytriballl\r\n";
//$add_http_header.="login_password: Tribe21\r\n";
//collect_data2("http","POST","rutracker.org/forum/login.php","80",'','',$add_http_header,"/forum/login.php",'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', FALSE, FALSE,$user_agent='Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0',FALSE,$timeout=60);


/*
//дубас
$dubas_file=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/dubas.txt');

$dubas_rows=explode("\n",$dubas_file);
foreach($dubas_rows as $dubas_row){
if(!empty($dubas_row)){
	if(is_numeric($dubas_row)){// Начало отдельной записи
		
		echo "<hr>POST:".$post_text;
		if(!empty($post_text)){
			$mysql_ins=mysql_query("INSERT INTO `$tableprefix-social-post` (`post_id`, `post_text`, `author`, `source`, `post_ts`) VALUES (NULL, '$post_text', NULL, 'Из книги Алекса Дубаса - Моменты Счастья (2016)', NULL);");
		}
		unset($post_text,$post_author,$prev_row,$row_count);
	} else {
	$post_text.=$dubas_row."\n";

	//$post_author=$dubas_row;
	//echo $dubas_row;
	}
}

}*/


?>
