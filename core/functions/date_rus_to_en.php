<? # Функции для преобр русской даты в английскую
# date_rus_to_en("Январь 3, 2010")   ->  Yanuary 3,2010 (можно вставлять в strtotime)

$log->LogInfo('Got this file');
function date_rus_to_en($date_string) {
	global $log;

	// Перевод
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
	
	foreach($translate as $en_word=>$rus_word){
		$date_string=str_replace($rus_word,$en_word,$date_string);
	}

	return $date_string;
}

?>