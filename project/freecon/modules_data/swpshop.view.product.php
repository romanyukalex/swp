<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	if ($productinfo['product_id']){
		
		if(!$bot_name){ #Оповестим админа о том, что заходили смотреть на продукта
			
			insert_function("send_letter");
			$subject="Новый просмотр продукта магазина";
			$message="Пользователь (ip ".$ip.' зашел на страничку '.$_SERVER['REQUEST_URI'];
			if($_SESSION['prev_page']) $message.=' со страницы '.$_SESSION['prev_page'];
			$message.='<br>Время - '.date("Y-m-d H:i:s").'<br>'.$_SERVER['HTTP_USER_AGENT'];
			sendletter_to_admin($subject,$message);
		}
	?>

	<script>function renew_shoppingcart_count(order_id){
		
		ajax_rq ("swpshop","order_count_items","order_count_items","order_ap_nok_ap",order_id);

		$('#shopcart_link').fadeIn(2000);
	}
	</script>

	
	<ul class="n-breadcrumbs i-bem n-breadcrumbs_js_inited" id="n-breadcrumbs"><li class="n-breadcrumbs__item">
	<a class="link i-bem link_js_inited" title="Записи тренингов" href="/?page=swpshop">Записи тренингов</a></li>
	
	<li class="n-breadcrumbs__item">></li>
	<li class="n-breadcrumbs__item"><a class="link i-bem link_js_inited" title="<?=$productinfo['product_short_title_'.$language]?>" href="/?page=swpshop&action=show_product&productid=<?=$product_id?>"><?=$productinfo['product_short_title_'.$language]?></a></li></ul>
	
<div class="row flex-items-md-center">

	
	
<div id="ya_m_wr1" style="width:100%">
<div id="ya_m_wr2">
<div id="ya_m_wr3">	
<div id="ya_m_wr4">
<ul class="n-product-tabs__list">
	<li class="n-product-tabs__item<?if(!$_GET['subact']){?> n-product-tabs__item_state_selected<?}?>">
		<a class="link n-smart-link i-bem n-smart-link_js_inited link_js_inited" href="/?page=swpshop&action=show_product&productid=<?=$product_id?>">Описание</a>
	</li>

	<li class="n-product-tabs__item<?if($_GET['subact']=='show_short_desc'){?> n-product-tabs__item_state_selected<?}?>">
		<a class="link n-smart-link i-bem n-smart-link_js_inited link_js_inited"
		href="/?page=swpshop&action=show_product&productid=<?=$product_id?>&subact=show_short_desc">Содержание</a>
	</li>
	<li class="n-product-tabs__item<?if($_GET['subact']=='vendor_desc'){?> n-product-tabs__item_state_selected<?}?>">
		<a class="link n-smart-link i-bem n-smart-link_js_inited link_js_inited" href="/?page=swpshop&action=show_product&productid=<?=$product_id?>&subact=vendor_desc">О ведущем</a>
	</li>
		
	<!--li class="n-product-tabs__item<?if($_GET['subact']=='users_reviews'){?> n-product-tabs__item_state_selected<?}?>">
		<a class="link n-smart-link i-bem n-smart-link_js_inited link_js_inited" href="<?/*/?page=swpshop&action=show_product&productid=<?=$product_id?>&subact=users_reviews*/?>">Отзывы<?//<!-- количество отзывов span class="n-product-tabs__count">386</span>?></a>
	</li-->

</ul>
</div></div></div></div>



</div>


<div class="row flex-items-md-center" style="margin-top:20px" id="napoln">
<!-- 2 столбец -->
<? if($_GET['subact']=='show_short_desc'){#Содержание?>
		<div class="col col-md-9">
			<?=str_replace("\n","<br>",$productinfo['product_shortdescription_'.$language])?>
			<!--Кнопка-ссылка-->
			<br><br><a class="justlink button medium" href="/?page=swpshop&action=show_product&productid=<?=$product_id?>&subact=vendor_desc">Кто автор тренинга?</a>
		</div>
		
			
		
	
<?	} elseif($_GET['subact']=="vendor_desc"){ #О ведущем?>
		<div class="col col-md-9">
			<h2><?=$vendorinfo['vendor_name_'.$language]?><? if ($vendorcountry['country_name_'.$language]){ echo " (".$vendorcountry['country_name_'.$language].")";}?></h2>
			<? if($vendorinfo['vendor_logo']){?><img  style="cursor:pointer;float:left" data-toggle="modal" data-target="#exampleModal" width="20%" src="<?='/project/'.$projectname.$vendorinfo['vendor_logo_img'];?>"><?}?>
			<?=str_replace("\n","<br>",$vendorinfo['vendor_description_'.$language])?>
		</div>
		
	<!-- Modal фото тренера -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?=$vendorinfo['vendor_name_'.$language]?><? if ($vendorcountry['country_name_'.$language]){ echo " (".$vendorcountry['country_name_'.$language].")";}?></h5>
			<!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button-->
		  </div>
		  <div class="modal-body">
			<img width="80%" src="<?='/project/'.$projectname.$vendorlogo['photo_path'];?>">
		  </div>
		  <div class="modal-footer" style="text-align:center">
			<?=$vendorinfo['vendor_short_description_'.$language]?>
		  </div>
		</div>
	  </div>
	</div>
	
<?	} elseif(!$_GET['subact']){#Короткое описание и галерея
	?>
	
	<div class="col col-md-9">
	<!-- 1 слой (фото и краткое описание -->
	<div class="row flex-items-md-center">
		<!-- Левый блок фото-->
		<div class="col col-md-8" id="left_col">
		  
			
		  <img itemprop="image" src="/project/<?=$projectname;
				if($productinfo['product_main_image']) echo $productinfo['product_main_image']; else echo '/files/shop_img/empty_oblojka.png';?>" width="100%" class="thumbnail" alt="Обложка продукта <?=$productinfo['product_short_title_'.$language]?>">
		
		</div>
		<!-- // Левый блок фото-->
		<!-- Коротко о продукте -->
		<div class="col col-md-4" id="center_col">
			<div class="n-product-content-block" style="color: #404040;box-sizing: border-box;">
			
			<h3 id="short_about_h3" style="">Коротко о продукте</h3>
				<div  style="color: #404040;margin-bottom: 11px;box-sizing: border-box;">

					<ul class="n-product-spec-list" style="margin: 0; padding: 0; font-size: 13px; list-style: none;font-family: 'YS Text',sans-serif;">
					
					<? #Список фич 
					while($featuresinfo=mysql_fetch_assoc($featuresinfo_q)){
						?><li class="n-product-spec-list__item n-product-spec-list__item_type_friendly"><?=$featuresinfo['feature_title_'.$language]?></li><?
					}
					?>
					</ul><br>
				</div>
			</div>
		</div>
		<!-- // Коротко о продукте -->
	</div>
	<!-- // 1 слой (фото и краткое описание -->
	<!--  #Полное описание -->
	<div class="col row">

		<div class="col col-md-12" id="product_full_desc" itemprop="description"><?=str_replace("\n","<br>",$productinfo['product_full_description_'.$language]);?>
			<!--Кнопка-ссылка-->
			<br><br><a class="justlink button medium" href="/?page=swpshop&action=show_product&productid=<?=$product_id?>&subact=show_short_desc">Посмотреть содержание тренинга</a>
		</div>
	</div>
	</div>
	<!-- //2 столбец -->
	<? }?>
	
	<!-- 3 столбец -->
	<div class="col col-md-3">

	
	<div style="padding: 20px;    border-radius: 4px;background-color: #fff;box-shadow: 0 1px 8px 0 rgba(0,0,0,.06), 0 2px 2px 0 rgba(0,0,0,.12); align-self: flex-start;">
	<span itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="price" style="font-size: 26px;   font-weight: 700;    letter-spacing: .2px;    color: #222;"><?
	
	if ($varnumber>0){//Есть варианты продукта, значит есть цена
		if ($varnumber==1){ //Вариант у товара всего один
			$productvar=mysql_fetch_assoc($productvarreq);
			echo mb_substr($productvar['price'],0,-3)."&nbsp;";	if($productvar['currency']=="RUB") echo "₽";
			mysql_data_seek($productvarreq,0);
		} else{ //Вариантов несколько
			echo mb_substr($variant_min_price,0,-3)."&nbsp;₽";;
		}
	}?>
	
	<meta itemprop="price" content="<?=$productvar['price']?>">
	<meta itemprop="priceCurrency" content="RUB">
	<link itemprop="availability" href="https://schema.org/InStock">
	</span><br>
	
	<br><br>
	<img id="product_preview_img_rght" class="vp_block thumbnail" src="/project/<?=$projectname;
	if($productinfo['product_main_image']) echo $productinfo['product_main_image']; else echo '/files/shop_img/empty_oblojka.png';?>" width="100%" alt="Обложка продукта <?=$books_info['name']?>"style="display:none"><br>
	
	<a class="button large" style="color:white;background-color:  #36cdb6;" rel="nofollow" href="/?page=<?=$page?>&action=show_product_variants&productid=<?=$product_id;
	?>" onclick="<? if ($varnumber>0){?>$('#variants_modal').modal('show');return false;<? }?>">В корзину</a>
	
	<br><br>
	<? 
	#Ссылка на вендора
	if ($vendorinfo['vendor_id']) { ?>
		<a class="justlink" href='/?page=<?=$page?>&action=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>' 
		title="<?=$vendorinfo['vendor_short_description_'.$language];?>"><?
		#Картинка с вендором
		if($vendorinfo['vendor_logo']){?><img width="30px" class="imgmiddle" src="/project/<?=$projectname.$vendorinfo['vendor_logo_img']?>"><?}?>
		<?=$vendorinfo['vendor_name_'.$language];?></a><br><br>
	<?}?>
	<br>Поделиться: 
		<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="https://yastatic.net/share2/share.js" async="async"></script>
		<div class="ya-share2" data-services="vkontakte,twitter,facebook,gplus,odnoklassniki,skype" data-counter=""></div>
		<div class="ya-share2 hidden-md-up" data-services="telegram,viber,whatsapp" data-counter></div><? // СДЕЛАТЬ ТЕЛЕГРАММ ВАТСАП и ВАЙБЕР НЕВИДИМЫМИ ДЛЯ ДЕКСТОПА?>
	<br>Лайк:
		<? insert_module("vk-api","show_like_button");?>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.9&appId=300626623690724";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="https://soznanie.club<?=$_SERVER['REQUEST_URI']?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
	<br>Сохранить:
		<div class="ya-share2" data-services="collections,blogger,delicious,evernote" data-counter></div>
		</div>
	</div><!-- // 3 столбец -->
	
</div>

<?} else echo sitemessage("$modulename",'product_not_found');?>

<div class="row">
	
	<div class="col col-md-6 col-md-offset-3" id="yt_descr" style="font-family: ProximaNova Reg;font-style: normal;font-weight: normal;font-size: 18px;line-height: 26px;color: #555b5e;">

</div>
</div>

<div class="row">
	<div class="col col-md-6 col-md-offset-3">
	<? #Делаем из тегов ссылки
	$tags_arr=explode(';',$book_info['tags']);
	foreach ($tags_arr as $tag){
		if($tag){
		?><a href="/?page=videos&search_string=<?=$tag?>" class="bcgr_grey tag_circle"><?=$tag?></a><?
		}
	}
	?>
	</div>
</div>



<? 

### Варианты ###
if ($varnumber>0){
?>
<div class="modal fade" id="variants_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Пожалуйста, выберите вариант продукта</h4></span>
      </div>
      <div class="modal-body">
	  
		  <form id="variant_form_1">
			
			<? insert_function("StringPlural");
			//var_export($productvarreq);
			while ($productvariant=mysql_fetch_assoc($productvarreq)){
					$n++;?>
					<p><input type="radio" id="r<?=$productvariant['variant_id']?>" name="variantid" price="<?=mb_substr($productvariant['price'],0,-3)?>" value="<?=$productvariant['variant_id']?>"/>
					<label for="r<?=$productvariant['variant_id']?>" id="vartext_<?=$productvariant['variant_id']?>"><span></span><?=$productvariant['description_'.$language]?> - <?=$productvariant['price']." ".$productvariant['currency']." "; 
					if($productvariant['charging_period_months'] and $productvariant['charging_period_months']!==0){
						echo "за ".$productvariant['charging_period_months']." ".(StringPlural::Plural($productvariant['charging_period_months'], 'месяц', 'месяца', 'месяцев'));
					} elseif($productvariant['charging_period_days'] and $productvariant['charging_period_days']!==0){
						echo "за ".$productvariant['charging_period_days']." ".(StringPlural::Plural($productvariant['charging_period_days'], 'день', 'дня', 'дней'));
					}?></label>
					</p>
					<script>
					put_space_to_digits("#vartext_<?=$productvariant['variant_id']?>");
					</script>
			<? 	}?>
				<br><br>
				<div id="varform_message_place_nok" class="varform_message"></div>
				<div>
					<a class="button large" id="addToCartButton" style="color:white;background-color:  #36cdb6;" rel="nofollow" onclick="saveform3('','variant_form_1','varform_message_place_ok','varform_message_place_nok','<?=$modulename?>','to_order','resetform',''); return false;">В корзину</a>
					<!-- The below method uses jQuery, but that is not required -->
					
					<!-- Add event to the button's click handler -->
					<script type="text/javascript">
					$( '#addToCartButton' ).click(function() { // Отправляем статистику в FB pixel
					//Добавить определение выбранной цены в переменную и отправка ее в fbq
					var mmnn = $( "#variant_form_1 input:checked" ).attr("price");
					
					fbq('track', 'AddToCart', {
					content_ids: ['<?=$product_id;?>'],
					content_type: 'product',
					value: mmnn,
					currency: 'RUB'
					});
					
					
					//Цель в метрике
					yaCounter30423247.reachGoal('AddPrToCart');
					
					(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-204268-3kH4T';
					});
					</script>

				</div>
		</form>
		 <div class="varform_message" id="varform_message_place_ok"></div>
		<a class="button large" style="display:none" href="/?page=<?=$modulename?>&action=show_shoppingcart" id="shopcart_link">Оформить заказ</a>
      </div>
    </div>
  </div>
</div>
<? }
//} // Варианты
//insert_module("arcticmodal");
 ?>

<? }//nitka?>