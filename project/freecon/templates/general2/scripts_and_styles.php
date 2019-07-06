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

<meta name="theme-color" content="#0aa4bb"> 
<link rel="icon" sizes="192x192" href="/project/freecon/files/soznanie.club.logo.192x192.png">

<? if(!$ampreq){?>
 <!--  styles -->

<link href="/project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/css_defa.css" media="" rel="stylesheet" type="text/css">
<link href="/project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/main_style.css" media="screen" rel="stylesheet" type="text/css">

<? }?>
        <!-- Scripts -->
        <!--script type="text/javascript" src="/project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/js_defau.js"></script-->
<script type="text/javascript" src="/project/<?=$projectname?>/templates/<?=$sitetemplate?>/files/mzs00000.js"></script>
 <!-- Scripts -->
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
      
      <!--script type="text/javascript">
            window.qbaka||function(e,t){var n=[];var r=e.qbaka=function(){n.push(arguments)};e.__qbaka_eh=e.onerror;e.onerror=function(){r("onerror",arguments);if(e.__qbaka_eh)try{e.__qbaka_eh.apply(e,arguments)}catch(t){}};e.onerror.qbaka=1;r.sv=2;r._=n;r.log=function(){r("log",arguments)};r.report=function(){r("report",arguments,new Error)};var i=t.createElement("script"),s=t.getElementsByTagName("script")[0],o=function(){s.parentNode.insertBefore(i,s)};i.type="text/javascript";i.async=!0;i.src=("https:"==t.location.protocol?"https:":"http:")+"//qbaka.r.worldssl.net/reporting.js";typeof i.async=="undefined"&&t.addEventListener?t.addEventListener("DOMContentLoaded",o):o();r.key="52bbb92211176c063b817eff0e784f04"}(window,document);qbaka.options={autoStacktrace:1,trackEvents:1};
        </script-->
<?if($_SERVER['HTTP_HOST']=="psy-space.ru"){?>
<!-- Google реклама в scripts and styles-->                
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-4339474268663783",
    enable_page_level_ads: true
  });
</script>
<? }?>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'deakSQw09e';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->