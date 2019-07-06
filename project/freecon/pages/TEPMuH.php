<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
		$word=process_data($_GET['word'],100);
		
		#Ищем слово в БД
		
		#Ищем файлы с определением
		
		#Для каждого найденного файла, читаем его в переменную
	
		$page_html=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/termins/'.$page);

		#Ищем название словаря и сслыку на словарь
		
		#Добавляем определение к общему выводу страницы $page_html

		/*
		#(Ищем ключевички в самом слове, чтобы было интересно читать и заменяем)
		insert_function("string_replace_nth");
		$pageTags=explode(";",$pagequery['tags']);
		foreach ($pageTags as $tag){
			$link_htmlCode="<a href='/?page=CTATbu&search_string=".$tag."' class='justlink'>".$tag."</a>";
			$page_html=string_replace_nth(" $tag ", "$link_htmlCode", $page_html, 1);
			
		}
		*/
		#Выводим страницу?>
		<div class="row  flex-items-md-center">
		<?=$page_html;?></div>
		<div class="row  flex-items-md-center">
<?	/*	
	#Выведем кружочки с тегами
		foreach ($pageTags as $tag){
			?><a href="/?page=CTATbu&search_string=<?=$tag?>" class="tag_circle justlink"><?=$tag?></a><?
		}?>
		</div><?
	*/
}//nitka?>