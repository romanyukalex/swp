<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	//insert_function("StringPlural");
	include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");
	
	$cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);
	
?>
<div class="row flex-items-md-center " style="padding-top:20px;">


<div class="col-md-12">


<!--div class="row">
	<section class="col-md-9">
		<form id="search_form" action="/?page=videos">Поиск по всей базе
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="cat_id" value="<?=$_REQUEST['cat_id']?>">
			<input name="search_string" id="search_string_id" placeholder="Введите слова для поиска" class="biginput" style="width:50%" value="<? 
			if($_REQUEST['search_string']){echo $_REQUEST['search_string'];}?>">
			<input type="submit" class="button" style="height:38px;padding-top:10px" value="Искать">
		</form>
	</section>
	
	<div class="col-md-2 vp_block" id="banner">
	
	<a href='http://get-in-line.ru/?ref=2234&key=0' target="_blank">Вы - психолог?<br><br>Инструмент для записи на Вашу консультацию.<br><br>Бесплатно!</a>
	</div>
</div-->


 
<?
# Страница при подделке URI

 if($_REQUEST['search_cat']=="main"){
	 ?>
<h2 class="maintitle">Что ищем?</h2>
	<div class="row vp_block_row">		
		
		<div class="col col-md  vp_block">
			
			<span>
			Пт 16:01			</span>
			<a target="_blank" title="Найти психолога в Вашем городе" href="/?page=igrat-nel-zya-uchit-sya" onclick="yandex_target('CTATbR_from_CTATbu');return true;"><i class="fas fa-search-location"></i></a>
			
			<div class="caption">
				<h4 class="video_title" title="Смотреть статью: Играть нельзя учиться!">
				<a class="video_title" style="font-size:18px" href="/?page=igrat-nel-zya-uchit-sya" target="_blank" onclick="yandex_target('CTATbR_from_CTATbu');return true;" ;="">Найти психолога в Вашем городе</a></h4>
				
			</div>
		</div>
		<div class="col col-md col-md-offset-1-my vp_block">
			
			<span>
			Пт 15:26			</span>
			<a target="_blank" title="Смотреть статью: Депрессия… Модное слово нынче…" href="/?page=depressiya-modnoe-slovo-nynche" onclick="yandex_target('CTATbR_from_CTATbu');return true;"><img src="https://www.b17.ru/foto/uploaded/upl_1559304344_239684.jpg" width="100%" class="thumbnail art_img"></a>
			
			<div class="caption">
				<h4 class="video_title" title="Смотреть статью: Депрессия… Модное слово нынче…">
				<a class="video_title" style="font-size:18px" href="/?page=depressiya-modnoe-slovo-nynche" target="_blank" onclick="yandex_target('CTATbR_from_CTATbu');return true;" ;="">Депрессия… Модное слово нынче…</a></h4>
				<!--p><a href="" class="yt-user-name" title="Подробнее об авторе - 1101">1101</a></p-->
			</div>
		</div>
		<div class="col col-md col-md-offset-1-my vp_block">
			
			<span>
			Пт 14:52			</span>
			<a target="_blank" title="Смотреть статью: Как изменяется человек после успешного завершения психотерапии." href="/?page=kak-izmenyaetsya-chelovek-posle-uspeshnogo-zaversheniya-psihoterapii" onclick="yandex_target('CTATbR_from_CTATbu');return true;"><img src="https://www.b17.ru/foto/uploaded/upl_1559302529_363269.jpg" width="100%" class="thumbnail art_img"></a>
			
			<div class="caption">
				<h4 class="video_title" title="Смотреть статью: Как изменяется человек после успешного завершения психотерапии.">
				<a class="video_title" style="font-size:18px" href="/?page=kak-izmenyaetsya-chelovek-posle-uspeshnogo-zaversheniya-psihoterapii" target="_blank" onclick="yandex_target('CTATbR_from_CTATbu');return true;" ;="">Как изменяется человек после успешного завершения психотерапии.</a></h4>
				<!--p><a href="" class="yt-user-name" title="Подробнее об авторе - 1101">1101</a></p-->
			</div>
		</div>

	</div>
	 <?
} elseif(!$_REQUEST['search_cat']){
	?>
	<div class="row">
	<section class="col-md-9">
		<h2 class="maintitle">Психологи, тренеры, тренинговые центры, практикующие в России</h2>
		В базе данных сейчас <a href="/?page=<?=$page?>&search_cat=trainers"><? 
			$trnr_count_q=mysql_query("SELECT  COUNT(*) cnt FROM `$tableprefix-contactlist` WHERE `position`='Тренер';");
			$trnr_count=mysql_fetch_array($trnr_count_q);
			$trc_count_q=mysql_query("SELECT  COUNT(*) cnt FROM `$tableprefix-contactlist` WHERE `position`='Тренинговый центр';");
			$trc_count=mysql_fetch_array($trc_count_q);
			echo $trnr_count['cnt'];?> тренеров</a> и <a href="/?page=<?=$page?>&search_cat=trainingcenters"><?=$trc_count['cnt']?> тренинговых центров</a>
	</section>
	</div>
	<?
} elseif ($_REQUEST['search_cat']=="trainers" or $_REQUEST['search_cat']=="trainingcenters"){ // ГЛАВНЫЙ ЭКРАН, с городами и весями

	if($_REQUEST['search_cat']=="trainers"){
		$h2header="Психологи и тренеры, практикующие в России";
		//$h2header2="Психологи и тренеры, по типу предоставляемых услуг, свойствам и достижениям";
		$contact_type="Тренер";
	} elseif($_REQUEST['search_cat']=="trainingcenters"){
		$h2header="Психологические и тренинговые центры по месту расположения";
		$contact_type="Тренинговый центр";
		$targ_sear_cat="tr";
	}
?>

<div class="row">
	<section class="col-md-12">
		<h2 class="maintitle"><?=$h2header?></h2>
	</section>
	
		<?

		$trnr_cities_q=mysql_query("SELECT DISTINCT `city` FROM `$tableprefix-contactlist` WHERE `position`='$contact_type';");
		$countries_q=mysql_query("SELECT DISTINCT `country_name_ru` FROM `$tableprefix-country` WHERE 1;");
		
		while($countries=mysql_fetch_array($countries_q)){$country[$countries['country_name_ru']]=0;}
		while($trnr_cities=mysql_fetch_array($trnr_cities_q)){
			if(mb_substr($trnr_cities['city'],0,1)=="ы"){
				mysql_query("UPDATE `$tableprefix-contactlist` SET `city`='".trim(mb_substr($trnr_cities['city'],1))."' WHERE `city`='".$trnr_cities['city']."';");
			}
			#Разбиваем на части адрес
			$trs_reg_info= explode(",",$trnr_cities['city']);
			foreach ($trs_reg_info as $reg) {
				$reg=trim(html_entity_decode($reg));
				//echo "Смотрим регион - ".$reg."<br>";
				if(mb_strstr($reg,"Область") or mb_strstr($reg,"район")){//	Адрес един
					if(!$cities_arr[$trnr_cities['city']]) $cities_arr[$trnr_cities['city']]=1;
				} elseif(mb_strstr($reg,"(")){ // Содержит название страны
					$cntr_start_pos=mb_strpos($reg,"(");
					$cntr_stop_pos=mb_strpos($reg,")");
					$maybeitscountry=mb_substr($reg,$cntr_start_pos+1,($cntr_stop_pos-$cntr_start_pos-1));
					//echo $maybeitscountry;
					if($country["$maybeitscountry"]==0) {$country[$maybeitscountry]=1;}
					$city_t=trim(mb_substr($reg,0,$cntr_start_pos-1));
					if(!$cities_arr[$city_t]) $cities_arr[$city_t]=1;
					//print_r($cities_arr[$city_t]);
				} elseif(isset($country[trim($reg)])){//Вместо города тут страна
				//	echo "ВОт она - ".$reg."<br>";
					if($country[trim($reg)]==0) {$country[trim($reg)]=1;}
				} else {
					if(!$cities_arr[$reg]) $cities_arr[$reg]=1;
				}

			}
		}
		?>
		
		
		
		<div class="col-md-8">
	<? if($_REQUEST['search_cat']=="trainers"){
			insert_function("string_ucfirst");
			#Вытащим все теги тренеров
			$trnr_tags_q=mysql_query("SELECT DISTINCT `tags` FROM `$tableprefix-contactlist` WHERE `position`='$contact_type';");?>
			<br><br>
		<? 	while($trnr_tags=mysql_fetch_array($trnr_tags_q)){
				if(mb_strstr($trnr_tags['tags'],"Регион")){ // Содержит слово Регион, ошибка парсинга
					$rw_pos=mb_strpos($trnr_tags['tags'],"Регион");

					$new_tag=trim(mb_substr($trnr_tags['tags'],0,$rw_pos));
					mysql_query("UPDATE `$tableprefix-contactlist` SET `tags`='".$new_tag."' WHERE `tags`='".$trnr_tags['tags']."';");
				}
				$trnr_tag_row_arr=explode(";",$trnr_tags['tags']);
				foreach($trnr_tag_row_arr as $tag){
					
					if($tag){
						$tag=trim($tag);
						$tag=string_ucfirst($tag); //Поднимаем первую букву
						if(!$trnr_tags_arr[$tag])  $trnr_tags_arr[$tag]=1;
					}
				}
			}

			ksort($trnr_tags_arr);//Сортируем направления по названию
			#Отображаем виды деятельности
			foreach($trnr_tags_arr as $tag=>$key){
				$cur_letter=mb_substr($tag,0,1);
				if($cur_letter!==$prev_letter) {
				//	echo "<br><span class='bold_link'>".$cur_letter."</b><br>";?>
				<br>
				<div class="fa-2x">
				<span class="fa-layers fa-fw">
					<i class="fas fa-circle" style="color:Tomato"></i>
					<span class="fa-layers-text fa-inverse" data-fa-transform="shrink-6" style="font-weight:900"><?=$cur_letter?></span>
				</span>
				</div><br>
			<?	}
				?><a class="thin_link" href="/?page=<?=$page?>&search_cat=<?=$_REQUEST['search_cat']?>_by_tag&tag=<?=$tag;?>"><?=$tag;?></a>&emsp;&emsp;<?
				$prev_letter=$cur_letter;
			}
				

		}?>
		</div>
		
	
		<div class="col-md-4">
		
		
		
			<? 
			ksort($country);
			foreach($country as $country_name=>$key){
				if($key==1){?><a class="bold_link" 
				title="Все тренеры и психологи в <?=$country_name?>"
				href="/?page=<?=$page?>&search_cat=<?=$_REQUEST['search_cat']?>_in_place&country=<?=$country_name?>"><?=$country_name?></a>&ensp;<?
				}
			}
		?><br><br>
			<? //echo "!".$ip.$cityName;
		
			ksort($cities_arr);
			
			foreach($cities_arr as $city_name=>$key){
				?><a class="thin_link"
				title="Тренеры и психологи в г.<?=$city_name;?>"
				href="/?page=<?=$page?>&search_cat=<?=$_REQUEST['search_cat']?>_in_place&city=<?=$city_name;?>"><?=$city_name;?></a>&ensp;<?

			}?>
		</div>
</div>
<? 	
}


#Тренера в выборках


elseif ($_REQUEST['search_cat']=="trainers_in_place" or $_REQUEST['search_cat']=="trainers_by_tag"){
	insert_function("process_user_data");
	insert_function("string_ucfirst");
	if($_REQUEST['search_cat']=="trainers_in_place"){
	
		if($_REQUEST['city']) { // Тренера в городе
			$tr_city=process_data($_REQUEST['city'],40);
			$tr_filt="SELECT * FROM `$tableprefix-contactlist` WHERE `position`='Тренер' AND `city` LIKE '$tr_city'";
			?><h2 class="maintitle">Психологи и тренеры, проживающие в г.<?=$tr_city;?></h2><?
		} elseif($_REQUEST['country']){ // Тренера в стране
			$tr_country=process_data($_REQUEST['country'],40);

			$tr_cities_q=mysql_query("SELECT `city_name_ru` FROM `freecon-cities` cty,`freecon-country` ctr 
			WHERE cty.`id_country`=ctr.`id` and ctr.`country_name_ru`='$tr_country'"); // Города страны

			while($tr_cities=mysql_fetch_array($tr_cities_q)){ //Перебираем городишки, записываем их в 1 строку
				$tr_cities_qt.=" `city` LIKE '".str_replace("'","",$tr_cities['city_name_ru'])."' OR";
			}
			$tr_cities_qt.=" `city` LIKE '".$tr_country."'";
			
			$tr_filt="SELECT DISTINCT * FROM `$tableprefix-contactlist` WHERE  `position`='Тренер' AND ( $tr_cities_qt )";
			$coat_img=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-country` WHERE `country_name_ru`='".$tr_country."' LIMIT 0,1;"));
			?><h2 class="maintitle"><img width="50px" src="/files/coat_country/<?=strtolower(str_replace(" ","_",$coat_img['country_name_en']))?><?
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/files/coat_country/'.strtolower(str_replace(" ","_",$coat_img['country_name_en'])).'_small_coat_of_arms.jpg')){
			?>_small_coat_of_arms.jpg<?}
			elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/files/coat_country/'.strtolower($coat_img['country_name_en']).'.svg')){?>.svg<?}
			elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/files/coat_country/'.strtolower($coat_img['country_name_en']).'.png')){?>.png<?}?>">
			Психологи и тренеры, проживающие в <?=$tr_country;?></h2><?
		}
	
	} elseif($_REQUEST['search_cat']=="trainers_by_tag") { // Тренера по направлениям деятельности (тегам)
		$rq_tag=process_data($_REQUEST['tag'],100);
		$tr_filt="SELECT DISTINCT * FROM `$tableprefix-contactlist` WHERE `position`='Тренер' AND `tags` LIKE '%".$rq_tag."%'";
	}

	#Запрашиваем список из БД
	$trnr_q=mysql_query($tr_filt);
//	if(mysql_error()) echo mysql_error();
	
	
	?>
	<? $row_id=0;
	while($trnr=mysql_fetch_array($trnr_q)){
		$row_id++;
	?>
	<div class="row flex-items-xs-center">
	<div class="cols col-md-2 col-sm-12"><?
		$trnr_photos=explode(";",$trnr['photo']);
		$avatar=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-photos` ph,`$tableprefix-galleries` g WHERE 
			g.`gallery_id`=ph.`gallery_id` and `photo_id`='".$trnr_photos[0]."' LIMIT 0,1;"));
			
			//echo $avatar['gallery_title'];
		if(strstr($avatar['gallery_title'],"Самопознание")){
			?><center><img width="150px"  style="border-radius: 75px;"  src="https://samopoznanie.ru/avatars/objects/<?=$avatar['photo_path'];?>"></center>
<?		}?>
	</div>
	<div class="cols col-md-6 <? if( is_int($row_id/2)){?>flex-sm-first<?}?>">
		<b><?=$trnr['second_name']." ".$trnr['first_name']." ".$trnr['patronymic_name']?></b><br>
		[<?=$trnr['city']?>]
		<br><?=mb_substr(strip_tags($trnr['about']),0,200).'...<br>';
		?>
		<div class="flex-md-bottom"><?
		$trnr_tag_row_arr=explode(";",$trnr['tags']);
		foreach($trnr_tag_row_arr as $tag){
			if($tag){
				$tag=trim($tag);$tag=string_ucfirst($tag); //Поднимаем первую букву
				?><a class="bcgr_grey tag_circle" href="/?page=<?=$page?>&search_cat=trainers_by_tag&tag=<?=$tag;?>"><?=$tag;?></a>&emsp;&emsp;<?
			}
		}
		?></div>
	</div>
	</div><?
	}
}


?>


</div>
</div>


<? } //nitka