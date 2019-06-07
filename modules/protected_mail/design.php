<?php
 /****************************************************************************************************
  * Snippet Name : protected_mail           					 									 * 
  * Scripted By  : RomanyukAlex		           					 									 * 
  * Website      : http://popwebstudio.ru	   					 									 * 
  * Email        : admin@popwebstudio.ru     					 									 * 
  * License      : GPL (General Public License)					 									 * 
  * Purpose 	 : some functions								 									 *
  * Access		 : insert_module("protected_mail","mail@domain.com","linktext","a_id") 	 			 *
  *					или так: insert_module("protected_mail","mail@domain.com","","a_id"), 			 *
  *					тогда текст ссылки не меняется													 *
  ***************************************************************************************************/

if ($nitka=="1"){
// На вход: емейл, id ссылки, класс ссылки
	$needed_mail=$param[1];
	$needed_text=$param[2];
	$needed_id=$param[3];
	$mailparts=explode("@",$needed_mail);
	$mailparts2=explode(".",$mailparts[1]);
	?>
<script>
$(document).ready(function(){
update_link_<?=$needed_id?>();
	
});
function update_link_<?=$needed_id?>(){

	var MN='<?=$mailparts[0]?>';
	var SN='<?=$mailparts2[0]?>';
	var SE='<?=$mailparts2[1]?>';
	var AT='@';
	var DOT='.';
	var emE=MN+AT+SN+DOT+SE;
	$('#<?=$needed_id?>').attr('href', 'mailto:'+emE);
	<? 
	if($needed_text){//текст ссылки надо менять
		if(substr_count($needed_text, '@')>0){//Возможно это повтор мейла
			$textparts=explode("@",$needed_text);?>
			var txt1='<?=$textparts[0]?>';
			var txt2='<?=$textparts[1]?>';
			var txtL=txt1+AT+txt2;
		<? }else{//ссылка есть, но в ней не было @?>
			var txtL='<?=$needed_text?>';
		<?}?>
	$('#<?=$needed_id?>').text(txtL);
	<? }?>
}
</script>
<?}?>