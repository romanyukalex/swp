<? #Собираем посетителей сайта в ВК ретаргет группу

if(!$bot_name){ //Пиксели не для ботов
?><script src="https://vk.com/js/api/openapi.js?144"></script> 
<script> 
	//Инициируем API
    VK.Retargeting.Init('VK-RTRG-188334-dwUSq');  //Посетители сайта
	//VK.Retargeting.Init('VK-RTRG-203638-1I8iL');  //Добавили товар в корзину
</script> 
<? 
	if($_SESSION['log']=='1'){ //Залогинился, вставляем пиксель списка залогированных
		
		?><script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-190046-cU50M';</script>
		<?//<script> VK.Retargeting.Add('25690278');</script> 

	}
	elseif($_REQUEST['page']=="swpshop" and $_REQUEST['action']=="show_product" and !$_SESSION['vk_looked_product']){ #Смотрит продукт, запихиваем в нуную очередь
	
		?><script>VK.Retargeting.Event('looked_product');</script><?
		$_SESSION['vk_looked_product']="Y";
	}
	elseif($_SESSION['return_entry']){ // Возвращенец, вставляем в список 'Вернувшиеся'
		?><script>VK.Retargeting.Event('returned_user');</script><?
		
		//<script>VK.Retargeting.Add('25663060');</script><?
//		<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-203634-8QwxY';</script><?
	} elseif($_SESSION['first_entry']==1) { //Впервые на портале
		#определяем раздел
		if($_REQUEST['page']=="book" or strstr($_REQUEST['page'],"book") or $_REQUEST['page']=="audio" or $_REQUEST['page']=="audios"){ //Впервые на сайте и смотрит книжку
			?><script>VK.Retargeting.Event('first_time_via_book'); </script><?
		} elseif ($_REQUEST['page']=="video" or $_REQUEST['page']=="videos"){  //Впервые на сайте и смотрит видосик
			?><script>VK.Retargeting.Event('first_time_via_video'); </script><?
		} else {//Впервые на сайте, скорее всего через статью
			?><script>VK.Retargeting.Event('first_time_via_article'); </script><?
		}
		
		
	}
	
	
	else{ //Просто посетитель, список 'Посетители сайта' 
		?>
	<script><?//VK.Retargeting.Add('25663060');?>
	
	VK.Retargeting.Event('returned_user'); </script>
	</script><?
	//<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-188334-dwUSq';</script>
	 }
	
	if($_SESSION['traffic_source']=="social"){ //Кликнули на пост в соцсети
		//<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-207743-2TyO';</script><?
		?><script> 
		//VK.Retargeting.Add('26024274'); //вроде тоже работает
		 VK.Retargeting.Event('clicked_post'); </script><?
		//unset($_SESSION['traffic_source']);
	}
	if($_REQUEST['page']=="psybooks_sex"){//Интересующиеся психол отношений
		?><script>VK.Retargeting.Event('relation'); </script><?
	} elseif($_REQUEST['page']=="psybooks_business"){
		?><script>VK.Retargeting.Event('business_books'); </script><?
	} elseif($_REQUEST['page']=="book"){//Открыли книжку
		?><script>VK.Retargeting.Event('psybook_reader'); </script><?
	} elseif($_REQUEST['page']=="psybooks_training"){//Коуч или тренер читает книжку
		?><script>VK.Retargeting.Event('trainer'); </script><?
	} elseif($_REQUEST['page']=="swpshop" and $_REQUEST['action']=="show_product"){//Смотрит продукт на сайте
		
		?><script>VK.Retargeting.Event('show_product_<?=$_REQUEST['productid']?>'); </script><?
	}
	
}?>
