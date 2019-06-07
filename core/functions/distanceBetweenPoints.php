<?php
 /***************************************************************************************************************
  * Snippet Name : distanceBetweenPoints		      			 												*
  * Scripted By  : other	           					 		 												*
  * Website      : http://popwebstudio.ru	   					 												*
  * Email        : admin@popwebstudio.ru     																	*
  * License      : GPL (General Public License)					 												* 
  * Purpose 	 : Расстояние между 2 координатами				 												*
  * Access		 : 																								*
  *	$point1 = array('lat' => 40.770623, 'long' => -73.964367);													*
  * $point2 = array('lat' => 40.758224, 'long' => -73.917404);													*
  * $distance = getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);	*
  * foreach ($distance as $unit => $value) {echo $unit.': '.number_format($value,4).'<br />';}					*
  **************************************************************************************************************/
$log->LogInfo('Got this file');
function distanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('miles','feet','yards','kilometers','meters'); 
}?>