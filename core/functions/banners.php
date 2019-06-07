<?
$log->LogInfo("Got ".(__FILE__));
/*

CREATE TABLE `freecon-banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT;
  `banner_codename` varchar(50) DEFAULT NULL,
  `img` text NOT NULL COMMENT 'Img path inside /project/PN/',
  `text_1` text,
  `text_2` text,
  `link` text NOT NULL,
  `a_title` text,
  `keywords` text,
  `page` text,
  `regions` int(11) DEFAULT NULL,
  `status` enum('en','dis','test') NOT NULL DEFAULT 'en' COMMENT 'Status of banner',
  `viewCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of banner display',
  PRIMARY_KEY (`banner_id`),
  UNIQUE KEY `banner_codename`
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Banners on the site';



$banner = new swpbanner(3,"param1"); 



$banner->add_kw("Мужчина;ребенок");//Добавляем ключевые слова
$banner->add_kw("Женщина");


$banner->add_page($page);//Добавляем страничку на которой мы сейчас

$banner->add_region($city);//Добавляем регион смотрящего

$banner->filter(3);//Подготовь вот столько баннеров по всем параметрам
echo $banner->get_banner(1,"banner_id");
echo $banner->get_banner(2,"a_title");

#Реальный пример
if($banner->get_banner(1,"banner_id")){
	?><div class="vp_block col-md-10" style="padding:0px;background-color:#fff;margin:0 0 15px 0">
	<a target="_blank" class="justlink" href="<?=$banner->get_banner(1,"link")?>"<? if($banner->get_banner(1,'a_title')){?>title="<?=$banner->get_banner(1,'a_title')?>"<?}?>>
	<b style="font-size:14px"><?=$banner->get_banner(1,'text_1')?></b><br>
	<img src="<?=$banner->get_banner(1,'img')?>" style="width: 100%;padding 5px;">
	<span style="font-size:12px"><?=$banner->get_banner(1,'text_2')?></span>
	</a>
	</div>
<? }

*/



class swpbanner{
	
	
	 
	public function __construct(){
		global $tableprefix;
		#Получаем все баннеры в статусе en
		$this->banners_q=mysql_query("SELECT * FROM `$tableprefix-banners` WHERE `status` = 'en' and (`expired`> NOW() or `expired` is NULL) order by rand();");
		
	}
	
	public function print_choosen(){
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
	public function add_region($region_id){ //Регионом может быть как id города, так и региона или страны
		$this->region=$region_id;
	}
	public function dont_count_view(){
		$this->dont_count_view=1;
	}
	public function filter($banner_need_count){ #Фильтровка баннеров, выбрать вот такое количество
		
		while($banner=mysql_fetch_assoc($this->banners_q)){
			
			
			#Проверим соотв на страницу
			if(mb_strstr($banner['page'],";")){ //Баннер прикреплён к нескольким страницам
				$banner_pages=explode(";",$banner['page']);
				foreach($banner_pages as $banner_page){
					if($banner_page==$this->page){
				
						$banner_weight[$banner['banner_id']]++; //Увеличили вес баннера
				
					}
				}
			}
			elseif($banner['page']==$this->page){ //Баннер прикреплён лишь к одной странице или ни к одной
				
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
		if(!$this->banner_shown[$banner_id]){
			global $tableprefix;
			//Впервые в этой страничке показывают какое то поле данного баннера, надо обновить счетчик баннера
			if ($this->dont_count_view!==1) mysql_query("UPDATE `$tableprefix-banners` SET `viewCount` = `viewCount` + 1 WHERE `banner_id`='".$banner_id."';");
			$this->banner_shown[$banner_id]=1;
		}

		mysql_data_seek($this->banners_q,0);
		while($banner=mysql_fetch_assoc($this->banners_q)){
			if($banner['banner_id']==$banner_id){//Да, это тот самый баннер, выводим нужное поле
				return $banner[$banner_field];
				break;
			}
		}
	}
	
}?> 