<?
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
/*
WIRTEL*(:)* 2008
Небольшой скрипт собирающий данные о погоде на сутки вперёд с XML-файлов проекта Gismeteo.ru. Данные обновляются, как утверждает источник, 4 раза в сутки (2.30, 8.30, 14.30, 20.30 МСК по зимнему времени). Полностью разобраны данные о погоде, можно выводить любым образом. Возможность выбирать несколько городов, достаточно только указать ID города(например:03161_1.xml).
*/
class Weather {
	var $city;
	var $weather;
	var $encode = 'utf8'; // Кодировка в которой будут выводиться данные
	var $patchimg = 'weather/weather/'; //Адрес к картинкам. Вы можете по желанию изменить директорию с картинками, также можете задать адрес внешнего источника, но могут возникнуть проблемы с именем файлов вам нужно будет изменить массив $cloudiness и $precipitation, а мменно вы можете изменить только имя файлов (например:<img src=".$this->patchimg."0".(($n=='0' || $n=='4')?'_night':'').".gif,, заменить на <img src=".$this->patchimg."Sunny.gif)
//	var $patchcache = '/home/tribalm/public_html/hotel/weather/cache_weather/'; //Директория для хранение КЕШ-файлов, обычно задаётся полный путь к директории (например: для Windows 'X:/cache/wth/' для *Unix '/usr/www/site/cache/wth/')
	//Подключаемся без использования КЕШа, т.е. постоянное соединение ссервером, что является не выгодным для веб-сервера и трафика на хостинге,  а также не выгодно самому проекту, т.е. страницы будут подвисать и долго открываться. Использовать этот метот не рекомендуется.
	var $patchcache = '/home/magicsol/public_html/FOLDER/weather/cache_weather/';
	function Connect($url, $encode){
		$url = 'http://informer.gismeteo.ru/xml/'.$url; //Генерируем URL
		$content = @file_get_contents($url); //Функция работает начиная с PHP 5.x, возможна проблема на некоторых хостингах директива allow_url_fopen в php.ini выключена и включить её через .htaccess не получится
		$content = str_replace(array(''.chr(13).'',''.chr(10).'',''.chr(9).'','\n','\r','/',' '),array(''),$content); //Вырезаем все переходы на строку, пробелы.
		
		$this->city=$this->pCity($content); //Задаём переменной $city название города
		$this->weather=$this->Parser($content); //Задаём переменной $weather готовые данные
	}
	//Подключаемся с использованием КЕШа, т.е. данные будут сохраняться в файл. Это более удобный вариант. 
	function ConnectCache($url, $expire =7200){
		$mtime = 0;
		$file_cacheid = $this->patchcache . md5($url); //Создаём переменую с Директорией и зашифрованым файлом
		if($file_cacheid) $s=true; else $s=false; // Проверяем создалась ли переменная
        if(!file_exists($file_cacheid)) $s=false; //Проверяем есть ли уже созданый КЕШ-файл 
        if(!($mtime = @filemtime($file_cacheid))) $s=false; //Если нет переменной времени создания/изменения файлов то возвращаем false
        if(($mtime + $expire) < time()){ //Проверяем устарел ли файл, проверяется в зависимости от установленой $expire по умолчанию она стоит 7200, т.е. данные будут обновляться каждые 2 часа
            @unlink($file_cacheid); //Если устарел удаляем его.
            $s=false;
        }
        else {
           $s=true;
        }
		if ((!$s)) { //Если устарел файл, то создаём новый
			if(file_exists($file_cacheid))
				@unlink($file_cacheid); //удаляем его, если не удалён
			$url = 'http://informer.gismeteo.ru/xml/'.$url; //Генерируем URL
			$content = file_get_contents($url);
			$content = str_replace(array(''.chr(11).'',''.chr(13).'',''.chr(10).'',''.chr(9).'','\n','\r','/',' '),array(''),$content);
			$this->city=$this->pCity($content);
			$this->weather=$this->Parser($content);
			if($fp = @fopen($file_cacheid, 'w')) {
                fwrite($fp, ''.$this->city.'|'.$this->weather.'|'); //Записываем в файл в виде маски город|погода|, если изменить придёться поменять и способ разбивки, который парсит данные из файла.
                fclose($fp); 
            }
            else {
                die('Unable to write cache.');
            }

		} else {
			$fp = @fopen($file_cacheid, 'r'); //Открываем КЕШ-файл 
			$p = explode('|',fread($fp, filesize($file_cacheid))); //Cпособ рабития на массив |, читайм файл
            fclose($fp);
			
			if ($this->encode !== 'windows-1251'){// Если кодировка не windows-1251 и требуется перекодирование
			$this->city = iconv ("windows-1251", $this->encode, $p[0]); //Задаём переменной $city название города из КЕШ-файла с учетом необходимой кодировки
			$this->weather = iconv ("windows-1251", $this->encode, $p[1]); //Задаём переменной $weather данные погоды из КЕШ-файла с учетом необходимой кодировки
		}
				else{// Если кодировка windows-1251
	//		$this->city = $p[0]; //Задаём переменной $city название города из КЕш-файла
			$this->weather = $p[1]; //Задаём переменной $weather дфнные погоды из КЕш-файла
		}
		
		
		
		}
	}
	//Парсим название города
	function pCity($content){
		$str = "<TOWNindex=\"(.*)\"sname=\"(.*)\"latitude=\"(.*)\"longitude=\"(.*)\">";
		if (eregi($str,$content,$out)){
			return urldecode($out[2]);
		} else return 'Unknow';
	}
	//Парсим погоду
	function Parser($content){
		if ($content){
			$str='<FORECASTday="([0-9]{1,2})"month="([0-9]{1,2})"year="([0-9]{4})"hour="([0-9]{1,2})"tod="([0-9]{1})"predict="([0-9]{1,3})"weekday="([0-9]{1})"><PHENOMENAcloudiness="([0-3])"precipitation="([0-9]{1,2})"rpower="([0-1])"spower="([0-1])"><PRESSUREmax="([0-9]{1,3})"min="([0-9]{1,3})"><TEMPERATUREmax="([-,0-9]{1,3})"min="([-,0-9]{1,3})"><WINDmin="([0-9]{1,3})"max="([0-9]{1,3})"direction="([0-9]{1})"><RELWETmax="([0-9]{1,3})"min="([0-9]{1,3})"><HEATmin="([-,0-9]{1,3})"max="([-,0-9]{1,3})"><FORECAST>'.
			'<FORECASTday="([0-9]{1,2})"month="([0-9]{1,2})"year="([0-9]{4})"hour="([0-9]{1,2})"tod="([0-9]{1})"predict="([0-9]{1,3})"weekday="([0-9]{1})"><PHENOMENAcloudiness="([0-3])"precipitation="([0-9]{1,2})"rpower="([0-1])"spower="([0-1])"><PRESSUREmax="([0-9]{1,3})"min="([0-9]{1,3})"><TEMPERATUREmax="([-,0-9]{1,3})"min="([-,0-9]{1,3})"><WINDmin="([0-9]{1,3})"max="([0-9]{1,3})"direction="([0-9]{1})"><RELWETmax="([0-9]{1,3})"min="([0-9]{1,3})"><HEATmin="([-,0-9]{1,3})"max="([-,0-9]{1,3})"><FORECAST>'.
			'<FORECASTday="([0-9]{1,2})"month="([0-9]{1,2})"year="([0-9]{4})"hour="([0-9]{1,2})"tod="([0-9]{1})"predict="([0-9]{1,3})"weekday="([0-9]{1})"><PHENOMENAcloudiness="([0-3])"precipitation="([0-9]{1,2})"rpower="([0-1])"spower="([0-1])"><PRESSUREmax="([0-9]{1,3})"min="([0-9]{1,3})"><TEMPERATUREmax="([-,0-9]{1,3})"min="([-,0-9]{1,3})"><WINDmin="([0-9]{1,3})"max="([0-9]{1,3})"direction="([0-9]{1})"><RELWETmax="([0-9]{1,3})"min="([0-9]{1,3})"><HEATmin="([-,0-9]{1,3})"max="([-,0-9]{1,3})"><FORECAST>';
			if (eregi($str,$content,$out)){
				return $this->arr($out);
			} else return ' Ошибка в данных сайта gismeteo.ru! ';
		} else return 'Ошибка! Соединения с '.$url.'';
	}
	//Задаём картинки для каждого типа осадков

	function imgcloud($n){
		$n=ceil($n);
		$cloudiness=array(
		'0' => "<img class='weatherimage' src=".$this->patchimg."0".(($n=='0' || $n=='4')?'_night':'').".png alt=\"Ясно\" title=\"Ясно\">", //Тип погоды Ясно, путь к картинки задан ".$this->patchimg." , сама переменная задаётся выше. Данное действие означает ".(($n=='0' || $n=='4')?'_night':'')." добавлять или нет к картинки приставку _night, т.е. картинка показываюшаяя погоду в ночное время суток.
		'1' => "<img class='weatherimage' src=".$this->patchimg."1".(($n=='0' || $n=='4')?'_night':'').".gif alt=\"Малооблачно\" title=\"Малооблачно\">", //Тип погоды Малооблачно, далее по анологии, тип погоды находиться  в теге title=\" Малооблачно \", если вы не желаете использовать картинки просто удалите вот эти даннные <img src=".$this->patchimg."1".(($n=='0' || $n=='4')?'_night':'').".gif style=\"float:left;margin-top:7px;\" alt=\"Малооблачно\" title=\"Малооблачно\"> оставьте только одно слово Малооблачно.
		'2' => "<img class='weatherimage' src=".$this->patchimg."2".(($n=='0' || $n=='4')?'_night':'').".gif  alt=\"Облачно\" title=\"Облачно\">",
		'3' => "<img class='weatherimage' src=".$this->patchimg."3.gif  alt=\"Пасмурно\" title=\"Пасмурно\">");
		
		return $cloudiness;
	}
	//Задаём картинки для каждого типа осадков
	function imgprecip($n){
		$n=ceil($n);
		$precipitation=array(
		'4' => "<img class='weatherimage' src=".$this->patchimg."4.gif  alt=\"Дождь\" title=\"Дождь\">" ,
		'5' => "<img class='weatherimage' src=".$this->patchimg."5.gif  alt=\"Ливень\" title=\"Ливень\">",
		'6' => "<img  class='weatherimage' src=".$this->patchimg."6.gif  alt=\"Снег\" title=\"Снег\">",
		'7' => "<img class='weatherimage' src=".$this->patchimg."6.gif  alt=\"Снег\" title=\"Снег\">",
		'8' => "<img class='weatherimage' src=".$this->patchimg."8.gif  alt=\"Гроза\" title=\"Гроза\">",
		'9' => "<img class='weatherimage' src=".$this->patchimg."9".(($n=='0' || $n=='4')?'_night':'').".gif  alt=\"нет данных\" title=\"нет данных\">",
		'10' => "<img src=".$this->patchimg."10".(($n=='0' || $n=='4')?'_night':'').".gif  alt=\"Ясно\" title=\"rerЯсно\">");
		
		return $precipitation;
	}
	
	function arr($out){
		$month_array = array( '1' => 'января' , '2' => 'февраля' , '3' => 'марта' , '4' => 'апреля' , '5' => 'мая' , '6' => 'июня' , '7' => 'июля' ,
		'8' => 'августа' , '9' => 'сентября' , '10' => 'октября' , '11' => 'ноября' , '12' => 'декабря' );
		$tod = array( '0' => 'Ночью' , '1' => 'Утром' , '2' => 'Днем' , '3' => 'Вечером' , '4' => 'Ночью' );
		$rpower = array( '0' =>' возможен дождь/снег' , '1' => ' дождь/снег' );
		$spower = array( '0' =>' возможна гроза', '1' => ' гроза' );
		$direction = array( '0' => 'северный' , '1' => 'северо-восточный' , '2' => 'восточный' , '3' => 'юго-восточный' , '4' => 'южный' , '5' => 'юго-западный' ,
		'6' => 'западный' , '7' => 'северо-западный' );
		$direction = array( '0' => 'северный' , '1' => 'северо-восточный' , '2' => 'восточный' , '3' => 'юго-восточный' , '4' => 'южный' , '5' => 'юго-западный' ,
		'6' => 'западный' , '7' => 'северо-западный' );
		$weekday = array( '1' => 'воскресенье' , '2' => 'понедельник' , '3' => 'вторник' , '4' => 'среду' , '5' => 'четверг' , '6' => 'пятницу' , '7' => 'субботу' );
		
		$day1 = $out[1]; //День ввиде DD
		$month1 = $month_array[ceil($out[2])]; //День ввиде названия месяца, данные храняться в $month_array выше
		$tod1 = $tod[ceil($out[5])]; //Время суток в виде Ночь, Утро, День,  Вечер, Ночь, данные храняться в $tod  выше
		$weekday1 = $weekday[$out[7]]; // название дня недели воскресенье, понедельник .. суббота,  данные храняться в $weekday выше
				
		$rpower1 = $rpower[$out[10]]; //Вид осадков, данные храняться в $rpower
		$spower1 = $spower[$out[11]]; //Вид осадков, данные храняться в $spower
		if (($out[8] < 4) and ($out[8] >= 0) and ($out[9]=='10')) {
			$cloudiness=$this->imgcloud($out[5]); //задаём массив картинок погоды используя функцию imgcloud()
			$cloudiness1 = $cloudiness[$out[8]]; //задаём картинку
		} else {
			$precipitation=$this->imgprecip($out[5]); //задаём массив картинок погоды используя функцию imgprecip()
			$precipitation1 = $precipitation[$out[9]]; //задаём картинку
		}
				
		$pressureMAX1 = $out[12]; //Минимальное атмосферное давление, в мм.рт.ст.
		$pressureMIN1 = $out[13]; //Максимальное атмосферное давление, в мм.рт.ст.
		$tempMIN1 = $out[15]; //Минимальная температура воздуха, в градусах Цельсия
		$tempMAX1 = $out[14]; //Максимальная температура воздуха, в градусах Цельсия
		$windMIN1 = $out[16]; //Минимальное значения средней скорости ветра, без порывов
		$windMAX1 = $out[17]; //Максимальное значения средней скорости ветра, без порывов
		$direction1 = $direction[$out[18]]; //направление ветра в румбах, 0 - северный, 1 - северо-восточный,  и т.д., данные храняться в $direction выше
		$relwenMIN1 = $out[20]; //Минимальная относительная влажность воздуха, в %
		$relwenMAX1 = $out[19]; //Максимальная относительная влажность воздуха, в %
		$heatMIN1 = $out[21]; //Минимальный комфорт - температура воздуха по ощущению одетого по сезону человека, выходящего на улицу
		$heatMAX1 = $out[22]; //Максимальный комфорт - температура воздуха по ощущению одетого по сезону человека, выходящего на улицу
		//Ниже по аналогии названы переменные изменно положение суток, т.е. можно выводить 3 положения на целые сутки, например  День пятницы Вчер пятницы и Ночь субботы.
		$day2 = $out[23];
		$month2 = $month_array[ceil($out[24])];
		$tod2 = $tod[ceil($out[27])];
		$weekday2 = $weekday[$out[29]];
				
		$rpower2 = $rpower[$out[32]];
		$spower2 = $spower[$out[33]];
				
		if (($out[30] < 4) and ($out[30] >= 0) and ($out[31]=='10')) { 
			$cloudiness=$this->imgcloud($out[27]);
			$cloudiness2 = $cloudiness[$out[30]];
		} else {
			$precipitation=$this->imgprecip($out[27]);
			$precipitation2 = $precipitation[$out[31]];
		}
				
		$pressureMIN2 = $out[35];
		$pressureMAX2 = $out[34];
		$tempMIN2 = $out[37];
		$tempMAX2 = $out[36];
		$windMIN2 = $out[38];
		$windMAX2 = $out[39];
		$direction2 = $direction[$out[40]];
		$relwenMIN2 = $out[42];
		$relwenMAX2 = $out[41];
		$heatMIN2 = $out[43]; 
		$heatMAX2 = $out[44]; 

		$day3 = $out[45];
		$month3 = $month_array[ceil($out[46])];
		$tod3 = $tod[ceil($out[49])];
		$weekday3 = $weekday[$out[51]];
				
		$rpower3 = $rpower[$out[54]];
		$spower3 = $spower[$out[55]];
				
		if (($out[52] < 4) and ($out[52] >= 0) and ($out[53]=='10')) {
			$cloudiness=$this->imgcloud($out[49]);
			$cloudiness3 = $cloudiness[$out[52]];
		} else {
			$precipitation=$this->imgprecip($out[49]);
			$precipitation3 = $precipitation[$out[53]];
		}
				
		$pressureMIN3 = $out[57];
		$pressureMAX3 = $out[56];
		$tempMIN3 = $out[59];
		$tempMAX3 = $out[58];
		$windMIN3 = $out[60];
		$windMAX3 = $out[61];
		$direction3 = $direction[$out[62]];
		$relwenMIN3 = $out[64];
		$relwenMAX3 = $out[63];
		$heatMIN3 = $out[65];
		$heatMAX3 = $out[66];
		
		/* 
		Выможете изменить ниже строчки, добавить переменные такие как $relwenMIN1, $relwenMIN2,$relwenMIN3 и теже самые тока $relwenMAX1.. и др
		Также вы можете убрать переменные которые вам не нужны или изменить вид их вывода.
		Данные в данном виде подойдут для вывода их по бокам сайта, т.е. в блоках.
		*/
		$content .= "<span id='weatherheader'>Погода во Владимире</span><div style='width:300;'><span id='weatherdayandweek'>".$day1.$month1." в ".$weekday1."</span> <br /><b style='color:#3f3d3b'>".$tod1." <span title=\"комфорт ".$heatMIN1."..".$heatMAX1."°C\">".$tempMIN1."°C...".$tempMAX1."°C</span></b> ".$cloudiness1." ".$precipitation1."</div>";
/* 		$content .= "<div>".$cloudiness2." ".$precipitation2." <span style=\"font-size:12px;\">".$day2." ".$month2." в ".$weekday2."</span> <br /><b style=\"font-size:12px;\">".$tod2."   <span title=\"комфорт ".$heatMIN2."..".$heatMAX2."°C\">".$tempMIN2."°C...".$tempMAX2."°C</span></b><br /> <span style=\"font-size:10px;\">ветер ".$windMIN2."-".$windMAX2."м/c ".$direction2."</span></div>";
		$content .= "<div>".$cloudiness3." ".$precipitation3." <span style=\"font-size:12px;\">".$day3." ".$month3." в ".$weekday3."</span> <br /><b style=\"font-size:12px;\">".$tod3." <span title=\"комфорт ".$heatMIN3."..".$heatMAX3."°C\">".$tempMIN3."°C...".$tempMAX3."°C</span></b><br /> <span style=\"font-size:10px;\">ветер ".$windMIN3."-".$windMAX3."м/c ".$direction3."</span></div>"; */
	
		return $content; //Выводим строчки выше

	
	}
}
?>
<? } ?>
