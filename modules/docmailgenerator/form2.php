

<h2>Организации-получатели</h2>
<p><hr></p>
<p><i>Данные организаций, в которые направляются письма</i></p>
<? /*
<div id="comp_list_table_ap"></div>
<form id="comp_list_table">
<table class="formdcmtable">
<? # Список компаний
global  $company_id;
insert_module("companies_management","show_companies_list","target-organization_form","$company_id");?>
</table>
</form>*/?>
<h3>Добавить новую организацию</h3>
<div id="new_comp_table_ap"></div>
<form id="new_comp_table">
<table class="formdcmtable">
<? # Добавить компанию
insert_module("form_generator","show_form","target-organization_form");
global $company_id;
?>
</table>
</form>
<script>
$(window).bind("load", function() { 
	$("#target-organization_form_23").val("<?=$company_id?>");
});
</script>






<h3>Добавить контактное лицо</h3>
<? //insert_module("contact_list","show_contact_list","","$company_id");?>
<a onClick="becamebig('addnewcontact')" id="addnewcontactlink">
	<img src="/adminpanel/pics/green-add-circle.png" height="16px" class="imgmiddle">Добавить новое контактное лицо
</a>
<div style='display: ;' id='addnewcontact'>
	<? insert_module("contact_list","new_contact_form_targ");?>
</div>
<script>
$(window).bind("load", function() { 
	$("#new_contact_form_targ_31").val("<?=$company_id?>");
});
</script>
