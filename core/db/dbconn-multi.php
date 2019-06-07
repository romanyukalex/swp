<? // connect to mysql
//$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));

$jk=1;
$aa = getdate();
foreach ($dbconndata as $hostname => $logindata)
	{
	$logindata1 = explode("/",$logindata);$username=$logindata1[0];$password=$logindata1[1];
	
	$dbh[$jk]=mysql_connect($hostname,$username,$password);

	$dbsel[$jk]=mysql_select_db($databasename,$dbh[$jk]);
	mysql_query("SET NAMES `utf8`");
	if ($dbh[$jk]){
		if ($dbsel[$jk])
			{
			echo "connected and selected ok to db $hostname \n";
			}
		else
			{$logphrase=" $hostname - connected ,but db select failed ".mysql_error()."\r\n";
			
			#Запись в лог
			//$log->LogInfo(basename (__FILE__)." | $logphrase ");
			if ($dbfailbehav=="stop") die();
			}
		}
	else
		{
		$logphrase=" Failed to connect to server $hostname \n".mysql_error()."\r\n";
		echo $logphrase;
		#Запись в лог
		//$log->LogInfo(basename (__FILE__)." | $logphrase ");
		if ($dbfailbehav=="stop") die();
		}
	$jk++;
	}?>