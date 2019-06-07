<?php
	/*******************************************************************************************\
	* Snippet Name	: image_mask																*
	* Purpose		: Given an image $src and mask $mask, this applies the mask over the image	*
	* Access		: image_mask(&$src, &$mask)													*
	\*******************************************************************************************/

	//If your mask is reversed, change 127 - $mask_pix_color['alpha'] with just $mask_pix_color['alpha']
	
$log->LogInfo('Got this file');

function image_mask(&$src, &$mask) {
    imagesavealpha($src, true);
    imagealphablending($src, false);
    // scan image pixels
    for ($x = 0; $x < imagesx($src); $x++) {
        for ($y = 0; $y < imagesy($src); $y++) {
            $mask_pix = imagecolorat($mask,$x,$y);
            $mask_pix_color = imagecolorsforindex($mask, $mask_pix);
            if ($mask_pix_color['alpha'] < 127) {
                $src_pix = imagecolorat($src,$x,$y);
                $src_pix_array = imagecolorsforindex($src, $src_pix);
                imagesetpixel($src, $x, $y, imagecolorallocatealpha($src, $src_pix_array['red'], $src_pix_array['green'], $src_pix_array['blue'], 127 - $mask_pix_color['alpha']));
            }
        }
    }
}