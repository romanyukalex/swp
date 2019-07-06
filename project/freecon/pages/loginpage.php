<div id="form" class="div-form">
            <div class="container" id="form_container">
                
              <script>
    $("a[href='#form']").click(function(){
        if ($('#request_form').data('hasrequest')) {
            $('#request_form').submit();
        }
    });
</script>

<span style="font-size: 24px;">Войдите на портал под учётной записью</span><br><br>
<? 
if($_SESSION['redirect_url']) $redirect_page=$_SESSION['redirect_url'];

insert_module("auth_social","show_auth_links",$redirect_page);?><br>

	 <i style="font-size:small"> Заходя на портал под учётной записью социальной сети, Вы соглашаетесь на обработку персональных данных, а также подтверждаете своё совершеннолетие</i>
      
<br><br>
<div style="width:500px"><hr><span style="font-size: 24px;">или </span><a href="/?page=register" class="justlink">зарегистрируйтесь</a></div>


                </div>
        </div>