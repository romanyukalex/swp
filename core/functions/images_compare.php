<?php
	/***********************************************************************************************************\
	* Snippet Name	: images_compare																			*
	* Purpose		: test if a Jpeg is greyscale or color 														*
	* Access		: images_compare($start, $finish, $color, $display, $type)									*
	* image-url($start) - base image URL																		*
	* image-url($finish) - compare image URL																	*
	* array($color) - array with keys "r", "g", "b" r being RED 0-255 g being GREEN 0-255 b being BLUE 0-255	*
	* bool($display) - 1 OR TRUE will return text stats from compare											*
	* int($type) - 1 OR 0 | 1 being % results | 0 being pixel results											*
	\***********************************************************************************************************/

$log->LogInfo('Got this file');

function images_compare($start, $finish, $color, $display, $type){

$im = ImageCreateFrompng($start);
$im2 = ImageCreateFrompng($finish);
$img['x'] = imagesx($im);
$img['y'] = imagesy($im);
$img2['x'] = imagesx($im2);
$img2['y'] = imagesy($im2);
if(($img['x'] == $img2['x']) && ($img['y'] == $img2['y'])){

//get and set image hieght and width
$i = array("width" =>  $img['x']*2, "height" => $img['y']);
$im3 = imagecreatetruecolor($i['width'], $i['height']);
if($color){ 
$color = imagecolorallocate($im3, $color['r'], $color['g'], $color['b']);
}else{

$color = imagecolorallocate($im3, 255, 255, 255);
}
for($y = $img['y'];$y > 0; $y--){
for($x = $img['x'];$x > 0; $x--){
if(ImageColorAt($im, $x, $y) == ImageColorAt($im2, $x, $y)){
$on = $on+1;
$rgb = ImageColorAt($im, $x, $y);
Imagesetpixel($im3, $img['x']+$x, $y, $rgb);
}else{
$off = $off+1;
imagesetpixel($im3, $img['x']+$x, $y , $color);
}
}
}
if($display == true){
if(($type == "1") || (!$type)){
$off2 = (round(($off / $on)*10));
if(($off2 == 0) && ($off > 0)){
$off2 = round(($off / $on)*10)*10;
}
$on2 = (100-$off2);
$off2 .="%";
$on2 .="%";
}else{
$off2 = $off;
$on2 = $on;
}
echo $off2 ." off<br>". $on2 ." on";
}else{
imagecopy($im3, $im, 0, 0, 0, 0, $img['x'], $img['y']);
@header("Content-type: image/png");
imagepng($im3);
imagedestroy($im3);
}
imagedestroy($im);
imagedestroy($im2);
return TRUE;
}else{
return False;
}
}