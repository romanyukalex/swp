<? # Создаёт переменные для сайта, выгружая данные о них из БД

include($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");

if(!$bot_name){ // Это не бот, берем конфиг портала из БД
	$paramdatas=mysql_query('SELECT `value`,`systemparamname`,`company_id` FROM `'.$tableprefix.'-siteconfig` WHERE 1;');

	while($paramdata=mysql_fetch_array($paramdatas)){
		$$paramdata['systemparamname'] = null;
		if(!$$paramdata['systemparamname'] or ($paramdata['company_id']!=='NULL' and $paramdata['company_id']!=='')) {
			$$paramdata['systemparamname'] = $paramdata['value'];
		}
	}
} else {include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/bots_systemparams.php'); // Берем конфиг сайта из файла->снизить нагрузку на БД при скан-нии портала ботами
	//file_put_contents ( $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/log/bots_log.log' , $bot_name.' '.time()."\r\n");
}
?>