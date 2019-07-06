<? if ($nitka=="1"){
$log->LogInfo("Got ".(__FILE__));
/*

$banner = new swpbanner(3,"param1"); 



$banner->add_kw("Мужчина;ребенок");//Добавляем ключевые слова
$banner->add_kw("Женщина");


$banner->add_page($page);//Добавляем страничку на которой мы сейчас

$banner->add_region($city);//Добавляем регион смотрящего

$banner->filter(3);//Подготовь вот столько баннеров по всем параметрам
echo $banner->get_banner(1,"banner_id");
echo $banner->get_banner(2,"a_title");

if($banner->get_banner(1,"banner_id")){		
	?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff;margin:0 0 15px 0">
	<a target="_blank" class="justlink" href="<?=$banner->get_banner(1,"link")?>"<? if($banner->get_banner(1,'a_title')){?>title="<?=$banner->get_banner(1,'a_title')?>"<?}?>>
<?}
*/



class swpbanner{
	
	
	 
	public function __construct(){
		global $tableprefix;
		#Получаем все баннеры в статусе en
		$this->banners_q=mysql_query("SELECT * FROM `$tableprefix-banners` WHERE `status` = 'en' order by rand();");

	}
	
	public function print_result(){
		var_export($this->banners_q);
	}
	
	public function add_kw($kw){
		$kw_arr=explode(";",$kw);
		
		foreach ($kw_arr as $kw){

			$this->keywords[]=$kw;
		}

	}
	public function add_page($page){
		$this->page=$page;
	}
	public function add_region($city){
		$this->city=$city;
	}
	
	public function filter($banner_need_count){ #Фильтровка баннеров, выбрать вот такое количество
		
		while($banner=mysql_fetch_assoc($this->banners_q)){
			
			#Проверим соотв на страницу
			if($banner['page']==$this->page){
				
				$banner_weight[$banner['banner_id']]++; //Увеличили вес баннера
				
			}

			#Проверим на соотв.ключевым словам
			if($this->keywords and $banner['keywords']){

				foreach ($this->keywords as $kw){
					if(mb_strstr(mb_strtolower($banner['keywords']), mb_strtolower($kw))){
				
						$banner_weight[$banner['banner_id']]++; //Увеличили вес баннера
					
					}
				
				}
			}
			

		}
		#Отсортируем баннеры по весу
		arsort($banner_weight);
		
		
		print_r($banner_weight);
		
		if (count($banner_weight)<$banner_need_count) {#Если выбрали баннеров меньше чем надо
			
			//Не хватает выбранных баннеров, просили больше, добавляем рандомно
			mysql_data_seek($this->banners_q,0);
			while($banner=mysql_fetch_assoc($this->banners_q)){
				if(!$banner_weight[$banner['banner_id']]){//Этот баннер не был выбран по параметрам
					$banner_weight[$banner['banner_id']]=1; //Добавили его в список отобранных баннеров
				}
				//Пересчитываем количество баннеров
				if (count($banner_weight)>=$banner_need_count) {break;}
			}
		}
		$num=0;
		foreach($banner_weight as $bannerid=>$banner_weight){
			$num++;
			//echo $bannerid." ".$banner_weight."<br>";
			$this->choosen_banner[$num]=$bannerid;
		}
		
		
	}
	public function get_banner($banner_num,$banner_field){

		#Получаем ID баннера, номер которого просят
		$banner_id=$this->choosen_banner[$banner_num];
		if(!$banner_shown[$banner_id]){
			global $tableprefix;
			//Впервые в этой страничке показывают какое то поле данного баннера, надо обновить счетчик баннера
			mysql_query("UPDATE `$tableprefix-banners` SET `viewCount` = `viewCount` + 1 WHERE `banner_id`='".$banner_id."';");
			$banner_shown[$banner_id]=1;
		}

		mysql_data_seek($this->banners_q,0);
		while($banner=mysql_fetch_assoc($this->banners_q)){
			if($banner['banner_id']==$banner_id){//Да, это тот самый баннер, выводим нужное поле
				return $banner[$banner_field];
				break;
			}
		}
	}
	
}










}?> 