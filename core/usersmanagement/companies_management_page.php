<? if($userrole=="superuser" or $userrole=="admin" or $userrole=="root"){?>
<?// echo "adminpanel=".$adminpanel;
if($userrole=="admin" or $userrole=="root"){?><img src="/adminpanel/pics/company-add.png" height="64px" class="imgmiddle"><?}?>
<b>Создать новую компанию</b><br>

<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">
<? include($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/add_new_comp_form.php");	
?>
</div></div></div>


<?if($userrole=="admin" or $userrole=="root"){?><img src="/adminpanel/pics/company.png" height="64px" class="imgmiddle"><?}?>

<b>Управление компаниями</b><br>

<div id="comptable_messageplace"></div>
<table class="zebra ap_table">
    <thead>
    <tr>
        <!--th>№</th-->        
        <th>Название</th>
		<th>Расположение</th>
		<th>Бухинфо</th>
		<th>Сайт</th>
		<th>Действия</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <td>&nbsp;</td>        
        <td></td>
        <td></td>
		<td></td>
		<td></td>
		<td></td>
    </tr>
    </tfoot>    

<tbody id="usermanagetable">
<script>$(document).ready(function(){ajaxreq('','','show_companies_table','usermanagetable','usersmanagement');})</script>
</tbody>
</table>
<? } else {?><h2>Раздел недоступен</h2><?}
?>