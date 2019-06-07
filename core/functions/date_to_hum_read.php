<?php
 /***************************************************************************
  * Snippet Name : date_to_hum_read		           			 				* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : будет примерно следующее: 					 			*
  *				Добавлено: Сегодня в 13.02 или Вчера в 18.00,				*
  *					ну а если не вчера и не сегодня, будет 		 			*
  *					выведен день недели, или просто красивая дата			*
  * Access		 : $data = '1366193071';echo date_to_hum_read($data);		*
  **************************************************************************/
function date_to_hum_read($time){
	//Сегодня
	if(intval(date("d", $time)) == intval(date("d", time())
	))
	// Если числа одинаковые
	{
	$time_text="Сегодня в ".date("H:i", $time); return $time_text;
	}
	//Вчера
	if( (intval(date("d", time())) - intval(date("d", $time))) == 1)
	// Если текущее число, минус заданное, равно одному, значит вчера
	{
	$time_text = "Вчера в ".date("H:i", $time); return $time_text;
	}
	//На этой неделе
	if( (time() -$time) < 604800)
	//604800 - это количество секунд в неделе. если и не вчера и не сегодня, то проверяем, произошло ли заданное событие в течение последних семи дней. если да, то выводим время с днем недели
	{
	$d = date("l", $time);
	$time_2 = str_replace(array(
	'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
	array(
	'Вс','Пн','Вт','Ср','Чт','Пт','Сб'),$d);
	$time_text = $time_2.' '.date("H:i", $time);
	return $time_text;
	}
	//В этом году
	if(date("Y", $time) == date("Y", time()))
	//Если ни вчера, ни сегодня, и не на этой неделе, но в этом году, то выводим число месяц и время
	{
	$montharr = array("янв","фев","мар","апр","мая","июн","июл","авг","сен","окт","ноя","дек");
	$i = date("m",$time) -1;
	return date("j",$time)." $montharr[$i] ".date("H:i",$time);
	}
	//Если ни одно из условий не совпало, то просто выводим целую дату
	$montharr2 = array("янв","фев","мар","апр","мая","июн","июл","авг","сен","окт","ноя","дек");
	$i = date("m",$time) -1;
	return date("j",$time)." $montharr2[$i] ".date("Y в H:i",$time);
}
?>