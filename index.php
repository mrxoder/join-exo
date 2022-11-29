<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();
$user = $db->getUser($_SESSION["username"]);
$data = [];
if($user["role"]=="student"){
   $d = $db->getStudent($user["id"]);
   $data["mention"]=$d["mention"];
   $data["grade"]=$d["grade"];
}elseif($user["role"]=="prof"){
   $d = $db->getProf($user["id"]);
   $data["Teach"]=$d["course"];
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
	<div class="container" align="center">
	<div>Name: <?php echo(htmlentities($user["name"]));?></div>
	<div>Role: <?php echo(htmlentities($user["role"]));?></div>
	<div>
	<?php
	   foreach($data as $key => $value){
		   echo("<div>$key: $value</div>");
	   }
	   
	   if($user["role"]=="Not defined"){
	?>
	<div class="link">
	<a href="prof.php">Edit as Professor</a>
	<a href="student.php">Edit as Student</a></div>
	<?php
	 }elseif($user["role"]=="prof"){
	?>
	
	<a href="prof.php">Edit</a>
	
	
	<?php }elseif($user["role"]=="student"){ ?>
		<a href="student.php">Edit</a>
		
	<?php }?>
	<a href="logout.php">logout</a></div>
	</div>
</body>

</html>
