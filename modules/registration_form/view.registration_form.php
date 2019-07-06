<? $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); ?>
<? if ($nitka=="1"){ ?>
Общая форма
 <div class="window-border">
                <div class="window-wrap">
				<div id="regform_answerplace"></div>
                  <form method="POST" action="" name="SIMPLE_FORM_4" id="registration_form" onSubmit="saveform1('saveform','registration_form','regform_answerplace','registration_form');return false;">
                    <table class="b-simple-form b-simple-form_with-required">
                      <tbody><tr>
                        <td class="label required">
                          <label>ФИО</label>
                        </td>
                        <td class="field">
                          <span class="text-field">
                            <b></b>
                            <input type="text" name="newfullname" value="" required="required">
                          </span>
                        </td>
                      </tr>
					  <tr>
                        <td class="label required">
                          <label>E-mail</label>
                        </td>
                        <td class="field">
                          <span class="text-field">
                            <b></b>
                            <input type="email" name="new_customer_email" required="required">
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td class="label required">
                          <label>Телефон</label>
                        </td>
                        <td class="field">
                          <span class="text-field">
                            <b></b>
                            <input type="tel" name="new_customer_phone" required="required">
                          </span>
                        </td>
                      </tr>
					  
					  <tr><td colspan="2" style="border-bottom: 1px solid #56778E;height:10px;"></td></tr>
					<tr><td colspan="2" style="height:10px;"> </td></tr>
					<tr>
                        <td class="label required">
                          <label>Страна</label>
                        </td>
                        <td class="field">
                          <select id="country_select" name="new_company_country" onchange="get_cities('cityplace');">
						  <? insert_function("region_data");
						  $allcountryreq=get_all_country();
						 
						  while($allcountry=mysql_fetch_array($allcountryreq)){
							?><option value="<?=$allcountry['id']?>"><? if($allcountry['country_name_ru']){echo $allcountry['country_name_ru'];} else $allcountry['country_name_en'] ?></option><?
						  }?>
						  </select>
                        </td>
                      </tr>
					  <tr>
                        <td class="label required">
                          <label>Город</label>
                        </td>
                        <td class="field">
							<select name="new_company_city" id="cityplace">
								<SCRIPT>$(document).ready(function(){get_cities('cityplace');})</SCRIPT>
							</select>
						</td>
					  </tr>
  
  
					  <tr>
                        <td class="label required">
                          <label>Название компании</label>
                        </td>
                        <td class="field">              
							<? /*
							<select id="" name="new_company_form_b_ownership">
							<? 
							insert_function("enum_select");
							$fbos=enum_select("$companiesprefix-companies","form_of_business_ownership");
							foreach($fbos as $fboskey=>$fbosvalue){
								?><option value="<?=$fbosvalue?>"><?=$fbosvalue?></option><?
							}
							?>
							</select>*/?>
							<span class="text-field">
                            <b></b>
							<input type="text" name="new_company_full_name" required="required">
                          </span>
                        </td>
                      </tr>
					  <? /*
                      <tr>
                        <td class="label required">
                          <label>Юридический адрес</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_legal_address" required="required">
                          </span>
                        </td>
                      </tr>
					  <tr>
                      <td class="label">
                          <label>Фактический адрес</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_real_address">
                          </span>
                        </td>
                      </tr>	
					  <tr>					  
                       <td class="label">
                          <label>Почтовый адрес</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_post_address">
                          </span>
                        </td>
                      </tr>
					  <tr>	*/?>
					  <td class="label">
                          <label>ИНН</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_inn">
                          </span>
                        </td>
                      </tr>
					  <? /*
					  <tr>	
					  <td class="label">
                          <label>КПП</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_kpp">
                          </span>
                        </td>
                      </tr>
					  <tr>	
					  <td class="label">
                          <label>БИК</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_bik">
                          </span>
                        </td>
                      </tr>*/?>
					  <tr>					  
                       <td class="label">
                          <label>Сайт компании</label>
                        </td>
                        <td class="field">              
						   <span class="text-field">
                            <b></b>
							<input type="text" name="new_company_domain">
                          </span>
                        </td>
                      </tr>							  
					 
					 
					 
					 
                    </tbody></table>
					 
                    <div>
                      <input type="image" src="/22_files/send.png" onclick="saveform1('saveform','registration_form','regform_answerplace','registration_form');return false;" >
                      <span class="error" style="display:none">Проверьте правильность заполнения обязательных полей</span>
                    </div>
                    <div class="b-required_message">
                      Обязательные поля для заполнения
					  </div>
                  </form>
				  
				 
                </div>
              </div>
<? } ?>