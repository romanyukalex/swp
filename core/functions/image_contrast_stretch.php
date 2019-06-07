<?php
  /*************************************************************************\
  * Snippet Name : image_contrast_stretch									*
  * Purpose		 : histogram-stretching function to get a better contrast	*
  * Access		 : image_contrast_stretch( $img )							*
  \*************************************************************************/

$log->LogInfo('Got this file');

function image_contrast_stretch( $img ) {
    $x = imagesx($img);
    $y = imagesy($img);

    $min=255.0;
    $max=0.0;

    for($i=0; $i<$y; $i++) {
		for($j=0; $j<$x; $j++) {
			$pos = imagecolorat($img, $j, $i);
			$f = imagecolorsforindex($img, $pos);
			$gst = $f["red"]*0.15 + $f["green"]*0.5 + $f["blue"]*0.35;
			if($gst>$max) $max=$gst;
			if($gst<$min) $min=$gst;
		}
    }

    $distance = $max-$min;

    for($i=0; $i<$y; $i++) {
		for($j=0; $j<$x; $j++) {
			$pos = imagecolorat($img, $j, $i);
			$f = imagecolorsforindex($img, $pos);

			$red = 255*($f["red"]-$min)/$distance;
			$green = 255*($f["green"]-$min)/$distance;
			$blue = 255*($f["blue"]-$min)/$distance;

			if($red<0) $red = 0.0;
			elseif($red>255) $red=255.0;

			if($green<0) $green = 0.0;
			elseif($green>255) $green=255.0;

			if($blue<0) $blue = 0.0;
			elseif($blue>255) $blue=255.0;

			$color = imagecolorresolve($img, $red, $green, $blue);
			imagesetpixel($img, $j, $i, $color);
		}
    }
}

/*
//Вариация
function contrast($im) {
    $brightness=0;
    $maxb=0;
    $minb=255;
    $imagesize=getimagesize($im);
    $w=$imagesize[0];
    $h=$imagesize[1];
    for ($x=0; $x<$w; $x++) {
        for ($y=0; $y<$h; $y++) {
            $rgb=imagecolorat($im, $x, $y);
            $rgb=imagecolorsforindex($im, $rgb);
            $grey=0.2125*$rgb['red']+
                0.7154*$rgb['green']+
                0.0721*$rgb['blue']; 
            $brightness+=$grey;
            if ($grey>$maxb) $maxb=$grey;
            if ($grey<$minb) $minb=$grey;
        }
    }
    $brightness=$brightness/($w*$h);
    $minb=$brightness/($brightness-$minb);
    $maxb=(255-$brightness)/($maxb-$brightness);
    $contrast=min($minb, $maxb);
    for ($x=0; $x<$w; $x++) {
        for ($y=0; $y<$h; $y++) {
            $rgb=imagecolorat($im, $x, $y);
            $rgb=imagecolorsforindex($im, $rgb);
            imagesetpixel($im, $x, $y,
                65536*floor(min($rgb['red']*$contrast, 255))+
                256*floor(min($rgb['green']*$contrast, 255))+
                floor(min($rgb['blue']*$contrast, 255)));
        }
    }
    return ($im);
}
?>

An example of usage might be:
<?php
$imagefile="/path/filename";
$image=imagecreatefromjpeg($imagefile);
$image=contrast($image);
imagejpeg($image, $imagefile);

*/