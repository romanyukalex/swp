<? 
$log->LogInfo('Got this file');
# Определяем $ampreq из GET['amp_page']
if($_REQUEST['AMP']){$ampreq=1;$log->LogDebug('This is request for amp page');}
?>