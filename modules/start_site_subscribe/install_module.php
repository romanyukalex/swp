<?php
 /****************************************************************
  * Snippet Name : module (install part)						 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : installation of module						 *
  * Access		 : just insert_module(modulename)			 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));    
if ($moduleinstalled['$modulename']!=='y' and $nitka=="1"){ #Требуется инсталляция
	
	
	/* 	Инсталляционные действия */
	
	
	$ssstableqry=mysql_query("CREATE TABLE `$moduletableprefix-start-site-subscribers` (
  `subscriber_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID подписчика',
  `email` text NOT NULL COMMENT 'Email для оповещения',
  `subscription_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время подписки на запуск портала',
  `domain` text COMMENT 'Доменное имя портала',
  PRIMARY KEY (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица подписчиков для оповещения о запуске портала в работ' AUTO_INCREMENT=1;");

	$sssmessagesqry=mysql_query("INSERT INTO `$tableprefix-messages` (`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`) VALUES 
	(NULL, 'start_site_subscribe', 'DB_issue', 'Сообщение о невозможности подписаться на оповещение о запуске портала', 'Извините, возникли проблемы с Базой Данных', 'Sorry, there is some database issue'),
	(NULL, 'start_site_subscribe', 'trying_failed', 'Сообщение при повторной попытке подписаться без перезапуска страницы', 'Извините, попытка не удалась, повторная подписка', 'Sorry, trying is failed'),
	(NULL, 'start_site_subscribe', 'email_already_exists', 'Емейл уже подписан на оповещение о запуске портала', 'Вы уже подписаны на оповещение', 'You already subscribed'),
	(NULL, 'start_site_subscribe', 'successfully_inserted', 'Сообщение об удачной подписке на оповещение о запуске портала', 'Мы уведомим Вас о запуске сайта по указанному e-mail', 'We let you know when site will start to work');");
	
	/*
	INSERT INTO `magicsol_docgen`.`docgen-siteconfig` (`id` ,
`value` ,
`vartype` ,
`describe` ,
`systemparamname` ,
`formmaxlegth` ,
`varpossible` ,
`showtositeadmin` ,
`example` ,
`depend` ,
`maybeempty` ,
`module_id` 
)
VALUES (NULL , 'aromanuk@mail.ru', '1', 'Оповещение о новом подписчике по емейл (ящик или оставить пустым)', 'newsubscrmailnotify', NULL , NULL , '1', NULL , 'user', '1', NULL 
);
	
	*/
	
	
	
	
}
?>