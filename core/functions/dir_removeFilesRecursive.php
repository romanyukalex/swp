<? #// удаление папки со всеми вложенными файлами и подпапками
//$folder = '/new_folder'; // имя новой папки
//dir_removeFilesRecursive($folder); // удаление


$log->LogInfo('Got this file');

function dir_removeFilesRecursive($folder) {
    // получаем все файлы из папки
    if ($files = glob($folder . "/*")) {
        // удаляем по одному
        foreach($files as $file) {
            if(is_dir($file)){
                // если попалась папка, то удаляем ее
                dir_removeFilesRecursive($file); 
            }else{
                // если попался файл
                unlink($file);
            }
        }
    }
    // удаляем пустую папку
    rmdir($folder);
} 
?>