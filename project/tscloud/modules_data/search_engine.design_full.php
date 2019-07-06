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

if ($nitka=="1"){
?>
<div class="item search">
<form action="/?page=search" method="post" class="b-search_inline" id="search_form">
<div class="input-wrap">

	<select name="srchcat"><option value="0"><? if($language=="ru"){ ?>Во всех категориях<?} elseif($language=="en"){?>All<?}?></option>
	<? //$categoriesqry=mysql_query("SELECT * FROM `$moduletableprefix-$modulename-categories` cat,`$moduletableprefix-$modulename-places` pl
	//WHERE cat.`cat_id`=pl.`cat_id`"); 
	$categoriesqry=mysql_query("SELECT * FROM `$moduletableprefix-$modulename-categories` WHERE 1;");
		while($categoryinfo=mysql_fetch_array($categoriesqry)){?>
		<option value="<?=$categoryinfo['cat_id']?>"><?=$categoryinfo['category_name_'.$language]?></option>
		<?}
	?>
	</select>

<? /*<a onclick="saveform1('','search_form','search_results','<?=$modulename?>');return false;" href="javascript:void(0)" class="icon"></a>*/?>
<a onclick="saveform2('','search_form','search_results','<?=$modulename?>','searchsome','','');return false;" href="javascript:void(0)" class="icon"></a>

<input type="text" value="" size="80" name="q" autofocus>

 </div>
 </form>
</div>
<div id="search_results">

</div>
<? }?>