<?php
 /*******************************************************************************
  * Snippet Name : ping and monitor daemon which is controlled whole mon system	*
  * Scripted By  : RomanyukAlex		           					 				*
  * Website      : http://popwebstudio.ru	   					 				*
  * Email        : admin@popwebstudio.ru     					 				*
  * License      : GPL (General Public License)					 				*
  * Purpose 	 : some functions								 				*
  * Access		 : start this script 											*
  *  php /site_path/modules/ping_and_portmon/start-daemon.php project 			*
  ******************************************************************************/


#Проверяем, подключен ли  pcntl
if (extension_loaded('pcntl')){

	$nitka=1;

	echo "Start monitor machine \n";
	$breakthisfile = Explode('/', $_SERVER["SCRIPT_NAME"]);
	unset ($breakthisfile[count($breakthisfile)-1]); //Удалили название скрипта
	$this_path=implode('/', $breakthisfile); 
	if($breakthisfile[count($breakthisfile)-1]!=="modules")unset ($breakthisfile[count($breakthisfile)-1]); //Мы все еще в глубине файловой системы, удаляем папку с модулем
	unset ($breakthisfile[count($breakthisfile)-1]); //Удаляем /modules
	$_SERVER["DOCUMENT_ROOT"]=implode('/', $breakthisfile); // Домашняя директория всего сайта
	
	require($_SERVER["DOCUMENT_ROOT"]."/core/start_platform_scripts_cron.php");
	
	require($this_path."/config.php");//Конфиг модуля
	

	$pid = pcntl_fork();
	if ($pid == -1) {
		// Ошибка 
		
		die('could not fork'.PHP_EOL);
		
	//} else if ($pid) {
		// Родительский процесс, убиваем
		
	//	die('die parent process'.PHP_EOL);
	} else {
		// Новый процесс, запускаем главный цикл

		
		$nodes_q=mysql_query("SELECT * FROM `$tableprefix-monitor-nodes` WHERE `mon_status`='active';");//Узлы для мониторинга
		

//		while(TRUE){
			
			
			while ($nodes_info=mysql_fetch_array($nodes_q)){
				# Проверяем, жив ли процесс, мониторящий этот нод
				//echo $nodes_info['node_id'];
		//		$pidinfo=getpidinfo($worker_processes[$nodes_info['node_id']]); 
				if(!$pidinfo['COMMAND']){# Процесс не найден, запускаем мониторинг нода исходя из его типа (ping/dns_check) в отдельном дочернем процессе через cmd
				
				
					if (!$nodes_info['port']){$nodes_info['port']=0;}
					//На вход подаем: project, ip_addr, port, mon_type, mon_period
					system("php ".$this_path."/monitor_worker.php ".$projectname." ".$nodes_info['ipaddr']." ".$nodes_info['port']." ".$nodes_info['mon_type']." ".$nodes_info['mon_period'],$sys_return);
					//echo $sys_return;
					//echo "!!php ".$this_path."/monitor_worker.php ".$projectname." ".$nodes_info['ipaddr']." ".$nodes_info['port']." ".$nodes_info['mon_type']." ".$nodes_info['mon_period'];
					/*
					#Получаем PID нового процесса
					sleep(2);
					//$uniq_token=$nodes_info['ip_addr'].$nodes_info['port'].$nodes_info['mon_type'].$nodes_info['mon_period'];
					$id = ftok(__DIR__ . '/monitor_worker.php', 'A');
					$shmId = shm_attach($id);
					$var = 1;

					// Смотрим, есть ли у нас требуемая переменная
					if (shm_has_var($shmId, $var) and $worker_processes[$nodes_info['node_id']]!== (array)shm_get_var($shmId, $var)) {// Данные в памяти есть и они не равны старому PID
						$worker_processes[$nodes_info['node_id']] =(array)shm_get_var($shmId, $var);
						$log->LogDebug(basename (__FILE__)." | The new process for node ".$nodes_info['node_id']." was successfully created with PID ".$worker_processes[$nodes_info['node_id']]);
					} else {
						// не удалось создать рабочий процесс
						$log->LogDebug(basename (__FILE__)." | Can't create a process for node ".$nodes_info['node_id']);
					}
					
					# Пишем все мониторимые Pid в shared memory для управления ими извне
					$id = ftok(__FILE__, 'A');
					$shmId = shm_attach($id);
					$pid_data=json_encode($worker_processes);
					shm_put_var($shmId, 1, $pid_data);*/
				}
			}
			mysql_data_seek($nodes_q, 0);
			
			sleep ($mon_check_period);
		//}
	}
} else {# Модуль pcntl не подключен - завершаем вызов с соотв сообщением
	echo "Please, install pcntl module via 'sudo yum install php php-cli' command";
}

$log->LogInfo($modulename."/cron | End of script -------------------");
		
 ?>