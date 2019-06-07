<?  session_start();
@require($_SERVER["DOCUMENT_ROOT"]."/vzor/userlogin3.php");
@require($_SERVER["DOCUMENT_ROOT"]."/vzor/head.php"); 


?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>ВЗОР — Видео Забота О Ребенке</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1251">
<LINK href="vzorcam.css" type=text/css rel=stylesheet>
<?	
if ($browser!=='ie')
	{echo ('
	<script language="JavaScript" type="text/javascript">
	//podskazka
	var ns=(document.layers)
	var ie=(document.all)
	if (ns){document.captureEvents(Event.MOUSEMOVE)}
	document.onmousemove = mouseMove
	function mouseMove(el) {
	if (ns) {x=el.pageX; y=el.pageY;TheLength=document.layers.length}
	if (ie) {x=event.x; y=event.y;TheLength=document.all.length}	
	for (i=1; i<TheLength; i++) {
	if (ns) {whichEl = document.layers[i];var whichMove=whichEl}
	if (ie) {whichEl = document.all[i];whichMove=document.all[i].style}
	if (whichEl.id.indexOf("child")!= -1) {whichMove.left=x+5
		whichMove.top=y+3} } }
	function sign(el,c) 
{if(ns){document.layers["child"+c].visibility="show";}else{document.all["child"+c].style.visibility="visible";} document.onmousemove = mouseMove}
function hide(c)
{if(ns){document.layers["child"+c].visibility="hide";}else{document.all["child"+c].style.visibility="hidden";}
	if (ns){releaseEvents(Event.MOUSEMOVE)}
	document.onmousemove=""}
	</script>');
	}; ?>
<SCRIPT src="ROWHIGHLIGHT.js"></SCRIPT>
<script src="MovingMenu.js"></script>

</head>
<body bgcolor="#000000">
<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/bodyhead.php");?>
<? //Определение ветки запроса
$url = $_SERVER['REQUEST_URI']; 
$ordertype = explode("%", $url); 
// $ordertype[1] - это тип запроса в этот скрипт.
// 
// 2 - Только что зарегистрировались 
// 3 - Хакер, индикация из любого другого скрипта
// 
// 5 - Оформляют новую регистрацию
// 6 - Успешая активация ссылки из письма
// 7 - Активация ссылки из письма прошла неуспешно, AktivationLink не нашелся в базе
// 8 и 9 - Ввели неправильные данные в форме

if ($p==2)
	{//Только что оформили
	echo ("<center><p class='style12'>Ваши данные приняты. Спасибо за уделенное время. Вам выслано письмо для активации учетной записи.</p><br><a href='http://ovzor.ru/' class='style6'>На главную >></a></center>");
	}
elseif ($p==3)
	{//Это хакер
	echo ("<p class='style12'>Не ломай сервер, христом богом прошу. И без взломов жизнь не легка..</p>");//Заменить на "идинахуй" после проверки всех функций сайта
	}
elseif ($ordertype[1]==5)
	{//Оформляют новый заказ
	?>
	<div align="left" style="position:absolute; top: 395;z-index:1">
	<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");?></div><?
	}
elseif ($ordertype[1]==1)
	{//Оформляют индивидуальную заявку
	?>
	<div align="left" style="position:absolute; top: 395;z-index:1">
	<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-2.php"); ?></div><?	
	}
elseif ($p==1)
	{//Успешно оформили индивидуальную заявку
	echo ("<p class='style12' align='center'>Ваши данные приняты. Спасибо за уделенное время. Очень скоро с Вами свяжется наш менеджер.</p><br><a href='http://ovzor.ru/' class='style6'>На главную >></a></center>");
	}
elseif ($p==6)
	{//Активировали акаунт по ссылке в письме
	echo ("<center><p class='style12'>Регистрация успешно пройдена Вами.<br>Поздравляем, теперь Вы пользователь системы ВЗОР.<br>
	<a href='http://ovzor.ru/' class='style6'>На главную</a><br><a href='javascript:history.back()' class='style6'>Назад</a></center>");
	}
elseif ($p==7)
	{//Активировали акаунт по ссылке в письме, но такой ссылки уже нет в базе (или не было)
	echo ("<center><p class='style12'>Извините, но эта активационная ссылка устарела или введена Вами неверно<br>Вы можете попробовать повторить регистрацию<br>");
	require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");
	}
elseif ($p==8 or $p==9)
	{//Ввели неправильные данные в форме
	echo("<p class='style12' align='center'>Введенные данные пока не приняты:</p><center><b class='style6'>".$err."<br>Вы можете попробовать заполнить ещё раз:");
			if ($p==8)	{// Это были неправильные поля в индив заявке
						require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-2.php");
						}
			elseif($p==9){// Это были неправильные поля в регистрационной карточке
						require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");
						}
	}
else{//нет сценария без ordertype[1] или $p
	echo ("<p class='style12'>Неправильная строка параметров. Просьба не заходить за рамки сценариев страницы.</p>");
	exit;
	};
	
require($_SERVER["DOCUMENT_ROOT"]."/vzor/footer.php");?>
</body></html>