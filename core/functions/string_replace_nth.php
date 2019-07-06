<?php 
# Функция заменяет N-ное вхождение подстроки
// $subject = "One fish two fish red fish blue fish";
// echo string_replace_nth('fish', 'bla-bla-bla', $subject, 2);
// Даёт: One fish two fish red bla-bla-bla blue fish
// $page_html=string_replace_nth_my('</p>', "</p><b>!</b>", $page_html, 2);//Добавляет ! после 2 абзаца

 
 function string_replace_nth($search, $replace, $subject, $nth)
{
	#Разбиваем строку на части
	$str_arr=explode($search,$subject);
	$str_arr_size=count($str_arr);
	if($str_arr_size==1) { // Нет в $subject ни одного $search
		return $subject;
	} else { #Есть нужные слова в тексте, как минимум 1
	
		foreach($str_arr as $arr_num=>$arr_elem){//Перебираем части строки $subject
			if(($arr_num+1)==$nth){//N-ный элемент, заменяем нужное
				$result.=$arr_elem.$replace;
				//echo "<br>1 Разбили строку на $str_arr_size, сейчас $arr_num итерация, ДОБАВИЛИ  $replace	<br>";
			}
			else{//Не N-ный элемент. Просто присоединяем
				if($arr_num!==($str_arr_size-1)) {
					$result.=$arr_elem.$search;
				//	echo "<br>2 Разбили строку на $str_arr_size, сейчас $arr_num итерация, ДОБАВИЛИ  $search<br>";
				} else $result.=$arr_elem;
			}
			
		}
		return $result;
	}
}

#Первое вхождение (проверить)
function str_replace_once($search, $replace, $text) {
	$pos = mb_strpos($text, $search);
	return $pos!==false ? mb_substr($text, 0, $pos).$replace.mb_substr($text, $pos+mb_strlen($search)) : $text;
}

/*
$str = 'Helo World!'; 
$str = str_replace_once('l', 'll', $str); 
// $str = 'Hello World!'; 

Или вообще вот так:
$str = preg_replace(‘/l/’, ‘ll’, $str, 1); //последней цифрой указывается сколько сделать замен вхождений, если не указать, заменяются все вхождения

*/

?>