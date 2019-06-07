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
$sitemapflag=1;
 
if($nitka=='1'){
	
	# Подключаемся ко всем проектам
	foreach($projectexist as $projectname=>$value){
		if($stopsitemap_cr_flag!==1 or !$stopsitemap_cr_flag){ // Запускаем 1 сайт за все время исполнения скрипта. Остальные - в след cron
			//echo 'Check '.$projectname;
			include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/config.php');
			@include($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
			
			
			if(isset($dbconnconnect)){ // Есть коннект к БД проекта
				
				
				$sites_q=mysql_query("SELECT * FROM `$tableprefix-templates_manager` WHERE 1;"); // Список доменов проекта
				set_time_limit(0);
				
				while ($sites=mysql_fetch_array($sites_q)){ #формируем sitemap для каждого сайта (домена) согласно указаниям в табличке templates_manager
					

					//if($sites['sitemap_on']!=='0' and $sites['sitemap_on'] and ($stopsitemap_cr_flag!==1 or !$stopsitemap_cr_flag)){ # Для домена нужно делать sitemap. Запускаем 1 сайт за все время исполнения скрипта. Остальные - в след cron
					if($sites['sitemap_on']!=='0' and $sites['sitemap_on']){ # Для домена нужно делать sitemap
						$host=$sites['domain'];
						
						
						$scheme='https://';
						$urls=array(); // Здесь будут храниться собранные ссылки
						$content=NULL; // Рабочая переменная
						$nofollow=array('/logout/','/adminpanel/');// Здесь ссылки, которые не должны попасть в sitemap.xml
						// Первой ссылкой будет главная страница сайта, ставим ей 0, т.к. она ещё не проверена
						$urls[$scheme.$host]='0';
						// Разрешённые расширения файлов, чтобы не вносить в карту сайта ссылки на медиа файлы. Также разрешены страницы без разрешения, у меня таких страниц подавляющее большинство.
						$extensions[]='php';$extensions[]='aspx';$extensions[]='htm';$extensions[]='html';$extensions[]='asp';$extensions[]='cgi';$extensions[]='pl';
						#Файл индекса или сам sitemap
						$sm_index_file= $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$sites['domain'].'.sitemap.xml';
						
						if (!file_exists($sm_index_file) or ((time() - filemtime($sm_index_file))>60*60*$sites['sitemap_on'])) { // Пора обновлять
						
							include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
							
							// Когда все ссылки собраны, то обрабатываем их и записываем в файлы sitemap.xml и sitemap.txt (должны быть права на запись)
							$sitemapXMLHeader='<?xml version="1.0" encoding="UTF-8"?>
							<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
							xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
							xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
							<!-- Last update of sitemap '.date("Y-m-d H:i:s+06:00").' -->';
							
							#Главная страница в массив
							$sitemapXML_arr_elmnt="<url><loc>".$scheme.$sites['domain']."/</loc><changefreq>daily</changefreq><priority>0.9</priority></url>";
							
							$sitemapXML_arr[]=$sitemapXML_arr_elmnt;//Записали строку в массив
							unset($sitemapXML_arr_elmnt);
							
							#Все остальные страницы в массив
							if(!$pages_q){ //Первый запрос за страницами, то есть первый домен из темплейт менеджера
								
								$pages_q=mysql_query("SELECT `page`,`filename` FROM `$tableprefix-pages` WHERE `showin_all_pages_page`='1';");

								$sitemap_size=mysql_num_rows($pages_q);
							} else { //Уже запрашивали данные о страницах
								mysql_data_seek($pages_q, 0);
							}
							// Добавляем каждую ссылку
							while($page=mysql_fetch_array($pages_q)){
								
								$sitemapXML_arr_elmnt="\r\n<url><loc>".$scheme.$sites['domain'].'/?page='.$page['page']."</loc><changefreq>";
								# Как часто меняется страница
								
								if(mb_strstr($page['filename'],".php") and $page['filename']!=="videopage.php"){
									$sitemapXML_arr_elmnt.='hourly';
								} else {
									$sitemapXML_arr_elmnt.='weekly';
								}
								
								/*
								if($k==$scheme.$host or $k==$scheme.$host.'/')	{ # Для главной указываем
									if($sites['sitemap_on']=='1' or $sites['sitemap_on']=='3'or $sites['sitemap_on']=='12') {
									
										$sitemapXML_arr_elmnt.='hourly';
										}
									elseif($sites['sitemap_on']=='24') {
										
										$sitemapXML_arr_elmnt.='daily';
									}
									elseif($sites['sitemap_on']=='168') $sitemapXML_arr_elmnt.='weekly';
									elseif($sites['sitemap_on']=='744') $sitemapXML_arr_elmnt.='monthly';
								}
								else {
									
									$sitemapXML_arr_elmnt.='daily';
								}
								*/
								$sitemapXML_arr_elmnt.="</changefreq><priority>0.";
								if($page['page']==$sites['mainpage']){$sitemapXML_arr_elmnt.='9';} else {$sitemapXML_arr_elmnt.=rand(1,9);} // Если это главная страница, то полюбому 0.9, для остальных - случайное число
								
								$sitemapXML_arr_elmnt.="</priority></url>";
								$sitemapXML_arr[]=$sitemapXML_arr_elmnt;//Записали строку в массив
								unset($sitemapXML_arr_elmnt);
							}
							#Добавляем строк для конкретного проекта
							if(is_file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/sitemap_db_add.php')) include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/sitemap_db_add.php');
							
							$sitemapXMLEnd="\r\n</urlset>";
							
							
							if(count($sitemapXML_arr)>50000){ #Строк слишком много, надо дробить на файлы

								#Вычислив количество файлов sitemap
								$sm_count=ceil(count($sitemapXML_arr)/50000);
								
								#Записываем sitemap index в файл
								$sm_index_XML='<?xml version="1.0" encoding="UTF-8"?>
								<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
								for($i=1;$i<=$sm_count;$i++){
									
									$sm_index_XML.='
									<sitemap>
									  <loc>'.$scheme.$sites['domain'].'/sitemap.part'.$i.'.xml</loc>
									  <lastmod>'.date("Y-m-d\TH:i:s+00:00").'</lastmod>
								   </sitemap>';
								   
								}
								$sm_index_XML.='</sitemapindex>';
								//$sm_index_file= $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$sites['domain'].'.'.'sitemap.xml';
								$fp=fopen($sm_index_file,'w+');
								if(!fwrite($fp,$sm_index_XML)){
									echo 'Ошибка записи!';
									insert_function('send_letter');
									$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' в проекте ('.$projectname.') произошла ошибка записи Index Sitemap в файл '.$sm_index_file;
									sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Ошибка записи Index sitemap',$message,'[SWP] sitemap_db - cron script',$officialemail);
									
								}
								fclose($fp);
								
								#Записываем файлы sitemap
								for($i=1;$i<=$sm_count;$i++){
									
									#Имя файла sitemap
									$sm_file= $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$sites['domain'].'.'.$i.'.sitemap.xml';
									//Запись в файл
									$fp=fopen($sm_file,'w+');
									#Находим позицию в массиве, с которой надо начать писать в данный файл
									if($i==1) $start_arr_pos=0;
									else $start_arr_pos=($i-1)*50000;
									//Надо агрегировать $sitemapXML_arr из массива в строку и писать
									$sitemapXML=$sitemapXMLHeader.implode("",array_slice($sitemapXML_arr,$start_arr_pos,50000)).$sitemapXMLEnd;
									//Некоторые символы, а также кириллица - должны быть в правильной кодировке/виде (по спецификации)
									$sitemapXML=trim(strtr($sitemapXML,array('%2F'=>'/','%3A'=>':','%3F'=>'?','%3D'=>'=','%26'=>'&','%27'=>"'",'%22'=>'"','%3E'=>'>','%3C'=>'<','%23'=>'#','&'=>'&amp;')));
								
									if(!fwrite($fp,$sitemapXML)){
										echo 'Ошибка записи!';
										
										insert_function('send_letter');
										$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' в проекте ('.$projectname.') произошла ошибка записи Sitemap в файл '.$sm_file;
										sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Ошибка записи sitemap',$message,'[SWP] sitemap_db - cron script',$officialemail);
										
										}
									fclose($fp);
									
								}
								
							} else { # Файл sitemap один
								//$sitemapXML=$sitemapXMLHeader.$sitemapXML.$sitemapXMLEnd;
								#Имя файла sitemap
								$sm_file= $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$sites['domain'].'.'.'sitemap.xml';
								//Запись в файл
								$fp=fopen($sm_file,'w+');
								//Надо агрегировать $sitemapXML_arr из массива в строку и писать
								$sitemapXML=$sitemapXMLHeader.implode("",$sitemapXML_arr).$sitemapXMLEnd;
								//Некоторые символы, а также кириллица - должны быть в правильной кодировке/виде (по спецификации)
								$sitemapXML=trim(strtr($sitemapXML,array('%2F'=>'/','%3A'=>':','%3F'=>'?','%3D'=>'=','%26'=>'&','%27'=>"'",'%22'=>'"','%3E'=>'>','%3C'=>'<','%23'=>'#','&'=>'&amp;')));
							
								if(!fwrite($fp,$sitemapXML)){
									echo 'Ошибка записи!';
									
									insert_function('send_letter');
									$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' в проекте ('.$projectname.') произошла ошибка записи Sitemap в файл '.$sm_file;
									sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Ошибка записи sitemap',$message,'[SWP] sitemap_db - cron script',$officialemail);
									
									}
								fclose($fp);
							}
						}
					}
					unset($sm_index_file,$sm_file,$sitemapXML,$sitemapXML_arr,$sitemapXMLEnd);
				}
			} else{# Нет подключения к БД
				include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts_cron.php');
				insert_function('send_letter');
				
				$message='Здравствуйте<br><br> При работе скрипта '.(__FILE__).' был обнаружен проект ('.$projectname.'), в котором неверны настройки подключения БД, либо подключение не удалось по другой причине<br><br>Пожалуйста, не отвечайте на это письмо, оно отправлено роботом';
				sendletter_full('Администратор','aromanuk@mail.ru','[SWP] Изменение состава таблиц',$message,'[SWP] Check db structures - cron script',$officialemail);
			}
		}
	}
}
?>