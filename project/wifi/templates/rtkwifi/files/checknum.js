(function(){if($("#test-phone").size()==0){return}$.ajax({url:"/ajax/checkNumAjax",type:"post",dataType:"json",async:true,cache:false,success:function(resp){var result="";if(typeof resp.result!=="undefined"){for(var i in resp.result){result+="<option";if(i==0){result+=' selected=""'}result+=' value="'+resp.result[i]+'"> 8 ('+resp.result[i]+")</option>"}}$("#test-phone1").html(result);$(".js-selectric0").selectric("refresh")}});$("#test-phone").on("click",function(){var phone=$("#test-phone2").val();var code=$("#test-phone1 :selected").val();$.ajax({url:"/ajax/checkNumAjax",type:"post",dataType:"json",data:{regionCode:code,revisePhoneNumber:phone},async:true,cache:false,success:function(resp){var result="";if(resp.result){result="Номер принадлежит сети ПАО «Ростелеком», регион: "+resp.result.region}else{result="Данный номер не зарегистрирован в сети ПАО «Ростелеком»"}$("#test-phone-answer").html(result);$(".test-phone__respond-phone").html("8 ("+code+") "+phone);$(".test-phone__respond-true").slideDown(300).siblings().slideUp(300)}})});$(".test-phone__reset").on("click",function(){$(".test-phone__inputs").slideDown(300).siblings().slideUp(300);$("#test-phone2").val("");$("#test-phone").addClass("button-disabled").prop("disabled",true);$(window).trigger("affect-filters");return false})})();