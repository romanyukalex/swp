<? $log->LogInfo('Got '.(__FILE__)); 
if($nitka=='1'){
if($userrole and $userrole!=='guest'){
	if($userlistcount>0){
		while ($manageproduct=mysql_fetch_array($manageproductreq)){
			$managedproductgroups[$manageproduct['group_id']]=1; ?>
		<div class="b-other-projects b-text mb services_item">
			<div class="wrap">                 
			<h2>Продукт: <?=$productfulltitle[$manageproduct['oid']]?></h2>
			<div class="b-text_2col">
		<table>
		<tr><td><span id="<?=$manageproduct['oid']?>messageplace"> </span></td></tr>
		</table>
		<table id="useracesstable<?=$manageproduct['oid']?>">

		</table>

		<script>$(document).ready(function(){ajaxreq('<?=$manageproduct['oid']?>','','show_product_managem_users','useracesstable<?=$manageproduct['oid']?>','$modulename');})</script>

		</div></div></div>
	<? 	}
	} else echo $sitemessage[$modulename]['no_users_for_subcr_managemnt'];
}else{?><script>changerazdel("login");</script><?}
}//nitka