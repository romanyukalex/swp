<? # Управление содержанием страницы, вывод данных на основе $page
// Запрос в БД, где поле = $page
// Структура БД: page - запрос,folder= напр. '/html', filename - название скрипта, pagetitle - название пункта текстом(заголовок страницы), secondlevelmenu - yes or no
$log->LogInfo('Got '.(__FILE__));
@include_once($_SERVER['DOCUMENT_ROOT'].'/core/pagefromget.php');

if($page){$log->LogDebug('Page is '.$page);} else $log->LogDebug('Page is undefined now');
if(!$pagequeried) {
	$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$page' LIMIT 0,1;"));
	$log->LogInfo('Queried page '.$page.' from DB');
}
if($pagequery['page_id']){ #Страница есть в БД

	#Проверяем права доступа по роли
	if(($pagequery['ap'] and $pagequery['ap']=="site_page_logged_only" and $_SESSION['log']=='1') OR
	($pagequery['ap'] and $pagequery['ap']=="ap_only" and ($userrole=="admin" or $userrole=="root")) OR
	($pagequery['ap'] and $pagequery['ap']=="site_page") OR
	!$pagequery['ap']) $show_page=1;

	if($show_page==1){
		
		
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
						// Для MVC-модулей
						if(is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/controller.php')) {
							if(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
							include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$pagequery['module_page'].'/controller.php'); // Обработали запрос контроллером
							$scriptpath='/core/mvc_get_module_view.php'; // Отдадим view модуля
						}
						// Для простых модулей
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
						echo '<!-- Страница '.$page.'-->';
						if($show_view) $log->LogInfo('Show page '.$page.' with view '.$scriptpath);
						else $log->LogInfo('Show page '.$page.' from file');
						include($_SERVER['DOCUMENT_ROOT'].$scriptpath);
						echo '<!-- // Страница '.$page.'-->';
					} elseif ($block==1){
						$log->LogInfo('Page is 404 because page had been blocked');
						$show404=1;
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
		}
		#Записываем посещение в счётчик
		if(($pagequery['viewCount'] or $pagequery['viewCount']==0)and !$bot_name) mysql_query("UPDATE `$tableprefix-pages` SET `viewCount` = `viewCount` + 1 WHERE `page_id` = ".$pagequery['page_id']." ;");
	} else echo $sitemessage['system']['you_have_no_privileges_to_see'];

} else{#Страницы нет в БД
	$log->LogDebug('Page is 404 because page was not found in DB');
	$show404=1;
}
if($show404==1){# Показываем 404
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/404.php')){
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/404.php');
	} else @include($_SERVER['DOCUMENT_ROOT'].'/pages/404.php');
}
?>
<?if(!isset($ajaxflag)){?></div><?}