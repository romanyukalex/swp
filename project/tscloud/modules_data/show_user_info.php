<? #Вынести в project воблы
$log->LogInfo('Got this file');
//if($userrole and $userrole!=="guest"){ ?>
<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">

<table><tr><td width="200px">Имя пользователя</td><td width="30px"><b>:</b></td><td> <?=$fullname?></td></tr>
<tr><td>Логин</td><td><b>:</b></td><td><?=$login?></td></tr>
<? if($userrole=="user" and ($companyinfo['company_id'] or $company_id)){?><tr><td>Компания</td><td><b>:</b></td><td title="<?=$companyinfo['company_id']?>"><?=$companyinfo['form_of_business_ownership']." ".$companyinfo['company_full_name']?></td></tr><? }?>
</table></div></div></div>



<? if($userrole=="superuser"){?>
<div class="b-other-projects b-text mb">
	<div class="wrap">                 
	<div class="b-text_2col">
	<table>
<tr><td width="200px">Компания</td><td width="30px"><b>:</b></td><td title="<?=$companyinfo['company_id']?>"><?=$companyinfo['form_of_business_ownership']." ".$companyinfo['company_full_name']?></td></tr>
<? if($companyinfo['inn']){?><tr><td>ИНН</td><td><b>:</b></td><td><?=$companyinfo['inn']?></td></tr><? }
if($companyinfo['kpp']){?><tr><td>КПП</td><td><b>:</b></td><td><?=$companyinfo['kpp']?></td></tr><? }
if($companyinfo['bik']){?><tr><td>КПП</td><td><b>:</b></td><td><?=$companyinfo['bik']?></td></tr><? }
if($companyinfo['legal_address']){?><tr><td>Юридический адрес</td><td><b>:</b></td><td><?=$companyinfo['legal_address']?></td></tr><? }
if($companyinfo['real_address']){?><tr><td>Фактический адрес</td><td><b>:</b></td><td><?=$companyinfo['real_address']?></td></tr><? }
if($companyinfo['post_address']){?><tr><td>Почтовый адрес</td><td><b>:</b></td><td><?=$companyinfo['post_address']?></td></tr><? }
if($companyinfo['company_domain']){?><tr><td>Сайт компании</td><td><b>:</b></td><td><?=$companyinfo['company_domain']?></td></tr><? }
?>
</table>
</div></div></div>
<? }// Данные для суперюзеров
?><br><br><br>
<? /*}else{?><script>changerazdel("login");</script><?}*/