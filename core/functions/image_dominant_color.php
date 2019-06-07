<?php # Тестирование обеих функций дало отрицательный результат
$log->LogInfo('Got this file');
#255;32;11
function image_dominant_color($imagepath){
	$i = imagecreatefromjpeg($imagepath);
	
	for ($x=0;$x<imagesx($i);$x++) {
		
		for ($y=0;$y<imagesy($i);$y++) {
			
			$rgb = imagecolorat($i,$x,$y);
			$r   = ($rgb >> 16) & 0xFF;
			$g   = ($rgb >> 8) & 0xFF;
			$b   = $rgb & 0xFF;

			$rTotal += $r;
			$gTotal += $g;
			$bTotal += $b;
			$total++;
			
		}
	}

	$rAverage = round($rTotal/$total);
	$gAverage = round($gTotal/$total);
	$bAverage = round($bTotal/$total);
	global $log;
    $log->LogDebug("Image_dominant_color is ".$rAverage.";".$gAverage.";".$bAverage);
	return $rAverage.";".$gAverage.";".$bAverage;
	
}
#HEX
function average_color($img) {
    $w = imagesx($img);
    $h = imagesy($img);
    $r = $g = $b = 0;
    for($y = 0; $y < $h; $y++) {
        for($x = 0; $x < $w; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r += $rgb >> 16;
            $g += $rgb >> 8 & 255;
            $b += $rgb & 255;
        }
    }
    $pxls = $w * $h;
    $r = dechex(round($r / $pxls));
    $g = dechex(round($g / $pxls));
    $b = dechex(round($b / $pxls));
    if(strlen($r) < 2) {
        $r = 0 . $r;
    }
    if(strlen($g) < 2) {
        $g = 0 . $g;
    }
    if(strlen($b) < 2) {
        $b = 0 . $b;
    }
    return "#" . $r . $g . $b;
}



?>