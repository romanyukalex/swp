<? $log->LogInfo('Got platform_header');
?>
<!-- Platform scripts-->
<?

if($ampreq==1) {  // Параметр из /core/fromget_amp.php
// Это AMP страница
?>
<meta charset="utf-8">
<link rel="canonical" href="<?
#Формируем url полной страницы (без AMP)
$canonic_uri_fin= 'https://'.$_SERVER['SERVER_NAME'].'/';
//Очищаем
$canonic_uri=str_replace("AMP=1","",$_SERVER['QUERY_STRING']); 

if(function_exists('mb_strlen')) $can_url_lenght=mb_strlen($canonic_uri);
else $can_url_lenght=strlen($canonic_uri);
if($can_url_lenght>0){
	if(mb_substr($canonic_uri,0,1)=="&") $canonic_uri_fin.= '/?'. mb_substr($canonic_uri,1);
	else $canonic_uri_fin.= "?".$canonic_uri;
	}
if(mb_substr($canonic_uri_fin,strlen($canonic_uri_fin)-1,1)=="&"){$canonic_uri_fin=mb_substr($canonic_uri_fin,0,-1);}
echo $canonic_uri_fin;
?>">

<script type="application/ld+json">
  {
	"@context": "http://schema.org",
	"@type": "NewsArticle",
	
	"headline": "<?if($page and $pagequery['SEO-title_'.$language]) echo $pagequery['SEO-title_'.$language];else {echo $title;}?>",
	"description": "<?if($page and $pagequery['SEO-descrtn_'.$language]) echo $pagequery['SEO-descrtn_'.$language]; else echo $description; ?>",
	"name": "<?if($page and $pagequery['SEO-title_'.$language]) echo $pagequery['SEO-title_'.$language];else {echo $title;}?>",
	"url": "<?=$canonic_uri_fin?>",
	  "mainEntityOfPage":{
		"@type":"WebPage",
		"@id":"<?=$canonic_uri_fin?>"
	  },
	  "thumbnailUrl": "<?=$pagequery['page_img']?>",
	  "dateCreated": "<?
	  $upldt = strftime("%Y-%m-%dT%H:%M:%SZ",strtotime($pagequery['creation_date']));
	  echo $upldt;?>",
	  "datePublished": "<?=$upldt;?>",
	  "dateModified": "<?=$upldt;?>",
	  "author": {
		"@type": "Organization",
		"name": "<?=$sitedomainname?>"
	  },
	  "publisher": {
		"@type": "Organization",
		"name": "<?=$sitedomainname?>",
		"logo": {
		  "@type": "ImageObject",
		  "url": "<?='https://'.$_SERVER['SERVER_NAME'].$logofile?>",
		  "width": 302,
		  "height": 60
		}
	  },
	  "image": {
		"@type": "ImageObject",
		"representativeOfPage": "true",
		"url": "<?=$pagequery['page_img']?>",
		"width": 1200,
		"height": 630
	  }
  }
</script>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<? } else { # Это не AMP страница
	?><meta http-equiv="content-type" content="text/html; charset=utf-8;charset=utf-8" />
	<META HTTP-EQUIV="expires" CONTENT="<?=date("D, d M Y H:i:s");?> GMT">
	<? if($pagequery['is_articles']==1){// Нужна сслыка на страницу AMP?>
	<link rel="amphtml" href="https://<?=$_SERVER['SERVER_NAME'].'/?'.$_SERVER['QUERY_STRING'].'&AMP=1';?>"><? 
	}
}

if($pagequery['meta']){
	$pagemeta=explode(";",$pagequery['meta']);
	foreach ($pagemeta as $metadata){
		$meta=explode(':',$metadata);
		?><meta name="<?=$meta[0]?>" content="<?=$meta[1]?>"/><?
		if($meta[0]=="Document-state") $meta_shown['Document-state']=1;
	}
}
?>
<META NAME="Keywords" CONTENT="<?
if($page and $pagequery['SEO-keywds_'.$language]) echo $pagequery['SEO-keywds_'.$language];
else echo $keywords;?>">
<META NAME="URL" CONTENT="<?=$_SERVER['SERVER_NAME']; ?>">
<META NAME="Author" CONTENT="<?=$autormeta; // Сделать: если есть page и у него есть autor то подсосать данные по юзеру и вставлять сюда. И настройка, делать ли так?>">
<META name="copyright" content="<?=$meta_copyright;?>">
<META NAME="description" CONTENT="<?if($page and $pagequery['SEO-descrtn_'.$language]) echo $pagequery['SEO-descrtn_'.$language]; else echo $description; ?>" />
<? if(!$meta_shown['Document-state']){?>
<META NAME="Document-state" CONTENT="<? if($pagequery){ if(!mb_strstr($pagequery['filename'],".php")){?>Static<?} else {?>Dinamic<?}}?>">
<? }?>
<META NAME="Resource-type" CONTENT="document">
<? if($pagequery['SEO_robot_index'] and !$adminpanel){?><meta name=“robots” content=“<?=$pagequery['SEO_robot_index']?>”><?}
elseif($adminpanel==1){?><meta name=“robots” content=“noindex,nofollow”><?}?>
<meta name="viewport" content="width=device-width<? if($ampreq){?>,minimum-scale=1<?}?>,initial-scale=1">
<? if($meta_titude){$meta_titude_data=explode(",",$meta_titude);
?><meta property="place:location:latitude" content="<?=$meta_titude_data[0]?>"/>
<meta property="place:location:longitude" content="<?=$meta_titude_data[1]?>"/><?
}
/*
<meta property="business:contact_data:street_address" content="Название улицы"/>
<meta property="business:contact_data:locality" content="Город"/>
<meta property="business:contact_data:postal_code" content="Индекс"/>
<meta property="business:contact_data:country_name" content="Страна"/>
*/?>
<meta property="business:contact_data:phone_number" content="<?=$contactphone?>"/>
<meta property="business:contact_data:email" content="<?=$officialemail?>"/>
<meta property="business:contact_data:website" content="<?=$_SERVER['SERVER_NAME']; ?>"/>
<? if(!$ampreq){?><!-- Активация ClearType в Mobile IE -->
<meta http-equiv="cleartype" content="on"><?}?>
<? if($meta_appl_fscr=='Открывать в полном экране'){?>
<!-- Чтобы приложение открылось в полноэкранном режиме, без видимой адресной строки -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<? }?>
<title><?if($page and $pagequery['SEO-title_'.$language]) echo $pagequery['SEO-title_'.$language];else {if($adminpanel)echo 'Администраторская панель '.$sitedomainname;else echo $title;}?></title>
<? insert_module('rss');
# link с языком
if(function_exists('mb_strlen')) $urilenght=mb_strlen($_SERVER['REQUEST_URI']);
else $urilenght=strlen($_SERVER['REQUEST_URI']);
if($language=='ru' and $pagequery['pagetitle_en']){?>
<link title="English" type="text/html" rel="alternate" hreflang="en" href="<?
	$langjustchanged=strpos($_SERVER['REQUEST_URI'],'lang=');
	if($langjustchanged!== false){ // Только сменили язык на русский
		if ($urilenght==9){// Содержится только переменная lang
			echo '/?lang=en';
		}
		else {// Только сменили язык, были не в корне сайта
			echo substr($_SERVER['REQUEST_URI'],0,-8).'&lang=en';
		}
	}
	else { // Просто ходят, не меняли только что язык
		if($_SERVER['REQUEST_URI']!=='/') echo $_SERVER['REQUEST_URI'].'&lang=en';
		else echo '/?lang=en';
	}?>" lang="en" <? if(!$ampreq){?> xml:lang="en"<?}?> />
<? }
elseif($language=='en' and $pagequery['pagetitle_ru']){// Язык страницы английский?>
	<link title="Русский" type="text/html" rel="alternate" hreflang="ru" href="<?
	$langjustchanged=strpos($_SERVER['REQUEST_URI'],'lang=');
	if($langjustchanged!== false){ // Только сменили язык на русский


		if ($urilenght==9){// Содержится только переменная lang
			echo '/?lang=ru';
		}
		else {// Только сменили язык, были не в корне сайта
			echo substr($_SERVER['REQUEST_URI'],0,-8).'&lang=ru';
		}
	}
	else { // Просто ходят, не меняли только что язык
		if($_SERVER['REQUEST_URI']!=='/') echo $_SERVER['REQUEST_URI'].'&lang=ru';
		else echo '/?lang=ru';
	}?>" lang="ru" xml:lang="ru" />
<?}
#Указатель текущего языка
?><META http-equiv="content-language" content="<?
if($language=='ru'){echo "ru";}
else {echo "en";}
?>"/>
<link type="image/x-icon" rel="shortcut icon" href='<?=$favicon_shortcut_path?>'/>

<? if(!$ampreq){ #Если это не AMP страница?>


	<link rel="stylesheet" type="text/css" media="all" href="/style/style.php<?if(isset($adminpanel)){?>?adminpanel=1<?}?>" />
	<? # JQuery
	if ($takejquery=='Ссылка на сервер Google'){?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<? } elseif($takejquery=='Ссылка на портал JQuery'){?>
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<? }elseif($takejquery=='Локальный файл /js/lib/jquery/jquery.min.js'){?>
	<script src="/js/lib/jquery/jquery.min.js"></script>
	<? }
	?><!--script>
	// This makes sure there's no conflict between libraries.
	jQuery.noConflict();
	</script--><?
	# JQuery-UI
	if ($takejqueryui=='Ссылка на сервер Google'){?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<? } elseif($takejqueryui=='Ссылка на портал JQuery'){?>
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/black-tie/jquery-ui.css"  type="text/css"/>
	<? }elseif($takejqueryui=='Локальные файлы в /js/lib/jquery-ui/'){?>
	<script src="/js/lib/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="/js/lib/jquery-ui/jquery-ui.css"  type="text/css"/>
	<? }
	if($takejqueryui!=='Не вставлять'){?><script>$(function() {$( document ).tooltip();});</script><? }//Активируем jquery-ui
	# JQueryMobile
	if ($takejquerymob=='Ссылка на сервер Google'){?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
	<? } elseif($takejquerymob=='Ссылка на портал JQuery'){?>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"  type="text/css"/>
	<? }elseif($takejquerymob=='Локальные файлы в /js/lib/jquery-mob/'){?>
	<script src="/js/lib/jquery-mob/jquery.mobile.min.js"></script>
	<link rel="stylesheet" href="/js/lib/jquery-mob/jquery.mobile.css"  type="text/css"/>
	<? }

	# Если вставляем bootstrap в header
	if($takebootstrap_where=='В header страницы') {
	# Bootstrap
	if($takebootstrap=='Ссылка на портал bootstrapcdn.com'){?>
	<!-- Latest compiled and minified CSS -->
	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"-->
	<!--Flexible-->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap-flex.min.css" rel="stylesheet" >
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<? }elseif($takebootstrap=='Локальные файлы из /js/lib/bootstrap/'){?>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/js/lib/bootstrap/css/bootstrap.min.css" type="text/css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="/js/lib/bootstrap/js/bootstrap.min.js"></script>
	<? }
	}


	//if(isset($adminpanel)){?>
	<script type="text/javascript" src="/js/platformscripts.php?<?if(isset($adminpanel)){?>adminpanel=1&<?}?>"></script>
	<?//}
	//if($enablegooglecount!=='Не включать') insert_module('counter-googleanalytics');
	//insert_module('counter-liveinternet');
	//insert_module('counter-yandex'); 

	unset($meta_shown);
}?>
	<!-- // Platform scripts-->
	<!-- Modules headers-->
	<? foreach($moduleenabled as $modulename=>$enabled){
		$module_header=null;
		# Читаем конфиг модуля
		if (is_readable($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.module_header.php')) {#Шапка модуля в папке проекта
			?><!-- Header for <?=$modulename?> -->
			<? include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/modules_data/'.$modulename.'.module_header.php');
			?><!-- // Header for <?=$modulename?> -->
			<? if($mode=='debug') $log->LogDebug('Module header is in /project/'.$projectname.'/modules_data/');
		} elseif (is_readable($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/module_header.php')) {#Конфиг модуля общий
			?><!-- Header for <?=$modulename?> -->
			<? include($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/module_header.php');
			?><!-- // Header for <?=$modulename?> -->
			<? if($mode=='debug') $log->LogDebug('Module header is in /modules/'.$modulename.'/');
		}
	}

?>
<!-- // Modules headers-->