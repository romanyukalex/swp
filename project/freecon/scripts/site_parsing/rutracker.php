<? #Распарсивает страницу rutracker.org

$log->LogDebug('Download torrent page for '.$torr_info[1]);

insert_function("parse_torrent_name");
insert_function("get_http_response_code");


#Основные данные из API
$api_info_q=file_get_contents("http://api.rutracker.org/v1/get_tor_topic_data?by=topic_id&val=".$torr_info[1]);
/*{"result":{"5401515":{"info_hash":"6E4599E187664AA15D3FEFE8AD93B22E8D6FAAA9","forum_id":2515,"poster_id":1540799,"size":2441537,"reg_time":1494557019,
"tor_status":2,"seeders":4,"topic_title":"Пратусевич Ю.М., Сербиненко М.В., Орбачевская Г.Н. - Системный анализ процесса мышления [1989, DjVu, RUS]",
"seeder_last_seen":1498789261}}}
*/


$api_info=json_decode($api_info_q);
$torr_info['name']=$api_info->result->$torr_info[1]->topic_title;//Название топика
$torr_info['forum_id']=$api_info->result->$torr_info[1]->forum_id; // ID форума
$forum_info=json_decode(file_get_contents("http://api.rutracker.org/v1/get_forum_data?by=forum_id&val=".$torr_info['forum_id']));
$torr_info['forum_name']=$forum_info->result->$torr_info['forum_id']->forum_name;

$torr_info['date']=$new_tor_date; //берем дату из RSS 


$torr_info['size']=$api_info->result->$torr_info[1]->size;
$torr_info['hash']=$api_info->result->$torr_info[1]->info_hash;


$book_info_p=parse_torrent_name($torr_info['name']);
$book_attr=$book_info_p['tor_attr'];


$foursymbols=mb_substr($book_attr,0,4);
if (preg_match('/[\d]{4}/',$foursymbols)) {//Это цифры
	$torr_info['year']=$foursymbols;
}


$filePath='http://rutracker.org/forum/viewtopic.php?t='.$torr_info[1];
$html=file_get_contents($filePath);
$html = mb_convert_encoding($html, 'utf-8', 'cp1251');
# Картинка

/* // Парсинговый способ получить картинку

$needle='<var class="postImg postImgAligned img-right" title="';
$img_cl_pos=mb_strpos($html,$needle);
$img_start_p=$img_cl_pos+mb_strlen($needle);
//echo '1я точка - '.$img_cl_pos. 'Сдвиг - '.mb_strlen($needle) .' Начинаем с '.$img_start_p;

$img_fin_pos=mb_strpos($html,'"',($img_cl_pos+mb_strlen($needle)));
$uri_lenght=$img_fin_pos-$img_start_p;
//echo ' 2я точка - '.$img_fin_pos. ' Длина URI - '.$uri_lenght;
$img_src=substr($html,$img_start_p,$uri_lenght);

*/

// Получаем картинку через всасывание страницы в DOM
$tp_dom = new DOMDocument;
$tp_dom->loadHTML($html);
//Обрабатываем картинки
$trpage_imgs =$tp_dom->getElementsByTagName('var');
foreach ($trpage_imgs as $item1) {
	if($item1->getAttribute('class')=="postImg postImgAligned img-right"){
		$img_src_temp=$item1->getAttribute('title');
	break;
	}
}
if(strstr($img_src_temp,"http://")){//Можно проверить доступность
	$img_ac=get_http_response_code($theURL);
}

if($img_ac!==404 or strstr($img_src_temp,"https://")){
	$img_src=$img_src_temp;
} else $img_src="no";

#Поиск дскрипшна
$needle2='<div class="post_body"';
$desc_cl_pos=strpos($html,$needle2);
$desc_frst_pos=strpos($html,'>',($desc_cl_pos+mb_strlen($needle2)));
//echo '1='.$desc_cl_pos. ' Real 1='.$desc_frst_pos;
$needle3='<div class="clear"';
$desc_fin_pos=strpos($html,$needle3,$desc_frst_pos);
$desc_lenght=$desc_fin_pos-$desc_frst_pos;
//echo "FIN pos=".$desc_fin_pos. "Desc lenght=".$desc_lenght;
$desc_html=strip_tags(substr($html,$desc_frst_pos+1,$desc_lenght));
//$desc_html= htmlentities($desc_html,ENT_QUOTES);
$desc_html=str_replace("'", "",$desc_html);
$desc_html=str_replace('"', "",$desc_html);
$desc_html=str_replace('Примеры страниц', "",$desc_html);
$desc_html=str_replace('Содержание', "",$desc_html);
echo '<pre>'.$desc_html.'</pre><hr>';


	