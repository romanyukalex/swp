  <div id="vrWrapper">
        <div id="wr" class="wr" style="margin-left: -382px">
            <div id="indicator">            </div>
            <div class='registerBlock' id="signup" <? if ($query[1]!=="0") {echo 'style="visibility: hidden"';} ?>>
			<!-- Регистрация юзера -->
			<? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-1.php");?>

                    
                <div class='additional' align="left">
					<a href="register.php?%1">Индивидуалная заявка</a><br>
                    <a href="remind.html">Вспомнить пароль</a><br>
                    <a href="/">Войти</a>
				</div>
            </div>
            <div class='loginBlock' id="signin" <? if ($query[1]!=="1") {echo 'style="visibility: hidden"';} ?>>
			<!-- Войти в систему -->
 				<table border="0"><tr><td colspan="2" align="left"><ul><li>Пожалуйста, введите имя пользователя и пароль.</li></ul></td></tr>
<FORM ACTION="http://<?=$sitedomainname;?>/vzor/?%C4ET=BxoD" METHOD="POST">
<? if ($errmessage){echo "<tr><td colspan='2'><span style='font:6;color:#FF9933;'>".$errmessage."</span></td></tr>";}; ?>
<tr><td align="right"><span style="color: #1874cb;">Имя пользователя: </span></td><td align="left"><INPUT TYPE="text" NAME="login"  SIZE="21" MAXLENGTH="20" class="left-input"></td></tr>
<tr><td align="right"><span style="color: #1874cb;">Пароль: </span></td><td align="left"><INPUT TYPE="password" NAME="password" SIZE="21" MAXLENGTH="20" class="left-input"></td></tr>
<tr><td colspan="2"  align="center"><INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
<INPUT type="submit" value="Войти" class="enter-input"></td></tr>
</FORM></table>
</center><br><br><br><br><br><br>
            <div class='buttonDiv'></div>
                <div class='additional' align="center">
					<a href="register.php?%1">Индивидуалная заявка</a><br>
                    <a href="remind.html">Вспомнить пароль</a><br>
                    <a href="register.php?%5">Зарегистрироваться</a>              
				</div>
            </div>
            <div class='loginBlock' id="remindPass" <? if ($query[1]!=="2") {echo 'style="visibility: hidden"';} ?>>
			<!-- Напомнить пароль -->
                <div class="description">
                    Чтобы вспомнить пароль, вспомните хотя бы Ваш E-mail.                </div>
                <label for="email">Email:</label> <input id="remindEmail" type="text" class='textinput' />
                <div id="error2" class="error displaynone">                </div>
                <div id="message0" class="message displaynone">                </div>
                <div class='buttonDiv'>
                    <input id="remindButton" type="button" value="Выслать пароль" onclick="RemindPassword()" />
				</div>
                <div class='additional' align="center">
                    <a href="/">Войти</a><br>
					<a href="register.php?%1">Индивидуалная заявка</a><br>
                    <a href="register.php?%5">Зарегистрироваться</a>
				</div>
            </div>
			<div class='individualBlock' id="individual" <? if ($query[1]!=="3") {echo 'style="visibility: hidden"';} ?>>
			<!-- Индивидуальная заявка -->
                <? require($_SERVER["DOCUMENT_ROOT"]."/vzor/register-2.php");?>
				
				
			
                    
                <div class='additional' align="center">
                    <a href="remind.html">Вспомнить пароль</a>
                    <a href="/">Войти</a>
					<a href="register.php?%5">Зарегистрироваться</a>
				</div>         
			</div>
        </div>
        </div>
    </div>
</div>