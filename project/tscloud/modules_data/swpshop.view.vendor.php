<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
?><div class="b-inner-top-banners">
	<div class="banner banner_left" style="background-image: url('<?=$vendorlogo['photo_path']?>')">
	  <div class="decorator png"></div>
	</div>
	<div class="banner banner_right" style=" <? //background-image: url('/upload/iblock/fb9/fb9649217d6e96a189493224aa7514db.png')?>">
	  <div class="banner_wrap">
		<div class="message">
		  <div class="title"><?=$vendorinfo['vendor_short_description_'.$language];?><br><a href='/?page=swpshop&action=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>'><?=$vendorinfo['vendor_name_'.$language]?></a>&nbsp;<? if ($vendorcountry['country_name_'.$language]){ echo "(".$vendorcountry['country_name_'.$language].")";}?></div>
		</div><? 
		if ($vendorinfo['vendor_domain_'.$language] or $vendorinfo['vendor_domain_ru']){?>
					<script>
						$(document).ready(function(){
							ajaxreq('<?=$vendorinfo['vendor_id']?>','<?=$language?>','check_vendor_domain','vendordom_ap','<?=$modulename?>');
						})
						
					</script>
					<div id="vendordom_ap"></div>
					<div class="buttons png" id="vendor_link_button" style="display:none;">
					  <a class="button button_large" href="<?
					  if($vendorinfo['vendor_domain_'.$language]) echo $vendorinfo['vendor_domain_'.$language];
					  else $vendorinfo['vendor_domain_ru'];?>" target="_blank">
						
						  <?if($language=="en"){?><span  style="font-size:14px; margin:10px 0 0 0px;">To vendor<br>web portal</span><?} 
						  elseif($language=="ru"){?><span  style="font-size:14px; margin:10px 0 0 40px;">Посетить сайт производителя</span><?}?>
						
					  </a>
					</div>
					<?
		}?>
	  </div>
	</div>
<div class="b-page b-text">
<h2><?=$vendorinfo['vendor_name_'.$language]?></h2>
<?=$vendorinfo['vendor_description_'.$language];
if(!$show_vendor_wiki) global $show_vendor_wiki;
if($show_vendor_wiki=="Показывать, если есть ссылка на Вики"){
	if($vendorinfo['vendor_wiki_link_'.$language] or $vendorinfo['vendor_wiki_link_ru']){
	?><p>
		<a href="<? if($vendorinfo['vendor_wiki_link_'.$language]) echo $vendorinfo['vendor_wiki_link_'.$language]; else {echo $vendorinfo['vendor_wiki_link_ru'];}?>" target="_blank"><?if($language=="en"){ echo $vendorinfo['vendor_name_'.$language];?> on Wikipedia<?} elseif($language=="ru"){?>Википедия о <?=$vendorinfo['vendor_name_'.$language];}?></a>
	</p>
<?}
}
# Все продукты вендора в каталоге
if($products_on_vendorpage=="Показывать"){
	// доделать
}
?>
</div></div>
<? }//nitka?>