<h2>Добавление проекта</h2>
<form method="post" enctype="multipart/form-data" action="/" accept-charset="utf-8" id="newprojectform">
<p>
    <label for="new_proj_name">Имя проекта</label>
    <input type="text" id="new_proj_name" name="new_proj_name" class="text" maxlength="30" value="Имя проекта"  onblur="if (value == '') {value = 'Имя проекта'}" onfocus="if (value == 'Имя проекта') {value =''}" />
</p>
<p>	<select name="activate_newpr" class="selectstyle" title="Активация" width="30">
        <option value="1" selected="selected">Активировать</option><option value="2">Не активировать</option>
    </select>
</p>
<!--
<p>
    <select><!-- Участники для выбора (из компании юзера)--><!--
    <? while ($users=mysql_fetch_array($query33))
        { ?>
        <option value="<?=$users[id]?>" onclick="setuserintoproject(<?=$userid?>);"><?=$userprojects[name]?></option>
    <?	}?>
    </select>
    <label for="memberlist">Состав проекта</label>
    <input type="text" id="memberlist" name="new_project_codename" class="text" maxlength="2000" value=""/>
</p>-->
<p>
    <input type="hidden" name="contact" value="1" />
    <a class="large button blue" onclick="saveform('0','newprojectform')" href="/#top">Создать проект</a>
</p>
</form>