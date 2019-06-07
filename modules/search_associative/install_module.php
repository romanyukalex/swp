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
$log->LogDebug('Got this file');
if ($moduleinstalled["$modulename"]!=='y' and $nitka=='1'){ #Требуется инсталляция
	
	# $module_id - id модуля
	
	/*
	
	Инсталляционные действия
	
	$structures['Some Table']="CREATE TABLE `$moduletableprefix-sometable` (....)";
	
	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, '$modulename', NULL, NULL, '$modulename', NULL, '0', '1');";
	
	
	$DBdata['Adding module messages']="INSERT into `$tableprefix-messages`( `message_id`,`module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
		(NULL, '$modulename', 'fill_all_required', 'Не заполнены все поля при смене пароля', 'Пожалуйста, заполните все обязательные поля', 'Please, fill all required fields',NULL),
		(NULL, '$modulename', 'new_passes_not_equal', 'Присланные пароли не совпадают', 'Присланные пароли не совпадают', 'The new passwords are not equal', NULL)
		;";
	
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`,`module_id`) VALUES 
		(NULL, 'selected', '1', 'Класс для активного LI в списке menu', 'liactiveclass', '20', NULL, '1', 'selected', 'design', '1','$moduleid'),
		(NULL, 'main', '1', 'Меню по-умолчанию (если не указано явно)', 'defaultmenu', NULL, NULL, '1', NULL, 'system', '1','$moduleid');";

		
		CREATE TABLE `freecon-associative-main` (
  `wid` int(11) NOT NULL COMMENT 'Just row id',
  `word` varchar(44) NOT NULL,
  `assoc` varchar(44) NOT NULL,
  `pos_tag` enum('NOUN','ADJ','VERB','ADVERB','NO_TAG','PHRASE') DEFAULT NULL,
  `dir` enum('BIDIR','DIR','REV') NOT NULL COMMENT 'Direction - to one side or bi-sided',
  `weight` decimal(10,4) NOT NULL,
  `mirror_weight` decimal(10,4) NOT NULL,
  `is_safe` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `freecon-associative-main`
--
ALTER TABLE `freecon-associative-main`
  ADD PRIMARY KEY (`wid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `freecon-associative-main`
--
ALTER TABLE `freecon-associative-main`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Just row id';
COMMIT;
		
		
	*/
	#Установка слов в БД
	$handle = fopen(dirname(__FILE__)."/assoc.csv", "r");
	if ($handle) {
	$n=0;
   
   while (($buffer = fgets($handle, 4096)) !== false) {
		//$n++;
        $row=explode (";",$buffer);
		//echo '<br>is - '.$row[6];
		
		mysql_query("INSERT INTO `$tableprefix-associative-main` ( `word`, `assoc`, `pos_tag`, `dir`, `weight`, `mirror_weight`, `is_safe`) VALUES 
		( '".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[3]."', '".$row[4]."', '".$row[5]."', '".mb_substr($row[6],0,1)."');");
		//if($n==30) exit();
	}
    fclose($handle);
}
	
}
?>