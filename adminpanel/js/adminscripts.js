/* Scripts of the adminpanel */
$(document).ready(function(){
	any_site_size("adminblock","ap_header_tr","ap_topmenu_tr","ap_footer_block","white_space");
	
	$('.admindeletelink').click(function(){
		var pageid=this.id;
		deletepage(pageid);
	});
	$('#newpagebutton').click(function(){createpage();});
	$('#pagestable td:not(.actionstd)').click(function(){var pageident=$(this).parent().attr("id");editpage(pageident);});
	$('#lightbutton').click(function(){
									$('#adminblock').stop().animate({ backgroundColor: '#ffffff'}, "slow"); return false;
									 
									 });
});


function showblock(blockid){
$("#"+blockid).show(1000);
return false;
}

function deletepage(pageid){
	$('#messages').load('/core/ajaxapi.php', {mod:'adminpanel',action:'deletepage',id:pageid});
}
function createpage(){
	var newpagetitle=$('#newpagetitle').attr("value");
	var newpagepage=$('#newpagepage').attr("value");
	var newpagefolder=$('#newpagefolder').attr("value");
	var newpagefilenameext=$('#newpagefilenameext').attr("value");
	$('#messages').load('/core/ajaxapi.php', {mod:'adminpanel',action:'createpage',pagetitle:newpagetitle,pagepage:newpagepage,pagefolder:newpagefolder,pagefilenameext:newpagefilenameext,rand:Math.random()});
}
function editpage(pageident){
	$('#pageeditor').load('/core/ajaxapi.php', {mod:'adminpanel',action:'editpage',page:pageident,rand:Math.random()});
}
function editnews(newsident){
	$('#pageeditor').load('/core/ajaxapi.php', {mod:'adminpanel',action:'editnews',id:newsident,rand:Math.random()});
}
function saveit(paramid,paramtype){ // ПОД ВОПРОСОМ НУЖНОСТЬ
	if(paramtype=='input'){	var nv = $("#field_"+paramid).attr('value');}
	if(paramtype=='select'){var nv = $("#field_"+paramid+" option:selected").val();}
	if(paramtype=='color'){	var nv = $("#color"+paramid).attr('value');}
	$('#fieldmessage_'+paramid).load('/core/ajaxapi.php', {mod:'adminpanel',action:"editconfig",id:paramid,newvalue:nv});
}
function saveselect(paramid){
	var nv = $("#field_"+paramid+" option:selected").val();
	$('#fieldmessage_'+paramid).load('/core/ajaxapi.php', {mod:'adminpanel',action:"editconfig",id:paramid,newvalue:nv});
}
function serverinfo(){
	$('#content1').load('/core/ajaxapi.php', {mod:'adminpanel',action:"serverinfo",rand:Math.random()},function(){softpageshow();});
	
}
function save_param(paramid,paramtype){
	var param_value=$("#field_"+paramid).val();
	ajaxreq(paramid,param_value,'editconfig','fieldmessage_'+paramid,'adminpanel');
}
function show_module_data(module_id,modulename,module_action,module_data_field){
	hidetronlywithout('module_table','moduletr'+module_id+'_',1000,'settings_table_header','settings_table_footer');
	ajaxreq(modulename,module_id,module_action,module_data_field,'adminpanel');
	
}
function hidetronlywithout(tableid,str,speed,showexeprionid1,showexeprionid2){
	$('#'+tableid+' tr:not(:contains("'+str+'"))').hide();
	$('#'+showexeprionid1).show();
	$('#'+showexeprionid2).show();
}
function get_table_data(){
	//$('body').append('<div id="hidden_block" class="hid"></div>');
	module=arguments[0];
	someaction=arguments[1];
	
	nok_answerplace=arguments[2];
	table_id=arguments[3];
	
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: '/core/ajaxapi.php',
		data: 'action='+someaction+'&mod='+module+'&rand='+Math.random(),
		success: function(answer){
			//Пишем сообщение
			if(answer.status=='ok'){
				
				//Заголовок таблицы
				var hcount=0;
				$.each(answer.header, function(i, header){
					
					if(header=="hide_id"){//Стролбцы с названием hide_id не выводятся пользователю
						$("#"+table_id+" #th").append("<th id='head_"+i+"'>ID</th>");
						donotshow=i;
					} else	{//Обычные header
						$("#"+table_id+" #th").append("<th id='head_"+i+"'>"+header+"</th>");
					} 
					hcount++;
				})
	
				// Мясо таблицы
				$.each(answer.message, function(j, table_data){
					//Накидываем строк
					$("#"+table_id+" #th").after('<tr id="raw_'+j+'"><td><input id="raw_chbx_'+j+'" type="checkbox" value="'+j+'" class="raw_checkbox"></td>');
					$.each(table_data, function(field,value){
						
						if(donotshow!=field){// Для сокрытия столбца, который помечен donotshow
							$("#"+table_id+" #raw_"+j).append('<td>'+value+'</td>');// Накидываем значение в ячейки
						}
					});				
				});
				
				$("#"+table_id+" #th").after("<tr id='action_tr'><td colspan='"+hcount+"'>С выбранными: <a onclick='edit_item_func(\""+table_id+"\");return false;' id='edititem_butt_"+table_id+"' class='edititem_butt' title='Редактировать'><img src='/adminpanel/pics/Javelin256.png'></a>Поиск <input id='search_"+table_id+"' class='ap_search' name='apt_search'></td></tr>");
				$("#"+table_id).after('<aside id="modal_window_'+table_id+'" class="modal"></aside>');
			}
			else {$("#"+nok_answerplace).html(answer.message);}
			
			//Исполняем вызванную фукнцию
			if(answer.getfunction){eval(answer.getfunction);}
		},
		error: function (jqXHR, exception) {
			var url = window.location.href;
			var message='got error '+jqXHR.status+' when send {action='+someaction+'&someid1='+someid1+'&someid2='+some_id2+'&someid3='+some_id3+'&mod='+module+'} and data {'+s+'} from form '+formid+' on url '+url;
			$("#error_handler_ap").load('/core/ajaxapi.php',{data:message,action:"ajax_error_handled",rand:Math.random()},function(){return false;});
		}
	});
}
function edit_item_func(){
	table_id=arguments[0];
	// Проверяем, есть ли в этой табличке выбранное
	var raw_id = $("#"+table_id+' .raw_checkbox:checked').val();
	//Наполняем модальное окно
	$('#modal_window_'+table_id).html("<div><b>Hi</b><a onclick=\"$('#modal_window_'+table_id).css({'opacity': '0', 'pointer-events': 'none' });\" href='#close' title='Закрыть'></a></div>");
	$('#modal_window_'+table_id).css({"opacity": "1", "pointer-events": "auto" });
	// Показываем модальное окно
	
	//$("#"+table_id+' #raw_chbx_'+raw_id).after('<aside id="example" class="modal"><div><h2>Модальное окно</h2><p>Анимация модального окна отлично работает в Safari и iOS. Браузер Chrome показывает анимацию несколько вяло. Firerefox выводит трансформацию прозрачности, но но не показывает анимацию, так как не поддерживает @keyframe.</p><a href="#close" title="Закрыть">Закрыть</a></div></aside>');
}
function put_raws_to_table(){
	table_id=arguments[0];
	alert(table_id);
	
}
/*
function any_site_size(siteblock,siteheaderblock,topmenublock,footerblock,whitefield){
	var windowheight=$(window).height();  
	var siteblockheight=$("#"+siteblock).height();

	if(windowheight>siteblockheight){// Окно больше сайта, надо растягивать
		var siteheaderblockheight=$("#"+siteheaderblock).height();
		var topmenuheight=$("#"+topmenublock).height();
		var pageheight=$("#ap_page_block_tr").height();
		var footerblockheight=$("#"+footerblock).height();
		var needheight=windowheight-siteheaderblockheight-topmenuheight-pageheight-footerblockheight-20;
		$("#"+whitefield).animate({height: needheight}, 300);
	}
}*/