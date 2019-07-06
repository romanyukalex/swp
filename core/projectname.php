<? # Определяем $projectname по домену
if($styleflag==1 or $ajaxflag==1 or $adminpanel==1 or $logoutflag==1 or $platscriptflag==1 or $sitemapflag==1){$projectcsvfh = fopen('../project/projectdb.csv', 'r');}
elseif($moduleflag==1){
	$projectcsvfh = fopen('../../project/projectdb.csv', 'r');
} else $projectcsvfh = fopen('project/projectdb.csv', 'r');
$projectcsvlineid=0;
 while($line = fgetcsv($projectcsvfh, 1000, '	')) {
	 if($projectcsvlineid!==0 and ($_SERVER['HTTP_HOST']==$line[0] or $_SERVER['HTTP_HOST']=='www.'.$line[0])){//Найден проект
		$projectname=$line[1];
	 }
	 $projectcsvlineid++; 
}
fclose($projectcsvfh);
unset($projectcsvfh,$projectcsvlineid);
if(!$projectname) {?><img src="/files/shoes/Shoe512_red.png" height="60px" style="vertical-align:middle">Domain name has been found on hosting, but platform can't locate the project by URI (<?=$_SERVER['HTTP_HOST']?>). Check projects.csv<?die();}

?>