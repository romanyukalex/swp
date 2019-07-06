<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?151"></script>

<script type="text/javascript">
VK.init({apiId: <? 
if($_SERVER['HTTP_HOST']=="nlp-course.ru" or $_SERVER['HTTP_HOST']=="test.nlp-course.ru"){?>5956312<? }
elseif($_SERVER['HTTP_HOST']=="psy-space.ru" or $_SERVER['HTTP_HOST']=="www.psy-space.ru" ){?>6092689<?}?>, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "full"});
</script>