var biz_datacenter_servrent_init=function(){var $wrap=$(".js-biz-datacenter");var $inputs=$wrap.find(".js-biz-datacenter-toogle-var-tarrif").find("input");$inputs.on("change",function(){var thisName=$(this).attr("name");$inputs.filter(function(){return $(this).attr("name")==thisName}).each(function(){$wrap.find("#"+$(this).data("href")).addClass("none-elem").hide(0)});$wrap.find("#"+$(this).data("href")).fadeIn(200).removeClass("none-elem")});var calcDomainChkBx=$wrap.find(".js-biz-datacenter-calc-domain");if(calcDomainChkBx.length){var calcDomainTarget=$wrap.find(".js-biz-datacenter-calc-domain-target");calcDomainChkBx.on("change",function(e){var summ=0;calcDomainChkBx.filter(":checked").each(function(){summ+=$(this).data("calc")});calcDomainTarget.text(summ)})}var calcHostChkBx=$wrap.find(".js-biz-datacenter-host");if(calcHostChkBx.length){var calcHostTarget=$wrap.find(".js-biz-datacenter-host-target");calcHostTarget.text(calcHostChkBx.filter(":checked").data("calc"));calcHostChkBx.on("change",function(e){calcHostTarget.text(calcHostChkBx.filter(":checked").data("calc"))})}};$(window).on("load",function(){biz_datacenter_servrent_init()});