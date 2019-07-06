<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){

$log->LogInfo('Got '.$products_count.' product(s) in list ');
?>

<div class="row flex-items-md-center">

	<div class="blockquote">
		
			<p>
				<? include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/get_phrase.php');
				echo $prases_arr[array_rand($prases_arr)];
				?>
			</p>
			<!--small>Команда soznanie.club</small-->
		
	</div>


</div>

<div class="row"  style="padding-right:0px;">
	<div class="col-md-1">
		<a href="javascript:history.back();" class="justlink" title="Назад"><i class="fas fa-undo-alt"></i></a>
	</div>
	<? /*
	<section class="col-md-11">
		<form id="search_form" action="/?page=swpshop">Поиск инфопродукта
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id']?>">
			<input name="search_string" id="search_string_id" placeholder="Введите часть названия или имени автора" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
			<!--input type="submit" class="button" style="height:38px;padding-top:10px" value="Искать"-->
			<a class="button medium" style="height:38px;padding-top:10px;color:white;background-color:#36cdb6;" onclick="document.getElementById('search_form').submit();">Искать</a>
		</form>
	</section>*/?>
</div>


<div class="row"  style="padding-right:0px;">
<div class="col-md-12">
<h2 class="maintitle"><?

if($_REQUEST['cat_id'] or $_REQUEST['cat_id']=='0'){ # Заголовок
	echo $pagequery['pagetitle_'.$language];
}
elseif($_REQUEST['search_tag']=="Психология"){?>Записи тренингов по психологии<?}
elseif($_REQUEST['search_tag']=="Интернет-маркетинг"){?>Записи тренингов по интернет-маркетингу<?}
elseif($_REQUEST['search_tag']=="Эзотерика"){?>Записи тренингов по эзотерике<?}
elseif($_REQUEST['search_tag']=="Отношения и секс"){?>Записи тренингов по отношениям и сексу<?}
elseif($_REQUEST['search_tag']=="Личная эффективность"){?>Записи тренингов по личной эффективности<?}
else {?>Записи тренингов по психологии, эзотерике и маркетингу<?}

?> [<?=$products_count.' '.StringPlural::Plural($products_count, array('продукт', 'продукта', 'продуктов'));
?>]
</h2>
<?if($_REQUEST['search_string']){?><br><h4>Показаны результаты поиска: <?=$search_string;?></h4><?}?>
</div>


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
	if ($page_num != $total_pages_count) $nextpage = '<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=' .$total_pages_count. '"><<</a>
								<a title="Следующие '.$artclspage_cnt.'" class="justlink" href= "/?' . $pgntr_base_uri.'page_num='. ($page_num + 1) .'"><</a>'; 
	// Проверяем нужны ли стрелки вперед 
	
if ($page_num != 1) $pervpage = '<a title="Предыдущие '.$artclspage_cnt.'" class="justlink" href= "/?'.$pgntr_base_uri.'page_num='. ($page_num - 1) .'">></a> 
								<a class="justlink" href= "/?' . $pgntr_base_uri.'page_num=1">>></a>'; 
	
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
$line_count=0;

while($productinfo=mysql_fetch_assoc($productinforeq)){
	$line_count++;
	
	?>
		<div class="col-md-2 <?if($line_count!==1){?>col-md-offset-1-my<?}?> vp_block">
			
			<b style="padding-left:10px"><?=mb_substr($product_price[$productinfo['product_id']]['min'],0,-3);
			if($product_price[$productinfo['product_id']]['min']!==$product_price[$productinfo['product_id']]['max']){
				echo " - ".mb_substr($product_price[$productinfo['product_id']]['max'],0,-3);
			}
			?> ₽</b>	
			
			<a target="_blank" href="/?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>" title="Смотреть и скачать продукт: <?=$productinfo['product_short_title_'.$language]?>" onclick="yandex_target('all_trngs');return true;"><img src="/project/<?=$projectname;
			if($productinfo['product_main_image']) echo $productinfo['product_main_image']; else echo '/files/shop_img/empty_oblojka.png';?>" width="100%" class="thumbnail" alt="Обложка продукта <?=$productinfo['product_short_title_'.$language]?>"></a>
			
			<div class="caption">
				<h4 class="video_title" title="Смотреть и скачать продукт: <?=$productinfo['product_short_title_'.$language]?>">
					<a href="/?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>" target="_blank" onclick="yandex_target('all_trngs');return true;"><?=$productinfo['product_short_title_'.$language]?></a></h4>
				
				<p><a target="_blank" href="<? ///?page=swpshop&action=show_vendor&vendor_id=<?=$productinfo['vendor_id']
				?>/?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>&subact=vendor_desc" class="yt-user-name" title="Об авторе продукта: <?=$bookauthor?>"><?=$productinfo['vendor_name_'.$language]?></a></p>
				
			</div>
		</div>
<?	if ($line_count==5){ // Смена строки
		?></div><div class="row vp_block_row"><?
		$line_count=0;
	}
}
?>
</div>


<? /*
<div class="row"><?
while($productinfo=mysql_fetch_array($productinforeq)){
		$line_count++;
	?>
	<div class="col-md-6">            
		<h4><a href="?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>"><?=$productinfo['product_full_title_'.$language]?></a></h4>
		 
			<table>
			<tbody><!--tr><td><? if($language=="en"){?>Vendor<?} elseif($language=="ru"){?>Производитель<?}?></td><td width="30px"><b>:</b></td><td><a href="/?page=swpshop&action=show_vendor&vendor_id=<?=$productinfo['vendor_id']?>&menu=services_<?=$productinfo['vendor_id']?>"><?=$productinfo['vendor_name_'.$language]?></a></td></tr-->			
			<tr><td><? if($language=="en"){?>Product<?} elseif($language=="ru"){?>Продукт<?}?></td><td width="20px"><b>:</b></td><td title="<?=$productinfo['product_short_title_'.$language]?>"><?=$productinfo['product_short_title_'.$language]?> <? if($language=="en"){?>by<?} else {?>от<?}?> <a href="/?page=swpshop&action=show_vendor&vendor_id=<?=$productinfo['vendor_id']?>&menu=services_<?=$productinfo['vendor_id']?>"><?=$productinfo['vendor_name_'.$language]?></a></td></tr>
			<tr><td><? if($language=="en"){?>Description<?} elseif($language=="ru"){?>Описание<?}?></td><td><b>:</b></td><td title="<?="[".$productinfo['product_id']."] ".$productinfo['product_full_title_'.$language]?>"><?=$productinfo['product_shortdescription_'.$language]?></td></tr>
			<tr><td></td><td></td><td title="<?=$productinfo['product_full_title_'.$language]?>"><a href="?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>&menu=services">
			<?// if($language=="en"){?>Product full description<?} elseif($language=="ru"){?>Полное описание продукта<?}?></a></td></tr>
			?>
			</tbody></table>
		
	</div>

<?	if ($line_count==2){ // Смена строки
		?></div><div class="row"><?
		$line_count=0;
	}
}?></div><?
*/
}//nitka?> 