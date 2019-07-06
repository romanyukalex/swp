<? #Собираем посетителей сайта в FB ретаргет группу

if(!$bot_name){ //Пиксели не для ботов
	if($_SESSION['log']=='1'){ //Залогинился, вставляем пиксель списка залогированных
		?>fbq('track', 'RegisteredUser');<?
	}
	elseif($_SESSION['return_entry']){ // Возвращенец, вставляем в список 'Вернувшиеся'
		?>fbq('track', 'ReturnedSiteViewer');<?
	}
}?>