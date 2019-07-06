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
	
	
$put_table_structure1=mysql_query("CREATE TABLE `$moduletableprefix-$modulename-fields` (
 `field_id` int(11) NOT NULL,
  `form_name` text NOT NULL,
  `ordernum` int(11) DEFAULT NULL COMMENT 'Порядок следования',
  `field_type` enum('button','checkbox','color','date','datetime','datetime-local','email','file','hidden','image','month','number','password','radio','range','reset','reset','submit','tel','text','time','url','week','-','SELECT') DEFAULT 'text',
  `field_label_ru` text,
  `field_label_en` text,
  `required` enum('required','no_required') NOT NULL DEFAULT 'no_required' COMMENT 'Field is required?',
  `enum_vars_texts_ru` text COMMENT 'Тексты вариантов enum в форме',
  `enum_vars_texts_en` text COMMENT 'Тексты Enum-вариантов на EN',
  `input_pattern` text COMMENT 'Регулярное выражение для pattern, если поле типа tel',
  `static_value` text COMMENT 'Статическое значение поля'
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Таблица с полями формы Form_simple';");
	
	
$put_table_structure2=mysql_query("CREATE TABLE `$moduletableprefix-$modulename-forminfo` (
 `form_id` int(11) NOT NULL,
  `form_name` text NOT NULL,
  `form_title` text CHARACTER SET utf8,
  `buttontext` text CHARACTER SET utf8 COMMENT 'Текст кнопки',
  `button_class` text COMMENT 'Класс на кнопке',
  `script` text COMMENT 'Скрипт-обработчик, который запустится после проверки лементов формы',
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Таблица с информацией о формах';");
	
	
$put_messages=mysql_query("INSERT into `$tableprefix-messages`(`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES
(NULL, '$modulename', 'action_is_not_found', 'Сообщение AJAX о невозможности найти требуемое действие над формой', 'Действие не найдено', 'Action is not found'),
(NULL, '$modulename', 'add_is_complete', 'Стандартное ообщение AJAX об успешной обработке формы (добавление)', 'Вы успешно зарегистрированы. Наш менеджер перезвонит Вам по указанному номеру как только это будет возможно.', 'Added successfully'),
(NULL, '$modulename', 'add_is_not_complete', 'Стандартное сообщение в AJAX об неуспешной обработке формы (добавление)', 'Невозможно добавить данные', 'Cant add your data');");
	
}
?>