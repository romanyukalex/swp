<? if($nitka and $install_swp==1){
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<script type="text/javascript" src="/js/platformscripts.js"></script>
</head>
<body>
<?
require_once($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname."/config.php"); // Берем конфиг
require_once($_SERVER['DOCUMENT_ROOT']."/core/install-create_tables.php"); // Структура БД и данные по-умолчанию

$install_errcount=0;

require_once($_SERVER['DOCUMENT_ROOT']."/core/install_structures_into_db.php");
# Инсталляция модулей платформы
##### Сделать ########

if($install_errcount==0){# Успешная установка
	?><img src="/files/Shoe512_yellow.png">
	Платформа успешно установлена<?
	
	# Исправляем флаг install_swp в config.php
	$line="1"; # номер строки, которую нужно изменить
	$replace="$"."install_swp=0; // Push install script for DB. Set 0 after complete installation!\r\n"; # на что нужно изменить

	$file=file($_SERVER['DOCUMENT_ROOT']."/project/".$projectname."/config.php");
	$open=fopen($_SERVER['DOCUMENT_ROOT']."/project/".$projectname."/config.php","w");

	   for($i=0;$i<count($file);$i++){
			if(strstr($file[$i],"install_swp")){
				fwrite($open,$replace);
				}
			else{
				fwrite($open,$file[$i]);
			}
	   }
	fclose($open);
	# Внести в кронтаб настройку cron (доделать)
} else {
	?><img src="/files/shoes/Shoe512_red.png">
	Во время установки платформы возникли ошибки<?
}
?>
 </body></html>
 <?}?>