<? 
#Принимает запросы от zapier на page=zapier_rss и обрабатывает его


if($nitka=="1"){

	if(strstr($_REQUEST['link'],"book24")){
		$book_name=$_REQUEST['title'];//Имя книги
		$rss_item['link']=$_REQUEST['link'];
		
		include $_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/site_parsing/parse_book24.php';
		$book_link=mb_substr($_REQUEST['link'],17);//Обрезанная ссылка
		#Пишем строку в БД
		mysql_query("INSERT INTO `freecon-books-book24ru` (`name`, `author`, `pics`, `link`, `price`, `publisher`, `year`, `ISBN`, `kw`) VALUES 
		('".$book_name."', '".$book_arr['author_name']."', '".$book_arr['img']."', '".$book_link."', '".$book_arr['price']."', '".$book_arr['publisher']."', '".$book_arr['year']."', '".$book_arr['ISBN']."', '".$book_arr['kw']."');");

		#Записываем описание книги в файл
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/books_book24ru/'.mysql_insert_id(), $book_arr['description']);
		
		#Оповещаем подписчиков VK о новой книге
		$subscr_post_txt="Новая книга в разделе ".$book_arr['catalog']."\n\n".$book_arr['author_name']." - ".$book_name."\n\n".$_REQUEST['link']."?partnerId=2235815";
		$subscr_theme='"books":"all"';
		include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/push_infoToSubcsribers.php');
		
		unset($book_arr);
	}
}