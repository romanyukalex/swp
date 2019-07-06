<?$countryName=insert_module("SxGeo_locatebyip","getCountryName",$ip);?>

<style>
input:invalid:not(:placeholder-shown) {border-color: red;}
input:valid:not(:placeholder-shown) {border-color: green;}
         

.form_div ul {list-style: none;}

.form_radio {
  font-family: "ProximaNova Bold";
  font-style: normal;
  font-weight: normal;
  font-size: 24px;
  padding: 0 0 20px 0;
  margin-bottom: 0 !important;
}
.form_div label {
  display: inline-block;
  vertical-align: top;
  padding: 2px 0 0 5px;
  font-size: 24px;
  color: #393939;
  margin-bottom: .5rem;
}
.form_div input[type=text],.form_div input[type=email],.form_div input[type=tel], .form_div textarea,.form_div select{
  border: 1px solid #c4c4c4;
  border-radius: 3px;
  width: 100%;
  background: #ffffff;
  padding: 10px 5px 8px 5px;
  font-size: 16px;
  line-height: 16px;
  text-align:center;
}
.form-agreement__label {
    color: #bababa;
}

.btn_green.xlarge {
    background: #42d9a6;
	    display: inline-block;
    vertical-align: top;
    color: #ffffff;
    text-align: center;
    font-size: 18px;
	padding: 18px 30px 18px 30px;
    margin: 5px auto 10px auto;
    border-radius: 0;
	line-height: normal !important;
    white-space: nowrap;
	text-transform: none;
	width:50%;
	border:none;
}
</style>
 


<div id="form" class="row flex-items-md-center form_div">
 
 
<form action="/" method="POST"  id="request_form" onsubmit="saveform3('','request_form','regform_answerplace','regform_answerplace','registration_form','addUser','resetform','hideform');return false;">
   
        <div class="col col-md-12" id="form_container" style="padding:0px">
                                           
                    <ul id="chooseRoleForm">
                        <li>  <div class="field_name">Роль</div>
							<div class="form_radio">
                                
                                <input id="selfrole1" type="radio" class="choose_role" name="selfrole" value="psychologist" onclick="showHideSelectionSoft('chooseRegVar',2000);showHideSelectionSoft('chooseRoleForm',2000);">
                                <label for="selfrole1">Я - Психолог, Тренер</label>
                            </div>
							<div class="form_radio">
                                <input id="selfrole2" type="radio" class="choose_role" name="selfrole" value="simple_user" onclick="showHideSelectionSoft('chooseRegVar',2000);showHideSelectionSoft('chooseRoleForm',2000);">
                                <label for="selfrole2">Просто интересуюсь психологией</label>
                            </div>
                            <!--div class="rightRadio">
								<a href="" class="small justlink">В чем отличие?</a>
                            </div-->
                        </li>
					</ul>
					
		</div>
		 <div class="col col-md-12">
					<ul id="chooseRegVar" style="display:none">
						
						<li class="sbm">
						<div class="field_name">Как Вы предпочитаете ввести данные?</div>
						<div class="form_radio">Залогиниться через<br>
						<? insert_module("auth_social","show_auth_links"); 	?></div>
						<div style="width:100%"><hr>или<hr></div>
						
						<div class="form_radio">Заполнить короткую форму</div><br>
							
							<a class="large swp_button blue" onclick="showHideSelectionSoft('regManualForm',2000);showHideSelectionSoft('chooseRegVar',2000);;return false;"><i class="fas fa-4x fa-address-card" style="color:white"></i></a>
							
						</li>
					</ul>	
		</div>
		 <div class="col col-md-12">			
						
					
					<ul id="regManualForm" style="display:none">
                        <li>
                            <div class="field_name">Имя</div>
                            <div class="field_option">
                                <input type="text" placeholder="Иван" name="new_name" maxlength="30" required>
                            </div>
                        </li>
						<li>
                            <div class="field_name">Фамилия</div>
                            <div class="field_option">
                                <input type="text" placeholder="Здоровый" name="new_family" maxlength="30" required>
                            </div>
                        </li>
                        <li>
                            <div class="field_name">E-mail</div>
                            <div class="field_option">
                                <input type="email" placeholder="ivanov@ivan.ru" name="new_customer_email" maxlength="100" required="required">
                            </div>
                        </li>
                        <li class="phone">
                            <div class="field_name">Телефон</div>
                            <div class="field_option clear">
                                <input type="tel" placeholder="+79015139363" name="phone" maxlength="15" required="required">
                               
                            </div>
                        </li>
                                  
						<li>
						<div class="field_name">Место проживания/деятельности</div>
						<div class="field_option">
						 <select id="country_select" name="country" style="width: 40%;" onchange="get_cities('cityplace');">
						  <? insert_function("region_data");
						  $allcountryreq=get_all_country();
						 
						  while($allcountry=mysql_fetch_array($allcountryreq)){
							?><option value="<?=$allcountry['id']?>"<? 
								if($countryName==$allcountry['country_name_ru']) {?>selected<?}
							?>><? if($allcountry['country_name_ru']){echo $allcountry['country_name_ru'];} else $allcountry['country_name_en'] ?></option><?
						  }?>
						  </select>
						  
							<select name="city" id="cityplace" style="width:60%">
								<SCRIPT>$(document).ready(function(){get_cities('cityplace');});
								get_cities('cityplace');</SCRIPT>
							</select>
						  
						  
						  </div>
						</li>	  		  
						<li>
						<div class="form-agreement__label">
						   
							<input class="form-agreement__checkbox" type="checkbox" name="5" checked="checked" value="1">
							Нажимая на кнопку "Зарегистрироваться", я даю согласие на обработку персональных данных и соглашаюсь c <a target="_blank" class="justlink" href="/?page=club_concept_n_rules">правилами клуба </a>
						</div>
						</li>
                        <li class="sbm">
							<button class="btn_green xlarge" id="submit_a" type="submit">Зарегистрироваться</button>
							<div id="regform_answerplace"></div>
						</li>
                    </ul>
					
					
<center><a id="want_toLogin" class="justlink" href="/" style="display:none;" data-toggle="modal" data-target="#auth_modal">Войти</a></center>
    
					
					</div>
	
    </form>
</div>



<div id="next_page_button" class="div-form" class="row flex-items-md-center"   style="display:none">
    <div class="container col col-md-12" id="form_container" style="padding:0px">
			
		<a class="super button blue" href="<? 
if($_SESSION['redirect_url']) {echo $_SESSION['redirect_url'];} else echo '/';?>">ПРОДОЛЖИТЬ<i class="fas fa-arrow-circle-right"></i></a>
    





		</div>
</div>

