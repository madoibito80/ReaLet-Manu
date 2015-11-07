<?php


if(isset($_GET['sess_num']) && isset($_GET['box_num'])){


session_start();



$width=100;
$height=100;

$img_gd=imagecreatetruecolor($width,$height);




$white=imagecolorallocate($img_gd,255,255,255);
$black=imagecolorallocate($img_gd,0,0,0);


$sess_num=$_GET['sess_num'];
$box_num=$_GET['box_num'];


if(! isset($_SESSION['manu_ids'][$sess_num])){

exit();

}


$manu_id = $_SESSION['manu_ids'][$sess_num];



$fp=fopen("../data/images/".$manu_id.'/'.$box_num.'.rl',"rb");



if(! $fp){

exit();

}


for($y=0;$y<$height;$y++){

for($x=0;$x<$width;$x++){

$p=ord(fgetc($fp));

if($p == 0){

imagesetpixel($img_gd,$x,$y,$white);

}else{

imagesetpixel($img_gd,$x,$y,$black);

}


}

}




fclose($fp);





header('Content-Type: image/png');
imagepng($img_gd);





}

?>