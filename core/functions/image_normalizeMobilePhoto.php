<?php
/*
// �������� ����� �� ��, ��� ��� ������� � ���������� ����������
// ��������� ���������� ����� � ���� ����� ������ ������, �� ������� ����� ��������� ����

������� ������ �������������:

$size = getSizePhotoMobile($source);//������ ������� �������� ��������
// ���� ��� ���� ������� � ���������� ��������
if($size['degree'] > 0){
    $photo = rotatePhotoMobile($source, $size['degree']);
}else{
    // ��� ��� ������� �����
}
*/



function getSizePhotoMobile($file_name){
        // �������� EXIF-���������
    $exif_read_data = @exif_read_data($file_name);
    $size = @getimagesize($file_name);
    $width = $size[0];
    $height = $size[1];
    $degree = 0;
        // ���� ��������� ��������, � ����� ��� ������� ���������� �� ����������
    if($exif_read_data){
        if(isset($exif_read_data["Orientation"]) AND $exif_read_data["Orientation"] > 4){                    
            $size = getimagesize($file_name, $info);
            $width = $size[1];
            $height = $size[0];     
            switch ($exif_read_data["Orientation"]){
                case 5:
                    $degree = 270;
                    break;
                case 6:
                    $degree = 270;
                    break;
                case 7:
                    $degree = 90;
                    break;
                case 8:
                    $degree = 90;
                    break;                      
            }
        }
    }
    return array(
        0 => $width,
        1 => $height,
        'degree' => $degree
    );
}

function rotatePhotoMobile($img, $degree){
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
    $rotate = imagerotate($source, $degree, '0xd72630');
    return $rotate;
}
?>