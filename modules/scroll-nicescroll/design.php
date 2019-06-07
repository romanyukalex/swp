<?php
 /***********************************************************************
  * Snippet Name : module template           					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some functions								 		*
  * Access		 :  insert_module("scroll-nicescroll","html","#000")	*
  **********************************************************************/
$log->LogInfo('Got '.(__FILE__));
if ($nitka=="1"){
?>
<script src="/modules/<?=$modulename?>/jquery.nicescroll.3.6.8.js"></script>
<script>

$(document).ready(
  function() { 
    $('<?=$param[1]?>').niceScroll(<?if($param[2]){?>{cursorcolor:"<?=$param[2]?>"}<?}?>);
  }
);
</script>
<? }?>