<?php
 /***********************************************************************************
  * Snippet Name : IWishQuery plugin           					 					*
  * Scripted By  : RomanyukAlex		           					 					*
  * Website      : http://popwebstudio.ru	   					 					*
  * Email        : admin@popwebstudio.ru     					 					*
  * License      : GPL (General Public License)					 					*
  * Purpose 	 : some functions								 					*
  * Access		 : include this script, 											*
  *			insert_module("","/project/<?=$projectname?>/files/file","autoplay")	*
  *							(WITHOUT .MP3)											*
  **********************************************************************************/
$log->LogInfo('Got '.(__FILE__));
if ($nitka=="1"){
?>
<script src="http://code.jquery.com/jquery-1.5rc1.js"></script>
	<audio controls></audio>
	<script src="/modules/<?=$modulename?>/jquery.iwish.js"></script>
	<script>
$(document).ready(function () {
	// Call the function with the filename skee-lo_i-wish and autoPlay to either true or false
	$("audio").iWish({audioSource: "<?=$param[1]?>", autoPlay: <?if($param[2]=="autoplay"){?>true<?} else{?>false<?}?>});
});
	$("audio").iWish({audioSource: "<?=$param[1]?>", autoPlay: <?if($param[2]=="autoplay"){?>true<?} else{?>false<?}?>});

</script>

<? }?>