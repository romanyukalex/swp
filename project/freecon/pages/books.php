<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	insert_function("StringPlural");

if(!$_SESSION['book_stBanner_shown'] or $_SESSION['book_stBanner_shown']!==1){?>
<div class="row flex-items-md-center">

	<div class="blockquote">
		
			<p>
				Найди книгу по психологии, философии и эзотерике (1076-2017) за 1 секунду<br>Можно ввести название книги, имя автора или год (посвежее или  раритетное)<br><br>
				
				В меню можно выбрать интересующий раздел
 
			</p>
			<small>Команда <?if($ps){?>Psy-space<?}elseif($sclub){?>soznanie.club<?}?></small>
		
	</div>


</div>
<? $_SESSION['book_stBanner_shown']=1;
}?>

<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<? #Назад?>
		<a href="javascript:history.back();" class="justlink" title="Назад"><i class="fas fa-undo-alt"></i></a>
	</div>
	<section class="col-md-11">
		<form id="search_form" action="/?page=books">Поиск по названиям / году
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id']?>">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
			<a class="button large"  style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
		</form>
	</section>
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
	if($_REQUEST['cat_id']!=='0' ){$books_info_qt="FROM `$tableprefix-torrents` WHERE `cat_id`='".$cat_id."'";}
	else {$books_info_qt="FROM `$tableprefix-torrents` WHERE  
		`cat_id`!='2515' and `cat_id`!='2516' and `cat_id`!='2517' and `cat_id`!='2518' and `cat_id`!='2519' and `cat_id`!='2520' and `cat_id`!='1696' and 
		`cat_id`!='2253' and `cat_id`!='995' and `cat_id`!='764' and `cat_id`!='1427' and `cat_id`!='2422' and `cat_id`!='1684' and `cat_id`!='2218' and 
		`cat_id`!='2217' and `status`='active'";}

	if($_REQUEST['search_string']){
		$books_info_qt.=" AND `name` like '%".$search_string."%' and `status`='active'";
		
		}
	
} else { #Нет категории, ищем во всей БД
	$log->LogDebug('No category, show all categoies');
	$books_info_qt="FROM `$tableprefix-torrents` WHERE `status`='active'";
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
$books_info_q=mysql_query("SELECT `name`,`year`,`orig_img`,`id`,`topic_id` ".$books_info_qt." ORDER BY `year` DESC,`id` DESC LIMIT $start_page_q,$bookspage_bcnt;");

if($item_count['ITEM_COUNT']>0) $log->LogInfo('Got '.$item_count['ITEM_COUNT'].' books');
else $log->LogError('No books found in query. Query was SELECT * '.$books_info_qt." ORDER BY `id` DESC LIMIT 0,$bookspage_bcnt;");





//$books_info_q=mysql_query($books_info_qt.' ORDER BY `year` DESC;');
//if(mysql_num_rows($books_info_q)>0) $log->LogInfo('Got '.mysql_num_rows($books_info_q).' product(s) in list of books');
//else $log->LogError('No books found in query - '.$books_info_qt.' ORDER BY `year` DESC;'); ?>

<div class="row"  style="padding-right:0px;">
<div class="col-md-12">
<h2 class="maintitle"><img width="60px" src="/project/freecon/files/ape_nosee.jpg"  title="Не пускай зло в сознание через глаза (яп.символ)" class="imgmiddle"><?

if($_REQUEST['cat_id'] or $_REQUEST['cat_id']=='0'){ # Заголовок
	echo $pagequery['pagetitle_'.$language];
}
else {?>Все категории книг по психологии<?}

if(!$_REQUEST['search_string']){
?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('книга', 'книги', 'книг'));
?>]<?}?>
</h2>
<?if($_REQUEST['search_string']){?><br><h4>Показаны результаты поиска: <?=$search_string;?> [<?=$item_count['ITEM_COUNT'].' '.StringPlural::Plural($item_count['ITEM_COUNT'], array('книга', 'книги', 'книг'));
?>]</h4><?}?>
</div>


<? # Дисклеймер к разделу 
if($page!=="psybooks"){
?><div class="row">

	<div class="blockquote" style="margin-left:20px">
		
			<p style="margin:0px">
				<? if($page=="psybooks_sex"){
					?>Сексоло́гия — научная дисциплина, изучающая все проявления сексуальности человека, включая как попытки охарактеризовать нормальную сексуальность, так и изучение изменчивости сексуальных практик, включая и так называемые парафилии (или сексуальные девиации).
<?				} elseif($page=="psybooks_main"){
				?>Прикладная психология — общий термин, используемый для обозначения всех тех отраслей психологии, которые стремятся применить принципы, открытия и теории психологии на практике в смежных областях, таких как образование (педагогика), промышленность (эргономика), маркетинг, опрос общественного мнения, музыка (музыкальная психология), спорт (психология спорта), кадровая служба (психодиагностика), военное дело (военная психология) и т. п. и/или обнаружить базовые принципы, которые могут быть применены таким образом.<?
				} elseif($page=="psybooks_diag"){
				?>Психологи́ческая корре́кция — один из видов психологической помощи; деятельность, направленная на исправление особенностей психологического развития, не соответствующих оптимальной модели, с помощью специальных средств психологического воздействия; а также — деятельность, направленная на формирование у человека нужных психологических качеств для повышения его социализации и адаптации к изменяющимся жизненным условиям.<?
				} elseif($page=="psybooks_social"){
				
				?>Социальная психология — раздел психологии, занимающийся изучением закономерностей поведения и деятельности людей, обусловленных включением их в социальные группы, а также психологических характеристик самих групп<br>
				<?}elseif($page=="psybooks_training"){
					?>Психологи́ческий тре́нинг — форма активного обучения навыкам поведения и развития личности. В тренинге участнику предлагается проделать те или иные упражнения, ориентированные на развитие или демонстрацию психологических качеств или навыков. Ключевым принципом, обеспечивающим эффективное обучение и развитие, является постоянное сочетание в тренинге всех форм деятельности: общение, игра, обучение, труд.<?
				}
				
				?>
			</p>
			<small></small>
		
	</div>
</div>
<?}?>
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
	if ($page_num != $total_pages_count) $nextpage = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><i class="fas fa-step-backward"></i></a>
	<a title="Следующие '.$artclspage_cnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><i class="fas fa-caret-left"></i></a>'; 
	// Проверяем нужны ли стрелки вперед 
	
if ($page_num != 1) $pervpage = '<a title="Предыдущие '.$artclspage_cnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'">
<i class="fas fa-caret-right"></i></a>

<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1"><i class="fas fa-step-forward"></i></a>'; // Сначала >, затем >>
	
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
<div class="row vp_block_row" style="padding-right:0px;">
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
		<div class="col-md-3 ">
			<div class="<?if($video_line_count!==1){?>col-md-offset-1-my<?}?> vp_block">
				<span><?=$books_info['year']?></span><span class="hidden-sm-down"><?=substr($book_info_p['tor_attr'],6);?></span>			
				
				<a target="_blank" title="Смотреть и скачать книгу: <?=$books_info['name']?>" href="/?page=book&topic_id=<?=$books_info['topic_id']?>" onclick="yandex_target('all_books');return true;"><img src="<?
				if($books_info['orig_img'] and $books_info['orig_img']!=='-1251' and $books_info['orig_img']!=='no') echo $books_info['orig_img']; else echo '/project/'.$projectname.'/files/no_oblojki.png';?>" width="100%" class="thumbnail" alt="Обложка книги <?=$books_info['name']?>"></a>
				
				<div class="caption">
					<h4 class="video_title" title="Смотреть и скачать книгу: <?=$books_info['name']?>"><a class="hvr-pulse-shrink" href="/?page=book&topic_id=<?=$books_info['topic_id']?>" target="_blank" onclick="yandex_target('all_books');return true;"><?
						if($bookname) echo $bookname; 
						elseif(!$bookname and !$bookauthor) { #Почему то не определился ни автор, ни название книги
							if(mb_strstr($books_info['name'],"[")) echo mb_substr($books_info['name'],0,mb_strpos($books_info['name'],"["));
							else echo $books_info['name'];
						}?></a></h4>
					<? if($bookauthor){?>
					<p><a target="_blank" href="/?page=psybooks&search_string=<?=$bookauthor?>" class="yt-user-name hvr-wobble-vertical" title="Другие книги автора: <?=$bookauthor?>"><?=$bookauthor?></a></p>
					<? }?>
				</div>
			</div>
		</div>
<?	if ($video_line_count==4){ // Смена строки
		?></div><div class="row vp_block_row"><?
		$general_line_count++;// Общий счётчик выведенных линий с блоками
		
		if($yandex_rsya_en=="Включена реклама РСЯ"){
			#Реклама яндекс РСЯ	
			if($general_line_count == 2){?>
				<!-- Yandex.RTB R-A-279803-1 -->
				<div id="yandex_rtb_R-A-279803-1"></div>
				<script type="text/javascript">
					(function(w, d, n, s, t) {
						w[n] = w[n] || [];
						w[n].push(function() {
							Ya.Context.AdvManager.render({
								blockId: "R-A-279803-1",
								renderTo: "yandex_rtb_R-A-279803-1",
								async: true
							});
						});
						t = d.getElementsByTagName("script")[0];
						s = d.createElement("script");
						s.type = "text/javascript";
						s.src = "//an.yandex.ru/system/context.js";
						s.async = true;
						t.parentNode.insertBefore(s, t);
					})(this, this.document, "yandexContextAsyncCallbacks");
				</script>
				</div><div class="row vp_block_row">
		<?	} elseif($general_line_count == 5){?><!-- Yandex.RTB R-A-279803-2 -->
				<div id="yandex_rtb_R-A-279803-2"></div>
				<script type="text/javascript">
					(function(w, d, n, s, t) {
						w[n] = w[n] || [];
						w[n].push(function() {
							Ya.Context.AdvManager.render({
								blockId: "R-A-279803-2",
								renderTo: "yandex_rtb_R-A-279803-2",
								async: true
							});
						});
						t = d.getElementsByTagName("script")[0];
						s = d.createElement("script");
						s.type = "text/javascript";
						s.src = "//an.yandex.ru/system/context.js";
						s.async = true;
						t.parentNode.insertBefore(s, t);
					})(this, this.document, "yandexContextAsyncCallbacks");
				</script>
		<?	}
		}
		$video_line_count=0;
	}
}
?>
</div>
<div class="row">
	<div class="col-md-10">
<?=$nextpage.$page2right.$page1right.'<b>'.$page_num.'</b>'.$page1left.$page2left.$pervpage;
	?></div>
</div>

<? } // Nitka