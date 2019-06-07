<? 
/*
$book_info_p=parse_torrent_name($books_info['name']);
$bookauthor=$book_info_p['author'];
$bookname=$book_info_p['title'];
$book_attr=$book_info_p['tor_attr'];
$torrent_name=$book_info_p['torrent_name'];
*/
function parse_torrent_name($torrent_name){
		global $log;
		$sqspos=mb_stripos($torrent_name,'['); //Первая квадр скобка
		$log->LogInfo("Position of first square is ".$sqspos);
		
		if($sqspos==0){//С начала идёт что то в скобках, отрезаем все что до ] или определяем, что это журнал
			$sqpos2=mb_stripos($torrent_name,']');
			if(mb_substr($torrent_name,0,$sqpos2)=="[Журнал") {
				$torrent_type="journal";
				$torrent_name=mb_substr($torrent_name,$sqpos2+1);
			} 
			else $torrent_name=mb_substr($torrent_name,$sqpos2); //Отрезали всё, что между первыми []
			$log->LogDebug("Now torrent name is ".$torrent_name);
			$sqspos=mb_stripos($torrent_name,'['); //Первая квадр скобка
		}
		
		if(mb_substr($torrent_name,0,6)=="Журнал"){
			$torrent_type="journal";
		}
		
		if($torrent_type=="journal"){
			//$torrent_name=mb_substr($torrent_name,$sqpos2+1);
			$bookauthor="Журнал";
			$bookname=mb_substr($torrent_name,0,$sqspos);
		} else {
		
			$tirepos=mb_stripos($torrent_name,' - '); //Первое тире
			$tire_count=substr_count ($torrent_name,' - '); // Количество тире в названии
			
			if($tire_count==1){
				$bookauthor=mb_substr($torrent_name,0,$tirepos);
				if($sqspos) $bookname=mb_substr($torrent_name,$tirepos+3,$sqspos);
				else  $bookname=mb_substr($torrent_name,$tirepos+3);
			} elseif($tire_count>1){
				$tirepos2=mb_stripos($torrent_name,' - ',($tirepos+3));
				$bookauthor_lenght=$tirepos2-$tirepos-3;
				$bookauthor=mb_substr($torrent_name,($tirepos+3),$bookauthor_lenght);
				$bookname=mb_substr($torrent_name,$tirepos2+3,$sqspos);
			}
			
			
		}
		if($bn_rr=stripos($bookname,'[')) $bookname=substr($bookname,0,$bn_rr);
			
			
		$sqs2pos=mb_stripos($torrent_name,']'); //2я квадр скобка
		$book_attr=substr(mb_substr($torrent_name,($sqspos+1),($sqs2pos-1)),0,-1);
		if($bn_rt=stripos($book_attr,']')) $book_attr=substr($book_attr,0,$bn_rt);
		
		return array(
			'tor_attr'=> $book_attr,
			'title'=>$bookname,
			'author'=>$bookauthor,
			'torrent_name' => $torrent_name
		);
	}?>