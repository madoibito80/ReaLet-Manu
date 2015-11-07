<?php



include('./header.php');
include('./logo.php');




if(isset($_FILES['manuscript'])){



echo('<script type="text/javascript" src="./jquery-1.11.1.min.js"></script>

<script type="text/javascript">

window.onload=function(){

$(function(){

$("#loading").fadeOut();
$("#contents").delay(900).fadeIn();

});

//document.getElementById("loading").style.display = "none";
//document.getElementById("contents").style.display = "inline";

sess_num = document.getElementById("sess_num").value;



box_num = document.getElementById("box_num").value;


for(i=0;i<box_num;i+=1){

GetText(i);

}


}





function GetText(m){

var Ajax=new XMLHttpRequest();

Ajax.overrideMimeType("text/plain; charset=Shift_JIS");

Ajax.onreadystatechange = function(){

document.getElementById("a_"+m).value = this.responseText;
document.getElementById("b_"+m).value = this.responseText;

};

Ajax.open("GET","./text.php?sess_num="+sess_num+"&box_num="+m);

Ajax.send();

}




function Change(m){

	document.getElementById("a_"+m).value = "";
}


</script>



<div id="main">
<img src="./loading');


if(isset($_COOKIE['color']) && $_COOKIE['color'] == 'black'){

echo('2');

}else{

echo('1');

}


echo('.gif" id="loading" />

<div id="contents">');













if(! isset($_SESSION['project_id'])
 || ! file_exists(dirname(__FILE__).'/../data/projectD/'.$_SESSION['project_id'])){


Logo('Error');


exit('<br />プロジェクトにサインインしてからOCRをご利用下さい。<br />

<a href="./">戻る</a>

</div></div></body></html>');

}









if(strlen($_FILES['manuscript']['name']) == 0){


Logo('Error');


exit('<br />ファイルを選択して下さい。<br />

<a href="./">戻る</a>

</div></div></body></html>');

}






	$img_gd=@imagecreatefromjpeg($_FILES['manuscript']['tmp_name']);

if(! $img_gd){

	$img_gd=@imagecreatefromgif($_FILES['manuscript']['tmp_name']);
}

if(! $img_gd){

	$img_gd=@imagecreatefrompng($_FILES['manuscript']['tmp_name']);
}

if(! $img_gd){


Logo('Error');


exit('<br />JPEG,GIF,PNG以外のファイルには対応していません。<br />

<a href="./">戻る</a>

</div></div></body></html>');

}










Logo('Manuscript');



$width=imagesx($img_gd);
$height=imagesy($img_gd);

$img="";




for($y=0;$y<$height;$y++){

for($x=0;$x<$width;$x++){

$rgbi=imagecolorat($img_gd,$x,$y);
$rgba=imagecolorsforindex($img_gd,$rgbi);
$color=round(($rgba['red']+$rgba['green']+$rgba['blue'])/3);


if($color > 220){

	$color = 0;
}else{

	$color = 1;
}

$color=chr($color);

$img .= $color;

}

}





$manu_id = hash("md5",$img);
$dir = dirname(__FILE__).'/../data/images/'.$manu_id;
$path = $dir.'/'.$manu_id.'.rl';

@mkdir($dir);
file_put_contents($path,$img);


$command = dirname(__FILE__).'/../realet2/realet2.exe ';
$command .= $path.' ';
$command .= $width.' ';
$command .= $height.' ';
$command .= $dir;



ob_start();
passthru($command);
$res=ob_get_contents();
ob_end_clean();



$res = explode("\n",$res);

$manu_type = explode(":",$res[2]);
$box_num = $manu_type[0];


if(preg_match('/^T/',$manu_type[1]) === 1){

	$manu_type[1] = '縦';
}

if(preg_match('/^Y/',$manu_type[1]) === 1){

	$manu_type[1] = '横';
}

	echo($box_num.'字'.$manu_type[1]);
	echo('<input type="hidden" id="box_num" value="'.$box_num.'" />');



$sess_num = count($_SESSION['manu_ids']);
array_push($_SESSION['manu_ids'],$manu_id);









if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'H'){

echo('<form action="./put_memory.php" method="post"><input type="hidden" name="sess_num" value="');
echo($sess_num);
echo('" /><input type="hidden" name="box_num" value="');
echo($box_num);
echo('" /><br /><input type="submit" value="簡単学習モード" class="submit" /></form>');

}



echo('<form action="./alltext.php" method="post">
<input type="hidden" name="sess_num" id="sess_num" value="');

echo($sess_num);

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




echo('<tr>');

for($x=0;$x<20;$x++){

if($y*20+$x < $box_num){

echo('<td>');
echo('<input type="text" id="a_');
echo($y*20+$x);
echo('" name="a_');
echo($y*20+$x);
echo('" value="" class="char" onClick="Change(');
echo($y*20+$x);
echo(')" />
<input type="hidden" id="b_');
echo($y*20+$x);
echo('" name="b_');
echo($y*20+$x);
echo('" value="" />');
echo('</td>');

}

}


echo('</tr>');




if($y*20+$x >= $box_num){

	break;
}




}

echo('</table>


<input type="submit" value="NEXT" class="submit" />
</form>

</div></div></body></html>');



}else{



echo('<div id="main">');


Logo('ReaLet-Manu');


echo('<form action="./index.php" method="post" enctype="multipart/form-data">

<input type="file" name="manuscript" />
<input type="submit" value="START" class="submit" />

</form>

<div class="content">
&ensp;ReaLet-Manu(リーレット マニュ)は、スキャナで取り込んだ原稿用紙の画像を、ワープロソフト等で編集可能なテキストデータに、自動で変換するOCRサービスです。<br />
&ensp;このサービスを利用すれば、原稿用紙をパソコンに入力する際の&quot;1文字ずつタイプする煩わしさ&quot;から解放されます。<br />
&ensp;原稿用紙の画像を上のフォームから送信すれば、自動でテキストデータへの変換を開始します。</div>


<div class="text1">
<div class="text2">Step</div>
<ol>
<li>原稿用紙の画像を上のフォームから送信します。</li>
<li>原稿用紙の型を自動で認識し、表示します。</li>
<li>OCRエンジンが画像をテキストに変換していきます。</li>
<li>誤変換があった場合、あなたはリアルタイムに修正することができます。</li>
<li>原稿用紙の内容をまとめて表示します。</li>
</ol>
</div>



<div style="font-size:10px;margin-top:100px;">
原稿用紙は画像に対して水平にして下さい。
&emsp;画像に不要な線が含まれる場合、正しく認識出来ない場合があります。
&emsp;JavaScriptを有効にしてご利用ください。
<br /><br /><span class="copyright">(C)2014 ReiSato.</span>
</div>










</div>


</body>

</html>');



}



?>