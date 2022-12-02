<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();
$user = $db->getUser($_SESSION["username"]);

if(empty($_SESSION["role"])){
   $_SESSION["role"] = $user["role"];
}

$data = [];
if($user["role"]=="student"){
	
   $data["Class"]=$user["class_name"];
   
}elseif($user["role"]=="prof"){
   
   $data["Teach"]=$user["course_name"];
   $data["Class"]=$user["class_name"];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Profile</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<style>
		.link a{
		  margin:1% 3% 0 0;
	   }
	</style>
</head>

<body>
	<div class="container">
	<div class="list-group" align="center">
	<div class="list-group-item ">Name: <?php echo(htmlentities($user["name"]));?></div>
	<div class="list-group-item ">Role: <?php echo(htmlentities($user["role"]));?></div>
	
	<?php
	   foreach($data as $key => $value){
		   if($key=="Class"){
			  echo("<div class='list-group-item '>$key:<a href='class.php?class=$value'>$value</a></div>");
		   }else{
		      echo("<div class='list-group-item '>$key: $value</div>");
		   }
	   }
	   
	   if($user["role"]=="Not defined"){
	?>
	<div class="list-group-item link">
	   <a href="prof.php">Edit as Professor</a>
	   <a href="student.php">Edit as Student</a>
	<?php
	 }elseif($user["role"]=="prof"){
	?>
	
	<div class="list-group-item link"><a href="prof.php">Edit</a>
	
	
	<?php }elseif($user["role"]=="student"){ ?>
		<div class="list-group-item link"><a href="student.php">Edit</a>
		
	<?php }?>
	<a href="logout.php">logout</a></div>
	</div>
</body>

</html>
