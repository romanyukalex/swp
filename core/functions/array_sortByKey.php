<?php
/**
* Сортировка массива по ключу

Например мы имеем массив такого вида

 Array
(
    [0] => Array
        (
            [id] => 221
            [task_name] => API
            [parent_id] => 0
            [project_id] => 24
            [position] => 2
        )

    [1] => Array
        (
            [id] => 225
            [task_name] => Аналитика
            [parent_id] => 0
            [project_id] => 24
            [position] => 0
        )
    [2] => Array
        (
            [id] => 226
            [task_name] => Кодинг
            [parent_id] => 0
            [project_id] => 24
            [position] => 1
        )
)
//Нужно отсортировать по position

array_sortByKey(&$arr,"position");


На выходе мы получим массив такого вида

 Array
(
    [0] => Array
        (
            [id] => 225
            [task_name] => Аналитика
            [parent_id] => 0
            [project_id] => 24
            [position] => 0
        )
    [1] => Array
        (
            [id] => 226
            [task_name] => Кодинг
            [parent_id] => 0
            [project_id] => 24
            [position] => 1
        )
    [2] => Array
        (
            [id] => 221
            [task_name] => API
            [parent_id] => 0
            [project_id] => 24
            [position] => 2
        )
)

Post 
*/
function array_sortByKey(&$arr,$sortkey)
{
    foreach ($arr as $key => $row) {
        $position[$key]  = $row[$sortkey];
    }
    array_multisort($position, SORT_ASC, $arr);
}?>
