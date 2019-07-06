<?
/*****************************************************************************************************************************
  * Snippet Name : sitemap	        																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создает карту сайта для роботов																			 *
  * Using		 : For creating of sitemap																					 *
  * For additional pages of the project write script in /project/projectname/scripts/sitemap_db_add.php						 * ***************************************************************************************************************************/
//$sitemapflag=1;
echo "Got stat script";
if($nitka=='1' and $now_hour=="23" and $now_min=="55"){
	echo "Now is the time to start getting statistic";
	# Подключаемся ко всем проектам
	foreach($projectexist as $projectname=>$value){
		
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
		@include($_SERVER['DOCUMENT_ROOT'].'/core/system-param_cron.php');
		
		
		if(isset($dbconnconnect)){ // Есть коннект к БД проекта
			
			/*
			В поле Query можно писать запросы вместе с PHP-кодом. Например:
			SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `status`='need_confirm';
			или
			$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/script/script.php
			Если используется PHP, то его надо записать в конфигурацию по полному имени, а результат добавить в массив $query['COUNT']
			*/

			$stat_conf_q=mysql_query("SELECT * FROM `$tableprefix-stat-conf` WHERE 1;");
			while($stat_conf=mysql_fetch_array($stat_conf_q)){
				$query_text=$stat_conf['Query'];
				eval("\$query_text = \"$query_text\";");
				//echo $query_text."<br>";
				if(mb_substr($stat_conf['Query'],-4)!==".php"){ //Используется просто запрос, а не скрипт PHP

					$query=mysql_fetch_assoc(mysql_query($query_text)); // Запрашиваем данные в БД
					
				} else { #Используется скрипт PHP для доставания параметра
				
					include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/script/'.$query_text); //Запускаем скрипт
					
				}
				
				#Пишем результат в БД	
				if($query['COUNT'] or $query['COUNT']==0) {
					mysql_query("INSERT INTO `$tableprefix-stat-results`  
					( `paramName`, `result`, `ts`) VALUES 
					( '".$stat_conf['ParamName']."', '".$query['COUNT']."', CURRENT_TIMESTAMP);");
				}
			}

		} else{# Нет подключения к БД
			include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
			insert_function('send_letter');
			
			$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' был обнаружен проект ('.$projectname.'), в котором неверны настройки подключения БД, либо подключение не удалось по другой причине<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
			sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Изменение состава таблиц',$message,'[SWP] Check db structures - cron script',$officialemail);
		}
	}
} else echo "Now is the NO time to start getting statistic";
?>