<? 
/*
* определяет до дате рождения знак зодиака
* $month - месяц
* $day - день рождения
echo getZodiac(1, 24); // результат "Водолей"
*/
function getZodiac($month, $day)
{
	$zodiacName = array(
	"Козерог", 
	"Водолей", 
	"Рыбы", 
	"Овен", 
	"Телец", 
	"Близнецы", 
	"Рак", 
	"Лев", 
	"Девы", 
	"Весы", 
	"Скорпион", 
	"Стрелец"
	);
	$zodiacDate = array(1=>21, 2=>20, 3=>20, 4=>20, 5=>20, 6=>20, 7=>21, 8=>22, 9=>23, 10=>23, 11=>23, 12=>23);
	if ($day < $zodiacDate[$month + 1]){
		$result = $zodiacName[$month - 1];
	}else{
		$result = $zodiacName[$month % 12];        
	}
	return $result;
}?>