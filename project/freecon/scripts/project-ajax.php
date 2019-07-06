<?php
 /***********************************************************************
  * Snippet Name : Project ajax scripts		 					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some ajax functions							 		*
  * Access		 : 														*
  *  ajaxreq(some_id1,some_id2,action,answer_place,"project_script");	*
  **********************************************************************/
 $log->LogInfo('Got this file');
if ($nitka=='1'){
	if($_REQUEST['action']=="get_hearts"){ //Получают новые сердечки
		foreach($_SESSION['prev_pages'] as $prev_page){
			$message.=$prev_page.";";
		}
		
		
		if(!strstr($_REQUEST['someid1'],"book") and $_REQUEST['someid1']!=="who_is_who" and $_REQUEST['someid1']!=="CTATbu" and $_REQUEST['someid1']!=="audios" and $_REQUEST['someid1']!=="audio" and $_REQUEST['someid1']!=="swpshop" and $_REQUEST['someid1']!=="pedia" and $_REQUEST['someid1']!=="psy_jokes" and $_REQUEST['someid1']!=="videos" 
		and !in_array($_REQUEST['someid1'],$_SESSION['prev_pages'])
		){
			$_SESSION['prev_pages'][]=$_REQUEST['someid1'];
			if($_SESSION['hearts']) {$_SESSION['hearts']++;setcookie("hearts",$_SESSION['hearts']);}
			elseif($_COOKIE["hearts"]) {
				$_SESSION['hearts']=$_COOKIE["hearts"]+1;setcookie("hearts",$_COOKIE["hearts"]+1);
			}elseif(!$_SESSION['hearts']) {$_SESSION['hearts']=1; setcookie("hearts",1);}

			$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>"update_hearts_display('".$_SESSION['hearts']."')");
		}
		
		echo json_encode($aRes);
		
	} elseif($_REQUEST['action']=="pay_hearts"){ //Списывают сердечки
		
		$_SESSION['hearts']=$_SESSION['hearts']-$_REQUEST['someid1'];//Списали
		setcookie("hearts",$_SESSION['hearts']);//Сохранили в куки
		$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>"update_hearts_display('".$_SESSION['hearts']."')");
		echo json_encode($aRes);//Ответили 

	} elseif($_REQUEST['action']=="add_new_video"){
		
		if ( preg_match( "/(http|https):\/\/(www.youtube|youtube|youtu)\.(be|com)\/([^<\s]*)/", $_REQUEST['new_yt_v_id'], $match ) ) {
		  if ( preg_match( '/youtube\.com\/watch\?v=([^\&\?\/]+)/', $_REQUEST['new_yt_v_id'], $id ) ) {
			  $new_v_id = $id[1];
		  } else if ( preg_match( '/youtube\.com\/embed\/([^\&\?\/]+)/', $_REQUEST['new_yt_v_id'], $id ) ) {
			 $new_v_id = $id[1];
		  } else if ( preg_match( '/youtube\.com\/v\/([^\&\?\/]+)/', $_REQUEST['new_yt_v_id'], $id ) ) {
			$new_v_id = $id[1];
		  } else if ( preg_match( '/youtu\.be\/([^\&\?\/]+)/', $_REQUEST['new_yt_v_id'], $id ) ) {
			$new_v_id = $id[1];
		  } else if ( preg_match( '/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $_REQUEST['new_yt_v_id'], $id ) ) {
			$new_v_id = $id[1]; 
		  }
		}
		
		# Нет ли видео на сайте
		$check_v_indb=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `yt_id`='$new_v_id';");
		if(mysql_num_rows($check_v_indb)>0){
			$message=sitemessage('system','video_already_exist');
		}
		else { #Видео еще нет в БД
			# Получить данные видео
			$vjson = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".$new_v_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
			
			$youtube = json_decode($vjson); // преобразовали JSON-строку в объект PHP
			if ($youtube && $youtube != NULL && $youtube->items) { // проверяем ответ, если ключ верен, видео существует и массив с информацией не пуст
			
				foreach ($youtube->items as $item) { // проходимся по массиву, задавая переменные
					$published = $item->snippet->publishedAt; // дата публикации
					$title = $item->snippet->title; // заголовок
					$description = $item->snippet->description; // описание
					//$thumb = $item->snippet->thumbnails; // превью
					$author = $item->snippet->channelTitle; // автор видео
					//$duration = $item->contentDetails->duration; // продолжительность (переводим в секунды)
					//$viewCount = $item->statistics->viewCount; // количество просмотров
					//$likes = $item->statistics->likeCount; // понравилось
					//$dislikes = $item->statistics->dislikeCount; // не понравилось
					
					foreach($item->snippet->tags as $tag){
						$tags.=$tag.";";
					}
				}
				$vtitle = htmlspecialchars(trim((string)$title)); // подготовили заголовок
				$vdescription = !empty($description) ? htmlspecialchars(trim((string)$description)) : "Нет описания видео"; // подготовили описание, проверив на пустоту
				$author = htmlspecialchars(trim((string)$author)); // автор видео
								
				#Функция для убирания ссылок из текстов роликов
				insert_function("clean_url_from_text");
				#Убираем ссылки из текста
				$vtitle=clean_url_from_text($vtitle);
				$vdescription=clean_url_from_text($vdescription);
				
				$log->LogInfo('Got info from youtube: TITLE - '.$vtitle.' AUTOR -'.$author. ' PUBLISHED - '. $published );
				mysql_query("INSERT INTO `$tableprefix-videos` (`v_id`, `yt_id`, `autor`, `vtitle`, `v_full_desc`,`yt_publishedAt`,`vstatus`, `tags`) VALUES 
				(NULL, '$new_v_id', '$author', '$vtitle', '$vdescription', '$published', 'need_moderate','$tags');");
			
				$message=sitemessage('system','video_added_succ'); //Видео успешно добавлено в базу
			
			} else { // произошла ошибка при парсинге
				$message=sitemessage('system','video_cant_add');//$message="Не удалось получить данные";
				$log->LogError('Cant get data about video from YT');
			}
		}
		$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>'');
		echo json_encode($aRes);
		
	} elseif($_REQUEST['action']=="add_new_channel"){ # Добавляют новый канал для мониторинга
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			
			if($_REQUEST['new_yt_с_id']){
				
				$new_c_url=process_user_data($_REQUEST['new_yt_с_id'],120);#Название нового канала
				$new_c_AutoApply=process_user_data($_REQUEST['new_yt_с_AutoApply'],2);
				if($new_c_AutoApply) $autoApply="'auto_apply'"; else $autoApply='NULL';
				$log->LogDebug('New channel full url after processing is '.$new_c_url);
				
				if($ch_id_variant=stripos($new_c_url,"/channel/")){#Запостили строку содерж ID канала
					$new_c_id=substr($new_c_url,$ch_id_variant+9);
					$log->LogDebug('New channel id is'.$new_c_id);

					$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=".$new_c_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
					$log->LogDebug('Query is -'. 
				"https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=".$new_c_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
					
				} elseif($ch_id_var=stripos($new_c_url,"/user/")){
					$new_c_user_id=substr($new_c_url,$ch_id_var+6);
					$log->LogDebug('New youtube user id is'.$new_c_user_id);
					$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername=".$new_c_user_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");

				} elseif (!stripos($new_c_url,"youtube")) { //Запостили ID канала
					$new_c_id = $new_c_url;
					$log->LogDebug('New channel id is'.$new_c_id);
					$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=".$new_c_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
				}
				if($cjson) $log->LogDebug('YouTube info about channel is'.str_replace(array("\r","\n"),"",$cjson)); 
				
				$c_youtube = json_decode($cjson); // преобразовали JSON-строку в объект PHP
				if ($c_youtube && $c_youtube != NULL) {
					foreach ($c_youtube->items as $item) { // проходимся по массиву, задавая переменные
						$new_c_title = $item->snippet->title; // Название канала
						$new_c_desc = $item->snippet->description; // Описание канала
						$new_c_id = $item->id; // id канала
					}
				}	
				
				$check_c_id=mysql_query("SELECT * FROM `$tableprefix-video-channels` WHERE `yt_c_id`='$new_c_id';");
				if(mysql_num_rows($check_c_id)>0){
					$message=sitemessage('system','channel_alr_exist');
					$log->LogError('Channel is already in DB');
				} else {
					# Записываем в БД
					$add_ch_qt="INSERT INTO `$tableprefix-video-channels` (`c_id`, `yt_c_name`, `yt_c_id`, `c_desc`,`last_update`,`chan_added_date`,`filter_rules`) VALUES (NULL, '$new_c_title','$new_c_id', '$new_c_desc','',CURRENT_TIMESTAMP, $autoApply);";
					$add_ch_q=mysql_query($add_ch_qt);
					
					if ($add_ch_q) { //Канал успешно добавлен
						$log->LogInfo('Channel added to DB');
						$message=sitemessage('system','channel_added_succ');
					}
					else {//Ошибка добавления строки
						$log->LogError('Channel had not added to DB: '. mysql_error());
						$log->LogDebug('Query was: '. $add_ch_qt);
						$message=sitemessage('system','Unknown_error');
					}
				}
				
			} else {//Нет url
				$log->LogDebug('No URL in query');
				$message=sitemessage('system','Unknown_error');
			}
		} else { //Нет прав на добавление канала
			$log->LogError('No privileges for channel adding');
			$message=sitemessage('system','you_have_no_privileges_for_operation');
		}
		$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>'');
		echo json_encode($aRes);
	} elseif($_REQUEST['action']=="add_new_playlist"){ # Добавляют новый канал для мониторинга
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			#Получаем ID нового плейлиста
			$new_pl_url=process_user_data($_REQUEST['new_yt_pl_id'],80);

			if($pl_id_variant=stripos($new_pl_url,"/playlist")){#Запостили 1 канал в полном URL типа https://www.youtube.com/playlist?list=PLqSTFWHJscVfDacNWshZkU0KfVDbq0LdH
				$new_pl_id=substr($new_pl_url,$pl_id_variant+15);
						
				


						
				//$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=".$new_c_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
				
			/* // Кейс нескольких плейлистов
			} elseif($ch_id_var=stripos($new_c_url,"/user/")){
				$new_c_user_id=substr($new_c_url,$ch_id_var+6);
			
				$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername=".$new_c_user_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");

				
			}*/
			} else $new_pl_id=$new_pl_url;
			
			#Получаем channelId канала
			$new_pl_det_q=file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=1&playlistId=".$new_pl_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
			$pl_youtube=json_decode($new_pl_det_q);
			if ($pl_youtube && $pl_youtube != NULL) {
				foreach ($pl_youtube->items as $item) { // проходимся по массиву, задавая переменные
					$new_c_id = $item->snippet->channelId; // id канала
				}
			}	
			
			#Получаем подробности по каналу
			$cjson = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=".$new_c_id."&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI");
			$c_youtube = json_decode($cjson); // преобразовали JSON-строку в объект PHP
			if ($c_youtube && $c_youtube != NULL) {
				foreach ($c_youtube->items as $item) { // проходимся по массиву, задавая переменные
					$new_c_title = $item->snippet->title; // Название канала
					$new_c_desc = $item->snippet->description; // Описание канала
					$new_c_id = $item->id; // id канала
				}
			}	
			#Проверяем существование канала
			$check_c_id=mysql_query("SELECT * FROM `$tableprefix-video-channels` WHERE `playlists`='$new_pl_id';");
			if(mysql_num_rows($check_c_id)>0){ // Уже существует
				$message=sitemessage('system','channel_alr_exist');
			} else {
				# Записываем в БД ID плейлиста
				mysql_query("INSERT INTO `$tableprefix-video-channels` (`c_id`, `yt_c_name`, `yt_c_id`,`playlists`, `c_desc`,`last_update`,`chan_added_date`) VALUES (NULL, '$new_c_title','$new_c_id','$new_pl_id', '$new_c_desc','',CURRENT_TIMESTAMP);");
				$message=sitemessage('system','channel_added_succ');
			}
			$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>'');
			echo json_encode($aRes);
			
		} else echo sitemessage('system','you_have_no_privileges_for_operation');
		
		
		
	} elseif($_REQUEST['action']=="get_v_descript"){ # Получить описание видеоролика из БД
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		$yt_id=process_user_data($_REQUEST['ytid'],20);
		$v_desc_q=mysql_query("SELECT `v_full_desc` FROM `$tableprefix-videos` WHERE `yt_id`='".$yt_id."';");
		$v_desc_info=mysql_fetch_array($v_desc_q);
		if($userrole=="admin" or $userrole=="root"){
			echo $v_desc_info['v_full_desc'];
		} else echo str_replace("\n", "<br>", $v_desc_info['v_full_desc']);

	} elseif($_REQUEST['action']=="moderate_video"){# Модерируют видео
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			$yt_id=process_user_data($_REQUEST['ytid'],20);
			$reaction=process_user_data($_REQUEST['reaction'],20);
			$log->LogDebug('Moderation ['.$reaction.'] video ['.$yt_id.'] is in progress');
			if($reaction=='publish' or $reaction=='publish_soc'){
				#Изменяем статус видео
				$upd_v_details_q=mysql_query("UPDATE `$tableprefix-videos` SET `vstatus` = 'active',`moderated_by`='$userid' WHERE `yt_id` = '".$yt_id."';");
				#Проверяем, есть ли такая страница
				$p_exst_chk=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page`='$yt_id'");
				if(mysql_num_rows($p_exst_chk)>0){
					#Страница суествует в БД, не вставляем её
					$log->LogError('Page '.$yt_id.' is already exist in PAGE table');
					
				} else{
					#Вставляем страницу
					//Получаем детали видео
					$v_details=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `yt_id` = '".$yt_id."' LIMIT 0,1;"));
					// Вставляем страницу
					$ins_page_q=mysql_query("INSERT INTO `$tableprefix-pages` 
					(`page_id`, `page`, `pagetitle_ru`, `pagetitle_en`, `folder`, `filename`, `pagebody_ru`, `pagebody_en`, `module_page`,
					`page_menu`, `exceptionsscript`, `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-keywds_ru`, 
					`SEO-keywds_en`, 			`SEO-descrtn_ru`, 			`SEO-descrtn_en`, 			`showin_all_pages_page`, 
					`is_articles`, `script_after_page`, `creation_date`) VALUES 
					(NULL, '".$yt_id."', '".$v_details['vtitle']."', '".$v_details['vtitle']."', '/pages/', 'videopage.php',NULL,NULL,NULL,
					NULL, '0', 				'yes','".$v_details['moderated_by']."', '".$v_details['vtitle']."', '".$v_details['vtitle']."', '". str_replace (';',' ',$v_details['tags'])."', '".str_replace (';',' ',$v_details['tags'])."', 	'".$v_details['vtitle']."', '".$v_details['vtitle']."', '0', 					'0', 			NULL, '". substr($v_details['yt_publishedAt'],0,10)." 00:00:00');");
					$log->LogDebug('New page inserted successfully '.mysql_insert_id($ins_page_q));
				}				
				
			} elseif($reaction=="decline"){
				$upd_v_details_q=mysql_query("UPDATE `$tableprefix-videos` SET `vstatus` = 'blocked',`moderated_by`='$userid', `autor`=NULL,`vtitle`=NULL,`v_full_desc`=NULL,`tags`=NULL WHERE `yt_id` = '".$yt_id."';");
			}
			
			if(mysql_error($upd_v_details_q)) $status_false=1; // Апдейт деталей видео прошел неудачно
			
			if($status_false!==1){
				echo sitemessage('system','video_moder_succ');
				$log->LogDebug('Video moderated successfully');
			} else {
				echo sitemessage('system','Unknown_error');
				$log->LogError('Video moderated NOT successfully. Some error');
			}
		} else {
			$log->LogError('No privileges for operation');
			echo sitemessage('system','you_have_no_privileges_for_operation');
		}
	} elseif($_REQUEST['action']=="moderate_book"){ # Модерируют книгу
		$topic_id=process_user_data($_REQUEST['id'],20);
		$reaction=process_user_data($_REQUEST['reaction'],20);
		$log->LogDebug('Moderation ['.$reaction.'] of book ['.$topic_id.'] is in progress');
		
		if($reaction=="delete"){#Удаляем данные топика, сменяем его статус
			
			mysql_query("UPDATE `$tableprefix-torrents` SET 
			 `name` = '',`status` = 'disabled',`orig_desc` = NULL,`hash` = NULL,`cat_name` = '', `cat_id` = '',`year` = NULL ,`orig_img` = NULL,`size` = '' 
			WHERE `topic_id` = '".$topic_id."';");

		}
		elseif($reaction=="apply"){
			
			mysql_query("UPDATE `$tableprefix-torrents` SET `status` = 'active' WHERE `topic_id` = '".$topic_id."';");
		
		}
		if(mysql_errno()){
			$log->LogError("Error - ".mysql_errno() . ", " . mysql_error()); 
			echo "Ошибка";
		} else {
			//Стираем сообщение из очереди сообщений
			mysql_query("DELETE FROM `$tableprefix-portal-events` WHERE `link`='https://".$sitedomainname."/?page=book&topic_id=".$topic_id."';");
			
			echo "Успешно исполнено";
		}
	} elseif($_REQUEST['action']=="moderate_page"){ # Модерируют страницу
		
		$page_id=process_user_data($_REQUEST['id'],20);
		$reaction=process_user_data($_REQUEST['reaction'],20);
		$log->LogDebug('Moderation ['.$reaction.'] of page ['.$page_id.'] is in progress');
		
		if($reaction=="delete"){#Удаляем страницу
	
			
			$page_page=mysql_fetch_assoc(mysql_query("SELECT `page` FROM  `$tableprefix-pages` WHERE `page_id` = '".$page_id."';"));
			unlink($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$page_page['page']);//стираем файл страницы
			unlink($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html_en/'.$page_page['page']);//стираем файл страницы en
			mysql_query("DELETE FROM `$tableprefix-pages` WHERE `page_id` = '".$page_id."';");
			
		}
		elseif($reaction=="apply"){
	
			mysql_query("UPDATE `$tableprefix-pages` SET `showin_all_pages_page` = '1',`is_articles` = '1',`status`='ena'
			WHERE `page_id`  = '".$page_id."';");
	
		} elseif($reaction=="clear_page_data"){
	
			mysql_query("UPDATE `$tableprefix-pages` SET `pagetitle_ru` = NULL,`pagetitle_en` = NULL,`folder` = NULL,`filename` = NULL,
			`pagebody_ru` = NULL,`pagebody_en` = NULL,`SEO-title_ru` = NULL ,`SEO-title_en` = NULL ,`SEO-keywds_ru` = NULL,`SEO-keywds_en` = NULL,
			`SEO-descrtn_ru` = NULL,`SEO-descrtn_en` = NULL,`showin_all_pages_page` = '0',`is_articles` = '0',`page_img` = NULL, `tags` = NULL,
			`script_after_page` = NULL, `status`='dis',`meta`= NULL
			 WHERE `page_id` = '".$page_id."';");
			
			
	
		} elseif($reaction=="deactivate"){
	
			mysql_query("UPDATE `$tableprefix-pages` SET `showin_all_pages_page` = '0',`is_articles` = '0',`status`='dis'
			WHERE `page_id`  = '".$page_id."';");
			
	
		} elseif($reaction=="clear_cache"){
			//insert_function();
			unlink($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/cache/'.$page_id);
	
		}
		echo "Успешно исполнено";

	} elseif($_REQUEST['action']=="delete_ch_gr" or $_REQUEST['action']=="add_ch_gr"){ # Изменение групповых прав
	
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			if($_REQUEST['action']=="add_ch_gr") mysql_query("INSERT INTO `$tableprefix-users-grouprights` (`group_id`, `oid`, `table`, `grant`) VALUES ('".$_REQUEST['group_id']."', '".$_REQUEST['c_id']."', '$tableprefix-video-channels', '1');");
			elseif($_REQUEST['action']=="delete_ch_gr") mysql_query("DELETE FROM `$tableprefix-users-grouprights` WHERE `group_id`='".$_REQUEST['group_id']."' and `oid`='".$_REQUEST['c_id']."';");
			echo "OK";
		}
	
	} elseif($_REQUEST['action']=="change_video_desc"){#Изменяют описание канала
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			if($_REQUEST['someid']){ # ID видео пришло
				//$upd_v_details_q=mysql_query("UPDATE `$tableprefix-video-channels` SET `c_desc` = '".$_REQUEST['desc_text']."' WHERE `c_id` = '".$_REQUEST['someid']."';");
				
				$upd_v_details_q=mysql_query("UPDATE `$tableprefix-videos` SET `v_full_desc` = '".$_REQUEST['desc_text']."' WHERE `yt_id` = '".$_REQUEST['someid']."';");
				
				if(mysql_error($upd_v_details_q)) $status_false=1; // Апдейт деталей видео прошел неудачно
				
				if($status_false!==1){
					$message= sitemessage('system','video_moder_succ');
					$log->LogDebug('Video moderated successfully');
				} else {
					$message= sitemessage('system','Unknown_error');
					$log->LogError('Video moderated NOT successfully. Some error');
				}
			} else {
				$message= sitemessage('system','Unknown_error');
				$log->LogError('No video id in query');
			}
		} else {
			$log->LogError('No privileges for operation');
			$message=sitemessage('system','you_have_no_privileges_for_operation');
		}
		$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>'');
		echo json_encode($aRes);
	} elseif($_REQUEST['action']=="change_channel_desc"){#Изменяют описание канала
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		if($userrole=="admin" or $userrole=="root"){
			if($_REQUEST['someid']){ # ID канала пришло
				$upd_c_details_q=mysql_query("UPDATE `$tableprefix-video-channels` SET `c_desc` = '".$_REQUEST['desc_text']."' WHERE `c_id` = '".$_REQUEST['someid']."';");
				
				//$upd_v_details_q=mysql_query("UPDATE `$tableprefix-videos` SET `v_full_desc` = '".$_REQUEST['desc_text']."' WHERE `yt_id` = '".$_REQUEST['someid']."';");
				
				if(mysql_error($upd_c_details_q)) $status_false=1; // Апдейт деталей видео прошел неудачно
				
				if($status_false!==1){
					$message= sitemessage('system','video_moder_succ');
					$log->LogDebug('Channel updated successfully');
				} else {
					$message= sitemessage('system','Unknown_error');
					$log->LogError('Channel updated NOT successfully. Some error');
				}
			} else {
				$message= sitemessage('system','Unknown_error');
				$log->LogError('No channel id in query');
			}
		} else {
			$log->LogError('No privileges for operation');
			$message=sitemessage('system','you_have_no_privileges_for_operation');
		}
		$aRes = array('status' => 'ok', 'message' => "$message",'getfunction'=>'');
		echo json_encode($aRes);
	} elseif($_REQUEST['action']=='get_banner'){
		echo "<a href='http://get-in-line.ru/?ref=2234&key=0'>Инструмент для записи на Вашу консультацию.<br>Бесплатно!</a>";
	} elseif($_REQUEST['action']=='delete_page'){

		mysql_query("DELETE FROM `$tableprefix-pages` WHERE `page`='".$_REQUEST['ytid']."'");
		echo "Страница удалена";

	}  elseif($_REQUEST['action']=="download_torrent"){ // Команда скачать торрент файл

		$rutr_cookie_file=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/books_torrents/cookie_file';
		$rutracker_login='Psytriballl';
		$rutracker_pass='Tribe21';
		$torrent_file=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/books_torrents/'.$_REQUEST['someid1'].".torrent";

		if(file_exists($torrent_file)) { //Файл торрента уже скачивали
			//echo "Скачивали";
		}
		else{ # Нужно скачать торрент файл

			$cmd="wget --load-cookies ".$rutr_cookie_file."  https://rutracker.org/forum/dl.php?t=".$_REQUEST['someid1']." --no-check-certificate -O ".$torrent_file;
			$shell_result=shell_exec($cmd);
			insert_function("file_search_in");
			if(file_search_in($torrent_file,'<h1 class="pagetitle">')){// У нас нет авторизации, скачалась страница авторизации, а не торрент файл
				unlink($torrent_file); // Удаляем то, что скачалось
				
				$cmd2='wget http://rutracker.org/forum/login.php --post-data="login_username='.$rutracker_login.'&login_password='.$rutracker_pass.'&login=1" --save-cookies='.$rutr_cookie_file.' -O  /dev/null';
				$shell_result2=shell_exec($cmd2); //Создали cookie файл
				$shell_result=shell_exec($cmd); //Скачали торрент файл
			}
			
		}
	} elseif($_REQUEST['action']=="get_page_preview"){
		$page_id=process_user_data($_REQUEST['pageid'],200);
		
	} elseif($_REQUEST['action']=="update_subsctipt"){ #Обновление/добавление подписки на рассылку
		
		#Проверяем то,что постят
		$razdels = $_POST['contenttype'];
		$email=process_user_data($_POST['email'],120);
		
		if(count($razdels)==0) {
			$message='Вы не выбрали, что хотите получать';
			$status="nok";
		} elseif(!$email){
			$message='Вы не ввели email, на который хотите получать рассылку';
			$status="nok";
		} 
		elseif(1 !== preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email)){
			$message='Email в неверном формате';
			$status="nok";
		}
		else {
			#Обрабатываем данные от пользователя
			foreach($razdels as $razdel){
				//$filtd_razdel[]=process_user_data($razdel,10);
				if($razdel=="articles") $subscr_json.='\"articles\":\"all\",';
				if($razdel=="books") $subscr_json.='\"books\":\"all\",';
				if($razdel=="videos") $subscr_json.='\"videos\":\"all\",';
				if($razdel=="jokes") $subscr_json.='\"jokes\":\"all\",';
				//if($razdel=="portal_news")
			}
			if($kws=process_user_data($_POST['keywords_filter'],300)) $subscr_json.='\"filter_kw\":\"'.$kws.'\",'; else $subscr_json.='\"filter_kw\":\"-\",';
			$subscr_json.='\"portal_news\":\"all\"';
			$subscr_json="{".$subscr_json."}";
			
			
	
			
			include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
			
			#Проверить, есть ли у юзера подписка
			$subscr_q=mysql_query("SELECT * FROM `$tableprefix-newsletter-users` WHERE `user_id`='$userid';");
			
			if(mysql_num_rows($subscr_q)==1){#Есть подписка, обновляем
				$subscr_info=mysql_fetch_array($subscr_q);
				mysql_query("UPDATE `$tableprefix-newsletter-users` SET `mail` = '".$email."',`themes`='".$subscr_json."'
				WHERE `id` = ".$subscr_info['id'].";");
				$message='Подписка на рассылку успешно обновлена'; 
			} else{	#Не было ещё подписки, добавляем новую
				mysql_query("INSERT INTO `$tableprefix-newsletter-users` (`id`, `user_id`, `mail`, `themes`) VALUES 
				(NULL, '$userid', '$email', '$subscr_json')");
				$message='Подписка на рассылку успешно добавлена'; 
			}
			$status='ok';
		}
		$aRes = array('status' => $status, 'message' =>$message,'getfunction'=>" $('#new_order_form_div').modal('show')" );
		echo json_encode($aRes);

	} elseif($_REQUEST['action']=="delete_subsctipt"){ #Удаление подписки на рассылку
		
		include($_SERVER['DOCUMENT_ROOT'].'/core/checkuserrole.php'); // Определяем userrole
		
		#Проверить, есть ли у юзера подписка
		$subscr_q=mysql_query("SELECT * FROM `$tableprefix-newsletter-users` WHERE `user_id`='$userid';");
		
		if(mysql_num_rows($subscr_q)==1){#Есть подписка, удаляем
		
		$subscr_info=mysql_fetch_array($subscr_q);
			mysql_query("DELETE FROM `$tableprefix-newsletter-users` WHERE `id` = ".$subscr_info['id'].";");
			$message='Подписка на рассылку успешно удалена'; 
			$status='ok';

		} else {

			$message='Подписка на рассылку не найдена'; 
			$status='nok';
		}
		$aRes = array('status' => $status, 'message' =>$message,'getfunction'=>" clear_subscr_form();$('#new_order_form_div').modal('show');" );
		echo json_encode($aRes);

	} elseif($_REQUEST['action']=="video_unavailable"){ #Обнаружено недоступное видео
		
		$yt_id=process_data($_REQUEST['someid1'],13);
		
		#Проверяем недоступность (в целях безопасности от стирания всех видео)
		
		$vid_avail=insert_module("youtube-api","check_video_avail","$yt_id");
		if(!$vid_avail) {#Видео недоступно
			#Деактивируем видео
			mysql_query("UPDATE `$tableprefix-videos` SET `vstatus` = 'blocked' WHERE `yt_id` = '$yt_id';");
			
			#Письмо админу
			$subject="Деактивировали видео из-за недоступности";
			$message_to_adm="Данное видео удалено из-за недоступности.<br>
			<a href='https://soznanie.club/?page=video&vid=$yt_id'>$yt_id</a>";
			#Сообщ юзеру
			$message='Данное видео удалено с Youtube. Администратор портала уже уведомлен об этом'; 
			
		} else {
			#Письмо админу
			$subject="Возможно видео недоступно";
			$message_to_adm="Данное видео, возможно, недоступно.<br>
			<a href='https://soznanie.club/?page=video&vid=$yt_id'>$yt_id</a>";
			$message='Данное видео возможно недоступно на Youtube. Администратор портала уже уведомлен об этой ситуации';
		}
		#Оповещаем админа
		insert_function("send_letter");
		sendletter_to_admin($subject,$message_to_adm);
		#Оповещаем юзера
		$status='ok';
		$aRes = array('status' => $status, 'message' =>$message);
		echo json_encode($aRes);
		
	} elseif($_REQUEST['action']=="save_banner_click"){ #Сохраняем клик по баннеру
		$banner_id=process_user_data($_REQUEST['someid1'],5);
		mysql_query("UPDATE `$tableprefix-banners` SET `clickCount`=`clickCount` +1 WHERE `banner_id`='".$banner_id."';");
	} 
	
	elseif($_REQUEST['action']=="dont_show_player_again"){ //Выключили музыку на сайте
		
		$_SESSION['dont_show_player_again']=1;//Сохраняем параметр, чтобы больше не включать музыку
	} 
	
	elseif($_REQUEST['action']=="show_onlyFatHeadphones"){ //Нажали на менюшку с наушниками. Надо показывать только толстые наушники
		
		$_SESSION['show_onlyFatHeadphones']=1;//Сохраняем параметр, чтобы показывать толстые наушники
	} 
	
	elseif($_REQUEST['action']=="add_new_video"){#Сохраняют свою страничку
	
		echo "OK";
	
	}
} ?>