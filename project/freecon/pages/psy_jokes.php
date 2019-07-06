<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	insert_function("StringPlural");
?>



<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<a href="javascript:history.back();" class="justlink"title="Назад"><i class="fas fa-undo-alt"></i></a>
	</div>
	<section class="col-md-11">
		<form id="search_form" action="/?page=videos">Поиск по анекдотам
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id']?>">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
			<a class="button large" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
		</form>
	</section>
</div>
<?

$itemspage_count=$bookspage_bcnt; // Количество записей на странице

$items_info_qt="FROM `$tableprefix-jokes` WHERE ";


if($_REQUEST['search_string']){
	$items_info_qt.="`text` like '%".$_REQUEST['search_string']."%'";
} else $items_info_qt.='1';


$items_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as ITEMSCOUNT ".$items_info_qt));//Количество записей по нужному запросу

#Пагинатор (расчёт)
$page_num = $_GET['page_num']; // Извлекаем из URL текущую страницу
$total_pages_count = intval(($items_count['ITEMSCOUNT'] - 1) / $itemspage_count) + 1;

if(empty($page_num) or $page_num < 0) $page_num = 1; // Если значение $page меньше единицы или отрицательно, переходим на первую страницу 
elseif ($page_num > $total_pages_count) $page_num = $total_pages_count; // А если слишком большое, то переходим на последнюю 

$start_page_q = $page_num * $itemspage_count - $itemspage_count; // Стартовая страница

#Запрос данных в БД
$items_info_q=mysql_query("SELECT * ".$items_info_qt." ORDER BY `joke_id` DESC LIMIT $start_page_q,$itemspage_count;");

if($items_count['ITEMSCOUNT']>0) $log->LogInfo('Got '.$items_count['ITEMSCOUNT'].' rows');
else $log->LogError('No rows found in query. Query was SELECT * '.$items_info_qt." ORDER BY `id` DESC LIMIT 0,$itemspage_count;");
 ?>

<div class="row"  style="padding-right:0px;">
<div class="col-md-12">
<h2 class="maintitle"><?

if($_REQUEST['cat_id'] or $_REQUEST['cat_id']=='0'){ # Заголовок
	echo $pagequery['pagetitle_'.$language];
}
else {?>Анекдоты<?}

?> [<?=$items_count['ITEMSCOUNT'].' '.StringPlural::Plural($items_count['ITEMSCOUNT'], array('анекдот', 'анекдота', 'анекдотов'));
?>]
</h2>
<?if($_REQUEST['search_string']){?><br><h4>Показаны результаты поиска: <?=$_REQUEST['search_string'];?></h4><?}?>
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
<div class="row"  style="padding-right:0px;">
	<div class="col-md-10"><?
	//Определяем базовый URI
	foreach ($_GET as $getparam_key => $getparam_value){
		if($getparam_key!=="page_num"){
			$pgntr_base_uri.=$getparam_key.'='.$getparam_value.'&';
		}
	}
	
	// Проверяем нужны ли стрелки назад 
	if ($page_num != 1) $pervpage = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1"><i class="fas fa-step-backward"></i></a> 
		<a title="Предыдущие '.$videopage_vcnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'"><i class="fas fa-caret-left"></i></a> '; 
	// Проверяем нужны ли стрелки вперед 
	if ($page_num != $total_pages_count) $nextpage = ' <a title="Следующие '.$videopage_vcnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><i class="fas fa-caret-right"></i></a> 
	<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><i class="fas fa-step-forward"></i></a>'; 

	// Находим две ближайшие станицы с обоих краев, если они есть 
	if($page_num - 2 > 0) $page2left = ' <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 2) .'">'. ($page_num - 2) .'</a> | '; 
	if($page_num - 1 > 0) $page1left = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num - 1) .'">'. ($page_num - 1) .'</a> | '; 
	if($page_num + 2 <=$total_pages_count) $page2right = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 2) .'">'. ($page_num + 2) .'</a>'; 
	if($page_num + 1 <=$total_pages_count) $page1right = ' | <a class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'">'. ($page_num + 1) .'</a>'; 

	// Вывод меню 
	echo $pervpage.$page2left.$page1left.'<b>'.$page_num.'</b>'.$page1right.$page2right.$nextpage;
	?></div>
</div><?
}?>

<style>

.font16{
	font-size:16px;
}

</style>
<div class="row vp_block_row" style="padding-right:0px;">
<? 
$items_line_count=0;


while($items_info=mysql_fetch_array($items_info_q)){
	
	
	?>
		<div class="col-md-12 vp_block font16">
			
						
			<?
			$items_info['text']=str_replace("\n","<br>",$items_info['text']);
			
		echo $items_info['text']; ?>
		</div>
<?	
}
?>
</div>



<? }