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
ProjectNameは1文字~20文字にして下さい。<br /><a href="javascript:history.back();">やり直す</a>
</div>
</div>

</div></body></html>');

}


if(mb_strlen($_POST['access_code'],'Shift_JIS') < 6){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
AccessCodeが短過ぎます。6文字以上にして下さい。<br /><a href="javascript:history.back();">やり直す</a>
</div>
</div>

</div></body></html>');

}


if(file_exists($dir)){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
そのProjectNameは既に使用されています。<br /><a href="javascript:history.back();">やり直す</a>
</div>
</div>

</div></body></html>');

}


if(mb_strlen($_POST['text'],'Shift_JIS') > 180){

exit('<div class="text1">
<div class="text2">Miss!</div>
<div class="cent">
Textが長過ぎます。180字以内に収めて下さい。<br /><a href="javascript:history.back();">やり直す</a>
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
プロジェクトを作成しました。<br /><a href="./index.php">戻る</a>
</div>
</div>

</div></body></html>');



}else{


echo('<div class="text1">
<div class="text2">What is MakeProject?</div>
&ensp;プロジェクトを作成することで、OCRを自分の認識させたい書体に特化させることが出来ます。<br />
&ensp;ReaLet-Manuではプロジェクトの概念により、高速かつ正確な認識を実現しています。<br />
&ensp;作成者としてサインインした状態で誤認識を修正すれば、プロジェクトに認識データが追加されます。また、簡単学習モードを利用すれば、より素早くプロジェクトに認識データを追加することが出来ます。<br />
&ensp;あなたが作成したプロジェクトは、他のユーザーが利用者としてサインイン出来ます。
</div>





<div class="text1">
<div class="text2">Make Project!</div>
<form action="./make_project.php" method="post">
<table class="input">

<tr><td>ProjectName</td><td><input type="text" name="project_name" class="text" /></td></tr>

<tr><td>AccessCode</td><td><input type="password" name="access_code" class="text" /></td></tr>

<tr><td>Text(説明文)</td><td><textarea name="text" class="text" style="height:100px;"></textarea></td></tr>

<tr><td colspan="2" class="cent"><input type="submit" value="プロジェクト作成" class="submit" /></td></tr>

</table>
</form>
</div>


</div></body></html>');



}



?>