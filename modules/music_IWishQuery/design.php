<?php
 /***************************************************************************************
  * Snippet Name : IWishQuery plugin           					 						*
  * Scripted By  : RomanyukAlex		           					 						*
  * Website      : http://popwebstudio.ru	   					 						*
  * Email        : admin@popwebstudio.ru     					 						*
  * License      : GPL (General Public License)					 						*
  * Purpose 	 : some functions								 						*
  * Access		 : include this script, 												*
  *			insert_module("","/project/<?=$projectname?>/files/file","autoplay loop controls","0.5")	*
  *				(last is volume)	(WITHOUT .MP3)										*
  **************************************************************************************/
$log->LogInfo('Got '.(__FILE__));
if ($nitka=="1"){
	if(strstr($param[2],"autoplay")){
		$autoplay=1;
	}
	if(strstr($param[2],"controls")){
		$controls=1;
	}
	if(strstr($param[2],"loop")){
		$loop=1;
	}
?>
<!--script src="http://code.jquery.com/jquery-1.5rc1.js"></script-->
	<audio id="myaudio" <?if($controls){?>controls<?}?>></audio>
	<script src="/modules/<?=$modulename?>/jquery.iwish.js"></script>
	<script>
$(document).ready(function () {
	// Call the function with the filename to_i-wish and autoPlay to either true or false
	$("#myaudio").iWish({audioSource: "<?=$param[1]?>",  <?if($autoplay){?>autoPlay:true<?}?>});
	var audio = document.getElementById("myaudio");
	<? 
	if($param[3]){?>audio.volume = <?=$param[3]?>;<?}?>
	audio.preload=true;
	<?if($autoplay){?>$("#myaudio").attr("autoplay",true);<?}
	if($loop){?>$("#myaudio").attr("loop",true);<?}?>
});
	$("#myaudio").iWish({audioSource: "<?=$param[1]?>",<?if($autoplay){?>autoPlay:true<?}?>});
	var audio = document.getElementById("myaudio");
	<? 
	if($param[3]){?>
	audio.volume = <?=$param[3]?>;
	
	<?}?>
	audio.preload=true;
	<?if($autoplay){?>$("#myaudio").attr("autoplay",true);<?}
	if($loop){?>$("#myaudio").attr("loop",true);<?}?>
</script>

<? }?>