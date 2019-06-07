<? if($userrole=="superuser" or $userrole=="admin" or $userrole=="root"){?>
<?// echo "adminpanel=".$adminpanel;
if($userrole=="admin" or $userrole=="root"){?><img src="/adminpanel/pics/User-blue-add256.png" height="64px" class="imgmiddle"><?}?>
<b>Создать нового пользователя</b><br>

<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">
<? include($_SERVER['DOCUMENT_ROOT']."/core/usersmanagement/add_new_user_form.php");	
?>
</div></div></div>

<?if($userrole=="admin" or $userrole=="root"){?><img src="/adminpanel/pics/User-blue256.png" height="64px" class="imgmiddle"><?}?>

<b>Управление пользователями</b><br>
<div id="usertable_messageplace"></div>
<table class="zebra ap_table">
    <thead>
    <tr>    
        <th>Имя пользователя</th>
        <th>Логин</th>
		<th>Телефон</th>
		<? if($userrole=="root" or $userrole=="admin"){?><th>Компания</th><?}?>
		<th>Аттрибуты</th>
		<th>Действия</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <td>&nbsp;</td>        
        <td></td>
        <td></td>
		<? if($userrole=="root" or $userrole=="admin"){?><td></td><?}?>
		<td></td>
		<td></td>
    </tr>
    </tfoot>    

<tbody id="usermanagetable">
<script>$(document).ready(function(){ajaxreq('','','show_users_table','usermanagetable','usersmanagement');})</script>
</tbody>
</table>
<? }else{?><script>changerazdel("login");</script><?}
?>