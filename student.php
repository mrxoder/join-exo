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
$name = ($db->getUser($_SESSION["username"]))["name"];

if(!empty($_POST["mention"]) && !empty($_POST["grade"]) && !empty($_POST["name"])){
	$newname = "";
	if($name!=$_POST["name"]){ $newname = $_POST["name"];}
	if($db->newstudent($_SESSION["username"], $_POST["grade"], $_POST["mention"], $newname)){
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
		  <label>Mention: </label>
		  <select name="mention">
			<option value="Computer Science">Computer Science</option>
			<option value="Biology">Biology</option>
			<option value="mention2">mention2</option>
			<option value="mention3">mention3</option>
			<option value="mention4">mention4</option>
			<option value="mention5">mention5</option>
		  </select></div>
		  <div>
			 <label>Grade: </label>
		  <select name="grade">
			<option value="L1">L1</option>
			<option value="L2">L2</option>
			<option value="L3">L3</option>
			<option value="M1">M1</option>
			<option value="M2">M2</option>
			<option value="etc">etc</option>
		  </select></div>
		  
		<input type="submit" value="Save"/>
	</form>
	</div>
</body>
</html>
