<?php 
 /****************************************************************
  * Snippet Name : rss feeds		           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : To show RSS feeds based on News-module		 *
  * Access		 : http://domain.com/modules/rss/				 *
  *		http://domain.com/modules/rss/?section=раздел&lang=en	 *
  ***************************************************************/
//require_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
//if($loglevel!=="OFF"){@require($_SERVER["DOCUMENT_ROOT"]."/core/functions/KLogger.php");}


$moduleflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');
$log->LogInfo("Got ".(__FILE__));

//require($_SERVER["DOCUMENT_ROOT"]."/core/functions/process_user_data.php");
$neededtable=process_data($_REQUEST['section'],20);
$rss_lang=process_data($_REQUEST['lang'],2);
if(!$rss_lang){$rss_lang="ru";}
if ($neededtable and $rss_lang=="ru"){$rsstitle="Раздел ".$neededtable." на сайте ";}
elseif(!$neededtable and $rss_lang=="ru"){$rsstitle="Новости всех разделов сайта ";}
elseif ($neededtable and $rss_lang=="en"){$rsstitle="News of ".$neededtable." on portal ";}
elseif(!$neededtable and $rss_lang=="en"){$rsstitle="News of all sections on portal ";}

if($rss_choosedomain=="Доменное имя, на которое пришел запрос"){$rss_sitedomainname=$_SERVER['HTTP_HOST'];}
else{$rss_sitedomainname=$sitedomainname;}
header("content-type: application/rss+xml");
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