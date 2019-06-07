<?php # Скрипт, удаляющий кешированные страницы всех проектов

if($nitka=='1'){
	//$now_hour = date('G');
	//$now_min=date('i');
	if($now_hour=="02" AND $now_min=="15"){ # Запускать в 2 часа 15 минут

	# Подключаемся ко всем проектам
//	print_r($projectexist );
	foreach($projectexist as $projectname=>$value){
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
		include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
		//@include($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
		insert_function("dir_to_array");
		echo "
		
		Proverka". $projectname.'
		
		';
		
		if(isset($dbconnconnect)){
			//echo ' HAS DB';

			if($cronscriptenable=='Включено'){
				//echo 'cron enabled;';

				#Получаем все страницы, у которых параметр кеширования не равен 0
				$pages_wcache_q=mysql_query("SELECT `page`,`cache_time` FROM `$tableprefix-pages` WHERE `cache_time`>0;");

				#Массив [page]=>['time']
				while($page_wcache=mysql_fetch_array($pages_wcache_q)){
					$pages_wcache[$page_wcache['page']]=$page_wcache['cache_time'];

				}
				#Получаем все файлы кешей
				$cache_dir=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/cache/';
				$cache_files_arr=dir_to_array($cache_dir);

				#Перебираем кеши
				foreach($cache_files_arr as $cache_file){
					#Находим название страницы
					$file_expl_gen=explode("_",$cache_file);
					$file_expl_amp=explode("&",$file_expl_gen[0]);
					if(mb_strstr($file_expl_amp[0],"page=")){ // Этот кеш содержит название страницы
						$page_name=mb_substr($file_expl_amp[0],5);
						//echo $page_name.'<br>';
						if($pages_wcache[$page_name]){#У этой страницы есть настройки кеша в табличке pages
							#Получаем filemtime 
							//echo "Страничка найдена для данного кеша его FT - ".date("Y-m-d h:i:s",filemtime($cache_dir.$cache_file)).', он должен жить '.$pages_wcache[$page_name].' минут а живет - '.((time() -filemtime($cache_dir.$cache_file))/60).'<br>';
							if ((time() - $pages_wcache[$page_name]*60) > filemtime($cache_dir.$cache_file)) { //удаляем те, что те, что просрочены
								//echo "<b>1 Будет удален </b>- ".$cache_file.'<br>';
								unlink($cache_dir.$cache_file);
							} else {
								//echo "<br>Файл не будет удален ".$cache_file;
							}
					
						} else { //У этого кеша нет настроек в табличке pages
							#удаляем этот кеш, для которого нет настроек page (видимо, поменяли настройку кеширования на 0)
							unlink($cache_dir.$cache_file);
						}
					}
				}
				
				#Удаляем настройки проекта
				mysql_data_seek($paramdatas,0);
				while($paramdata=mysql_fetch_array($paramdatas)){
					unset($$paramdata['systemparamname']);
				}
				mysql_close($dbconnconnect);

			} else {
				//echo 'CRON disabled';
			}
		} else{# Нет подключения к БД
			//echo "No DB";
			
			insert_function('send_letter');
			
			$message='Здравствуйте<br><br> При работе скрипта check_db_structures был обнаружен проект ('.$projectname.'), в котором неверны настройки подключения БД, либо подключение не удалось по другой причине<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
			sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Изменение состава таблиц',$message,'[SWP] Check db structures - cron script',$officialemail);
		}
	}
	} else echo "Не надо запускать этот скрипт\r\n";
}?>