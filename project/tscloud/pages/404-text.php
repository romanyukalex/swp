<? 
/*****************************************************************************************************************************
  * Snippet Name : 404-text																									 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Текст в основном теле страницы в случае 404										 						 *
  * Insert		 : include_once('404-text.php');																			 *
  ***************************************************************************************************************************/ 
//@require_once($_SERVER["DOCUMENT_ROOT"]."/core/siteconfig.php");
@include_once($_SERVER["DOCUMENT_ROOT"]."/core/system-param.php");
insert_module("bookmark");?>
<div><span style="color:#FF6600; font-size:72px">404</span>
Извините, страница не найдена<br>
<table>
<tr><td><a href="/"><img src="/pics/blue-home.png" border="0" style="vertical-align:middle;">На главную</a></td></tr>
<tr><td><a href='javascript:history.back()'><img src="/pics/blue-back.png"  border="0"  style="vertical-align:middle;">На предыдущую страницу</a></td></tr>
<tr><td><a href="#"><img src="/pics/blue-refresh.png" border="0" style="vertical-align:middle;">Обновить страницу</a></td></tr>
<tr><td><a href="/" onClick="return BookmarkApp.addBookmark(this)"> <img src="/pics/blue-star.png" border=0 alt="В закладки" style="vertical-align:middle;">В закладки</a></td></tr>
<tr><td><a href="mailto:<?=$officialemail?>?subject=Не существует страницы"><img src="/pics/blue-mail.png" border="0" style="vertical-align:middle;">Отправить сообщение администратору</a></td></tr>
<tr><td><a href="/"><img src="/pics/blue-search.png" border="0" style="vertical-align:middle;">Искать на сайте</a></td></tr>
<tr><td><a href="javascript:self.close()"><img src="/pics/blue-X.png" border="0" style="vertical-align:middle;">Закрыть страницу</a></td></tr>
</table>
</div>