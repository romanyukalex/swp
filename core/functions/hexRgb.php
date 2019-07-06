<? #   Перевод цвета из HEX в RGB и обратно 

/*
// Параметром для функции будет номер цвета
$rgb = hexToRgb('#fff000');
print_r($rgb);*/

function hexToRgb($hexvalue){
	
   if($hexvalue[0] == '#') {
                $hexvalue = substr( $hexvalue, 1);
        }
        if(strlen( $hexvalue ) == 6){
                list($r, $g, $b) = array($hexvalue[0] . $hexvalue[1], $hexvalue[2] . $hexvalue[3], $hexvalue[4] . $hexvalue[5]);
        }elseif (strlen($hexvalue) == 3) {
                list($r,$g,$b) = array($hexvalue[0] . $hexvalue[0], $hexvalue[1] . $hexvalue[1], $hexvalue[2] . $hexvalue[2]);
        }else{
                return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('R' => $r, 'G' => $g, 'B' => $b);
}


# перевод цвета из RGB в HEX
/*
$colorRgb = array(255, 0, 0);
$result = rgbToHex($colorRgb);
var_dump($result);*/
function rgbToHex($color) {
    $red = dechex($color[0]); 
    $green = dechex($color[1]);
    $blue = dechex($color[2]);
    return "#" . $red . $green . $blue;
}