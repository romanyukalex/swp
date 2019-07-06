<? # Создаёт переменные для модуля, выгружая данные о них из БД

if(!$bot_name){ // Это не бот, берем конфиг портала из БД
	
	if($param[0]) $modulename=$param[0];
	elseif($pagequery['module_page']) $modulename=$pagequery['module_page'];
	$log->LogDebug('Got file for '.$modulename.'. queried ='.$module_params_quered[$modulename]);
	
	
	$paramdatas=mysql_query('SELECT `value`,`systemparamname`,`company_id` FROM `'.$tableprefix.'-siteconfig` sc,`'.$tableprefix.'-modulesregister` modreg WHERE modreg.`module_id`=sc.`module_id` AND modreg.`modulename`="'.$modulename.'";');
	
	if(mysql_num_rows($paramdatas)>0){
		while($paramdata=mysql_fetch_array($paramdatas)){
			$$paramdata['systemparamname'] = null;
			if(!$$paramdata['systemparamname'] or ($paramdata['company_id']!=='NULL' and $paramdata['company_id']!=='')) {
				$$paramdata['systemparamname'] = $paramdata['value'];
				$log->LogDebug('Next system params was got from DB:'.$paramdata['systemparamname'].' equal '.$$paramdata['systemparamname']);
			}
		}
		
	} else $log->LogDebug('No module ('.$modulename.') system param');
	unset($paramdatas);
	$module_params_quered[$modulename]=1; //Флаг, что не нужно запрашивать данные модуля заново
	
	
}
?>