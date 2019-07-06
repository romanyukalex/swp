<? 
  /***************************************************************************************************************************
  * Snippet Name : Scripts and styles																						 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Вставляется в <head></head>, содержит стили и javascripts шаблона										 *
  * Insert		 : include_once('/templates/$currenttemplate/scripts_and_styles.php');										 *
  ***************************************************************************************************************************/ 
 //echo "<!-- This project scripts and styles-->";
 ?>
<!--link href="/project/<?=$projectname?>/files/kernel.css" type="text/css" rel="stylesheet"-->
<!--script src="/project/<?=$projectname?>/files/all.js" id="facebook-jssdk"></script-->
<!--script src="/project/<?=$projectname?>/files/jquery_002.js"></script-->
<script src="/project/<?=$projectname?>/files/jquery_002.js"></script>
<!--script src="/project/<?=$projectname?>/files/jquery-ui.js"></script-->
<!--script src="/project/<?=$projectname?>/files/jquery_005.js"></script-->
<script src="/project/<?=$projectname?>/files/jquery_003.js"></script>
<script src="/project/<?=$projectname?>/files/toolbox.js"></script>
<script src="/project/<?=$projectname?>/files/jquery_004.js"></script>
<!--script src="/project/<?=$projectname?>/files/jquery_006.js"></script-->
<script src="/project/<?=$projectname?>/files/jquery.js"></script>
<script src="/project/<?=$projectname?>/files/scripts22.js"></script>
<!--script type="text/javascript" src="/project/<?=$projectname?>/files/kernel.js"></script-->
  <!-- { CSS -->
    <link charset="utf-8" href="/project/<?=$projectname?>/files/style.css" media="all" rel="stylesheet" type="text/css">
<link charset="utf-8" href="/project/<?=$projectname?>/files/stylemy.css" media="all" rel="stylesheet" type="text/css">
    <link charset="utf-8" href="/project/<?=$projectname?>/files/font.css" media="all" rel="stylesheet" type="text/css">
    <link charset="utf-8" href="/project/<?=$projectname?>/files/jqtransform.css" media="all" rel="stylesheet" type="text/css">
    <!--[if IE]>
      <link charset="utf-8" href="/project/<?=$projectname?>/files/ie.css" media="all" rel="stylesheet" type="text/css">
    <![endif]-->
    <!-- CSS } -->
    <!-- { JS -->
    <!--script charset="utf-8" src="/project/<?=$projectname?>/files/yepnope.js" type="text/javascript"></script-->
<script charset="utf-8" src="/project/<?=$projectname?>/files/jquery_002.js" type="text/javascript"></script>
    <!--script charset="utf-8" src="/project/<?=$projectname?>/files/yepnope-data.js" type="text/javascript"></script-->
    <!--[if IE 6]>
      <script charset="utf-8" src="/project/<?=$projectname?>/files/pngfix.js" type="text/javascript"></script>
    <![endif]-->
    <!-- JS } -->
<script language="javascript">
$(document).ready(function(){

$("#city_open").click(function(){

$("#city_slide").slideToggle(300);


});


});
</script>

<style>
p{text-indent: 0em;}
</style>
<script language="javascript">

$(document).ready(function(){

$(".mini a").hover(function(){

$(this).next(".mini .text1").css({'display':'block'})
return false;


}, 
function(){

$(this).next(".mini .text1").hide(300);
return false;

});

$(".mini .text img").click(function(){

$(this).parent(".mini .text1").hide(300);
return false;


});



});

</script>
 
<style>
.mini a{
text-decoration:none;
color:#1D5F7F;
border-bottom:1px dashed;
cursor: pointer;
}

#krest{
float:right;
}
</style>