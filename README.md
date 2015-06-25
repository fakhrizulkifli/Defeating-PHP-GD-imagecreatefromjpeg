# Exploiting PHP-GD imagecreatefromgif() function
Proof-of-concept to exploit the flaw in the PHP-GD built-in function, imagecreatefromgif(). Inspired by one of Reddit's comment on my previous thread regarding exploiting the imagecreatefromgif() PHP-GD function.

This is the script to generate the payload

```PHP
<?php
$jpg = imagecreatefromjpeg('image.jpg');
imagejpeg($jpg, 'poc.jpg');
imagedestroy($jpg);
?>
```
>This is the hexadecimal dump for the image.jpg before the recreation. Nothing fancy here, just some junk and EXIF data.

![before](http://i.imgur.com/xPcyO6l.png "Before Recreation")

>So this is what happens after the recreation of JPEG file, all the EXIF data is removed and not much empty space where we can append the PHP backdoor. 

![after](http://i.imgur.com/ASiY6d8.png "After Recreation")

>However, there are several important parts in the JPEG file format which can be exploited.

![parts](http://i.imgur.com/il5fhAa.jpg "JPEG parts")

>So according to this JPEG file format, where would be the place to put the PHP backdoor?. Search for the Start of Scan (SOS) marker which is FF DA, as you can see there are Scan Header Length and Scan Header after the SOS marker. The place to be put PHP backdoor is right after the Scan Header (00  0C 03 01 00 02 11 03 11  00 3F 00).

![final](http://i.imgur.com/XjdniZ5.png "PHP backdoor")

>Run through the payload script again, and then the PHP backdoor will not get removed even after multiple times going through recreation process

```PHP
<?php
$jpg = imagecreatefromjpeg('poc.jpg');
imagejpeg($jpg, 'exploit.jpg');
imagedestroy($jpg);
?>
```
