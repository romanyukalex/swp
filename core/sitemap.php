<?
/*****************************************************************************************************************************
  * Snippet Name : sitemap	        																						 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru  					 														 	     *
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Создаёт массив сообщений портала, выгружая данные из БД													 *
  * Using		 : For robots																								 *
  ***************************************************************************************************************************/
$sitemapflag=1;
include($_SERVER['DOCUMENT_ROOT'].'/core/start_platform_scripts.php');

if (mb_strstr($_SERVER['REQUEST_URI'],"part")){
	// Для обращений вроде - https://psy-space.ru/sitemap.part133.xml
	readfile($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$_SERVER['HTTP_HOST'].'.'.mb_substr($_SERVER['REQUEST_URI'],13,-4).'.sitemap.xml'); //psy-space.ru.133.sitemap.xml
}
else readfile($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$_SERVER['HTTP_HOST'].'.'.'sitemap.xml');
?>