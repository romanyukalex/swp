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
<div class="b-search_results">
<p>Показаны результаты запроса: "<?=$search_text?>"</p><br>
<? foreach($result_weight as $result_id=>$result_weight){?>
<div class="result">
<? //div class="path"><a href="/">Техносерв</a>&nbsp;|&nbsp;<a href="/about/">О Техносерве</a>&nbsp;|&nbsp;<a href="/about/company/">О Техносерве</a>&nbsp;|&nbsp;<a href="/about/company/press/">Пресс-центр</a>&nbsp;|&nbsp;<a href="/about/company/press/articles/">Пресс-центр</a></div>?>
<div class="link">
		<a href="<?=$search_result_arr[$result_id]['url']?>"><?="[".$result_id."] ".$search_result_arr[$result_id]['title']?></a>
</div>

<div class="text">
	<?=$search_result_arr[$result_id]['shorttext']?>
</div>
</div>
<? }?>
</div>
<? }?>