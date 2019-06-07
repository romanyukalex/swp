<? $log->LogInfo('Got '.(__FILE__)); 
if($nitka=="1"){

$vendorinforeq=mysql_query("select * from `$moduletableprefix-product-vendors` v, `$tableprefix-photos` ph, `$tableprefix-country` cnt where ph.`photo_id`=v.`vendor_logo` and cnt.`id`=`vendor_country_id`;");

while($vendorinfo=mysql_fetch_array($vendorinforeq))
{//$curven_id=$vendorinfo['vendor_id'];
?>
<div class="b-other-projects b-text mb services_item">
		<div class="wrap">            
		<h2><a href='/?page=swpshop&pagetype=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>'><?=$vendorinfo['vendor_name_'.$language]?></a></h2>
		 <div class="b-text_2col">
		<table>
		<tbody>
		
		<tr>
		<td><img src="<?=$vendorinfo['photo_path']?>" width="150px" class="light-rounded emphasize-dark" style="margin:10px"></td><td>
		<table>
		<tbody>
		<td><? if($language=="en"){?>Description<?} elseif($language=="ru"){?>Описание<?}?></td><td width="30px"><b>:</b></td><td><?=$vendorinfo['vendor_short_description_'.$language];?></td></tr>			
		<? #Список продуктов вендора
		$productinforeq=mysql_query("select * from `$moduletableprefix-product` p,`$moduletableprefix-product-vendors` v where p.`product_vendor_id`=v.`vendor_id` and v.`vendor_id`='".$vendorinfo['vendor_id']."';");
		$vendproduct_count=mysql_num_rows($productinforeq);
		?>
		<tr><td><? if($language=="en"){?>Product<?if($vendproduct_count>1){?>s<?}} elseif($language=="ru"){?>Продукт<?if($vendproduct_count>1){?>ы<?}}?></td><td><b>:</b></td><td>
		<? 
		
		while ($productinfo=mysql_fetch_array($productinforeq)){?><a href="/?page=swpshop&pagetype=show_product&productid=<?=$productinfo['product_id']?>"><?=$productinfo['product_short_title_'.$language]?></a><br><?}
		?>
		</td></tr>
		<tr><td><? if($language=="en"){?>Country<?} elseif($language=="ru"){?>Страна<?}?></td><td><b>:</b></td><td title="<?=$productinfo['product_id']?>"><?if ($vendorinfo['country_name_'.$language]){echo $vendorinfo['country_name_'.$language];} else{echo $vendorinfo['country_name_en'];}?></td></tr>
		<tr><td></td><td></td><td title="<?=$productinfo['vendor_name_'.$language]?>"><a href="/?page=swpshop&pagetype=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>"><? if($language=="en"){?>Vendor full description<?} elseif($language=="ru"){?>Полное описание производителя<?}?></a></td></tr>
		</tbody></table>
		</td>
		
		</tbody></table>
		</div></div></div>
<?}
}//nitka?>