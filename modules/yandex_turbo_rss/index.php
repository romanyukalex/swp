<?php 
 /***********************************************************************
  * Snippet Name : yandex turbo rss feeds		    			 		* 
  * Scripted By  : RomanyukAlex		           					 		* 
  * Website      : http://popwebstudio.ru	   					 		* 
  * Email        : admin@popwebstudio.ru     					 		* 
  * License      : GPL (General Public License)					 		* 
  * Purpose 	 : To show RSS feeds for turbo pages			 		*
  * Access		 : http://domain.com/modules/yandex_turbo_rss/	 		*
  *	http://domain.com/modules/yandex_turbo_rss/?section=раздел&lang=en *
  **********************************************************************/
//require_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
//if($loglevel!=="OFF"){@require($_SERVER["DOCUMENT_ROOT"]."/core/functions/KLogger.php");}


$moduleflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
$log->LogInfo("Got ".(__FILE__));

$neededtable=process_data($_REQUEST['section'],20);
$rss_lang=process_data($_REQUEST['lang'],2);
if(!$rss_lang){$rss_lang="ru";}
if ($neededtable and $rss_lang=="ru"){$rsstitle="Раздел ".$neededtable." на сайте ";}
elseif(!$neededtable and $rss_lang=="ru"){$rsstitle="Новости всех разделов сайта ";}
elseif ($neededtable and $rss_lang=="en"){$rsstitle="News of ".$neededtable." on portal ";}
elseif(!$neededtable and $rss_lang=="en"){$rsstitle="News of all sections on portal ";}

if($ya_rss_choosedomain=="Доменное имя, на которое пришел запрос"){$rss_sitedomainname=$_SERVER['HTTP_HOST'];}
else{$rss_sitedomainname=$sitedomainname;}

?>
<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru"  version="2.0">
    <channel>
	<turbo:analytics
         id="30423247"
         type="Yandex"
         >
    </turbo:analytics>
<title><?=$rsstitle." ".$rss_sitedomainname?></title>
<link>https://<?=$rss_sitedomainname?></link>
<description><?
if($rss_lang=="en") {echo "The news feed on portal";} else echo "Лента обновлений на сайте";
echo $rss_sitedomainname."</description>
<language>".$rss_lang."</language>
<image>

	<url>https://".$rss_sitedomainname.$logofile."</url>
	<title>".$rsstitle." ".$rss_sitedomainname."</title>
	<link>https://".$rss_sitedomainname."</link>

</image>";
	# Выбираем все новости
	$query=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `turboyaposted` IS false AND `status`='ena' AND `ap`='site_page' AND `is_articles`=1 ORDER BY `page_id` DESC LIMIT 0,$yarssnewsquantity");
	if(mysql_num_rows($query)==0){ #Нет непощенных, надо дать просто последние, а то Яндекс даёт ошибку
		$query=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `status`='ena' AND `ap`='site_page' AND `is_articles`=1 ORDER BY `page_id` DESC LIMIT 0,$yarssnewsquantity");
	}
	while ($pagequery = mysql_fetch_assoc($query))
		{ if($pagequery['page']){
			?>
	<item turbo="true">
	
	   <link>https://<?=$rss_sitedomainname?>/?page=<?=$pagequery['page']?></link>
	   <turbo:content>
		   <![CDATA[
			   <header>
				   <h1><?=$pagequery['pagetitle_'.$rss_lang]?></h1>
			   </header>
			   <?
			   
			   if($pagequery['page_img']){
			   ?>
			   
			   <figure>
				  <img src="<?=$pagequery['page_img']?>" />
				  <figcaption><?=$pagequery['pagetitle_'.$rss_lang]?></figcaption>
			  </figure>
			   <?}
				if (!empty($pagequery['pagebody_'.$rss_lang])){ # Текст страницы существует в БД	
					$log->LogInfo('Show page '.$pagequery['page'].' from DB');
					echo $pagequery['pagebody_'.$rss_lang];
				} elseif (!$pagequery['pagebody_'.$rss_lang]) { # Нет тела страницы в БД
					$log->LogDebug('Pagebody is not found in DB for language '.$rss_lang.' Pagebody_ru - '.$pagequery['pagebody_ru']);
					if ($pagequery['filename']){ # Указан файл страницы в БД
						
						if(substr_count($pagequery['folder'],'/adminpanel/')==0 and substr_count($pagequery['folder'],'/core/usersmanagement/')==0) {
							
							$scriptpath='/project/'.$projectname.$pagequery['folder'].$pagequery['filename'];
							//echo $scriptpath;
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
						}
					}
					if (file_exists($_SERVER['DOCUMENT_ROOT'].$scriptpath) and !empty($scriptpath)){ # Файл страницы существует, можно вставлять

						$log->LogDebug('Page file is found - '.$scriptpath);
						if(!$block or $block!==1){
							
							include($_SERVER['DOCUMENT_ROOT'].$scriptpath);
							
						} elseif ($block==1){
							$log->LogInfo('Page is 404 because page had been blocked');
							$show404=1;
						}
						
					} else { // $scriptpath нет на диске
						if(empty($scriptpath)) $log->LogDebug('Page file is not found, bcs scriptpath is empty in DB');
						else $log->LogError('Page file is not found - '.$scriptpath.' and no page body in DB. So page exist but could be shown');
						if(!$ip) include($_SERVER['DOCUMENT_ROOT'].'/core/IPreal.php');
						sendletter_to_admin("Проблемы со страницей","Страница есть в БД, но не отображается - ".$pagequery['page']." <br>IP - ".$ip.'<br>BOT - '.$bot_name.'<br>UA - '.$_SERVER['HTTP_USER_AGENT']);
						$show404=1;
						
					}
				
				}
			   ?>
			]]>
	   </turbo:content>
   </item>
	<? }
		#Запоминаем page_id
		$page_id_arr[]=$pagequery['page_id'];
	}
	#Изменяем флаг чтобы отдали в следующий раз другой контент для индексации
	foreach($page_id_arr as $page_id){
		$shown_pages_q.=" or `page_id`='".$page_id."' ";
	}
	$shown_pages_q=mb_substr($shown_pages_q,4);
	#Изменяем turboyaposted
	$turboyaposted_chq=mysql_query("UPDATE `$tableprefix-pages` SET `turboyaposted` = '1' WHERE ".$shown_pages_q);
	?>
    </channel>
</rss>




<?
/*

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><rss version=\"2.0\" xmlns:atom=".'"'."http://www.w3.org/2005/Atom".'"'.">
<channel>
<title>".$rsstitle." ".$rss_sitedomainname."</title>
<link>http://".$rss_sitedomainname."</link>
<description>";
if($rss_lang=="en") {echo "The news feed on portal";} else echo "Лента обновлений на сайте";
echo $rss_sitedomainname."</description>
<language>".$rss_lang."</language>
<image>
	<url>http://".$rss_sitedomainname.$logofile."</url>
	<title>".$rsstitle." ".$rss_sitedomainname."</title>
	<link>http://".$rss_sitedomainname."</link>

</image>
<atom:link href='http://".$rss_sitedomainname."/modules/rss' rel='self' type='application/rss+xml' />
";
if($neededtable){$sectionquery="`section`='$neededtable' and `status`='active'";}else $sectionquery="`status`='active'";
# Выбираем последнюю новость
$data =  mysql_fetch_array(mysql_query("SELECT `newsdate` FROM `$tableprefix-news` WHERE $sectionquery ORDER BY `newsdate` DESC LIMIT 0,1"));
if ($data['newsdate']){
	$upldt = strftime("%a, %d %b %Y %H:%M:%S %z",strtotime($data['newsdate'])); // конвертация даты в формат RFC 2822
}
echo "<lastBuildDate>".$upldt."</lastBuildDate>
<ttl>60</ttl>
";
# Выбираем все новости
$query=mysql_query("SELECT * FROM `$tableprefix-news` WHERE $sectionquery ORDER BY `newsdate` DESC LIMIT 0,$rssnewsquantity");
while ($data = mysql_fetch_array($query))
	{
	echo "<item>
	";
	echo "<title>".$data['newstitle_'.$rss_lang]."</title>
	";
	//echo "<link>http://www.".$sitedomainname."/?page=news&newsaction=show_news_text&news_id=".$data['newsid']."&menu=mainmenu</link>
	echo "<link>http://".$rss_sitedomainname."/?page=news<![CDATA[&]]>newsaction=show_news_text<![CDATA[&]]>news_id=".$data['newsid']."<![CDATA[&]]>menu=mainmenu<![CDATA[&]]>lang=".$rss_lang."</link>
	";
	if($data['shorttext_'.$rss_lang]) echo "<description><![CDATA[".$data['shorttext_'.$rss_lang]."]]></description>";
	else{// Ищем новые абзацы
		//$rss_news_stop=strpos(mb_substr($data['fulltext_'.$rss_lang],0,$rss_text_min,"utf8"), "<br>");// Ищем новые абзацы в 
		if (function_exists('mb_substr')) {$rss_news_stop=strpos(mb_substr($data['fulltext_'.$rss_lang],0,$rss_text_min), "<br>");}
		else $rss_news_stop=strpos(substr($data['fulltext_'.$rss_lang],0,$rss_text_min,"utf-8"), "<br>");
		if ($rss_news_stop === false or $rss_news_stop<80) {//Строка '<br>' не найдена в строке $data['fulltext_'.$rss_lang]
			$rss_news_stop=$rss_text_min;
			echo "<description><![CDATA[";
			if (function_exists('mb_substr')) {echo mb_substr($data['fulltext_'.$rss_lang],0,$rss_text_min);}
			else echo substr($data['fulltext_'.$rss_lang],0,$rss_text_min,"utf-8");
			echo "<b>...<b>]]></description>";
		} else {
			echo "<description><![CDATA[".$rss_lang;
			if (function_exists('mb_substr')) {echo mb_substr($data['fulltext_'.$rss_lang],0,$rss_news_stop);}
			else echo substr($data['fulltext_'.$rss_lang],0,$rss_news_stop,"utf-8");
			echo "]]></description>";
		}
	}
	echo "<category>".$data['section']."</category>
	";
	$updt =strftime("%a, %d %b %Y %H:%M:%S %z",strtotime($data['date']));
	echo "<pubDate>$updt</pubDate>
	";
	echo "<guid>http://".$rss_sitedomainname."/?page=news<![CDATA[&]]>newsaction=show_news_text<![CDATA[&]]>news_id=".$data['newsid']."<![CDATA[&]]>menu=mainmenu<![CDATA[&]]>lang=".$rss_lang."</guid>
";
	echo "</item>
";
	}
echo "</channel>
</rss>";
/* Получится
<lastBuildDate>Здесь дата последнего изменения в канале (RFC 2822)</lastBuildDate>

<item>
<title>Заголовок статьи1 или новости1</title>
<link>Ссылка на эту статью или новость</link>
<description>Текст статьи или новости в произвольном объёме</description>
<pubDate>Дата опубликования данной статьи или новости</pubDate>
</item>

<item>
<title>Заголовок статьи2 или новости2</title>
<link>Ссылка на эту статью или новость</link>
<description>Текст статьи или новости в произвольном объёме</description>
<pubDate>Дата опубликования данной статьи или новости</pubDate>
</item>

</channel>
</rss>
*/
/*
Раскрутка
http://feedshark.brainbliss.com/
http://www.submitrssfeed.com/
http://www.dummysoftware.com/rsssubmit.html
*/
?>