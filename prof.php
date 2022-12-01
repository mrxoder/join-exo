<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Edit Prof profile</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	
	<style>
	   .form{
		  margin:3% 0 0 3%;
	   }
	</style>
</head>

<body>


<?php


session_start();

include("db.php");

if(empty($_SESSION["username"])){ header("location: login.php");}

$db = new sql();
$userinfo = $db->getUser($_SESSION["username"]);
if($userinfo["role"]=="student"){ header("location: index.php");}
$name = $userinfo["name"];


if(!empty($_POST["class"]) && !empty($_POST["course"]) && !empty($_POST["name"])){
	$newname = "";
	if($name!=$_POST["name"]){ $newname=$_POST["name"];}
	if($db->newprof($_POST["class"], $_POST["course"], $_SESSION["username"], $newname) ){
	   header("location: index.php");
	}else{
	   echo("<span>Failed to save Prof profile.</span>");
	}
}

$classes = $db->getclass();
$courses = $db->getcourses();

?>
	<div class="container" align="center">
	
	<form action="" method="POST" class="form">
		<div class="row">Name:<input name="name" type="text" value="<?php echo(htmlentities($name));?>" /></div>
	
		<div class="row">
		  <label>Class : </label>
		  <select name="class">
			<?php
			  foreach($classes as $item){
				  echo("<option value='{$item["class_name"]}'>{$item["class_name"]}</option>");
			  }
			?>			
		  </select>
		</div>
		
		<div class="row">
		  <label>Teach: </label>
		  <select name="course">
			<?php
			  foreach($courses as $item){
				  echo("<option value='{$item["course_name"]}'>{$item["course_name"]}</option>");
			  }
			?>
		  </select></div>
		
		<div class="row">  
		<input type="submit" value="Save"/></div>
	</form>
	</div>
</body>
</html>
