<? 
  /***************************************************************************************************************************
  * Snippet Name : Scripts and styles																						 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Вставляется в <head></head>, содержит стили и javascripts шаблона										 *
  * Insert		 : include_once('/templates/$currenttemplate/scripts_and_styles.php');										 *
  ***************************************************************************************************************************/ 
 ?><!-- This project scripts and styles-->
 <!-- Le styles -->
        <link href="project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/css_defa.css" media="" rel="stylesheet" type="text/css">
<link href="project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/madagask.css" media="screen" rel="stylesheet" type="text/css">
        <!-- Scripts -->
        <!--script type="text/javascript" src="project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/js_defau.js"></script-->
<? /*		
<!-- tracker retargeting-->
<script type="text/javascript">(function(){function c(){if(!g){g=!0;var d=a.createElement(e);d.type="text/java"+e;var b;b="?rnd="+(100*((new Date).getTime()%1E7)+h.round(99*h.random()));b+=a.referrer?"&r="+encodeURIComponent(a.referrer):"";b+="&t="+(new Date).getTime();"undefined"!==typeof __lx__target&&(b+="&trg="+encodeURIComponent(__lx__target));d.src="http://luxup.ru/rt/trd/291/"+b;"undefined"!=typeof d&&a.getElementsByTagName(e)[0].parentNode.appendChild(d)}}var j=379,g=!1,a=document,i=a.documentElement,h=Math,f=window,e="script";a.addEventListener?a.addEventListener("DOMContentLoaded",c,!1):a.attachEvent?(i.doScroll&&f==f.top&&function(){try{i.doScroll("left")}catch(a){setTimeout(arguments.callee,0);return}c()}(),a.attachEvent("onreadystatechange",function(){"complete"===a.readyState&&c()})):f.onload=c})();</script>
<!-- tracker retargeting-->
*/?>

        <!--[if IE]>
        <script type="text/javascript">
            document.createElement('article');
            document.createElement('aside');
            document.createElement('header');
            document.createElement('section');
            document.createElement('nav');
            document.createElement('menu');
            document.createElement('time');
            document.createElement('progress');
            document.createElement('footer');
        </script>
        <![endif]-->

        <!--[if lte IE 8]>
            <link rel="stylesheet" type="text/css" href="/css/ie8.css" />
        <![endif]-->
        <script>
    (function (w) {
        "use strict";
        w.BmUser = {
            isAuthorized: function () {
                return false;
            }
        }
    })(window);
</script>
<style type="text/css">
#photoframe img{
display: block; width:960px;
}
</style>