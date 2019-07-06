<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  \*************************************************************/
$log->LogInfo('Got this file');
if($nitka=='1'){
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if($page=="project_admin"){
		#Ссылка на логику по получению данных под проект
		$show_view='project_admin';
	}
	elseif ($page=='HACTPOuKu'){# Страничка с продуктом
		#Получить сеттинги всех компаний
		if($moduleid){#Выбирают настройки модуля
			$paramwhere="`module_id`='$moduleid'";
		} else $paramwhere="1";
		$paramdatareq=mysql_query("SELECT * FROM `$tableprefix-siteconfig` WHERE $paramwhere order by `module_id` asc, `id` asc;");
		
		# Показать view
		$show_view='siteconfig';
	} elseif($page=='change_admin_password'){
		$show_view='change_password';	
	} elseif($page=='MoDyJlu'){
		$show_view='modules';	
	} elseif($page=='CTPAHuUbI'){
		$show_view='pages';	
	} elseif($page=='noJlb3oBaTeJlu'){
		$show_view='users_management';	
	} elseif($page=='KapTuHKu'){
		$show_view='pictures';	
	} elseif($page=='TeKcToBku'){
		$show_view='messages';	
	} elseif($page=='3KCnopT'){
		$show_view='export';	
	} elseif($page=='O6HoBJleHue'){
		$show_view='update';
	} elseif($page=='CTaTuCTuKa'){
		$show_view='statistics';		
	}elseif($page=='CTaTuCTuKa_graph'){
		$show_view='stat_graph';		
	} elseif($page=='CoobuuEHuR'){
		$show_view='messageToAdmin';		
	}


	else{
		
		$show_view='admin_hello';
	}
}
?>