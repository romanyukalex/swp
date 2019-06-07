<?php
 /**************************************************************************\
  * Snippet Name : modulename		           					 			*
  * Part		 : view (view)												*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : do something								 				*
  * Access		 : 															*
  * insert_module('modulename','get_some',$get_detail_arr)					*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){?>
<style>
#vk_community_messages{
	position: inherit;
}
</style>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", <?=$vk_group_id?>, {expanded: "1",tooltipButtonText: "Есть вопрос?"});
$("#vk_community_messages").css("position", "inherit");
</script>
<? }?>