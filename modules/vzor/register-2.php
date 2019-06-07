<table width="700">
<FORM ACTION="regmaker.php?=newcand" METHOD="POST">
<tr><td colspan="2"><b>Воспитанник</b></td></tr>
<input type="text" SIZE="1" MAXLENGTH="1" name="ROBOTTRAP" class="hid" <? if ($ROBOTTRAP){echo "VALUE='".$ROBOTTRAP."'";} ?> >
<tr><td><p class="style6">Фамилия:</p></td>
  <td><center><INPUT TYPE="text" NAME="SN"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="20" <? if ($SN){echo "VALUE='".$SN."'";} ?> ></center></td></tr>
  <tr><td><p class="style6">Имя:</p></td><td><center><INPUT TYPE="text" NAME="FN"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="20" <? if ($FN){echo "VALUE='".$FN."'";} ?>></center></td></tr>
<tr><td><p class="style6">Роль на сайте:</p></td><td><center><SELECT NAME="USERROLE">
<OPTION VALUE="1" <? if ($USERROLE==1){echo "selected";} ?> >Родитель</OPTION>
<OPTION VALUE="2" <? if ($USERROLE==2){echo "selected";} ?>>Директор ДОУ</OPTION></SELECT></center></td></tr>
<tr><td colspan="2"><b>Образовательное учреждение</b></td></tr>
<tr><td><p class="style6">Город:</p></td>
<td><center><SELECT NAME="CITY">
<OPTION VALUE="Москва" <? if ($CITY=="Москва"){echo "selected";} ?>>Москва</OPTION>
<OPTION VALUE="Подольск" <? if ($CITY=="Подольск"){echo "selected";} ?>>Подольск</OPTION>
<OPTION VALUE="Климовск" <? if ($CITY=="Климовск"){echo "selected";} ?>>Климовск</OPTION>
<OPTION VALUE="Железнодорожный" <? if ($CITY=="Железнодорожный"){echo "selected";} ?>>Железнодорожный</OPTION>
<OPTION VALUE="Реутов" <? if ($CITY=="Реутов"){echo "selected";} ?>>Реутов</OPTION>
<OPTION VALUE="Другой" <? if ($CITY=="Другой"){echo "selected";} ?>>Другой</OPTION>
</SELECT></center></td></tr>
<tr><td><p class="style6">Тип образовательного учреждения:</p></td><td><center><SELECT NAME="DOUTYPE">
<OPTION VALUE="1" <? if ($DOUTYPE==1){echo "selected";} ?>>Школа</OPTION>
<OPTION VALUE="2" <? if ($DOUTYPE==2){echo "selected";} ?>>Детский сад</OPTION></SELECT></center></td></tr>
<tr><td><p class="style6">Номер образовательного учреждения:</p></td>
<td><center><INPUT TYPE="text" NAME="REALNUMBER"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="6" <? if ($REALNUMBER){echo "VALUE='".$REALNUMBER."'";} ?>></center></td></tr>
<tr><td><p class="style6">Класс/группа:</p></td>
<td><center><INPUT TYPE="text" NAME="CLASSTITLE"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="12" <? if ($CLASSTITLE){echo "VALUE='".$CLASSTITLE."'";} ?>></center></td></tr>
<tr><td><p class="style6">Как к Вам обращаться:</p></td>
<td><center><INPUT TYPE="text" NAME="NICKNAME"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="40" <? if ($NICKNAME){echo "VALUE='".$NICKNAME."'";} ?>><br></center></td></tr>
<tr><td><p class="style6">Адрес e-mail:</p></td>
<td><center><INPUT TYPE="text" NAME="EMAIL"  SIZE="<?=$registerformsize; ?>" MAXLENGTH="30" <? if ($EMAIL){echo "VALUE='".$EMAIL."'";} ?>></center></td></tr>
<tr><td colspan="2"><b>Сообщение администратору</b></td></tr>
<tr><td><p class="style6">Дополнительный комментарий:</p></td>
<td><center><textarea name="COMMENT" cols=30 rows=3  MAXLENGTH="600"><? if ($COMMENT){echo $COMMENT;} else echo "Мне нечего добавить"; ?></textarea></center></td></tr>
<tr><td><p class="style6">Отправить заявку:</p></td>
<td><center><INPUT value="Отправить" type="submit"></center></td></tr>
</FORM>
</table>