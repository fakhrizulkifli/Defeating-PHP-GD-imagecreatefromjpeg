<?php
/*
 Recreate the poc.jpg after embed the PHP backdoor
 */
$jpg = imagecreatefromjpeg('image.jpg');
imagejpeg($jpg, 'poc.jpg');
imagedestroy($jpg);
?>
