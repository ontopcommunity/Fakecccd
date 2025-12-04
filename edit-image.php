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
    $birthday = trim($_GET['birthday']);
    $sex = trim($_GET['sex']);
    $quequan = trim($_GET['quequan']);
    $thuongtru = trim($_GET['thuongtru']);
    $ngaycap = trim($_GET['ngaycap']);
    $anhthe_url = trim($_GET['anhthe']);

    if(empty($socccd) || empty($name) || empty($birthday) || empty($sex) || empty($quequan) || empty($thuongtru) || empty($ngaycap) || empty($anhthe_url)){
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

$anhthe_data = fetchUrlData($anhthe_url);
if ($anhthe_data === FALSE) die("Error: Cannot fetch photo data from URL. Check cURL/allow_url_fopen.");
$anhthe = imagecreatefromstring($anhthe_data);
if ($anhthe === FALSE) die("Error: Photo data is corrupted or not a valid image format.");


$qr_image_url = 'https://quickchart.io/qr?text='.urlencode($socccd.'||'.$name.'|'.str_replace('/','',$birthday).'|'.$sex.'|'.$thuongtru.'|'.str_replace('/','',$ngaycap)).'&light=0000&ecLevel=Q&format=png&size=170';
$qr_data = fetchUrlData($qr_image_url);
if ($qr_data === FALSE) die("Error: Cannot fetch QR code data.");
$qr_image = imagecreatefromstring($qr_data);
if ($qr_image === FALSE) die("Error: QR code data is corrupted.");

$mattruoc_data = @file_get_contents('mattruoc.png');
if ($mattruoc_data === FALSE) die("Error: Cannot load mattruoc.png overlay image.");
$mattruoc_image = imagecreatefromstring($mattruoc_data);
if ($mattruoc_image === FALSE) die("Error: Invalid mattruoc.png format.");
imagecopy($jpg_image, $mattruoc_image, 0, 0, 0, 0, imagesx($mattruoc_image), imagesy($mattruoc_image));
imagedestroy($mattruoc_image);

$textColor = [0, 0, 0, 0];
$shadowColor = [0, 0, 0, 50];

imagettftextSpWithEffects($jpg_image, 40, 0, 845, 535, $socccd, 'SVN-Arial 3 bold.ttf', $textColor, $shadowColor, 0, 0, 2, 0);
imagettftextSpWithEffects($jpg_image, 31, 0, 725, 630, mb_strtoupper($name, 'UTF-8'), 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 28, 0, 1060, 670, $birthday, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 28, 0, 935, 715, $sex, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 28, 0, 1340, 722, 'Việt Nam', 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 28, 0, 725, 810, $quequan, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 28, 0, 725, 900, $thuongtru, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 1, 1, 1, 0);
imagettftextSpWithEffects($jpg_image, 18, 0, 555, 875, $ngaycap, 'SVN-Arial Regular.ttf', $textColor, $shadowColor, 0, 0, 1, 0);

$overlay = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));
if ($overlay !== FALSE) {
    $black = imagecolorallocatealpha($overlay, 0, 0, 0, 100);
    imagefill($overlay, 0, 0, $black);
    imagecopymerge($jpg_image, $overlay, 0, 0, 0, 0, imagesx($overlay), imagesy($overlay), 5);
    imagedestroy($overlay);
}

imagecopy($jpg_image, $qr_image, 1360, 200, 0, 0, imagesx($qr_image), imagesy($qr_image));


$desiredWidth = 295;
$desiredHeight = 405;

$adjustedImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
if ($adjustedImage === FALSE) die("Error creating adjusted image resource for photo.");

$transparentColor = imagecolorallocatealpha($adjustedImage, 0, 0, 0, 127);
imagefill($adjustedImage, 0, 0, $transparentColor);
imagesavealpha($adjustedImage, true);

$sourceWidth = imagesx($anhthe);
$sourceHeight = imagesy($anhthe);
$sourceAspectRatio = $sourceWidth / $sourceHeight;
$desiredAspectRatio = $desiredWidth / $desiredHeight;

$cropX = 0; $cropY = 0;
$cropWidth = $sourceWidth; $cropHeight = $sourceHeight;

if ($sourceAspectRatio > $desiredAspectRatio) {
    $cropWidth = $sourceHeight * $desiredAspectRatio;
    $cropX = ($sourceWidth - $cropWidth) / 2;
} else {
    $cropHeight = $sourceWidth / $desiredAspectRatio;
    $cropY = ($sourceHeight - $cropHeight) / 2;
}

imagecopyresampled($adjustedImage, $anhthe, 0, 0, $cropX, $cropY, $desiredWidth, $desiredHeight, $cropWidth, $cropHeight);

$blackOverlay = imagecreatetruecolor($desiredWidth, $desiredHeight);
if ($blackOverlay !== FALSE) {
    $black = imagecolorallocatealpha($blackOverlay, 0, 0, 0, 100);
    imagefill($blackOverlay, 0, 0, $black);
    imagecopymerge($adjustedImage, $blackOverlay, 0, 0, 0, 0, $desiredWidth, $desiredHeight, 20); 
    imagedestroy($blackOverlay);
}


$blurredImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
imagecopy($blurredImage, $adjustedImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight);

$blurAmount = 10;
$blurImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
imagefilledrectangle($blurImage, 0, 0, $desiredWidth, $desiredHeight, imagecolorallocate($blurImage, 255, 255, 255));
imagecopymerge($blurImage, $blurredImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, 100 - $blurAmount);

imagecopy($jpg_image, $blurImage, 400, 430, 0, 0, $desiredWidth, $desiredHeight);

imagedestroy($blurredImage);
imagedestroy($blurImage);
imagedestroy($adjustedImage);

imagejpeg($jpg_image);

imagedestroy($jpg_image);
imagedestroy($qr_image);
imagedestroy($anhthe);

}
?>