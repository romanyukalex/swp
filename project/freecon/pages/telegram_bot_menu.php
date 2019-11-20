<? #Формирует меню для psyspace_bot

	include($_SERVER['DOCUMENT_ROOT'].'/modules/telegram_api/vendor/autoload.php'); //Подключаем библиотеку


	use Telegram\Bot\Api;

	$log->LogDebug("Query from TG: ".  $HTTP_RAW_POST_DATA);

	$telegram = new Api('468386961:AAG6Ih5bIT6iCP4oT6lu5MJJpX-SwI1iXaw',true); //Устанавливаем токен, полученный у BotFather (PsyspaceBot)

	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	// $result Содержит примерно следующее  {"update_id":126797430,"message":{"message_id":128,"from":{"id":250150108,"is_bot":false,"first_name":"Alexey","last_name":"Romanyuk","username":"ARomanyuk","language_code":"ru"},"chat":{"id":250150108,"first_name":"Alexey","last_name":"Romanyuk","username":"ARomanyuk","type":"private"},"date":1510047803,"text":"sd"}}
	//$log->LogDebug("Query from TG: ".  json_encode ($result));

	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["username"]; //Юзернейм пользователя
	$keyboard = [["Картинка"],["Гифка"],["Картинка2"]]; //Клавиатура

	
	
	if($text){
		 if ($text == "/start") {
			$reply = "Добро пожаловать в бота!";
			$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
		}elseif ($text == "/help") {
			$reply = "Информация с помощью.";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
		}elseif ($text == "Картинка") {
			$url = "https://68.media.tumblr.com/6d830b4f2c455f9cb6cd4ebe5011d2b8/tumblr_oj49kevkUz1v4bb1no1_500.jpg";
			$telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $url, 'caption' => "Описание." ]);
		}elseif ($text == "Гифка") {
			$url = "https://68.media.tumblr.com/bd08f2aa85a6eb8b7a9f4b07c0807d71/tumblr_ofrc94sG1e1sjmm5ao1_400.gif";
			$telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Описание." ]);
		}
		elseif ($text == "Последние статьи") {
			$html=simplexml_load_file('http://netology.ru/blog/rss.xml');
			foreach ($html->channel->item as $item) {
		 $reply .= "\xE2\x9E\xA1 ". //Смайлы
			$item->title." (<a href='".$item->link."'>читать</a>)\n";
			}
			$telegram->sendMessage([ 'chat_id' => $chat_id, 
				'parse_mode' => 'HTML', 
				'disable_web_page_preview' => true, // чтобы к сообщению со ссылкой не подгружалось превью.
				'text' => $reply ]);
			
		}
		else{
			$reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
		}
	}else{
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
	}

?>