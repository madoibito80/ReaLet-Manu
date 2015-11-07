<?php


if(isset($_GET['sess_num']) && isset($_GET['box_num'])){



			//$start_time = microtime(TRUE);



session_start();


$sess_num = $_GET['sess_num'];


if(! isset($_SESSION['manu_ids'][$sess_num])){

exit();

}


$manu_id = $_SESSION['manu_ids'][$sess_num];
$box_num = $_GET['box_num'];




$letter_len = 0;
$letter_value = '?';









if(isset($_SESSION['project_id'])){




$project_id = $_SESSION['project_id'];







$command = dirname(__FILE__).'/../realet3/realet3.exe ';
$command .= dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$box_num.'.rl ';
$command .= '100 ';
$command .= '100 ';
$command .= dirname(__FILE__).'/../data/projectD/'.$project_id.'/E2';




ob_start();
passthru($command);
$res=ob_get_contents();
ob_end_clean();




$res=explode("\n",$res);




foreach($res as $line){

$line=explode(':',$line);

if(count($line) == 3){

if($line[1] > $letter_len){

	$letter_len = $line[1];
	$letter_value = $line[0];

}

}

}




}//if project_id






$letter_value = htmlspecialchars($letter_value,ENT_QUOTES,'Shift_JIS');

echo($letter_value);



			//file_put_contents('../data/time.log',microtime(TRUE)-$start_time,FILE_APPEND);
			//file_put_contents('../data/time.log',"\r\n",FILE_APPEND);



}




?>