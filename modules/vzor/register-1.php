<table width="700"  style="background: #fafafa;border: solid 1px Silver;">
<FORM ACTION="regmaker.php?=newuser" METHOD="POST">
<tr><td colspan="2"><b>�����������</b></td></tr>
<input type="text" SIZE="1" MAXLENGTH="1" name="ROBOTTRAP" class="hid" <? if ($ROBOTTRAP){echo "VALUE='".$ROBOTTRAP."'";} ?> >
<tr><td><p class="style6">�������:</p></td>
  <td><center><INPUT TYPE="text" NAME="SN"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="20" <? if ($SN){echo "VALUE='".$SN."'";} ?>></center></td></tr>
  <tr><td><p class="style6">���:</p></td><td><center><INPUT TYPE="text" NAME="FN"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="20" <? if ($FN){echo "VALUE='".$FN."'";} ?>></center></td></tr>

<tr><td colspan="2"><b>��������������� ����������</b></td></tr>
<tr><td><p class="style6">�����:</p></td>
<td><center><SELECT NAME="CITY">
<OPTION VALUE="������" <? if ($CITY=="������"){echo "selected";} ?>>������</OPTION>
<OPTION VALUE="��������" <? if ($CITY=="��������"){echo "selected";} ?>>��������</OPTION>
<OPTION VALUE="��������" <? if ($CITY=="��������"){echo "selected";} ?>>��������</OPTION>
<OPTION VALUE="���������������" <? if ($CITY=="���������������"){echo "selected";} ?>>���������������</OPTION>
<OPTION VALUE="������" <? if ($CITY=="������"){echo "selected";} ?>>������</OPTION>
<OPTION VALUE="������" <? if ($CITY=="������"){echo "selected";} ?>>������</OPTION>
</SELECT></center></td></tr>
<tr><td><p class="style6">��� ���������������� ����������:</p></td><td><center>
<SELECT NAME="DOUTYPE">
<OPTION VALUE="1" <? if ($DOUTYPE==1){echo "selected";} ?>>�����</OPTION>
<OPTION VALUE="2" <? if ($DOUTYPE==2){echo "selected";} ?>>������� ���</OPTION>
</SELECT></center></td></tr>
<tr><td><p class="style6">����� ���������������� ����������:</p></td>
<td><center><INPUT TYPE="text" NAME="REALNUMBER"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="6" <? if ($REALNUMBER){echo "VALUE='".$REALNUMBER."'";} ?>></center></td></tr>
<tr><td><p class="style6">�����/������:</p></td>
<td><center><INPUT TYPE="text" NAME="CLASSTITLE"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="6" <? if ($CLASSTITLE){echo "VALUE='".$CLASSTITLE."'";} ?>></center></td></tr>
<tr><td><p class="style6">��������� ����� ������������:</p></td>
<td><center><INPUT TYPE="text" NAME="schoolkey"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="10"></center></td></tr>

<tr><td colspan="2"><b>������ ������� ������</b></td></tr>
<tr><td><p class="style6">����� �� �����:</p></td>
<td><center><INPUT TYPE="text" NAME="LOGIN"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="20" title="��� ������������" <? if ($LOGIN){echo "VALUE='".$LOGIN."'";} ?>></center></td></tr>
<tr><td><p class="style6">������ ��� �����:</p></td><td><center><INPUT TYPE="password" NAME="PASSWORD"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="20" title="�� ����� 9 ���� �/��� ����" <? if ($PASSWORD){echo "VALUE='".$PASSWORD."'";} ?>></center></td></tr>
<tr><td><p class="style6">��� � ��� ����������:</p></td>
<td><center><INPUT TYPE="text" NAME="NICKNAME"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="40" <? if ($NICKNAME){echo "VALUE='".$NICKNAME."'";} ?>><br>
<span style="font-size:8;">��������: �������� ����, ����� ���������, ����</span></center></td></tr>
<tr><td><p class="style6">����� e-mail:</p></td>
<td><center><INPUT TYPE="text" NAME="EMAIL"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="30" <? if ($EMAIL){echo "VALUE='".$EMAIL."'";} ?>></center></td></tr>

<tr><td colspan="2"><b>������ ��� �������������� ������</b></td></tr>
<tr><td><p class="style6">��������� ������:</p></td>
<td><center><INPUT TYPE="text" NAME="QUESTION"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="40" <? if ($QUESTION){echo "VALUE='".$QUESTION."'";} ?>></center></td></tr>
<tr><td><p class="style6">����� �� ��������� ������:</p></td>
<td><center><INPUT name="SECRETANSWER"  TYPE="text"  SIZE="<? echo $registerformsize; ?>" MAXLENGTH="40" <? if ($SECRETANSWER){echo "VALUE='".$SECRETANSWER."'";} ?>></center></td></tr>

<tr><td colspan="2"><center><b>��������� ��������������</b></center></td></tr>
<tr><td><p class="style6">�������������� �����������:</p></td>
<td><center><textarea name="COMMENT" cols=30 rows=3  MAXLENGTH="600"><? if ($COMMENT){echo $COMMENT;} else echo "��� ������ ��������"; ?></textarea></center></td></tr>
<tr><td><p class="style6">��������� ������ �� ��������:</p></td>
<td><center><INPUT value="���������" type="submit"></center></td></tr>
</FORM>
</table>