// Скрипт для смены фотографий на главной
var ImgIdx = 2;
$(document).ready(function(){
	getMousePosition();//site_size();
	// создавать пустой DIV #error_handler_ap
	/*
	$('input[name=search]').focus().keyup(function() {
			$('#jokestable tr:not(:contains("' + $(this).val() + '"))').hide();
			$('#jokestable tr:contains("' + $(this).val().toLocaleLowerCase() + '")').show();
			$('#jokestable tr:contains("' + $(this).val().toUpperCase() + '")').show();
			$('#jokestable tr:contains("' + ucfirst ($(this).val().toLocaleLowerCase()) + '")').show();
			$('#jokestable tr:contains("' + $(this).val() + '")').show();
			});*/
});

function showHideSelection(str){
var obj=document.getElementById(str);
    if(obj.style.display=='inline'){
        obj.style.display='none';
    }else{
        obj.style.display='inline';   
    }
}
function showHideSelectionSoft(str,speed){
var obj=document.getElementById(str);
    if(obj.style.display!='none'){
		$('#'+str).fadeOut(speed);
		obj.style.display='none'; // ??
    }else{ 
		$('#'+str).fadeIn(speed);
		//setTimeout('n=1', speed);
		obj.style.display='inline';
    }
}
/*
function linkcolor(id){
$('.tasktable tr td').attr('class','');
$('.tasktable tr#'+id+' td').attr('class','curmenu');
}
function nolinkcolor(){
$('.tasktable tr td').attr('class','');
}*/
function showtr(tableid,str,speed){
	$('#'+tableid+' tr:contains("'+str+'")').fadeIn(speed);
}
function hidetr(tableid,str,speed){
	$('#'+tableid+' tr:contains("'+str+'")').fadeOut(speed);
}
function showtronlywithout(table_id,str){
	$('#'+table_id+' tr:not(:contains("'+str+'"))').show();
}
/*function hidetronlywithout(tableid,str,speed,showexeprionid1,showexeprionid2){
	$('#'+tableid+' tr:not(:contains("'+str+'"))').hide();
	$('#'+showexeprionid1).show();
	$('#'+showexeprionid2).show();
}*/

function hidecolmanage(table,colnum){
	if($('#showcol_'+colnum).is(':checked'))showcol(table,colnum)
	else hidecol(table,colnum);
}
function showcol(table,colnum){
	$('#'+table).find("tr").each(function(){
		$(this).find("td:eq("+colnum+")").show(1000)
		$(this).find("th:eq("+colnum+")").show(1000)
	});
}
function hidecol(table,colnum){
	$('#'+table).find("tr").each(function(){
		$(this).find("td:eq("+colnum+")").animate({width: "0"}, 1000,function(){$(this).hide()})
		$(this).find("th:eq("+colnum+")").animate({width: "0"}, 1000,function(){$(this).hide()})
	});
}
function showmytasks(name){
	if($('#showmytaskchecker').is(':checked')) showtrbyname(name)
	else hidetr(name);
}
function showcolleaugtasks(name){
	if($('#showcolleagtaskschecker').is(':checked')) showtrbynamewithout(name)
	else  hidetronlywithout(name);
}
function showtrbyname(table_id,name){
	$('#'+table_id).find("tr").each(function(){
		var prid=$(this).find(".hid").text().substr(5)
		if ($(this).is(':contains("'+name+'")') &&  $(this).css("display")=="none" && $('#showprid_'+prid).is(':checked')) $(this).show()
	})
}
function showtrbynamewithout(table_id,name){
	$('#'+table_id).find("tr").each(function(){
		var prid=$(this).find(".hid").text().substr(5)
		if ($(this).is(':not(:contains("'+name+'"))') &&  $(this).css("display")=="none" && $('#showprid_'+prid).is(':checked')) $(this).show()
	})
}
function showalltr(table){
	$('#'+table+' tr').show();
}
function showHideTr(str){
var obj=document.getElementById(str);
    if(obj.style.display=='table-row'){
        obj.style.display='none';
    }else{
        obj.style.display='table-row';   
    }
}
function saveform(someid1,formid,answerplace,module){
	var action='saveform';
	var s = $('#'+formid).serialize();
	$("#"+answerplace).load('/core/ajaxapi.php?'+s,{action:'saveform',someid:someid1,mod:module},function(){	
		$('#'+formid).trigger('reset');
	}).show(2000).delay(10000).fadeOut(2000);
}
function saveform1(someid1,formid,answerplace,module){
	var s = $('#'+formid).serialize();
	$("#"+answerplace).load('/core/ajaxapi.php?'+s,{action:'saveform',someid:someid1,mod:module},function(){ 
		$('#'+formid).trigger('reset').fadeOut(2000);
	});
}
function saveform2(someid1,formid,answerplace,module,someaction,resetform,hideform){
	var s = jQuery('#'+formid).serialize();
	
	jQuery("#"+answerplace).load('/core/ajaxapi.php?'+s,{action:someaction,someid:someid1,mod:module,rand:Math.random()},function(){
		if(resetform=='resetform' && hideform=='hideform') {jQuery('#'+formid).trigger('reset').fadeOut(1000);
		} else if (resetform=='resetform' && hideform=='') {jQuery('#'+formid).trigger('reset');
		} else if (resetform=='' && hideform=='hideform') {jQuery('#'+formid).fadeOut(2000);}
	});
}


function saveform3(){/*
	function saveform3(someid1,formid,ok_answerplace,nok_answerplace,module,someaction,resetform,hideform)
	Ответ на PHP
	$aRes = array('status' => 'ok', 'message' => 'All is OK','getfunction'=>'showblock("next_page_button")');
	echo json_encode($aRes);
	*/
	
	someid1=arguments[0];
	formid=arguments[1];
	ok_answerplace=arguments[2];
	nok_answerplace=arguments[3];
	module=arguments[4];
	someaction=arguments[5];
	resetform=arguments[6];
	hideform=arguments[7];
	
	var s = jQuery('#'+formid).serialize();
	
	jQuery.ajax({
		dataType: 'json',
		type: 'POST',
		url: '/core/ajaxapi.php',
		data: 'action='+someaction+'&someid='+someid1+'&mod='+module+'&rand='+Math.random()+'&'+s,
		success: function(answer){
			if(answer.status=='ok'){
				jQuery("#"+ok_answerplace).html(answer.message);
				if(resetform=='resetform' && hideform=='hideform') {jQuery('#'+formid).trigger('reset').fadeOut(1000);
				} else if (resetform=='resetform' && hideform=='') {jQuery('#'+formid).trigger('reset');
				} else if (resetform=='' && hideform=='hideform') {jQuery('#'+formid).fadeOut(2000);}
			}else {jQuery("#"+nok_answerplace).html(answer.message);}
			//Исполняем вызванную фукнцию
			if(answer.getfunction){
			eval(answer.getfunction);}
		},
		error: function (jqXHR, exception) {
			var url = window.location.href;
			var message='got error '+jqXHR.status+' when send {action='+someaction+'&someid='+someid1+'&mod='+module+'} and data {'+s+'} from form '+formid+' on url '+url;
			jQuery("#error_handler_ap").load('/core/ajaxapi.php',{data:message,action:"ajax_error_handled",rand:Math.random()},function(){return false;});
		}
	});
}


function softpageshow(){
	$("#content").animate({opacity: 0}, 1000,function(){
		// замена содержимого content на content1
		var htmlStr = $("#content1").html();
		$("#content").html(htmlStr);
		// Далее удаляем содержимое content1
		$("#content1").empty();
		});
	$("#content").animate({opacity: 1},1000);
}
function softblockshow(sourceblock,destblock){
	// Копирует cодержимое одного блока в бругой, копируя содержимое source в dest
	$("#"+destblock).animate({opacity: 0}, 1000,function(){
		var htmlStr = $("#"+sourceblock).html();
		$("#"+destblock).html(htmlStr);
		});
	$("#"+destblock).animate({opacity: 1},1000);
}
function changerazdel(razdel){
	$("#content1").load('/core/ajaxapi.php?page='+razdel,{id:'1',action:"getpage",rand:Math.random()},function(){
		softpageshow();
		//linkcolor(razdel);
		showmenu(razdel,'leftmenutab','by_page');
		});
	return false;
}
function set_title(newtitle){
	$("#titleonpage").html(newtitle);
}
function shownews(someid){
	$("#content1").load('/core/ajaxapi.php?page=news',{id:someid,action:"getpage",rand:Math.random()},function(){softpageshow();});
	return false;
}
function checkmylogin(answerplace,ok_page){
	var dp = document.getElementById('formlogin');
	var rp = document.getElementById('formpass');
	login_username=dp.value;
	login_password=MD5_hexhash(rp.value);
	ajaxreq(login_username+"№№"+login_password,ok_page,"checklogin",answerplace,"loginform_simple");
	return false;
}
function logout(answerplace){
	$('#'+answerplace).load('/core/ajaxapi.php', {mod:"usersmanagement",action:"logout"}).fadeIn(2000).delay(10000).fadeOut(2000);
}
function closelogin(){
	$('.login').fadeOut(2500);
	$('#logreglinks').fadeOut(2500);
	$('#cabinetlinks').fadeIn(2500);
	$('.nonloggedlink').fadeOut(2500);
	$('.loggedlink').fadeIn(2500);
}
function openlogin(){
	$('.login').show(2500);
	$('#logreglinks').fadeIn(2500);
	$('#cabinetlinks').fadeOut(2500);
	$('.nonloggedlink').fadeIn(2500);
	$('.loggedlink').fadeOut(2500);
}
function showblock(blockid){
$("#"+blockid).show(1000);
return false;
}
function closeblock(id){
	$('#'+id).hide(2500);
	return false;
}
function becamebig(blockname){
	$("#"+blockname).show(2500);
}
function changeinputtype(input,newtype){
	$(input).get(0).type = newtype
}
function getMousePosition() { 
    $(document).one("mousemove", function (event) {
        window.mouseXPos = event.pageX;
        window.mouseYPos = event.pageY;   
		setTimeout(function() { getMousePosition(100) }, 100);    
    });
}
function showmenu(search_name,answerplace,action){
	if(action=='by_page') $("#"+answerplace).load('/core/ajaxapi.php?mod=menu&pagename='+search_name+'&',function(){ })
	else $("#"+answerplace).load('/core/ajaxapi.php?mod=menu&menuname='+search_name+'&',function(){ })
}
//function ajaxreq(some_id1,some_id2,someaction,answerplace,module){
function ajaxreq(){
	some_id1=arguments[0];
	some_id2=arguments[1];
	someaction=arguments[2];
	answerplace=arguments[3];
	module=arguments[4];
	some_id3=arguments[5];
	$("#"+answerplace).load('/core/ajaxapi.php',{mod:module,someid1:some_id1,someid2:some_id2,someid3:some_id3,action:someaction,rand:Math.random()},function(){ })
}
function ajax_req(){ //ajax_req(module,someaction,answerplace,some_id1,some_id2,some_id3) //используется для вставки кусков HTML прямо на страницу, без обработки JSON
	module=arguments[0];
	someaction=arguments[1];
	answerplace=arguments[2];
	some_id1=arguments[3];
	some_id2=arguments[4];
	some_id3=arguments[5];
	some_id4=arguments[6];
	$("#"+answerplace).load('/core/ajaxapi.php',{mod:module,someid1:some_id1,someid2:some_id2,someid3:some_id3,someid4:some_id4,action:someaction,rand:Math.random()},function(){ })
}

function ajax_rq(){

//ajax_rq (module,someaction,ok_answerplace,nok_answerplace,some_id1,some_id2,some_id3)

	module=arguments[0];
	someaction=arguments[1];
	ok_answerplace=arguments[2];
	nok_answerplace=arguments[3];
	some_id1=arguments[4];
	some_id2=arguments[5];
	some_id3=arguments[6];
	some_id4=arguments[7];

	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: '/core/ajaxapi.php',
		data: 'action='+someaction+'&mod='+module+'&someid1='+some_id1+'&someid2='+some_id2+'&someid3='+some_id3+'&someid4='+some_id4+'&rand='+Math.random(),
		success: function(answer){
			//Пишем сообщение
			if(answer.status=='ok'){$("#"+ok_answerplace).html(answer.message);}
			else {$("#"+nok_answerplace).html(answer.message);}
			
			//Исполняем вызванную фукнцию
			if(answer.getfunction){eval(answer.getfunction);}
		},
		error: function (jqXHR, exception) {/*
			var url = window.location.href;
			var message='got error '+jqXHR.status+' when send {action='+someaction+'&someid1='+some_id1+'&someid2='+some_id2+'&someid3='+some_id3+'&mod='+module+'} and data {'+s+'} from form '+formid+' on url '+url;
			$("#error_handler_ap").load('/core/ajaxapi.php',{data:message,action:"ajax_error_handled",rand:Math.random()},function(){return false;});*/
		}
	});
	
}


function get_cities(answerplace){
	countryidval=$("#country_select").val();
	ajaxreq(countryidval,'','get_cities_of_country',answerplace,'region_data');
}
function any_site_size(siteblock,siteheaderblock,topmenublock,pageblock,footerblock,whitefield){
	var windowheight=$(window).height();  // Размер окна
	var siteblockheight=$("#"+siteblock).height(); // Весь сайт

	if(windowheight>siteblockheight){// Окно больше сайта, надо растягивать
		var siteheaderblockheight=$("#"+siteheaderblock).height();
		var topmenuheight=$("#"+topmenublock).height();
		var pageheight=$("#"+pageblock).height();
		var footerblockheight=$("#"+footerblock).height();
		var needheight=windowheight-siteheaderblockheight-topmenuheight-footerblockheight-20;
		//alert(windowheight+" "+needheight+" "+siteblockheight+" "+siteheaderblockheight+" "+topmenuheight+" "+pageheight+" "+footerblockheight);
		$("#"+whitefield).animate({height: needheight}, 300);
	}
}
/* Функция добавления пробелов в цифру (1 пробел на 3 символа). <script>put_space_to_digits("#label");</script>*/
function put_space_to_digits(block_id_or_class){
var str = $(block_id_or_class).html();
$(block_id_or_class).html(str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
}
