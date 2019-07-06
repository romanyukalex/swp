<? if($userrole=="superuser"){?>

<b>Создать нового пользователя</b><br>

<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">
<? include($_SERVER["DOCUMENT_ROOT"]."/core/usersmanagement/add_new_user_form.php");
?>
</div></div></div>


<b>Управление пользователями</b><br>
<div id="usertable_messageplace"></div>
<table class="zebra">
    <thead>
    <tr>
        <th>№</th>        
        <th>Имя пользователя</th>
        <th>Логин</th>
		<th>Статус</th>
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
    </tr>
    </tfoot>    

<tbody id="usermanagetable">
<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script>
</tbody>
</table>
<? } else {?><h2>Раздел недоступен</h2><?}
?>