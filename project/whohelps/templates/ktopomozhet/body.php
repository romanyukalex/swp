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
3. Если надо, чтобы ссылка показывала в нужном div#content какую то страницу, то пишем ей onClick="changerazdel('pagename');return false;" или класс (будет сделано). На странице д.б. блок <div id="content1"></div>. Часто оборачиваем в div id="content" вокруг pagemanage
4. Если надо использовать какой-нибудь сторонний класс, то кидаем его в папку "/core/functions/". Название файла должно совпадать с названием класса, тогда класс сам подцепится
5. Если надо кроссбр-но вставить "Добавить в избранное" <a href="javascript:void(0)" onClick="return BookmarkApp.addBookmark(this)">bookmarkIt</a>
6. Подключить любой модуль - include($_SERVER["DOCUMENT_ROOT"]."/modules/modulename/design.php");
   Например, кнопка google+1 - include($_SERVER["DOCUMENT_ROOT"]."/modules/google_plusone/design.php");
   Или так - insert_module("modulename");
7. Подключаем фукнцию - insert_function("functionname") из /core/functions
8. Если нужно выводить название страницы на странице то обозначаем место так - id="titleonpage"

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
//insert_module("loginform_simple");

$data="4:15
Прошу, поприветствуем профессора
4:19
Дэниела Канемана. Это удовольствие и честь оказаться здесь
4:27
в качестве профессора фонда Хичкока, это также довольно
4:31
трогательный случай, поскольку
4:34
это место я посетил первым, оказавшись на территории университета
4:38
49 лет назад, практически день в день,
4:42
когда я приступил к моей выпускной работе
4:45
здесь, в Калифорнийском университете. Так что,
4:49
приятно находиться здесь
4:52
при других обстоятельствах. Но тема, о которой я буду говорить сегодня,
4:56
одна из тех, над которой я работал много лет,
5:01
и позвольте мне начать с того, что я всегда использовал науку в качестве разговора,
5:05
который может быть более или менее дружелюбным, когда друзья пытаются понять
5:10
обсуждаемые вещи,
5:11
или менее дружелюбным, переходящим в спор, некоторые из них становились
5:15
даже неприятными. По счастливому стечению обстоятельств, я поучаствовал 
5:19
в довольно большом количестве дебатов.
5:20
Большинство из них были вполне культурными. Большая часть моей карьеры посвящена участию 
5:25
в обоих видах споров. И тот, и другой, 
5:30
были вполне цивилизованными. Оба начались много лет назад, когда Амос Тверски и я
5:36
приступили к исследованию систематических ошибок суждения и это был 1969 год.
5:41
Этот Амос Тверски, он умер в 1996 году.
5:48
Первый спор,
5:52
который мы вели с экономистами, возник потому, что
5:55
другое возможное применение того, что мы изучали в систематических ошибках
6:00
и предубеждению по отношению к принятию решений и суждениям
6:02
ведут к тому, что эти ошибки и предубеждения могут иметь
6:05
дополнительные модели рационального поведения субъекта. Также был второй спор,
6:11
который мы вели с психологами.
6:15
Многие психологи осуждают акцент на заинтересованности
6:18
и заявляют, что созданное нами представление о человеческом мыслительном процессе
6:22
искажает действительность и характеризует его
6:25
куда более пессимистично и негативно, чем это есть на самом деле.
6:31
В частности, сюда относится спор 
6:36
о качестве интуиции специалиста. Сейчас эта тема широко обсуждается
6:41
и один из лучших бестселлеров прошлого года, “Озарение” Малькома Гладуэлла,
6:45
посвящен изучению или
6:48
описанию некоторых изумительных последствий
6:52
интуиции специалиста и в течении нескольких лет
6:55
использовался в некоторых
6:58
чудесных противоречивых сотрудничествах с кем-то.
7:02
Сейчас я намереваюсь перейти к Гэри Кляйну, который 
7:06
отталкивается от другой позиции. Он заявляет, 
7:10
что мы, как правило, должны доверять интуиции специалистов.
7:13
и мы всегда, вы знаете, я всегда заявлял, что мы должны быть достаточно осторожны,
7:17
полагаясь на интуицию специалиста.
7:19
И мы совместно пытались 
7:22
выяснить ту границу, когда мы можем доверять интуиции специалиста
7:26
и когда должны ей доверять. И позвольте начать мне с пары
7:30
наиболее прекрасных примеров, приведённых Гэри Кляйном. Один из них
7:35
является довольно убедительным и утверждает, что большое влияние на Линкольна оказывали мыслительный процесс 
7:39
и его карьера. 
7:41
Этот пример иллюстрирует капитана пожарной бригады,
7:44
пожарной станции и он здесь,
7:48
на крыше. Он наблюдает языки пламени, однако, не совсем понимает, какая именно ситуация сложилось,
7:54
а внизу несколько пожарников внезапно слышат, 
7:58
как он кричит: “Выметайтесь оттуда!!”
8:02
Они делают это и им едва хватает времени на то, чтобы 
8:05
убраться вон из-под крыши, и через несколько мгновений дом взрывается.
8:09
И когда он пытается понять, что именно с ним случилось,
8:14
он понял, что был определённый признак и он заключался в том, что его ноги нагревались. 
8:19
Он чувствовал тепло под ногами и был сделан вывод, что это действительно 
8:24
неосознанное умозаключение.
8:26
Раз его ноги чувствуют тепло, значит, прямо под ним огонь
8:30
и это, как я называю, 
8:34
экстремально опасная ситуация. Что ж, именно это и есть
8:37
интуиция специалиста. Есть также другой пример,
8:42
который
15.11.15	
я нахожу довольно-таки интересным, и в нём
8:45
проиллюстрирован случай с медсестрой кардиологического отдела,
8:49
которая только вернулась домой,
8:52
там ждёт её свёкр, она бросает на него только один взгляд
8:56
и говорит: “Мы должны ехать в больницу прямо сейчас!”
8:59
и он ей отвечает: “Зачем? Я чувствую себя хорошо”. Она повторяет: “Мы должны ехать в больницу”
9:04
и они едут и успевают прямо к тому времени,
9:07
когда вот-вот должен был случиться обширный инфаркт.
9:11
И здесь, фактически, опять
9:14
вышло таким образом, что она не знала, что именно её обеспокоило,
9:19
и потребовалось обследование, чтобы обнаружить,
9:22
что признак был. Выяснилось, что перед сердечным приступом,
9:26
когда затрудняется проходимость в артериях,
9:29
есть изменения в особенности распределения притока крови к лицу,
9:34
и она заметила эту особенность, не осознавая этого.
9:37
Сейчас вы можете сказать, что раз эти эксперты смогли сделать это, то этому можно
9:42
научиться.
9:44
Что ж, эти истории, существует сотни их,
9:47
заставляют вас поверить в силу человеческой интуиции.";
$data_lines=explode("
",$data);
function isEven($value) {return ($value%2 == 0);}
foreach($data_lines as $num=>$data_line){
	
	if(isEven($num)) $timing[]=$data_line;
	else $string_data[]=$data_line;
	
}
foreach ($timing as $num=>$time){
	$zero_q=explode(":",$time);
	if ($zero_q[0]<10){$start_time="0".$time;} 
	else {$start_time=$time;}
	echo ($num+1)."<br>
	00:".$start_time.",000 --> 00:".$timing[$num+1].",000<br>".$string_data[$num]."<br><br>";
}
//var_dump($timing);

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