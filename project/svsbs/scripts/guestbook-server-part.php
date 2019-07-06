<?php # Серверная часть гостевой книги
# Сделать БД:
/* CREATE TABLE `messages` (
  `id` int(5) NOT NULL auto_increment,
  `name` char(255) character set utf8 NOT NULL,
  `text` text character set utf8,
  PRIMARY KEY  (`id`)
); */

require_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
@include_once($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
//Header("Content-Type: text/javascript; charset=utf-8"); // говорим браузеру что это javascript в кодировке UTF-8 

// проверяем есть ли переменная act (send или load), которая указываем нам что делать
if( isset($_POST['act']) ) 
{
	// $_POST['act'] - существует
	switch ($_POST['act'])
	{
		case "send" : // если она равняется send, вызываем функцию Send()
			Send();
			break;
		case "load" : // если она равняется load, вызываем функцию Load()
			Load();
			break;
		default : // если ни тому и не другому  - выходим
			exit();
	}
}

// Функция выполняет сохранение сообщения в базе данных
function Send()
{
	
	$name=process_data($_REQUEST['name'],30);
	$text=str_replace("\n","<br>",process_data($_REQUEST['text'],2000));
	// добавляем новую запись в таблицу messages
	mysql_query("INSERT INTO messages (name,text) VALUES ('" . $name . "', '" . $text . "')");
}


// функция выполняет загрузку сообщений из базы данных и отправку их пользователю через ajax виде java-скрипта
function Load()
{
	// тут мы получили переменную переданную нашим java-скриптом при помощи ajax
	// это:  $_POST['last'] - номер последнего сообщения которое загрузилось у пользователя 

	$last_message_id = intval($_POST['last']); // возвращает целое значение переменной
	$gbmode=process_data($_REQUEST['gbmode'],3);
	if(!$gbmode or $gbmode=="nor"){// получения 10 сообщений последних сообщений с номером большим чем $last_message_id
		$query = mysql_query("SELECT * FROM messages WHERE ( id > $last_message_id ) ORDER BY id DESC LIMIT 10");
	}
	elseif($gbmode=="all"){// получения всех последних сообщений с номером большим чем $last_message_id
		$query = mysql_query("SELECT * FROM messages WHERE 1 ORDER BY id DESC");
	}
	// проверяем есть ли какие-нибудь новые сообщения
	if( mysql_num_rows($query) > 0 )
	{
		// начинаем формировать java-скрипт который мы передадим клиенту
		//$js = 'var chat = $("#chat_area");'; // получаем "указатель" на div, в который мы добавим новые сообщения
		
		// следующий конструкцией мы получаем массив сообщений из нашего запроса
		$messages = array();
		while ( $row = mysql_fetch_array($query) )
		{
			$messages[] = $row;
		}
		
		// записываем номер последнего сообщения
		// [0] - это вернёт нам первый элемент в массиве $messages, но так как мы выполнили запрос с параметром "DESC" (в обратном порядке),
		// то это получается номер последнего сообщения в базе данных
		$last_message_id = $messages[0]['id'];
		
		// переворачиваем массив (теперь он в правильном порядке)
		$messages = array_reverse($messages);
		
		// идём по всем этементам массива $messages
		foreach ( $messages as $value )
		{
			// формируем данные для отправки пользователю
		//	$js .= 'chat.append("<ul '."class='m_blog listing topbox'><li><span title='Опубликовал ".$value['name']."'>".$value['date']." <b>".$value['name']."</b></span>".$value['text'].'</li></ul>'.'");';
		$messageheight=30;
		if (substr_count($value['text'],"<br>")>1){$messageheight=$messageheight+substr_count($value['text'],"<br>")*10;}
		$js .= "<ul class='m_blog listing topbox' style='height:$messageheight px'><li><span title='Опубликовал ".$value['name']."'>".$value['date']." <b>".$value['name']."</b></span>".$value['text'].'</li></ul>';
		}

		//$js .= "last_message_id = $last_message_id;"; // запишем номер последнего полученного сообщения, что бы в следующий раз начать загрузку с этого сообщения

		// отправляем полученный код пользователю, где он будет выполнен при помощи функции eval()
		echo $js;
	}
}
?>