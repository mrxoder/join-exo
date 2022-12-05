<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<meta name="viewport" content="width=device-width" />
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

if(!empty($_GET["message"])){ echo("<center><span>".htmlentities($_GET["message"])."</span></center>");}

session_start();
if(!empty($_SESSION["username"])){ header("location: profile.php");}

include("db.php");

if(!empty($_POST["user"]) && !empty($_POST["pass"])){

	$db = new sql();
	if($db->login($_POST["user"], $_POST["pass"])){
	   
	   $_SESSION["username"]  = $_POST["user"];
	   header("location: index.php");
	}else{
	   echo("<center><span>Failed, incorrect username or password</span></center>");
	}

}
?>

    <div class="container">
		<div class="row" id="ct">
			<div class="col-lg-4"></div>
			<div class="col-lg-6">
				<form action="" method="POST">
					<div><input name="user" type="text" placeholder="Username" required/></div>
					<div><input name="pass" type="password" placeholder="Password" required/></div>
				<div><input type="submit" value="Login"/> <a href="registration.php">SignUp</a></div>
				</form>
		</div></div>
	</div>
</body>

</html>
