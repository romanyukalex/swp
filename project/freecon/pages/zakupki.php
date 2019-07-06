<?

insert_function("ifttt"); //Подключаем функцию, дёргающую webhook IFTTT
insert_function("string_getStrBetween");


$file = $_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/VTBmails.txt';
	// Открываем файл для получения существующего содержимого
	$current = file_get_contents($file);


foreach($_POST as $key => $empty) { 
	$log->LogDebug('Key is '.$key); //Записли текст письма в лог
	
	#Допишем текст письма в файл
		
	
	
	$current .= "-----------------------------\n".$_REQUEST['theme']."\n".'POSTKEY='.$key;
	
	//$data = $_POST['data']; $json = json_decode($data); $device = $json->{'d'};


    $data = json_decode(file_get_contents('php://input')); //php    data = JSON.parse(request.body.read) #ruby-sinatra
	
	$current .="\n".'PHPINPUT='.$data;
	
	// Пишем содержимое обратно в файл
	file_put_contents($file, $current);
	
	unset($data);
	
	if(mb_stristr($key,'заработная_плата')){#Поступила ЗП
		
		#Найдём номер счёта
		$account_num = mb_substr(string_getStrBetween($key, 'на_счет_*', 'поступила'),1,4);
		
		#Найдём сумму
		$summ = str_replace('_',',',mb_substr(string_getStrBetween($key, 'заработная_плата', 'RUB'),1,-1));
		
		#Найдём остаток на счёте
		$money_left = str_replace('_',',',mb_substr(string_getStrBetween($key, 'Доступно', 'RUB'),1,-1));
		
		$log->LogDebug('Account num is '.$account_num.'. Summ is '.$summ.' RUB. Money on account - '.$money_left.' RUB'); //Пишем всё это в лог
		
		# Отправляем уведомление на телефон
		$ifttt_param=array(
			'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d', //Ключ, который можно получить 
			'trigger'=>'NotifyAndroid', //Название триггера webhook в IFTTT
			'params'=>array(
				'value1' => 'Пришла ЗП: '.$summ.' руб.'
			)
		);
		if(ifttt_trigger($ifttt_param)) $log->LogDebug('Notification has been successfully sent');
		else $log->LogDebug('Error when sending notification');
		
		# Отправляем данные в webhook, который записывает строчку в табличку
		$ifttt_param=array(
			'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d', //Ключ, который можно получить на https://ifttt.com/maker_webhooks -> Documentation
			'trigger'=>'CashFlow_in', //Название триггера webhook в IFTTT
			'params'=>array(
				'value1'=>$account_num,
				'value2' => $summ,
				'value3'=>$money_left
			)
		);
		if(ifttt_trigger($ifttt_param)) $log->LogDebug('Row has been successfully inserted');
		else $log->LogDebug('Error when put row');
		
	} elseif(mb_stristr($key,'поступили_денежные')){ #Не ЗП, а просто перевод на счёт
		
		#От кого пришли деньги
		$money_sender =mb_substr(string_getStrBetween($key, 'от', 'в'),1,-1); 
		
		#Найдём номер счёта
		$account_num = mb_substr(string_getStrBetween($key, 'на_Ваш_счет', 'зачислены'),2,4);
		
		#Найдём сумму
		$summ = str_replace('_',',',mb_substr(string_getStrBetween($key, 'в_размере', 'RUB'),1,-1));
		
		#Найдём остаток на счёте
		$money_left = str_replace('_',',',mb_substr(string_getStrBetween($key, 'Доступно_к_использованию:', 'RUB'),1,-1));
		
		$log->LogDebug('Account num is '.$account_num.'. Summ is '.$summ.' RUB. Money on account - '.$money_left.' RUB. Money sender is '.$money_sender); //Пишем всё это в лог
		
		# Отправляем данные в webhook, который записывает строчку в табличку
		$ifttt_param=array(
			'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d', //Ключ, который можно получить на https://ifttt.com/maker_webhooks -> Documentation
			'trigger'=>'CashFlow_in_3rdparty', //Название триггера webhook в IFTTT
			'params'=>array(
				'value1'=>$money_sender,
				'value2' => $summ,
				'value3'=>$money_left
			)
		);
		if(ifttt_trigger($ifttt_param)) $log->LogDebug('Row has been successfully inserted');
		else $log->LogDebug('Error when put row');
		
	} elseif(mb_stristr($key,'Транзакция') and !mb_stristr($key,'отклонена')){#Произошло списание средств с карты
	
		$account_num = mb_substr($key,(mb_strpos($key,'карте_')+7),4);#Найдём номер карты
		
		if(preg_match("/на_сумму([^RUB]*)/",$key,$matches2)) $summ = str_replace('_',',',mb_substr($matches2[1],1,-1));#Найдём сумму
		
		if(preg_match("/использованию([^RUB]*)/",$key,$matches3)) $money_left = str_replace('_',',',mb_substr($matches3[1],1,-1));#Найдём остаток на счёте
		
		if(preg_match("/Детали_платежа:([^\n]*)/",$key,$matches4)) $trsac_detail = mb_substr($matches4[1],1,-1);#Найдём детали транзакции
		
		$log->LogDebug('Account num is '.$account_num.'. Summ is '.$summ.' RUB. Money on account - '.$money_left.' RUB. Transaction details is '.$trsac_detail); //Пишем всё это в лог
		
		$log->LogDebug("Trigger - ".$triggername);
		# Отправляем данные в webhook, который записывает строчку в табличку
		$ifttt_param=array(
			'key'=>'hnMEpWRtP-vy8mY0mbhvxzyYvVDxYRtzTVzr2SJ1U6d', //Ключ, который можно получить на https://ifttt.com/maker_webhooks -> Documentation
			'trigger'=>'CashFlow_out_'.$account_num, //Название триггера webhook в IFTTT
			'params'=>array(
				'value1'=>$summ,
				'value2' =>$money_left ,
				'value3'=>$trsac_detail
			)
		);
		if(ifttt_trigger($ifttt_param)) $log->LogDebug('Row has been successfully inserted');
		else $log->LogDebug('Error when put row');
	}
}

?>