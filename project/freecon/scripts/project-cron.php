<?php
 /***********************************************************************
  * Snippet Name : Project cron scripts		 					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some crontabbed functions					 		*
  * Access		 : 														*
  *  																	*
  **********************************************************************/

 $log->LogDebug('Got this file');
if ($nitka=='1'){

$now_day= date('w'); // День недели,от 0 (воскресенье) до 6 (суббота)
$now_hour = date('G');
$now_min=date('i');
$now_weekDay=date('l');
$now_date=date('Y-m-d');
$yest_date=date("Y-m-d", strtotime("yesterday"));
$this_year=date("Y");
$prev_year=$this_year-1;

################ Скачать видеоролики с youtube ################



insert_function("enum_select");
$fbos=enum_select("$tableprefix-video-channels",'update_freq'); // Все возможные периодичности обновления канала

# Общие стоп-слова для видео-роликов
$v_stop_words=array(
	"отзыв","мнение","анонс", "о программе","приглаш","о тренинг","про тренинг","мастер-класс","о курсе", "о семинар", "о мастер","о марафон","анонс","отчет о","результаты после","с новым годом","о чем тренинг", "о чем программа", "о чем курс", "о чем семинар", "о чем мастер-",'приглашение на','о тренер','invitation',
	'skinny body','Скинни боди кеа',"фаберлик","Сетевой Маркетинг","Questra","квестра",'skinnybody',"млм", "mlm","team","leader",
	'аудиокнига'
);
#Блеклист каналов
$c_blacklist=array('UCqIRXhI09gBu4-yN9AnP8pg','UCJg6FUCXB_aoWGiu7JEOe4Q','UCxfPISD8P38Y2lIJ-VlcVvw','UCdziPYxnjMKc-tlHEzyJb6w','UCy0hLvDdujr1C8OKdKlBeJg','UCKrGoyi4Zpsc38-3tqKj9qQ');

if(!$yt_api_key) $yt_api_key=set("yt_api_key");

#Функция для скачивания роликов
function YoutubeData($action,$some_id,$yt_api_key,$maxResults="15") {
	global $log;
	if($action=="get_videos_by_chid"){
	
		// выдача фида канала
		$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet'
			. '&channelId=' . $some_id
			. '&order=date' // упорядочивать по дате добавления
			. '&maxResults='.$maxResults // за раз получать не более 5 результатов
			 //. '&fields=items/id/videoId'  // нам нужны только идентификаторы видео
			. '&key=' . $yt_api_key;
			//Пример: https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCO6cpWSqqW9MKNCBtZFPJ0A&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI	
	} elseif($action=="get_videos_by_plid"){
		$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet'
			. '&playlistId=' . $some_id
			. '&order=date' // упорядочивать по дате добавления
			. '&maxResults='.$maxResults // за раз получать не более 5 результатов
			 //. '&fields=items/id/videoId'  // нам нужны только идентификаторы видео
			. '&key=' . $yt_api_key;
			//Пример:https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLqSTFWHJscVfDacNWshZkU0KfVDbq0LdH&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI
	
	} elseif($action=="get_videos_by_words"){
	
		//$words=explode(';',$some_id);
		
		$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q='.
		str_replace(' ','%20', $some_id)
		.'&order=date&type=video&maxResults='.$maxResults.'&key='. $yt_api_key;
		//Пример:    https://www.googleapis.com/youtube/v3/search?part=snippet&q=%D0%B1%D0%B8%D0%B7%D0%BD%D0%B5%D1%81%20%D0%BF%D0%BE%20%D0%B6%D0%B5%D0%BD%D1%81%D0%BA%D0%B8&order=date&type=video&maxResults=50&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI
		
	}
	$log->LogDebug("Query is ".$url);
	$buf = file_get_contents($url);
	// декодируем JSON данные
	$json = json_decode($buf, 1);
	//echo 'ДО!! Первое видео в tarr '. $json ['items']['id']['videoId'];
	//print_r($json);
	return $json;
}

insert_function('send_letter');


foreach($fbos as $fboskey=>$fbosvalue){
	if(!$stop_ch_upd){
		
		#Выбираем 1 канал, у которого подошла дата апдейта роликов
		$trash=rand(1,100000);
		$need_upd_channel=mysql_query("SELECT SQL_NO_CACHE * FROM `$tableprefix-video-channels` WHERE (`last_update`<= (NOW() - $fbosvalue*60*60) AND `update_freq`='$fbosvalue') or `last_update`='' LIMIT 0,1;#$trash");
		
		if (mysql_num_rows($need_upd_channel)>0){# Нашли такой канал
			
			$need_upd_channel_data=mysql_fetch_array($need_upd_channel);
			$log->LogDebug('Channel '.$need_upd_channel_data['yt_c_id'].' ['.$need_upd_channel_data['c_id'].'] needs udate bcs last update was '.$need_upd_channel_data['last_update']);
			#Функция для убирания ссылок из текстов роликов
			insert_function("clean_url_from_text");
			

			
			$channel_id=$need_upd_channel_data['yt_c_id'];
			
			if($need_upd_channel_data['playlists']){#Скачать видео только определенного плейлиста
			
				$pl_id=$need_upd_channel_data['playlists'];
				$log->LogDebug('Trying to get playlist '.$pl_id.' videos with api key '.$yt_api_key);
				if($need_upd_channel_data['last_update']!=='0000-00-00 00:00:00') $tarr = YoutubeData("get_videos_by_plid",$pl_id,$yt_api_key,15);
				else $tarr = YoutubeData("get_videos_by_plid",$pl_id,$yt_api_key,50);
				$log->LogDebug('playlist - ');
				
			} elseif($need_upd_channel_data['yt_c_id']) {#Скачиваем видео из общей ленты канала
				$log->LogDebug('Trying to get channel '.$channel_id.' videos');
				 #Скачиваем ленту канала
				
				if($need_upd_channel_data['last_update']!=='0000-00-00 00:00:00') $tarr = YoutubeData("get_videos_by_chid",$channel_id,$yt_api_key,15);
				else $tarr = YoutubeData("get_videos_by_chid",$channel_id,$yt_api_key,50);
				//$lastvideo[$channel_id] = array(); // Если сразу много каналов в 1 скрипте

			} elseif($need_upd_channel_data['search_words']){ # Ищем среди всех видео на youtube по ключевым словам
				$log->LogDebug('Trying to get videos by words ['.$need_upd_channel_data['c_id'].']');
				if(strstr($need_upd_channel_data['search_words'],',')){//Там несколько слов
					$words=explode(',',$need_upd_channel_data['search_words']);
					$tarr=array();
					foreach ($words as $word){
						echo $word;
						$log->LogDebug('Get data for word:'.$word);
						$tarr1= YoutubeData("get_videos_by_words",$word,$yt_api_key,15);
						
						$tarr=array_merge_recursive($tarr,$tarr1);
					}
				} else $tarr = YoutubeData("get_videos_by_words",$need_upd_channel_data['search_words'],$yt_api_key,50);
			}
			$log->LogDebug('Got '.count($tarr).' elements');
			# Перебираем полученные видео
			if ( !empty($tarr['items']) ) {
				foreach ($tarr['items'] as $v) {
					if($need_upd_channel_data['playlists']) $v_yt_id=$v['snippet']['resourceId']['videoId'];
					else $v_yt_id=$v['id']['videoId'];
					$log->LogInfo('Check '.$v_yt_id.' in DB');
					#Смотрим, есть ли видео в базе
					$v_check_q=mysql_query("SELECT `v_id` FROM `$tableprefix-videos` WHERE `yt_id`='".$v_yt_id."';");
					if(mysql_num_rows($v_check_q)==0){#Видео не в базе - записываем его в базу
						
						#Получаем данные о видеоролике

						$log->LogInfo('Video '.$v_yt_id.' is not in DB');
						$vjson = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".$v_yt_id."&key=".$yt_api_key);
						
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
								$v_yt_channel=$item->snippet->channelId;
								if($item->snippet->tags){
									foreach($item->snippet->tags as $tag){
										//if(substr($tag,0,1)=="#")$tag=substr($tag,1);
										$tag=str_replace("#",'',$tag);
										$tags.=$tag.";";
									}
									$tags.=$need_upd_channel_data['c_tags'];//Прибавили к тегам видео еще и тег канала, чтобы можно было сортировать по разделам прямо в теге
								}
							}
							
							$vtitle = htmlspecialchars(trim((string)$title)); // подготовили заголовок
							
							#Ассоциативные теги из заголовка
							$phrase=$vtitle;
							include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/get_associative.php');
							$tags=$tags.implode(";",$fin_assoc_arr);

							$vdescription = !empty($description) ? htmlspecialchars(trim((string)$description)) : ""; // подготовили описание, проверив на пустоту. Если в пустое поле надо что то написать, то заполняем кавычки
							
							#Убираем ссылки из текста
							$vtitle=clean_url_from_text($vtitle);
							$vdescription=clean_url_from_text($vdescription);
												
							$author = htmlspecialchars(trim((string)$author)); // автор видео
						
							# ПРОВЕРКА НА РОЛИКИ С ДРУГИМ ID НО С ТЕМИ ЖЕ НАЗВАНИЯМИ
							$v_titl_dupl_chk_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `vtitle`='".$vtitle."';");
							if(@mysql_num_rows($v_titl_dupl_chk_q)>0){
								$v_titl_dupl_chk=mysql_fetch_array($v_titl_dupl_chk_q);
								$dupicated_id=$v_titl_dupl_chk['yt_id'];
							} else $dupicated_id="NULL";
						
							#Проверяем на стоп-слова
							$v_title_sml=mb_strtolower ( $vtitle, "UTF-8");
							foreach($v_stop_words as $v_stop_word){
								if(stristr($v_title_sml,$v_stop_word)) $stop_this_video=1;
							}
							if($need_upd_channel_data['search_words'] and !$need_upd_channel_data['playlists'] and !$need_upd_channel_data['yt_c_id']){#В поиске по словам проверяем в блеклисте каналов
								foreach($c_blacklist as $black_c){
									if($black_c==$v_yt_channel) $stop_this_video=1;
								}
							}
							
							if($stop_this_video!==1){//Нет стоп-слов, можно 
								$log->LogDebug('Got info from youtube: TITLE - '.$vtitle.' AUTOR -'.$author. ' PUBLISHED - '. $published );
								
								if($need_upd_channel_data['search_words'] and !$need_upd_channel_data['playlists'] and !$need_upd_channel_data['yt_c_id']){    # В поиске по словам надо проверить, нет ли этого канала на мониторинге
									if(!$mon_channels){ # Надо получить данные обо всех каналах
										$mon_channels_q=mysql_query("SELECT * FROM `$tableprefix-video-channels` WHERE 1;#$trash");
										while($mon_channel=mysql_fetch_array($mon_channels_q)){
											$mon_channels[$mon_channel['yt_c_id']]=1; //Сохранили все возможные каналы в массив
										}
									}
									#Проверяем есть ли данный канал на мониторинге
									if(!$mon_channels[$v_yt_channel]){#Такого канала нет в нашем реестре, возможно, стоит добавить этот канал на мониторинг, проверяем, появлялся ли он на видосах:
										
										$check_ch_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `autor`='".$author."' limit 0,1;");
										//$log->LogDebug("SELECT * FROM `$tableprefix-videos` WHERE `autor`='".$author."' limit 0,1;");
										
										
										
										if(mysql_num_rows($check_ch_q)<1){ # Такой канал ни разу не встречался, надо оповестить письмом
										
										
											$YT_possible_channels_file = $_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/YT_possible_channels.txt'; //Реестр обнаруженных каналов
											insert_function("file_search_in");
											if(!file_search_in ( $YT_possible_channels_file, $v_yt_channel )){//Такого канала еще не отправляли
										
												$subject='Новый канал для мониторинга - '.$author;
												$message='Обнаружен новый канал по запросу '.$need_upd_channel_data['search_words'].'
												<br><a href="https://www.youtube.com/channel/'.$v_yt_channel.'">'.$author.'</a>';
												
												sendletter('aromanuk@mail.ru',$subject,$message);
												
												#Пишем сообщение в табличку events
												mysql_query("INSERT INTO `$tableprefix-portal-events` 
												(`event_id`, `text`, `status`, `type`, `link`) VALUES 
												(NULL, '$message', 'new', 'need_moderate', NULL);");
												
												#пишем канал в реестр возможных каналов на мониторинг
												
												file_put_contents($YT_possible_channels_file, $v_yt_channel."\n", FILE_APPEND | LOCK_EX);
											}
										}
									}
								}
								if(strstr($need_upd_channel_data['filter_rules'],"auto_apply")) { // Механизм автоподтверждения включен
									
									
									$new_v_status='active'; // Статус видео
									/*
									$p_exst_chk=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page`='$v_yt_id'");//Есть ли такая страница
									if(mysql_num_rows($p_exst_chk)>0){
										#Страница суествует в БД, не вставляем её
										$log->LogError('Page '.$yt_id.' is already exist in PAGE table');
										
									} else{
										#Вставляем страницу
										$v_details=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `yt_id` = '".$v_yt_id."' LIMIT 0,1;"));
										$ins_page_q=mysql_query("INSERT INTO `$tableprefix-pages` 
										( `page`, `pagetitle_ru`, `pagetitle_en`, `folder`, `filename`, `pagebody_ru`, `pagebody_en`, `module_page`, `page_menu`, 
										 `canbechanged`, `autor`, `SEO-title_ru`, `SEO-title_en`, `SEO-keywds_ru`, `SEO-keywds_en`, `SEO-descrtn_ru`,`SEO-descrtn_en`,
										`showin_all_pages_page`, `is_articles`, `script_after_page`, `creation_date`) VALUES 
										('".$v_yt_id."', '".$vtitle."', '".$vtitle."', '/pages/', 'videopage.php', NULL, NULL, NULL, NULL, 
										'yes', '1035', '".$vtitle."', '".$vtitle."', '". str_replace (';',' ',$tags)."', '".str_replace (';',' ',$tags)."', '".$vtitle."', '".$vtitle."', '0', '0',
										NULL, '". substr($published,0,10)." 00:00:00');");
										$log->LogDebug('New page inserted successfully '.mysql_insert_id($ins_page_q));
									}*/
								} else $new_v_status='need_moderate';
								
								#Записываем видео в БД
								$new_v_add_qt="INSERT INTO `$tableprefix-videos` (`v_id`, `yt_id`,`ch_id`, `autor`, `vtitle`, `v_full_desc`,`yt_publishedAt`,`vstatus`, `tags`,`duplicates`) VALUES 
								(NULL, '".$v_yt_id."', '".$need_upd_channel_data['c_id']."','$author', '$vtitle', '$vdescription', '$published', '".$new_v_status."','$tags','$dupicated_id');";
								$new_v_add_q=mysql_query($new_v_add_qt);
								if(mysql_insert_id()) {#ВИДЕО УСПЕШНО ВСТАВЛЕНО В БД
									$log->LogInfo('Video inserted to database:'.mysql_insert_id());
									if(strstr($need_upd_channel_data['filter_rules'],"auto_apply")) {#Постим в соцсети
										
										#Постим видео в ВКОНТАКТЕ
										insert_module('vk-api','video.save',"$v_yt_id","$vk_group_id");
									
										#Пост в канал Youtube "Поток видео по психологии"
										
									}
								}
								if($dupicated_id){ #Предупреждаем админа, что возможно видео - дубль с тем же названием,но с другим ID
									$subject='Возможно дублирование видео';
									$message='Обнаружено новый видеоролик с тем же названием, но с другим ID - 
									<br>Новое видео<a href="soznanie.club/?page='.$v_yt_id.'"><img src="//img.youtube.com/vi/'.$v_yt_id.'/0.jpg">'.$vtitle.'</a>
									<br>Уже существующее видео<a href="soznanie.club/?page='.$dupicated_id.'"><img src="//img.youtube.com/vi/'.$dupicated_id.'/0.jpg">'.$vtitle.'</a>';
									
									//sendletter('aromanuk@mail.ru',$subject,$message);
								}
								else $log->LogError('Video not inserted to database. Error is '.mysql_error().' SQL was - '.$new_v_add_qt);
							} else $log->LogDebug("Video contains stop word or video from stop channel");
						
						} else { // произошла ошибка при парсинге
							$log->LogError('Cant get data about video from YT - '.$v_yt_id);
						}
						
						$tags='';$stop_this_video=0;
					} else{ #Видео есть в БД
						$v_id_indb=mysql_fetch_array($v_check_q);
						$log->LogDebug('Got video in DB. Id is = '.$v_id_indb['v_id']);
					}	
				}
			}
			
			# отмечаем, что мы только что скачали видео этого канала
			$ch_upd_q=mysql_query("UPDATE `$tableprefix-video-channels` SET `last_update` = CURRENT_TIMESTAMP WHERE `c_id` = ".$need_upd_channel_data['c_id']);
			if(!$ch_upd_q){
				$log->LogError("Channel LAST_UPDATE is not updated because an error:".mysql_error());
			}
			$stop_ch_upd=1; // Остановили апдейты каналов до следующей минуты
		} else $log->LogDebug('Not found channel for '.$fbosvalue.' hours');
	}
}
if(!$stop_ch_upd){ $log->LogInfo('No need to check any youtube channel now');}
else  $log->LogDebug('End of youtube channel update');

/*



################  Обновить картинки (torrents) ################






$all_torr_db_q=mysql_query('SELECT * FROM `freecon-torrents` where `orig_img` IS NULL or `orig_desc` IS NULL limit 0,10;');
while ($all_torr=mysql_fetch_array($all_torr_db_q)){
	$log->LogDebug('Download torrent page for '.$all_torr['topic_id']);
	$filePath='http://rutracker.org/forum/viewtopic.php?t='.$all_torr['topic_id'];
	$html=file_get_contents($filePath);
	$html = mb_convert_encoding($html, 'utf-8', 'cp1251');
	if(!$all_torr['orig_img']){
		$needle='<var class="postImg postImgAligned img-right" title="';
		$img_cl_pos=strpos($html,$needle);
		$img_start_p=$img_cl_pos+mb_strlen($needle);
		//echo '1я точка - '.$img_cl_pos. 'Сдвиг - '.mb_strlen($needle) .' Начинаем с '.$img_start_p;

		$img_fin_pos=strpos($html,'"',($img_cl_pos+mb_strlen($needle)));
		$uri_lenght=$img_fin_pos-$img_start_p;
		//echo ' 2я точка - '.$img_fin_pos. ' Длина URI - '.$uri_lenght;
		$img_src=substr($html,$img_start_p,$uri_lenght);
		
		
		#Проверяем доступность картинки
		ini_set('default_socket_timeout', '10');
		$fp = fopen($img_src, "r");
		$res = fread($fp, 500);
		fclose($fp);
		if (strlen($res) > 0) mysql_query("UPDATE `freecon-torrents` SET `orig_img` = '".$img_src."' WHERE `topic_id` = ".$all_torr['topic_id']);
		
		else mysql_query("UPDATE `freecon-torrents` SET `orig_img` = 'no' WHERE `topic_id` = ".$all_torr['topic_id']);
	}
	if(!$all_torr['orig_desc']){
		#Поиск дскрипшна
		$needle2='<div class="post_body"';
		$desc_cl_pos=strpos($html,$needle2);
		$desc_frst_pos=strpos($html,'>',($desc_cl_pos+mb_strlen($needle2)));
		//echo '1='.$desc_cl_pos. ' Real 1='.$desc_frst_pos;
		$needle3='<div class="clear"';
		$desc_fin_pos=strpos($html,$needle3,$desc_frst_pos);
		$desc_lenght=$desc_fin_pos-$desc_frst_pos;
		//echo "FIN pos=".$desc_fin_pos. "Desc lenght=".$desc_lenght;
		$desc_html=strip_tags(substr($html,$desc_frst_pos+1,$desc_lenght));
		//$desc_html= htmlentities($desc_html,ENT_QUOTES);
		$desc_html=str_replace("'", "",$desc_html);
		$desc_html=str_replace('"', "",$desc_html);
		//echo '<pre>'.$desc_html.'</pre>';
		mysql_query("UPDATE `freecon-torrents` SET `orig_desc` = '".$desc_html."' WHERE `freecon-torrents`.`topic_id` = ".$all_torr['topic_id']);
	}
}*/

################ ПОСТ НА СТЕНУ ВКОНТАКТЕ И ДРУГИЕ СОЦ.СЕТИ ################

$log->LogDebug('-- Check if its needed to post to social network wall');



$post_plan=array(
'sd'=>array(
	'1'=>'article',
	'2'=>'insta',
	'3'=>'article',
	'5'=>'article',
	'7'=>'article',
	'8'=>'video',
	'11'=>'insta',
	//'11'=>'soc_post',
	'12'=>'insta',
	'13'=>'article',
	'14'=>'book',
	'15'=>'joke',
	//'16'=>'book',
	'16'=>'insta',
	'17'=>'article',
	'18'=>'article',
	'19'=>'article',
	'20'=>'insta',//
	'21'=>'day_articles',
	'22'=>'video',
	//'22'=>'product',
	'23'=>'article'
	),
'vd'=>array(
	'1'=>'article',
	'3'=>'article',
	'5'=>'article',
	'7'=>'article',
	'9'=>'article',
	'10'=>'article',
	'11'=>'video',
	'12'=>'article',
	'13'=>'video',
	'14'=>'article',
	'15'=>'book',
	'16'=>'video',
	'17'=>'article',
	'18'=>'video',
	'19'=>'article',
	'20'=>'article',
	//'21'=>'video',
	'21'=>'product',
	'22'=>'article',
	'23'=>'article'
	)
);

if($now_day>0 and $now_day<=5) $dn='sd'; else $dn='vd'; //Определяем, выходной день или будний

$log->LogDebug('Now is '.$dn.' [sd = usual day, vd = vikhodnoy day]');

//if ($now_hour >= array_shift($post_plan[$dn]) && $now_hour < array_pop ($post_plan[$dn])) { #day
if($post_plan[$dn][$now_hour]){
	if ((time() - strtotime($vk_wall_lastposttime))/(60*60)>1){ //Прошло более часа, пора постить
		$post_flag=1;
	}
}

if($post_flag==1){
	$stop_post=0; //Флаг для останова постинга, пока не взведен
	$log->LogInfo('Need to put new post to VK');

	if($post_plan[$dn][$now_hour]=="book"){ #Надо постить книжку
		

		$ten_yearAgo_year=$this_year-10;
		
		#Выберем свеженькую книжку
		$new_post_query=mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `soc_posted` is null and `status`='active' and 
		(`year`='".$prev_year."' or `year`='".$this_year."') ORDER BY RAND() LIMIT 0,1;");
	
		if(mysql_num_rows($new_post_query)==0){ //Нет книг за этот год, надо постить хоть какую то, за прошлые 10 лет
			unset($new_post_query);
			$new_post_query=mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `soc_posted` is null and `status`='active' and 
			`year` BETWEEN '".$ten_yearAgo_year."' AND '".($prev_year-1)."' ORDER BY RAND() LIMIT 0,1;");
		}
		
		$new_post_q=mysql_fetch_array($new_post_query);
		unset($new_post_query);
		$log->LogInfo('Need to post a BOOK accorging post_plan. New book ID='. $new_post_q['id']);
		
		$alltags=explode(',',$new_post_q['cat_name']);
		$book_emoji_arr=array("📕","📖","📗","📘","📙","📚");
		$rand_keys = array_rand($book_emoji_arr, rand(1,6));

		foreach($rand_keys as $rand_key){
			$post_text.=$book_emoji_arr[$rand_key];
		}

		$post_text.='Что почитать'."\r\n".$new_post_q['name'];
		$tg_mes=$post_text;
		
		if($new_post_q['cat_name']=="Астрология") $post_text.="🌞✨🌛";
		$post_text.='['.$new_post_q['cat_name'].']'."\r\n".
			'Подробнее 👉 https://'.$sitedomainname.'/?page=book&topic_id='.$new_post_q['topic_id']."&from=post_vk\r\n\r\n";
		$tg_mes.='['.$new_post_q['cat_name'].']'."\r\n".
			'Подробнее 👉 https://'.$sitedomainname.'/?page=book&topic_id='.$new_post_q['topic_id']."&from=post_tg\r\n\r\n";
		
		if($book_info['orig_desc']!==NULL){
			$post_text.='Про что книга: '."\r\n".$new_post_q['orig_desc'];
		} elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$new_post_q['topic_id'])) {
		
			$post_text.='Про что книга: '."\r\n".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/pages/torrents/'.$new_post_q['topic_id']);
			
		}
		
		#Формируем приклады к посту
		$vk_post_attach=array('link'=>'https://'.$sitedomainname.'/?page=book&topic_id='.$new_post_q['topic_id'].'&from=post_vk');
	
		if(strstr($new_post_q['orig_img'],"http")){//У книги есть обложка, надо постить картинку в вк
			$log->LogInfo('Need to download image to our server');
			$image_path = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/'.basename($new_post_q['orig_img']);
			$image_download=file_put_contents($image_path, file_get_contents($new_post_q['orig_img']));
			if($image_download) {
				$log->LogInfo("Image ".$new_post_q['orig_img'].' successfully downloaded and attached to post query');
				$vk_post_attach['image']=$image_path;
			}
			else $log->LogError("Image ".$new_post_q['orig_img'].' NOT downloaded');
		}
		
		#Сообщение в телеграм
		//$tg_mes=$post_text;
		$tg_img=$image_path;
		
		mysql_query("UPDATE `$tableprefix-torrents` SET `soc_posted` = CURRENT_TIMESTAMP WHERE `id` = ".$new_post_q['id'].";");
	}
	elseif($post_plan[$dn][$now_hour]=="video"){ #Постим видео
	
		$log->LogDebug('Need to post a VIDEO accorging post_plan');
		
		$new_vk_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `vk_v_id` is not null and `vk_posted_At` is null AND `vstatus`='active' ORDER by `yt_publishedAt` DESC LIMIT 0,1;");
		if(mysql_num_rows($new_vk_q)>0){
			$new_vk_v=mysql_fetch_array($new_vk_q);
			$log->LogDebug('New video ID='. $new_vk_v['v_id'].' ('.$new_vk_v['yt_id'].')');
					
			$alltags=explode(';',$new_vk_v['tags']);
			
			$post_text=$vk_post_text= htmlspecialchars_decode ($new_vk_v['vtitle']).' ('.mb_substr($new_vk_v['yt_publishedAt'],0,10).')'."\r\n\r\n".$new_vk_v['v_full_desc']."\r\n\r\n".'Оригинал - https://'.$sitedomainname.'/?page='.$new_vk_v['yt_id'].'&from=post_vk';
			
			$vk_post_attach['video']='video-'.$vk_group_id.'_'.$new_vk_v['vk_v_id'];
			
			
			
			#Сообщение в телеграм
			$tg_img="img.youtube.com/vi/".$new_vk_v['yt_id']."/0.jpg";
			$tg_mes=htmlspecialchars_decode ($new_vk_v['vtitle'])."\n".mb_substr($new_vk_v['v_full_desc'],0,100)."...\n".
				'https://'.$sitedomainname.'/?page='.$new_vk_v['yt_id'].'&from=post_tg';
				
			# Обозначаем дату поста, чтобы не было повторных постов видео
			mysql_query("UPDATE `$tableprefix-videos` SET `vk_posted_At` = CURRENT_TIMESTAMP WHERE `v_id` = ".$new_vk_v['v_id'].";");
		} else {// Нет видео для постинга
			$log->LogError('No new video to post');
			$stop_post=1;
		}
		
	}
	elseif($post_plan[$dn][$now_hour]=="soc_post"){
		$log->LogDebug('Need to post a SOCIAL QUEUE POST accorging post_plan');
		$soc_post_q=mysql_query("SELECT * FROM `$tableprefix-social-post` WHERE `post_ts` is null ORDER BY RAND() LIMIT 0,1;");
		if(mysql_num_rows($soc_post_q)>0){
		
			$vk_post_info=mysql_fetch_array($soc_post_q);
			
			$alltags=explode(';',$vk_post_info['tags']);
			
			$vk_post_text=$vk_post_info['source']."\n\n".$vk_post_info['post_text']."\n\n".$vk_post_info['author'];
			$vk_post_attach='';
			
			#Сообщение в телеграм
			$tg_mes=$vk_post_text;
				

			mysql_query("UPDATE `$tableprefix-social-post` SET `post_ts` = CURRENT_TIMESTAMP WHERE `post_id` = ".$vk_post_info['post_id'].";");
		} else {// Нет инфо для постинга
			$log->LogError('No new social post to post');
			$stop_post=1;
		}
	}
	elseif($post_plan[$dn][$now_hour]=="article"){ # Постим статью
		$log->LogDebug('Need to post an article accorging post_plan');

		#Получаем 10 страничек со статьями за последний месяц
		$start_date=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
		$end_date_db=date("Y-m-d H-i");
	
		$soc_post_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `is_articles` = 1 and `creation_date`>='$start_date' and `creation_date`<='$end_date_db' ORDER BY RAND() LIMIT 0,10;");
		while($post_info=mysql_fetch_array($soc_post_q)){
			
			#Проверяем не было ли соц поста для каждой из 10 статей
			$soc_check_q=mysql_query("SELECT * FROM `$tableprefix-social-post` WHERE `source`='".$post_info['page']."';");
			
			if(mysql_num_rows($soc_check_q)==0){#Статью ещё не постили, подходит для постинга
				$log->LogInfo('This article is not posted to social yet,Page - '.$post_info['page']);
				$alltags=explode(';',$post_info['tags']);
				
				if($post_info['pagebody_ru']){
					$post_pagebody=$post_info['pagebody_ru'];
					$log->LogDebug('Body got from DB');
				}
				elseif($post_info['filename'] and file_exists($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$post_info['page'])){
				
					$post_pagebody=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$post_info['page']);
					$log->LogDebug('Body got from file');
				}
				
				$post_pagebody=str_replace("<br>","\r\n",$post_pagebody);
				$post_pagebody=str_replace("</p>","\r\n",$post_pagebody);
				$post_pagebody=htmlspecialchars_decode(strip_tags($post_pagebody));
				
				$log->LogDebug('Body size is '.mb_strlen($post_pagebody));
				//$post_text=$post_info['pagetitle_ru']."\n\n".mb_substr($post_pagebody,0,800)."\n\n".'Читайте продолжение статьи -> https://'.$sitedomainname.'/?page='.$post_info['page'].'&from=social';
				$post_text=$post_info['pagetitle_ru']."\n\n".$post_pagebody."\n\n".'Читайте оригинал статьи -> https://'.$sitedomainname.'/?page='.$post_info['page'].'&from=post_vk';
				
				#Формируем приклады к посту
				$vk_post_attach=array('link'=>'https://'.$sitedomainname.'/?page='.$post_info['page'].'&from=post_vk');
			
				if($post_info['page_img']){
					$log->LogInfo('Need to download image');
					$image_path = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/'.basename($post_info['page_img']);
					$image_download=file_put_contents($image_path, file_get_contents($post_info['page_img']));
					if($image_download) {
						$log->LogInfo("Image ".$post_info['page_img'].' successfully downloaded and attached to post query');
						$vk_post_attach['image']=$image_path;
						
					}
					else $log->LogError("Image ".$post_info['page_img'].' NOT downloaded');
					
					$tg_img=$post_info['page_img']; // Картинка для Телеграма
				} 
				
				#Сообщение в телеграм
				$tg_mes=$post_info['pagetitle_ru']."\n".mb_substr($post_pagebody,0,100)."...\n".
				'https://'.$sitedomainname.'/?page='.$post_info['page'].'&from=post_tg';
				
				#Сохраняем в соц посты, чтобы не было повторных постов
				mysql_query("INSERT INTO `freecon-social-post` (`post_id`, `post_text`, `author`, `source`, `post_img`, `tags`, `post_ts`) VALUES (NULL, 'article', NULL, '".$post_info['page']."', NULL, '".$post_info['tags']."', CURRENT_TIMESTAMP);");
				break;
			}
		}
		if(!$post_text){
			// Нет инфо для постинга
			$log->LogError('No article to post in 10 random articles, all already posted');
			$stop_post=1;
		}
		
	}
	elseif($post_plan[$dn][$now_hour]=="insta"){#Постим в инстаграм
	
		#Получение случайной статьи со словами ОТНОШЕНИ и ЛЮБОВ
		$insta_artcl=mysql_fetch_assoc(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `is_articles`='1' AND (`pagetitle_ru` LIKE '%отношени%' OR `pagetitle_ru` LIKE '%любов%') and `page_img` NOT LIKE '%psychologos%' and `status`='ena' ORDER BY RAND() LIMIT 0,1;"));

		if($insta_artcl['page_img']){ //Есть фотка, которую, собственно, надо постить
			
			#Скачиваем фото
			$image_path = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/'.basename($insta_artcl['page_img']);
			$image_download=file_put_contents($image_path, file_get_contents($insta_artcl['page_img']));
			
			if($image_download) { //Успешно скачали фото
				
				$log->LogInfo("Image ".$insta_artcl['page_img'].' successfully downloaded and attached to post query');
				
				#обрабатываем картинку
				insert_function("image_makeRoundCorners");
				$radius = 10;
				$background = 0xffffff;
				//параметры изображения
				list($width, $height, $type, $attr) = getimagesize($image_path);
				// закругляем углы
				$imgCorner = image_makeRoundCorners($image_path, $radius, $background);
				/*
				//Накладываем лейбл
				$label_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/insta_label_pink.png');
				$label_width=300;
				$label_HEIGHT=100;
				imagecopy($imgCorner, $label_image, 0, 0, 0, 0, $label_width, $label_HEIGHT);
				*/
				
				//Рисуем прямоугольник под надпись
				$label_image = @imagecreate($width, $height/5) or die("Невозможно создать поток изображения");
				
				$color_array=array("ff6641","f69d00","ffe100","00c48a","57C3ED","0aa4bb","cb69fe"); //массив с нашими цветами
				
				$txt_color_hex=$color_array[mt_rand(0, count($color_array) - 1)];//случайно выбранный цвет
				
				insert_function("hexRgb");//фция перевода hex в rgb
				$txt_color=hexToRgb($txt_color_hex);
				
				$base_hgt=$height*8/10; //основная высота, на которой будет надпись
				
				$background_color = imagecolorallocate($label_image, $txt_color["R"], $txt_color["G"], $txt_color["B"]); //Фон прямоугольника
				imagecopy($imgCorner, $label_image, 0, $base_hgt-$height/10, 0, 0, $width, $height/5); //Накладываем
				//Рисуем текст на картинке
				$txtColor = imagecolorallocate($imgCorner , 0xFF, 0xFF, 0xFF);;
				if($width<500) $font_size=10;
				else $font_size=20;
				$font=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/templates/general2/files/ProximaNova-Black.ttf';
				$text_arr=explode(" ",$insta_artcl['pagetitle_ru']);
				$text="[Ψ] ".strtoupper($text_arr[0])." ".strtoupper($text_arr[1])." ".strtoupper($text_arr[2]); //название на картинке - 3 первых слова. Загадочно
				imagettftext($imgCorner, $font_size, 0, $width/4, $base_hgt+$font_size/2, $txtColor , $font, $text); //Наноим надпись
				imagejpeg($imgCorner,$image_path);
				
				#Получаем текст статьи из файла и готовим к постингу
				$caption_Text=strtoupper($insta_artcl['pagetitle_ru'])."\n\n".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/'.$insta_artcl['page']);
				$caption_Text=str_replace("<br>","\n",$caption_Text);
				$caption_Text=str_replace("</p>","\n",$caption_Text);
				$caption_Text=htmlspecialchars_decode(strip_tags($caption_Text));
				
				#Короткая ссылка на статью
				$short_url=file_get_contents("https://clck.ru/--?url=https://".$sitedomainname."/?page=".$insta_artcl['page'].'&from=post_insta');

				#Стандартные теги
				$article_tags="#психологияотношений #любовь #любовьмоя #любовьморковь #любовьвсеймоейжизни #любовьспасетмир #любовьвсейжизни #любовьэто #любовьспервоговзгляда #любовьнавсегда #отношения #обнимашки #поцелуй #поцелуйчики #сердце #амур #парень #девушка #пара #романтика #навсегда #иньянь #люби #он #она #чувства #мужчинамечты #мужчинамоеймечты #психология #soznanie_club";

				#Прицеп после статьи

				$pricep1="Оригинал читайте -> ".$short_url;

				$pricep2="..."."\r\r"."Дальше -> ".$short_url;

				#Итоговый текст подписи
				if(mb_strlen($caption_Text.$pricep1)<2200){ //Текст вместе с прицепом меньше, чем ограничение (то есть статья достаточно короткая)
					
					$caption_Text=$caption_Text.$pricep1;

				} else { //Статья достаточно длинная, где то на грани или больше ограничения
					
					$caption_Text=mb_substr($caption_Text,0,(2200-mb_strlen($pricep2))).$pricep2;

				}

				$post_params=array(
					"username"=>"soznanie_club",
					"password"=>"Tribe2121",
					"photo"=>$image_path,
					"text"=>$caption_Text
				);
				$mediaId=insert_module("instagramAPI","make_post",$post_params); //Запостили картинку и получили ID записи
				
				#Стереть картинку
				unlink($image_path);
				
				if($mediaId){ //Картинка запостилась, пишем хештеги в коммент
					#Подождать 10-15 секунд
					sleep (rand(10,15));
					#Запостим коммент с тегами
					
					$post_params=array(
						"username"=>"soznanie_club",
						"password"=>"Tribe2121",
						"mediaId"=>$mediaId,
						"text"=>$article_tags
					);
					insert_module("instagramAPI","put_commentToPost",$post_params);
				}
				
			}
			else {
				$log->LogError("Image ".$new_post_q['orig_img'].' NOT downloaded');
				echo "image not downloaded";
			}
			
		}
	
	}
	elseif($post_plan[$dn][$now_hour]=="joke"){ # Постим анекдот
		
		$log->LogDebug('Need to post an joke accorging post_plan');
			
		$post_info=mysql_fetch_array(mysql_query("SELECT * from `$tableprefix-jokes` where `$tableprefix-jokes`.`joke_id` not in (select `source` from `$tableprefix-social-post` WHERE `post_text`='joke') LIMIT 0,1;"));
		
		#Очищаем текст		
		$post_pagebody=str_replace("<br>","\r\n",$post_info['text']);
		$post_pagebody=str_replace("</p>","\r\n",$post_pagebody);
		$post_pagebody=htmlspecialchars_decode(strip_tags($post_pagebody));
		
		$log->LogDebug('Body size is '.mb_strlen($post_pagebody));
		
		$post_text=$post_pagebody."\n\n🤣 ПсихоШутка про Ψ \n\n -------------------- \n\n".'Читайте ещё анекдоты -> https://'.$sitedomainname.'/?page=psy_jokes&from=post_vk'."\n\n\n\n";
		$tg_mes=$post_pagebody."\n\n🤣 ПсихоШутка про Ψ \n\n -------------------- \n\n".'Читайте ещё анекдоты -> https://'.$sitedomainname.'/?page=psy_jokes&from=post_tg'."\n\n\n\n";
		#Теги
		$alltags=array("шутки_о_психах", "шутки_о_психологах","анекдот_о_психах", "анекдот_о_психологах");
		
		#Метим шутку, что ее уже постили
		mysql_query("INSERT INTO `$tableprefix-social-post` ( `post_text`,  `source`) VALUES ('joke', '".$post_info['joke_id']."');");

	} elseif($post_plan[$dn][$now_hour]=="day_articles"){ #Постим ссылки на все статьи, которые вышли за прошедшие сутки
	
		$log->LogDebug('Need to post all articles accorging post_plan');
		#Получаем странички со статьями за прошедшие сутки
		$soc_post_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE 
		`is_articles` = 1 AND `status`='ena' AND `creation_date` BETWEEN  NOW() - INTERVAL 1 DAY AND NOW() 
		ORDER BY `viewCount` DESC;");

		if(mysql_num_rows($soc_post_q)!==0){
			$post_text=$post_text['fb']="Статьи по психологии, отношениям и бизнесу за прошедшие сутки\n\n";
			while($vk_post_info=mysql_fetch_array($soc_post_q)){
				
				
					$post_text.=$vk_post_info['pagetitle_ru']."\n".
					'https://'.$sitedomainname.'/?page='.$vk_post_info['page'].'&from=post_vk'."\n\n";
					
					$post_text['fb']= $vk_post_info['pagetitle_ru']."\n".
					'https://'.$sitedomainname.'/?page='.$vk_post_info['page'].'&from=post_fb'."\n\n";
					#Картинка к посту
					/*$tg_img=*/$vk_post_attach['image']= $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/daily_articles.jpg';
					
					 
					
					#Сообщение в телеграм
					//$tg_mes.=$vk_post_info['pagetitle_ru']."\n".
					//'https://'.$sitedomainname.'/?page='.$vk_post_info['page'].'&from=post_in_telegram'."\n";
				
			}


			if(!$post_text){
				// Нет инфо для постинга
				$log->LogError('No article to post in 10 random articles, all already posted');
				$stop_post=1;
			}
		}
	
	} elseif($post_plan[$dn][$now_hour]=="day_videos"){ #Сборный пост с присоединенными видосиками за день
		
		$log->LogDebug('Need to post all day videos accorging post_plan');
		#Получаем одобренные видео за прошедшие 2 суток, что ещё не постили в ВК
		$soc_post_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `vstatus`='active' AND `vk_v_id` is not null and `vk_posted_At` is null AND `yt_publishedAt`  BETWEEN '".$yest_date." 00:00:00.000000' and '".$now_date." 23:59:59.999999';");
		
		if(mysql_num_rows($soc_post_q)!==0){
			$post_text="Видео по психологии за прошедшие сутки\n\n";
			$vk_post_attach=array();
			$added_vid_count=0; //Счетчик присоединенных к посту видео
			
			while($post_info=mysql_fetch_array($soc_post_q)){
				$added_vid_count++;
				
				#Добавляем запись о видео к тексту поста в ВК
				$post_text.=htmlspecialchars_decode ($post_info['vtitle'])."\n".
				'https://'.$sitedomainname.'/?page=video&vid='.$post_info['yt_id'].'&from=post_in_vk'."\n\n";
				
				#Добавляем запись о видео к тексту поста в телеграм
				$tg_mes.=htmlspecialchars_decode ($post_info['vtitle'])."\n".
				'https://'.$sitedomainname.'/?page=video&vid='.$post_info['yt_id'].'&from=post_in_telegram'."\n";
				
				
				if($added_vid_count<10){ #Если приложений к посту не более 10
					#Добавляем приклады к посту
					$vk_post_attach['video'][]='video-'.$vk_group_id.'_'.$post_info['vk_v_id'];
					#Обновляем инфо о видео в БД
					mysql_query("UPDATE `$tableprefix-videos` SET `vk_posted_At` = CURRENT_TIMESTAMP WHERE `v_id` = ".$post_info['v_id'].";");
				}
			}	
				
			print_r($vk_post_attach);
			if(!$post_text){
				// Нет инфо для постинга
				$log->LogError('No videos to post, all already posted or no videos');
				$stop_post=1;
			}
		}
		
	} elseif($post_plan[$dn][$now_hour]=="product"){ #Нужно постить продукт
		
		#Получаем продукт
	
		$post_info=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-product` WHERE `status` = 'active' ORDER BY RAND() LIMIT 0,1;"));
		
		$alltags=explode(';',$post_info['tags']);
			
		$post_pagebody=$post_info['product_full_description_ru'];
		$post_pagebody=str_replace("<br>","\r\n",$post_pagebody);
		$post_pagebody=str_replace("</p>","\r\n",$post_pagebody);
		$post_pagebody=htmlspecialchars_decode(strip_tags($post_pagebody));
		
		$log->LogDebug('Body size is '.mb_strlen($post_pagebody));
		
		include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/get_phrase.php');
		
		$post_text='😌😏☺😃 УЧИМСЯ САМИ '."\n\n".$prases_arr[array_rand($prases_arr)]."\n\n".mb_strtoupper($post_info['product_full_title_ru'])."\n\n".$post_pagebody."\n\n".'Узнать цену и подробности -> https://'.$sitedomainname.'/?page=swpshop&action=show_product&productid='.$post_info['product_id'].'&from=post_in_vk';
		
		#Формируем приклады к посту
		$vk_post_attach=array('link'=>'https://'.$sitedomainname.'/?page=swpshop&action=show_product&productid='.$post_info['product_id'].'&from=');
	
		if($post_info['product_main_image']){
			
			$tg_img=$vk_post_attach['image']=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/'.$post_info['product_main_image']; //Картинка для VK	
			
		} else $log->LogError("Product has no image");
		
		#Сообщение в телеграм
		$tg_mes=mb_strtoupper($post_info['product_full_title_ru'])."\n".mb_substr($post_pagebody,0,100)."...\n".
		'https://'.$sitedomainname.'/?page=swpshop&action=show_product&productid='.$post_info['product_id'].'&from=post_in_telegram';
		
	}
	
	if(empty($post_text)){
		$log->LogError('No text to post. Stop operation');
		$stop_post=1;
	}

	if($stop_post!==1){
		#Форматируем теги
		foreach($alltags as $tag){
			if($tag){
				if(substr_count($tag,' ')>0){#Тег содержит пробелы
					if(substr($tag,0,1)==' ') $tag=substr($tag,1);//В начале пробел
					if(substr($tag,0,-1)==' ') $tag=substr($tag,0, -1);//В конце пробел
					$tags.='#'.str_replace(' ','_',$tag).' ';
					$tags.='#'.str_replace(' ','',$tag).' ';
				} else $tags.='#'.$tag.' ';
			}
		}
		$tags.='#soznanie_club';
		$post_text.="\n\n".$tags;
		# Постим
		$vk_id=insert_module("vk-api","post_to_wall_with_attach","$vk_group_id","$post_text",$vk_post_attach);
		sleep(2);
		
		#Отправляем в телеграм
		include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/telegram_sendMessage.php'); //Подключаем библиотеку
		sleep(2);
		
		#Постим в FB
		if(!$post_link['fb']) $post_link['fb']='https://soznanie.club/';
		insert_function("ifttt");
		$ifttt_param=array(
			'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d',
			'trigger'=>'facebookit',
			'params'=>array(
				'value1' => $post_link['fb'],
				'value2'=>$post_text['fb']
			)
		);

		//ifttt_trigger($ifttt_param);//Пост в FB через IFTTT
		
		unlink($image_path);
	}
	//Исправляем $vk_wall_lastposttime
	mysql_query("UPDATE `$tableprefix-siteconfig` SET `value` = CURRENT_TIMESTAMP WHERE `systemparamname` ='vk_wall_lastposttime';");
	
} else $log->LogInfo('No need to put new post to VK. Time elapsed - '.round((time() - strtotime($vk_wall_lastposttime))/60).' minutes');



################ Получение новых тренингов samopoznanie ########################



/* //Стереть дубли
$tr_info_q=mysql_query("SELECT `tr_id`,`orig_uri_title` FROM `$tableprefix-training` WHERE 1;"); // Информация по тренингам в базе

while($tr_info=mysql_fetch_array($tr_info_q)){
	if(!isset($orig_link_arr[$tr_info['orig_uri_title']])){
		$orig_link_arr[$tr_info['orig_uri_title']]=0;
	} else {//Повторный
		$del_arr[]=$tr_info['tr_id'];
	}
	if(count($del_arr)==30){
		//Удаляем
		foreach($del_arr as $tr_id){
			 $delq_qt.="`tr_id` =' $tr_id' or "; 
		}
		mysql_query("DELETE FROM `freecon-training` WHERE ".substr($delq_qt,0,-4).";");
		//echo "DELETE FROM `freecon-training` WHERE ".substr($delq_qt,0,-4).";";
		unset($del_arr,$delq_qt);
		
	}
}*/

/*

if($now_hour=="03" AND $now_min=="11"){ # Запускать в 3 часа 11 минут

	$log->LogDebug('-- Trying to find new trainings on SAMOPOZNANIE');
	$base_url="https://samopoznanie.ru/sitemap/?action=actions&p=";
	$host='samopoznanie.ru';
	$scheme='https://';	
	$end_flag=0;//Флаг окончания цикла while
	$pnum=0; // Индикатор страницы &p= из ссылки $base_url. 0 - все страницы, 200 - начиная с 200-й
	$add_tr_count=0;//Счетчик добавленных тренингов
	insert_function("get_html_code_url");

	$tr_info_q=mysql_query("SELECT `orig_uri_title` FROM `$tableprefix-training` WHERE 1;"); // Информация по тренингам в базе

	while($tr_info=mysql_fetch_array($tr_info_q)){
		$orig_link_arr[$tr_info['orig_uri_title']]=0; // Ноль - индикация того, что он кандидат на стирание. Если в процессе скрипта его переправят на 1, то он остается
	}
	$tr_before_script=count($orig_link_arr);
	$log->LogInfo ('Now in DB '.$tr_before_script.' unique trainings');
	unset($tr_info,$tr_info_q);

	while($end_flag<1){
		$pnum++;
		$url=$base_url.$pnum; // Новый URL
		$content=NULL;
		$content=get_html_code_url($url); // Получаем страницу
		if( is_numeric($content)){ // Вместо страницы пришел номер ошибки, скорее всего из-за того, что предыдущая страница, была последней, а сейчас пришло 404
			$log->LogError("Stopped on url - ".$url." because page cant be downloaded (".$content.")");
			$end_flag=1;
		}
		else{// Пришла страница с HTML, парсим её
			
			preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/",$content,$tmp); // Находим ссылки на странице
			$content=NULL;

			//Добавляем в массив links все ссылки не имеющие аттрибут nofollow
			foreach($tmp[0] as $k => $v){if(!preg_match('/<.*[Rr][Ee][Ll]=.?("|\'|).*[Nn][Oo][Ff][Oo][Ll][Ll][Oo][Ww].*?("|\'|).*/
			
			//НИЖЕ ЭТО ПРОДОЛЖЕНИЕ FOREACH. НАДО ПРОСТО СТЕРЕТЬ / * (кот на след строке) и все заработает
			/*',$v)){$links[$k]=$tmp[1][$k];}}
			
			unset($tmp);
			$log->LogDebug('Found '.count($links).' links on page '.$pnum);
			
			//Обрабатываем полученные ссылки, отбрасываем "плохие", а потом и с них собираем...
			for ($i = 0; $i < count($links); $i++)
			{	
				if(!strstr($links[$i],'/trainings/')){continue;}
				
				//Убираем якори у ссылок
				$links[$i]=preg_replace("/#.*/
				
				//НИЖЕ ЭТО ПРОДОЛЖЕНИЕ preg_replace. НАДО ПРОСТО СТЕРЕТЬ / * (кот на след строке) и все заработает
				/*X", "",$links[$i]);
				//Узнаём информацию о ссылке
				$urlinfo=@parse_url($links[$i]);if(!isset($urlinfo['path'])){$urlinfo['path']=NULL;}
				//Если хост совсем не наш, ссылка на главную, на почту или мы её уже обрабатывали - то заканчиваем работу с этой ссылкой
				if((isset($urlinfo['host']) AND $urlinfo['host']!=$host) OR isset($urls[$links[$i]]) OR strstr($links[$i],'@')){continue;}
				//Если ссылка в нашем запрещающем списке, то также прекращаем с ней работать
				$nofoll=0;if($nofollow!=NULL){foreach($nofollow as $of){if(strstr($links[$i],$of)){$nofoll=1;break;}}}if($nofoll==1){continue;}
				//Если задано расширение ссылки и оно не разрешёно, то ссылка не проходит
				$ext=end(explode('.',$urlinfo['path']));
				$noext=0;if($ext!='' AND strstr($urlinfo['path'],'.') AND count($extensions)!=0){$noext=1;foreach($extensions as $of){if($ext==$of){$noext=0;continue;}}}if($noext==1){continue;}
				//Заносим ссылку в массив
				$urls[$links[$i]]=0; // тогда нет повторов в текущей сессии
			}
			unset($links);
			$log->LogDebug("On this page (".$pnum.") script found ".count($urls)." links to trainings");
			# Обработаем ссылки
			$new_tr_add_q="";
			$add_tr_count_onpage=0;
			if($urls){
				foreach ($urls as $tr_url=>$poh){
					
					if(!isset($orig_link_arr[$tr_url]) and !isset($orig_link_arr[substr($tr_url,11)])){ // Ссылка новая
						$new_tr_add_q.= "( '".substr($tr_url,11)."', '', 'Стр $pnum', 'new'),"; // Прибавили к запросу наш новый тренинг
						$add_tr_count++;//Увеличили общий счетчик добавленных тренингов
						$add_tr_count_onpage++;//Увеличили счетчик добавленных тренингов на этой странице
					} 
					$orig_link_arr[$tr_url]=1; // Пометили ссылку, что она еще актуальная (для старых) и что она уже есть,чтобы ее не повторять, если она встретится на других страницах (для новых)
				}
				unset($urls);
			}
			$new_tr_add_q=substr($new_tr_add_q,0,-1).";";
			if($add_tr_count_onpage>0){
				#Вносим названия тренингов со страницы познания в БД, потом отдельно сделаем на парсинг каждой страницы
				mysql_query("INSERT INTO `$tableprefix-training` ( `orig_uri_title`, `tr_name`,  `tr_desc`,`status`) VALUES ".$new_tr_add_q);
				if(!mysql_error())	$log->LogDebug('Inserted '.mysql_affected_rows().' [planned - '.$add_tr_count_onpage.'] new trainings from the page '.$pnum);
				else $log->LogError('Mysql error - '.mysql_error().' Query was - '."INSERT INTO `$tableprefix-training` (`tr_id`, `orig_uri_title`, `tr_name`, `tr_center_id`, `trainer_id`, `tr_date`, `tr_lengh`, `tr_desc`, `place_address`, `price`, `tags`,`status`) VALUES ".$new_tr_add_q);
				$tr_found_on_pages.=$pnum.","; // Список страниц, на которых найдены новые тренинги
			}
			unset($new_tr_add_q);
		}
		
//		if($pnum==1) $end_flag=1; // Раскомментить, если нужен 1 прогон по первой странице познания
	}
	$log->LogInfo($add_tr_count." trainings added today from pages - ".$tr_found_on_pages);

	#Стираем то, что не помечено 1, этих тренингов нет в ленте samopoznanie и потому они и нам не нужны уже
	$deleted_tr_count=0; // Счетчик удаленных тренингов
	foreach ( $orig_link_arr as $link => $marker ) {
		if($marker==0){
			mysql_query("DELETE FROM `$tableprefix-training` WHERE `orig_uri_title`='".$link."';"); // Или сделать апдейт статуса, хотя и так много записей...
			$deleted_tr_count++;
		}
	}
	$log->LogInfo($deleted_tr_count." trainings deleted today");
	# Статистика на почту
	//Кол-во тренингов после операций:
	sleep(20);
	$tr_after_script_q=mysql_fetch_array(mysql_query("SELECT count(*) as TRCOUNT FROM `$tableprefix-training` WHERE 1;"));
	$tr_after_script=$tr_after_script_q['TRCOUNT'];
	
	$log->LogInfo($tr_after_script." trainings now in DB. Query was - SELECT `tr_id` FROM `$tableprefix-training` WHERE 1;");
	$new_tr_subject='Отчёт по работе с порталом Самопознание';
	$new_tr_message=$deleted_tr_count." trainings deleted today<br>".$add_tr_count." trainings added today from pages:<br>".mb_substr($tr_found_on_pages,0,-1)."<br>".
	'Before this script there in DB was '.$tr_before_script.' trainings. Now in DB '.$tr_after_script.' trainings.';
	sendletter_to_admin($new_tr_subject,$new_tr_message);

}


*/









################ Парсинг страниц тренингов и задействованных тренеров samopoznanie ########################

/*

#Функция получения содержимого по названию класса
function getElementsByClass(&$parentNode, $tagName, $className) {
    $nodes=array();

    $childNodeList = $parentNode->getElementsByTagName($tagName);
	//var_dump($childNodeList);
    for ($i = 0; $i < $childNodeList->length; $i++) {
        $temp = $childNodeList->item($i);
		//var_dump($temp );
        if (stripos($temp->getAttribute('class'), $className) !== false) {
           // var_dump($childNodeList->item($i));
			$nodes[]=$temp;
        }
    }

    return $nodes;
}

$tr_once=70; // Количество тренингов за 1 проход скрипта

insert_function("get_html_code_url");
// Массив русских дат для перевода в unixtime
$montharr = array("января"=>'01',"февраля"=>'02',"марта"=>'03',"апреля"=>'04',"мая"=>'05',"июня"=>'06',"июля"=>'07',"августа"=>'08',"сентября"=>'09',"октября"=>'10',"ноября"=>'11',"декабря"=>'12'); 

#Все логины тренеров и ТЦ
$trainer_q=mysql_query("SELECT `nickname` FROM `$tableprefix-contactlist` WHERE `position`='Тренер';");
while($trainer=mysql_fetch_array($trainer_q)){
	$trainer_login_db[$trainer['nickname']]=0;
}
$training_center_q=mysql_query("SELECT `nickname` FROM `$tableprefix-contactlist` WHERE `position`='Тренинговый центр';");
while($training_center=mysql_fetch_array($training_center_q)){
	$training_center_login_db[$training_center['nickname']]=0;
}

$cities_q=mysql_query("SELECT `city_name_ru`,`oid` WHERE 1;");
while(@$cities=mysql_fetch_array($cities_q)){
	$cities_db[$cities['city_name_ru']]=$cities['oid'];
}

unset($trainer_q,$training_center_q,$cities_q);//Очищаем память
#Получаем пачку новых тренингов для обновления их данных
$tr_page_q=mysql_query("SELECT * FROM `$tableprefix-training` WHERE `status`='new' order by `tr_id` DESC LIMIT 0,$tr_once;");

if(mysql_num_rows($tr_page_q)>0){
	while($tr_page=mysql_fetch_array($tr_page_q)){

		if(strstr($tr_page['orig_uri_title'],"/trainings/")) $content=get_html_code_url('https://samopoznanie.ru'.$tr_page['orig_uri_title']);
		else $content=get_html_code_url('https://samopoznanie.ru/trainings/'.$tr_page['orig_uri_title']);

		echo '<br><br>'.$tr_page['orig_uri_title']."<br>";
		
		if( is_numeric($content)){ #Ошибка при получении страницы, стираем её из базы
			
			mysql_query("DELETE FROM `$tableprefix-training` WHERE `tr_id` = ".$tr_page['tr_id'].";");
				
			$log->LogDebug("Training erased because page [".$tr_page['orig_uri_title']."] answers ".$content." - td_id ".$tr_page['tr_id']);
		}
		else{ // Получили страницу тренинга
			
			#Парсим страницу
			if($dom) unset($dom);
			$dom = new DOMDocument;
			@$dom->loadHTML($content);
			
			# Дата и время проведения
			$tr_starttime = $dom->getElementsByTagName('time');
			
			foreach ($tr_starttime as $item) {
				if($item->getAttribute('itemprop')=="startDate"){
					$trng['starttime']=$item->nodeValue;
					$trng['starttime2']=$item->getAttribute('datetime');
				} elseif($item->getAttribute('datetime')==date("Y-m-d")){ //Возможно, это случай периодического тренинга
					$trng['dt_per']=$item->nodeValue;// Время проведения периодич тренинга
				}
			}
			
			# Проверим, не прошел ли тренинг
			if($trng['yearpos']=mb_strpos($trng['starttime'],date("Y"))){ #ДОПИСАТЬ УЧЕТ СЛЕДУЮЩЕГО ГОДА
				//$log->LogDebug( "ГОД найден в ".$trng['yearpos']);

				$trng['tr_dts_hum_startstr'] = mb_substr ($trng['starttime'], 0, $trng['yearpos'] );//Отрезали начало строки до первого года
			
				$trng['ph_long']=mb_strlen($trng['tr_dts_hum_startstr']);

				for ($i = 0; $i <=$trng['ph_long'] ; $i++) {//Перебираем по букве, ищем первую цифру, это будет число, тк формат даты - 17 июня 2017
					
					$cur_symbol=mb_substr($trng['tr_dts_hum_startstr'],$i,1);

					if($cur_symbol=="0" or $cur_symbol=="1" or $cur_symbol=="2" or $cur_symbol=="3"){ //Это первая цифра
						$first_digit=$i;
						break;
					}
				}
				
				$trng['date_long']=$trng['yearpos']+4-$first_digit;
				
				$trng['tr_dts_hum'] = mb_substr ($trng['starttime'], $first_digit, $trng['date_long'] ); //Это дата тренинга, написанная по-русски - 21 июня 2017
				
				#Теперь проверим, не прошел ти тренинг
				foreach($montharr as $monthname=>$month_number){
					if(strstr($trng['tr_dts_hum'],$monthname)){
						$trng['tr_dts_dig']=str_replace($monthname,$month_number ,$trng['tr_dts_hum']);
						$trng['tr_dts_dig']=str_replace (" ", "-" ,$trng['tr_dts_dig']);
						break;
					}
				}

				$trng['tr_dts_ut']=strtotime($trng['tr_dts_dig']);

				if (time()>$trng['tr_dts_ut']) { // Дата в прошлом относительно текущего момента!!
					$decl_flag=1;
					echo "RAZNICA";
				}
			} elseif($trng['dt_per']){
				// Это периодич тренинг
			} 
			else{//Тренинг уже точно прошел, тк год другой уже
				$decl_flag=1;
				echo "GOD";
			}

			if($decl_flag==1){ //Тренинг уже прошел, надо пометить его, чтобы он больше не скачивался
			
				mysql_query("UPDATE `$tableprefix-training` SET `status` = 'declined' WHERE `tr_id` = ".$tr_page['tr_id'].";");
				echo "ПРОШЕЛ";
				$log->LogDebug("Training declined because OLD - ".$tr_page['tr_id']);
			
			} else { //Тренинг будет, выделяем другие детали, кроме даты

				#Название тренинга
				$tr_title = $dom->getElementsByTagName('h1');
				
				foreach ($tr_title as $item) {
					$trng['train_title']=htmlspecialchars($item->nodeValue,ENT_QUOTES); // Название тренинга
				}

				# Время проведения (часы)

				$tr_st_time_temp=explode ("T",$trng['starttime2']);
				$trng['tr_start_time']=$tr_st_time_temp[1];
				
				@$tr_stop_time_markpos=mb_strpos($trng['starttime'],mb_substr($trng['tr_start_time'],1)); // Позиция даты начала в строке, содержащей всю дату
				$trng['tr_stop_time']=mb_substr($trng['starttime'],($tr_stop_time_markpos+8),5); // Время окончания тренинга
				
				#Цена и описание тренера

				$tr_divs= $dom->getElementsByTagName('div');
			
				foreach ($tr_divs as $item) {
					if($item->getAttribute('itemprop')=="offers"){
						$trng['tr_price'] = trim(html_entity_decode($item->nodeValue));//Цена
					} elseif($item->getAttribute('class')=="small trainer-additional"){
						$trng['trnr_small_desc']=$item->nodeValue; //Краткое описание тренера

					}
				}

				#Полное описание тренинга
				$trng_desc_start_pos= mb_strpos($content,'<div class="object_description">');
				$trng_desc_stop_pos= mb_strpos($content,'<p class="display-none">Скопировано с сайта «Самопознание .ру»</p>');
				$trng['trnr_small_desc'] = html_entity_decode(mb_substr($content,$trng_desc_start_pos+34,($trng_desc_stop_pos-$trng_desc_start_pos-34)),ENT_NOQUOTES); // Описание тренинга
		
				
				if($trng['trnr_small_desc']) $trng['trnr_small_desc']=str_replace( "Самопознание","$sitedomainname",$trng['trnr_small_desc']);


				#Адреса тренинга
				$trng_span =$dom->getElementsByTagName('span');
				foreach ($trng_span as $span) {
					if($span->getAttribute('itemprop')=="addressLocality"){ // Это город, где тренер живет
						$trng['trng_city']=$span->nodeValue; // Регион/город
						
					} elseif($span->getAttribute('itemprop')=="streetAddress"){// Это адрес места приема
						$trng['trng_place_address']=$span->nodeValue;
					}
					
				}


				#Обрабатываем ссылочки
				$tr_links = $dom->getElementsByTagName('a');
				foreach ($tr_links as $item) {
					$link_val=$item->nodeValue;
					$link_href=$item->getAttribute('href');
					# Тренер
					if(strstr($link_href,"/trainers/") and $link_href!=="/trainers/"){ // Возможно ссылка содержит ссылку на страницу тренера
						
						$link_len=mb_strlen($link_href);
						$trainer_pos=mb_strpos($link_href,"/trainers/");
						if($link_len-$trainer_pos-10>0){//Это ссылка с тренером

							$trnr['trainer_login']=mb_substr($link_href,$trainer_pos+10); // Логин тренера
							if(strstr($trnr['trainer_login'],"/")) $trnr['trainer_login']=mb_substr($trnr['trainer_login'],0,-1);
							# Есть ли тренер в базе
							if(!isset($trainer_login_db[$trnr['trainer_login']])){ # Тренера нет в БД, выделяем его контакты и записываем в contactlist
								$trainer_full_name=explode(" ",$link_val); // 0 - имя, 1 - фамилия
								if(count($trainer_full_name)==2){
									// 0 - имя, 1 - фамилия
									$trnr['fn']=$trainer_full_name[0];
									$trnr['sn']=$trainer_full_name[1];
								} elseif(count($trainer_full_name)==3){
									// 0 - имя, 1 - отчество, 2 - фамилия
									$trnr['fn']=$trainer_full_name[0];
									$trnr['pn']=$trainer_full_name[1];
									$trnr['sn']=$trainer_full_name[2];
								}
								
								$trpage_content=get_html_code_url('https://samopoznanie.ru'.$link_href."/"); //https://samopoznanie.ru/trainers/erik_pelhem/
								echo "Тренера ".$trnr['trainer_login']." нет в БД<br>";
								if($tr_dom) unset($tr_dom);
								$tr_dom = new DOMDocument;
								@$tr_dom->loadHTML($trpage_content);
								#Обрабатываем ссылочки
								$trainerpage_links =$tr_dom->getElementsByTagName('a');
								foreach ($trainerpage_links as $item1) {
									//$link_val=$item->nodeValue;
									$trp_link_href=$item1->getAttribute('href');
									if(strstr($trp_link_href,"skype:")){//Это сылка на скайп
										$trnr['trainer_skype']=$item1->nodeValue; // его Skype
									} elseif(strstr($trp_link_href,"/schools/") and $trp_link_href!=="/schools/"){ //Это тег
										$trnr['tags'].=$item1->nodeValue.";";
									} elseif($item1->getAttribute('data-fresco-group')=="avatars"){
										
										//$trnr['tr_avatar']=$trp_link_href;
										$jpg_pos=mb_strpos($trp_link_href,".jpg");
										$trnr['tr_avatar']=mb_substr($trp_link_href,17,($jpg_pos-17+4));

										$photo_q=mysql_query("INSERT INTO `$tableprefix-photos` (`photo_id`, `gallery_id`, `photo_path`, `photo_title`) VALUES 
										(NULL, '1', '".$trnr['tr_avatar']."', 'Фотография $trnr[sn] $trnr[fn]  $trnr[pn]');");
										$trnr['photo_id'].=mysql_insert_id().";";
									
									} elseif($item1->getAttribute('rel')=="nofollow" and $item1->getAttribute('class')=="underline" and strstr($trp_link_href,"/links/")){# WEBSITE
										$trnr['trnr_website']=$item1->nodeValue;// Сайт тренера
									}
								}
								if(!$trnr['trainer_skype']){$trnr['trainer_skype']="NULL";} else $trnr['trainer_skype']="'".$trnr['trainer_skype']."'";
								#Полное описание тренера
								$desc_start_pos= mb_strpos($trpage_content,'<div class="object_description">')."<br>";
								$desc_stop_pos= mb_strpos($trpage_content,'<p class="display-none">Скопировано с сайта «Самопознание .ру»</p>');
								$trnr['trainerpage_desc'] = html_entity_decode(mb_substr($trpage_content,$desc_start_pos+34,($desc_stop_pos-$desc_start_pos)),ENT_NOQUOTES); // Описание тренера
								
								#Адреса тренера
								$trainerpage_span =$tr_dom->getElementsByTagName('span');
								foreach ($trainerpage_span as $span) {
									if($span->getAttribute('itemprop')=="addressLocality"){ // Это город, где тренер живет
										$trnr['trainer_city']=$span->nodeValue; // Регион/город
									} elseif($span->getAttribute('itemprop')=="streetAddress"){// Это адрес места приема
										$trnr['trainer_place_address']=$span->nodeValue;
									}
									
								}
								

								if(empty($trnr['trainer_city']) or $trnr['trainer_city']==''){// Город не определился по нижней части. 
									//Ищем город в заголовке. Там точно есть
									$city_f_fp=mb_strpos($trpage_content,'<table class="object_info ');

									$city_f_sp=mb_strpos($trpage_content,'<div class="object_description">');
									
									$city_text_len=$city_f_sp-$city_f_fp;

									$city_kusok=mb_substr($trpage_content,$city_f_fp,$city_text_len);
									$regw_pos=mb_strpos($city_kusok,'Регионы');
									if(!$regw_pos) $regw_pos=mb_strpos($city_kusok,'Регион');

									$trnr['trainer_city']=trim(strip_tags(mb_substr($city_kusok,$regw_pos+6)));
									
									
									if(strstr($trnr['trainer_city'],'.')){$trnr['trainer_city']=mb_substr($trnr['trainer_city'],0,-1);}
										
								}
							
								#Что делает

								$trainer_tables =$tr_dom->getElementsByTagName('table');
								foreach ($trainer_tables as $item) {
									if($item->getAttribute('class')=="object_info  table_info"){//Верхняя таблица
										$tabletext=$item->nodeValue;
										
										$roles_pos=mb_strpos($tabletext,"Роли");
										if($roles_pos){ // Есть роли, сделаем теги
											$regions_pos=mb_strpos($tabletext,"Регионы");
											if(!$regions_pos) $regions_pos=mb_strpos($tabletext,"Регион");
											if($regions_pos) $trnr_roles=trim(strip_tags(mb_substr($tabletext,$roles_pos+4,($regions_pos-$roles_pos-5))));
											else  $trnr_roles=trim(strip_tags(mb_substr($tabletext,$roles_pos+4)));
											$trnr['trnr_tags']=str_replace(",",";",$trnr_roles);
											$trnr['trnr_tags']=str_replace(".","",$trnr['trnr_tags']);
										}
									}

								}

								#Записываем что получили в Contactlist
								mysql_query("INSERT INTO `$tableprefix-contactlist` 
								(`second_name`, `first_name`, `patronymic_name`, `gender`, `position`, `skype`, `nickname`,`about`, `comment`,`website`,`city`,`address_home`,
								`photo`,`tags`) VALUES 
								( '".$trnr['sn']."', '".$trnr['fn']."','".$trnr['pn']."', '-', 'Тренер', ".$trnr['trainer_skype']." ,  '".$trnr['trainer_login']."','".$trng['trnr_small_desc']."', '".$trnr['trainerpage_desc']."','".$trnr['trnr_website']."','".$trnr['trainer_city']."','".$trnr['trainer_place_address']."','".$trnr['photo_id']."','".$trnr['trnr_tags']."');");
								$trainer_login_db[$trnr['trainer_login']]=0; // Чтобы при повторном проходе не заводилось повторных строк с тренерами
							
							} else echo "Тренер найден в БД!<br>";
							# Сохраняем логины тренеров тренинга
							if(!mb_strpos($trng['trainers'],$trnr['trainer_login'])) $trng['trainers'].=$trnr['trainer_login'].";"; // Если не повторная ссылка
						}
					}

					#Тренинг центр
					elseif(strstr($link_href,"/organizers/")){ // Возможно ссылка содержит ссылку на страницу ТЦ (организатора)
						echo $link_href;
						$link_len=mb_strlen($link_href);
						$trainingcenter_pos=mb_strpos($link_href,"/organizers/");
						if($link_len-$trainingcenter_pos-12>0){//Это ссылка с ТЦ - //https://samopoznanie.ru/indonesia/organizers/art_transformation/
							//echo "<br>Организатор найден на странице<br>";
							$trc['trainingcenter_login']=mb_substr($link_href,$trainingcenter_pos+12);
							if(strstr($trc['trainingcenter_login'],"/")) $trc['trainingcenter_login']=mb_substr($link_href,$trainingcenter_pos+12,-1);
							//else $trc['trainingcenter_login']=mb_substr($link_href,$trainingcenter_pos+12);
							
							# Есть ли ТЦ в базе
							if(!isset($training_center_login_db[$trc['trainingcenter_login']])){ # ТЦ нет в БД, выделяем его контакты и записываем в contactlist
								echo "ТЦ ".$trc['trainingcenter_login']." нет в БД<br>" ;
								$trc['trainingcenter_name']=$link_val;
								
								$trcpage_content=get_html_code_url('https://samopoznanie.ru'.$link_href."/"); //https://samopoznanie.ru/abakan/organizers/spc_praksis/
								
								if($trc_dom) unset($trc_dom);
								$trc_dom = new DOMDocument;
								@$trc_dom->loadHTML($trcpage_content);
								#Обрабатываем ссылочки
								$trcpage_links =$trc_dom->getElementsByTagName('a');
								foreach ($trcpage_links as $item1) {
				
									$trcp_link_href=$item1->getAttribute('href');
									if(strstr($trcp_link_href,"skype:")){//Это сылка на скайп
										$trc['skype']=$item1->nodeValue; // Skype ТЦ
									
									} elseif($item1->getAttribute('data-fresco-group')=="avatars"){ // /avatars/objects/4-9649_3_4.jpg?19ffb2ba74590d8e40da5b57ec70e4f7
										$jpg_pos=mb_strpos($trcp_link_href,".jpg");
										$trc['avatar']=mb_substr($trcp_link_href,17,($jpg_pos-17+4));
										
										$trc_photo_q=mysql_query("INSERT INTO `$tableprefix-photos` (`photo_id`, `gallery_id`, `photo_path`, `photo_title`) VALUES 
										(NULL, '2', '".$trc['avatar']."', 'ТЦ ".$trc['trainingcenter_name']."');");
										$trc['trc_photo_ids'].=mysql_insert_id().";";
									} elseif($item1->getAttribute('rel')=="nofollow" and $item1->getAttribute('class')=="underline" and strstr($trcp_link_href,"/links/")){# WEBSITE
										$trc['website']=$item1->nodeValue;// Сайт ТЦ
									}
								}

								if(!$trc['skype'] or $trc['skype']=='NULL'){$trc['skype']="NULL";} else $trc['skype']="'".$trc['skype']."'";
								
								#Полное описание ТЦ
								$desc_start_pos= mb_strpos($trcpage_content,'<div class="object_description">')."<br>";
								$desc_stop_pos= mb_strpos($trcpage_content,'<p class="display-none">Скопировано с сайта «Самопознание .ру»</p>');
								$trc['desc'] = html_entity_decode(mb_substr($trcpage_content,$desc_start_pos+34,($desc_stop_pos-$desc_start_pos)),ENT_NOQUOTES); //Полное описание ТЦ
								
								# Адреса ТЦ
								$trcpage_span =$trc_dom->getElementsByTagName('span');
								foreach ($trcpage_span as $span) {
									if($span->getAttribute('itemprop')=="addressLocality"){ // Это город, где тренер живет
										$trc['city']=$span->nodeValue; // Регион/город
									} elseif($span->getAttribute('itemprop')=="streetAddress"){// Это адрес места приема
										$trc['place_address']=$span->nodeValue;
									} elseif($span->getAttribute('itemprop')=="name"){//Это название ТЦ
										$trc['trainingcenter_name']=$span->nodeValue; //Название ТЦ

									}
								}

								$hd_f_fp=mb_strpos($trcpage_content,'<table class="object_info ');

								$hd_f_sp=mb_strpos($trcpage_content,'<div class="object_description">');
								
								$hd_text_len=$hd_f_sp-$hd_f_fp;

								$hd_kusok=mb_substr($trcpage_content,$hd_f_fp,$hd_text_len);
								$regw_pos=mb_strpos($hd_kusok,'Регион');
								
								if(empty($trc['city']) or $trc['city']==''){// Ищем город в заголовке. Там точно есть
									
									$trc['city']=trim(strip_tags(mb_substr($hd_kusok,$regw_pos+6)));
									
									if(strstr($trc['city'],'.')){$trc['city']=mb_substr($trc['city'],0,-1);}

								}
								# Второе название
								$sname_pos=mb_strpos($hd_kusok,'Второе&nbsp;название');
								if($sname_pos){
									//echo "ВТОРОЕ ИМЯ В -".$sname_pos.", a РЕГИОН В - $regw_pos<br>";
									$trc_second_name_len=$regw_pos-$sname_pos-20;
									$trc['second_name']=trim(strip_tags(mb_substr($hd_kusok,$sname_pos+20,$trc_second_name_len)));
									if(strstr($trc['second_name'],'.')){$trc['second_name']=mb_substr($trc['second_name'],0,-1);}
								}
								


								#Записываем что получили о ТЦ в Contactlist
								$trc_cl_add_qt="INSERT INTO `$tableprefix-contactlist` 
								(`second_name`, `first_name`,  `gender`, `position`, `skype`, `nickname`, `comment`,`website`,`city`,`address_home`,`photo`) VALUES 
								( '".htmlspecialchars($trc['second_name'],ENT_QUOTES)."', '".htmlspecialchars($trc['trainingcenter_name'],ENT_QUOTES)."', '-', 'Тренинговый центр', ".$trc['skype']." ,  '".$trc['trainingcenter_login']."', '".$trc['desc']."','".$trc['website']."','".$trc['city']."','".$trc['place_address']."','".$trc['trc_photo_ids']."') 
								;";
								mysql_query($trc_cl_add_qt);
								
								if( mysql_error ()) {
									$log->LogDebug( mysql_error ()."Query was <br>".$trc_cl_add_qt);
									
								}
								
								$training_center_login_db[$trc['trainingcenter_login']]=0; // Чтобы при повторном проходе не заводилось повторных строк с ТЦ
								#Запоминаем название организатора
								if(!mb_strstr($trng['trg_trcs'],$trc['trainingcenter_login'])) $trng['trg_trcs'].=$trc['trainingcenter_login'].";"; //Если такого организатора еще не было в этом тренинге, пополняем список организаторов
							}
						} else{// Нет организатора
							echo "<br>Ссылка не содержит имя организатора<br>";
						}
					}
					elseif(strstr($link_href,"/regulars/" and !$trng['tr_price'])){ //Тренинг регулярный, надо цену пересчитывать из другого поля
						#Цена
						$trng_price_start_pos= mb_strpos($content,'Стоимость тренинга');
						$trng_price_stop_pos= mb_strpos($content,'<td>Скидки</td>');
						if(!$trng_price_stop_pos) $trng_price_stop_pos= mb_strpos($content,'<span class="green bold">Эксклюзивная скидка</span>');
						$trng['tr_price'] = trim(html_entity_decode(strip_tags(mb_substr($content,$trng_price_start_pos+18,($trng_price_stop_pos-$trng_price_start_pos-18)),ENT_NOQUOTES))); // Стоимость занятий
					}
				}

				
				# Обрезаем тренеров и ТРЦ
				$trng['trg_trcs']=substr($trng['trg_trcs'],0,-1);// Все тренинговые центры тренинга
				$trng['trainers']=substr($trng['trainers'],0,-1); // Все тренера ведущие тренинг

				# Записываем детали тренинга в БД и активируем его
				$tr_upd_qt="UPDATE `$tableprefix-training` SET 
					`tr_name` = '".$trng['train_title']."', `tr_center_id` = '".$trng['trg_trcs']."', `trainer_id` = '".$trng['trainers']."', 
					`tr_date` = '".str_replace("T"," ",$trng['starttime2'])."',	`periodic_tr_dateandtime`='".$trng['dt_per']."',`tr_start_time` = '".$trng['tr_start_time']."',
					`tr_end_time` = '".$trng['tr_stop_time']."', `tr_desc` = '".$trng['trnr_small_desc']."', `city` = '".$trng['trng_city']."', 
					`place_address` = '".$trng['trng_place_address']."', `price` = '".$trng['tr_price']."',		
					`status` = 'active' 
					
					WHERE `tr_id` = ".$tr_page['tr_id'].";";
				mysql_query($tr_upd_qt);
				if( mysql_error ()) {$log->LogDebug( mysql_error ()."Query was <br>".$tr_upd_qt);echo "<br>НЕ ПРОШЕЛ ЗАПРОС - ".$tr_upd_qt."!!!!!!!!!!!<br><br>";}
								
				$log->LogDebug("Training details saved - ".$tr_page['tr_id']);
			}

			
			//echo "<br>НАЗВАНИЕ:".$trng['train_title']."<br>ДАТА:".$trng['tr_dts_hum']."(".$trng['tr_dts_dig']." , ".$trng['tr_dts_ut'].") ИЛИ для периодич - ".$trng['dt_per'].
			//"<br>ВРЕМЯ:".$trng['tr_start_time']." ".$trng['tr_stop_time']."<br>Тренер - ".$trnr['trainer_login']."(ГОРОД - ".$trnr['trainer_city'].")<br>ТЦ - ".
			//$trc['trainingcenter_login']."(ИМЯ - ".$trc['trainingcenter_name']." ГОРОД - ".$trc['city']."  <br>ЦЕНА: ".$trng['tr_price']." <br>Описание тренинга:". 
			//$trng['trnr_small_desc']." <br>Коротко о тренере:". $trng['trnr_small_desc']." <br>Адрес проведения тренинга:". $trng['trng_city']." ".$trng['trng_place_address']."<hr>";
			unset($tr_dom,$trc_dom, $decl_flag,$tr_links,$link_href,$trp_link_href,$trcp_link_href,$trcpage_content,$trc_cl_add_qt,$tr_upd_qt,
			$trng,$trc,$trnr
			);
			
		}
	}
} else $log->LogInfo("In DB no trainings whithout data now [samopoznanie]");

*/
############## Все статьи с B17
/*
if($now_min=="26" or $now_min=="56"){

	 # Скачать статьи с B17
	insert_function("get_html_code_url");
	insert_function("DOM_getHTMLByClass");
	$page_num=1;//Количество страниц для прохода
	$pnum=$b17scanpage;//Стартовая страница
	$base_url='https://www.b17.ru/article/?page=';

	$rss_config['need_apply']='auto_confirm';

	echo ($b17scanpage+$page_num);



	while($end_flag<1){
		
		$url=$base_url.$pnum; // Новый URL
		$content=NULL;
		$content=get_html_code_url($url); // Получаем страницу

		if($dom) unset($dom);
		$dom = new DOMDocument;
		@$dom->loadHTML($content);

		#Получаем ссылки
		$page_a = $dom->getElementsByTagName('a');
		foreach ($page_a as $item) {
			if(strstr($item->getAttribute('href'),"/article/") AND !strstr($item->getAttribute('href'),"/article/?") and !strstr($item->getAttribute('href'),"/article/&") and $item->getAttribute('href')!=='http://www.b17.ru/article/'){ // Ссылка на статью
				
				$rss_item['link']='http://www.b17.ru'.$item->getAttribute('href');
				$log->LogDebug($rss_item['link']);
				include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_b17_articles.php';
			}
		}



		if($pnum==($b17scanpage+$page_num-1)){ $end_flag=1;}
		$pnum++;
	}

	//Записываем страницу для следующего прогона
	mysql_query("UPDATE `freecon-siteconfig` SET `value` = '".($b17scanpage+$page_num)."' WHERE `freecon-siteconfig`.`id` = 178;");
}
*/

############## RSS ленты #######################


#Выбираем 1 канал, у которого подошла дата апдейта новостей
$trash=rand(1,100000);
$rss_feed_q=mysql_query("SELECT * FROM `$tableprefix-getrss-conf` WHERE `last_update_ts`<= (NOW() - `update_freq`*60) AND `status`='enabled' LIMIT 0,1;#$trash");

if (mysql_num_rows($rss_feed_q)>0){# Нашли такой канал
	
	
	
	$rss_config=mysql_fetch_array($rss_feed_q);
	$log->LogDebug('Channel '.$rss_config['feed_id'].' ['.$rss_config['feed_name'].'] needs update bcs last update was '.$rss_config['last_update_ts']);
	
	# обновляем дату обновления канала, даже если он не ответит
	mysql_query("UPDATE `$tableprefix-getrss-conf` SET `last_update_ts` = CURRENT_TIMESTAMP WHERE `feed_id` = '".$rss_config['feed_id']."';");
	
	if(strstr($rss_config['feed_url'],".gz")) { //Ганзипленный sitemap, откроем содержимое
		$gzlines = gzfile($rss_config['feed_url']);
		foreach ($gzlines as $line) {
			$xmlstr.= $line;
		}
		$log->LogDebug('Feed got from gz');
	} else 

	$xmlstr = @file_get_contents($rss_config['feed_url']);//Просто получили текст

	if($xmlstr===false) { // Лента не ответила
		
		insert_function("get_http_response_code");
		$httpcode=get_http_response_code($rss_config['feed_url']);
		
		$log->LogError('Error connect to feed url: '.$rss_config['feed_url'].'. Http code is '.$httpcode);
		sendletter_to_admin("Не удалось подключиться к ленте ".$rss_config['feed_id'],$rss_config['feed_name'].'['.$rss_config['feed_url'].'] ответил на запрос ошибкой. HTTP ответ - '.$httpcode);
	} else { # Лента ответила, разбираем её

		$xml = new SimpleXMLElement($xmlstr);
		if($xml===false) {
			$log->LogError('Error parse RSS: '.$rss_config['rss_link']);
			sendletter_to_admin("Ошибка парсинга ленты ".$rss_config['feed_id'],'При парсинге ленты '.$rss_config['feed_url'].' возникла ошибка. Возможно поменялась структура ленты.');
		}
		# Есть ли файл скрипта
		$launch_script=0;
		if(!empty($rss_config['script']) and is_file( $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$rss_config['script'])) $launch_script=1;

		#Перебираем выданные результаты
		if($rss_config['feed_type']=="rss"){
			
			if($xml->channel){

				foreach($xml->channel->item as $item) {

					if($stop_feed_proc!==1) {
						$rss_item['title']=$item->title;
						if(mb_strstr($rss_item['title'],"<![CDATA[")){
							$rss_item['title']=mb_substr($rss_item['title'],9,-3);
						}
						$rss_item['link']=trim($item->link);
						$rss_item['pubDate']=$item->pubDate;
						$rss_item['description']=$item->description;
						if(mb_strstr($rss_item['description'],"<![CDATA[")){
							$rss_item['description']=mb_substr($rss_item['description'],9,-3);
						}
						$rss_item['description']=trim($rss_item['description']);
						
						//$rss_item['content']= $item->children("http://purl.org/rss/1.0/modules/content/");
						$rss_item['content']=$item->{"content:encoded"};
						if(mb_strstr($rss_item['content'],"<![CDATA[")){
							$rss_item['content']=mb_substr($rss_item['content'],9,-3);
						}
						$rss_item['content']=trim($rss_item['content']);
						
						
						$rss_item['author']=$item->author;
						$rss_item['guid']=$item->guid;
						if($item->enclosure){
							//Можно вытащить картинку или другое приложение
							$encl=$item->enclosure;
							//$log->LogDebug($encl['type'].$encl['url']);
							$rss_item['enclosure']=$encl['url'];
							$rss_item['enclosure_type']=$encl['type'];
							unset($encl);
						}

						if($launch_script==1) include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$rss_config['script'];
						
						#Постим в Twitter (туда идёт всё)
						//Скачаем картинку для твиттера
						$tw_image_path = $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp/'.basename($twitter_image);
						$tw_image_download=file_put_contents($tw_image_path, file_get_contents($twitter_image));
						if($tw_image_download) {
							$log->LogInfo("Image ".$twitter_image.' successfully downloaded and attached to post query');
							$tweet_img_src=$tw_image_path;
						}
						$post_tweet=insert_module("twitter","post_tweet","$tweet_text",$tweet_img_src);
						unlink($tw_image_path);
						unset($tw_image_path,$tw_image_download,$tweet_img_src,$twitter_image,$post_tweet);
					}
				}
			} elseif($xml->title){
				foreach($xml->entry as $item) { // Неправильная лента rutracker.org
					$rss_item['title']=$item->title;
					$rss_item['pubDate']=$item->pubDate;
					$rss_item['description']=$item->description;
					$rss_item['author']=$item->author;
					$rss_item['guid']=$item->guid;
					$rss_item['updated']=$item->updated;

					if($launch_script==1) include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$rss_config['script'];
					if($stop_feed_proc==1) {
						$log->LogDebug("Interruption of feed processing complete");	
						break 1; //Встретили в ленте уже знакомые новости
					}
					//break;//запуск для 1 торрент-страницы
				}
			}
		}
		elseif($rss_config['feed_type']=="script"){
			if($launch_script==1) include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$rss_config['script'];
		}
		elseif($rss_config['feed_type']=="sitemap"){
			foreach($xml->url as $item) {//Перебираем все URL из sitemap
				$rss_item['link']=$item->loc;
				#Проверим, нет ли его в базе, и если нет, то скачаем
				include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_site_top.php';
				if($launch_script==1) include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/'.$rss_config['script'];
			}
		}
		unset($xml); // Убиваем результаты, чтобы дальше не мешались по скрипту
	}
	
	# Сводное письмо с результатами работы скрипта
	if($message_to_adm){
		sendletter_to_admin($add_to_theme,$message_to_adm);
		$dnld_item=0;
		unset($add_to_message,$add_to_theme,$message_to_adm);
	}
	
} else $log->LogDebug('Not found RSS channel needed to update');

################## VK group wall posts to Telegram posts converter for 102records ########################


if( $now_min=="23" or $now_min=="53"){
	
	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/102rec_VKwallToTelegram.php';
	
}


################## Рассылка писем подписчикам  #######################



if($now_hour=="23" and $now_min=="00"){


	### Рассылка новостей / обновлений на портале

	insert_function("string_cut");
	insert_function("send_letter");


	#Читаем файл с


	#Если файл просрочен, то формируем новый файл


	$mail_header='<!doctype html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<style type="text/css">
		.ReadMsgBody {width: 100%; background-color: #ffffff;}
		.ExternalClass {width: 100%; background-color: #ffffff;}
		body	 {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Georgia, Times, serif}
		table {border-collapse: collapse;}

		@media only screen and (max-width: 640px)  {
						.deviceWidth {width:440px!important; padding:0;}
						.center {text-align: center!important;}
				}

		@media only screen and (max-width: 479px) {
						.deviceWidth {width:280px!important; padding:0;}
						.center {text-align: center!important;}
				}

	</style>
	</head>

	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="font-family: Georgia, Times, serif">

	<!-- Wrapper -->
	<table width="580" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="580" valign="top" bgcolor="#ffffff" style="padding-top:20px">

				<!-- Start Header-->
				<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" style="margin:0 auto;">
					<tr>
						<td width="100%" bgcolor="#ffffff">

								<!-- Logo -->
								<table border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
									<tr>
										<td style="padding:10px 20px" class="center">
											<a href="#"><img src="https://soznanie.club/project/freecon/files/freecon-logo.png" alt="" border="0" width="20px"/></a>
										</td>
									</tr>
								</table><!-- End Logo -->

								<!-- Nav -->
								<table border="0" cellpadding="0" cellspacing="0" align="right" class="deviceWidth">
									<tr>
										<td class="center" style="font-size: 13px; color: #272727; font-weight: light; text-align: right; font-family: Georgia, Times, serif; line-height: 20px; vertical-align: middle; padding:10px 20px; font-style:italic">
											<a href="#psy_videos" style="text-decoration: none; color: #3b3b3b;">Видеоролики</a>
											&nbsp;&nbsp;&nbsp;
											<a href="#psy_books" style="text-decoration: none; color: #3b3b3b;">Книги</a>
											&nbsp;&nbsp;&nbsp;
											<a href="#psy_jokes" style="text-decoration: none; color: #3b3b3b;">Анекдоты</a>
											&nbsp;&nbsp;&nbsp;
											<a href="#psy_articles" style="text-decoration: none; color: #3b3b3b;">Статьи</a>
										</td>
									</tr>
								</table><!-- End Nav -->

						</td>
					</tr>
				
					<tr>
						<td valign="top" style="padding:0" bgcolor="#ffffff">
							<a href="#"><img  class="deviceWidth" src="https://soznanie.club/project/freecon/files/hcclub_title_1.png" alt="" border="0" style="display: block; border-radius: 4px;" /></a>
						</td>
					</tr>
				</table>
				<div style="height:15px;margin:0 auto;">&nbsp;</div><!-- spacer -->
				
				<!-- End Header -->

	<div style="height:15px;margin:0 auto;">&nbsp;</div><!-- spacer -->';


	#Книги добавлены сегодня
	$b_today_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as BCOUNT FROM `$tableprefix-torrents` WHERE `date`='".date("Y-m-d")."' and `status`='active';"));


	if($b_today_stat_q['BCOUNT']>0){
		$todays_books_q=mysql_query("SELECT * FROM `$tableprefix-torrents` WHERE `date`='".date("Y-m-d")."' and `status`='active';");
		
		//$row_art_count=0;
		
		$books_today.='<!-- 2 Column Images & Text Side by SIde -->
				<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#FFF" style="margin:0 auto;">
					
					<tr>
						<td bgcolor="#57C3ED"><div style="height:28px;color:#FFF;" align="center" >&nbsp;<b>Добавленные книги и обновления</b></div>
						<a name="psy_books"></a>
						</td>
					</tr>
					
					<tr>
						<td style="padding:10px 0">';
		
		while($b_today=mysql_fetch_array($todays_books_q)){
		
		   $books_today.='	
					<table><tr><td>
								<table align="left" width="49%" cellpadding="0" cellspacing="0" border="0" class="deviceWidth">
									<tr>
										<td valign="top" align="center" class="center" style="padding-top:20px">
												<a href="https://'.$sitedomainname.'/?page=book&topic_id='.$b_today['topic_id'].'">
												<img width="267" src="'.$b_today['orig_img'].'" alt="Обложка для книги:'.$b_today['name'].'" border="0" style="border-radius: 4px; width: 267px; display: block;" class="deviceWidth" />
												</a>
										</td>
									</tr>
								</table>
								<table align="right" width="49%" cellpadding="0" cellspacing="0" border="0" class="deviceWidth">
									<tr>
										<td style="font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">

											<table>
												<tr>
													
													<td valign="middle" style="padding:0 10px 10px 0">
													<a href="https://'.$sitedomainname.'/?page=book&topic_id='.$b_today['topic_id'].'" style="text-decoration: none; font-size: 16px; color: #ccc; font-weight: bold; font-family:Arial, sans-serif ">
													'.$b_today['name'].'
													</a>
													</td>
												</tr>
											</table>

											<p style="mso-table-lspace:0;mso-table-rspace:0; margin:0">
											   '.crop_str_word(ltrim( mb_substr( strip_tags($b_today['orig_desc']), mb_strpos($b_today['orig_desc'],"Описание")+9      )),30).'
												<br/><br/>

												<table width="100" align="right">
													<tr>
														<td background="https://'.$sitedomainname.'/project/'.$projectname.'/files/blue_back.jpg" bgcolor="#409ea8" style="padding:5px 0;background-color:#409ea8; border-top:1px solid #77d5ea; background-repeat:repeat-x" align="center">
															<a href="https://'.$sitedomainname.'/?page=book&topic_id='.$b_today['topic_id'].'"
															style="
															color:#ffffff;
															font-size:13px;
															font-weight:bold;
															text-align:center;
															text-decoration:none;
															font-family:Arial, sans-serif;
															-webkit-text-size-adjust:none;">
																   Скачать
															</a>

														</td>
													</tr>
												</table>

											</p>
										</td>
									</tr>
								</table>
								
							</td>
							</tr>
						</table>';
		}
		
		//$books_today.='</td>                </tr>				</table>				';

		//$mail_template.=$books_today;
	}




	#Всего страниц, одобреных сегодня
	$pages_today_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as ARTCLS_COUNT FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."' and `is_articles`='1';"));

	if($pages_today_act_q['ARTCLS_COUNT']>0){
		$todays_artcls_q=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `creation_date`='".date("Y-m-d")."' and `is_articles`='1';");
		
		$row_art_count=0;

			$articles.='
		<tr>
			<td  bgcolor="#ffe83e"><div style="height:28px;color:#FFF;" align="center" >&nbsp;<b>Новые статьи</b></div>
			<a name="psy_articles"></a></td>
		</tr>
		';
		
		$artcls_count=mysql_num_rows($todays_artcls_q);
		$now_process_artcls=0;
		while($todays_artcls=mysql_fetch_array($todays_artcls_q)){
			$row_art_count++;
			$now_process_artcls++;
			
			
			
			if($row_art_count==1) { //Открываем строку
			
			//<!-- The paragraph tag is important here to ensure that this table floats properly in Outlook 2007, 2010, and 2013 To learn more about this fix check out this link: https://www.emailonacid.com/blog/details/C13/removing_unwanted_spacing_or_gaps_between_tables_in_outlook_2007_2010. This fix is used for all floating tables in this responsive template. The margin set to 0 is for Gmail
			
				$articles.='<tr><td class="center" style="padding:10px 0 0 5px">
					<table width="49%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
						<tr>
							<td align="center">
								<!-- The paragraph tag is important here-->
								<p style="mso-table-lspace:0;mso-table-rspace:0; margin:0">
									<a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'">
										<img width="267" src="'.$todays_artcls['page_img'].'" alt="'.$todays_artcls['pagetitle_ru'].'" border="0" style="border-radius: 4px; width: 267px" class="deviceWidth" />
									</a>
								</p>
							</td>
						</tr>
						<tr>
							<td style="font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">

									<table style="border-bottom: 1px solid #333">
										<tr>
											
											<td valign="middle" style="padding:0 10px 10px 0">
											<a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'" style="text-decoration: none; font-size: 16px; color: #363636; font-weight: bold; font-family:Arial, sans-serif ">'.
											$todays_artcls['pagetitle_ru'].'</a>
											</td>
										</tr>
									</table>
								 <p>'.
								 crop_str_word(ltrim(strip_tags($todays_artcls['pagebody_ru'])),10,' <a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'">...</a>')
								 .'</p>
							</td>
						</tr>
					</table>
					';
					
				if($now_process_artcls==$artcls_count) $articles.='</td></tr>';
			}
			
			if($row_art_count==2) { //Закрываем строку
				$articles.='
						<table width="49%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
							<tr>
								<td align="center">
									<p style="mso-table-lspace:0;mso-table-rspace:0; margin:0">
										<a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'">
											<img width="267" src="'.$todays_artcls['page_img'].'" alt="'.$todays_artcls['pagetitle_ru'].'" border="0" style="border-radius: 4px; width: 267px" class="deviceWidth" />
										</a>
									</p>
								</td>
							</tr>
							<tr>
								<td style="font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">

										<table style="border-bottom: 1px solid #333">
											<tr>
												<td valign="middle" style="padding:0 10px 10px 0">
													<a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'" style="text-decoration: none; font-size: 16px; color: #363636; font-weight: bold; font-family:Arial, sans-serif ">'.
													$todays_artcls['pagetitle_ru'].'</a>
												</td>
											</tr>
										</table>
									 <p>'.	crop_str_word(ltrim(strip_tags($todays_artcls['pagebody_ru'])),10,' <a href="https://'.$sitedomainname.'/?page='.$todays_artcls['page'].'">...</a>')
									.'</p>
								</td>
							</tr>
						</table>
				</td></tr>
				';
				$row_art_count=0;
			}
			
		}
		
		#Кнопка Читать ещё
		
		$articles.='
			<tr>
				<td style="font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">
					<p style="mso-table-lspace:0;mso-table-rspace:0; margin:0">

						<table width="100" align="right">
							<tr>
								<td 
								background="https://'.$sitedomainname.'/project/'.$projectname.'/files/blue_back.jpg"
								bgcolor="#409ea8" style="padding:5px 0;background-color:#409ea8; border-top:1px solid #77d5ea; background-repeat:repeat-x" align="center">
								
									<a href=""
									style="
									color:#ffffff;
									font-size:13px;
									font-weight:bold;
									text-align:center;
									text-decoration:none;
									font-family:Arial, sans-serif;
									-webkit-text-size-adjust:none;">
										   Читать ещё
									</a>
								</td>
							</tr>
						</table>

					</p>
				</td>
			</tr>
		';
		$articles.='</table>';
		
		//$mail_template.=$articles;
	}



	#Видео за сегодня

	$v_today_stat_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-videos` WHERE `vstatus`='active' and `last_update` BETWEEN '".date("Y-m-d")." 00:00:00.000000' AND '".date("Y-m-d")." 23:59:59.000000';"));


	if($v_today_stat_q['COUNT']>0){ 
		
		$videos_today='<table width="580" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" style="margin:0 auto;">

								<tr>
									<td bgcolor="#00c48a">
									<a name="psy_videos"></a>
									<div style="height:28px;color:#FFF;" align="center" >&nbsp;<b>Видеоролики, добавленные сегодня</b></div>
									
									</td>
								</tr>

								<tr>
									<td valign="top">';
		
		$v_today_q=mysql_query("SELECT * FROM `$tableprefix-videos` WHERE `vstatus`='active' and `last_update` BETWEEN '".date("Y-m-d")." 00:00:00.000000' AND '".date("Y-m-d")." 23:59:59.000000';");
		while($v_today=mysql_fetch_array($v_today_q)){
			
			
			$videos_today.='
							<table width="32%" align="left" cellpadding="0" cellspacing="0" class="deviceWidth">
								<tr>
									<td valign="top" align="center" style="padding:10px 0">
											<p style="mso-table-lspace:0;mso-table-rspace:0; margin:0"><a href="https://'.$sitedomainname.'/?page='.$v_today['yt_id'].'"><img width="170" src="https://img.youtube.com/vi/'.$v_today['yt_id'].'/0.jpg" alt="" border="0" style="border-radius: 4px; width: 170px;" class="deviceWidth" /></a></p>
									</td>
								</tr>
								<tr>
									<td style="padding:0 10px 20px 10px">
										<a href="https://'.$sitedomainname.'/?page='.$v_today['yt_id'].'" style="text-decoration: none; font-size: 14px; 					color: #363636; font-weight: bold; font-family:Arial, sans-serif ">
										'.$v_today['vtitle'].'</a>
										<p style="text-align:left; font-size: 10px; line-height:17px">'
										.$v_today['autor'].'</p>
									</td>
								</tr>
							</table>';
			
		}
		
		$videos_today.='			</td>
								</tr>
							</table>';
		//$mail_template.=$videos_today;
	}


	#Шутки за сегодня

	$jokes_today_act_q=mysql_fetch_array(mysql_query("SELECT count(*) as COUNT FROM `$tableprefix-jokes` WHERE `pubDate` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));


	if($jokes_today_act_q['COUNT']>0){

	$jokes_today.='

	 <table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#FFF" style="margin:0 auto;">
					
					<tr>
						<td colspan=2 bgcolor="#f69d00"><div style="height:30px;color:#FFF;" align="center" >&nbsp;<b>Новые шутки на портале</b></div>
						<a name="psy_jokes"></a>
						</td>
					</tr>

		';


		$todays_jokes_q=mysql_query("SELECT * FROM `$tableprefix-jokes` WHERE `pubDate` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';");
		
		while($todays_jokes=mysql_fetch_array($todays_jokes_q)){
			$jokes_today.='<tr>
						<td valign="top">
							<table>
								<tr>
									<td style="color:#fff;font-size:12px;font-weight:bold;text-align:center;-webkit-text-size-adjust:none;padding:4px 8px;">
									<img src="https://soznanie.club/project/freecon/files/freecon-logo.png" alt="" border="0" width="20px"/>
									</td>
								</tr>
							</table>
						</td>
						<td style="font-size:11px;color:#656565;text-align:left;padding-left:8px;" valign="middle">
						   ';
			if($todays_jokes['author']) $jokes_today.='<a style="font-size:14px;font-weight:bold;color:#000000;text-align:left;text-decoration:none;">'.$todays_jokes['author'].'</a><br />';
			$jokes_today.=htmlentities($todays_jokes['text']).'
						</td>
					</tr>';
		}
		$jokes_today.='</td>
					</tr>
					</table>';
		//$mail_template.=$jokes_today;
	}






	$subject="Ежедневная рассылка";

	#Получаем список юзеров для рассылки
	$nl_q=mysql_query("SELECT * FROM `freecon-newsletter-users` WHERE 1;");

	while($nl_user=mysql_fetch_assoc($nl_q)){
		
		$post_to=json_decode($nl_user['post_to'],TRUE);
		
		if($post_to['email']) { #Юзер подписан на рассылку по email
		
			#Личный код отписки
			$unsubscr_code=md5($nl_user['user_id']."ps");
		
			#Формируем его письмо
			$mail_body=$mail_header;

			$user_needs_razdel=json_decode($nl_user['themes'],TRUE);

			if($user_needs_razdel['videos']=="all"){
				$mail_body.=$videos_today;
			}
			if($user_needs_razdel['books']=="all"){
				$mail_body.=$books_today;
			}
			if($user_needs_razdel['jokes']=="all"){
				$mail_body.=$jokes_today;
			}
			if($user_needs_razdel['articles']=="all"){
				$mail_body.=$articles;
			}

			#Нижний wrap-ер
			$mail_wrapEnd='</td>
				</tr>
			</table> <!-- End Wrapper -->
			<div style="display:none; white-space:nowrap; font:15px courier; color:#ffffff;">
			- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			<a href="https://'.$sitedomainname.'/?page=unsubscribe&subscr_id='.$nl_user['id'].'&action=remove_email&code='.$unsubscr_code.'">Не всегда нравится рассылка? Можете отписаться</a><br><br><br>
			</div>
			</body>
			</html>';
			
			$mail_body.=$mail_wrapEnd;//Присоединили нижний wrap-ер

			#Отсылаем письмо
			sendletter($nl_user['mail'],$subject,$mail_body);
			unset($mail_body,$user_needs_razdel);
			sleep (4);
		}
	}

}


################## Стереть пустые торренты за день ############################
/*
if($now_hour=="23" AND $now_min=="21"){ 

	insert_function("file_nullFilesSearch");
	$null_files_arr=file_nullFilesSearch("/home/a/aromanuq/popwebstudio/public_html/project/freecon/files/books_torrents/");

	if($null_files_arr) { 
		foreach($null_files_arr as $fname){
			unlink($fname);
		}
	}

}
*/
################## Отчет за день ############################

if($now_hour=="23" AND $now_min=="59"){ 
	
	include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/get_statistics.php');
	
	
	$new_lt_subject='Статистика портала за '.date("Y-m-d");
	$new_lt_message='
	-----VIDEOS -----<br>
	Today script found videos - '.$v_today_stat_q['VCOUNT'].'<br>
	Now in status "NEED_MODERATE" - '.$v_need_mod_stat_q['NMCOUNT'].'<br>
	
	-----BOOKS ------<br>
	Books in DB - '.$b_all_q['BCOUNT'].'<br>
	Need confirm - '.$b_all_needconfirm_q['BCOUNT'].'<br>
	Active books - '.$b_all_act_q['BCOUNT'].'<br>
	Disabled (DELETED) books - '.$b_disabled_q['BCOUNT'].'<br>
	Today script added - '.$b_today_stat_q['BCOUNT'].'<br>

	-----Articles (Pages) ------<br>
	Pages in DB - '.$pages_all_q['ARTCLS_COUNT'].'<br>
	Pages in DISABLED status - '. $pages_all_dis['COUNT'].'<br>
	Pages in ERROR status - '. $pages_all_err['COUNT'].'<br>
	Pages in BLOCKED status - '. $pages_all_blk['COUNT'].'<br>

	Pages of adminpanel - '. $pages_admin['COUNT'].'<br>
	Pages for users - '. $pages_sitePage['COUNT'].'<br>
	Articles in DB - '. $pages_artcls_db['COUNT'].'<br>
	Articles on disk (rus) - '.$pages_artcls_disk.'<br>
	Articles on disk (en) - '.$pages_artcls_disk_en.'<br>
	Pages with video - '. $pages_video['COUNT'].'<br>
	
	
	Today added - '.$pages_today_q['ARTCLS_COUNT'].'<br>
	Today activated - '.$pages_today_act_q['ARTCLS_COUNT'].'<br>
	Deleted in DB - '.$pages_all_deleted_q['ARTCLS_COUNT'].'<br>
	Today deleted - '.$pages_today_deleted_q['ARTCLS_COUNT'].'<br>
	Waiting for moderate - '.$pages_all_waitmoder_q['ARTCLS_COUNT'].'<br>
	Waiting for moderate fresh (todays) - '.$pages_today_waitmoder_q['ARTCLS_COUNT'].'<br>
	
	------JOKES ------<br>
	Jokes in DB - '.$jokes_all_act_q['COUNT'].'<br>
	Jokes added today - '.$jokes_today_act_q['COUNT'].'<br>
	------Users ------<br>
	User in DB - '.$users_all_act_q['COUNT'].'<br>
	Users added today - '.$users_today_act_q['COUNT'].'<br>
	
	
	';
	sendletter_to_admin($new_lt_subject,$new_lt_message);
}


############# Разбираемся с одинаковыми страницами (стереть)

/*
//Всосали файл с теми, кого надо перескачать
$ost_arr=file($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/odinak_ost.txt');

insert_function("file_delRowByRownum");

$page_id=$ost_arr[0];
#Запрос данных о странице
$page_q=mysql_fetch_assoc(mysql_query("SELECT * FROM `freecon-pages` WHERE `page_id`='".$page_id."';"));
#запускаем
$rss_item['link']=$page_q['orig_link'];
mysql_query("UPDATE `freecon-pages` SET `orig_link`='',`status`='err' WHERE `page_id`='".$page_id."'; ");
if(strstr($page_q['orig_link'],"b17")){	

	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_b17_articles.php';
	
} elseif(strstr($page_q['orig_link'],"self")){
	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/selfgrowth_ru.php';
	
} elseif(strstr($page_q['orig_link'],"psycholo")){
	
	include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/articles_psychologos.php';
	
}
//echo $page_q['page_id'].' '.$page_q['page']."<br>";

//Удалим эту строку из файла
file_delRowByRownum($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/odinak_ost.txt', 1);

//сотрем файлы
unlink($_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html/".$page_q['page']);
unlink($_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/html_en/".$page_q['page']);
*/


############# Стираем файлы нулевого размера из папки tmp этого проекта

if($now_hour=="03" AND $now_min=="34"){ 
	insert_function("file_nullFilesSearch");
	#Файлы из директории tmp	
	$null_files_arr=file_nullFilesSearch($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tmp');

	if($null_files_arr) { 
		foreach($null_files_arr as $fname){
			//Стираем нулевые файлы
			unlink($fname);
		}
	}
	unset($null_files_arr);
	#Нулевые торрент-файлы
	$null_files_arr=file_nullFilesSearch($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/books_torrents/');

	if($null_files_arr) { 
		foreach($null_files_arr as $fname){
			//Стираем нулевые файлы
			unlink($fname);
		}
	}
}


/*
###### Парсинг психологического словаря #####
insert_function("file_delRowByRownum");
insert_function("get_html_code_url");
#Функция получения содержимого по названию класса
insert_function("DOM_getHTMLByClass");

$links=$_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/termins.txt';
$fh = fopen($links, 'r');
if(!empty($fh) and $fh!=='' and $fh!==NULL){
	for($jj = 0; $jj <= 4; $jj++){
		$art_engname = trim(fgets($fh));
		
		$rss_item['link']="https://vocabulary.ru/termin/".$art_engname.".html";
		
		//echo "<br><br>".$rss_item['link'];
		
		$content=get_html_code_url($rss_item['link']);
		if($dom) unset($dom);
		$dom = new DOMDocument;
		@$dom->loadHTML($content);
		#Получаем название
		$art_h1 = $dom->getElementsByTagName('h1');
		
		foreach ($art_h1 as $item) { 
				$artcl['article_title']=trim($item->textContent);//Название статьи
				$artcl['article_title']= preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $artcl['article_title']);
				$log->LogDebug('Got article title - '.$artcl['article_title']);
		}
		
		#Выберем определения
		$art_div = $dom->getElementsByTagName('div');
		$i=0;
		foreach ($art_div as $item) {
			if($item->getAttribute('itemprop')=="articleBody"){//Это определение (термин)
				//$artcl['termin'][$i]=$item->textContent;
				$artcl['termin'][$i]= DOM_getInnerHTML($item);
				$i++;
			} 
		}
		
		#Выберем источники определения (словари)
		$i=0;
		$tags_a=$dom->getElementsByTagName('a');
		foreach ($tags_a as $item) {
			if($item->getAttribute('class')=="dic"){ // Словарь, из которого взяли определение
				$artcl['dictionary_link'][$i]=$item->getAttribute('href');
				$artcl['dictionary_name'][$i]=$item->textContent; 
				echo $artcl['dictionary_link'][$i];
				echo $artcl['dictionary_name'][$i];
				$i++;
				
			}
		}
		
		#Какие есть словари в БД
		$dic_db_q=mysql_query("SELECT * FROM `freecon-pedia-dics` WHERE 1;");
		while($dic_db=mysql_fetch_assoc($dic_db_q)){
			$dic[$dic_db['dic_link']]=$dic_db['dic_id']; //Сохранили в массив все словари
		}
		
		#Пишем запись о термине в файлы

		$i=0;
		foreach ($artcl['termin'] as $termin){
			
			#Ищем словарь
			if(!$dic[$artcl['dictionary_link'][$i]]){ //Нет такого словаря в БД
				#Запишем новый словарь в БД
				$dic_add_q=mysql_query("INSERT INTO `freecon-pedia-dics` (`dic_id`, `dic_link`, `dic_name`) 
					VALUES (NULL, '".$artcl['dictionary_link'][$i]."', '".$artcl['dictionary_name'][$i]."');"
				);
				$dic_dbId = mysqli_insert_id();//id добавленной строки
			} else {#Словарь есть, вот его ID
				$dic_dbId =$dic[$artcl['dictionary_link'][$i]];
			}
		
			
			#Сохраняем тело статьи в файл
			
			$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/termins/".$art_engname."|_".$dic_dbId;
			file_put_contents ( $filename , $termin);
			
			
			
			
			$i++;
			
		}
		
		#Пишем термин в БД
		$termin_add_q=mysql_query("INSERT INTO `freecon-pedia-artcl` (`id`, `code_en`, `code_ru`, `source_dic`, `tags`, `orig_link`) VALUES 
		(NULL, '".$art_engname."', '".$artcl['article_title']."', '', '".$art_tags."', '".$rss_item['link']."');");
		
		
		#Стираем верхнюю строку в файле
		file_delRowByRownum($links, 1);
		
	}
}
fclose($fh); // Закроем файл до следующего раза

*/







}//nitka
echo "!!!EOS";

?>