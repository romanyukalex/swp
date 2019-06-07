<?php
 /****************************************************************
  * Snippet Name : weather form Gismeteo       					 * 
  * Scripted By  : WIRTEL*(:)* 2008	           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : weather										 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
// Исправь папку сайта в классе!!!!!!!!!!!!!
@require"Weather.php";
$w = new Weather; //Включаем класс
$w->ConnectCache('27532_1.xml'); //Собираем информацию и КЕШруем её, ID города можно узнать по адрему http://informer.gismeteo.ru/xml.html?index=27612
//$w->Connect('27532_1.xml'); 
echo $w->city;
echo $w->weather;

// Можно вывести несколько городов :
/*$w->ConnectCache('26063_1.xml'); //Чтобы установить время в течение которого скрипт будет обновляться и КЕШировать данные, можно изменив $w->ConnectCache('26063_1.xml'); на $w->ConnectCache('26063_1.xml','3600'); в таком случаи скрипт будет обновлять данные ежечасно
echo $w->city;
echo $w->weather;
*/
/*
Тоже самое только уже без КЕШирования, что использовать не эфективно
$w->Connect('28367_1.xml'); 
echo $w->city;
echo $w->weather;

$w->Connect('26063_1.xml'); 
echo $w->city;
echo $w->weather;

$w->Connect('28225_1.xml'); 
echo $w->city;
echo $w->weather;
*/
<? }?>