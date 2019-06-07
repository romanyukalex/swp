<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module("modulename")			 	 *
  ***************************************************************/
    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	# $module_id - id модуля
	
	/*
	
	Инсталляционные действия
	
	$put_table_structure=mysql_query("CREATE TABLE `$moduletableprefix-sometable` (....);
	
	DROP TABLE IF EXISTS `freecon-names`;
CREATE TABLE IF NOT EXISTS `freecon-names` (
  `name_id` int(11) NOT NULL COMMENT 'ID',
  `name_ru` int(11) DEFAULT NULL COMMENT 'Имя на русском',
  `name_en` text,
  `gender` enum('male','female','-') NOT NULL COMMENT 'Пол',
  `contry_id` int(11) DEFAULT NULL COMMENT 'Какой стране преимущественно принадлежит имя'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Имена';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `freecon-names`
--
ALTER TABLE `freecon-names`
  ADD PRIMARY KEY (`name_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `freecon-names`
--
ALTER TABLE `freecon-names`
  MODIFY `name_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
	
	
	
	
	$put_page=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, 'change_password', NULL, 0, 1)");
	
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'fill_all_required', 'Не заполнены все поля при смене пароля', 'Пожалуйста, заполните все обязательные поля', 'Please, fill all required fields'),
		(NULL, '$modulename', 'new_passes_not_equal', 'Присланные пароли не совпадают', 'Присланные пароли не совпадают', 'The new passwords are not equal')
		;");
	
	$put_siteconfig=mysql_query("INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
		(NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');");

	*/
	
}
?>