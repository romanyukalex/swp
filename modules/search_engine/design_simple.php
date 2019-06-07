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
<form action="/?page=search" method="get">
<div class="input">
  <input value="Поиск на сайте" name="q" class="field js-placeholder placeholder" title="Поиск на сайте" type="text">
  <a class="submit png" href="javascript:void(0)" onclick="$(this).closest('form').submit();"></a>
</div>
</form>
</div>
<? }?>