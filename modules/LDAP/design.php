<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : include this script, insert_module("modulename")	*
  ******************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){

/*
    Пример работы с каталогом LDAP из php (мой hello world).
    Представление "Пользователи разбиты на группы". Пример не претендует на
    универсальность, подразумевается, что записи групп построены на объектном
    классе posixGroup, атрибут членства memberUid совпадает с uid записи
    пользователя (как при связке с samba). Представление древовидной структуры
    выполнено с помощью компонента dhtmlxTree библиотеки dhtmlxSuite
    (см. http://docs.dhtmlx.com/doku.php?id=dhtmlxtree:toc)
*/

##################################################################################
# Параметры подключения к LDAP-каталогу
##################################################################################
$LDAP = array(
    'server' => '127.0.0.1',
    'port' => '389',
    'bindDN' => NULL, // анонимное подключение,
		      // в этом параметре можно указать DN подключения
    'bindPW' => NULL, // анонимное подключение,
		      // в этом параметре можно указать пароль для DN подключения
    'groupsDN' => 'ou=Groups,dc=mycompany,dc=ru',
    'usersDN' => 'ou=Users,dc=mycompany,dc=ru'
    );

##################################################################################
# Работа с LDAP-сервером: подключение/отключение
##################################################################################
// Подключаемся к серверу
$conn = ldap_connect($LDAP['server'], $LDAP['port'])
    or die('Не могу подключиться к LDAP-серверу: ' . $LDAP['server'] . ', порт ' . $LDAP['port']);
// Устанавливаем версию протокола (странно, но по умолчанию не 3-я версия)
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Подсоединение
if(isset($LDAP['bindDN'])) // с аутентификацией
{
    ldap_bind($conn, $LDAP['bindDN'], $LDAP['bindPW'])
	or die('Не могу подсоединиться к LDAP-серверу');
}
else // анонимное
{
    ldap_bind($conn)
	or die('Не могу подсоединиться к LDAP-серверу');
}

// Определимся, что будем делать
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';
switch ($action)
{
    case 'main': get_main(); break;
    case 'userinfo': get_user_info(); break;
    default: die('Определите корректный параметр action'); break;
}

// Когда всё сделано отключаемся от сервера
ldap_close($conn);

##################################################################################
# Функция построения страницы и вывода списка групп с пользователями
##################################################################################
function get_main()
{
    global $LDAP, $conn;
    
    // Выполним запрос на получение групп с объектным классом posixGroup,
    // возвращающий атрибут memberUid
    $search = ldap_search($conn, $LDAP['groupsDN'], '(objectClass=posixGroup)', array('memberUid'))
	or die('Запрос ничего не вернул, DN ветки группы: ' . $LDAP['groupsDN']);
    // Получим результат запроса в массив
    $entries = ldap_get_entries($conn, $search);
    // Массив довольно интересен, с претензией на всеобъемлемость,
    // что затрудняет работу с ним. Содержимое массива 
    // можно посмотреть с помощью функции print_r()
    
    // Отсортируем по алфавиту список групп и список членов к каждой группе
    // пример работы с массивом, возвращаемым функцией ldap_get_entries()
    $entries_sorted = array();
    // Цикл по группам из массива
    for($i = 0; $i < $entries['count']; $i++)
    {
	$members = array();
	// Получение атрибутов memberUid для текущей группы из массива
	if(isset($entries[$i]['memberuid']))
	{
	    for($j = 0; $j < $entries[$i]['memberuid']['count']; $j++)
		array_push($members, $entries[$i]['memberuid'][$j]);
	    sort($members);
	}
	else $members = NULL;
	$entries_sorted[$entries[$i]['dn']]=$members;
    }
    asort($entries_sorted);
    
    // Вывод страницы
    header('Content-type: text/html; charset=UTF-8');
?>
<html><head><title>Просмотр групп LDAP</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="STYLESHEET" type="text/css" href="./dhx/dhtmlxtree.css">
<script  src="./dhx/dhtmlxcommon.js"></script>
<script  src="./dhx/dhtmlxtree.js"></script>
<script  src="./dhx/dhtmlxtree_start.js"></script>
<script>dhtmlx.skin = "dhx_skyblue";
window.onload = function ()
{
    // Инициируем дерево
    LDAPTree = dhtmlXTreeFromHTML('LDAPTree');
    // Обработка события onClick
    LDAPTree.attachEvent('onClick', function(id)
    {
	if(/,/.test(id)) document.getElementById('userInfo').innerHTML = 'Группа ' + id;
	else if(/[$](_|$)/.test(id)) document.getElementById('userInfo').innerHTML = 'Samba Trust Account ' + LDAPTree.getItemText(id);
	else // ajax-запрос сведений о пользователе
	{
	    var A = dhtmlxAjax.getSync('index.php?action=userinfo&user='+LDAPTree.getItemText(id));
	    var res = A.xmlDoc.status==200 ? A.xmlDoc.responseText : 'Er: BadRequest, status '+ A.xmlDoc.status;
	    if(/^Er/.test(res)) alert(res); else document.getElementById('userInfo').innerHTML = res;
	}
    });
}
</script>
<style>
h1 {font-family:Tahoma; font-size:16pt}
#LDAPTree {width:400px; height:400px; border:1px solid Silver}
#userInfo {width:400px; height:400px; border:1px solid Silver; font-family:Tahoma;font-size:11px}
#userInfo td{font-family:Tahoma; font-size:11px; vertical-align:top}
</style>
</head><body><h1>Группы в <?php echo $LDAP['groupsDN']; ?></h1>
<table><tr><td><div id="LDAPTree" setImagePath="./dhx/imgs/csh_bluefolders/">
<?
    // Вывод списка групп и их членов в формате xml, который поддерживает
    // dhtmlxTree (см .http://docs.dhtmlx.com/doku.php?id=dhtmlxtree:syntax_templates)
    if(count($entries_sorted))
    {
	echo '<xmp>';
	foreach($entries_sorted as $groupDN=>$members)
	{
	    echo '<item id="' . $groupDN . '" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif" text="' .
		preg_replace('/,' . $LDAP['groupsDN'] . '/', '', $groupDN) . '">';

	    if(is_array($members))
		echo join('', array_map(
		function($member)
		{
		    return '<item id="' . $member . '" text="' . $member . '"' .
			(preg_match('/[$]$/',$member) ? ' im0="computer.gif"' : '') . ' />';
		}, $members));

	    echo '</item>';
	}
	echo '</xmp>';
    }
    else
    {
	echo 'Групп нет';
    }
?>
</div></td><td><div id="userInfo"></div></td></tr><table></body></html>
<?

##################################################################################
# Функция получения информации о пользователе
##################################################################################
function get_user_info()
{
    global $LDAP, $conn;
    
    // Обязательный параметр user
    $user = $_REQUEST['user'];
    if(empty($user)) die('Задайте параметр user');
    
    // Список нужных нам атрибутов 'Имя_атрибута' => 'Смысловое_описание'
    $LDAP['Attrs'] = array(
	'uid'=>'Login',
	'cn'=>'Имя',
	'uidnumber'=>'uid',
	'gidnumber'=>'gid',
	'telephonenumber'=>'Телефон',
	'mail'=>'Эл. почта');
    
    // Выполняем запрос, возвращающий заданные нами атрибуты
    $search = ldap_search($conn, $LDAP['usersDN'], '(uid=' . $user . ')', array_keys($LDAP['Attrs']))
	or die('Запрос ничего не вернул, user: ' . $user);
    // Получаем результаты запроса в массив
    $entries = ldap_get_entries($conn, $search);
    
    // Вывод заголовка
    header('Content-type: text/plain; charset:UTF-8');

    // Кому интересно посмотреть содержимое массива, раскомментируйте строку ниже
#    echo '<pre>'; print_r($entries); echo '</pre>';
    
    // Вывод таблицы с запрашиваемыми данными
    echo '<table>';
    foreach($LDAP['Attrs'] as $attr=>$desc)
    {
	echo '<tr><td>' . $desc . '</td><td>';
	if(isset($entries[0][$attr]))
	{
	    array_shift($entries[0][$attr]);
	    echo join('<br>', $entries[0][$attr]);
	}
	echo '</td></tr>';
    }
    echo '</table>';
}
}?>