<?  session_start();
@require($_SERVER["DOCUMENT_ROOT"]."/vzor/userlogin3.php");
@require($_SERVER["DOCUMENT_ROOT"]."/vzor/head.php"); 


?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>���Р� ����� ������ Π�������</TITLE>
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
<? //����������� ����� �������
$url = $_SERVER['REQUEST_URI']; 
$ordertype = explode("%", $url); 
// $ordertype[1] - ��� ��� ������� � ���� ������.
// 
// 2 - ������ ��� ������������������ 
// 3 - �����, ��������� �� ������ ������� �������
// 
// 5 - ��������� ����� �����������
// 6 - ������� ��������� ������ �� ������
// 7 - ��������� ������ �� ������ ������ ���������, AktivationLink �� ������� � ����
// 8 � 9 - ����� ������������ ������ � �����

if ($p==2)
	{//������ ��� ��������
	echo ("<center><p class='style12'>���� ������ �������. ������� �� ��������� �����. ��� ������� ������ ��� ��������� ������� ������.</p><br><a href='http://ovzor.ru/' class='style6'>�� ������� >></a></center>");
	}
elseif ($p==3)
	{//��� �����
	echo ("<p class='style12'>�� ����� ������, ������� ����� �����. � ��� ������� ����� �� �����..</p>");//�������� �� "��������" ����� �������� ���� ������� �����
	}
elseif ($ordertype[1]==5)
	{//��������� ����� �����
	?>
	<div align="left" style="position:absolute; top: 395;z-index:1">
	<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");?></div><?
	}
elseif ($ordertype[1]==1)
	{//��������� �������������� ������
	?>
	<div align="left" style="position:absolute; top: 395;z-index:1">
	<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-2.php"); ?></div><?	
	}
elseif ($p==1)
	{//������� �������� �������������� ������
	echo ("<p class='style12' align='center'>���� ������ �������. ������� �� ��������� �����. ����� ����� � ���� �������� ��� ��������.</p><br><a href='http://ovzor.ru/' class='style6'>�� ������� >></a></center>");
	}
elseif ($p==6)
	{//������������ ������ �� ������ � ������
	echo ("<center><p class='style12'>����������� ������� �������� ����.<br>�����������, ������ �� ������������ ������� ����.<br>
	<a href='http://ovzor.ru/' class='style6'>�� �������</a><br><a href='javascript:history.back()' class='style6'>�����</a></center>");
	}
elseif ($p==7)
	{//������������ ������ �� ������ � ������, �� ����� ������ ��� ��� � ���� (��� �� ����)
	echo ("<center><p class='style12'>��������, �� ��� ������������� ������ �������� ��� ������� ���� �������<br>�� ������ ����������� ��������� �����������<br>");
	require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");
	}
elseif ($p==8 or $p==9)
	{//����� ������������ ������ � �����
	echo("<p class='style12' align='center'>��������� ������ ���� �� �������:</p><center><b class='style6'>".$err."<br>�� ������ ����������� ��������� ��� ���:");
			if ($p==8)	{// ��� ���� ������������ ���� � ����� ������
						require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-2.php");
						}
			elseif($p==9){// ��� ���� ������������ ���� � ��������������� ��������
						require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");
						}
	}
else{//��� �������� ��� ordertype[1] ��� $p
	echo ("<p class='style12'>������������ ������ ����������. ������� �� �������� �� ����� ��������� ��������.</p>");
	exit;
	};
	
require($_SERVER["DOCUMENT_ROOT"]."/vzor/footer.php");?>
</body></html>