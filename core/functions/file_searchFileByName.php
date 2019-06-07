<? 
$log->LogInfo('Got this file');
/**
* Поиск файла по имени во всех папках и подпапках
* 
* @param string $folderName - пусть до папки
* @param string $fileName - искомый файл

// пример использования
$folderName = "./files"; // в какой папке ищем
$fileName = "test.txt"; // что ищем
$result = search_file($folderName, $fileName);
if($result){
    echo $result;
}else{
    echo "Нет такого файла";
}

*/
function search_file($folderName, $fileName){
    // открываем текущую папку 
    $dir = opendir($folderName); 
    // перебираем папку 
    while (($file = readdir($dir)) !== false){ // перебираем пока есть файлы
        if($file != "." && $file != ".."){ // если это не папка
            if(is_file($folderName."/".$file)){ // если файл проверяем имя
                // если имя файла нужное, то вернем путь до него
                if($file == $fileName) return $folderName."/".$file;
            } 
            // если папка, то рекурсивно вызываем search_file
            if(is_dir($folderName."/".$file)) return search_file($folderName."/".$file, $fileName);
        } 
    }
    // закрываем папку
    closedir($dir);
}?>