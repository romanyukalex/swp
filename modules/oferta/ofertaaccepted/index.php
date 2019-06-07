<? 
session_start();
@require($_SERVER["DOCUMENT_ROOT"]."/userlogin6.php");
if ($userrole!=="guest" and $userrole)
	{ # пишем подтверждение оферты в БД
	@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
	$offertaexist=mysql_query("INSERT INTO `offertatable` (`login`, `date`) VALUES ('$login', CURRENT_TIMESTAMP);");
	$_SESSION['hideoferta']=1; // Чтобы в следующем клике не было оферты
?>
<span style="color:green">Договор оферты подтвержден</span>
<?	}?>