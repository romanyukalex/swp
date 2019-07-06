<? # Гостевая книга

@include_once($_SERVER["DOCUMENT_ROOT"]."/system-param.php");?>
<style>
.chat {
	/*height: 500px;
	overflow: auto; /* Это позволяет отображать полусу прокрутки */
	position: relative; /* Это позволяет съезжать тексту в слое, не растягивая страницу */
	text-align: left;
	/*border: solid #818181 1px;*/
}
.chat span {
	display: block;
}
.chat #chat_area div { border:groove;
height:50;
}
.chattext{text-align:left}
input[type=text],textarea {
	width: 100%;
	font: normal normal normal 16px "Trebuchet MS", Arial, Times;
	border: solid #818181 1px;
}

/* Для CSS 3 */
.r4 {
	-moz-border-radius: 4px;
	-khtml-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
}
</style>


<script type="text/javascript">
$(document).ready(function () {
	Load('nor');
    /*$("#pac_form").submit(Send);*/ 
    //setInterval("Load();", <? if ($guestbooktimeout){echo $guestbooktimeout;}else{?>2<? }?>000); // вызывать загрузку сообщений каждые N секунд
});    

// Функция для отправки сообщения
function Send() {
    $.post("/ajax/",  
	{
		action:"guestbookquery",
        act: "send", 
        name: $("#pac_name").val(),
        text: $("#pac_text").val() 
    },
     Load );

    $("#pac_text").val("");
    //$("#pac_text").focus();
    return false;
}

var last_message_id = 0;
var load_in_process = false;

// Функция для загрузки сообщений

function Load(mode) {
    if(!load_in_process)
    {	load_in_process = true;
		$("#chat_area").load("/ajax/",{action:"guestbookquery",act: "load",gbmode:mode},
   	    function () {
		    $(".chat").scrollTop($(".chat").get(0).scrollHeight); 
		    load_in_process = false;
    	});
    }
}
</script>

<ul class='m_blog listing topbox'><li class="">Гостевая книга СВСБСБ<br />&nbsp<a href="" onClick="Load('all');return false;">Вся книга</a></li></ul>
<div class="chat r4">
<div id="chat_area"><!-- новые сообщения --></div>
</div>
<ul class='m_blog listing topbox'><li><span><b>Оставить отзыв или задать вопрос:</b></span></li></ul>
<form id="pac_form" action="">
<table style="width: 100%;">
	<tr>
		<td>Имя:</td>
		<td>Сообщение:</td>
		<td></td>
	</tr>
	<tr>
		
		<td><input type="text" id="pac_name" class="r4" value="Гость"  onblur="if (value == '') {value = 'Гость'}" onfocus="if (value == 'Гость') {value =''}"></td>
		<td style="width: 80%;"><!--<input type="text" id="pac_text" class="r4" value="">--><textarea id="pac_text" class="r4" value=""></textarea></td>
		<td><a class="large button orange" onClick="Send();return false;">Отправить</a></td>
	</tr>
</table>
</form>
</div>