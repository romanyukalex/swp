<?php
 /***************************************************************************************************************
  * Snippet Name : colorize_image  (покрасить картинку)															*
  * Access		 :																								*
  * image_colorize($_SERVER['DOCUMENT_ROOT']."/Diamond256.png",$_SERVER['DOCUMENT_ROOT']."/green.png",0,255,0);	*
  ***************************************************************************************************************/
  $log->LogInfo('Got this file');

function image_colorize($path_src_image,$path_out_image, $red, $green, $blue){
     $im = imagecreatefrompng($path_src_image);
    $pixel = array();
        
    $n_im = imagecreatetruecolor(imagesx($im),imagesy($im));
    $fond = imagecolorallocatealpha($n_im, 255, 255, 255, 0);
    imagefill($n_im, 0, 0, $fond);
    
    for($y=0;$y<imagesy($n_im);$y++)
    {
        for($x=0;$x<imagesx($n_im);$x++)
        {
            $rgb = imagecolorat($im, $x, $y);            
            $pixel = imagecolorsforindex($im, $rgb);
            
            $r = min(round($red*$pixel['red']/169),255);
            $g = min(round($green*$pixel['green']/169),255);
            $b = min(round($blue*$pixel['blue']/169),255);
            $a = $pixel['alpha'];            
            
            $pixelcolor = imagecolorallocatealpha($n_im, $r, $g, $b, $a);
            
            imagealphablending($n_im, TRUE);
            imagesetpixel($n_im, $x, $y, $pixelcolor);
        }
    }
    
   imagepng($n_im,$path_out_image);
   imagedestroy($n_im);
}
# Сделать черно-белую картинку из цветной
 function makeGrayPic($filename, $resultName){
      // получаем размеры исходного изображения
      $imgSize = getimagesize($filename);
      $width = $imgSize[0];
      $height = $imgSize[1];
      // создаем новое изображение
      $img = imageCreate($width,$height);
      // задаем серую палитру для нового изображения
      for ($color = 0; $color <= 255; $color++) {
        imageColorAllocate($img, $color, $color, $color);
      }
      // создаем изображение из исходного
      $img2 = imageCreateFromJpeg($filename);
      // объединяем исходное изображение и серое
      imageCopyMerge($img,$img2,0,0,0,0, $width, $height, 100);
      // сохраняем изображение
      imagejpeg($img, $resultName);
      // очищаем память
      imagedestroy($img);
    }
    // пример использования 
//    makeGrayPic('test.jpg', 'testGray.jpg');
?>