<link rel="stylesheet" href="/pages/reconstruction_page/files/style000.css" type="text/css" media="screen" />
   <?/*     
<script type="text/javascript" src="/pages/reconstruction_page/files/jquery-l.js"></script>
<script type="text/javascript" src="/pages/reconstruction_page/files/jquery01.js"></script>
<script type="text/javascript" src="/pages/reconstruction_page/files/jcarouse.js"></script>*/?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="/pages/reconstruction_page/files/jquery.countdown.js"></script>
<script type="text/javascript" src="/pages/reconstruction_page/files/jcarousellite1.0.1_min.js"></script>
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function () {
var austDay = new Date("<?=date( "F d, Y 00:00:00", strtotime($sitestartdate)); //June 24, 2012 00:00:00?>");
	$j('#defaultCountdown').countdown({until: austDay, layout: '{dn} {dl}, {hn} {hl}, {mn} {ml} и {sn} {sl}'});
	$j('#year').text(austDay.getFullYear());
	});
</script>


<!-- jquery slider -->
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function() {
    $j("#slidertext").jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
});
<? /*
function savesubsform(subscribeform,subscribeform,subscribeformmessage,startsitesubscribe){
	<? 
	$_SESSION['checksubsribeform']=rand(5,5555555);
	?>
	$('#chid').val("<?=$_SESSION['checksubsribeform']?>");
	saveform(subscribeform,subscribeform,subscribeformmessage,startsitesubscribe);
	
}*/?>

</script>

<!--script for IE6-image transparency recover-->
<!--[if IE 6]>
<script type="text/javascript" src="/pages/reconstruction_page/files/DD_belatedPNG_0.0.7a-min.js"></script>
<script>
  /* EXAMPLE */
  DD_belatedPNG.fix('#logo img,#main,.counter,.twitter,.flickr,.facebook,.youtube,#submit_button,.prev img,.next img,#email_input');
  
</script>
<![endif]--> 
</head>

<body style="background-color:#FFFFFF">
	<body class="home blog">
		
	<div class="container">
	
    <div id="header">
    
    	<div id="logo">
        	<a href="/"><img src="<? if($logofile!=="/pages/reconstruction_page/files/logo.png"){echo $logofile;} else echo "/pages/reconstruction_page/files/logo.png";?>" 
            height="100"/></a>
        </div><!--end logo-->
            
        <div id="contact_details">
        	<p><?=$officialemail?></p>
			<p>phone : <?=$contactphone?></p>
		</div><!--end contact details-->     
                
	</div><!--end header-->
              <div style="clear:both"></div> 
              
<div id="main">

		 <div id="content">
                    


<div class="text">
              <h2>Сайт <? if($sitedomainname=="domain.com") echo $_SERVER['HTTP_HOST']; else echo $sitedomainname;?> находится на реконструкции</h2>
              </div><!--end text-->
                  
              <div class="counter">
              <h3>Времени до запуска:</h3>
              <div id="defaultCountdown"> 
       
    </div>

         </div><!--end counter-->
                 
         <div class="details">
              <!--slider prev button-->    
            <a class="prev" href=""><img src="/pages/reconstruction_page/files/prev0000.png" alt="" /> 
            </a>

                  <div id="sliderwrap">
                  		<div id="slidertext"><!-- The slider -->
                                <ul>
                                	 <li>
                                     <h3 id="subscribeform_message">Мы можем выслать информацию о запуске на Ваш Email!</h3>
                                       
                                     <? /* 
                                    <form id="subscribeform" action="/" method="post" onSubmit="savesubsform('subscribeform','subscribeform','subscribeform_message','start-site-subscribe');return false;">
                                    <p>
                                    <div id="email_input"><input type="text" size="30" id="email" name="email" value="Введите E-mail" onFocus="if(this.value=='Введите E-mail'){this.value=''};" 	onblur="if(this.value==''){this.value='Введите E-mail'};" />
                                    <input type="hidden" value="" name="chid" id="chid"/>
                                    <input type="submit" id="submit_button" value="Submit" size="80" />
                                        
                                    </div>
                                    </p>
                                    </form>*/
									//insert_function("insert_module");
									insert_module("start_site_subscribe");
									?>
                                 	</li><!-- Slider item -->
                                   <li>
                                         <h3>Вы можете связаться с нами здесь:</h3>
                                         <div class="social">
                                         <? if($officialtwitter){?><a href="http://twitter.com/#!/<?=$officialtwitter?>" class="twitter" target="_blank"></a><? }?>
                                         <? if($officialfacebook){?><a href="https://www.facebook.com/<?=$officialfacebook?>" class="facebook" target="_blank"></a><? }?>
                                         </div>
                                    </li><!-- Slider item -->
                                 
                                 	<li>
                                         <h3>О нас:</h3>
                                         <p>
                                         <?if($sitedomainname=="domain.com") echo $_SERVER['HTTP_HOST']; else echo $sitedomainname;?></p>
                                        
                                 
                                	 </li><!-- Slider item -->
                            
                                </ul>
                            
             	 </div><!-- End of slidertext -->
    
              </div><!-- End of sliderwrap -->

					<!--slider next button-->
             	<a class="next" href=""><img src="/pages/reconstruction_page/files/next0000.png" alt=""/></a>
                  </div><!--end details-->
 </div><!--end content-->
</div><!--end main-->
</div><!--end class container-->
</body>