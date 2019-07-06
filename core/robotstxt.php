<?
/*****************************************************************************************************************************
  * Snippet Name : robots.txt query processing	        																	 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создаёт массив сообщений портала, выгружая данные из БД													 *
  * Using		 : For robots																								 *
  ***************************************************************************************************************************/

$sitemapflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
$rob_info=mysql_fetch_array(mysql_query('SELECT * FROM `'.$tableprefix.'-templates_manager` where `domain`="'.$_SERVER['HTTP_HOST'].'" and  `onoff`="on"'));

?>User-Agent: *
Disallow: /adminpanel/
Disallow: /logout/
<? if($rob_info['robotxt_host']){?>HOST: <?=$rob_info['robotxt_host'];}?>