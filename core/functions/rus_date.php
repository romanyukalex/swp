<? # Функции для вывода даты по-русски
# rus_date("j F Y H:i ", strtotime($result['create_date'])

$log->LogInfo('Got this file');
function rus_date() {
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
	 "Jan" => "Янв",
	 "February" => "Февраля",
	 "Feb" => "Фев",
	 "March" => "Марта",
	 "Mar" => "Мар",
	 "April" => "Апреля",
	 "Apr" => "Апр",
	 "May" => "Мая",
	 "May" => "Мая",
	 "June" => "Июня",
	 "Jun" => "Июн",
	 "July" => "Июля",
	 "Jul" => "Июл",
	 "August" => "Августа",
	 "Aug" => "Авг",
	 "September" => "Сентября",
	 "Sep" => "Сен",
	 "October" => "Октября",
	 "Oct" => "Окт",
	 "November" => "Ноября",
	 "Nov" => "Ноя",
	 "December" => "Декабря",
	 "Dec" => "Дек",
	 "st" => "ое",
	 "nd" => "ое",
	 "rd" => "е",
	 "th" => "ое"
	 );
	global $log;
	 
	if (func_num_args() > 1) {// если передали дату, то переводим ее
		$timestamp = func_get_arg(1);
		$rusdate=strtr(date(func_get_arg(0), $timestamp), $translate);
	} else {// иначе текущую дату
		$rusdate=strtr(date(func_get_arg(0)), $translate);
	}
	$log->LogDebug("Date returned by '".(__FUNCTION__)."' is ".$rusdate.".Params: ".implode(',',func_get_args()));
	return $rusdate;
}

?>