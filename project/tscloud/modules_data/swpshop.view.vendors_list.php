<? $log->LogInfo('Got '.(__FILE__));
if($nitka=="1"){
while($vendorinfo=mysql_fetch_array($vendorinforeq)){?>
<div class="b-other-projects b-text mb services_item">
		<div class="wrap">
		<h2><a href='/?page=<?=$modulename?>&action=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>'><?=$vendorinfo['vendor_name_'.$language]?></a></h2>
		 <div class="b-text_2col">
		<table>
		<tbody>

		<tr>
		<td><img src="<?=$vendorinfo['photo_path']?>" width="150px" class="light-rounded emphasize-dark" style="margin:10px"></td><td>
		<table>
		<tbody>
		<td><? if($language=="en"){?>Description<?} elseif($language=="ru"){?>Описание<?}?></td><td width="30px"><b>:</b></td><td><?=$vendorinfo['vendor_short_description_'.$language];?></td></tr>
		<tr><td><? if($language=="en"){?>Product<?if($vendproduct_count[$vendorinfo['vendor_id']]>1){?>s<?}} elseif($language=="ru"){?>Продукт<?if($vendproduct_count[$vendorinfo['vendor_id']]>1){?>ы<?}}?></td><td><b>:</b></td><td>
		<?

		while ($productinfo=mysql_fetch_array($productinforeq[$vendorinfo['vendor_id']])){?><a href="/?page=<?=$modulename?>&action=show_product&productid=<?=$productinfo['product_id']?>"><?=$productinfo['product_short_title_'.$language]?></a><br><?}
		?>
		</td></tr>
		<tr><td><? if($language=="en"){?>Country<?} elseif($language=="ru"){?>Страна<?}?></td><td><b>:</b></td><td title="<?=$productinfo['product_id']?>"><?if ($vendorinfo['country_name_'.$language]){echo $vendorinfo['country_name_'.$language];} else{echo $vendorinfo['country_name_en'];}?></td></tr>
		<tr><td></td><td></td><td title="<?=$productinfo['vendor_name_'.$language]?>"><a href="/?page=<?=$modulename?>&action=show_vendor&vendor_id=<?=$vendorinfo['vendor_id']?>&menu=services_<?=$vendorinfo['vendor_id']?>"><? if($language=="en"){?>Vendor full description<?} elseif($language=="ru"){?>Полное описание производителя<?}?></a></td></tr>
		</tbody></table>
		</td>

		</tbody></table>
		</div></div></div>
<?}
}//nitka?>