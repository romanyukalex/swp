<? # Определяем сезон
$log->LogInfo('Got this file');
function getSeason() {
	global $log;
	$seasons = array(0 => 'winter', 1 => 'spring', 2 => 'summer', 3 => 'autumn');
	$log->LogDebug("Season is ".$seasons[floor(date('n') / 3) % 4]);
	return $seasons[floor(date('n') / 3) % 4];
}
//$season=getSeason();