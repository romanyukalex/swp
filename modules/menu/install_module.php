<?php
 /****************************************************************
  * Snippet Name : menu (install part)	              					 * 
  * Scripted By  : RomanyukAlex		           					           * 
  * Website      : http://popwebstudio.ru	   					           * 
  * Email        : admin@popwebstudio.ru     					           * 
  * License      : GPL (General Public License)					         * 
  * Purpose 	 : installation of module						               *
  * Access		 : include									 	                     *
  ***************************************************************/

if ($nitka=="1"){  
if ($moduleinstalled['menu']!=='y'){ #Требуется инсталляция

	//@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	$structures['Menu Table']="CREATE TABLE `$tableprefix-menus` (
  `rawid` int(4) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(20) NOT NULL COMMENT 'Название меню, к которому относится пункт',
  `menuposition` int(3) NOT NULL,
  `link` varchar(100) DEFAULT '/',
  `title_ru` varchar(100) NOT NULL DEFAULT 'Новый пункт',
  `title_en` varchar(100) NOT NULL DEFAULT 'New item',
  `page` varchar(20) DEFAULT NULL COMMENT 'При таком page пункт становится активным',
  `addclasstoli` text COMMENT 'Добавить класс к <li>',
  `addclasstoa` text COMMENT 'Добавить класс к <a>',
   `jsonclick` text,
  `onlyforrole` text COMMENT 'Пункт вставляется только для роли',
  `onlyforgroup` text COMMENT 'Пункт вставляется только для участников группы',
  `status` enum('enabled','disabled','not_ready') NOT NULL DEFAULT 'not_ready' COMMENT '????????? ??????',
  PRIMARY KEY (`rawid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
// Активный класс и Дефолт меню как настроечный параметр
$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`) VALUES 
(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
 (NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');";

}
}//nitka ?>