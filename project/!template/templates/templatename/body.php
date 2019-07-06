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
3. Если надо, чтобы ссылка показывала в нужном div#content какую то страницу, то пишем ей onClick="changerazdel('pagename');return false;".
4. Если надо использовать какой-нибудь сторонний класс, то кидаем его в папку "/core/functions/". Название файла должно совпадать с названием класса, тогда класс сам подцепится
5. Подключить любой модуль - include($_SERVER["DOCUMENT_ROOT"]."/modules/modulename/design.php");
   Например, кнопка google+1 - include($_SERVER["DOCUMENT_ROOT"]."/modules/google_plusone/design.php");
   Или так - insert_module("modulename");
6. Подключаем функцию - insert_function("functionname") из /core/functions
7. Если нужно выводить название страницы на странице то обозначаем место так - id="titleonpage"
8. Если в папке /project/$projectname/pages/ есть файл 404.php, то при отсутствии искомой страницы будет показана именно она. Если такого файла нет, то будет показана стандартная страница /pages/404.php
9. В папке /project/$projectname/modules_data располагаются кастомизированные скрипты. 
Если в этой папке лежит файл $modulename.design.php, то при вызове модуля будет вызываться именно этот файл. 
Если в этой папке лежит файл $modulename.config.php, то при вызове модуля будет использоваться именно этот конфиг модуля.


Доступные переменные:
$page - страница в гет "&page="
$_SESSION['changepassmust']=="yes" - юзер должен поменять пароль
$_SESSION['prev_page'] - предыдущая страница в случае, если был внутренний переход
*/
###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo('Got '.(__FILE__));
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################?>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################
?>



<?
#####################################
# // Body							#
#####################################

#####################################
# Required 2						#
#####################################
	}
	else{
		insert_module("loginform_simple");
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>