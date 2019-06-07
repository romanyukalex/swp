<?php
 /*******************************************************************
  * Snippet Name : module header           						 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : insert module header into <head></head>		 	*
  * Access		 : include this script								*
  ******************************************************************/
$log->LogDebug('Got this file');
if ($nitka=="1"){
?>
<meta property="og:type" content="profile"/>
<meta property="profile:first_name" content="Имя"/>
<meta property="profile:last_name" content="Фамилия"/>
<meta property="profile:username" content="Ник"/>
<meta property="og:title" content="Название страницы"/>
<meta property="og:description" content="Описание"/>
<meta property="og:image" content="https://website.com/image250X250.png"/>
<meta property="og:url" content="http://www.site.com"/>
<meta property="og:site_name" content="Название сайта"/>
<meta property="og:see_also" content="http://www.website.com"/>
<meta property="fb:admins" content="Facebook_ID"/>
<? }?>