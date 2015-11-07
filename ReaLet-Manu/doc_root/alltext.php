<?php


include('./header.php');
include('./logo.php');


echo('<div id="main">');





Logo('AllText');


echo('<textarea style="width:70%;height:200px;">');





if(isset($_POST['sess_num'])){


	$sess_num = $_POST['sess_num'];


if(isset($_SESSION['manu_ids'][$sess_num])){

	$manu_id = $_SESSION['manu_ids'][$sess_num];

}


}






$max = 0;
$miss = 0;




for($i=0;isset($_POST['a_'.$i]) && isset($_POST['b_'.$i]);$i++){




	$max += 1;


if($_POST['a_'.$i] != $_POST['b_'.$i]){


	$miss += 1;


if(isset($_SESSION['project_id'])
 && isset($_SESSION['user_type'])
 && $_SESSION['user_type'] == 'H'
 && isset($manu_id)
 && file_exists(dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$manu_id.'.rl')){





$command = dirname(__FILE__).'/../realet3/realet3.exe ';
$command .= dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$i.'.rl ';
$command .= '100 ';
$command .= '100 ';
$command .= dirname(__FILE__).'/../data/projectD/'.$_SESSION['project_id'].'/E2 ';
$command .= $_POST['a_'.$i];


ob_start();
passthru($command);
$res=ob_get_contents();
ob_end_clean();




}//input memories


}//a != b



@unlink(dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$i.'.rl');





$str = htmlspecialchars($_POST['a_'.$i],ENT_QUOTES,'Shift_JIS');

echo($str);





}//for



@unlink(dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$manu_id.'.rl');
@rmdir(dirname(__FILE__).'/../data/images/'.$manu_id);




echo('</textarea>
<br />');

if($max == 0){

	$miss = 1;
}else{

	$miss = $miss/$max;
	$miss = 1-$miss;
}


echo(round($miss*100,2));
echo('%');

echo('<br />
<a href="./index.php"><input type="submit" value="FINISH" class="submit" /></a>
</div></body></html>');




?>