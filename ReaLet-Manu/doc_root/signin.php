<?php


include('./header.php');
include('./logo.php');


echo('<div id="main">');

Logo('Signin');





if(isset($_GET['project_id'])){



$project_id = $_GET['project_id'];

preg_match('/[a-z0-9]+/',$project_id,$res_array);


if($res_array[0] != $project_id){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
ProjectID���s���ł��B<br /><a href="./signin.php">�߂�</a>
</div>
</div>

</div></body></html>');

}





$dir = dirname(__FILE__).'/../data/projectD/'.$project_id;




if(!file_exists($dir)){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
�w�肳�ꂽ�v���W�F�N�g�͊��ɍ폜����܂����B<br /><a href="./signin.php">�߂�</a>
</div>
</div>

</div></body></html>');

}








$project_name = file_get_contents($dir.'/project_name.txt');
$text = file_get_contents($dir.'/text.txt');



echo('<div class="text1">
<div class="text2">'.$project_name.'</div>');

echo($text);

echo('</div>');








echo('<div class="text1"><div class="text2">Letters</div>');



$fp = @fopen($dir.'/E2/memory3.mmr','rb');


if($fp){


	fgetc($fp);

while(!feof($fp)){


	fgetc($fp);
	fgetc($fp);



	$letter = fgetc($fp);

for($i=0;$i<9;$i++){

	$letter .= fgetc($fp);
}

$letter = htmlspecialchars($letter,ENT_QUOTES,'Shift_JIS');

	echo('[');
	echo($letter);
	echo(']');



	fgetc($fp);

}

fclose($fp);



}//if fp


echo('</div>');







echo('<div class="text1"><div class="text2">Signin!</div>
<form action="./signin.php" method="post">
<table class="input">

<input type="hidden" name="project_id" value="');

echo($project_id);

echo('" />

<tr>
<td>AccessCode<br /><span style="font-size:10px;">(�쐬�҂Ƃ��ăT�C���C������ꍇ�̂ݓ���)</span></td>
<td><input type="password" name="access_code" class="text" /></td>
</tr>

<tr>
<td colspan="2" class="cent"><input type="submit" value="�T�C���C��" class="submit" /></td>
</tr>

</table>
</form>

</div>



</div></body></html>');




}elseif(isset($_POST['project_id']) && isset($_POST['access_code'])){


$project_id = $_POST['project_id'];



preg_match('/[a-z0-9]+/',$project_id,$res_array);


if($res_array[0] != $project_id){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
ProjectID���s���ł��B<br /><a href="./signin.php">�߂�</a>
</div>
</div>

</div></body></html>');

}




$dir = dirname(__FILE__).'/../data/projectD/'.$project_id;




if(!file_exists($dir)){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
�w�肳�ꂽ�v���W�F�N�g�͊��ɍ폜����܂����B<br /><a href="./signin.php">�߂�</a>
</div>
</div>

</div></body></html>');

}






$access_code = hash('md5',$_POST['access_code']);


$project_name = file_get_contents($dir.'/project_name.txt');


$_SESSION['project_id'] = $project_id;

$_SESSION['project_name'] = $project_name;





echo('<div class="text1">
<div class="text2">OK!</div>
<div class="cent">');



if(file_get_contents($dir.'/access_code.txt') == $access_code){

$_SESSION['user_type'] = 'H';
echo('�쐬��');

}else{

$_SESSION['user_type'] = 'R';
echo('���p��');

}


echo('�Ƃ��ăT�C���C�����܂����B<br /><a href="./index.php">�߂�</a>
</div>


</div></body></html>');






}else{


echo('<div class="text1">
<div class="text2">What is Signin?</div>
&ensp;�v���W�F�N�g�ɃT�C���C�����܂��B<br />
&ensp;�v���W�F�N�g�Ƃ́A����̏��̂�&quot;����&quot;���ꂽ�F���f�[�^�̂��Ƃł��B<br />
&ensp;���҂̍쐬�����v���W�F�N�g�ɗ��p�҂Ƃ��ăT�C���C������΁A��������OCR�𗘗p�o���܂��B
</div>
<div style="font-size:13px;text-align:left;">&emsp;(ProjectName���N���b�N���đI�����ĉ�����)</div><br />');




echo('<table style="width:700px;margin:0px auto;">
<tr>

<td class="project_index"><span class="project_index">ProjectName</span></td>
<td class="project_index"><span class="project_index">Text</span></td>
<td class="project_index"><span class="project_index">LetterNum</span></td>

</tr>');

$handle = opendir(dirname(__FILE__).'/../data/projectD/');

while( ($project_id=readdir($handle)) !== false ){

if($project_id != '.' && $project_id != '..'){

$dir = dirname(__FILE__).'/../data/projectD/'.$project_id;

$project_name = file_get_contents($dir.'/project_name.txt');

	echo('<tr><td class="project_index"><a href="./signin.php?project_id='.$project_id.'">'.$project_name.'</a></td><td class="project_index">');

$text = file_get_contents($dir.'/text.txt');

	echo($text);
	echo('</td><td class="project_index">');


$fp = @fopen($dir.'/E2/memory1.mmr',"rb");

if($fp){

$letter_num = ord(fgetc($fp))*256*256;
$letter_num += ord(fgetc($fp))*256;
$letter_num += ord(fgetc($fp));

fclose($fp);

}else{

$letter_num = 0;

}

	echo($letter_num);
	echo('</td></tr>');

}//if . ..

}//while

closedir($handle);

echo('</table>');




echo('</div></body></html>');



}




?>