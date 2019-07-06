<? # Создаёт переменные для сайта, выгружая данные о них из БД

include($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
	
$paramdatas=mysql_query('SELECT `value`,`systemparamname`,`company_id` FROM `'.$tableprefix.'-siteconfig` WHERE 1;');//Кроме модульных настроек/ ДОБАВИТЬ В WHERE `depend`='always'


while($paramdata=mysql_fetch_array($paramdatas)){
	$$paramdata['systemparamname'] = null;
	if(!$$paramdata['systemparamname'] or ($paramdata['company_id']!=='NULL' and $paramdata['company_id']!=='')) {
		$$paramdata['systemparamname'] = $paramdata['value'];
		$_SESSION['param'][$paramdata['systemparamname']]=$paramdata['value'];
	}
}

unset($paramdata);


//function set($paramname){
//echo "!";
//}
?>