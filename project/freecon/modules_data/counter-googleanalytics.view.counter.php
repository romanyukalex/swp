<? # Счетчик посещений от google
$log->LogInfo('Got '.(__FILE__));
if ($nitka=="1"){
/*
ga('create', 'UA-11111111-1', 'domain.com');
ga('require', 'linkid', 'linkid.js');
ga('send', 'pageview');
*/
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63226710-<?
  
  if($_SERVER['HTTP_HOST']=="psy-space.ru"){echo "3";}
  elseif($_SERVER['HTTP_HOST']=="soznanie.club"){echo "4";}?>', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>

<?} ?>