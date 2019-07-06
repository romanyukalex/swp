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
<form action="/?page=search_morph_page" method="post" id="<?=$modulename?>_form" onSubmit="submit_search();return false">
<div class="input">
  <input value="Поиск на сайте" name="q" class="field js-placeholder placeholder" title="Поиск на сайте" type="text">
  <a class="submit png <?=$modulename?>_search_button"></a>
</div>
</form>
</div>
<? }?>