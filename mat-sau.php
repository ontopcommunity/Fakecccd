<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

function fetchUrlData($url) {
    if (ini_get('allow_url_fopen') == 1) {
        $data = @file_get_contents($url);
        if ($data !== FALSE) {
            return $data;
        }
    }

    if (!extension_loaded('curl')) {
        return FALSE;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200 && $data !== FALSE) {
        return $data;
    }
    return FALSE;
}

if(isset($_GET['name'])){
    $socccd = trim($_GET['socccd']);
    $name = trim($_GET['name']);
    
    if (function_exists('iconv')) {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    }
    $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
    $name = strtoupper($name);
    
    $birthday = trim($_GET['birthday']);
    $sex = trim($_GET['sex']);
    $quequan = trim($_GET['quequan']);
    $thuongtru = trim($_GET['thuongtru']);
    $ngaycap = trim($_GET['ngaycap']);
    
    if(empty($socccd) || empty($name) || empty($birthday) || empty($sex) || empty($quequan) || empty($thuongtru) || empty($ngaycap)){
        die("Missing required parameters.");
    }

function imagettftextSpWithEffects($image, $size, $angle, $x, $y, $text, $font, $textColor, $shadowColor, $shadowOffsetX, $shadowOffsetY, $outerGlowSize, $spacing = 0)
{
    $temp_image = imagecreatetruecolor(imagesx($image), imagesy($image));
    if ($temp_image === FALSE) return;

    $textColor = imagecolorallocatealpha($temp_image, $textColor[0], $textColor[1], $textColor[2], $textColor[3]);
    $shadowColor = imagecolorallocatealpha($temp_image, $shadowColor[0], $shadowColor[1], $shadowColor[2], $shadowColor[3]);

    $transparentColor = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
    imagefill($temp_image, 0, 0, $transparentColor);
    imagesavealpha($temp_image, true);

    if ($spacing == 0) {
        for ($i = 0; $i < $outerGlowSize; $i++) {
            imagettftext($temp_image, $size, $angle, $x + $shadowOffsetX, $y + $shadowOffsetY, $shadowColor, $font, $text);
        }
        imagettftext($temp_image, $size, $angle, $x, $y, $textColor, $font, $text);
    } else {
        $temp_x = $x;
        for ($i = 0; $i < mb_strlen($text, 'UTF-8'); $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            
            for ($j = 0; $j < $outerGlowSize; $j++) {
                imagettftext($temp_image, $size, $angle, $temp_x + $shadowOffsetX, $y + $shadowOffsetY, $shadowColor, $font, $char);
            }
            $bbox = imagettftext($temp_image, $size, $angle, $temp_x, $y, $textColor, $font, $char);
            
            if ($bbox === false) continue;
            $temp_x += $spacing + ($bbox[2] - $bbox[0]);
        }
    }

    imagecopy($image, $temp_image, 0, 0, 0, 0, imagesx($image), imagesy($image));

    imagedestroy($temp_image);
}

header('Content-type: image/jpeg');

$jpg_data = @file_get_contents('fsdf.png');
if ($jpg_data === FALSE) die("Error: Cannot load fsdf.png background image.");
$jpg_image = imagecreatefromstring($jpg_data);
if ($jpg_image === FALSE) die("Error: Invalid fsdf.png format.");

$white_image = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));
$whiteColor = imagecolorallocate($white_image, 255, 255, 255);
imagefill($white_image, 0, 0, $whiteColor);
imagecopy($jpg_image, $white_image, 0, 0, 0, 0, imagesx($white_image), imagesy($white_image));
imagedestroy($white_image);

$matsau_data = @file_get_contents('matsau.png');
if ($matsau_data === FALSE) die("Error: Cannot load matsau.png overlay image.");
$matsau_image = imagecreatefromstring($matsau_data);
if ($matsau_image === FALSE) die("Error: Invalid matsau.png format.");
imagecopy($jpg_image, $matsau_image, 0, 0, 0, 0, imagesx($matsau_image), imagesy($matsau_image));
imagedestroy($matsau_image);


$textColor = [0, 0, 0, 0];
$shadowColor = [0, 0, 0, 50];

imagettftextSpWithEffects($jpg_image, 20, 0, 845, 290, $ngaycap, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);

$name_for_mrz = str_replace(' ', '<', $name);

$check_digit1 = rand(0, 9);
$check_digit2 = rand(0, 9);

$dob_formatted = str_replace('/', '', $birthday);
$dob_yy = substr($dob_formatted, 2, 6);
if(strlen($dob_yy) != 6) {
    $dob_yy = date('ymd', strtotime(str_replace('/', '-', $birthday)));
}
$gender_mrz = ($sex == 'Nam') ? 'M' : 'F';
$expire_date_rand = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);


$mrz_line1 = 'IDVNM' . $socccd;
$mrz_line1 = str_pad($mrz_line1, 30, '<', STR_PAD_RIGHT);


$mrz_line2 = $dob_yy . $check_digit1 . $gender_mrz . $expire_date_rand . $check_digit2 . 'VNM';
$mrz_line2 = str_pad($mrz_line2, 30, '<', STR_PAD_RIGHT);


$name_part1 = substr($name_for_mrz, 0, 30);
$mrz_line3 = str_pad($name_part1, 30, '<', STR_PAD_RIGHT);


$start_y = 720;
$line_height = 55;

imagettftextSpWithEffects($jpg_image, 44, 0, 420, $start_y, $mrz_line1, 'font.ttf', $textColor, $shadowColor, 1, 1, 1, 0);

imagettftextSpWithEffects($jpg_image, 44, 0, 420, $start_y + $line_height, $mrz_line2, 'font.ttf', $textColor, $shadowColor, 1, 1, 1, 0);

imagettftextSpWithEffects($jpg_image, 44, 0, 420, $start_y + ($line_height * 2), $mrz_line3, 'font.ttf', $textColor, $shadowColor, 1, 1, 1, 0);


$overlay = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));
if ($overlay !== FALSE) {
    $black = imagecolorallocatealpha($overlay, 0, 0, 0, 100);
    imagefill($overlay, 0, 0, $black);
    imagecopymerge($jpg_image, $overlay, 0, 0, 0, 0, imagesx($overlay), imagesy($overlay), 5);
    imagedestroy($overlay);
}

imagejpeg($jpg_image);

imagedestroy($jpg_image);

}
?>