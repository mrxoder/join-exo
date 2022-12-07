<?php

  if($_SERVER["SERVER_ADDR"] != $_SERVER["REMOTE_ADDR"]){
	 
?>	 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Access Denied</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
</head>
<body>
	<center>
	<h3>Access Denied.</h3>
	</center>
</body>	
</html>	
	 
<?	 
  }else{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>SignUp</title>
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
		   header("location: login.php?message=Success.");
		}else{
		   echo("<center><span class='text-danger'>Failed.</span></center>");
		}
    }else{
		echo("<center><span class='text-danger'>Password confirmation doesn't match.</span></center>");
    }

}

?>

<body>
	<div class="container">
	<div class="row" id="ct">
	<div class="col-lg-4"></div>
	<div class="col-lg-6">
	<form action="" method="POST">
		<div><input name="name" type="text" placeholder="Name" required/></div>
		<div><input name="user" type="text" placeholder="username" required/></div>
		<div><input name="pass" type="password" placeholder="password" required/></div>
		<div><input name="retype" type="password" placeholder="retype password" required/></div>
		
		<div><input type="submit" value="SignUp"/> <a href="login.php">Login</a></div>
	</form></div>
	</div>
</body>
</html>
<?php
}
?>
