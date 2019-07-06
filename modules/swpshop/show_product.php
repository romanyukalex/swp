<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ?>
<? if($nitka=="1"){
$vendorinfo=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` products, `$moduletableprefix-product-vendors` vendors
where products.`product_vendor_id`=vendors.`vendor_id` and products.`product_id`='$product_id'"));
$productinfo=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` products
where	products.`product_id`='$product_id';"));
	?>
	<div class="b-inner-top-banners">
					<div class="banner banner_left" style="background-image: url('<?=$productinfo['product_main_image']?>')">
					  <div class="decorator png"></div>
					</div>
					<div class="banner banner_right">
					  <div class="banner_wrap">
						<div class="message">
						  <div class="title"><?=$vendorinfo['vendor_short_description_'.$language];?><br><a href='/?page=$modulename&pagetype=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>'><?=$vendorinfo['vendor_name_'.$language];?></a></div>
						</div>
						<? global $userrole;
						if($userrole!=="user"){?>
						<a class="b-button b-button_sidebar mt-40 js-window" style="position:absolute;    bottom:0;width:89%"
						<? if($userrole=="superuser") {?>href="/?page=order&pagetype=showvariants&productid=<?=$product_id?>" onclick="showblock('variant_form_1');	$('#variant_form_div').arcticmodal(); return false;"<? }
						  elseif($userrole=="guest" or !$userrole){?>href="/?page=register_needed&menu=services"<?}?>
						  >
						<span class="png"><?if($language=="en"){?>Order<?} elseif($language=="ru"){?>Заказать<?}?></span></a>  
						<? }?>
						
						<? /*<div class="buttons png" id="orderbutton">
						  <a class="button button_large" 
						  <? if($userrole=="superuser") {?>href="/?page=order&pagetype=showvariants&productid=<?=$product_id?>" onclick="$('#variant_form_div').arcticmodal();return false;"><? }
						  elseif($userrole=="guest" or !$userrole){?>href="/?page=register_needed&menu=services"><?}
						  elseif($userrole=="user"){?>><script>$(document).ready(function(){$('#orderbutton').hide();})</script><?}?>
						  
							<span  style="font-size:24px; margin-top:10px">
							  Заказать
							</span>
						  </a>
						</div>*/?>
						
					  </div>
					</div>
<div class="b-page b-text">
<h2><? if ($productinfo['product_id']){
		echo $productinfo['product_full_title_'.$language]; 
		if ($vendorinfo['vendor_id']){
			if($language=="en"){echo " by ";} elseif($language=="ru"){echo " от ";}
			?><a href='/?page=$modulename&pagetype=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>'><?=$vendorinfo['vendor_name_'.$language];?></a><?
		}
		echo " [".$productinfo['product_short_title_'.$language]."]";
	} else echo sitemessage("$modulename",'product_not_found')?></h2>
<?=$productinfo['product_full_description_'.$language]?>

<? 

### Варианты ###
include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/get_product_variants.php");

if($userrole=="superuser") {
	$varnumber=mysql_num_rows($productvarreq);
	if ($varnumber>0){
?>
<div style="display: none;">
<div class="checkbox-radio-css3-show box-modal" id="variant_form_div" style="visibility: 0">
<div class="box-modal_close arcticmodal-close">закрыть</div>
	<form id="variant_form_1">
		<h1>Пожалуйста, выберите вариант предоставления продукта:</h1>
		<br/>
        <? insert_function("StringPlural");
		while ($productvariant=mysql_fetch_array($productvarreq)){
				$n++;?>
				<p><input type="radio" id="r<?=$productvariant['variant_id']?>" name="variantid" value="<?=$productvariant['variant_id']?>"/>
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
                <input type="image" src="/project/<?=$projectname?>/files/send_<? global $language;echo $language;?>.png"
				onclick="saveform3('','variant_form_1','varform_message_place_ok','varform_message_place_nok','<?=$modulename?>','to_order','resetform',''); return false;">
			</div>
	</form>
	 <div class="varform_message" id="varform_message_place_ok"></div>
</div>
</div>
<? }
} // Варианты
insert_module("arcticmodal");
 ?>
</div></div>
<? }//nitka?>