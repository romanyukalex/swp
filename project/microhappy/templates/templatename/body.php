<? /******************************************************************
  * Snippet Name : body           				 					 * 
  * Scripted By  : RomanyukAlex		           						 * 
  * Website      : http://popwebstudio.ru	   						 * 
  * Email        : admin@popwebstudio.ru     					     * 
  * License      : License on popwebstudio.ru	from autor		 	 *
  * Purpose 	 : Тело страницы обрамленное тегами <body></body>	 *
  * Insert		 : include_once('/templates/$currenttemplate/body.php');						 *
  *******************************************************************/ 
/* Как писать Body:
1. Открываем и закрываем </head><body></body>, между ними вся страничка.
2. В DIV, в котором надо открывать страничку, пишем include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); 
3. Если надо, чтобы ссылка показывала в нужном div#content какую то страницу, то пишем ей onClick="changerazdel('pagename');return false;" или класс (будет сделано). На странице д.б. блок <div id="content1"></div>
4. Если надо использовать какой-нибудь сторонний класс, то кидаем его в папку "/core/functions/". Название файла должно совпадать с названием класса, тогда класс сам подцепится
5. Если надо кроссбр-но вставить "Добавить в избранное" <a href="javascript:void(0)" onClick="return BookmarkApp.addBookmark(this)">bookmarkIt</a>
6. Подключить любой модуль - include($_SERVER["DOCUMENT_ROOT"]."/modules/modulename/design.php");
   Например, кнопка google+1 - include($_SERVER["DOCUMENT_ROOT"]."/modules/google_plusone/design.php");
   Или так - insert_module("modulename");
7. Если нужно выводить название страницы на странице то обозначаем место так - id="titleonpage"

Доступные переменные:
$page - страница в гет "&page="
$_SESSION['changepassmust']=="yes" - юзер должен поменять пароль
*/
###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
?>
</head><? 
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################?>
<body>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>



<?
#####################################
# // Body							#
#####################################
?></body><?
#####################################
# Required 2						#
#####################################
	}
	else{?><body><?
		insert_module("loginform_simple");
		?></body><?
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>