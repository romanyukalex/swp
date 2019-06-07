<?

$formsize_standart=75; // Стандартная длина поля в админке

$var[0]=1;
$vartype[0]="select";
$varpossible[0]="1;;2;;3";
$describe[0]="В какую сторону округлять незаконченную минуту";
$example[0]="
1) Округление в большую сторону.<br>
5.1 округлится до 6<br>
5.9 округлится до 6<br>
2) Округление дробного числа до целого.<br>
3.4 округлится до 3.0<br>
3.5 округлится до 4.0<br>
3.6 округлится до 4.0<br>
3) Округление в меньшую сторону.<br>
5.1 округлится до 5<br>
5.9 округлится до 5<br>";

$var[1]="Внимание! При переходе к просмотру камер начнётся тарификация по времени.";
$vartype[1]="input";
$describe[1]="Подпись под знаком PLAY в личном кабинете";
$formsize[1]=75; // Размер size для формы в админке
$formmaxlegth[1]=300; // Максим количество символов в переменной var[$i]

$var[2]="Статистика Ваших посещений и списания";
$vartype[2]="input";
$describe[2]="Название раздела статистики";
$formmaxlegth[2]=300;


$var[3]="support@ovzor.ru, aromanuk@mail.ru";
$vartype[3]="input";
$describe[3]="E-mail, куда отправляются письма, сформированные из Сообщения Администратору";

$var[4]=5;
$vartype[4]="input";
$describe[4]="Количество цифр в счёте пользователя";
$formmaxlegth[4]=2;

$var[5]=3;
$vartype[5]="select";
$varpossible[5]="";$example[5]="";
$prov=mysql_query("SELECT `tariffid`,`tariffname` FROM `ovzor-tariff` WHERE `status`='active' and `tarifftype`='online';");
while ($tariffinfo=mysql_fetch_array($prov))
	{$varpossible[5].=$tariffinfo[tariffid].";;";
	$example[5].=$tariffinfo[tariffid]." ".$tariffinfo[tariffname]."<br>";
	}
$varpossible[5]=substr($varpossible[5],0,-2); // Удалили 2 ;
$describe[5]="Тариф пользователя при заведении заказа";

$var[6]=300;
$vartype[6]="input";
$describe[6]="Сумма на счету при первоначальной активации пользователя (подарок)";
?>