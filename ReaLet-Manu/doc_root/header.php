<?php

session_start();


if(! isset($_SESSION['manu_ids'])){

	$_SESSION['manu_ids'] = array();
}




set_time_limit(0);
ob_end_flush();
echo(str_repeat("\0",4*1024));
ob_implicit_flush(TRUE);



echo('<html lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />


<title>ReaLet-Manu</title>



<link rel="icon" href="./icon.png" type="image/vnd.microsoft.icon" />

<link rel="stylesheet" href="./style.css" type="text/css" />
<link rel="stylesheet" href="./color');

if(isset($_COOKIE['color']) && $_COOKIE['color'] == 'black'){

echo('2');

}else{

echo('1');

}


echo('.css" type="text/css" id="colorcss" />

</head>

<body>

<div class="header">

<a href="./index.php" class="header">OCR (Top)</a>');


if(isset($_SESSION['project_name'])){

echo('&emsp;[ ');
echo($_SESSION['project_name']);
echo(' ] に');

if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'H'){

echo('作成者');

}else{

echo('利用者');

}

echo('としてサインインしています。');

}

echo('&emsp;<a href="./signin.php" class="header">サインイン</a>&emsp;<a href="./make_project.php" class="header">プロジェクト作成</a>');
echo('&emsp;<input type="submit" value="Color" class="submit" style="width:100px;height:30px;" title="テーマ(色)が変わります" onClick="Color()" /></div>');












for($i=0;$i<20;$i++){

echo('<div class="background" id="background_');
echo($i);
echo('">ReaLet-Manu</div>');

}




echo('<script type="text/javascript">



for(i=0;i<20;i++){

document.getElementById("background_"+i).style.top = i*25 + "px";

left = Math.floor(Math.random() * 1300);
document.getElementById("background_"+i).style.left = left + "px";


if(i % 2 == 0){

	document.getElementById("background_"+i).style.color = "#AAAAAA";
}


}




function Color(){


cookies = document.cookie;


cookies = cookies.split(";");
num = cookies.length;

for(i=0;i<num;i++){

cookie = cookies[i];
cookie = cookie.split("=");

if(cookie[0].search("color") != -1){

	color = cookie[1];
	break;
}


}


if(typeof color === "undefined"){

	color = "white";
}




if(color == "white"){


document.cookie = "color=black;";
document.getElementById("colorcss").href = "./color2.css";

if(document.getElementById("loading")){

	document.getElementById("loading").src = "./loading2.gif";
}


}else if(color == "black"){


document.cookie = "color=white;";
document.getElementById("colorcss").href = "./color1.css";

if(document.getElementById("loading")){

	document.getElementById("loading").src = "./loading1.gif";
}


}


}



</script>');



?>