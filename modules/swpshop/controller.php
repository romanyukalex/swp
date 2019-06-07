<?php
 /**************************************************************\
  * Modulename	: swpshop					 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  \*************************************************************/
$log->LogInfo('Got this file');
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact=='show_product'){# Страничка с продуктом
		$product_id=process_data($_REQUEST['productid'],20);
		#Информация о вендоре
		
		$vendorinfo=mysql_fetch_assoc(mysql_query("select 
			`vendor_id` ,
			`vendor_logo`,
			`vendor_name_ru` ,
			`vendor_name_en` ,
			`vendor_domain_ru`,
			`vendor_domain_en`,
			`vendor_short_description_ru`,
			`vendor_short_description_en`,
			`vendor_description_ru`,
			`vendor_description_en`,
			`vendor_wiki_link_ru`,
			`vendor_wiki_link_en`,
			`vendor_country_id`
		from `$moduletableprefix-product` products, `$moduletableprefix-product-vendors` vendors
		where products.`product_vendor_id`=vendors.`vendor_id` and products.`product_id`='$product_id'"));
		#Информация о продукте
		$productinfo=mysql_fetch_assoc(mysql_query("select * from `$moduletableprefix-product` products
		where	products.`product_id`='$product_id';"));
		
		#Информация о фичах продукта
		$featuresinfo_q=mysql_query("SELECT * FROM `$moduletableprefix-product-features` f,`$moduletableprefix-product-featuregroups` fg WHERE f.`feature_id`=fg.`feature_id` AND fg.`product_id`=".$productinfo['product_id']." AND `showfeature`='on';");
		
		global $userrole;
		
		 ### Варианты продукта ###

		# Получаем все rights юзера по userid
		mysql_data_seek($userrightsreq,0);
		$variants_for_user='';
		while ($userrights=mysql_fetch_assoc($userrightsreq)){
			
			if ($userrights['table']=="$moduletableprefix-product-variants" and $userrights['grant']=='1') {
				$variants_for_user.='`variant_id`='.$userrights['oid'].' or ';
				}
		}
		if(!$variants_for_user==''){// Что то есть у пользователя личное в правах
			$variants_for_user='('.substr($variants_for_user,0,-4).') or';
		}

		# Запрос на получение вариантов
		//$productvarreq=mysql_query("select * from  `$moduletableprefix-product-variants` where	`product_id`='$product_id' and 	( $variants_for_user );");

		$productvarreq=mysql_query("select * from `$moduletableprefix-product-variants` where `product_id`='$product_id' and ( $variants_for_user  `is_public`=1 or `is_custom`=0) and `Is_available`=1 and `Is_retired`='0';");
		# Варианты, которые доступны всем, даже не авторизованным пользователям (is_public=1), и варианты, которые доступны всем авторизованным пользователям (is_custom=0)
				
				
				
		$varnumber=mysql_num_rows($productvarreq);
		
		if ($varnumber>1){
			while($productvar=mysql_fetch_assoc($productvarreq)){
				$price_arr[$productvar['variant_id']]=$productvar['price'];
			}
			$variant_min_price=min($price_arr);
			$variant_max_price=max($price_arr);
		}
		mysql_data_seek($productvarreq,0);
		
		
		$show_view='product';
	}
	elseif ($contact=='show_product_list'){ # Просмотр всех продуктов/сервисов
		if($_REQUEST['search_tag']) {//$tag_search=process_data($_REQUEST['search_tag'],100);
			$search_cond=" AND `tags` LIKE '%".process_data(urldecode($_REQUEST['search_tag']),100)."%'";
		}
		#Инфо по продуктам
		$productinforeq=mysql_query("select * from `$moduletableprefix-product` p,`$moduletableprefix-product-vendors` v WHERE
		p.`product_vendor_id`=v.`vendor_id` and p.`status`='active' 
		$search_cond
		ORDER BY `product_id` DESC;");
		
		#Инфо по вариантам (min и max цена)
		
		while($productinfo=mysql_fetch_assoc($productinforeq)){
			$var_q=mysql_query("select * from `$moduletableprefix-product-variants` WHERE  `product_id`='".$productinfo['product_id']."' AND `Is_available`='1' AND `is_public`='1';");
			while ($vars=mysql_fetch_assoc($var_q)){
				if(!$product_price[$productinfo['product_id']]['min']){//Первый в списке вариантов
					$product_price[$productinfo['product_id']]['min']=$vars['price'];
					$product_price[$productinfo['product_id']]['max']=$vars['price'];	
				} else { //Не первый, будем сравнивать
					if($vars['price']<$product_price[$productinfo['product_id']]['min']){$product_price[$productinfo['product_id']]['min']=$vars['price'];}
					if($vars['price']>$product_price[$productinfo['product_id']]['max']){$product_price[$productinfo['product_id']]['max']=$vars['price'];}
					
				}
			}
		}
		mysql_data_seek($productinforeq,0);
		$products_count=mysql_num_rows($productinforeq);
		$show_view='product_list';
	}
	elseif ($contact=='show_product_variants'){### Варианты продукта ### Пока не работает, непонятно почему
		$product_id=process_data($_REQUEST['productid'],20);

		//$productreq=mysql_query("select * from `$moduletableprefix-product` products where	products.`product_id`='$product_id';");
		$productinfo=mysql_fetch_assoc(mysql_query("select * from `$moduletableprefix-product` products
		where	products.`product_id`='$product_id';"));
		$vendorinfo=mysql_fetch_assoc(mysql_query("select 
		`vendor_id` ,
		`vendor_logo`,
		`vendor_name_ru` ,
		`vendor_name_en` ,
		`vendor_domain_ru`,
		`vendor_domain_en`,
		`vendor_short_description_ru`,
		`vendor_short_description_en`,
		`vendor_description_ru`,
		`vendor_description_en`,
		`vendor_wiki_link_ru`,
		`vendor_wiki_link_en`,
		`vendor_country_id`
		from `$moduletableprefix-product` products, `$moduletableprefix-product-vendors` vendors
			where products.`product_vendor_id`=vendors.`vendor_id` and products.`product_id`='$product_id'")); // Исправить: запрашивать просто по vendor ID и SELECT *
		$userrightsreq=mysql_query("SELECT DISTINCT * FROM 
		`$tableprefix-users` u, 
		`$tableprefix-users-groupmembers` gm,
		`$tableprefix-users-grouprights` gr
	WHERE
		u.`userid`=gm.`userid` and
		gr.`group_id`=gm.`group_id` and
		u.`userid`='$userid'
		");
		

		# Получаем все rights юзера по userid
		//mysql_data_seek($userrightsreq,0);
		$variants_for_user='';
		while ($userrights=mysql_fetch_array($userrightsreq)){
			if ($userrights['table']=="$moduletableprefix-product-variants" and $userrights['grant']=='1') {
				$variants_for_user.='`variant_id`='.$userrights['oid'].' or ';
				}
		}
		if(!$variants_for_user==''){// Что то есть у пользователя личное в правах
			$variants_for_user='('.substr($variants_for_user,0,-4).") or";
		}

		# Запрос на получение вариантов
		
		$productvarreq=mysql_query("select * from `$moduletableprefix-product-variants` where `product_id`='$product_id' and ( $variants_for_user  `is_public`=1 or `is_custom`=0) and `Is_available`=1 and `Is_retired`='0';");
		# Варианты, которые доступны всем, даже не авторизованным пользователям (is_public=1), и варианты, которые доступны всем авторизованным пользователям (is_custom=0)
		
		
				
				
		$varnumber=mysql_num_rows($productvarreq);
		
		if ($varnumber>1){
			while($productvar=mysql_fetch_assoc($productvarreq)){
				$price_arr[$productvar['variant_id']]=$productvar['price'];
			}
			$variant_min_price=min($price_arr);
			$variant_max_price=max($price_arr);
		}
		
		mysql_data_seek($productvarreq,0);
		
		$show_view='product_variants';
	}
	elseif ($contact=='show_subscriptions'){
		
		global $company_id,$userrole,$userrightsreq;
		if(isset($userrole) and $userrole!=='guest'){
			$subscriptionslist_qt="SELECT * FROM `$moduletableprefix-subscriptions` WHERE `client_id`='$company_id' and `status`!='inactive' order by `creations_ts` desc ";
			$subscriptionslistreq=mysql_query($subscriptionslist_qt);
			$subscriptionslistlength=mysql_num_rows($subscriptionslistreq);
			if($subscriptionslistlength>0){
				$log->LogDebug($subscriptionslistlength.' subcriptions found');
				
				while ($subscriptionslist=mysql_fetch_array($subscriptionslistreq)){
					$variantdetailqrytext.="`variant_id`='$subscriptionslist[product_variant_id]' or ";
				}
				$variantdetailqrytext=substr($variantdetailqrytext,0,-4);
				$productvarreq=mysql_query("select * from  `$moduletableprefix-product-variants` var,`$moduletableprefix-product` pr
				where ($variantdetailqrytext) and  pr.`product_id`=var.`product_id`;");
				unset($variantdetailqrytext);
				while ($productvariant=mysql_fetch_array($productvarreq)){
					$vardescription[$productvariant['variant_id']]=$productvariant['description_'.$language];
					$varproductfulltitle[$productvariant['variant_id']]=$productvariant['product_full_title_'.$language];
					$parproductid[$productvariant['variant_id']]=$productvariant['product_id'];
				}
				# Запрос номеров групп управления продуктом, к которым есть доступ у данного юзера
				$manageproductreq=mysql_query("SELECT `group_id` FROM `$tableprefix-users-groups` WHERE `groupname` LIKE '%product%' and `groupname` LIKE '%manage%' and `groupname` LIKE '%company$company_id%' and `onoff`='on'");
				// Группы дозволенных продуктов
				while ($manageproduct=mysql_fetch_array($manageproductreq)){
					$managedproductgroups[$manageproduct['group_id']]=1; 
				}
				# Запрос номеров групп управления подписками компании, к которым есть доступ у данного юзера
				$managesubscriptionreq=mysql_query("SELECT `group_id` FROM `$tableprefix-users-groups` WHERE `groupname` LIKE '%subscription%' and `groupname` LIKE '%manage%' and `groupname` LIKE '%company$company_id%' and `onoff`='on'");
				// Группы дозволенных подписок
				while ($managesubscription=mysql_fetch_array($managesubscriptionreq)){
					$managedsubscriptiongroups[$managesubscription['group_id']]=1; //echo $managesubscription['group_id'].'<br>';
				}

				mysql_data_seek($subscriptionslistreq,0);
			}else {
				$log->LogDebug('0 subcriptions found.'); 
			}
		} else {$log->LogDebug('Userrole is guest, subscriptions are not found');
		}
		
		$show_view='subscriptions';
	}
	elseif ($contact=='sh_subscript_manage'){ # Управление привилегиями пользователей по управлению подписками
		
		global $company_id,$userrole;
		
		if(isset($userrole) and $userrole!=='guest'){
			# Список подписок компании 
			
			$subscriptionslistreq=mysql_query("SELECT * FROM `$moduletableprefix-subscriptions` WHERE `client_id`='$company_id' order by `creations_ts` desc ");
			# Получаем информацию о вариантах
			$log->LogDebug('Got '.mysql_num_rows($subscriptionslistreq).' subscriptions for company_id='.$company_id);
			while ($subscriptionslist=mysql_fetch_array($subscriptionslistreq)){
				$variantdetailqrytext.="`variant_id`='$subscriptionslist[product_variant_id]' or ";
			}
			$variantdetailqrytext=substr($variantdetailqrytext,0,-4);
			$productvarreq=mysql_query("select * from  `$moduletableprefix-product-variants` var,`$moduletableprefix-product` pr
			where ($variantdetailqrytext) and  pr.`product_id`=var.`product_id`;");
			$log->LogDebug('Got '.mysql_num_rows($productvarreq).' variant(s) for these subscriptions');
			while ($productvariant=mysql_fetch_array($productvarreq)){ // Массив с информацией о вариантах
				$vardescription[$productvariant['variant_id']]=$productvariant['description'];
				$varproductfulltitle[$productvariant['variant_id']]=$productvariant['product_full_title_'.$language];
				$parproductid[$productvariant['variant_id']]=$productvariant['product_id'];
			}

			# Список всех пользователей компании
			$userlistreq=mysql_query("SELECT * FROM `$tableprefix-users` WHERE `company_id`='$company_id' and `userrole`='user'");
			$userlistcount=mysql_num_rows($userlistreq);// Число юзеров с ролью user в компании
			$log->LogDebug($userlistcount." users (with role='user') was found");
			if($userlistcount>0){
				# Список пользователей со всеми правами, чтобы узнать, кому даны права на доступ к управлению продуктами и подписками
				$useraccessreq=mysql_query("SELECT * FROM `$tableprefix-users` u,`$tableprefix-users-groups` g,`$tableprefix-users-groupmembers` gm WHERE u.`company_id`='$company_id' and u.`userrole`='user' and gm.`userid`=u.`userid` and gm.`group_id`=g.`group_id`;");
				echo 'Доступ ко всем подпискам продукта<br><br>';
				# Запрос номеров групп управления продуктом, к которым есть доступ у данной компании - переписать
				$manageproductreq=mysql_query("SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id`");

				while ($manageproduct=mysql_fetch_array($manageproductreq)){
					$productinforeqinfo.="`product_id`='$manageproduct[oid]' or ";
				}

				# Информация о продуктах у которых есть группа управления продуктом
				$productinforeqinfo=substr($productinforeqinfo,0,-4);
				$productinforeq=mysql_query("SELECT * FROM `$moduletableprefix-product` WHERE $productinforeqinfo;");
				while ($productinfo=mysql_fetch_array($productinforeq)){
					$productfulltitle[$productinfo['product_id']]=$productinfo['product_full_title_'.$language];
				}

				mysql_data_seek($manageproductreq,0);
			}
		}
		$show_view='subscript_rights_grant';	
	}
	elseif ($contact=='show_shoppingcart'){ # Заявки юзера и компании
		global $company_id,$userid,$userrole,$fullname;
		$order_list=null;
		if($userrole and $userrole!=='guest'){
			if($_SESSION['order_group']) { //Обновляем все заказы этого пользователя, назначаем ему userid
				mysql_query("UPDATE `$tableprefix-orders` SET `user_id`='".$userid."' WHERE `order_group`='".$_SESSION['order_group']."';");
			}
			
			
			$orderlistreq=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE `user_id`='$userid' AND `order_group`='".$_SESSION['order_group']."' order by `status` asc ,`creations_ts` desc");
			$orderlistlength=mysql_num_rows($orderlistreq);
			
			$log->LogDebug('Found '.$orderlistlength.' order(s) of this user');
			# Информация о вариантах
			while ($orderlist=mysql_fetch_array($orderlistreq)){
				$productvar[$orderlist['product_variant_id']]=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` prod,`$moduletableprefix-product-variants` var where var.`variant_id`='$orderlist[product_variant_id]' and var.`product_id`=prod.`product_id`;"));
				$order_list.=$orderlist['order_id'].';'; //Список заказов,нужный для обновления их статусов по ajax 
				$order_summ=$order_summ+$orderlist['price'];#Сумма цен заказа
			}
			mysql_data_seek($orderlistreq,0);
		}
		
		
		if ($userrole=='superuser'){
			$orderlist_su_req=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE `user_id`!='$userid' and `client_id`='$company_id' order by  `status` asc ,`creations_ts` desc ");
			$orderlist_su_length=mysql_num_rows($orderlist_su_req);
			$log->LogDebug('Found '.$orderlist_su_length.' order(s) of other users');
			while ($orderlist=mysql_fetch_array($orderlist_su_req)){
				# Информация о пользователях, кот заказали
				$userinfo[$orderlist['user_id']]=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `userid`='$orderlist[user_id]';"));
				# Информация о вариантах
				$productvar[$orderlist['product_variant_id']]=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` prod,`$moduletableprefix-product-variants` var where var.`variant_id`='$orderlist[product_variant_id]' and var.`product_id`=prod.`product_id`;"));
				$order_list.=$orderlist['order_id'].';'; //Список заказов,нужный для обновления их статусов по ajax 
			}
			mysql_data_seek($orderlist_su_req,0);
		}
		if($order_list){ // Отрезаем 1 символ ; 
			$order_list=substr($order_list,0,-1);
		}
		
			$show_view='shopping_cart';
	} elseif ($contact=='show_orders'){ # Заявки юзера и компании
		global $company_id,$userid,$userrole,$fullname;
		$order_list=null;
		if($userrole and $userrole!=='guest'){
			
			$orderlistreq=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE `user_id`='$userid' and `status` !='opened'
			order by `status` asc ,`creations_ts` desc");
			$orderlistlength=mysql_num_rows($orderlistreq);
			
			$log->LogDebug('Found '.$orderlistlength.' order(s) of this user');
			# Информация о вариантах
			while ($orderlist=mysql_fetch_array($orderlistreq)){
				$productvar[$orderlist['product_variant_id']]=mysql_fetch_assoc(mysql_query("select * from `$moduletableprefix-product` prod,`$moduletableprefix-product-variants` var where var.`variant_id`='$orderlist[product_variant_id]' and var.`product_id`=prod.`product_id`;"));
				$order_list.=$orderlist['order_id'].';'; //Список заказов,нужный для обновления их статусов по ajax 
				$order_summ=$order_summ+$orderlist['price'];#Сумма цен заказа??
			}
			mysql_data_seek($orderlistreq,0);
		}
		
		
		if ($userrole=='superuser'){
			$orderlist_su_req=mysql_query("SELECT * FROM `$tableprefix-orders` WHERE `user_id`!='$userid' and `client_id`='$company_id' order by  `status` asc ,`creations_ts` desc ");
			$orderlist_su_length=mysql_num_rows($orderlist_su_req);
			$log->LogDebug('Found '.$orderlist_su_length.' order(s) of other users');
			while ($orderlist=mysql_fetch_array($orderlist_su_req)){
				# Информация о пользователях, кот заказали
				$userinfo[$orderlist['user_id']]=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE `userid`='$orderlist[user_id]';"));
				# Информация о вариантах
				$productvar[$orderlist['product_variant_id']]=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product` prod,`$moduletableprefix-product-variants` var where var.`variant_id`='$orderlist[product_variant_id]' and var.`product_id`=prod.`product_id`;"));
				$order_list.=$orderlist['order_id'].';'; //Список заказов,нужный для обновления их статусов по ajax 
			}
			mysql_data_seek($orderlist_su_req,0);
		}
		if($order_list){ // Отрезаем 1 символ ; 
			$order_list=substr($order_list,0,-1);
		}
		
		 $show_view='orders';
		
	}
	elseif ($contact=='show_vendors_list'){
		
		$vendorinforeq=mysql_query("select * from `$moduletableprefix-product-vendors` v, `$tableprefix-photos` ph, `$tableprefix-country` cnt where ph.`photo_id`=v.`vendor_logo` and cnt.`id`=`vendor_country_id`;");
		$vendor_list_length=mysql_num_rows($vendorinforeq);
		$log->LogDebug('Found '.$vendor_list_length.' vendor(s)');
		while($vendorinfo=mysql_fetch_array($vendorinforeq)){
			$productinforeq[$vendorinfo['vendor_id']]=mysql_query("select * from `$moduletableprefix-product` p,`$moduletableprefix-product-vendors` v where p.`product_vendor_id`=v.`vendor_id` and v.`vendor_id`='".$vendorinfo['vendor_id']."';");
			$vendproduct_count[$vendorinfo['vendor_id']]=mysql_num_rows($productinforeq[$vendorinfo['vendor_id']]);
			$log->LogDebug('Found '.$vendproduct_count[$vendorinfo['vendor_id']].' products(s) for vendor '.$vendorinfo['vendor_id']);
		}
		mysql_data_seek($vendorinforeq,0);
		$show_view='vendors_list';
		
	}
	elseif ($contact=='show_vendor'){
		$need_vendor_id=process_data($_REQUEST['vendor_id'],6);
		$vendorinfo=mysql_fetch_array(mysql_query("select * from  `$moduletableprefix-product-vendors` where `vendor_id`='$need_vendor_id'  LIMIT 0,1;"));
		$vendorlogo=mysql_fetch_array(mysql_query("select `photo_path` from  `$tableprefix-photos` where `photo_id`='$vendorinfo[vendor_logo]' LIMIT 0,1;"));
		$vendorcountry=mysql_fetch_array(mysql_query("select * from  `$tableprefix-country` where `id`='$vendorinfo[vendor_country_id]' LIMIT 0,1;"));

		$show_view='vendor';
		
	} elseif($contact=="add_to_cart"){ #Добавляют товар в корзину
		
		//$product_id=process_data($_REQUEST['productid'],20);
		$product_var_id=process_data($_REQUEST['variant'],20);
		$log->LogDebug('Product_variant id - '.$product_var_id);
		if(!$_SESSION['order_group']) { #Генерируем order_group
			insert_function("abracadabra");
			$hhuh=1;
			$order_group=abracadabra(8,'digits');
			while($hhuh==1){
				
				
				#Проверяем, нет ли такого номера заказа
				$check_ord_group=mysql_fetch_assoc(mysql_query("SELECT count(*) as ORDCNT FROM `$moduletableprefix-orders` WHERE `order_group`='$order_group' and `status`!='resolved' and `creations_ts` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));
				
				if($check_ord_group['ORDCNT']>0) {#Номер уже занят
					$order_group=abracadabra(8,'digits'); //Генерируем новый номер заказа
				} else {#Номер свободен, оставляем его как номер заказа
					$_SESSION['order_group']=$order_group;
					$hhuh=2;// Выходим из цикла
				}
			}
		} else $order_group=$_SESSION['order_group'];
		mysql_query("INSERT INTO `$moduletableprefix-orders` (`order_id`, `order_group`, `user_id`, `client_id`, `subscription_id`, `status`, `creations_ts`, `product_variant_id`, `order_type`, `order_text`, `last_status_change_ts`, `chat_id`, `sale_manager_id`) 
		VALUES 
		(NULL, '$order_group', '1035', NULL, NULL, 'opened', CURRENT_TIME(), '4', 'simple_order', 'dfsdf', CURRENT_TIMESTAMP, NULL, '1035');"
		);
		if(mysql_insert_id()){
			$return_data= "OK";
			$show_view='success_add_to_cart';
		}
		
	} elseif ($contact=="to_order"){ // Добавляют вариант в корзину (через ajax)
		
		if($_REQUEST['variantid']){
			global $company_id,$userid,$userrole,$tableprefix;
			if(!$userid) $userid=$_SESSION['userid'];
			$needvariant=process_data($_REQUEST['variantid'],6);// Отрезали лишее
			$log->LogDebug("Choosen variant is ".$needvariant);
			
			
			# Доступен ли вариант юзеру?
			$userrightsreq=mysql_query("SELECT DISTINCT * FROM 
		`$tableprefix-users` u, 
		`$tableprefix-users-groupmembers` gm,
		`$tableprefix-users-grouprights` gr
	WHERE
		u.`userid`=gm.`userid` and
		gr.`group_id`=gm.`group_id` and
		u.`userid`='$userid'
		");

			$varrightgiven=0;//Флаг успешного добавления варианта в заказ
			# Среди выделенных для него
			while ($userrights=mysql_fetch_array($userrightsreq)){
				if ($userrights['table']=="$tableprefix-product-variants" and $userrights['oid']==$needvariant) {
					# Этот вариант доступен
					$varrightgiven=1;
				}
			}
			
			# Среди is_public=1 и is_custom
			$other_vars_req=mysql_query("SELECT * FROM `$companiesprefix-product-variants` WHERE `variant_id`='$needvariant' and (`is_public`=1 or `is_custom`=0);");
			if(mysql_num_rows($other_vars_req)>0){$varrightgiven=1;}
			
			
			if($varrightgiven==0){# Среди доступных вариантов нет запрашиваемого
				$order_message = $sitemessage["$modulename"]["variant_isnt_found"];
				$order_status="nok";
				$log->LogError("Choosen variant is not found in available lists");
			} elseif($varrightgiven==1){# Права на вариант есть
				#Получаем детали варианта
				$varianddetail=mysql_fetch_array(mysql_query("select * from `$tableprefix-product-variants`
				where `variant_id`='$needvariant'"));
				
				if(!$varianddetail[charging_aligment]) {
					$varianddetail[charging_aligment]="NULL";
					$order_type="simple_order";
					
				}
				else {$order_type="subscription_request";}
				if(!$varianddetail[charging_period_days])$varianddetail[charging_period_days]="NULL";
				if(!$varianddetail[charging_period_months])$varianddetail[charging_period_months]="NULL";
				if(!$varianddetail[is_charging_prepaid])$varianddetail[is_charging_prepaid]="NULL";
				
				#Генерируем order_group (номер заказа по сути)
				if(!$_SESSION['order_group']) { 
					insert_function("abracadabra");
					$hhuh=1;
					$order_group=abracadabra(8,'digits');
					while($hhuh==1){
						
						
						#Проверяем, нет ли такого номера заказали
						$check_ord_group=mysql_fetch_assoc(mysql_query("SELECT count(*) as ORDCNT FROM `$moduletableprefix-orders` WHERE `order_group`='$order_group' and `status`!='resolved' and `creations_ts` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));
						
						if($check_ord_group['ORDCNT']>0) {#Номер уже занят
							$order_group=abracadabra(8,'digits'); //Генерируем новый номер заказа
						} else {#Номер свободен, оставляем его как номер заказа
							$_SESSION['order_group']=$order_group;
							$hhuh=2;// Выходим из цикла
						}
					}
				} else $order_group=$_SESSION['order_group'];
				
				$inserttoorder_qt="INSERT INTO `$tableprefix-orders` (	`order_group`,`order_type`,`client_id`,`user_id` ,`product_variant_id`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id`,`price` )
					VALUES ( '$order_group','$order_type', '$company_id', '$userid', '$needvariant', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL , '".$varianddetail['price']."'	);";
				$inserttoorder=mysql_query($inserttoorder_qt);
				
				$order_id=mysql_insert_id();
				
				if($inserttoorder==1){
					$order_message = $sitemessage["$modulename"]["order_succ"];
					$order_status="ok";
					//$order_function="closeblock('variant_form_1')";
					$order_function="showHideSelectionSoft('variant_form_1',1500);renew_shoppingcart_count(".$order_group.")";
					/* 
					Сумма в корзине обновляется:
					shoppingcart_count - id блока с счетчиками
					order_count_items - id блока с счетчиком покупок
					order_count_summ - id блока с счетчиком денег
					<img src="/files/shoppingcart_grey.png" height="40px"> 
					<span id="order_count_items"><?if($_SESSION['order_count_items']) echo $_SESSION['order_count_items']; else echo "0";?></span>покупок на сумму <span id="shoppingcartSummCount_ap"><?if($_SESSION['order_count_summ']) echo $_SESSION['order_count_summ']; else echo "0";?></span> руб.</div><?}?>
					*/
					$inseredorderrawid=mysql_insert_id();
					
					/*
					# Отправляем письмо
					insert_function("send_letter");
					$subject="Новая заявка на сайте ".$sitedomainname." - ".$order_group.'['.$order_id.']';				
					$message="На портале ".$sitedomainname." оформлена заявка. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>";
					$message.="Интересующий вариант - ".$needvariant;
					$message.="<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			
					sendletter($modulenameordernotify,$subject,$message);
					*/
					$log->LogDebug("Variant adeed to order was created sucessfully");
					if($varianddetail["activation_string"]){
						#Парсим строчку
						insert_function("isJSON");
						if(isJSON($varianddetail["activation_string"])){
							$log->LogDebug("Variant config is correct JSON");
							//{"script":"/project/tscloud/scripts/BMC_activation.php","param":{"balancerip":"172.35.1.12","balancerport":"80","soap_path":"/arsys/services/ARService?server=itsm&webService=SAS_CompanyCreateWS"}}

							$act_string_arr=json_decode($varianddetail["activation_string"], true);
							
							if($act_string_arr["script"]){// Активация из скрипта
								exec("/usr/bin/php ".$fullpath.$act_string_arr["script"]." $projectname $inseredorderrawid > /dev/null &");	// то есть скрипт должен стукнуться в табличку orders, найти там заказ, найти variant_id, найти активационную строчку и активировав, перевести order в статус исполнено
								$log->LogDebug("Auto activation started with string: /usr/bin/php ".$fullpath.$act_string_arr["script"]." $projectname $inseredorderrawid > /dev/null &");
							}
							
						} else $log->LogError("Variant config is not JSON or incorrect JSON");
						
					}
				} else {$order_message = $sitemessage["$modulename"]["order_unsucc"];
					$order_status="nok";
					$log->LogError("Order was not created sucessfully. Query was: ".$inserttoorder_qt);
				}
			}
			
		} else {
			$order_message = $sitemessage["$modulename"]["variant_isnt_ch"]; 
			$order_status="nok";
			$log->LogError("Variant is not choosen");
		}
		
		$aRes = array('status' => $order_status, 'message' => $order_message, 'getfunction'=>$order_function);
		echo json_encode($aRes);
	}	
	#Исправление параметров подписки
	elseif ($contact=="modify_subscription_request"){
		$request_text=process_data( $_REQUEST['request_text'],3000);
		$subscription_id=process_data( $_REQUEST['subscription_id'],7);
		$order_type='modify_subscription_request';
		$modifysubscrreq=mysql_query("INSERT INTO `$tableprefix-orders` (`order_type`,`client_id`,`user_id` ,`subscription_id`,`order_text`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` )
				VALUES ('$order_type', '$company_id', '$userid', '$subscription_id','$request_text', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 
				);");
		$order_id=mysql_insert_id();
		insert_function ("send_letter");
		
		if($modifysubscrreq){
			echo "<span style='color:green'>".$sitemessage["$modulename"]["mdfy_sbscr_ordr_succ_crtd"]." Статус заявки можно отслеживать в разделе ";
			if($userrole=="superuser") echo "ЗАЯВКИ КОМПАНИИ"; elseif($userrole=="user"){echo "МОИ ЗАЯВКИ";} 
			echo "</span>";
			
			$subject="Новая заявка на сайте ".$sitedomainname." - ".$order_id;
			$message="На портале ".$sitedomainname." оформлена заявка. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>Номер подписки = ".$subscription_id."<br> Текст запроса:<br>".$request_text."<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			$log->LogDebug("New order (".$order_type.") was successfully created. Administrator was notified");
		
		} else {echo "<span style='color:red'>".$sitemessage["$modulename"]["mdfy_sbscr_ordr_not_crtd"]."</span>";
			$log->LogError("Modify request was not created sucessfully. Query was: INSERT INTO `$tableprefix-orders` (`order_type`,`client_id`,`user_id` ,`subscription_id`,`order_text`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` )
				VALUES ('$order_type', '$company_id', '$userid', '$subscription_id','$request_text', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 
				);");
			$subject="Ошибка при создании новой заявки на портале ".$sitedomainname;
			$message="На портале ".$sitedomainname." была осуществлена попытка оформления заявки. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>Номер подписки = ".$subscription_id."<br> Текст запроса:<br>".$request_text."
			<br><b>ЗАЯВКА НЕ БЫЛА СОЗДАНА В БД. ОШИБКА</b>
			<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
		}
		sendletter($$modulenameordernotify,$subject,$message);	
	}
	elseif($contact=="add_user_to_product_managem"){// Добавляют юзера в группу управления продуктом
		if($userrole=="superuser"){
			$neededuserid=process_data($_REQUEST['userid'],7);
			$neededproductid=process_data($_REQUEST['product_id'],6);
			if($neededproductid and $neededuserid){
				# Запрос номера группы управления продуктом для данной компании
				$manageproduct=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1"));
				if($manageproduct['group_id'])	{#Группа управления продуктом найдена
					$log->LogDebug($modulename."/".basename (__FILE__)." | Group for manage of this product was found - ".$manageproduct['group_id']);
					
					$addtogroupreq=mysql_query("INSERT INTO `$tableprefix-users-groupmembers` (`group_id` ,`userid`) VALUES ('$manageproduct[group_id]', '$neededuserid');");
					if($addtogroupreq){
						$log->LogDebug($modulename."/".basename (__FILE__)." | User was inserted into group");
						echo $sitemessage["$modulename"]["user_added_prodmanage_group"].
						"<script>$(document).ready(function(){ajaxreq('".$neededproductid."','','show_product_managem_users','useracesstable".$neededproductid."','$modulename');})</script>";
					} else $log->LogDebug($modulename."/".basename (__FILE__)." | But user was NOT inserted into group by reason ".$addtogroupreq);
				} else $log->LogDebug($modulename."/".basename (__FILE__)." | Group for manage of this product was NOT found");
			} else { echo $sitemessage["$modulename"]["right_add_error"];
				$log->LogDebug($modulename."/".basename (__FILE__)." | Rights were not changed. Post user_id=".$neededuserid.". Post product_id=".$neededproductid);
			}
		}
	}
	elseif($contact=="del_user_from_product_manag"){// Удаляют юзера из группы управления продуктом
		if($userrole=="superuser"){
			$neededuserid=process_data($_REQUEST['someid2'],7);
			$neededproductid=process_data($_REQUEST['someid1'],6);
			# Запрос номера группы управления продуктом для данной компании
			$manageproduct=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1"));
			
			$delfromgroupreq=mysql_query("DELETE FROM `$tableprefix-users-groupmembers` WHERE `group_id`='$manageproduct[group_id]' and `userid`='$neededuserid' LIMIT 1 ; ");
			
			if($delfromgroupreq){echo $sitemessage["$modulename"]["us_remov_fr_group_success"].
			"<script>$(document).ready(function(){ajaxreq('".$neededproductid."','','show_product_managem_users','useracesstable".$neededproductid."','$modulename');})</script>";
			}
		}
	}
	elseif($contact=="show_product_managem_users"){ // Показать тех, кто может управлять продуктом и форму добавления пользователей
		
		if($userrole=="superuser"){
			$neededproductid=process_data($_REQUEST['someid1'],7);
			# Запрос номера группы управления продуктом для данной компании
			$manageproduct_qt="SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1";
			$manageproduct=mysql_fetch_array(mysql_query($manageproduct_qt));
			
			# Список пользователей со всеми правами, чтобы узнать, кому даны права на доступ к управлению продуктом и подписками
			$useraccessreq=mysql_query("SELECT * FROM `$tableprefix-users` u,`$tableprefix-users-groups` g,`$tableprefix-users-groupmembers` gm WHERE u.`company_id`='$company_id' and u.`userrole`='user' and gm.`userid`=u.`userid` and gm.`group_id`=g.`group_id`;");
			# Список всех пользователей компании
			$userlistreq=mysql_query("SELECT * FROM `$tableprefix-users` WHERE `company_id`='$company_id' and `userrole`='user'");
			$userlistcount=mysql_num_rows($userlistreq);// Число юзеров с ролью user в компании
			?>
			<tr><td width="250px">Доступ к управлению продуктом</td><td width="30px"><b>:</b></td><td><? 

			//mysql_data_seek($useraccessreq,0);
			while ($useraccess=mysql_fetch_array($useraccessreq)){
				if($useraccess['group_id']==$manageproduct['group_id']){echo $useraccess['fullname']."<a  href='/' title='Исключить из группы' onclick='ajaxreq(".'"'.$neededproductid.'","'.$useraccess['userid'].'","del_user_from_product_manag","'.$neededproductid.'messageplace","$modulename");'.";return false;'><img src='/22_files/close.png' style='vertical-align:middle'></a><br>";
					$userexceplist[$manageproduct['oid']][$useraccess['userid']]=1; //echo "Исключен из списка добавления id=".$useraccess['userid'];
				}	
			}
			if (count($userexceplist[$manageproduct['oid']])==0){echo $sitemessage["$modulename"]["no_accss_users"];}
			?></td></tr><? 
			if($userlistcount>0){?>
			<? 	mysql_data_seek($userlistreq,0);
				if($userlistcount-count($userexceplist[$manageproduct['oid']])>1){?>
					<tr><td>Добавить пользователя</td><td><b>:</b></td><td>
					<form id="addtoproductform"><select name="userid"><? 
					while ($userlist=mysql_fetch_array($userlistreq)){
						if($userexceplist[$manageproduct['oid']][$userlist['userid']]!==1){?>
						<option value="<?=$userlist['userid']?>"><?=$userlist['fullname']?></option>
				<?		}
					}?></select>
				<input value="add_user_to_product_managem" name="subscr_action" type="hidden">
				<input value="<?=$manageproduct['oid']?>" name="product_id" type="hidden">
				<a href="/" onclick="saveform('','addtoproductform','<?=$manageproduct['oid']?>messageplace','$modulename');return false;"><img src='/files/plus0000.png' style="vertical-align:middle" width="20px"></a>
				</form></td></tr>
			<? 	}
				elseif(($userlistcount-count($userexceplist[$manageproduct['oid']]))==1) {// Есть всего один из списка юзеров компании, кого нет в ексепшн списке
					while($userlist=mysql_fetch_array($userlistreq)){ // Перебираем весь список
						if($userexceplist[$manageproduct['oid']][$userlist['userid']]!==1){// Нашелся нужный юзер?>
							<tr><td>Добавить пользователя</td><td><b>:</b></td><td><?=$userlist['fullname'];?><a  href="/" onclick="saveform('','addtoproductform','<?=$manageproduct['oid']?>messageplace','$modulename');return false;"><img src='/project/tscloud/files/plus0000.png' style="vertical-align:middle" width="20px"></a>
							<form id="addtoproductform"><input value="<?=$userlist['userid']?>" name="userid" type="hidden">
							<input value="add_user_to_product_managem" name="subscr_action" type="hidden">
							<input value="<?=$manageproduct['oid']?>" name="product_id" type="hidden">
							</form></td></tr><?
						}
					}
				}					
			}
		}
	}
	elseif($contact=="check_order_status"){/*
		$order_ids=process_data($_REQUEST['someid1'],200);
		$order_id=explode(";",$order_ids);
		foreach($order_id as $oid){
			//$query.=
		}
		$order_status=mysql_fetch_array(mysql_query("SELECT `order_id`,`status` FROM `$tableprefix-orders` WHERE `order_id`='$order_id'"));
		if($order_status['status']){
			if($order_status['status']=="opened"){$humread_status = "В работе";}
			elseif($order_status['status']=="droped"){$humread_status = "Сброшена";}
			elseif($order_status['status']=="admin_suspended"){$humread_status = "Приостановлена администратором";}
			elseif($order_status['status']=="resolved"){$humread_status = "Успешно отработана";}
			elseif($order_status['status']=="inprogress"){$humread_status = "На исполнении";}
			elseif($order_status['status']=="wait_user"){$humread_status = "Ожидание ответа пользователя";}
			$aRes = array('status' => 'ok', 'message' => $humread_status);
		
		
		} else{
			$aRes = array('status' => 'nok', 'message' => "Ошибка при обновлении статуса");
			$log->LogError("Can't get status of order_id - ".$order_id);
		}
		echo json_encode($aRes);*/
	}
	
	elseif($contact=="check_vendor_domain"){
		ini_set('default_socket_timeout', '10');
		$need_vendor_id=process_data($_REQUEST['someid1'],5);
		$req_lang=process_data($_REQUEST['someid2'],2);
		$vendorinfo=mysql_fetch_array(mysql_query("select * from  `$moduletableprefix-product-vendors` where `vendor_id`='$need_vendor_id'  LIMIT 0,1;"));
		$fp = fopen($vendorinfo['vendor_domain_'.$req_lang], "r");
		$res = fread($fp, 500);
		fclose($fp);
		if (strlen($res) > 0)
			{
				?><script>showblock("vendor_link_button",0,'show');</script><?
			}
	}
	elseif($contact=="order_count_summ"){ // Получают сумму всех покупок в корзине
		if($_REQUEST['someid1']) {//передали запрос через ajax
			$order_group=process_data($_REQUEST['someid1'],20);
		} elseif($param[2]){//Вызвали экшн через вызов модуля
			$order_group=$param[2];
		}
		$check_summ_q=mysql_query("SELECT `price` FROM `$tableprefix-orders` WHERE `order_group`='$order_group';");
		while($check_summ=mysql_fetch_assoc($check_summ_q)){
			$order_count_summ=$order_count_summ+$check_summ['price'];
		}
		if(!$order_count_summ) $order_count_summ=0;
		$_SESSION['order_count_summ']=$order_count_summ;
		
		if($_REQUEST['someid1']) {//Отвечаем в ajax
			$aRes = array('status' => 'ok', 'message' => $order_count_summ);
			echo json_encode($aRes);
		} elseif($param[2]){//Отвечаем в модуль
			$return_data=$order_count_summ;
		}
		
	}
	elseif($contact=="order_count_items"){ //Получают количество покупок в корзине
		$order_group=process_data($_REQUEST['someid1'],20);
		$check_itemCount=mysql_fetch_assoc(mysql_query("SELECT count(*) as itemsCount FROM `$tableprefix-orders` WHERE `order_group`='$order_group' and `status`='opened';"));
		
		
		$_SESSION['order_count_items']=$check_itemCount['itemsCount'];
		$aRes = array('status' => 'ok', 'message' => $check_itemCount['itemsCount']);
		echo json_encode($aRes);
	}
	elseif($contact=="del_from_order"){ //Удаляют вариант из корзины
		/* Удаляется так: 
		ajax_rq ('swpshop','del_from_order','swpshop_ap','swpshop_ap','<?=$orderlist['product_variant_id'];?>','<?=$_SESSION['order_group']?>','<?=$orderlist['order_id']?>')*/
		
		#Удалять может или администратор портала или юзер, если у него есть такой же order_group в SESSION
		$order_group=process_data($_REQUEST['someid2'],20);
		$del_var_id=process_data($_REQUEST['someid1'],10);
		$del_row_id=process_data($_REQUEST['someid3'],20);
		if(($_SESSION['order_group']==$order_group and !empty($_SESSION['order_group'])) or $userrole=="admin" or $userrole=="root") { #есть права на удаление
			
			$del_row=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-orders` WHERE `order_group`='$order_group' AND `product_variant_id`='$del_var_id' and `order_id`='$del_row_id' LIMIT 1;"));
			if($del_row['order_id']) {//Подходящая строчка есть в БД
				mysql_query("DELETE FROM `$tableprefix-orders` WHERE `order_group`='$order_group' AND `product_variant_id`='$del_var_id' and `order_id`='$del_row_id' LIMIT 1;");
				$aRes = array('status' => 'ok', 'message' => "Продукт успешно удалён из заказа",
				'getfunction'=>"renew_shoppingcart_summ();
				showHideSelectionSoft('row".$del_row_id."',1000);
				");
			}
		
		} else $aRes = array('status' => 'nok', 'message' => "Не возможно удалить продукт из заказа");
		
		echo json_encode($aRes);
	}
	elseif($contact) include_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$modulename.'/'.$pagetype.'.php');
	
}
?>