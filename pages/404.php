<? 
/*****************************************************************************************************************************
  * Snippet Name : 404 page																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Текст в основном теле страницы в случае 404										 						 *
  * Insert		 : include_once('404-text.php');																			 *
  ***************************************************************************************************************************/ 

@include_once($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
insert_module("bookmark");?>

<div  class="row flex-items-sm-center" style="background:#FFF;margin-top:0px">
	
	<div class="col-md-2 flex-items-sm-center">
    
      <img src="/adminpanel/pics/Diamond256.png" class="mainAOAimg imgmiddle"><span style="color:#B71A1A; font-size:72px; font-weight:bold">404</span>
    
  </div>

<div class="col-md-5" id="AOAtxt">
  
  
  Здравствуйте, уважаемый посетитель.
  <p>К сожалению, запрашиваемой Вами страницы не существует на этом сайте: <?=$_SERVER['HTTP_QUERY']?><br></p>
  <p>Возможно, это обусловлено одной из причин:</p>
  <ul>
  <li>ошибкой при наборе адреса страницы
  </li><li>переходом по неработающей ссылке
  </li><li>запрашиваемой страницы никогда не было на сайте
  </li><li>страница была удалена
  </li></ul>
  <br>
  <p>Мы приносим свои извинения за доставленные неудобства и предлагаем следующие пути решения проблемы:
  </p>
  
</div>

<div class="col-md-5">
<? #Ближайшая по написанию страница
	include_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/process_user_data.php');
	$page_wr=process_data($_REQUEST['page'],20);
	$page_near_q=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE 
  `page` LIKE '%$page_wr%' or `page` LIKE '%".mb_substr($page_wr,0,-1)."%' or `page` LIKE '%".mb_substr($page_wr,1)."%'
  LIMIT 0,1;"));
	if($page_near_q['page'] and $page_near_q['page']!==$page){
		?><a href="/?page=<?=$page_near_q['page']?>"><img src="/adminpanel/pics/Colorpencils512.png" class="imgmiddle AOAimg">Посмотреть найденую нами ПОХОЖУЮ страницу: <?=$page_near_q['pagetitle_'.$language]?></a><br><?
	}

?>
<a href="/"><img src="/adminpanel/pics/Arrow-turn-left256.png" class="imgmiddle AOAimg">Вернуться назад</a><br>
<a href="/"><img src="/adminpanel/pics/rename256.png" class="imgmiddle AOAimg">Проверить правильность написания адреса страницы</a><br>
<a href="/"><img src="/adminpanel/pics/home256.png" class="imgmiddle AOAimg">Перейти на главную страницу сайта</a><br>
<a href="mailto:<?=$officialemail?>?subject=Не существует страницы <?=$page?>"><img src="/adminpanel/pics/skills256.png" class="imgmiddle AOAimg">Отправить сообщение администратору по Email</a><br>
<?  if($moduleenabled['search_engine'] or $moduleenabled['search_morph']){?>
<a href="/?page=search_engine_page"><img src="/adminpanel/pics/status256.png" class="imgmiddle AOAimg">Воспользоваться поиском</a><br>
<? }
 if($moduleenabled['all_pages_link']){?>
<a href="/?page=Becb_cauT"><img src="/adminpanel/pics/checklist256.png" class="imgmiddle AOAimg">Просмотреть все доступные страницы</a><br><? }?>
<a href="javascript:self.close()"><img src="/adminpanel/pics/red-cross.png" class="imgmiddle AOAimg">Закрыть страницу</a><br>
</div>
</div>