<?php

function LoadJpeg ($imgname)
{
    $im = @imagecreatefromjpeg($imgname);
    if (! $im) {
        $im = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }
    return $im;
}

header('Content-Type: image/jpeg');
$img = LoadJpeg('einzahlungsschein.jpg');
$black = imagecolorallocate($img, 0, 0, 0);
$font = './arial.ttf';

// The text to draw
$zweck1 = isset($_GET['z1']) ? $_GET['z1'] : 'Anlass';
$zweck2 = isset($_GET['z2']) ? $_GET['z2'] : 'ID';
$amount = isset($_GET['a']) ? $_GET['a'] : '0';

// Replace path by your own font path

// Add the text
imagettftext($img, 10, 0, 270, 70, $black, $font, $zweck1);
imagettftext($img, 10, 0, 270, 88, $black, $font, $zweck2);
imagettftext($img, 10, 0, 70, 252, $black, $font, $amount);

imagejpeg($img);
imagedestroy($img);