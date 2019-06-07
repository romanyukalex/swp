<?php
 /***********************************************************
  * Snippet Name : image_maketransparent					*
  * Purpose		 : making images with white bg transparent	*
  * Access		 :											*
  * $image='abc/abc.jpg';									*
  * $src = imagecreatefromjpeg($image);						*
  * $src=image_maketransparent($src); 						*
  **********************************************************/
  $log->LogInfo('Got this file');

function image_maketransparent($src){
$r1=80;
$g1=80;
$b1=80;
for($x = 0; $x < imagesx($src); ++$x)	{
		for($y = 0; $y < imagesy($src); ++$y)
		{
			$color=imagecolorat($src, $x, $y);
			$r = ($color >> 16) & 0xFF;
			$g = ($color >> 8) & 0xFF;
			$b = $color & 0xFF;
			for($i=0;$i<270;$i++){
				if($r.$g.$b==($r1+$i).($g1+$i).($b1+$i)){
					$trans_colour = imagecolorallocatealpha($src, 0, 0, 0, 127);
					imagefill($src, $x, $y, $trans_colour);
				}
			}
		}
	}

	return $src;
}