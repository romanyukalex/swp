<?php
 /****************************************************************
  * Snippet Name : module template           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some functions								 *
  * Access		 : insert_module("bookmark")				 	 *
  ***************************************************************/
$log->LogInfo("Got ".(__FILE__));
  if($nitka=="1"){
/*
  <a href="javascript:void(0)" onClick="return BookmarkApp.addBookmark(this)" title="Добавить в избранное"><img src="/files/favorites.png" height="40" border="0"/></a>
*/
?>
<script type="text/javascript" src="/modules/bookmark/ATBookmarkApp.js"></script>
<? } ?>