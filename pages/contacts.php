<div class="clearfix"></div>
<hr class="dashed grid_12" />
<? if ($messagetopage){echo $messagetopage;}?>
<!-- About -->
<section class="about text grid_8">
    

    <p class="address">
        <img src="files/address0.png" alt="" /><span>&nbsp;Москва, ул. Юности, д. 13</span><br>
        <img src="files/email000.png" alt="" /><span>&nbsp;&nbsp;<?=$officialemail?></span><br>
        <img src="files/phone000.png" alt="" /><span>&nbsp;+7(495)648-0808</span>
    </p>

    <hr class="dashed" />

 
    <h3>У Вас есть уточняющие вопросы?</h3>
    <p>Просим Вас пользоваться формой обратной связи:</p>
</section>
<br><br>
<!-- Contact form -->
<section class="contact_form simple grid_4">

<? //include($_SERVER['DOCUMENT_ROOT']."/modules/contact_form/design.php");
insert_module("contact_form");?>

</section>