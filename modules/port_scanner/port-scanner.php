<? $lport = 8080;
$hport = 8082;
$host="193.169.4.183";
?>
<html>
<head><title>PORTSCANNER</title></head>
<body>

<?
for ( $port=$lport; $port<=$hport; $port++ )
	{
	$fp = fsockopen( "$host", $port, &$errno, &$errstr, 4 );
	
	if ( !$fp )
		{
		 echo "Port $port seems to be closed/filtered:nDesc: $errstr<br>";
		}
	else
		{
		
		echo "<strong>Port $port /seems open...</strong><br>";
		fclose($fp);
		}
	
	}


?>
</body>
</html>