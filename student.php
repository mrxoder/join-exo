<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Student Profile</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
</head>

<body>


<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();

$userinfo = $db->getUser($_SESSION["username"]);
if($userinfo["role"]=="prof"){ header("location: index.php");}
$name = $userinfo["name"];

$classes = $db->getclass();


if(!empty($_POST["class"]) && !empty($_POST["name"])){
	
	$newname = "";
	if($name!=$_POST["name"]){ $newname = $_POST["name"];}
	
	if($db->newstudent($_SESSION["username"], $_POST["class"], $newname)){
	   header("location: index.php");
	}else{
	   echo("<span>Failed to save student profile.</span>");
	}
}




?>
	<div id="wrapper" align="center">
	
	<form action="" method="POST">
		<span>Name:<input name="name" type="text" value="<?php echo(htmlentities($name));?>" /></span>
		<div>
		  <label>Classes: </label>
		  <select name="class">
			<?php
			  foreach($classes as $item){
				  
				  echo("<option value='{$item["class_name"]}'>{$item["class_name"]}</option>");
			  }
			?>
		  </select></div>
		
		  
		<input type="submit" value="Save"/>
	</form>
	</div>
</body>
</html>
