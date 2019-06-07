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
/*<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>*/?>
<link href="/modules/tips-juis/juizLinkinTips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/modules/tips-juis/juizLinkinTips.min.js"></script>
<script type="text/javascript">
	/*<![CDATA[*/
	$(document).ready(function() {
		$(".withtip[title]").juizLinkinTips();	
	});
	/*]]>*/
</script>

<? } ?>