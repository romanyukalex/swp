<?php
 /****************************************************************
  * Snippet Name : arcticmodal		          					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : insert_module("arcticmodal");			 	 *
  ***************************************************************/
$log->LogInfo('Got this file');
if ($nitka=='1'){  
?>
<!-- add easing jquery plugin if you want to use easing option -->
<script src="/js/easing1.3" type="text/javascript"></script>
<script src="/modules/modal-moaModal/src/moaModal.js" type="text/javascript"></script>
<!-- triggering element -->
<button class="viewModal">Click Me</button>
 
<!-- modal element -->
<div id="modal" style="display:none;width:50%;...">
Your Modal Content with your own styles
</div>
<script>
$(function(){
$('.viewModal').modal({
target : '#modal',
animation : 'top',
position : 'center'
});
});
</script>



<? } ?>