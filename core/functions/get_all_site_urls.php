<?
/****************************************************************************************************************************
  * Snippet Name :	get_all_site_urls        																				*
  * Scripted By  :	RomanyukAlex		           																			*
  * Website      :	http://popwebstudio.ru	   																				*
  * Email        :	admin@popwebstudio.ru  					 														 	    *
  * License      :	License on popwebstudio.ru from autor		 															*
  * Purpose 	 :	Скачивает все ссылки с сайта																			*
  * Using		 :	$host='domain.com';																						*
  *				 	$scheme='https://';																						*
  *					$urls=array(); // Здесь будут храниться собранные ссылки												*
  *					$content=NULL; // Рабочая переменная																	*
  *					$nofollow=array('/logout/','/adminpanel/');// Здесь ссылки, которые не должны попасть в sitemap.xml		*
  *					// Первой ссылкой будет главная страница сайта, ставим ей 0, т.к. она ещё не проверена					*
  *					$urls[$scheme.$host]='0';																				*
  *					// Разрешённые расширения файлов																		*
  *  				$extensions[]='php';$extensions[]='aspx';$extensions[]='htm';$extensions[]='html';$extensions[]='asp';	*
  *					$extensions[]='cgi';$extensions[]='pl';																	*
  *					$only_on_the_page=NULL;//Собирать URL со всех страниц сайта. Если нужно только с текущей, то =1			*
  *					get_all_site_urls($scheme.$host,$host,$scheme,$nofollow,$extensions,$urls,$only_on_the_page);			*
  *					foreach($urls as $k => $v){echo $k;}																	*
  **************************************************************************************************************************/

function get_all_site_urls($page,&$host,&$scheme,&$nofollow,&$extensions,&$urls,$only_on_page=NULL)
	{
		global $log;
		$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
		//Возможно уже проверяли эту страницу
		if($urls[$page]==1){//echo '\n PAGE CHECKED';
			continue;
		}
		//Получаем содержимое ссылки. если недоступна, то заканчиваем работу функции и удаляем эту страницу из списка
		$content=file_get_contents($page);
		if(!$content){
			unset($urls[$page]);
			$log->LogError("URL can't be reach");
			return false;
		}
		//Отмечаем ссылку как проверенную (мы на ней побывали)
		$urls[$page]=1;
		//Проверяем не стоит ли запрещающий индексировать ссылки на этой странице мета-тег с nofollow|noindex|none
		if(preg_match('/<[Mm][Ee][Tt][Aa].*[Nn][Aa][Mm][Ee]=.?("|\'|).*[Rr][Oo][Bb][Oo][Tt][Ss].*?("|\'|).*?[Cc][Oo][Nn][Tt][Ee][Nn][Tt]=.*?("|\'|).*([Nn][Oo][Ff][Oo][Ll][Ll][Oo][Ww]|[Nn][Oo][Ii][Nn][Dd][Ee][Xx]|[Nn][Oo][Nn][Ee]).*?("|\'|).*>/',$content)){
			//echo "NO FOLLOW found";
			$content=NULL;}
		//Собираем все ссылки со страницы во временный массив, с помощью регулярного выражения.
		preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/",$content,$tmp);$content=NULL;
		//Добавляем в массив links все ссылки не имеющие аттрибут nofollow
		foreach($tmp[0] as $k => $v){if(!preg_match('/<.*[Rr][Ee][Ll]=.?("|\'|).*[Nn][Oo][Ff][Oo][Ll][Ll][Oo][Ww].*?("|\'|).*/',$v)){$links[$k]=$tmp[1][$k];}}
		
		unset($tmp);
		
		//Обрабатываем полученные ссылки, отбрасываем "плохие", а потом и с них собираем...
		for ($i = 0; $i < count($links); $i++)
		{	
			//Если слишком много ссылок в массиве, то пора прекращать нашу деятельность (читай спецификацию)
			if(count($urls)>49900){return false;}
			//Если не установлена схема и хост ссылки, то подставляем наш хост
			if(!strstr($links[$i],$scheme.$host)){$links[$i]=$scheme.$host.$links[$i];}
			//Убираем якори у ссылок
			$links[$i]=preg_replace("/#.*/X", "",$links[$i]);
			//Узнаём информацию о ссылке
			$urlinfo=@parse_url($links[$i]);if(!isset($urlinfo['path'])){$urlinfo['path']=NULL;}
			//print_r( $urlinfo );
			//Если хост совсем не наш, ссылка на главную, на почту или мы её уже обрабатывали - то заканчиваем работу с этой ссылкой
			if((isset($urlinfo['host']) AND $urlinfo['host']!=$host) OR isset($urls[$links[$i]]) OR strstr($links[$i],'@')){continue;}
			//Если ссылка в нашем запрещающем списке, то также прекращаем с ней работать
			$nofoll=0;if($nofollow!=NULL){foreach($nofollow as $of){if(strstr($links[$i],$of)){$nofoll=1;break;}}}if($nofoll==1){continue;}
			//Если задано расширение ссылки и оно не разрешёно, то ссылка не проходит
			$ext=end(explode('.',$urlinfo['path']));
			$noext=0;if($ext!='' AND strstr($urlinfo['path'],'.') AND count($extensions)!=0){$noext=1;foreach($extensions as $of){if($ext==$of){$noext=0;continue;}}}if($noext==1){continue;}
			//Заносим ссылку в массив и отмечаем непроверенной (с неё мы ещё не забирали другие ссылки)
			$urls[$links[$i]]=0;
			//Проверяем ссылки с этой страницы
			if($only_on_page==NULL) get_all_site_urls($links[$i],$host,$scheme,$nofollow,$extensions,$urls);
		}
		return true;
	}

?>
