<? # Функции получения региональных данных
$log->LogInfo('Got this file');
function get_all_country(){
	global $tableprefix;
	return $country_data=mysql_query("select * from `$tableprefix-country` where 1");
}
function get_cities_by_country($country_id,$orderbyfield,$askdesc){
	global $tableprefix;
	return $citiesreq=mysql_query("select * from `$tableprefix-cities` where `id_country`='$country_id' ORDER BY $orderbyfield $askdesc");
}
/*
insert_function("region_data");
#THEN get_all_country:
$allcountryreq=get_all_country();
while($allcountry=mysql_fetch_array($allcountryreq)){
?><option value="<?=$allcountry['id']?>"><? if($allcountry['country_name_ru']){echo $allcountry['country_name_ru'];} else $allcountry['country_name_en'] ?></option><?
}
# OR get_cities_by_country:
$citiesreq=get_cities_by_country($country_id,'`city_name_$lang`','ASC');
	while ($cities=mysql_fetch_array($citiesreq)){
	?><option value="<?=$cities['id']?>"<? if($cities['id']=="1") echo " selected";?>><?=$cities['city_name_ru']?></option>
<?}
*/