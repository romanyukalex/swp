<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){	
	insert_function("StringPlural");?>
<script>

function filter_result(code_ru){
			$('.termin_desc').hide();
			
			$('[rel = "'+code_ru+'"]').show();
}
function filter_show_all(){
	$('.termin_desc').show();
}
</script>



<?



# Фильтр записей:

if($_REQUEST['search_string']){#Поиск по словам
	$_REQUEST['search_string'] = process_user_data($_REQUEST['search_string'],100);
	
	$s_words_arr=explode(" ",$_REQUEST['search_string']);
	
	$search_qt_exp='(';
	foreach($s_words_arr as $s_word){
		$search_qt_exp.="`code_ru` like '%$s_word%' and ";
	}
	$search_qt_exp=substr($search_qt_exp,0,-4).')';

} else $search_qt_exp='1';



# Количество результатов для пользователей
$data_req=mysql_query("SELECT `code_ru`,`code_en` FROM `freecon-pedia-artcl` WHERE $search_qt_exp;");
$item_count=mysql_num_rows($data_req);//Количество записей по нужному запросу

?>

<div class="row">
	<div class="col-md-12">
		<h2 class="maintitle"><img width="60px" src="/project/freecon/files/ape_nosee.jpg"  title="Не пускай зло в сознание через глаза (яп.символ)" class="imgmiddle">  
		<? if(!$_REQUEST['search_string']){?>
		Психологичесие термины в базе <?}
		else {?>Результаты поиска: <?=process_user_data($_REQUEST['search_string'],100);}

		?> [<?=$item_count.' '.StringPlural::Plural($item_count, array('термин', 'термина', 'терминов'));
		if($_REQUEST['search_string']){?> с несколькими значениями<?
			if($item_count>1) {?> каждый<?}
		}
		?>]</h2>
	</div>
</div>



<div class="row">
<div class="col-md-1">
	<a href="javascript:history.back();" class="justlink"title="Назад"><i class="fas fa-undo-alt"></i></a>
</div>
<section class="col-md-11">
	<form id="search_form" action="/?page=videos_srch">
		<input type="hidden" name="page" value="pedia">
		<input name="search_string" id="search_string_id" placeholder="Поиск определений" class="biginput" style="width:50%" value="<? 
		if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
		<a class="button large" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="$('#search_form').submit()"><i class="fas fa-search" style="color:white"></i></a>
	</form>
	<br>
</div>
<?

if($_REQUEST['search_string'] and $item_count>0){
	
	#Если слов найдено несколько, то делаем теги
	if($item_count>1 and $item_count<40) {
		?>
		<div class="row">
		<div class="col-md-10">
		<div id="v_tags">
		<a href="/?page=pedia&search_string=<?=$_REQUEST['search_string']?>" onclick="filter_show_all();return false;">Все</a>
		<?
		while($data_result=mysql_fetch_assoc($data_req)){
			?><a href='/?page=pedia&search_string=<?=$data_result['code_ru']?>' onclick="filter_result('<?=$data_result['code_ru']?>');return false;"><?=$data_result['code_ru']?></a><?
		}
		?></div><br><br>
		</div>
		</div><?
	mysql_data_seek($data_req,0);
	}
	
	insert_function("file_searchFileByName");
	$folderName=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/termins/';
	while($data_result=mysql_fetch_assoc($data_req)){

	# Блоки с определениями?>
	<!--  Записи -->
	
			<?
			
			$file_names=search_file_byMask($folderName, $data_result['code_en']."|");

			foreach($file_names as $eventfileName){
				$fh = fopen($folderName.$eventfileName, 'r');
				if(!empty($fh) and $fh!=='' and $fh!==NULL){
					$termin_text[] = trim(fgets($fh));
				}
			}
			
			foreach($termin_text as $termin_code=>$termin_desc){?>
			<div class="row vp_block_row termin_desc" rel="<?=$data_result['code_ru']?>">

				<div class="col-md-2">
					<?=$data_result['code_ru']?>
				</div>
				<div class="col-md-10">
					
					<i><?=$termin_desc?></i><br><br><br>
		
				</div>
			</div>
<?			}?>

<!-- // Записи -->
<?	}
}


}//nitka?>