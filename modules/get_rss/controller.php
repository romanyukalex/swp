<?php
 /**************************************************************\
  * Modulename	: get_rss	                      			 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: 
  * $rss_feed=insert_module('get_rss','get_feed',"$url_xml","$return_type"); 	  *
  *         $return_type: "array" | "object" | "json"           *
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){

	if ($contact=='get_feed'){# Требуется скачать feed
    if(isset($param[2])){

      $xmlstr = @file_get_contents($param[2]);
      if($xmlstr===false) $log->LogError('Error connect to RSS: '.$param[2]);
      $xml = new SimpleXMLElement($xmlstr);
      if($xml===false) $log->LogError('Error parse RSS: '.$rss);
      else{
        #Выводим
        if(isset($param[3])) $return_type=$param[3];
        else $return_type="array";
        if($return_type=="array"){ //Выводим массив
          foreach($xml->channel->item as $item) {
	          $return_var[]=array(
                'title'=>$item->title,
                'pubdate'=>$item->pubDate,
	              'decription'=>$item->description,
                'link'=>$item->link,
                'guid'=>$item->guid
            );
          }
         
      } elseif($return_type=="object"){
        $return_var=$xml->channel;
      } elseif($return_type=="json"){
         $return_var=json_encode($xml->channel); // погуглить object to json
      }
      return $return_var;
    }
		//$show_view='vendor';
		
	}
}
?>