<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");

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
	 
<?php
}else{
  $db = new sql();

  $user = $db->getUser($_SESSION["username"]);
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Admin-Page</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<meta http-equiv="viewport" content="width=device-width" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="index.css" />
	
</head>

<body class="bg-light">
	 
  <div class="sidebar">
	  <a href="index.php">School</a>
	  <a href="classe.php">Classe</a>
	  <a href="student.php">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="course.php">Matière</a>
	  <a href="admin.php" class="active">Admin</a>
	  <a href="logout.php">Quitter</a>
  </div>


<div class="content">
	<?php
	
	if(!empty($_POST["name"]) && !empty($_POST["currentpwd"]) && !empty($_POST["npwd"]) && !empty($_POST["retype"]) ){
	    if($_POST["retype"]!=$_POST["npwd"]){
			echo("<center><span class='text-danger notif'>Password confirmation doesn't match.</span></center>");
			return false;
		}
		
		if($db->login($_SESSION["username"], $_POST["currentpwd"])){
		   if($db->newuser($_SESSION["username"], $_POST["npwd"], $_POST["name"], $user["id"])){
			    header("location: admin.php?message=The account is up to date.");
		   }else{ echo("<center><span class='text-danger notif'>Failed to update the account.</span></center>");}
		}else{ echo("<center><span class='text-danger notif'>Incorrect current password.</span></center>");}
    }
   
    if(!empty($_GET["message"])){
		$m = htmlentities($_GET["message"]);
		echo("<center><span class='text-primary notif'>$m</span></center>");
	}
	
	?>
	<div class="input">
	<form action="admin.php" class="form-horizontal" method="post">
		
		<div class="form-group">
			 <ul class="list-group" style="width:40%;">
			   <li class="list-group-item control-label " for="name">Username:  <?php echo(htmlentities($user["username"])); ?></li>
			 </ul>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label " for="name">Name: </label>
			 <div col="col-sm-10">
			   <input type="text" placeholder="name" class="form-control" id="name" name="name" value="<?php echo(htmlentities($user["name"])); ?>" required />
			 </div>
	    </div>
		<div class="form-group">
			 <label class="control-label " for="pwd">Current Password: </label>
			 <div col="col-sm-10">
			   <input type="password" placeholder="Current Password" class="form-control" id="pwd" name="currentpwd" required />
			 </div>
	    </div>
		<div class="form-group">
			 <label class="control-label " for="npwd">New password: </label>
			 <div col="col-sm-10">
			   <input type="password" placeholder="New Password" class="form-control" id="npwd" name="npwd" required />
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label " for="confirm">Retype, new password: </label>
			 <div col="col-sm-10">
			   <input type="password" placeholder="Retype, new password" class="form-control" id="confirm" name="retype" required />
			 </div>
	    </div>
		<div class="form-group">
			 <div col="col-sm-10">
			   <input type="submit" class="btn btn-primary" value="Save"/>
			 </div>
	    </div>
	    
	</form>
	</div>
</div>

	<script src="js/jquery.js"></script>
	<script src="js/notif.js"></script>
</body>
</html>
<?php
}
?>

