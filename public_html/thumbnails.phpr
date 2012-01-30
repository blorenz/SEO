<?php 

function thumbnail($image_path,$thumb_path,$image_name)
{
    $orig_img = imagecreatefromjpeg("$image_path/$image_name");
    $width = imagesx($orig_img);
    $height = imagesy($orig_img);
    #$new_width = ($width/$height)*50;
    #$new_height = 50;
	
	$new_height = ($height/$width)*65;
	$new_width = 65;
	
	
    $new_img = imagecreatetruecolor($new_width,$new_height);
    imagecopyresized($new_img,$orig_img,0,0,0,0,$new_width,$new_height,imagesx($orig_img),imagesy($orig_img));

    imagejpeg($new_img, "$thumb_path/$image_name");
    return true;
}

$count = 1;

while ($count < 750) {
	thumbnail("auction/uploaded","auction/uploaded/thumbnails",$count.".jpg");
	echo "Image #$count<br>";
	$count++;
}

?>