<? # Определяет какой шаблон сайта запрашивает пользователь
$log->LogInfo('Got this file');

if ($_SESSION['template'] and !$_REQUEST['template'] and !$adminpanel) {
	$sitetemplate=$_SESSION['template'];
	$site_company_id=$_SESSION['site_company_id'];
	$log->LogDebug('Sitetemplate is from $ SESSION - '.$sitetemplate);
} else {
	
	if ($_REQUEST['template']){ //Вставили template в URI
		if (set('ch_template')=='Разрешить') { //Админ разрешил вставку template в URI
			insert_function('process_user_data');
			$sitetemplate_r=process_data($_REQUEST['template'],20);
			
			$templ_data_q=mysql_query("SELECT * FROM `$tableprefix-templates_manager` where `template`='$sitetemplate_r' and `onoff`='on'");
			if(mysql_num_rows($templ_data_q)>0){# Найден
				$templ_data=mysql_fetch_array($templ_data_q);
				$sitetemplate=$templ_data['template'];
				$templatepage=$templ_data['mainpage'];
				$site_company_id=$templ_data['company_id'];
				$log->LogDebug('Sitetemplate has found in DB with data from $ REQUEST - '.$sitetemplate.' (page='.$templatepage.' / company_id='.$site_company_id);
			} else {# Не найден шаблон
				$sitetemplate=$currenttemplate;
				$log->LogDebug('Sitetemplate has not found with data from $ REQUEST. Template is default - '.$sitetemplate);
			}
			
			$_SESSION['template']=$sitetemplate;
		
		}
	
	} 
	if(!$_SESSION['template']){ //Значит все еще не найден шаблон. Ищем в БД
	
		$templ_data_q=mysql_query("SELECT * FROM `$tableprefix-templates_manager` where `domain`='$_SERVER[HTTP_HOST]' and  `onoff`='on'");

		if(mysql_num_rows($templ_data_q)>0){# "Найден"
			$log->LogDebug('Sitetemplate has found in DB');
			$templ_data=mysql_fetch_array($templ_data_q);
			$sitetemplate=$templ_data['template'];
			$templatepage=$templ_data['mainpage'];
			$site_company_id=$templ_data['company_id'];
			$_SESSION['template']=$sitetemplate;
			$_SESSION['templatepage']=$templatepage;
			$_SESSION['site_company_id']=$site_company_id;
		} else {# "Не найден!"
			$sitetemplate=$currenttemplate;
			$log->LogDebug('Sitetemplate has not found. Template is default - '.$sitetemplate);
		}
	}
}
unset($templ_data_q);

if($templatepage) $log->LogDebug('Template page is '.$templatepage);
else $log->LogDebug('Template page is not found');

if(!is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/body.php')){
	echo sitemessage('system','template_body_has_no_found');
	$log->LogDebug('Template body has not found');
}
if(!is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/doctype.php')){
	echo sitemessage('system','template_doctype_has_no_found');
	$log->LogDebug('Template doctype has not found');
}
if(!is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/'.$sitetemplate.'/scripts_and_styles.php')){
	echo sitemessage('system','template_scripts_has_no_found');
	$log->LogDebug('Template sctipts have not found');
}
?>