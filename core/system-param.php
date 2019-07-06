<? # Создаёт переменные для сайта, выгружая данные о них из БД

include($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");

if(!$bot_name){ // Это не бот, берем конфиг портала из БД
	
	if(!$_SESSION['paramdatas']) $_SESSION['paramdatas']=mysql_query('SELECT `value`,`systemparamname`,`company_id` FROM `'.$tableprefix.'-siteconfig` WHERE `module_id` is null;');//Кроме модульных настроек/ ДОБАВИТЬ В WHERE `depend`='always'

	
	while($paramdata=mysql_fetch_array($_SESSION['paramdatas'])){
		$$paramdata['systemparamname'] = null;
		if(!$$paramdata['systemparamname'] or ($paramdata['company_id']!=='NULL' and $paramdata['company_id']!=='')) {
			$$paramdata['systemparamname'] = $paramdata['value'];
			$_SESSION['param'][$paramdata['systemparamname']]=$paramdata['value'];
		}
	}

	unset($paramdata);
	
} else {// Это бот, Берем конфиг сайта из файла->снизить нагрузку на БД при скан-нии портала ботами
	include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/bots_systemparams.php'); 
}

function set($paramname){

	if(!$_SESSION['param'][$paramname]) {//Параметр еще не доставали, редкий или для определенных случаев или страниц
		$tempq=mysql_fetch_assoc( mysql_query('SELECT `value` FROM `'.$tableprefix.'-siteconfig` WHERE `systemparamname`="'.$paramname.'";'));
		if ($tempq['value']) $_SESSION['param'][$paramname]=$tempq['value'];
		else return FALSE;
		unset($tempq);
	}
	
	return $_SESSION['param'][$paramname];
}

?>