<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<style>
	   #ct{
		  margin:3% 0 0 0;
	   }
	   input{
		  margin:1% 0 0 0;
	   }
	</style>
</head>

<body>
	

<?php

include("db.php");

if(!empty($_POST["user"]) && !empty($_POST["pass"]) && !empty($_POST["name"]) && !empty($_POST["retype"]) ){

	$db = new sql();
	if($_POST["pass"]==$_POST["retype"]){
		if($db->newuser($_POST["user"], $_POST["pass"], $_POST["name"])){
		   header("location: login.php?message=Account is created successfully.");
		}else{
		   echo("<span >Failed.</span>");
		}
    }else{
		echo("<span>password confirmation doesn't match.</span>");
    }

}

?>

<body>
	<div class="container">
	<div class="row" id="ct">
	<div class="col-lg-4"></div>
	<div class="col-lg-6">
	<form action="" method="POST">
		<div><input name="name" type="text" placeholder="Name"/></div>
		<div><input name="user" type="text" placeholder="username"/></div>
		<div><input name="pass" type="password" placeholder="password"/></div>
		<div><input name="retype" type="password" placeholder="retype password"/></div>
		
		<div><input type="submit" value="SignUp"/> <a href="login.php">Login</a></div>
	</form></div>
	</div>
</body>
</html>
