<?php
 /****************************************************************
  * Snippet Name : $modulename (install part)						 *
  * Scripted By  : RomanyukAlex		           					 *
  * Website      : http://popwebstudio.ru	   					 *
  * Email        : admin@popwebstudio.ru     					 *
  * License      : GPL (General Public License)					 *
  * Purpose 	 : installation of module						 *
  * Access		 : include									 	 *
  ***************************************************************/

$log->LogInfo('Got this file');
if ($moduleinstalled["$modulename"]!=='y' and $nitka=='1'){ #Требуется инсталляция

	$structures['Product Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-product` (
	`product_id` int(8) NOT NULL AUTO_INCREMENT,
	`product_vendor_id` int(11) DEFAULT NULL,
	`product_code` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
	`product_full_title_ru` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
	`product_full_title_en` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
	`product_short_title_ru` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
	`product_short_title_en` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
	`product_shortdescription_ru` text,
	`product_shortdescription_en` text,
	`product_full_description_ru` text,
	`product_full_description_en` text,
	`product_autor` int(6) DEFAULT NULL,
	`product_main_image` text COMMENT 'Main product image from $tableprefix-photo table',
	`status` enum('active','inactive','ready_to_start') NOT NULL DEFAULT 'ready_to_start' COMMENT 'Status of product',
	`tags` text COMMENT 'Tags of product for search',
	PRIMARY KEY (`product_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$structures['Product feature groups Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-product-featuregroups` (
	`fgraw_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Just raw id',
	`product_id` int(6) NOT NULL,
	`feature_id` int(4) NOT NULL,
	PRIMARY KEY (fgraw_id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	$structures['Product features Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-product-features` (
	`feature_id` int(4) NOT NULL AUTO_INCREMENT,
	`feature_title_ru` text CHARACTER SET utf8 NOT NULL,
	`feature_title_en` text CHARACTER SET utf8 NOT NULL,
	`showfeature` enum('on','off') NOT NULL DEFAULT 'on' COMMENT 'Status',
	`feature_description_ru` varchar(2000) CHARACTER SET utf8 NOT NULL,
	`feature_description_en` varchar(2000) CHARACTER SET utf8 NOT NULL,
	`feature_link` varchar(1000) CHARACTER SET utf8 NOT NULL,
	PRIMARY KEY (`feature_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
	
	
	$structures['Product variants Table']="CREATE TABLE `$moduletableprefix-product-variants` (
	`variant_id` int(11) NOT NULL AUTO_INCREMENT,
	`product_id` int(11) NOT NULL,
	`description_ru` varchar(3000) DEFAULT NULL,
	`description_en` varchar(3000) DEFAULT NULL,
	`product_group` text COMMENT 'Variant belons to product group',
	`creation_ts` timestamp NULL DEFAULT NULL COMMENT 'Timestamp of variant creation',
	`modification_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of last changing of the variant',
	`dependency_desc` text COMMENT 'The term describes the dependence on other products and options',
	`activation_string` text COMMENT 'The value is read by the activator and uses for deployment of necessary resourses',
	`is_public` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Is the information on the public version of the product (whether to place it in an unauthorized part of the site)',
	`Is_available` tinyint(1) NOT NULL DEFAULT '1',
	`is_custom` tinyint(1) NOT NULL DEFAULT '0',
	`Is_retired` tinyint(1) NOT NULL DEFAULT '0',
	`retirement_ts` timestamp NULL DEFAULT NULL,
	`charging_aligment` tinyint(1) DEFAULT NULL COMMENT 'Billing Product variant tied to the beginning of the calendar month or not',
	`charging_period_days` int(11) DEFAULT NULL COMMENT 'The duration of the rating period in days',
	`charging_period_months` int(11) DEFAULT NULL COMMENT 'The duration of the rating period in months (must be filled in or the field, or charging_period_days)',
	`is_charging_prepaid` tinyint(1) DEFAULT NULL COMMENT 'Is the product should paid at the beginning of the cycle (prepaid) or at the end (postpaid)',
	`price` decimal(10,2) NOT NULL COMMENT 'Product variant price (in currency units)',
	`currency` enum('RUB','USD','EUR','') DEFAULT NULL,
	`sla` text COMMENT 'link to the SLA, which is serviced by a variant',
	`provision_lead_time` text COMMENT 'Usual development time',
	`approval_workflow` text COMMENT 'Business process, on which there is approval of the service',
	`tags` text COMMENT 'The list of tags for the convenience of using the search',	
	PRIMARY KEY (`variant_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
	

	$structures['Vendors Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-product-vendors` (
	`vendor_id` int(6) NOT NULL AUTO_INCREMENT,
	`vendor_logo` int(6) DEFAULT NULL COMMENT 'id логотипа производителя из таблицы photos',
	`vendor_name_ru` varchar(100) CHARACTER SET utf8 NOT NULL,
	`vendor_name_en` varchar(100) CHARACTER SET utf8 NOT NULL,
	`vendor_domain_ru` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
	`vendor_domain_en` text CHARACTER SET utf8 COMMENT 'Website of vendor (EN)',
	`vendor_short_description_ru` text CHARACTER SET utf8,
	`vendor_short_description_en` text CHARACTER SET utf8,
	`vendor_description_ru` varchar(3000) CHARACTER SET utf8 DEFAULT NULL,
	`vendor_description_en` varchar(3000) CHARACTER SET utf8 DEFAULT NULL,
	`vendor_wiki_link_ru` text CHARACTER SET utf8 COMMENT 'Wikipedia link (RU)',
	`vendor_wiki_link_en` text CHARACTER SET utf8 COMMENT 'Wikipedia link (EN)',
	`vendor_country_id` int(3) DEFAULT NULL COMMENT 'country_id',
	 PRIMARY KEY (`vendor_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
	
	$structures['Subscriptions Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-subscriptions` (
	`subscription_id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`client_id` int(11) DEFAULT NULL COMMENT 'Company_ID',
	`subscription_group_id` int(11) DEFAULT NULL COMMENT 'Идентификатор группировки подписок (объединяет несколько подписок в рамках одного бандла), для всех отдельных подписок в рамках бандла равен subscription_id основной подписки на bundle',
	`product_variant_id` int(11) NOT NULL,
	`status` enum('idle','activationPending','active','suspentionPending','deactivatePending','inactive','suspended','resumePending','terminated') NOT NULL DEFAULT 'active',
	`creations_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`last_status_change_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp последнеднего изменения статуса',
	`charging_aligment` int(1) NOT NULL DEFAULT '2' COMMENT 'Тарификация в начале месяца.1-да, 2-нет.',
	`charging_period_days` int(11) DEFAULT NULL COMMENT 'Длительность тарификационного периода в днях',
	`charging_period_months` int(11) DEFAULT NULL COMMENT 'Длительность тарификационного периода в месяцах',
	`is_charging_prepaid` int(11) DEFAULT NULL COMMENT 'Подписка оплачивается.1-в начале месяца,else-в конце',
	`price` double NOT NULL COMMENT 'Цена',
	`currency` enum('RUB','USD','EUR','') NOT NULL COMMENT 'Валюта',
	 PRIMARY KEY (`subscription_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$structures['Orders Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-orders` (
	  `order_id` int(11) NOT NULL AUTO_INCREMENT,
	  `order_group` int(11) NOT NULL COMMENT 'For order of few products/variants in 1 order',
	  `user_id` int(11) NOT NULL,
	  `client_id` int(11) DEFAULT NULL COMMENT 'Company_ID',
	  `subscription_id` int(11) DEFAULT NULL COMMENT 'Using when order depended to subscription',
	  `status` enum('opened','droped','admin_suspended','resolved','inprogress','wait_user') NOT NULL DEFAULT 'opened',
	  `creations_ts` timestamp NULL DEFAULT NULL,
	  `product_variant_id` int(11) NOT NULL,
	  `order_type` enum('modify_subscription_request','subscription_request','company_creation_request','delete_subscription_request','halt_subscription_request','simple_order') NOT NULL,
	  `order_text` text,
	  `last_status_change_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `chat_id` int(11) DEFAULT NULL,
	  `sale_manager_id` int(11) DEFAULT NULL COMMENT 'ID of sale manager who sold this order',
	  `price` decimal(10,2) DEFAULT NULL COMMENT 'Price of this item'
	  PRIMARY KEY (`order_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Orders table';
	";
	
	
	$structures['Payments Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-payments` (
	  `payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'AI_ID',
	  `payment_agent` text NOT NULL,
	  `summ` decimal(10,0) NOT NULL COMMENT 'Summ',
	  `currency` enum('RUR','USD','EUR') DEFAULT 'RUR',
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of callback',
	  `order_id` int(11) DEFAULT NULL,
	  `user_id` int(11) DEFAULT NULL,
	  `details` text COMMENT 'Details of payment',
	  `IsTest` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is it test call? (0-no,1-yes)',
	  `pm_status` enum('new','processed','error','unknown') NOT NULL DEFAULT 'new' COMMENT 'Status of payment processing',
	   PRIMARY KEY (`payment_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Payments table for all payment agents';";
	
	$structures['Account Table']="CREATE TABLE IF NOT EXISTS `$moduletableprefix-account` (
	`ac_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ID строки';
	`user_id` int(5) NOT NULL,
	`company_id` int(11) DEFAULT NULL COMMENT 'If account is company account',
	`items` int(7) NOT NULL DEFAULT '0' COMMENT 'Счёт',
	`currency` text COMMENT 'В чем измеряется items',
	`comment` text COMMENT 'Комментарий',
	PRIMARY KEY (`ac_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Данные по счёту кастомера';";


  
	$DBdata['Adding siteconfig settings']="INSERT INTO `$tableprefix-siteconfig` (`id`, `value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`) VALUES
	(NULL, 'Показывать, если есть ссылка на Вики', '2', 'Ссылка на Википедию о производителе', 'show_vendor_wiki', NULL, 'Показывать, если есть ссылка на Вики;;Не показывать ссылку на Вики никогда', '1', NULL, 'system', '1', '$module_id'),
	(NULL , 'aromanuk@mail.ru', '1', 'Cписок емейлов для оповещения о заказе в магазине', 'modulenameordernotify', NULL , NULL , '1', 'testuser@gmail.com', 'user','1', '$module_id'),
	(NULL, 'show_product_list', '1', 'Действие по-умолчанию, если никакого действия не получено (полезно для стартовых страниц)', 'default_action', NULL, NULL, '1', NULL, 'user', '1', '$module_id'),
	(NULL, 'Показывать', '2', 'Показывать продукты производителя на его странице', 'products_on_vendorpage', NULL, 'Показывать;;Не показывать', '1', 'Показывать', 'design', '1', '$module_id');";

	$DBdata['Adding module pages']="INSERT INTO `$tableprefix-pages` (`page_id`, `page`, `pagetitle_ru`,`pagetitle_en`, `module_page`, `page_menu`, `exceptionsscript`, `canbechanged`) VALUES
	(NULL, '$modulename', NULL, NULL, '$modulename', NULL, '0', '1'),
	(NULL, 'my_orders', 'Ваши заказы', NULL, NULL, '$modulename', NULL, '0', '1')
	;";

	$DBdata['Adding module messages']="INSERT INTO `$tableprefix-messages` (`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`,`company_id`) VALUES
	(NULL, '$modulename', 'product_not_found', 'Не найден запрашиваемый (по ID) продукт', 'Неизвестный продукт', 'Unknown product', NULL),
	 (NULL ,  '$modulename',  'order_succ',  'Сообщение об удачном заказе варианта продукта', 'Заявка на подключение продукта принята',  'The order was created successfully', NULL),
	(NULL ,  '$modulename',  'order_unsucc',  'Заказ не добавлен, ошибка',  'Добавление заявки обработано неуспешно', 'Order was not created sucessfully', NULL),
	(NULL ,  '$modulename',  'us_remov_fr_group_success', 'Успешно удален пользователь из группы управления продуктом', 'Пользователь успешно удален из группы управления продуктом', 'The user was successfully removed from product management group', NULL),
	(NULL ,  '$modulename',  'mdfy_sbscr_ordr_succ_crtd', 'Успешно принята заявка на изменение подписки',  'Ваша заявка принята', 'Your request was created successfully', NULL),
	(NULL ,  '$modulename',  'variant_isnt_ch',  'Отправлен заказ, но не выбран вариант', 'Пожалуйста, выберите вариант предоставления услуги', 'Please choose one variant of the product', NULL),
	(NULL ,  '$modulename',  'variant_isnt_found', 'Пользователь выбрал вариант услуги, которого нет в базе (нештатный случай)', 'Запрашиваемый вариант продукта не найден',  'Requested variant is not found in database', NULL),
	(NULL ,  '$modulename',  'no_accss_users', 'Доступ к продуктам не предоставлен ни одному пользователю', 'Не предоставлен ни одному пользователю',  'Access is not provided to users', NULL),
	(NULL, '$modulename', 'right_add_error', 'Ошибка при добавлении прав пользователю на управление продуктом ', 'Ошибка при добавлении прав пользователю', 'Error. Rights were not added', NULL),
	(NULL, '$modulename', 'user_added_prodmanage_group', 'Пользователь успешно добавлен в группу управления продуктом', 'Пользователь успешно добавлен в группу управления продуктом', 'User was successfully added to product management group', NULL),
	(NULL, '$modulename', 'mdfy_sbscr_ordr_not_crtd', 'Заявка на изменение подписки обработана не успешно', 'Ваша заявка была обработана неуспено', 'Error. Your request was not created', NULL),
	(NULL, '$modulename', 'no_users_for_subcr_managemnt', 'Нет пользователей в компании для назначения им привилегий на управление подписками', 'Нет других пользователей в данной компании. Для управления привилегиями доступа к подпискам компании создайте новых пользователей в разделе \'Управление пользователями\'', 'There is no other users for privelege management', NULL),
	(NULL, '$modulename', 'my_orders_are_not_found', 'Заявки пользователя не найдены в БД', 'Ваши заявки не найдены', 'You have not an orders yet', NULL),
	(NULL, '$modulename', 'company_orders_are_not_found', 'Заявки других пользователей компании не найдены в БД', 'Заявки других пользователей компании не найдены', 'Orders of other users are not found', NULL)
	;";

}
?>