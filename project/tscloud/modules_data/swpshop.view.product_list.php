<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
while($productinfo=mysql_fetch_array($productinforeq))
{?>
<div class="b-other-projects b-text mb services_item">
		<div class="wrap">            
		<h2><a href="?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>&menu=services"><?=$productinfo['product_full_title_'.$language]?></a></h2>
		 <div class="b-text_2col">
		<table>
		<tbody><!--tr><td><? if($language=="en"){?>Vendor<?} elseif($language=="ru"){?>Производитель<?}?></td><td width="30px"><b>:</b></td><td><a href="/?page=swpshop&action=show_vendor&vendor_id=<?=$productinfo['vendor_id']?>&menu=services_<?=$productinfo['vendor_id']?>"><?=$productinfo['vendor_name_'.$language]?></a></td></tr-->			
		<tr><td><? if($language=="en"){?>Product<?} elseif($language=="ru"){?>Продукт<?}?></td><td width="20px"><b>:</b></td><td title="<?=$productinfo['product_short_title_'.$language]?>"><?=$productinfo['product_short_title_'.$language]?> <? if($language=="en"){?>by<?} else {?>от<?}?> <a href="/?page=swpshop&action=show_vendor&vendor_id=<?=$productinfo['vendor_id']?>&menu=services_<?=$productinfo['vendor_id']?>"><?=$productinfo['vendor_name_'.$language]?></a></td></tr>
		<tr><td><? if($language=="en"){?>Description<?} elseif($language=="ru"){?>Описание<?}?></td><td><b>:</b></td><td title="<?="[".$productinfo['product_id']."] ".$productinfo['product_full_title_'.$language]?>"><?=$productinfo['product_shortdescription_'.$language]?></td></tr>
		<tr><td></td><td></td><td title="<?=$productinfo['product_full_title_'.$language]?>"><a href="?page=swpshop&action=show_product&productid=<?=$productinfo['product_id']?>&menu=services"><? if($language=="en"){?>Product full description<?} elseif($language=="ru"){?>Полное описание продукта<?}?></a></td></tr>
		</tbody></table>
		</div></div></div>
<?}
}//nitka?>