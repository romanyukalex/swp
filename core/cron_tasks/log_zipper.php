<?
/*****************************************************************************************************************************
  * Snippet Name : sitemap	        																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создает карту сайта для роботов																			 *
  * Using		 : For robots																								 *
  ***************************************************************************************************************************/
$sitemapflag=1;
 
if($nitka=='1'){
	include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/dir_to_array.php'; // Заменить на insert_function когда починю log->
	include_once $_SERVER['DOCUMENT_ROOT'].'/core/functions/zip_create.php';
	# Подключаемся ко всем проектам
	foreach($projectexist as $projectname=>$value){
			echo 'Check '.$projectname."\n";
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
			include($_SERVER['DOCUMENT_ROOT'].'/core/system-param_cron.php');
			
			
			if(isset($dbconnconnect) ){ // Есть коннект к БД проекта, соответственно, все переменные
				if(isset($max_log_size)){
					//echo "max_log_size - ".$max_log_size ."МБ";
					$dir_array=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir);
					//echo "Файлы в папке";print_r($dir_array);
					for ($i = 0; $i <= 10; $i++) {
						if(strstr($dir_array[$i],".log")){ // Это лог файл
							//echo "found log - ".$dir_array[$i]."<br>\n";
							if(filesize ($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.$dir_array[$i] ) > $max_log_size * 1000000 ){//Сжимаем файл
								//$log->LogInfo( "Compress ".$dir_array[$i]." for this project");
								//echo "Compress ".$dir_array[$i]." for this project\n";
								$filename_zip=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.$dir_array[$i];
								$files[]=$filename_zip;
								zip_create($files, $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.date("Y-m-d-H-i").".zip", FALSE);
								
								unset($files);
								unlink($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.$dir_array[$i]);
								//echo "Удалили ". $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.$dir_array[$i];
								sleep(1);
							} else {
								//echo "Не сжимаем ".$dir_array[$i]." тк его размер ".filesize ($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.$log_dir.$dir_array[$i] )."<br>";
							}
						}
					}
				}
			} else{# Нет подключения к БД
				include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
				insert_function('send_letter');
				
				$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' был обнаружен проект ('.$projectname.'), в котором неверны настройки подключения БД, либо подключение не удалось по другой причине<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
				sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Изменение состава таблиц',$message,'[SWP] Check db structures - cron script',$officialemail);
			}
		unset($max_log_size);
	}


}
?>