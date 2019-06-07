<?php
/* 
���������� ����� �������: 
crop_picture($file_input, $file_output, $crop = 'square',$percent = false);
��������� ������� � ��������($file_input) � ��������($file_output) ����, ���������� $crop, ������� ��������� ���������� �������, � �� ��������� �������� ���� �� ��������, �, ��� � � ������ �������, ���������� $percent, ������� ��������� �������� true ��� false.
*/
function crop_picture($file_input, $file_output, $crop = 'square',$percent = false) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		//echo '���������� �������� ����� � ������ �����������';
		$log->LogError("Cant get width and height of the picture");
		return;
    }
	$types = array('','gif','GIF','jpeg','JPEG','png','PNG','jpg','JPG');
	$ext = $types[$type];
	if ($ext) {
		$func = 'imagecreatefrom'.$ext;
		$img = $func($file_input);
	} else {
		//echo '������������ ������ �����';
		$log->LogError("File extention is incorrect");
		return;
	}
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	$log->LogDebug("Picture cropped");
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}?>