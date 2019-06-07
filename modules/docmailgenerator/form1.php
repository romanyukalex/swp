<h2>Данные об организации-отправителе</h2>
<p><hr></p>
<h3>Реквизиты организации</h3>
<div id="formdcmtable_ap"></div>
<form action="#" method="post" id="formdcmtable">
<table class="formdcmtable">
<? global  $company_id;
insert_module("form_generator","edit_form","from-organization_form","$company_id");?>
</table>
</form>


<h3>Контактные лица в организации</h3>
<i>Необходимо добавить Директора, Главного бухгалтера и отправителей-составителей</i>
<? insert_module("contact_list","show_contact_list","","$company_id");?>
<a onClick="becamebig('addnewcontact');$('#addnewcontactlink').hide(100);" id="addnewcontactlink">
	<img src="/adminpanel/pics/green-add-circle.png" height="16px" class="imgmiddle">Добавить новое контактное лицо
</a>
<div style='display:none ;' id='addnewcontact'>	<br><br><b>Форма добавления контактного лица организации</b>
	<? insert_module("contact_list","new_contact_form");?>
</div>