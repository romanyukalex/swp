<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ?>
<? if ($userrole=="guest" and $nitka=="1"){?><div>
<script type="text/javascript" src="/js/md5.js"></script>
<script type="text/javascript">
//<![CDATA[
function encode_pass() {
  var dp = document.getElementById('dummy_password');
  var rp = document.getElementById('real_password');
  rp.value = MD5_hexhash(dp.value);
  dp.value = '';
};
//]]>
</script>
<table><tr><!--td style="vertical-align:middle;">
<a href="/"><img src="<?=$logofile;?>" border="0"></a>
</td--><td>
<br>
<FORM ACTION="/?page=<?=$page?>&parentpage=<?=$parentpage?>" METHOD="POST" id=info onsubmit="encode_pass()">
<? if ($errmessage){echo "<span style='font:6;'>".$errmessage."</span><br>";}; ?>
<div id="login-wrap" class="slider">
<label for="login">Логин</label><br />
<INPUT TYPE="text" NAME="login" ID="login" MAXLENGTH="20" style="height:30;">
</div><br><br>
<div id="password-wrap" class="slider">
<label for="dummy">Пароль</label>
<input type="password" name="dummy" id="dummy_password" value="" MAXLENGTH="20" style="height:30;" /><br />
<input type="hidden" name="password" id="real_password" value="" />
</div><br>
<INPUT type="hidden" SIZE="1" MAXLENGTH="1" name="Family" class="hid">
<INPUT type="submit" value="Войти" id="btn" name="btn" onClick="checkmylogin();return false;">
</FORM>
</td></tr></table></div>
<? }?>