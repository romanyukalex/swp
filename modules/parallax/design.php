<?php
 /****************************************************************
  * Snippet Name : parallax effect           					 * 
  * Scripted By  : RomanyukAlex	& http://webdev.stephband.info	 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : parallax										 *
  * Access		 : include									 	 *
  ***************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
?>
<STYLE type="text/css" media="screen, projection">
  #parallax
    {position: absolute; overflow:hidden; width:60em; height:20em; z-index:1}
</STYLE>
<!--<SCRIPT type="text/javascript" src="/modules/parallax/files/jquery-1.2.6.min.js"></SCRIPT>-->
<SCRIPT type="text/javascript" src="/modules/parallax/files/jquery.jparallax.js"></SCRIPT>
<SCRIPT type="text/javascript">
<!--
  var inPullNav = false;  
  jQuery(document).ready(function(){
  	jQuery('.grid_4 .parallax').jparallax({});
  });
//-->
</SCRIPT>
<!--[if lt IE 7]>
<script type="text/javascript" src="/modules/parallax/files/jquery.ifixpng.js"></script>
<script type="text/javascript">jQuery(document).ready(function(){ jQuery('img[@src$=.png]').ifixpng(); });</script>
<![endif]--><!--[if lt IE 8]>
<style type="text/css">
img.tr{right:-1px;}img.bl{bottom:-1px;}img.br{bottom:-1px;right:-1px;}
</style>
<![endif]-->
<? /* Использовать так

<SCRIPT type="text/javascript">
<!--
  var inPullNav = false;  
  jQuery(document).ready(function(){
  	jQuery('#parallax').jparallax({});
  });
//-->
</SCRIPT>
<DIV id="content">
    <DIV id="parallax">
        <DIV style="width: 860px; height: 273px;"><IMG style="left: 300px; top: -12px; position: absolute;" 
        alt="" src="/modules/parallax/example/files/0_sun.png"></DIV>
        <DIV style="width: 920px; height: 274px;"><IMG alt="" src="/modules/parallax/example/files/1_mountains.png"></DIV>
        <DIV style="width: 1100px; height: 284px;"><IMG style="left: 0px; top: 40px; position: absolute;" 
        alt="" src="/modules/parallax/example/files/2_hill.png"></DIV>
        <DIV style="width: 1360px; height: 320px;"><IMG style="left: 0px; top: 96px; position: absolute;" 
        alt="" src="/modules/parallax/example/files/3_wood.png"></DIV>
        </DIV>
</DIV>*/?>
<? } ?>