<? # Скрипт парсит всю ленту рутрекера и ищет книги по теме психологии, не входящие в остальные разделы
$log->LogInfo('Got this file');
$psy_kws=array(
    "психолог","ораторск", "личностное","стресс","цели","нлп","внимани","стать лидер","самооценк","коммуникац","невербальн","карьер","менеджмент","бизнес","успе","воспит",
    " транс","гипноз","терапия","терапевтичес","психоанали","метафор","сомати","мозг","випассан","медитац"
);
$books_ext=array("fb2","pdf","epub","txt","docx","djvu","doc");
 $log->LogDebug("This torrent name is ".$rss_item['title']);
foreach($psy_kws as $keyword){
    if(mb_strstr(mb_strtolower($rss_item['title']),$keyword)){ // В посте есть ключевое слово
        $log->LogDebug("This torrent contains our keyword - ".$keyword);
        // смотрим, книга ли это
         foreach($books_ext as $extention){
             if(mb_strstr(mb_strtolower($rss_item['title']),$extention)){ //Да, это книга
                 $log->LogDebug("This is book. Start to download");
                include "parse_torrent_page.php";
                break;
             }
         }
    } 
}

