<?php
 /***************************************************************************
  * Snippet Name : all_pages_link           					 			*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : all pages of the site						 			*
  * Access		 : include this script										*
  **************************************************************************/

if ($nitka=="1"){
	?><div id="<?=$modulename?>_div"><?
	global $language;
	$pages_data_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `showin_all_pages_page`=TRUE");
	while($pages_data=mysql_fetch_array($pages_data_q)){?>
	<a href="/?page=<?=$pages_data['page']?>"><?=$pages_data['pagetitle_'.$language]?></a><br>
	<?}?></div><?
}?>