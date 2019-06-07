<?php
/**
* Получить значение элемента в массиве, где данный элемент имеет самое большое число вхождений.

$array = array(20, 10, 30, 30, 40, 10);
echo array_maxCountElement($array);

*/
function array_maxCountElement ($array=NULL)
{   
    // делаем проверку что мы получили массив 
    if(is_array($array)&&!empty($array))
    {
        // Подсчитываем количество всех значений массива
        $array = array_count_values($array);
        // Получаем максимальное кол-во вхождений
        $maxCount = max($array);
        // Возвращаем элемент массива
        return array_search($maxCount, $array);
    }

    return false;
}?>
