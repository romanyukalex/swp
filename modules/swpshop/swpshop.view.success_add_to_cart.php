<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
?><div><?if($return_data=="OK") echo $sitemessage['swpshop']['order_succ'];
else echo $sitemessage['swpshop']['variant_isnt_found'];?>
</div>
<? }//nitka?>