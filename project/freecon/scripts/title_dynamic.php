<?php
 /**************************************************************************************\
  * Snippet Name : получить title для динамических страниц		 						*
  * Scripted By  : RomanyukAlex		           					 						*
  * Website      : http://popwebstudio.ru	   					 						*
  * Email        : admin@popwebstudio.ru     					 						*
  * License      : GPL (General Public License)					 						*
  \*************************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){
	if($page=="book"){
		//$title='Аудиокниги по психологии';
		if(!$book_id){
			$book_id=process_data($_REQUEST['topic_id'],8);
			$book_info=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `topic_id`='".$book_id."' AND (`status`='active' or `status`='need_confirm') LIMIT 0,1;"));

			mb_internal_encoding("UTF-8");
			
			insert_function("parse_torrent_name");
			$book_info_p=parse_torrent_name($book_info['name']);
			$bookauthor=$book_info_p['author'];
			$bookname=$book_info_p['title'];
			$book_attr=$book_info_p['tor_attr'];
			$torrent_name=$book_info_p['torrent_name'];
		}
		if($bookauthor) $title=$book_info_p['author'].' - '.$book_info_p['title'];
		else $title=$book_info_p['torrent_name'];
		if(strlen($title)<65) $title.=". Скачать бесплатно";
	}
	elseif($page=="CTATbu_srch" or $page=="CTATbu"){$title='Статьи по психологии';}
	elseif($page=="audios_srch"){$title='Аудиокниги по психологии';}
	elseif($page=="psybooks"){$title='Книги по психологии | Скачать бесплатно';}
	elseif($page=="who_is_who"){
		if($_REQUEST['search_cat']=="trainingcenters") $title="Тренинговые центры России и стран СНГ";
		elseif($_REQUEST['search_cat']=="trainers") $title="Психологи и тренеры России и стран СНГ";
		elseif($_REQUEST['search_cat']=="trainers_by_tag") $title="Психологи и тренеры по направлению:".process_data($_REQUEST['tag'],40);
		elseif($_REQUEST['search_cat']=="trainers_in_place") $title="Психологи и тренеры, проживающие в ".process_data($_REQUEST['country'],40);
		elseif($_REQUEST['search_cat']=="trainingcenters_in_place") $title="Тренинговые центры, расположенные в ".process_data($_REQUEST['city'],40);
	}
	elseif($page=="swpshop" and $_REQUEST['productid']){ //Страница с продуктом swpshop
		$product_id=process_data($_REQUEST['productid'],10);
		$product_info=insert_module("swpshop",'get_product_info',"$product_id");
		$title=$product_info['product_full_title_ru'];
	}
	elseif($page=="swpshop" and !$_REQUEST['productid']){//Просто страница магазина
		$title="Магазин записей тренингов";
	}
	if($_REQUEST['search_string']) $title.=': '.process_data($_REQUEST['search_string'],200);
	
	echo $title;
}?>