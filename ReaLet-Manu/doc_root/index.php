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


exit('<br />�v���W�F�N�g�ɃT�C���C�����Ă���OCR�������p�������B<br />

<a href="./">�߂�</a>

</div></div></body></html>');

}









if(strlen($_FILES['manuscript']['name']) == 0){


Logo('Error');


exit('<br />�t�@�C����I�����ĉ������B<br />

<a href="./">�߂�</a>

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


exit('<br />JPEG,GIF,PNG�ȊO�̃t�@�C���ɂ͑Ή����Ă��܂���B<br />

<a href="./">�߂�</a>

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

	$manu_type[1] = '�c';
}

if(preg_match('/^Y/',$manu_type[1]) === 1){

	$manu_type[1] = '��';
}

	echo($box_num.'��'.$manu_type[1]);
	echo('<input type="hidden" id="box_num" value="'.$box_num.'" />');



$sess_num = count($_SESSION['manu_ids']);
array_push($_SESSION['manu_ids'],$manu_id);









if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'H'){

echo('<form action="./put_memory.php" method="post"><input type="hidden" name="sess_num" value="');
echo($sess_num);
echo('" /><input type="hidden" name="box_num" value="');
echo($box_num);
echo('" /><br /><input type="submit" value="�ȒP�w�K���[�h" class="submit" /></form>');

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
&ensp;ReaLet-Manu(���[���b�g �}�j��)�́A�X�L���i�Ŏ�荞�񂾌��e�p���̉摜���A���[�v���\�t�g���ŕҏW�\�ȃe�L�X�g�f�[�^�ɁA�����ŕϊ�����OCR�T�[�r�X�ł��B<br />
&ensp;���̃T�[�r�X�𗘗p����΁A���e�p�����p�\�R���ɓ��͂���ۂ�&quot;1�������^�C�v����ς킵��&quot;����������܂��B<br />
&ensp;���e�p���̉摜����̃t�H�[�����瑗�M����΁A�����Ńe�L�X�g�f�[�^�ւ̕ϊ����J�n���܂��B</div>


<div class="text1">
<div class="text2">Step</div>
<ol>
<li>���e�p���̉摜����̃t�H�[�����瑗�M���܂��B</li>
<li>���e�p���̌^�������ŔF�����A�\�����܂��B</li>
<li>OCR�G���W�����摜���e�L�X�g�ɕϊ����Ă����܂��B</li>
<li>��ϊ����������ꍇ�A���Ȃ��̓��A���^�C���ɏC�����邱�Ƃ��ł��܂��B</li>
<li>���e�p���̓��e���܂Ƃ߂ĕ\�����܂��B</li>
</ol>
</div>



<div style="font-size:10px;margin-top:100px;">
���e�p���͉摜�ɑ΂��Đ����ɂ��ĉ������B
&emsp;�摜�ɕs�v�Ȑ����܂܂��ꍇ�A�������F���o���Ȃ��ꍇ������܂��B
&emsp;JavaScript��L���ɂ��Ă����p���������B
<br /><br /><span class="copyright">(C)2014 ReiSato.</span>
</div>










</div>


</body>

</html>');



}



?>