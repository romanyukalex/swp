<? $log->LogInfo("Got ".(__FILE__)); ?>
<? if($nitka=="1"){
$productreq=mysql_query("select * from `$moduletableprefix-product` products
where
	products.`product_id`='$product_id'
;");
$vendorinfo=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` products, `$moduletableprefix-product-vendors` vendors
where products.`product_vendor_id`=vendors.`vendor_id` and products.`product_id`='$product_id'"));
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

<? # Варианты

# Получаем все rights юзера по userid
$userrightsreq=mysql_query("SELECT DISTINCT * FROM 
	`$tableprefix-users` u, 
	`$tableprefix-users-groupmembers` gm,
	`$tableprefix-users-grouprights` gr
WHERE
	u.`userid`=gm.`userid` and
	gr.`group_id`=gm.`group_id` and
	u.`userid`='$userid'
	");
include_once($_SERVER["DOCUMENT_ROOT"]."/modules/$modulename/get_product_variants.php");
/*
$variants_for_user="";
while ($userrights=mysql_fetch_array($userrightsreq))
{ 
if ($userrights['table']=="$moduletableprefix-product-variants") $variants_for_user.="`variant_id`=".$userrights['oid']." or ";
}
$variants_for_user=substr($variants_for_user,0,-4);
$productvarreq=mysql_query("select * from  `$moduletableprefix-product-variants` 
where
	`product_id`='$product_id' and 
	( $variants_for_user )
;");*/
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