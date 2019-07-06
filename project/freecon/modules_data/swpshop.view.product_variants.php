<? $log->LogInfo("Got ".(__FILE__));
if($nitka=="1"){

?><br><br>Варианты продукта: <?=$productinfo['product_full_title_'.$language]?><br><br>

<? 
	while ($productvariant=mysql_fetch_assoc($productvarreq)){
		echo $productvariant['description_'.$language].' - '.mb_substr($productvariant['price'],0,-3)?> ₽ <a class="justlink" href='/?page=<?=$page?>&action=add_to_cart&productid=<?=$product_id?>&variant=<?=$productvariant['variant_id']?>'>В корзину</a><br><br><?
	}

?>
<script>
$(document).ready(function(){
$('#service_button a').attr("href","/?page=order&pagetype=showvariants&productid=<?=$product_id?>");
$('#service_button').show(1000);
})
</script>
<? }//nitka?>