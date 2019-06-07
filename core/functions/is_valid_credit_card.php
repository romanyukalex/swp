<? # Проверка правильности номера кредитной карты по алгоритму Луна
	
function is_valid_credit_card($s) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    // оставить только цифры
    $s = strrev(preg_replace('/[^\d]/','',$s));
 
    // вычисление контрольной суммы
    $sum = 0;
    for ($i = 0, $j = strlen($s); $i < $j; $i++) {
        // использовать четные цифры как есть
        if (($i % 2) == 0) {
            $val = $s[$i];
        } else {
            // удвоить нечетные цифры и вычесть 9, если они больше 9
            $val = $s[$i] * 2;
            if ($val > 9)  $val -= 9;
        }
        $sum += $val;
    }
 
    // число корректно, если сумма равна 10
    if(($sum % 10) == 0) $log->LogDebug("Decision: card number is valid");
	else $log->LogDebug("Decision: card number is INVALID");
    return (($sum % 10) == 0);
}
/*
if (! is_valid_credit_card('4111 1111 1111 1234')) {
    echo 'ошибка в номере';
}*/
?>
