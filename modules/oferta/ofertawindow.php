<style type="text/css">

#svet{
  background: url(/mtsstyles/i/magicsolutions/fon.png);
  display:block;
  position: absolute;
  width:100%;
  height:100%;
  left: 0;
  top: 0;
  z-index:10;
}
.popup {
  position: absolute;
  z-index:30;
  display:none;
  background:#fff;
  width:700px;
  height:380px;
  left:50%;
  margin-left:-350px;
  top:50%;
  margin-top:-190px;
  padding:15;
}
</style>

<!--[if IE]>
<style type="text/css">
#svet{
  top: expression($('#svet').scrollTop + "px");
  position:absolute;
}
.popup {
  height:420px;
}
</style>
<![endif]-->


<script>

$(document).ready(function() {	
	$("#svet").css("height", $(document).height()); // устанавливает висоту div'а равную высоте страницы.
	$("#svet").css("width", $(document).width());
	//$('body').append('#svet');
	$('#svet').fadeTo(0, 0.4);
	$('#popupint').hide();
	$("#svet").fadeIn(); //эфект jQuery который делает плавное появление div'a
	$('.popup').fadeIn('slow');
	$('#popupint').fadeIn(2000);
	$('#applyoffertabut').hide();
	});
	
function showofertabutton(){
	var obj=document.getElementById('applyoffertabut');
	if(obj.style.display!=='none'){
		$('#applyoffertabut').hide();
		}
	else{$('#applyoffertabut').animate({opacity: "show"},1000);
		}
}
function sendoktosite(){
	$("#justforfun").hide();
	$("#justforfun").load("/ofertaaccepted/",{rand:<?=Rand(1,1000000)?>}, function(){
		$('.popup').fadeOut('slow');
		$('#svet').remove();// Погасили фон
		$("#justforfun").show(<? if ($browser!=="ie"){echo "1000";}?>).delay(1000).hide(<? if ($browser!=="ie"){echo "2000";}?>);
	});
}
</script>
<div id="svet"></div>
<div class="popup">
<div id="popupint">
<h3 style="color:red"><b>Добро пожаловать!</b></h3><br>
Для завершения регистрации внимательно прочтите «Публичную оферту на оказание услуги МТС Wi-Fi»<br><br>
Для перехода в Личный кабинет необходимо подтвердить своё согласие с условиями оферты и нажать кнопку «<b>Далее</b>»<br><br>
<fieldset><legend align="left" style="margin-left:20"><b style="padding-left:10;padding-right:10;color:black">Публичная оферта на оказание услуги МТС Wi-Fi</b></legend>

<!--	<textarea readonly="readonly" rows="10" cols="94" style="border: solid #FF0000; border-width:1;resize:none; margin-left:7" wrap="hard">-->
<div style="width: 650px; height: 150px; border: solid #FF0000; border-width:1;resize:none; margin-left:7; overflow:auto;">
		<? include($_SERVER["DOCUMENT_ROOT"]."/oferta.htm");?>
</div>
<!--	</textarea>-->
	<br><br>
	<input type="checkbox" name="applyofferta" id="applyofferta" onClick="showofertabutton();"> 
	Я согласен (согласна) с «Публичной офертой на оказание услуги МТС Wi-Fi»<br><br>
</fieldset>

<div class="btn-wrap" id="applyoffertabut" align="right"><div class="btn-wrap-right"></div>
<input  type="submit" class="submit" value="Далее" name="submitofferta" onClick="sendoktosite();return false;"></div>
</div>
</div>