<? # Определение возраста. Формат даты по полю типа date из БД: 2014-06-29
function getAge($birthdate) {
	$birthdate_data=explode("-",$birthdate);
	$y=$birthdate_data[0];
	$m=$birthdate_data[1];
	$d=$birthdate_data[2];
	if($m > date('m') || $m == date('m') && $d > date('d')) return (date('Y') - $y - 1);
	else return (date('Y') - $y);
}
 /*
    * Получение возраста
    * $day - день
    * $mouth - месяц
    * $year - год
    */
    function getAge2($day, $mouth, $year) 
    {
        if($mouth > date('m') || $mouth == date('m') && $day > date('d')){
            return (date('Y') - $year - 1);
        }else{
            return (date('Y') - $year);
        }
    }

?>