<?php
 /****************************************************************
  * Snippet Name : newsblock (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : insert_module("newsblock")				 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($moduleinstalled['newsblock']!=='y' and $nitka=="1"){ #Требуется инсталляция

	global $tableprefix, $dbconnconnect;
	$moduleinstallquery=mysql_query("CREATE TABLE IF NOT EXISTS `$moduletableprefix-news` (
	`newsid` int(11) NOT NULL AUTO_INCREMENT,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`newsdate` date NOT NULL,
	`newstitle` varchar(200) CHARACTER SET utf8 NOT NULL,
	`fulltext` text CHARACTER SET utf8 NOT NULL,
	`news_photo_id` int(6) DEFAULT NULL COMMENT 'Фотография к новости из таблицы photos',
	`section` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Название раздела, сгенерировавшего новость (для RSS)',
	`autor_id` int(5) DEFAULT NULL COMMENT 'ID пользователя, опубликовавшего новость',
	PRIMARY KEY (`newsid`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;", $dbconnconnect);
	if ($moduleinstallquery){
		# Тестовая новость
		mysql_query("INSERT INTO `$moduletableprefix-news` (`newsid` ,`date` ,`newsdate` ,`newstitle` ,`fulltext`)VALUES (NULL ,CURRENT_TIMESTAMP , CURRENT_DATE( ) , 'Тестовая новость', 'Тестовая новость');");
		
		# Добавление страницы с новостями
		mysql_query("INSERT INTO `$tableprefix-pages` (`page_id` ,`page` ,`folder` ,`filename` ,`ext` ,
		`pagetitle` ,`exceptionsscript` ,`canbechanged` )
		VALUES (NULL , 'news', '/modules/newsblock/', 'start_script', 'php', 'Новости и события', '0', '1');");
		/*
		(`page_id`, `page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES (NULL, 'news2', 'Новости и события', NULL, NULL, NULL, NULL, 'newsblock', NULL, '0', '1');
		*/
		mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
		(NULL, '10', '1', 'Количество новостей, размещенных на одной странице НОВОСТИ И СОБЫТИЯ', 'newsonpage', '3', NULL, '1', '15', 'user', '1', '$moduleid'),
		(NULL, '5', '1', 'Количество новостей, размещенных на Главной странице', 'newsonmain', '3', NULL, '1', '15', 'user', '1', '$moduleid'),
		(NULL, 'По убыванию даты', '2', 'Порядок вывода новостей на главной', 'newonmainorder', NULL, 'По убыванию даты;;По возрастанию даты', '1', 'По убыванию даты', 'user', '1', '$moduleid'),
		(NULL, 'По убыванию даты', '2', 'Порядок вывода новостей на странице НОВОСТИ И СОБЫТИЯ', 'newonpageorder', NULL, 'По убыванию даты;;По возрастанию даты', '1', 'По убыванию даты', 'user', '1', '$moduleid')
		;");	
	}
}
?>