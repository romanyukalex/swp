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
	
	
$put_table_structure1=mysql_query("CREATE TABLE `$moduletableprefix-formgenerator-fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` text NOT NULL,
  `ordernum` int(11) DEFAULT NULL COMMENT 'Порядок следования',
  `field_table` text COMMENT 'Из какой таблички поле',
  `id_field_name` text COMMENT 'Название поля с уникальным ID в таблице field_table',
  `field_name` text NOT NULL COMMENT 'Какое поле в табличке',
  `field_type` enum('button','checkbox','color','date','datetime','datetime-local','email','file','hidden','image','month','number','password','radio','range','reset','reset','submit','tel','text','time','url','week','-','SELECT') DEFAULT '-' COMMENT 'Если не указано, берется тип поля filed_col из таблицы field_table и это преимущественно в использовании',
  `field_label_ru` text,
  `field_label_en` text,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `enum_vars_texts_ru` text COMMENT 'Тексты вариантов enum в форме',
  `enum_vars_texts_en` text COMMENT 'Тексты Enum-вариантов на EN',
  `input_pattern` text COMMENT 'Регулярное выражение для pattern',
  `static_value` text COMMENT 'Статическое значение формы',
  `script` text COMMENT 'Поле генерируется и обрабатывается скриптом',
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Таблица с полями формы Formgenerator';");
	
	
$put_table_structure2=mysql_query("CREATE TABLE `$moduletableprefix-formgenerator-forminfo` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` text NOT NULL,
  `buttontext` text CHARACTER SET utf8 COMMENT 'Текст кнопки',
  `button_class` text COMMENT 'Класс на кнопке',
  `JSonSubmit` text CHARACTER SET utf8,
  `script_after_add` text COMMENT 'Скрипт, который запустится после добавления нового элемента формы',
  `script_after_edit` text COMMENT 'Скрипт, запускаемый после обработки данных действия EDIT',
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Таблица с информацией о формах';");
	
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
	(NULL, 'form_generator', 'action_is_not_found', 'Сообщение AJAX о невозможности найти требуемое действие над формой', 'Действие не найдено', 'Action is not found'),
	(NULL, 'form_generator', 'add_is_complete', 'Сообщение AJAX об успешной обработке формы (добавление)', 'Вы успешно зарегистрированы. Наш менеджер перезвонит Вам по указанному номеру как только это будет возможно.', 'Added successfully'),
	(NULL, 'form_generator', 'add_is_not_complete', 'Сообщение AJAX об неуспешной обработке формы (добавление)', 'Невозможно добавить данные', 'Cant add your data'),
	(NULL, 'form_generator', 'edit_is_complete', 'Сообщение AJAX об успешной обработке формы (исправление)', 'Успешно обновлено', 'Edited successfully'),
	(NULL, 'form_generator', 'edit_is_not_complete', 'Сообщение AJAX об неуспешной обработке формы (исправление)', 'Невозможно обновить данные', 'Cant edit your data'),
	(NULL, 'form_generator', 'form_is_not_found', 'Сообщение AJAX о невозможности найти требуемое действие над формой', 'Форма не найдена', 'Form is not found');");
	/*
	
	Инсталляционные действия
	
	
	$put_pages=mysql_query("INSERT INTO `$tableprefix-pages`(`page`, `pagetitle`, `folder`, `filename`, `ext`, `pagebody`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	('change_password_page', 'Изменение пароля', NULL, NULL, NULL, NULL, '$modulename', NULL, 0, 1)");
	
	$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
		(NULL, '$modulename', 'code1', 'Смысл сообщения 1', 'Сообщение на русском 1', 'Message text 1'),
		(NULL, '$modulename', 'code2', 'Смысл сообщения 2', 'Сообщение на русском 2', 'Message text 2'),
		(NULL, '$modulename', 'code3', 'Смысл сообщения 3', 'Сообщение на русском 3', 'Message text 3')		
		;");
		
	$put_settings=mysql_query("INSERT INTO `$tableprefix-siteconfig` 
	(`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES 
	(NULL, 'Показывать', '2', 'После успешной активации показывать ли пользователю его активационные данные (емейл,телефон)', 'usrcntctafteractiv', NULL, 'Показывать;;Не показывать', '1', NULL, 'design', '1', '$module_id');");
	
	*/
	
}
?>