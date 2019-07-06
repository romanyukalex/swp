<?
/*****************************************************************************************************************************
  * Snippet Name : sitemap	        																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создает карту сайта для роботов																			 *
  * Using		 : For creating of sitemap for the project (aaditional pages)												 *
  ***************************************************************************************************************************/
$sitemapflag=1;
 
if($nitka=='1'){
	#Добавим торренты
	$pages_q=mysql_query("SELECT `topic_id` FROM `$tableprefix-torrents` WHERE `status`='active';");

	
	while($page=mysql_fetch_array($pages_q)){
		$sitemapXML_arr_elmnt="\r\n<url><loc>".$scheme.$sites['domain'].'/?page=book&topic_id='.$page['topic_id']."</loc><changefreq>";
		# Как часто меняется страница
		if($k==$scheme.$host or $k==$scheme.$host.'/')	{ # Для главной указываем
			if($sites['sitemap_on']=='1' or $sites['sitemap_on']=='3' or $sites['sitemap_on']=='12') $sitemapXML_arr_elmnt.='hourly';
			elseif($sites['sitemap_on']=='24') $sitemapXML_arr_elmnt.='daily';
			elseif($sites['sitemap_on']=='168')$sitemapXML_arr_elmnt.='weekly';
			elseif($sites['sitemap_on']=='744') $sitemapXML_arr_elmnt.='monthly';
		}
		else $sitemapXML_arr_elmnt.='monthly';
		
		$sitemapXML_arr_elmnt.="</changefreq><priority>0.".rand(1,9)."</priority></url>";
		$sitemapXML_arr[]=$sitemapXML_arr_elmnt;//Записали строку в массив
		unset($sitemapXML_arr_elmnt);
	}

	#добавим страницы с видео	
	$vpages_q=mysql_query("SELECT `v_id` FROM `$tableprefix-videos` WHERE `vstatus`='active';");

	while($page=mysql_fetch_array($vpages_q)){
		$sitemapXML_arr_elmnt="\r\n<url><loc>".$scheme.$sites['domain'].'/?page=video&vid='.$page['v_id']."</loc><changefreq>";
		# Как часто меняется страница
		$sitemapXML_arr_elmnt.='monthly';
		
		$sitemapXML_arr_elmnt.="</changefreq><priority>0.".rand(1,9)."</priority></url>";
		$sitemapXML_arr[]=$sitemapXML_arr_elmnt;//Записали строку в массив
		unset($sitemapXML_arr_elmnt);
	}

}
?>