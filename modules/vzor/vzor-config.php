<?

$formsize_standart=75; // ����������� ����� ���� � �������

$var[0]=1;
$vartype[0]="select";
$varpossible[0]="1;;2;;3";
$describe[0]="� ����� ������� ��������� ������������� ������";
$example[0]="
1) ���������� � ������� �������.<br>
5.1 ���������� �� 6<br>
5.9 ���������� �� 6<br>
2) ���������� �������� ����� �� ������.<br>
3.4 ���������� �� 3.0<br>
3.5 ���������� �� 4.0<br>
3.6 ���������� �� 4.0<br>
3) ���������� � ������� �������.<br>
5.1 ���������� �� 5<br>
5.9 ���������� �� 5<br>";

$var[1]="��������! ��� �������� � ��������� ����� ������� ����������� �� �������.";
$vartype[1]="input";
$describe[1]="������� ��� ������ PLAY � ������ ��������";
$formsize[1]=75; // ������ size ��� ����� � �������
$formmaxlegth[1]=300; // ������ ���������� �������� � ���������� var[$i]

$var[2]="���������� ����� ��������� � ��������";
$vartype[2]="input";
$describe[2]="�������� ������� ����������";
$formmaxlegth[2]=300;


$var[3]="support@ovzor.ru, aromanuk@mail.ru";
$vartype[3]="input";
$describe[3]="E-mail, ���� ������������ ������, �������������� �� ��������� ��������������";

$var[4]=5;
$vartype[4]="input";
$describe[4]="���������� ���� � ����� ������������";
$formmaxlegth[4]=2;

$var[5]=3;
$vartype[5]="select";
$varpossible[5]="";$example[5]="";
$prov=mysql_query("SELECT `tariffid`,`tariffname` FROM `ovzor-tariff` WHERE `status`='active' and `tarifftype`='online';");
while ($tariffinfo=mysql_fetch_array($prov))
	{$varpossible[5].=$tariffinfo[tariffid].";;";
	$example[5].=$tariffinfo[tariffid]." ".$tariffinfo[tariffname]."<br>";
	}
$varpossible[5]=substr($varpossible[5],0,-2); // ������� 2 ;
$describe[5]="����� ������������ ��� ��������� ������";

$var[6]=300;
$vartype[6]="input";
$describe[6]="����� �� ����� ��� �������������� ��������� ������������ (�������)";
?>