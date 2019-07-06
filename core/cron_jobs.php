<?/*********************************************************************************************************\
  * Snippet Name : start_platform_scripts           														* 
  * Scripted By  : RomanyukAlex		           																* 
  * Website      : http://popwebstudio.ru	   																* 
  * Email        : admin@popwebstudio.ru  					 												* 
  * License      : License on popwebstudio.ru from autor		 											*
  * Purpose 	 : Стартует сессию, инклюдит все необходимые проекту скрипты, делаются проверки на $block	*
  * Insert		 : include_once('start_platform_scripts.php');												*
  \*********************************************************************************************************/


gc_enable();
$now_hour = date('G');
$now_min=date('i');
$nitka=1;
$console_flag=1;
if(!$_SERVER['DOCUMENT_ROOT']){
$breakthisfile = Explode('/', $_SERVER['SCRIPT_NAME']);
unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем /core
$_SERVER['DOCUMENT_ROOT']=implode('/', $breakthisfile); // Домашняя директория всего сайта
}
$current.=$_SERVER['DOCUMENT_ROOT'];
$debug_file = '/home/a/aromanuq/popwebstudio/public_html/people.txt';

$projectcsv=$_SERVER['DOCUMENT_ROOT'].'/project/projectdb.csv';
# Парсим DB проектов
$projectcsvlineid=0; # Чтобы не брать шапошную строчку
if (($projectcsvfh = fopen($projectcsv, "r")) !== FALSE) {
 while($line = fgetcsv($projectcsvfh, 1000, '	')) {
	if($projectcsvlineid!==0){
		$cur_projectname=$line[1];
		if($cur_projectname!==$prev_projectname){#Новый проект
			# Записываем его в массив всех проектов
			if(!$projectexist[$cur_projectname])$projectexist[$cur_projectname]='1';
		}
	}
	$projectcsvlineid++;
}

//include($_SERVER['DOCUMENT_ROOT'].'/core/functions/KLogger.php');# Вкл логирование

# Запускаем общие crontab платформы
$cron_files = scandir($_SERVER['DOCUMENT_ROOT'].'/core/cron_tasks/');
foreach($cron_files as $cron_script){
	if($cron_script!=='.' and $cron_script!=='..') {
		echo '-------------------------
		START SCRIPT '.$cron_script.' ['.date("Y-m-d H:i:s").']
		
		';
		include($_SERVER['DOCUMENT_ROOT'].'/core/cron_tasks/'.$cron_script);
		
	}
}

# Находим проекты, в которых есть свой CRON-скрипт
foreach($projectexist as $projectname=>$value){
	echo '-------------------------
		Searching cron SCRIPTs for '.$projectname.' ['.date("Y-m-d H:i:s").']
		
		';
	if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php')) {
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');#Cистемные параметры этого проекта
	}
	include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
	

	# Находим в проекте модули с включенными CRON-скриптами
	
	if(is_array($module_cron_enabled)){
	
		foreach($module_cron_enabled as $modulename=>$enable){
			
			echo '
			Check cron SCRIPT for '.$modulename.' ['.$projectname.']';
			
			#Проверяем наличие кронскрипта
			if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/cron.php')) {#Есть кронскрипт, запускаем кронскрипт для данного модуля
				
				echo "
				Cron is enabled for the module ".$modulename.". Module cron script is found";
				$log->LogInfo("Cron is enabled for the module ".$modulename.". Module cron script is found");
				include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/cron.php');
				echo "
				Cron included succ";
			} else $log->LogInfo("Cron is enabled for the module ".$modulename.", but module cron script is not found");

		}
	}
	echo "
	CHECKING PROJECT-CRON";
	# Проверяем, есть ли у проекта крон файл
	if(is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/project-cron.php')) {
		$cron_project[$projectname]=1;//Его надо кронить
		#кроним
		$base_memory_usage = memory_get_usage(); # Определяем, сколько было скушано памяти в начале
		
		
		if($cronscriptenable=="Включено"){#Кроним
			echo "
			CRON script is enabled for the project";
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/project-cron.php');
			echo "
			Cron script included succ";
		}
		$log->LogDebug('MemUsage (after all) '.(memory_get_usage()-$base_memory_usage).'. Memory peak was '.memory_get_peak_usage().'.');
		unset($install_swp,$databasename,$dbadmin_login,$dbadmin_pass,$tableprefix,$fullpath,$logfile,$ap_logfile,$PHP_errors_log,$mode,$serverid,$log,$base_memory_usage);
		//while($paramdata=mysql_fetch_array($paramdatas)){ - уничтожить переменные проекта
		
	} else echo "
		Project has no project script";
	
	
	unset($module_cron_enabled,$moduleenabled,$log,$cron_logfile);
}



# Кроним
//include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
//@include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/project-cron.php';
//unset($install_swp,$databasename,$dbadmin_login,$dbadmin_pass,$tableprefix,$fullpath,$logfile,$ap_logfile,$PHP_errors_log,$mode,$serverid,$log);
//while($paramdata=mysql_fetch_array($paramdatas)){ - уничтожить переменные проекта





# Что то вывести (debug на Beget)
	file_put_contents($debug_file, $current);


}
?>