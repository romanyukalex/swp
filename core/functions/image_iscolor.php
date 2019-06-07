<?php
  /*********************************************************\
  * Snippet Name : image_iscolor							*
  * Purpose		 : test if a Jpeg is greyscale or color 	*
  * Access		 : image_iscolor( $img )					*
  \*********************************************************/

$log->LogInfo('Got this file');

function image_iscolor($pic_adress){

    
// A Pixel is Greyscale if the r = B = G 
    //example: colorpixel R=250, G=140 , B=19  Greyscale Pixel R=110, G= 110, B=110 
    
    //we do a check of 10 Pixels to find out if the Picture is Greyscale
    $tocheck = 10;
    
    $iscolor=false;
    
    $temp= getimagesize($pic_adress);
    
    $x= $temp[0];
    $y= $temp[1];
    
    $im= imagecreatefromjpeg($pic_adress);

    //now check out the Pixels    
    for( $i = 0 ; $i< $tocheck && !$iscolor; $i++){
    
    
    // Here a Random Pixel is chosen
    $color = imagecolorat($im,rand(0,$x),rand(0,$y));
    
    //Problem color is an int
    //The Hex view on the number is RRGGBB
    // Here we get the blue part of the Pixel
    $blue = 0x0000ff & $color;
    
    $green = 0x00ff00 & $color;
   //The Green part we have to push 8 bits to the right to get an Compareable result 
    $green = $green >> 8;
    $red =0xff0000 & $color;
    //red part needs to be pushed 16 bit
    $red = $red >> 16;
    // if one of the Pixels isnt Greyscale it breaks an you know this is a color picture
    if( $red!= $green || $green!= $blue){
        $iscolor = true;
        break;
        }
    }
    return $iscolor;

}