<? 

class Vkapi { 



  //global $vkapi_access_token;
   
   protected $_access_token = '930733f82f6a29fabfddf7b5d7e9ea03492da3ebb7b84f351117be814834e86462d7e7915f631060762ed'; 

    public static function factory () 
    { 
        $class = get_class(); 
        return new $class; 
    } 

    public function method ($method, array $params = array(), $as_array = FALSE) 
    { 
        if ( ! $params) { 
            $params = array(); 
        } 

        $url = 'https://api.vk.com/method/'.$method.'?'; 

        if (count($params) > 0) 
        { 
            foreach ($params AS $key => $value) 
            { 
                $url .= $key.'='.$value.'&'; 
            } 
        } 

        $url     .= 'access_token='.$this->_access_token; 
        $content  = file_get_contents($url); 
        $result   = json_decode($content, (bool) $as_array); 
        $result   = ( (bool) $as_array) ? $result['response'] : $result->response; 

        if ($result === NULL) { 
            throw new Exception('Some error with VK API'); 
        } 

        return $result; 
    } 
    protected $_client_id = номер; 
    protected $_client_secret = '';     
} 

$resp = VkApi::factory()->method('wall.get', array(     'owner_id' => '-1672480',    'count' => 10,    'filter' => 'owner')); 
 
//echo "<pre>";  print_r($resp); echo "</pre>"; 

insert_function("file_search_in");
 
 foreach ($resp as $vkpost){
	 //print_r($vkpost);
	 echo "Проверяем ID ".$vkpost->id;
	
	if(! file_search_in($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/102lastVkPubId.txt',$vkpost->id) and $vkpost->id) {
		//Надо постить данный пост
		
		 print_r($vkpost);
		if( $vkpost->copy_text) $tg_text=$vkpost->copy_text;
		$tg_text.=$vkpost->text;
		
		#Приклады
		if($vkpost-> attachment) {
			//if($vkpost-> attachment->type=="photo") $tg_post[$vkpost->id] += [ 'image'=>$vkpost->attachment->photo->src ];
			if($vkpost-> attachment->type=="link") $tg_text.="\n".$vkpost->attachment->link->url;
			
		}
		
		
		#Меняем [|] на ссылки
		$vk_text_arr=explode("[",$tg_text);
		if(count($vk_text_arr>1)){
			$tg_text=$vk_text_arr[0];

			$n=1;
			foreach($vk_text_arr as $vk_text_part){
				if($n!==1){
				$vk_text_arr2=explode("]",$vk_text_part); //слева будет ссылка, справа просто текст
				#Побиваем левую часть на |, чтобы отделить ссылку от текста ссылки
				$link_arr=explode("|",$vk_text_arr2[0]);
				$tg_text.= $link_arr[1]." (https://vk.com/".$link_arr[0].")";
				$tg_text.=$vk_text_arr2[1];
				} else $n=2;
			}
		}
		$tg_text=str_replace("<br>","\n",$tg_text);
		$tg_post[$vkpost->id]=array( 'text'=>$tg_text);
		
		if($vkpost-> attachment) {
			if($vkpost-> attachment->type=="photo") $tg_post[$vkpost->id] += [ 'image'=>$vkpost->attachment->photo->src ];
			elseif($vkpost-> attachment->type=="link" and $vkpost-> attachment->link->image_src) $tg_post[$vkpost->id] += [ 'image'=>$vkpost-> attachment->link->image_src ];
			
		}
	 }
	unset($tg_text,$vk_text_arr,$vk_text_arr2,$link_arr);
//	print_r($tg_post);
	 
	 //$vkpost_text= $vkpost->text;
	 echo "<hr>";
 }
 if($tg_post){
	 
	include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/telegram_sendMessage102rec.php'); //Подключаем библиотеку
	
	#Записать ID последней публикации в файл
 
	foreach($tg_post as $key=>$tg_post_arr){

		// Пишем id поста в файл
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/102lastVkPubId.txt', "\r\n".$key,FILE_APPEND);
	}
 } else $log->LogInfo ("102 rec. No new posts on wall in VK");
?>