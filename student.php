<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Student Profile</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="style.css" />
</head>

<body class="bg-light">
	 
  <div class="sidebar">
	  <a href="index.php"  >School</a>
	  <a href="classe.php" >Classe</a>
	  <a href="student.php" class="active">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="logout.php">Quitter</a>
  </div>


<div class="content">
  
</div> 


<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();


?>

</body>
</html>
