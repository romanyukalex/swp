<?php 
# Функция отрезает заданное количество слов
// echo string_cut($string,8);
function string_cut($string,$cut_size,$commentnum){
	// $cut_size - количество строк в комментарии
	$StringArray=explode("<br>",$string); 
	$BRcount=count($StringArray); // Счетчик абзацев
	$rowcount=0; // Количество занимаемых строк
	$rowcountold=0;// Предыдущее значение количества занимаемых строк
	for($i=0;$i<$BRcount;$i++){
		if (mb_strlen($StringArray[$i])>79){//$string_cut.= "//".ceil(strlen($StringArray[$i])/79)."//".strlen($StringArray[$i]);
			$rowcount=$rowcount+ceil(mb_strlen($StringArray[$i])/79); // абзацы занимают вот столько строк
		}
		else{$rowcount++;}
		if ($rowcount>=$cut_size){// То пора заканчивать с выводом абзацев но надо вывести часть
			$tett=$cut_size-$rowcountold; // разница между предыдущим количеством строк и максимально возможным (число свободных строчек)
			$string_cut.= mb_substr ("$StringArray[$i]", 0, 78*($tett-1));$i=$BRcount;
		}
		else{// Выводим абзац
			$string_cut.="$StringArray[$i]"."<br>";
			$rowcountold=$rowcountold+$rowcount;
		}
	}
	global $log;
	$log->LogDebug('Called '.(__FUNCTION__)."' function. ".$cut_size." raws has been cut.");
	return "$string_cut"; 
}

function crop_str_word($text, $max_words, $append = ' …')
{
       $max_words = $max_words+1;
       
       $words = explode(' ', $text, $max_words);
       
       array_pop($words);
       
       $text = implode(' ', $words) . $append;
       
       return $text;
}
?>