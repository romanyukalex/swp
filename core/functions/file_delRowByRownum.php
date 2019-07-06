<? # удаляет строку из файла по номеру
function file_delRowByRownum($fileName, $num){
    // Открываем файл
    $file = @file($fileName);
    // если файл не найден, выводим ошибку
    if(!$file){
        trigger_error("File '$fileName' not found!");
        return false;
    }
    // если номер строки не корректный, сообщим об этом
    if(!isset($file[$num-1])){
        trigger_error("Incorrect number string: ($num)");
        return false;
    }
    // удаляем строку
    $num = intval($num)-1;
    unset($file[$num]);
    // открываем файл для записи
    $fileOpen = @fopen($fileName,"w"); 
    // если файл невозможно редактировать, сообщаем об этом
    if(!$file){
        trigger_error("File '$fileName' is not writable!");
        return false;
    }
    // перезаписываем файл
    fputs($fileOpen,implode("",$file)); 
    fclose($fileOpen);
    return true;
}

/* пример использования
$result = file_delRowByRownum('/files/test.txt', 3);
var_dump($result);
*/
?>