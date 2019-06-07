<?php 
# Функция заменяет N-ное вхождение подстроки (начиная с 0-й, естественно)
// $subject = "One fish two fish red fish blue fish";
// echo string_replace_nth('fish', 'bla-bla-bla', $subject, 2);
// Даёт: One fish two fish red bla-bla-bla blue fish
// $page_html=string_replace_nth_my('</p>', "</p><b>!</b>", $page_html, 2);//Добавляет ! после третьего абзаца

 
 function string_replace_nth($search, $replace, $subject, $nth)
{
	#Разбиваем строку на части
	$str_arr=explode($search,$subject);
	foreach($str_arr as $arr_num=>$arr_elem){//Перебираем элементы
		if($arr_num==$nth){//N-ный элемент, заменяем нужное
			$result.=$arr_elem.$replace;
		}
		else{//Не N-ный элемент. Просто присоединяем
			$result.=$arr_elem.$search;
		}
		
	}
	return $result;
}

?>