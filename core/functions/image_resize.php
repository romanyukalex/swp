<?php
function image_resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		$log->LogError("Cant get width and height of the picture");
		//echo '���������� �������� ����� � ������ �����������';
		return;
        }
        $types = array('','gif','jpeg','png');
        $ext = $types[$type];
        if ($ext) {
    	        $func = 'imagecreatefrom'.$ext;
    	        $img = $func($file_input);
        } else {
    	        //echo '������������ ������ �����';
				$log->LogError("File extention is incorrect");
		return;
        }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}

	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);

	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	$log->LogDebug("Picture resized");	
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}
/*
* ������ �������� PNG � ����������� ������������
*
* $source � �������� �����������
* $path � ���� ��� ���������� ����� ��������
* $height � ����� ������
* $width � ����� ������
* $formatImg - ���������� ��������, ��� ����������.
*/
function resizePhotoPNG($source, $path, $height, $width, $formatImg = 'png'){
    $rgb = 0xffffff; //���� ������� ����
    $size = getimagesize($source);//������ ������� �������� ��������
    //���������� ��� (����������) ��������
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;   //����������� ������� ��� ���������� �����
    //���� ��� ����� �������, �� ���������� ������ �������
    if (!function_exists($icfunc)) return false;
    $x_ratio = $width / $size[0]; //��������� ������
    $y_ratio = $height / $size[1]; //��������� ������
    $ratio = min($x_ratio, $y_ratio);
    $use_x_ratio = ($x_ratio == $ratio); //����������� ������ � ������
    $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio); //������
    $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio); //������
    //����������� � ��������� ����������� �� ������
    $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
    //����������� � ��������� ����������� �� ������
    $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
    //������� ��������������� ����������� ���������������� ��������
    $img = imagecreatetruecolor($width, $height);
    // ������ ��� ����������
    imagealphablending($img, false); 
    imagesavealpha($img, true);
     
    $photo = $icfunc($source); //������� ��� ��������
    imagecopyresampled($img, $photo, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]); //�������� �� ���� �������� � ������ �����������
    $func = 'image'.$formatImg;
    $func($img, $path); //��������� ���������
    // ������� ������ ����� ���������� �������
    imagedestroy($img);
    imagedestroy($photo);
    // ������ ���� ��� ��������
    return $path;
}

?>