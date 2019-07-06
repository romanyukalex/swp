<? # Скрипт ищет аудио книги в ленте
$log->LogInfo('Got this file');

$dnld_torr=0; // Флаг для скачивания страницы торрента
$erase_flag=0; // Флаг стирания записи БД
$torr_info=explode("/t/",$item->id); // 1 - topic_id
$tor_q=mysql_query("SELECT `id`,`date`,`status` FROM `$tableprefix-torrents-abooks` WHERE `topic_id`='".$torr_info[1]."' LIMIT 0,1;");

$new_tor_date=mb_substr($item->updated,0,10);//Дата

if(mysql_num_rows($tor_q)>0){ // Такой торрент уже есть, возможно надо перескачать

	$tor_db=mysql_fetch_array($tor_q);

	if($tor_db['status']!=="disabled"){
		if($tor_db['date']!==$new_tor_date){ // Торрент обновили, надо его перескачать
			$log->LogDebug('Torrent need to be updated - '.$torr_info[1].'. Torrent date in db - '.$tor_db['date'].' but in RSS date - '.$new_tor_date);
			$dnld_torr=1; // Флаг чтобы скачать
			$erase_flag=1; // Флаг, чтобы стереть перед записью
			$dnld_reason="Дата в БД отличается от даты в ленте. В БД - ".$tor_db['date'].', а в ленте - '.$new_tor_date;
			$add_to_theme="Обновление торрента";
		} else { // Встретили строку в RSS, которая уже есть в торрентах и которая не обновлена (дата та же), останавливаем процедуру скачивания торрентов, дальше ничего нового не будет
			$log->LogDebug('Stop processing feed bcs torrent exists with same update date'.$tor_db['status']); $stop_feed_proc=1;
		}
	} else $log->LogDebug('Torrent is disabled. Just ignore it');

} else { // Торрента еще нет, надо скачать
	$log->LogDebug('Torrent need to download, its a new torrent');
	$dnld_torr=1; // Флаг чтобы скачать
	$dnld_reason="Новый торрент";
	$add_to_theme="Новый торрент";
}

if($dnld_torr==1){ // Парсим страницу торрента

	#Скрипт распарсивания
	include "site_parsing/rutracker.php";

	if($erase_flag==1){// Стираем строку БД, тк надо обновить торрент
		mysql_query("DELETE FROM `$tableprefix-torrents-abooks` WHERE `topic_id` = '".$torr_info[1]."';");
		$log->LogDebug('Row deleted');	
	}

	if($rss_config['need_apply']=="auto_confirm") {
		$tor_info['status']='active';
		$add_to_message="Торрент размещен на сайте <b>автоматически</b> согласно настройкам фида";
		//$add_to_theme='';
	}
	elseif($rss_config['need_apply']=='manual_confirm') {
		$tor_info['status']='need_confirm';
		$add_to_message="Торрент пока не размещен на сайте и <b>требует ручной активации</b> согласно настройкам фида.\n
		Для подтверждения пройдите по ссылке: <a href='https://".$sitedomainname."/?page=audio&topic_id=".$torr_info[1]."'>".$torr_info['name']."</a>";
		$add_to_theme.="(Требует активации)";
		#добавляем в таблицу событий на портале с пометкой "Нужна модерация"
		mysql_query("INSERT INTO `$tableprefix-portal-events` 
	  (`text`, `status`, `type`, `link`) VALUES 
	  ('Модерация аудио книги ".$torr_info['name']."', 'new', 'need_moderate', 'https://".$sitedomainname."/?page=audio&topic_id=".$torr_info[1]."');");
	}
	
	#Для ярых правообладателей, парсим их имя в тексте
	if(strstr($desc_html,"ксмо")){
		$tor_info['status']='law_block';
		$add_to_message="Торрент содержит контент от Эксмо, статус law_block";
		$add_to_theme.="(Есть забокированный контент)";
		#добавляем в таблицу событий на портале с пометкой "Нужна модерация"
		mysql_query("INSERT INTO `$tableprefix-portal-events` 
	  (`text`, `status`, `type`, `link`) VALUES 
	  ('Добавлена книга Эксмо ".$torr_info['name']."', 'new', 'need_moderate', 'https://".$sitedomainname."/?page=audio&topic_id=".$torr_info[1]."');");
	}
	
	#Добавляем торрент
	mysql_query("INSERT INTO `$tableprefix-torrents-abooks` (`name`,`hash`, `date`, `size`, `topic_id`, `cat_id`, `cat_name`, `year`, `orig_img`, `orig_desc`,`status`) 
	VALUES ('".$torr_info['name']."', '".$torr_info['hash']."','".$torr_info['date']."', '".$torr_info['size']."', '".$torr_info[1]."', '".$torr_info['forum_id']."', '".$torr_info['forum_name']."', '".$torr_info['year']."', '".$img_src."', NULL,'".$tor_info['status']."');");
	
	$filename=$_SERVER['DOCUMENT_ROOT']."/project/freecon/pages/torrents/".$torr_info[1];
	#Сохраняем описание в файл
	file_put_contents ( $filename , $desc_html);
	
	if($rutr_NewBook_notify=="Да"){#Нужно отправлять письмо о новом торренте на почту
		# Формируем тело письма
		$message_to_adm=$torr_info['name']."<br>
		Скачан торрент с Topic id = ".$torr_info[1]." с <a href='http://rutracker.org/forum/viewtopic.php?t=".$torr_info[1]."'>http://rutracker.org/forum/viewtopic.php?t=".$torr_info[1]."</a><br>
		Ссылка на портале: <a href='https://".$sitedomainname."/?page=book&topic_id=".$torr_info[1]."'>".$torr_info['name']."</a><br>
		ФОРУМ: ".$torr_info['forum_name']."(".$torr_info['forum_id'].")<br>
		СКАЧАНО ЛЕНТОЙ:".$rss_config['feed_name'].' ['.$rss_config['feed_id'].']<br>
		ПРИЧИНА СКАЧИВАНИЯ: '.$dnld_reason.'<br>
		ОПИСАНИЕ:'.mb_substr($desc_html,(mb_strpos($desc_html,"Описание")),2000).'
		'.$add_to_message;
	}
	unset($torr_info);
}