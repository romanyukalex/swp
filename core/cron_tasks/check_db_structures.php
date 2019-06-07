<?php # Скрипт, выясняющий, не пропали ли таблицы в базе данных всех проектов 
//$log->LogInfo('Got this file');
if($nitka=='1'){
	# Подключаемся ко всем проектам
	print_r($projectexist );
	foreach($projectexist as $projectname=>$value){
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
		@include($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
		echo "
		
		Proverka". $projectname.'
		
		';
		
		if(isset($dbconnconnect)){
			//echo ' HAS DB';
			if(!isset($all_tables_list)){ # Старая БД, вписываем параметр
				mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`) 
				VALUES
				(NULL, '1', '1', 'Список всех таблиц для мониторинга их существования', 'all_tables_list', NULL, NULL, '1', NULL, 'system', '1'),
				(NULL, 'Включено', '2', 'Обслуживание проекта периодическими служебными скриптами (CRON)', 'cronscriptenable', NULL, 'Включено;;Выключено', '1', NULL, 'system', '1'),
				(NULL, 'admin@domain.com', '1', 'Email-ящик, на который будут присылаться аварийные сообщения из CRON-скриптов', 'cronalarmemail', NULL, NULL, '1', NULL, 'system', '1')
				;");
			}
			if($cronscriptenable=='Включено'){
				echo 'cron enabled;';
				# Текущий список таблиц
				$table_list=mysql_query("SHOW TABLES FROM $databasename;");
				
				
					while($table_list_arr=mysql_fetch_array($table_list)){
					$table_list_array[]=$table_list_arr[0];
					}
				#Loading table list from 'siteconfig'
				$result_history_body = mysql_query("SELECT `value` FROM `$tableprefix-siteconfig` where `systemparamname`='all_tables_list';") or die(mysql_error());
				while($result_arr_body=mysql_fetch_array($result_history_body)){$result_array_body[]=$result_arr_body[0];}
				#Convert json from backup to array
				$temp_seg_array=[];
				$temp_seg_array=explode("\"",$result_array_body[0]);
					for ($i=0;$i<100;$i++){
						if (strlen($temp_seg_array[$i]) < 2 ){
							unset($temp_seg_array[$i]);
						}
					}
					$temp_seg_array_1=[];
					//print_r($temp_seg_array);
					foreach ($temp_seg_array as $i){
						array_push($temp_seg_array_1,$i);
					}
				#Creation Arrays that contain removed and added tables
				$addedTableIntoDB = [];
				foreach (array_diff($table_list_array,$temp_seg_array_1) as $i) {
					array_push($addedTableIntoDB, $i);
					}
				$removedTableFromDB = [];
				foreach (array_diff($temp_seg_array_1,$table_list_array) as $i) {
					array_push($removedTableFromDB, $i);
					}	
				#Comparing Arrays
				
				if ($table_list_array !== $temp_seg_array_1) {
					$str_seg_name_mysql="";
					$str_seg_name_backup="";
					foreach ($addedTableIntoDB as $i){
						$str_seg_name_mysql .= $i;
						$str_seg_name_mysql .= " ";
					}
					foreach ($removedTableFromDB as $i){
						$str_seg_name_backup .= $i;
						$str_seg_name_backup .= " ";
					}
					$table_list_array_body_json=json_encode($table_list_array);
					#Sending mail
					include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
					insert_function('send_letter');
					
					/*if (() && ())
					WTF
					
					*/
					$message = 'Здравствуйте<br><br> На проекте <b>'.$projectname.'</b> изменился состав таблиц. <br><br>Удаленные таблицы:<br>'.$str_seg_name_backup.'<br><br>Созданные таблицы:<br>'.$str_seg_name_mysql.'<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
					if ((strlen($str_seg_name_mysql) > 1) && (strlen($str_seg_name_backup) < 1)){
						$message = 'Здравствуйте<br><br> На проекте <b>'.$projectname.'</b> изменился состав таблиц. <br><br>Созданные таблицы:<br>'.$str_seg_name_mysql.'<br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
					}
					elseif ((strlen($str_seg_name_mysql) < 1) && (strlen($str_seg_name_backup) > 1)) {
						$message = 'Здравствуйте<br><br> На проекте <b>'.$projectname.'</b> изменился состав таблиц. <br><br>Удаленные таблицы:<br>'.$str_seg_name_backup.'<br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
					}
					elseif ((strlen($str_seg_name_mysql) > 1) && (strlen($str_seg_name_backup) > 1)) {
						$message = 'Здравствуйте<br><br> На проекте <b>'.$projectname.'</b> изменился состав таблиц. <br><br>Удаленные таблицы:<br>'.$str_seg_name_backup.'<br><br>Созданные таблицы:<br>'.$str_seg_name_mysql.'<br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
					}
					if($cronalarmemail and $cronalarmemail!=='admin@domain.com') $cronmailto=$cronalarmemail;
					else $cronmailto='aromanuk@mail.ru'; 
					
					sendletter_full('Администратор',$cronmailto,'[SWP-cron] Изменение состава таблиц проекта '.$projectname,$message,'[SWP] Check db structures - cron script',$officialemail);
					mysql_query("UPDATE `$tableprefix-siteconfig` SET `value`='$table_list_array_body_json' WHERE `systemparamname`='all_tables_list';");
				}
				mysql_data_seek($paramdatas,0);
				while($paramdata=mysql_fetch_array($paramdatas)){
					unset($$paramdata['systemparamname']);
				}
				mysql_close($dbconnconnect);
				
				
			} else echo 'CRON disabled';
		} else{# Нет подключения к БД
			//echo "No DB";
			include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
			insert_function('send_letter');
			
			$message='Здравствуйте<br><br> При работе скрипта check_db_structures был обнаружен проект ('.$projectname.'), в котором неверны настройки подключения БД, либо подключение не удалось по другой причине<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
			sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Изменение состава таблиц',$message,'[SWP] Check db structures - cron script',$officialemail);
		}
	}
}?>