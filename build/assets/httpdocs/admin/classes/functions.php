<?php
function imgCopyAndResize($path_from, $path_to, $x_scale=0, $y_scale=0)
{
	$check = @GetImageSize($path_from);
	$width = $check[0];
	$height = $check[1];
	$mime = $check[2];

	$factor = $width/$height;

	$y=@floor($x_scale/$factor);
	if(($y>$y_scale) && ($y_scale!=0)) $x_scale=@floor($y_scale*$factor);
	else $y_scale=$y;

	if (function_exists("imagejpeg")) 		ImageJPEG(ShowThumb($path_from, $x_scale, $y_scale, $width, $height, $mime),$path_to, 100);
	else die("Ten serwer nie obs³uguje funkcji graficznych w PHP");
}

function LoadImage($imgname, $mime, $width, $height) 
{
	switch($mime)
	{
		case 1:
		$im = @ImageCreateFromGif($imgname);
		break;
		
		case 2:
		$im = @ImageCreateFromJpeg($imgname);
        break;
		
		case 3:
		$im = @ImageCreateFromPng($imgname);
		break;
		
		case 6:
		$im = @ImageCreateFromWBMP($imgname);
		break;
		
		
		default:
		$im = false;
		break;
	}

	if (!$im)
	{
		$im = ImageCreate($width, $height);
		$bgc = ImageColorAllocate ($im, 255, 255, 255);
		$tc = ImageColorAllocate ($im, 0, 0, 0);
		ImageString($im, 2, 2, 2, "B³¹d: $imgname", $tc);
		ImageString($im, 2, 2, 15, "Brak pliku!", $tc);
	}

	return $im;
}

function ShowThumb($imgname, $x_scale, $y_scale, $width, $height, $mime) 
{
	$thumb = ImageCreateTrueColor($x_scale,$y_scale);
	ImageCopyResampled($thumb, LoadImage($imgname, $mime, $width, $height), 0, 0, 0, 0,	$x_scale, $y_scale, $width, $height);
	return $thumb;
}
?>