<?/***************************************************************************************************************************
  * Snippet Name : check_avail_modules           																			 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://magicsolutions.ru	   																				 * 
  * Email        : admin@magicsolutions.ru     					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Выбирает реестр подключенных модулей																		 *
  * Insert		 : include_once('check_avail_modules.php');																	 *
  ***************************************************************************************************************************/ 
$log->LogInfo('Got this file');
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/db/dbconn.php');
$avmodulesqry=mysql_query("SELECT * FROM `$tableprefix-modulesregister` WHERE 1 order by `module_id` asc;");//два поля - modulename и installed
if(mysql_num_rows($avmodulesqry) > '0'){
	
	while($avmodulesresult=mysql_fetch_array($avmodulesqry)){
		$moduleinstalled[$avmodulesresult['modulename']] = null;
		$moduleenabled[$avmodulesresult['modulename']]=null;
		$moduleinstalled[$avmodulesresult['modulename']]=$avmodulesresult['installed'];
		if($avmodulesresult['enabled']=='enabled') $moduleenabled[$avmodulesresult['modulename']]=$avmodulesresult['enabled'];
		if($avmodulesresult['cron']=='enabled') $module_cron_enabled[$avmodulesresult['modulename']]=$avmodulesresult['enabled'];
	}
	$log->LogDebug('Data about modules received: installed '.count($moduleinstalled).', enabled '.count($moduleenabled).', cron enabled for '.count( $module_cron_enabled));
} else $log->LogError('No modules available.');
mysql_data_seek($avmodulesqry, 0);?>
