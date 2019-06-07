<?php
 /***********************************************************************************
  * Snippet Name : SxGeo_locatebyip           					 					*
  * Scripted By  : RomanyukAlex		           					 					*
  * Website      : http://popwebstudio.ru	   					 					*
  * Email        : admin@popwebstudio.ru     					 					*
  * License      : GPL (General Public License)					 					*
  * Purpose 	 : Get city or Country by IP address			 					*
  * Access		 : $cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);	*
  **********************************************************************************/

if ($nitka=="1"){
if(!$param[2]) global $ip;
else $ip=$param[2];
global $fullpath,$language,$log;

$log->LogDebug("Got this file");

#$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);
#$country = $SxGeo->getCountry($ip)
#$SxGeo->getCountryId($ip);
#$SxGeo->getCity($ip);
#$SxGeo->getCityFull($ip);
#$city = $SxGeo->get($ip);

// Создаем объект
include("SxGeo.php");
// Первый параметр - имя файла с базой (используется оригинальная бинарная база SxGeo.dat)
// Второй параметр - режим работы: 
//     SXGEO_FILE   (работа с файлом базы, режим по умолчанию); 
//     SXGEO_BATCH (пакетная обработка, увеличивает скорость при обработке множества IP за раз)
//     SXGEO_MEMORY (кэширование БД в памяти, еще увеличивает скорость пакетной обработки, но требует больше памяти)

$SxGeo = new SxGeo($fullpath.'modules/'.$modulename.'/SxGeoCity.dat');
//$SxGeo = new SxGeo('SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY); // Самый производительный режим, если нужно обработать много IP за раз

#var_export($SxGeo->getCityFull($ip)); // Вся информация о городе
#var_export($SxGeo->get($ip));         // Краткая информация о городе или код страны (если используется база SxGeo Country)
#var_export($SxGeo->about());          // Информация о базе данных
$citydata=$SxGeo->getCityFull($ip);

if($param[1]=="getCityName"){
	$log->LogDebug("Return city name - ".$citydata['city']['name_'.$language]);
	return $citydata['city']['name_'.$language];
}
elseif($param[1]=="getCountryName"){
	$log->LogDebug("Return country name - ".$citydata['country']['name_'.$language]);
	return $citydata['country']['name_'.$language];
}

}?>