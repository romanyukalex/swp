<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel:users-management.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : 											 					 *
  * Insert		 : 														 *
  ***************************************************************************************************************************/ 

if(($userrole=="admin" or $userrole=="root") and $adminpanel==1){?>
	СТАТИСТИКА<br>
	<? insert_function("getYandexTIC");
	insert_function("getGoogleSiteRank");
	$gpr = new GooglePR();
?><?

	$templates_q=mysql_query("SELECT * FROM `$tableprefix-templates_manager` WHERE 1;");
	while($templates_info=mysql_fetch_array($templates_q)){
		$tcy = getYandexTIC('https://'.$templates_info['domain']);
		$grank=getGoogleSiteRank('https://'.$templates_info['domain']);
		$pagerank = $gpr->getPagerank('https://'.$templates_info['domain']);
		$log->LogDebug('Yandex TIC is '.$tcy.' Google Rank is '.$grank);
		echo $templates_info['domain']." Яндекс. ТИЦ: ".$tcy.' Google Rank: '.$grank.$pagerank ;
		?>
		<script type="text/javascript">!function(e,t,r){e.PrcyCounterObject=r,e[r]=e[r]||function(){(e[r].q=e[r].q||[]).push(arguments)};var c=document.createElement("script");c.type="text/javascript",c.async=1,c.src=t;var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(c,n)}(window,"//a.pr-cy.ru/assets/js/counter.min.js","prcyCounter"),prcyCounter("<?=$templates_info['domain']?>","prcyru-counter_<?=$templates_info['domain']?>",0);</script>
		<div id="prcyru-counter_<?=$templates_info['domain']?>"></div><noscript><a href="//a.pr-cy.ru/<?=$templates_info['domain']?>" target="_blank"><img src="//a.pr-cy.ru/assets/img/analysis-counter.png" width="88" height="31" alt="Analysis"></a></noscript>
		<br><?
	}
	?><hr><?
	$clientStats=mysqli_get_client_stats();
	foreach($clientStats as $statParam=>$statValue){
		echo $statParam.' = '.$statValue."<br>";
	}
	?><hr><?
	$connStats=mysqli_get_connection_stats($dbconnconnect);
	foreach($connStats as $statParam=>$statValue){
		echo $statParam.' = '.$statValue."<br>";
	}
	
}?><br><br><br><br><br><br>