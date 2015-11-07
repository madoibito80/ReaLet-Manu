<?php



include('./header.php');
include('./logo.php');



echo('<div id="main">');

Logo('MakeProject');


if(isset($_POST['project_name']) && isset($_POST['access_code']) && isset($_POST['text'])){

$project_name = $_POST['project_name'];
$project_id = hash('md5',$project_name);
$project_name = htmlspecialchars($project_name,ENT_QUOTES,'Shift_JIS');
$access_code = hash('md5',$_POST['access_code']);
$text = $_POST['text'];
$text = htmlspecialchars($text,ENT_QUOTES,'Shift_JIS');

$dir = dirname(__FILE__).'/../data/projectD/'.$project_id;




if(mb_strlen($_POST['project_name'],'Shift_JIS') == 0 || mb_strlen($_POST['project_name'],'Shift_JIS') > 20){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
ProjectName��1����~20�����ɂ��ĉ������B<br /><a href="javascript:history.back();">��蒼��</a>
</div>
</div>

</div></body></html>');

}


if(mb_strlen($_POST['access_code'],'Shift_JIS') < 6){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
AccessCode���Z�߂��܂��B6�����ȏ�ɂ��ĉ������B<br /><a href="javascript:history.back();">��蒼��</a>
</div>
</div>

</div></body></html>');

}


if(file_exists($dir)){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
����ProjectName�͊��Ɏg�p����Ă��܂��B<br /><a href="javascript:history.back();">��蒼��</a>
</div>
</div>

</div></body></html>');

}


if(mb_strlen($_POST['text'],'Shift_JIS') > 180){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
Text�����߂��܂��B180���ȓ��Ɏ��߂ĉ������B<br /><a href="javascript:history.back();">��蒼��</a>
</div>
</div>

</div></body></html>');

}




@mkdir($dir);
file_put_contents($dir.'/project_name.txt',$project_name);
file_put_contents($dir.'/access_code.txt',$access_code);
file_put_contents($dir.'/text.txt',$text);
@mkdir($dir.'/E2');






$_SESSION['project_id'] = $project_id;

$_SESSION['project_name'] = $project_name;

$_SESSION['user_type'] = 'H';




echo('<div class="text1">
<div class="text2">OK!</div>
<div class="cent">
�v���W�F�N�g���쐬���܂����B<br /><a href="./index.php">�߂�</a>
</div>
</div>

</div></body></html>');



}else{


echo('<div class="text1">
<div class="text2">What is MakeProject?</div>
&ensp;�v���W�F�N�g���쐬���邱�ƂŁAOCR�������̔F�������������̂ɓ��������邱�Ƃ��o���܂��B<br />
&ensp;ReaLet-Manu�ł̓v���W�F�N�g�̊T�O�ɂ��A���������m�ȔF�����������Ă��܂��B<br />
&ensp;�쐬�҂Ƃ��ăT�C���C��������ԂŌ�F�����C������΁A�v���W�F�N�g�ɔF���f�[�^���ǉ�����܂��B�܂��A�ȒP�w�K���[�h�𗘗p����΁A���f�����v���W�F�N�g�ɔF���f�[�^��ǉ����邱�Ƃ��o���܂��B<br />
&ensp;���Ȃ����쐬�����v���W�F�N�g�́A���̃��[�U�[�����p�҂Ƃ��ăT�C���C���o���܂��B
</div>





<div class="text1">
<div class="text2">Make Project!</div>
<form action="./make_project.php" method="post">
<table class="input">

<tr><td>ProjectName</td><td><input type="text" name="project_name" class="text" /></td></tr>

<tr><td>AccessCode</td><td><input type="password" name="access_code" class="text" /></td></tr>

<tr><td>Text(������)</td><td><textarea name="text" class="text" style="height:100px;"></textarea></td></tr>

<tr><td colspan="2" class="cent"><input type="submit" value="�v���W�F�N�g�쐬" class="submit" /></td></tr>

</table>
</form>
</div>


</div></body></html>');



}



?>