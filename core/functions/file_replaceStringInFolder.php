<?/**
* Функция замены текста во всех файлах папки
* 
* @param string $folderName - пусть до папки
* @param string $oldText - искомый текст
* @param string $newText - на что меняем текст

// пример использования
$oldText = 'old text'; // что меняем
$newText = 'new text'; // на что меняем
$folderName = "./files"; // в какой папке ищем
file_replaceStringInFolder($folderName, $oldText, $newText);

*/
function file_replaceStringInFolder($folderName, $oldText, $newText){
    // открываем текущую папку 
    $dir = opendir($folderName); 
    // перебираем папку 
    while (($file = readdir($dir)) !== false){ // перебираем пока есть файлы
        if($file != "." && $file != ".."){ // если это не папка
            if(is_file($folderName."/".$file)){ // если файл
                $contentFile = file_get_contents($folderName."/".$file); // открываем файл
                //$contentFile = iconv("windows-1251", "utf-8", $contentFile); // для работы с файлами в кодировке windows-1251
                $contentFile = str_replace($oldText, $newText, $contentFile); // делаем замену в тексте
                file_put_contents($folderName."/".$file,$contentFile); // сохраняем изменения
            } 
            // если папка, то рекурсивно вызываем file_replaceStringInFolder
            if(is_dir($folderName."/".$file)) file_replaceStringInFolder($folderName."/".$file, $oldText, $newText);
        } 
    } 
    // закрываем папку
    closedir($dir); 
}?>