<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	insert_function("StringPlural");


if(!$_SESSION['show_book_s_banner']){?>
<div class="row flex-items-md-center">

	<div class="blockquote">
		
			<p>
				Найди аудиозапись тренинга или книги по психологии, философии и эзотерике за 1 секунду<br>Можно ввести название курса, имя автора/ тренера или год (посвежее или  раритетное)<br><br>
 
			</p>
			<small>Команда <?if($ps){?>Psy-space<?}elseif($sclub){?>soznanie.club<?}?></small>
		
	</div>


</div>
<? $_SESSION['show_book_s_banner']=1;
}?>

<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<a href="javascript:history.back();" class="justlink"title="Назад"><i class="fas fa-undo-alt"></i></a>
	</div>
	<section class="col-md-11">
		<form id="search_form" action="/?page=audios_srch">Поиск по названию записи / году
			<input type="hidden" name="page" value="audios_srch">
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id']?>">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
			<a class="button large" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
		</form>
		
	</section>
	
	<!--div class="col-md-2 vp_block" id="banner">
	
	<a href='http://get-in-line.ru/?ref=2234&key=0' target="_blank">Вы - психолог?<br><br>Инструмент для записи на Вашу консультацию.<br><br>Бесплатно!</a>
	</div-->
</div>
<?

# Фильтр книг:

if($_REQUEST['search_string']){
	$search_string=process_data($_REQUEST['search_string'],200);
	?>
	<script>
fbq('track', 'Search', {
search_string: '<?=$search_string?>'
});
fbq('track', 'Search_book', {
search_string: '<?=$search_string?>'
});
</script>
	<?
}


if($_REQUEST['cat_id'] or $_REQUEST['cat_id']=='0'){#Поиск по словам
	
	$cat_id=process_data($_REQUEST['cat_id'],4);
	$log->LogDebug('Category is '.$cat_id);
	if($_REQUEST['cat_id']!=='0' ){$books_info_qt="FROM `$tableprefix-torrents-abooks` WHERE `cat_id`='".$cat_id."'";}
	

	if($_REQUEST['search_string']){
		$books_info_qt.=" AND `name` like '%".$search_string."%' and `status`='active'";
		
		}
	
} else { #Нет категории, ищем во всей БД
	$log->LogDebug('No category, show all categoies');
	$books_info_qt="FROM `$tableprefix-torrents-abooks` WHERE `status`='active'";
	if($_REQUEST['search_string']){
		$books_info_qt.="and `name` like '%".$search_string."%'";
		}
}
# Книги для пользователей


$item_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as ITEM_COUNT ".$books_info_qt));//Количество записей по нужному запросу


#Пагинатор (расчёт)
$page_num = process_data($_GET['page_num'],5); // Извлекаем из URL текущую страницу
$total_pages_count = intval(($item_count['ITEM_COUNT'] - 1) / $artclspage_cnt) + 1;

if(empty($page_num) or $page_num < 0 or $page_num > $total_pages_count) $page_num = $total_pages_count; // Если значение $page_num не сущ, меньше единицы или отрицательно, переходим на первую страницу 

// Стартовая страница
$start_page_q = ($total_pages_count- $page_num) * $artclspage_cnt;

#Запрос данных в БД
//$books_info_q=mysql_query("SELECT * ".$books_info_qt." ORDER BY `id` DESC LIMIT $start_page_q,$bookspage_bcnt;");
$books_info_q=mysql_query("SELECT `name`,`year`,`orig_img`,`id`,`topic_id`,`cat_name`,`cat_id` ".$books_info_qt." ORDER BY `id` DESC LIMIT $start_page_q,$bookspage_bcnt;");

if($item_count['ITEM_COUNT']>0) $log->LogInfo('Got '.$item_count['ITEM_COUNT'].' books');
else $log->LogError('No books found in query. Query was SELECT * '.$books_info_qt." ORDER BY `id` DESC LIMIT 0,$bookspage_bcnt;");





//$books_info_q=mysql_query($books_info_qt.' ORDER BY `year` DESC;');
//if(mysql_num_rows($books_info_q)>0) $log->LogInfo('Got '.mysql_num_rows($books_info_q).' product(s) in list of books');
//else $log->LogError('No books found in query - '.$books_info_qt.' ORDER BY `year` DESC;'); ?>

<div class="row"  style="padding-right:0px;">
<div class="col-md-12">

<h2 class="maintitle"><img width="60px" src="/project/freecon/files/ape_nohear.jpg" title="Не пускай зло в сознание через уши (яп.символ)" class="imgmiddle"><?

if($_REQUEST['cat_id'] or $_REQUEST['cat_id']=='0'){ # Заголовок
	echo $pagequery['pagetitle_'.$language];
}
else {?>Аудиозаписи и аудиокниги <?}

if(!$_REQUEST['search_string']){
?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('запись', 'записи', 'записей'));
?>]<?}?>
</h2>
<?if($_REQUEST['search_string']){?><br><h4>Показаны результаты поиска: <?=$search_string;?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('запись', 'записи', 'записей'));
?>]</h4><br><?}?>
</div>


<? /*# Дисклеймер к разделу ?>
<div class="row">

	<div class="blockquote" style="margin-left:20px">
		
			<p>
				<? if($page=="psybooks_sex"){
					?>Сексоло́гия — научная дисциплина, изучающая все проявления сексуальности человека, включая как попытки охарактеризовать нормальную сексуальность, так и изучение изменчивости сексуальных практик, включая и так называемые парафилии (или сексуальные девиации).
Современная сексология — мультидисциплинарное поле исследований, в котором используются методы ряда смежных дисциплин: биологии, медицины, психологии, статистики, эпидемиологии, педагогики, социологии, антропологии, а иногда и криминалистики. Она изучает развитие сексуальности и развитие сексуального контакта, включая технику половых сношений и расстройства половой сферы. Исследователи документируют сексуальность самых разных групп общества, таких как люди с ограниченными физическими возможностями, детей, пожилых людей, и случаи сексуальной патологии, такие как патологическую одержимость сексом или сексуальные домогательства по отношению к детям.
Следует отметить, что сексология — описывающая, а не предписывающая дисциплина. Она пытается документировать определённые аспекты реальности, а не предписывать, какое поведение будет уместным, этичным или нравственным. Сексология часто становилась предметом конфликтов между её сторонниками, а также теми, кто полагают, что сексология посягает на сакральные основы человеческой жизни, или теми, кто оспаривают, с философской точки зрения, претензии сексологов на объективность и эмпирическую методологию.<?
				}?>
			</p>
			<small></small>
		
	</div>
</div>*/

?>
</div>

<?
#Выводим Пагинатор
if($total_pages_count>1){?>
<div class="row">
	<div class="col-md-10"><?
	//Определяем базовый URI
	foreach ($_GET as $getparam_key => $getparam_value){
		if($getparam_key!=="page_num"){
			$pgntr_base_uri.=$getparam_key.'='.$getparam_value.'&';
		}
	}
	// Проверяем нужны ли стрелки назад 
	if ($page_num != $total_pages_count) $nextpage = '
	    <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><i class="fas fa-step-backward"></i></a>
		<a title="Следующие '.$artclspage_cnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><i class="fas fa-caret-left"></i></a>'; 
	// Проверяем нужны ли стрелки вперед 
	
if ($page_num != 1) $pervpage = '
	<a title="Предыдущие '.$artclspage_cnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'"><i class="fas fa-caret-right"></i></a> 
	<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1"><i class="fas fa-step-forward"></i></a>'; 
	
	// Находим две ближайшие станицы с обоих краев, если они есть 
	if($page_num - 2 > 0) $page2left = ' |  <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 2) .'">'. ($page_num - 2) .'</a>'; 
	if($page_num - 1 > 0) $page1left = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 1) .'">'. ($page_num - 1) .'</a>'; 
	if($page_num + 2 <=$total_pages_count) $page2right = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 2) .'">'. ($page_num + 2) .'</a> | '; 
	if($page_num + 1 <=$total_pages_count) $page1right = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'">'. ($page_num + 1) .'</a> | '; 

	// Вывод меню 
	echo $nextpage.$page2right.$page1right.'<b>'.$page_num.'</b>'.$page1left.$page2left.$pervpage;
	?></div>
</div><?
}
?>

<? 
$video_line_count=0;

insert_function("CheckDomain");
insert_function("parse_torrent_name");

while($books_info=mysql_fetch_array($books_info_q)){
	$video_line_count++;
	#Данные о книге
	mb_internal_encoding("UTF-8");
	
	
	$book_info_p=parse_torrent_name($books_info['name']);
	$bookauthor=$book_info_p['author'];
	$bookname=$book_info_p['title'];
	$book_attr=$book_info_p['tor_attr'];
	
	if(!$books_info['year']){ // Не вычислен еще год
		$foursymbols=mb_substr($book_attr,0,4);
		if (preg_match('/[\d]{4}/',$foursymbols) and !$books_info['year']) {//Запись года в поле
			mysql_query("UPDATE `$tableprefix-torrents` SET `year` = '$foursymbols' WHERE `id` = ".$books_info['id'].";");
		}
	}
	?>
	<div class="row vp_block_row" style="padding-right:0px;">
		<div class="col-md-12 <?if($video_line_count!==1){?>col-md-offset-1-my<?}?> vp_block">

			<div class="caption">
			
				<p>
				
				
				
				<a class="yt-user-name" title="Смотреть и скачать запись: <?=$books_info['name']?>" href="/?page=audio&topic_id=<?=$books_info['topic_id']?>" onclick="yandex_target('all_aud');return true;" target="_blank"><?
					if($bookauthor) {echo $bookauthor.' &mdash; ';}
					if($bookname) echo $bookname; 
					elseif(!$bookname and !$bookauthor) { #Почему то не определился ни автор, ни название книги
						if(mb_strstr($books_info['name'],"[")) echo mb_substr($books_info['name'],0,mb_strpos($books_info['name'],"["));
						else echo $books_info['name'];
					}
					
					?></a>
				</p>
				
				
				<? if($bookauthor){?>
					<h4 class="video_title">[
						<? if(is_numeric(substr($book_attr,0,4))){ //Значит атрибуты начинаются с годов
							echo $book_attr;
						} else { //Значит атрибуты начинаются с озвучивателя
							echo "Озвуч. ".$book_attr;
						}?>]
						
					</h4>
					<? if($bookauthor) {?>
						<a class="tag_circle justlink"href="/?page=audios&search_string=<?=$bookauthor?>" title="Другие аудио автора: <?=$bookauthor?>"><?=$bookauthor?></a>
					<?}?>
					<a class="tag_circle justlink"href="/?page=audios&cat_id=<?=$books_info['cat_id']?>" title="Другие аудио в разделе <?=$books_info['cat_name']?>"><?=$books_info['cat_name']?></a>
					
						
				<? }?>
				
			</div>
		</div>
	</div>
	<?
		$general_line_count++;// Общий счётчик выведенных линий с блоками
		$video_line_count=0;
}
?>
</div>
<div class="row">
	<div class="col-md-10">
<?=$nextpage.$page2right.$page1right.'<b>'.$page_num.'</b>'.$page1left.$page2left.$pervpage;
	?></div>
</div>

<? } // Nitka

/*
//Ограничиваем время выполнения скрипта 3-мя минутами
set_time_limit(180);


//Открываем файл указанный в url переменной "f"
$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/category_25.csv', "r");


//Запускаем цикл до конца строк в файле
while (!feof($fp)) {
        //Считываем строку (да, функцию trim() выполнять не обязательно, но у каждого программиста свои "тараканы")
        $tmp = trim(fgets($fp));
        
        
        //Преобразуем строку в массив. За разделитель используем ";"
        $torrent = explode('";"', $tmp);
        
        
        //В первом и последнем элементе удаляем лишние символы "
        $torrent[0] = substr($torrent[0], 1);
        $torrent[6] = substr($torrent[6], 0, (strlen($torrent[6]) - 1));
        
        
        //Если раскомментировать следующую строку, то можно увидеть как распарсился первый торрент в файле
       // print '<pre>'; print_r($torrent); 		exit();
        
        
        //Вставляем данные текущего торрента в таблицу
        mysql_query("INSERT INTO `freecon-torrents` 
            (`name`,
            `hash`,
            `date`,
            `size`,
            `topic_id`,
            `cat_id`,
            `cat_name`) 
          VALUES 
            ('" . mysql_real_escape_string($torrent[4]) . "',
            '" . $torrent[3] . "',
            '" . $torrent[6] . "',
            '" . $torrent[5] . "',
            '" . $torrent[2] . "',
            '" . $torrent[0] . "',
            '" . mysql_real_escape_string($torrent[1]) . "')
        ");
		
}
//Закрываем файл
fclose($fp);

//Выводим сообщение о завершении работы
print 'complete: ';



$books_info=mysql_query("SELECT * FROM `freecon-torrents` WHERE `cat_id`='2515' or `cat_id`='2516' or `cat_id`='2517' or `cat_id`='2518' or `cat_id`='2519' or `cat_id`='2520' or `cat_id`='1696' or `cat_id`='2253' or `cat_id`='995' or `cat_id`='764' or `cat_id`='1427' or `cat_id`='2422' or `cat_id`='1684' or `cat_id`='2218' or `cat_id`='2217' or `name` LIKE '%психолог%';");
//echo mysql_num_rows($books_info);

//DELETE FROM `freecon-torrents` WHERE `cat_id`!='2515' and `cat_id`!='2516' and `cat_id`!='2517' and `cat_id`!='2518' and `cat_id`!='2519' and `cat_id`!='2520' and `cat_id`!='1696' and `cat_id`!='2253' and `cat_id`!='995' and `cat_id`!='764' and `cat_id`!='1427' and `cat_id`!='2422' and `cat_id`!='1684' and `cat_id`!='2218' and `cat_id`!='2217' and `name` NOT LIKE '%психолог%'
*/