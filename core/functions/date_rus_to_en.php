<? # Функции для преобр русской даты в английскую
# date_rus_to_en("Январь 3, 2010")   ->  Yanuary 3,2010 (можно вставлять в strtotime)

$log->LogInfo('Got this file');
function date_rus_to_en($date_string) {
	global $log;

	// Перевод
/*
	 $translate = array(
	 "am" => "дп",
	 "pm" => "пп",
	 "AM" => "ДП",
	 "PM" => "ПП",
	 "Monday" => "Понедельник",
	 "Mon" => "Пн",
	 "Tuesday" => "Вторник",
	 "Tue" => "Вт",
	 "Wednesday" => "Среда",
	 "Wed" => "Ср",
	 "Thursday" => "Четверг",
	 "Thu" => "Чт",
	 "Friday" => "Пятница",
	 "Fri" => "Пт",
	 "Saturday" => "Суббота",
	 "Sat" => "Сб",
	 "Sunday" => "Воскресенье",
	 "Sun" => "Вс",
	 "January" => "Января",
	 "January" => "Январь",
	 "February" => "Февраля",
	 "February" => "Февраль",
	 "March" => "Марта",
	 "March" => "Март",
	 "April" => "Апреля",
	 "April" => "Апрель",
	 "May" => "Мая",
	 "May" => "Май",
	 "June" => "Июня",
	 "June" => "Июнь",
	 "July" => "Июля",
	 "July" => "Июль",
	 "August" => "Августа",
	"August" => "Август",
	 "September" => "Сентября",
	"September" => "Сентябрь",
	 "October" => "Октября",
	 "October" => "Октябрь",
	 "November" => "Ноября",
	  "November" => "Ноябрь",
	 "December" => "Декабря",
	  "December" => "Декабрь",
	 "st" => "ое",
	 "nd" => "ое",
	 "rd" => "е",
	 "th" => "ое"
	 );
*/
	 $translate = array(
	  "дп"=> "am",
	 "пп" => "pm",
	  "ДП"=> "AM",
	  "ПП"=> "PM",
	"Понедельник" =>  "Monday",
	  "Пн" =>"Mon",
	 "Вторник" => "Tuesday",
	  "Вт" =>"Tue",
	  "Среда"=> "Wednesday",
	 "Ср"  => "Wed",
	 "Четверг"  => "Thursday",
	 "Чт" =>  "Thu",
	 "Пятница" =>  "Friday" ,
	  "Пт"=>  "Fri",
	 "Суббота" =>  "Saturday",
	 "Сб" => "Sat" ,
	 "Воскресенье" =>   "Sunday",
	 "Вс"  => "Sun",
	 "Января" =>  "January",
	 "Январь" => "January" ,
	   "Февраля"  =>"February",
	 "Февраль"  => "February",
	  "Марта"=>  "March",
	  "Март"=>  "March",
	 "Апреля" =>  "April",
	 "Апрель" =>  "April",
	  "Мая"=>  "May",
	  "Май" => "May",
	  "Июня"=>  "June",
	 "Июнь" =>  "June",
	  "Июля" =>  "July",
	 "Июль" =>  "July",
	 "Августа" =>  "August",
	"August" =>  "August",
	 "Сентября" =>  "September",
	"Сентябрь" =>  "September",
	"Октября"  =>  "October",
	 "Октябрь" =>  "October",
	 "Ноября"  => "November",
	 "Ноябрь"  =>"November",
	"Декабря" =>   "December",
	 "Декабрь" =>   "December",
	 "ое"  => "st",
	 "ое" =>  "nd",
	 "е" =>  "rd",
	  "ое"=>  "th"
	 );

	foreach($translate as $rus_word => $en_word){
		$date_string=str_replace($rus_word,$en_word,$date_string);
		$date_string=str_replace(mb_strtoupper($rus_word),mb_strtoupper($en_word),$date_string);
		$date_string=str_replace(mb_strtolower($rus_word),mb_strtolower($en_word),$date_string);
	}

	return $date_string;
}

?>