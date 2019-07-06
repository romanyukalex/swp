<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	if($pagequery['viewCount'] and $pagequery['viewCount']!==0) {
		?><<?if($ampreq){?>amp-<?}?>img src="/files/eye_grey.png" width="25px" height="25px" class="imgmiddle" title="<?='Статью посмотрели '.$pagequery['viewCount'].' раз';?>"<?if($ampreq){?>></amp-img><?} else {?>/><?} echo $pagequery['viewCount']."<span style='font-size:6px' itemprop='name'>".$pagequery['pagetitle_'.$language]."</span><br>";
	}
		
	if($ampreq and $pagequery['page_img']){ # Это страничка AMP
		?><h1 itemprop="headline"><?=$pagequery['pagetitle_'.$language]?></h1><?
		//Вставляем главную картинку
		list($artcl_img_width, $artcl_img_height, $artcl_img_type, $artcl_img_attr) = getimagesize($pagequery['page_img']);
		?><amp-img src="<?=$pagequery['page_img']?>" alt="<?=$pagequery['pagetitle_'.$language]?>px" width="<?=$artcl_img_width?>" height="<?=$artcl_img_height?>px"></amp-img><?
	}
	if(!$rss_lang){ #Это простая веб-страница
		if ($language=='ru') $page_html=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$page);
		elseif($language=='en') $page_html=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html_en/'.$page);
		
		insert_function("string_replace_nth");
		
		if($yandex_rsya_en=="Включена реклама РСЯ"){ #Реклама яндекс РСЯ	
			//Код счётчика
			$ad_block_code='<!-- Yandex.RTB R-A-279803-4 -->
			<div id="yandex_rtb_R-A-279803-4"></div>
			<script type="text/javascript">
				(function(w, d, n, s, t) {
					w[n] = w[n] || [];
					w[n].push(function() {
						Ya.Context.AdvManager.render({
							blockId: "R-A-279803-4",
							renderTo: "yandex_rtb_R-A-279803-4",
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
			</script>';
			//Считаем количество абзацев
			$page_html_p_counter=mb_substr_count($page_html,"</p>");
			
			if($page_html_p_counter<=1){//Абзацы разбиты не p а br
				$page_html_brbr_counter=mb_substr_count($page_html,"<br><br>");
				if($page_html_brbr_counter>2){//Страница подходит для вставки баннера посередине, вставляем
					$page_html=string_replace_nth("<br><br>", "<br><br>".$ad_block_code, $page_html, 3);
				}
			} else{
				$page_html=string_replace_nth('</p>', "</p>".$ad_block_code, $page_html, 3);
			}
		}
		#Ищем ключевички и заменяем
		
		$pageTags=explode(";",$pagequery['tags']);
		foreach ($pageTags as $tag){
			$link_htmlCode="<a href='/?page=CTATbu&search_string=".$tag."' class='justlink'>".$tag."</a>";
			$page_html=string_replace_nth(" $tag ", "$link_htmlCode", $page_html, 1);
			
		}
		
		#Выводим страницу?>
		
		<style>

/*Стиль всех блоков для картинок*/
.pic {
overflow: hidden; /*Скрывает все, что не влазит в блок*/
margin: 9px;
border: 10px solid #fff; /*Для всех браузеров*/
border: 10px solid #eee\9; /*Для IE6, IE7, IE8*/
-webkit-box-shadow: 2px 3px 10px #6E6E6E;
box-shadow: 2px 3px 10px #6E6E6E;
float: left;}
.pic:hover { cursor: pointer;}



</style>
		
		
		<div class="row  flex-items-md-center articleBody_text" itemprop="articleBody">
			
		<? if($pagequery['page_img']){ //Выведем картинку
			list($artcl_img_width, $artcl_img_height, $artcl_img_type, $artcl_img_attr) = getimagesize($pagequery['page_img']);
			?><span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<div class="pic on_hover_sepia light-rounded">
				<img class="itemprops light-rounded" itemprop="url image" src="<?=$pagequery['page_img']?>" alt="<?=$pagequery['pagetitle_'.$language]?>" style="width:100%">
			</div>
			<meta itemprop="width" content="<?=$artcl_img_width?>"><meta itemprop="height" content="<?=$artcl_img_height?>">
			</span><?
		}
		
		echo $page_html;
		?><!--a style="text-decoration:none">: <?=$pagequery['pagetitle_ru']?></a--><a href="<?=$pagequery['orig_link'];if (mb_strstr($pagequery['orig_link'],'b17.ru')){
										?>?prt=psyspace<? }?>" target="_blank"><i class="fas fa-external-link-alt"></i></a>
		</div>
		<link itemprop="url" href="/?page=<?=$pagequery['page']?>" />
		<meta itemprop="datePublished" content="<?=mb_substr($pagequery['creation_date'],0,10)?>">
	
	<? 	#Выведем кружочки с тегами?>
		<div class="row  flex-items-md-center">
<?		foreach ($pageTags as $tag){
			if($tag) {
				?><a href="/?page=CTATbu&search_string=<?=$tag?>" class="tag_circle justlink hvr-outline-in"><?=$tag?></a><?
			}
		}?>
		</div>
		<?
		#Выводим комментарии
		include ($_SERVER['DOCUMENT_ROOT'].'/commenton/index.php'); 
		
	}
	else {// Для Яндекс Турбо

		if ($rss_lang=='ru') echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$pagequery['page']);
		elseif($rss_lang=='en') echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html_en/'.$pagequery['page']);
	}
	
	#Скрипты для странички AMP
	if ($pagequery['script_after_page'] and $ampreq){#Вставляем скрипт после странички AMP
		echo '<!-- Скрипт(ы) после страницы: '.$pagequery['script_after_page'].'-->';
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/show_likes.php');
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/show_related_articles.php');
		echo '<!-- // Скрипт после страницы -->';
	}
	?>
	<script> 
	$(window).on('load',function(){
	//$(document).ready(function(){
		yandex_target("article_page_opened");//Фиксируем открытие страницы в Яндекс.Метрика
	
		// находим ссылки без href и подставляем
		$('.articleBody_text').find('a').each(function() {
			if($(this).attr('href') == null){ //нет ручек, нет и подарков
				$(this).attr('href','/?page=CTATbu&search_string='+$(this).text());
				$(this).attr('target','_blank');
				$(this).attr('class','articleBody_text_a');
				$(this).attr('style','color:#555b5e;border-bottom: 1px dashed #000080;');
			}
		});
		
	});
	
	// находим ссылки без href и подставляем
		$('.articleBody_text').find('a').each(function() {
			if($(this).attr('href') == null){ //нет ручек, нет и подарков
				$(this).attr('href','/?page=CTATbu&search_string='+$(this).text());
				$(this).attr('target','_blank');
				$(this).attr('class','articleBody_text_a');
				$(this).attr('style','color:#555b5e;border-bottom: 1px dashed #000080;');
			}
		});
	</script>
	<?
}//nitka?>