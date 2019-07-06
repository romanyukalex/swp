<?php
 /***********************************************************************
  * Snippet Name : Script to get statistics		 				 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some crontabbed functions					 		*
  * Access		 : 														*
  *  																	*
  **********************************************************************/
 $log->LogDebug('Got this file');
if ($nitka=='1'){

	# Видео
	$v_today_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as VCOUNT FROM `$tableprefix-videos` WHERE`last_update` BETWEEN '".date("Y-m-d")." 00:00:00.000000' AND '".date("Y-m-d")." 23:59:59.000000';"));
	$v_need_mod_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as NMCOUNT FROM `$tableprefix-videos` WHERE `vstatus`='need_moderate';"));
	
	#Книги

	#Книги в базе всего
	$b_all_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE 1;"));
	#Книги в базе активных
	$b_all_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `status`='active';"));
	#Книги в базе ждут подтверждения
	$b_all_needconfirm_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `status`='need_confirm';"));
	
	#Книги добавлены сегодня
	$b_today_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `date`='".date("Y-m-d")."';"));
	#Отвергнутые	
	$b_disabled_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `status`='disabled';"));
	
	

	#Страницы
	
	#Всего страниц
	$pages_all_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE 1;"));
	//echo $pages_all_q['ARTCLS_COUNT'];
	
	#Всего страниц в статусе disabled
	$pages_all_dis=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `status`='dis';"));
	//echo $pages_all_dis['COUNT'];
	
	#Всего страниц в статусе error
	$pages_all_err=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `status`='err';"));
	//echo $pages_all_err['COUNT'];
	
	#Всего страниц в статусе blocked
	$pages_all_blk=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `status`='blk';"));
	//echo $pages_all_blk['COUNT'];
	
	
	#Всего служебных страниц
	$pages_admin=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `ap`='ap_only';"));
	//echo $pages_admin['COUNT'];
	#Всего простых страниц
	$pages_sitePage=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `ap`='site_page';"));
	//echo $pages_sitePage['COUNT'];
	
	#Всего страниц со статьями в БД
	$pages_artcls_db=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `filename`='CTATbR.php';"));
	//echo $pages_artcls_db['COUNT'];
	
	#Всего статей на диске
	insert_function("dir_to_array");
	$pages_all_disk_arr=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html'); // выбрали все с файлами на русском
	$pages_artcls_disk=count($pages_all_disk_arr);
	unset($pages_all_disk_arr);
	$pages_all_disk_arr_en=dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html_en'); // выбрали все с файлами на англ
	$pages_artcls_disk_en=count($pages_all_disk_arr_en);
	unset($pages_all_disk_arr_en);
	
	// echo $pages_artcls_disk .' '.$pages_artcls_disk_en
	
	#Всего страниц со видео
	$pages_video=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-pages` WHERE `filename`='videopage.php';"));
	//echo $pages_video['COUNT'];
	
	#Добавлены сегодня
	$pages_today_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."';"));
	//echo $pages_today_q['ARTCLS_COUNT'];
	#Одобрены сегодня
	$pages_today_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."' and `is_articles`='1';"));
	//echo $pages_today_act_q['ARTCLS_COUNT'];
	#Ждут модерации сегодня
	$pages_today_waitmoder_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."' and `is_articles`='0' and (`pagebody_ru` is not null OR `filename` is not null);"));
	//echo $pages_today_waitmoder_q['ARTCLS_COUNT'];
	#Ждут модерации вообще
	$pages_all_waitmoder_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `is_articles`='0' and (`pagebody_ru` is not null OR `filename` is not null);"));
	//echo $pages_all_waitmoder_q['ARTCLS_COUNT'];
	#Удаленные страницы в базе
	$pages_all_deleted_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `is_articles`='0' and `pagebody_ru` is null and `filename` is not null;"));
	//echo $pages_all_deleted_q['ARTCLS_COUNT'];
	#Удаленные сегодня
	$pages_today_deleted_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."' and `is_articles`='0' and `pagebody_ru` is null and `filename` is not null;"));
	//echo $pages_today_deleted_q['ARTCLS_COUNT'];
	
	
	
	
	#Шутки
	#Добавлены сегодня
	$jokes_today_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-jokes` WHERE `pubDate` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));
	//echo $jokes_today_act_q['COUNT'];
	#Всего в БД
	$jokes_all_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-jokes` WHERE 1;"));
	//echo $jokes_all_act_q['COUNT'];
	
	#Пользователи
	#Добавлены сегодня
	$users_today_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-users` WHERE `timestamp` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));
	#Всего в БД
	$users_all_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-users` WHERE 1;"));

	#Заказы
	#Всего заказов
	$orders_all=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-orders` WHERE 1;"));
	//echo $orders_all['COUNT'];
	
	
	#В статусах
	$orders_statuses=mysql_query("SELECT `status`, COUNT(*) as COUNT FROM `$tableprefix-orders` GROUP BY `status`;");
	
	while($orders_status_rr=mysql_fetch_assoc($orders_statuses)){
		$orders_status[$orders_status_rr['status']]= $orders_status_rr['COUNT'];
		
	}
	// print_r($orders_status);


}//nitka


?>