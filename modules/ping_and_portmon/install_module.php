<?php
 /***************************************************************
  * Snippet Name : ping and portmon (install part)				* 
  * Scripted By  : RomanyukAlex		           					* 
  * Website      : http://popwebstudio.ru	   					* 
  * Email        : admin@popwebstudio.ru     					* 
  * License      : GPL (General Public License)					* 
  * Purpose 	 : installation of module						*
  * Access		 : insert_module("ping_and_portmon")	 	 	*
  ***************************************************************/
    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	# $module_id - id модуля
	
	
		$put_siteconfig=mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES
		(NULL, '10', 1, 'Период проверки жизни мониторингового процесса в сек', 'mon_check_period', NULL, NULL, 1, '10', 'system', 1, $module_id),		
		(NULL, '10', '1', 'Жёлтая зона для отображения падения узла (в минутах)', 'yellow_zone_time', NULL, NULL, '1', NULL, 'user', '1', $module_id),
		(NULL, NULL, '1', 'Скрипт, исполняемый после проведения мониторинга узлов (CRON)', 'scr_aft_mon', NULL, NULL, '1', NULL, 'system', '1', NULL);")

		
		$put_table_structure=mysql_query("CREATE TABLE IF NOT EXISTS `$moduletableprefix-monitor-events` (
		  `event_id` int(11) NOT NULL AUTO_INCREMENT,
		  `node_id` int(11) NOT NULL COMMENT 'Узел, на котором обнаружено событие',
		  `event` enum('alive','dead','degradation') NOT NULL,
		  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время события',
		  `comment` text,
		  PRIMARY KEY (`event_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица событий мониторинга' AUTO_INCREMENT=1 ;");

		$put_table_structure=mysql_query("CREATE TABLE IF NOT EXISTS `$moduletableprefix-monitor-nodes` (
		  `node_id` int(11) NOT NULL AUTO_INCREMENT,
		  `mon_type` enum('ping','fsockopen','Socket','DNS') NOT NULL DEFAULT 'ping' COMMENT 'Тип мониторинга',
		  `hostname_ru` text,
		  `hostname_en` text COMMENT 'Hostname (EN)',
		  `ipaddr` text NOT NULL,
		  `port` int(11) DEFAULT NULL,
		  `mon_period` int(11) NOT NULL DEFAULT '10000000' COMMENT 'Период мониторинга для данного узла в режиме демона',
		  `cur_status` enum('alive','dead') NOT NULL DEFAULT 'dead' COMMENT 'Текущий статус узла',
		  `mon_status` enum('active','disable') NOT NULL DEFAULT 'active' COMMENT 'На мониторинге ли хост',
		  `comment` text COMMENT 'Произвольный комментарий',
		  PRIMARY KEY (`node_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Мониторинг портов' AUTO_INCREMENT=1 ;");

		$put_messages=mysql_query("INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename',  'daemon_started', 'Сообщение об успешном запуске демона мониторинга узла', 'Демон успешно запущен', 'Daemon has been started successfully'),
		(NULL, '$modulename', 'deamon_alr_run', 'Запуск демона невозможен, так как он уже запущен', 'Запуск демона невозможен, так как он уже запущен', 'Daemon start can NOT be executed because daemon is already running'),
		(NULL, '$modulename', 'PIDfile_cant_erase', 'Найден файл PID, демон не запущен, невозможно удалить файл', 'Невозможно удалить файл PID', 'PID file can NOT be erased')
		;");
	// Добавить ноду INSERT INTO `$moduletableprefix-monitor-nodes` (`node_id`, `mon_type`, `hostname_ru`, `hostname_en`, `ipaddr`, `port`, `mon_period`, `cur_status`, `mon_status`, `comment`) VALUES (NULL, 'ping', 'Google DNS', 'Google DNS', '8.8.8.8', NULL, '10000000', 'dead', 'active', 'Работоспособность сетевых элементов, меряем по доступности Google');
		
	/*
	
	Инсталляционные действия
	
	$put_page=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, 'change_password', NULL, 0, 1)");

		
	*/
	
}
?>