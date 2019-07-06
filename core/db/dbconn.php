<? // connect to mysql
//$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
require_once($_SERVER['DOCUMENT_ROOT']."/project/".$projectname."/config.php");
//if(isset($dbconnreadconnect)){mysql_close($dbconnreadconnect);}
$dbconnconnect=mysql_pconnect('localhost',$dbadmin_login,$dbadmin_pass) or die("Could not connect by bdadmin: ".mysql_error());
//@mysql_query('CREATE DATABASE $databasename');
mysql_select_db($databasename,$dbconnconnect);
//mysql_select_db($databasename) or die("Could not select database $databasename: ".mysql_error());
mysql_query("SET NAMES `utf8`") or die(sysmass('Error in database code.')); 
mysql_query("SET @@global.query_cache_size=32*1024*1024;");
#Включим отладчик запросов в mysql
mysql_query("set profiling_history_size=100");
mysql_query("set profiling=1");
?>
