<?php
 /****************************************************************
  * Snippet Name : module template (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some ajax functions							 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){
	include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
	if($_REQUEST['action']=="get_cities_of_country"){
	
		include($_SERVER["DOCUMENT_ROOT"]."/core/IPreal.php");
		$log->LogDebug("IP is ".$ip);
		
		$cityName=insert_module("SxGeo_locatebyip","getCityName",$ip);
		
		$citiesreq=mysql_query("select * from `$moduletableprefix-cities` where `id_country`='$_REQUEST[someid1]' ORDER BY `city_name_$language` ASC");
		while ($cities=mysql_fetch_array($citiesreq)){
		?><option value="<?=$cities['id']?>"<? 
			if($cities['city_name_'.$language]==$cityName) echo " selected";
		?>><?=$cities['city_name_'.$language]?></option>
	<?	$log->LogDebug("CITY ".$cities['city_name_'.$language]. ' and mantch with '.$cityName);
	
		}
	}
} ?>