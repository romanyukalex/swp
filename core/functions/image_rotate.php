<?php
/*
* ������� �������� �� �������� ����
*
* $img - ���� � ��������
* $degree - ���� ��������
* $path - ���� ��� ���������� ��������
* $formatImg - ���������� ��������, ��� ����������.
*/
function image_rotate($img, $degree, $path, $formatImg = 'jpeg'){
    // �������� ������ � ��������
    $size = getimagesize($img);
    //���������� ��� (����������) ��������
    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;   //����������� ������� ��� ���������� �����
    //���� ��� ����� �������, �� ���������� ������ �������
    if (!function_exists($icfunc)) return false;        
    // �������� �����������
    $source = $icfunc($img);
    // �������. ������ ���� �������� ������ 0xffffff
    $rotate = imagerotate($source, $degree, '0xffffff');
    // ��������� ��������
    $func = 'image'.$formatImg;
    $func($rotate, $path, 100);
    // ������� ������
    imagedestroy($rotate);
    // ���������� ���� � ����� ��������
    return $path;
}
/*
* ������� PNG �������� �� �������� ����
*
* @var string $img - ��������
* @var string $degree - ���� ��������
* @var string $path - ���� ��� ���������� ��������
*
* @return string $path - ���� � ����� ��������
*/
function rotatePhotoPNG($img, $degree, $path){
    // ��������� ��������
    $simage = imagecreatefrompng($img); 
    // ������ �� ������������
    imagealphablending($simage, true); 
    imagesavealpha($simage, true); 
    // ������� ���������� ���
    $bg = imagecolorallocatealpha($simage, 0, 0, 0, 127); 
    // ������� �� ������ ����
    $rotate = imagerotate($simage, $degree, $bg); 
    // ������ ������������ ��� ���������� ��������
    imagealphablending($rotate, true); 
    imagesavealpha($rotate, true);      
    // ��������� ���������
    imagepng($rotate, $path);
    // ������� ������
    imagedestroy($rotate);
    // ���������� ���� � ����� ��������
    return $path;
}
?>