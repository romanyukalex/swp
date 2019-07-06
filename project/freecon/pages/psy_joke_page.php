<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){

$joke_id=process_data($_REQUEST['jid'],10);

#Запрос данных в БД
$items_info_q=mysql_query("SELECT * FROM `$tableprefix-jokes` WHERE  `joke_id`='$joke_id';");

if(mysql_num_rows($items_info_q)>0) $log->LogInfo('Got '.mysql_num_rows($items_info_q).' rows');
else $log->LogError('No rows found in query');
?>
<div class="row vp_block_row" style="padding-right:0px; font-size:26px;">
<? 
$items_info=mysql_fetch_array($items_info_q);
?>
	<div class="col-md-12 vp_block">
		<?
		$items_info['text']=str_replace("\n","<br>",$items_info['text']);
		
		echo $items_info['text']; 
		
	
	?>
	</div>
	<div class="col-md-12">
<?	#Выводим комментарии
		include ($_SERVER['DOCUMENT_ROOT'].'/commenton/index.php');?>
	</div>
</div>
<? }