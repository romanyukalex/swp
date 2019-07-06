<!-- Description -->
<section class="description results_wide grid_12">
<? 
$projectid=$_REQUEST['id'];
$my_xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/html/portfolio.xml');
if($projectid=="any"){$projectid=$my_xml->item[rand (0, count($my_xml->item))]->id;settype($projectid,string);}

//echo $projectid;
//if ((string) $my_xml->item->id == $projectid) {$item=$my_xml->item;
	//echo $my_xml->item->imagesource;
//}

foreach ($my_xml->item as $item)
		{
			if($projectid==$item->id){
			?>
    <a href="files/800x600/<?=$item->imagesource?>" class="main_image fancybox"><img src="files/300x200/<?=$item->imagesource?>" alt="<?=$item->projectname?>" /></a>

    <div>
        <span>
            <span class="boxed"><a href=""><?=$item->projectname?></a></span>
        </span>
        <span>
            <span class="stars boxed">
                <? $rating=explode ('-', $item->rating);
				
				for ($rat=1;$rat<=$rating[0];$rat++){?><img src="files/star_ful.png" alt="" /><? }
				for ($rat=1;$rat<=$rating[1];$rat++){?><img src="files/star_hal.png" alt="" /><? }
				$allstartcount=$rating[0]+$rating[1];
				if($allstartcount<5){
					for ($rat=$allstartcount;$rat<5;$rat++){?><img src="files/star_emp.png" alt="" /> <? }
                }?>
            </span>
        </span>
        <span><?=$item->user?></a></span>
        <span><?=$item->shortdescription?></span>
        <? if($item->price){?><span class="price" style="margin:-10px 20px 0 0;"><?=$item->price?></span><? }?>
    </div><script>$(document).ready(function () {
    $('#h2titleonpage').html("<span>Проект <?=$item->projectname?></span>");});
    </script>

    <p><?=$item->projectdescription?></p>

</section>
<? if($item->gallery){?>
<!-- Image gallery -->
<section class="gallery grid_12">
    
    <!-- Slider navigation -->
    <nav class="slider_nav">
        <a href="" class="left">&nbsp;</a>
        <a href="" class="right">&nbsp;</a>
    </nav>

    <!-- Slider -->
    <div class="slider_wrapper">

        <!-- Slider content -->
        <div class="slider_content">
        <? while(count($item->gallery->image<12)){
		foreach($item->gallery->image as $image){?>
            <a href="files/800x600/<?=$image?>">
                <img src="files/150x110/<?=$image?>" />
            </a>
     <? 	}
	 	}?>
        </div>

    </div>

</section>
<? }?>
<div class="clearfix"></div>
<hr class="dashed grid_12" />

<!-- Simple text -->
<section class="text padded_right grid_8">
    <h3 class="text_big">Как это было</h3>
    <p><?=$item->fulldescription?></p>
</section>

<!-- Right Thing -->
<section class="video grid_4">
<? if($item->logofile){?><center><img src="/files/logo/<?=$item->logofile?>" style="margin:10px 0"></center><? }?>
</section>

<div class="clearfix"></div>
<hr class="dashed grid_12" />

<!-- Features -->
<section class="similar_hotels grid_12">
    
    <h2 class="section_heading">Фунционал сайта / состав проекта</h2>
    <ul><? foreach ($item->features->feature as $item2){?>
        <li>
            <img src="files/ok.png" alt="OK" style="vertical-align:top; margin:10px 30px 0px 20px"/>
            <h3 style="vertical-align:top; margin-top:20px"><?=$item2?></h3>
           <? /* <span class="stars">
                <img src="files/star_ful.png" alt="" />
                <img src="files/star_ful.png" alt="" />
                <img src="files/star_ful.png" alt="" />
                <img src="files/star_hal.png" alt="" />
                <img src="files/star_emp.png" alt="" />
            </span>
            <div>
                <span><a href="">Malorca</a></span>
                <span><strong>1 899 €</strong> / 10 nights</span>
            </div>*/?>
        </li><? }//FEach?>
     
    </ul>
    
</section>

<? if($item->link){?>
<div class="clearfix"></div>
<hr class="dashed grid_12" /><br />
<!-- page slider -->
<section class="grid_12" id="iframe_for_pages">
<h3 class="text_big">Живая демонстрация</h3>
 <iframe src="<?=$item->link?>"></iframe>
</section>
<span class="boxed" style="margin-left:20px"><a href="<?=$item->link?>" target="_blank">Посетить сайт (в отдельном окне)</a></span><br />
<span class="boxed" style="margin-left:20px"><a href="/?page=project&id=any&salt=<?=rand(1,10000)?>">Просмотреть случайно выбранный проект</a></span>
<?  }?>

<?	}//if 
}// foreach
/*?>
<div class="clearfix"></div>
<hr class="dashed grid_12" />

<!-- Simple text -->
<section class="text grid_4">
    <h3>Curabitur rutrum</h3>
    <p>Curabitur rutrum lacinia dui vitae tempus. Etiam porttitor, metus id rutrum placerat, quam arcu lobortis magna, et ornare leo massa at massa. Aliquam tempor iaculis dui at pellentesque. Pellentesque accumsan consectetur dolor sed facilisis. Etiam sed purus sem, quis accumsan nunc.</p>
</section>

<!-- Simple text -->
<section class="text grid_4">
    <h3>Sed vitae mauris</h3>
    <p>Sed vitae mauris vitae elit porta rhoncus at eget augue. Pellentesque eu ante eu ante mollis eleifend. Praesent a eros elit, vitae dapibus sem. Morbi scelerisque nulla at lorem egestas fringilla. Proin sit amet lectus ac risus sagittis auctor. Nulla laoreet lobortis pulvinar.</p>
</section>

<!-- Simple text -->
<section class="text grid_4">
    <h3>Sed vitae mauris</h3>
    <p>Sed vitae mauris vitae elit porta rhoncus at eget augue. Pellentesque eu ante eu ante mollis eleifend. Praesent a eros elit, vitae dapibus sem. Morbi scelerisque nulla at lorem egestas fringilla. Proin sit amet lectus ac risus sagittis auctor. Nulla laoreet lobortis pulvinar.</p>
</section>*/?>