<? $log->LogInfo('Got '.(__FILE__)); 
if($nitka=="1"){
while($productinfo=mysql_fetch_array($productreq)){
	?>
	<div class="b-inner-top-banners">
					<div class="banner banner_left" style="background-image: url('<?=$productinfo['product_main_image']?>')">
					  <div class="decorator png"></div>
					</div>
					<div class="banner banner_right" style="background-image: url('/upload/iblock/fb9/fb9649217d6e96a189493224aa7514db.png')">
					  <div class="banner_wrap">
						<div class="message">
						  <div class="title"><?=$vendorinfo['vendor_short_description_'.$language];?><br><?=$vendorinfo['vendor_name_'.$language];?></div>
						</div>
					  </div>
					</div>
<h2><?=$productinfo['product_shortdescription']?></h2>
<?=$productinfo['product_full_description']?>

<? 
echo "<br><br>ВАРИАНТЫ<br><br>";
while ($productvariant=mysql_fetch_array($productvarreq)){
echo $productvariant['description_'.$language]."<br>"."Будет развернуто через ".$productvariant['provision_lead_time']."<br>"."Стоимость = ".$productvariant['price']." ".$productvariant['currency']." <a href=''>Заказать</a><br><br>";
}

?>
					

</div>
<? } ?>
<script>
$(document).ready(function(){
$('#service_button a').attr("href","/?page=order&pagetype=showvariants&productid=<?=$product_id?>");
$('#service_button').show(1000);
})
</script>
<? }//nitka?>