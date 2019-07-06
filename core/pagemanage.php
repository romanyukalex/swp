<? # Управление содержанием страницы, вывод данных на основе $page
// Запрос в БД, где поле = $page
// Структура БД: page - запрос,folder= напр. '/html', filename - название скрипта, pagetitle - название пункта текстом(заголовок страницы), secondlevelmenu - yes or no
$log->LogInfo('Got '.(__FILE__));
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/pagefromget.php');

if(!isset($ajaxflag)){# эти контенты ломают мягкое переключение страниц и вообще выдачу по ajax
	?><div id="content1"></div><div id="content"><?
}
if($page){$log->LogDebug('Page is '.$page);} else $log->LogDebug('Page is undefined now');
if(!$pagequeried) {
	$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$page' and `status`='ena' LIMIT 0,1;"));
	$log->LogInfo('Queried page '.$page.' from DB');
}
if($pagequery['page_id']){ #Страница есть в БД

	#Проверяем права доступа по роли
	if(($pagequery['ap'] and $pagequery['ap']=="site_page_logged_only" and $_SESSION['log']=='1') OR
	($pagequery['ap'] and $pagequery['ap']=="ap_only" and ($userrole=="admin" or $userrole=="root")) OR
	($pagequery['ap'] and $pagequery['ap']=="site_page") OR
	!$pagequery['ap']) $show_page=1;

	if($show_page==1){
		if($pagequery['cache_time'] and $pagequery['cache_time']!=="0"){// Надо показать страницу из кеша или сделать кеш
			
			if($_SERVER['QUERY_STRING']){ // Вызвали какую то страницу, кроме главной
				$q_srting=process_data($_SERVER['QUERY_STRING'],2083);
				$q_srting=str_replace(";",'',$q_srting);
				$q_srting=str_replace("/",'',$q_srting);
				$q_srting= urldecode($q_srting);
				//$q_srting=iconv("windows-1251","UTF-8", $q_srting);
				$q_srting=iconv("UTF-8","windows-1251", $q_srting);
			} else {// Вызвали главную страницу
				$q_srting='page='.$page;
			}
			$cacheFile = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/cache/'.$q_srting.'_'.$userrole.'.cache';
			// если кэш существует
			if (file_exists($cacheFile)) {
				$log->LogDebug('Cache file for this page found');
				// проверяем актуальность кеша
				if ((time() - $pagequery['cache_time']*60) < filemtime($cacheFile)) {
					$log->LogDebug('Cache file shown - '.$cacheFile);
					// показываем данные из кеша
					echo file_get_contents($cacheFile);
					$page_shown=1; //Флаг для не выдавания страницы
				} else {
					$log->LogDebug('Cache file time elapsed. File created at '.date("Y-m-d h:i:s",filemtime($cacheFile)).' and cache lifetime set is '.$pagequery['cache_time'].' min');
				}
			} else $log->LogDebug('Cache file for this page NOT found yet');
			
			if(!$page_shown and !$bot_name){ob_start();} // открываем буфер
		}
		
		if(!$page_shown){ //Страницу отыгрываем если она еще не показана
		
			// Инклюдим страницу php или html или из БД
			if (!empty($pagequery['pagebody_'.$language])){ # Текст страницы существует в БД	
				$log->LogInfo('Show page '.$page.' from DB');
				echo $pagequery['pagebody_'.$language];
			} elseif (!$pagequery['pagebody_'.$language]) { # Нет тела страницы в БД
				$log->LogDebug('Pagebody is not found in DB for language '.$language.' Pagebody_ru - '.$pagequery['pagebody_ru']);
				if ($pagequery['filename']){ # Указан файл страницы в БД
					
					if(substr_count($pagequery['folder'],'/adminpanel/')==0 and substr_count($pagequery['folder'],'/core/usersmanagement/')==0) {
						if ($pagequery['ext']) $scriptpath.='/project/'.$projectname.$pagequery['folder'].$pagequery['filename'].'.'.$pagequery['ext'];
						else $scriptpath.='/project/'.$projectname.$pagequery['folder'].$pagequery['filename'];
					} elseif(substr_count($pagequery['folder'],'/adminpanel/')>0) {
						if ($pagequery['ext']) $scriptpath.=$pagequery['folder'].$pagequery['filename'].'.'.$pagequery['ext'];
						else $scriptpath.=$pagequery['folder'].$pagequery['filename'];
					} elseif(substr_count($pagequery['folder'],'/core/usersmanagement/')>0) {
						$scriptpath.=$pagequery['folder'].$pagequery['filename'];
					}
					$log->LogInfo('Try to show page '.$page.' from file ('.$scriptpath.")");
				} elseif ($pagequery['module_page']){ # Указан модуль
					$log->LogDebug('Page is modulepage - '.$pagequery['module_page']);
					if($pagequery['module_page']!=='adminpanel'){
						# Читаем конфиг модуля
						if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$pagequery['module_page'].'.config.php')) {#Конфиг модуля в папке проекта
							$log->LogDebug('This is module ('.$pagequery['module_page'].') page. Config file is /project/'.$projectname.'/modules_data/'.$pagequery['module_page'].'.config.php');
							include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$pagequery['module_page'].'.config.php');
						} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/config.php')) {#Конфиг модуля общий
							$log->LogDebug('This is module ('.$pagequery['module_page'].') page. Config file is /modules/'.$pagequery['module_page'].'/config.php');
							include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/config.php');
						}
						#Подгружаем параметры модуля из БД
						include($_SERVER['DOCUMENT_ROOT'].'/core/system_param_for_module.php');						
						// Для MVC-модулей подгружаем контроллер
						if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/controller.php')) {
							
							if(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
							include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/controller.php'); // Обработали запрос контроллером
							$scriptpath='/core/mvc_get_module_view.php'; // Отдадим view модуля
						}
						// Для простых модулей подгружаем startscript
						else $scriptpath='/modules/'.$pagequery['module_page'].'/startscript.php';
					} else {#Adminpanel controller
						if(is_readable($_SERVER['DOCUMENT_ROOT'].'/adminpanel/controller.php')) {
							if(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
							include($_SERVER['DOCUMENT_ROOT'].'/adminpanel/controller.php'); // Обработали запрос контроллером
							$scriptpath='/adminpanel/mvc_get_view.php'; // Отдадим view админпанели
						} else $log->LogFatal('Controller of adminpanel is not found');
					}
				}
				if (file_exists($_SERVER['DOCUMENT_ROOT'].$scriptpath) and !empty($scriptpath)){ # Файл страницы существует, можно вставлять
					$log->LogDebug('Page file is found - '.$scriptpath);
					if(!$block or $block!==1){
						$log->LogDebug('-------START PAGEMANAGE ---------');
						echo '<!-- Страница '.$page.'-->';
						if($show_view) $log->LogInfo('Show page '.$page.' with view '.$scriptpath);
						else $log->LogInfo('Show page '.$page.' from file');
						include($_SERVER['DOCUMENT_ROOT'].$scriptpath);
						echo '<!-- // Страница '.$page.'-->';
						$log->LogDebug('-------STOP PAGEMANAGE ---------');
					}
				} else { // $scriptpath нет на диске
					if(empty($scriptpath)) $log->LogDebug('Page file is not found, bcs scriptpath is empty in DB');
					else $log->LogError('Page file is not found - '.$scriptpath.' and no page body in DB. So page exist but could be shown');
					if(!$ip) include($_SERVER['DOCUMENT_ROOT'].'/core/IPreal.php');
					sendletter_to_admin("Проблемы со страницей","Страница есть в БД, но не отображается - ".$page." <br>IP - ".$ip.'<br>BOT - '.$bot_name.'<br>UA - '.$_SERVER['HTTP_USER_AGENT']);
					$show404=1;
					echo "<i style='font-size: xx-small'>Error_desc: scriptpath not exists ($scriptpath) for Page=".$pagequery['page']. '. Lang is '.$language.'</i>';
				}
			
			}
			if ($pagequery['script_after_page']){#Вставляем скрипт после странички
				echo '<!-- Скрипт(ы) после страницы: '.$pagequery['script_after_page'].'-->';
				if(substr_count($pagequery['script_after_page'], ';')>0) {
					$scripts_after_page=explode ( ';' ,$pagequery['script_after_page']);
					foreach($scripts_after_page as $script_after_page){
						include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$script_after_page);
					}
				} else include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$pagequery['script_after_page']);
				echo '<!-- // Скрипт после страницы -->';
			}

			if($pagequery['cache_time'] and $pagequery['cache_time']!=="0"){//мы кешировали, надо записать кеш
				// Открываем файл для записи
				$cache_file_cursor = fopen($cacheFile, 'w');
				// сохраняем все что есть в буфере вфайл кеша
				fwrite($cache_file_cursor, ob_get_contents());
				// закрываем файл
				fclose($cache_file_cursor);
				if(ob_get_length()>0 and filesize($cacheFile)>0){ // Буфер записан в файл
					$log->LogInfo('Cache for the page created. Buffer size - '.ob_get_length().', filesize - '.filesize($cacheFile));
				} else {//Что то пошло не так
					$log->LogError('Cache for the page NOT created. Buffer size - '.ob_get_length().', filesize - '.filesize($cacheFile));
					unlink($cacheFile);
				}
				// выводим страницу
				ob_end_flush();
			}
		}
		#Записываем посещение в счётчик
		if(($pagequery['viewCount'] or $pagequery['viewCount']==0)and !$bot_name) mysql_query("UPDATE `$tableprefix-pages` SET `viewCount` = `viewCount` + 1 WHERE `page_id` = ".$pagequery['page_id']." ;");
	} else echo sitemessage('system','you_have_no_privileges_to_see');

} else{#Страницы нет в БД
	$log->LogDebug('Page is 404 because page was not found in DB');
	$show404=1;
}
if($show404==1){# Показываем 404
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/404.php')){
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/404.php');
	} else @include($_SERVER['DOCUMENT_ROOT'].'/pages/404.php');
}
?><script>
$(document).ready(function(){
	$("#breadcrumb #pagelink").html("<a href='/?page=<?=$page?>'><?=$pagequery['pagetitle_'.$language]?></a>");
	$("#titleonpage").hide(300,function(){
	$("#titleonpage").html("<?=$pagequery['pagetitle_'.$language]?>").fadeIn(300)});
});</script>
<?if(!isset($ajaxflag)){?></div><?}