<?php
	include($_SERVER["DOCUMENT_ROOT"].'/modules/word_doc_generate/html_to_doc/html_to_doc.inc.php');
	
	$htmltodoc= new HTML_TO_DOC();
	
	
	$doc_content="
	
	
<div class=Section1>

<div style='mso-element:header' id=h1>

<p class=MsoHeader style='tab-stops:center 233.85pt right 729.0pt'><b
style='mso-bidi-font-weight:normal'><u><span style='font-size:9.0pt;font-family:
Verdana'>ООО</span></u></b><u><span style='font-size:9.0pt;font-family:Verdana'>
<b style='mso-bidi-font-weight:normal'>«Служба Деловой Разведки»</b> <span
style='mso-tab-count:1'>                </span><span
style='mso-spacerun:yes'> </span><span style='mso-tab-count:1'>                                                                  </span></span></u><a
href='http://www.egrul-base.ru/'><span style='font-size:9.0pt;font-family:Verdana'>http://www.</span><span
lang=EN-US style='font-size:9.0pt;font-family:Verdana;mso-ansi-language:EN-US'>egrul</span><span
style='font-size:9.0pt;font-family:Verdana'>-</span><span lang=EN-US
style='font-size:9.0pt;font-family:Verdana;mso-ansi-language:EN-US'>base</span><span
style='font-size:9.0pt;font-family:Verdana'>.ru/</span></a><u><span
style='font-size:9.0pt;font-family:Verdana'><o:p></o:p></span></u></p>

</div>

	
	
	
	<ul>
<li>ошибкой при наборе адреса страницы;
</li><li>переходом по неработающей ссылке;
</li><li>запрашиваемой страницы никогда не было на сайте или она была удалена.
</li></ul>
<br>
<p>Мы приносим свои извинения за доставленные неудобства и предлагаем следующие пути:
</p><ul>
<li>вернуться назад при помощи кнопки браузера back;
</li><li>проверить правильность написания адреса страницы;
</li><li>перейти на главную страницу сайта;
</li><li>воспользоваться картой сайта или поиском.
</li></ul>
<br>
<p>Если Вы уверены в правильности набранного адреса страницы, пожалуйста, сообщите нам об этом при помощи <a href='/?page=contact_form&menu=mainmenu' class='png js-window'>контактной формы</a> или <a href='mailto:$officialemail?subject=Не существует страницы'>электронной почты</a>






<div style='mso-element:footer' id=f1>

<p class=MsoFooter style='margin-right:-.5pt;tab-stops:center 414.0pt right 711.0pt'><span
class=MsoPageNumber><b style='mso-bidi-font-weight:normal'><span
style='font-size:9.0pt'>Аналитическая экспресс-справка №577 от 04.06.2010 г.<span
style='mso-tab-count:1'>                                                                                     </span>
<span style='mso-tab-count:1'>                                 </span>Страница <span
style='mso-field-code:' PAGE '><span style='mso-no-proof:yes'>6</span></span>
из <span style='mso-field-code:' NUMPAGES '><span style='mso-no-proof:yes'>15</span></span></span></b></span></p>

</div>
	";
	//$htmltodoc->createDoc($_SERVER["DOCUMENT_ROOT"].'/pages/404.php',$_SERVER["DOCUMENT_ROOT"].'/modules/word_doc_generate/html_to_doc/test.doc', true);
	//$htmltodoc->createDocFromURL("http://yahoo.com",$_SERVER["DOCUMENT_ROOT"].'/modules/word_doc_generate/html_to_doc/test.doc');
	$htmltodoc->createDocFromHTML($doc_content,'test.doc',true);
	

?>