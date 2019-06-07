<?php
 /****************************************************************
  * Snippet Name : module template           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : include									 	 *
  ***************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){  
	?>
	<link rel="stylesheet" type="text/css" href="/modules/typography_effect/files/style.css" />
	<script type="text/javascript" src="/modules/typography_effect/files/lettering.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#panel h1 a").lettering();
		});
	</script>
<? } ?>