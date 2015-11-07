<?php



include('./header.php');
include('./logo.php');


echo('<div id="main">');



if(isset($_POST['sess_num'])
 && isset($_POST['box_num'])
 && isset($_SESSION['manu_ids'][$_POST['sess_num']])
 && isset($_SESSION['user_type'])
 && $_SESSION['user_type'] == 'H'
 && isset($_SESSION['project_id'])){


$sess_num = $_POST['sess_num'];
$box_num = $_POST['box_num'];
$manu_id = $_SESSION['manu_ids'][$sess_num];


if(isset($_POST['text'])){


$text = $_POST['text'];

$text_num = mb_strlen($text,'Shift_JIS');


if($text_num > $box_num){

echo('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
入力されたテキストが画像と対応しません。<br />

<form action="./put_memory.php" method="post"><input type="hidden" name="sess_num" value="');
echo($sess_num);
echo('" /><input type="hidden" name="box_num" value="');
echo($box_num);
echo('" /><input type="submit" value="やり直す" class="submit" /></form>

</div>
</div>

</div></body></html>');

exit();

}




for($i=0;$i<$box_num;$i++){


if($i < $text_num){


$char = mb_substr($text,$i,1,'Shift_JIS');



$command = dirname(__FILE__).'/../realet3/realet3.exe ';
$command .= dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$i.'.rl ';
$command .= '100 ';
$command .= '100 ';
$command .= dirname(__FILE__).'/../data/projectD/'.$_SESSION['project_id'].'/E2 ';
$command .= $char;


ob_start();
passthru($command);
$res=ob_get_contents();
ob_end_clean();



$char = htmlspecialchars($char,ENT_QUOTES,'Shift_JIS');
echo('[');
echo($char);
echo(']');



}//if text_num


@unlink(dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$i.'.rl');



}//for box_num



@unlink(dirname(__FILE__).'/../data/images/'.$manu_id.'/'.$manu_id.'.rl');
@rmdir(dirname(__FILE__).'/../data/images/'.$manu_id);





echo('<div class="text1">
<div class="text2">OK!</div>
<div class="cent">');

	echo($text_num);

echo('個の認識データを追加しました。<br /><a href="./index.php">戻る</a>
</div>
</div>

</div></body></html>');




}else{


Logo('PutMemory');



echo('<script type="text/javascript" src="./jquery-1.11.1.min.js"></script>

<script type="text/javascript">

window.onload=function(){

$(function(){

$("#loading").fadeOut();
$("#contents").delay(900).fadeIn();

});

}

</script>




<img src="./loading');


if(isset($_COOKIE['color']) && $_COOKIE['color'] == 'black'){

echo('2');

}else{

echo('1');

}


echo('.gif" id="loading" />

<div id="contents">');




echo('<form action="./put_memory.php" method="post">
<input type="hidden" name="sess_num" id="sess_num" value="');
echo($sess_num);
echo('" /><input type="hidden" name="box_num" value="');
echo($box_num);
echo('" />

<table class="manu">');





for($y=0;;$y++){


echo('<tr>');



for($x=0;$x<20;$x++){

if($y*20+$x < $box_num){

echo('<td>');
echo('<img src="./image.php?sess_num=');
echo($sess_num);
echo('&box_num=');
echo($y*20+$x);
echo('" class="char" />');
echo('</td>');

}

}

echo('</tr>');



if($y*20+$x >= $box_num){

	break;
}



}


echo('</table>



<br />下の入力欄に、上の画像');
echo($box_num);
echo('個に対応する');
echo($box_num);
echo('字を入力して下さい。<br />
画像とテキストを対応させて、簡単に認識データを追加することが出来ます。

<br /><br />
<textarea name="text" style="width:600px;height:200px;"></textarea>
<br /><br />

<input type="submit" value="NEXT" class="submit" />
</form>

</div></div></body></html>');










}//else text


}else{



echo('<script type="text/javascript">location.href = "./index.php";</script>');



}


?>