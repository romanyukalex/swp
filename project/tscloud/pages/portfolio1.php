<section class="search_box sidebar grid_4">

		<h2>Меню:</h2>
        <form class="black" action="">
        <input type="submit" value="Выбрать лучшее" onclick="onlybestsites();return false;"><br /><br />
        <input type="submit" value="Только Web-сайты" onclick="onlywebsites();return false;"><br ><br />
         <input type="submit" value="Вce" onclick="showallsites();return false;"><br />
		</form>

	</section>
<script>
function onlybestsites(){
	showallsites();
	$('#portfoliosites li:not(.bestsite)').hide(2000);
	$('#portfoliosites .bestsite').show();
	}
function onlywebsites(){
	showallsites();
	$('#portfoliosites .shrtdscrpt:not(:contains("Сайт"))').parent().parent().hide(2000);
	$('#portfoliosites .shrtdscrpt:contains("Сайт")').parent().parent().show();
}
function showallsites(){
$('#portfoliosites li').show(2000);
}
</script>
<? 
$prod_query_text="SELECT DISTINCT
 `product_id` , `product_code` , `product_full_title` , `product_short_title` , `product_shortdescription` , `product_full_description` , `product_autor` , `product_gallery_id` ,ph1.`photo_path`  as product_main_image_photo_path , 
 ph.`photo_path` as product_label_photo_path, `product_price` , `product_old_price` , `link` , `product_rating_value` , `product_rating_votes` , `product_rating_summ` , `keywords` , ven.`vendor_id`, `vendor_name` , `vendor_domain` , `vendor_description` ,ph2.`photo_path` as vendor_logo_path,ph2.`photo_title` as vendor_logo_photo_title, country.`country_code` as vendor_country_code

 FROM `$tableprefix-product` pr,`$tableprefix-product-vendors` ven,`$tableprefix-photos` ph,`$tableprefix-photos` ph1,`$tableprefix-photos` ph2,`$tableprefix-galleries` gal,`$tableprefix-country` country
WHERE 
pr.`vendor_id`=ven.`vendor_id` and 
pr.`product_label` = ph.`photo_id` and 
pr.`product_main_image`=ph1.`photo_id` and 
ven.`vendor_logo`=ph2.`photo_id` and 
ven.`vendor_country_id`=country.`country_id`
";
$procuct_query=mysql_query($prod_query_text);
echo $prod_query_text;
?>
<!-- PortfolioItems -->
<ul class="results_wide grid_8" id="portfoliosites">
<?
while($item=mysql_fetch_array($procuct_query)){?>
    <li<? if($item[keywords]){?> class="<?=$item[keywords]?>"<? }?>>
        <a href="/?page=project&id=<?=$item[product_code]?>" class="thumb"><img src="<?=$item[product_main_image_photo_path]?>" alt="<?=$item[product_full_title]?>" /><?
		// 200x170?></a>
        <h3><a href="/?page=project&id=<?=$item[product_code]?>"><?=$item[product_full_title]?></a></h3>
        <? if($item[product_price]){?><span class="price">$<?=$item[product_price]?></span><? }?>
        <div>
            <span><a href="/?page=project&id=<?=$item[product_code]?>"><?=$item[vendor_name]?></a></span>
            <span class="stars">
                <? /* $rating=explode ('-', $item[product_rating_value]);
				
				for ($rat=1;$rat<=$rating[0];$rat++){?><img src="files/star_ful.png" alt="" /><? }
				for ($rat=1;$rat<=$rating[1];$rat++){?><img src="files/star_hal.png" alt="" /><? }
				$allstartcount=$rating[0]+$rating[1];
				if($allstartcount<5){
					for ($rat=$allstartcount;$rat<5;$rat++){?><img src="files/star_emp.png" alt="" /> <? }
                }
				*/
				 $allstartcount=0;// Счетчик звезд
				for ($rat=1;$rat<=floor($item[product_rating_value]);$rat++){$allstartcount++;
				?><img src="files/star_ful.png" alt="" /><? }
				if(fmod($item[product_rating_value],1)!==0){ $allstartcount++;
				?><img src="files/star_hal.png" alt="" /><? }
				if($allstartcount<5){
					for ($rat=$allstartcount;$rat<5;$rat++){?><img src="files/star_emp.png" alt="" /><? }
                }
				?> 
            </span>
            <span class="shrtdscrpt"><?=$item[product_short_title]?></span>
        </div>
        <p><?=$item[product_shortdescription]?></p>
    </li>
<?	}?>
</ul>

<div class="clearfix"></div>
<? /*
<!-- Paging -->
<nav class="grid_8 prefix_4">
    <a href="" class="previous">Previous</a>
    <a href="" class="next">Next</a>
</nav>*/?>