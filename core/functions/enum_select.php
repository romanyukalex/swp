<? # Функции для вывода списка возможных значений ENUM-поля в таблице
$log->LogInfo('Got this file');
function enum_select( $table , $field ){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	$query = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
	$result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() );
	$row = mysql_fetch_array( $result , MYSQL_NUM );
	$regex = "/'(.*?)'/";
	preg_match_all( $regex , $row[1], $enum_array );
	$enum_fields = $enum_array[1];
	return( $enum_fields );
}
/* Example
insert_function("enum_select");
$fbos=enum_select("$tableprefix-companies",'form_of_business_ownership');
foreach($fbos as $fboskey=>$fbosvalue){
	?><option value="<?=$fbosvalue?>"><?=$fbosvalue?></option><?
}
*/