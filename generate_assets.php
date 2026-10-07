<?php
$root = __DIR__ . '/assets/images';
if (!is_dir($root)) {
    mkdir($root, 0777, true);
}

$font = 'C:/Windows/Fonts/arial.ttf';

// Create click.jpg as a simple branded logo image
$logo = imagecreatetruecolor(1600, 900);
$bg = imagecolorallocate($logo, 15, 23, 42);
imagefilledrectangle($logo, 0, 0, 1600, 900, $bg);
$blue = imagecolorallocate($logo, 29, 78, 216);
$white = imagecolorallocate($logo, 255, 255, 255);
$dark = imagecolorallocate($logo, 17, 24, 39);
$light = imagecolorallocate($logo, 239, 246, 255);

imagefilledellipse($logo, 400, 430, 900, 430, $blue);
imagefilledellipse($logo, 1000, 430, 900, 430, $blue);

for ($x = 260; $x <= 900; $x += 130) {
    imagefilledrectangle($logo, $x, 250, $x + 45, 520, $dark);
}

imagefilledrectangle($logo, 450, 450, 920, 610, $blue);
imagefilledrectangle($logo, 540, 300, 860, 430, $blue);
imagefilledellipse($logo, 650, 650, 150, 150, $dark);
imagefilledellipse($logo, 650, 650, 70, 70, $blue);
imagefilledellipse($logo, 1040, 650, 150, 150, $dark);
imagefilledellipse($logo, 1040, 650, 70, 70, $blue);

$poly = [1020, 430, 1185, 385, 1210, 420, 1055, 485];
imagefilledpolygon($logo, $poly, 4, $light);
imageline($logo, 1120, 390, 1180, 290, $light);
imageline($logo, 1180, 390, 1240, 290, $light);
imageline($logo, 1240, 390, 1300, 290, $light);

imagettftext($logo, 165, 0, 250, 560, $white, $font, 'CLICK');
imagettftext($logo, 110, 0, 480, 730, $white, $font, 'SLICK');
imagejpeg($logo, $root . '/click.jpg', 92);
imagedestroy($logo);

// Create sample-pic.png as a stylized before/after detailing mockup
$sample = imagecreatetruecolor(1400, 900);
$bg2 = imagecolorallocate($sample, 15, 23, 42);
imagefilledrectangle($sample, 0, 0, 1400, 900, $bg2);
$blue2 = imagecolorallocate($sample, 31, 119, 194);
$dark2 = imagecolorallocate($sample, 8, 18, 32);
$white2 = imagecolorallocate($sample, 255, 255, 255);
$gray2 = imagecolorallocate($sample, 156, 170, 186);

imagefilledrectangle($sample, 0, 0, 1400, 900, $bg2);
imagefilledrectangle($sample, 200, 420, 1200, 700, $blue2);
imagefilledrectangle($sample, 430, 330, 980, 520, $blue2);
$window = imagecolorallocate($sample, 12, 32, 52);
imagefilledrectangle($sample, 560, 360, 820, 450, $window);
imagefilledrectangle($sample, 430, 450, 540, 560, $window);
imagefilledrectangle($sample, 860, 450, 970, 560, $window);

for ($x = 500; $x <= 900; $x += 400) {
    imagefilledellipse($sample, $x, 670, 120, 120, $dark2);
    imagefilledellipse($sample, $x, 670, 55, 55, $blue2);
}

imagefilledrectangle($sample, 1090, 470, 1170, 560, $white2);
imagefilledrectangle($sample, 1090, 560, 1170, 610, $white2);
imagettftext($sample, 48, 0, 120, 110, $white2, $font, 'BEFORE');
imagettftext($sample, 48, 0, 990, 110, $white2, $font, 'AFTER');
imagepng($sample, $root . '/sample-pic.png');
imagedestroy($sample);

if (file_exists($root . '/click.jpg') && file_exists($root . '/sample-pic.png')) {
    echo "ASSET_FILES_READY\n";
} else {
    echo "ASSET_FILES_MISSING\n";
}
