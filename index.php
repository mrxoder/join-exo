<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();

$classes = $db->getclass();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>School</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="style.css" />
	<meta http-equiv="viewport" content="width=device-width" />
	
	<style>
		 .list{
            margin: 2% 0 0 10%;
         }
         
         label{
			color: #2e59d9;
		 }
         
         .label{
			width: 10%;
			background-color:#2e59d9;
			color: white;
		 }
         
    </style>
	
</head>

<body class="bg-light">
	 
  <div class="sidebar">
	  <a href="index.php" class="active">School</a>
	  <a href="classe.php">Classe</a>
	  <a href="student.php">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="course.php">Matière</a>
	  <a href="admin.php">Admin</a>
	  <a href="logout.php">Quitter</a>
  </div>
  
  <div class="content">
	   <div class="list">
       <table class="table">
		   <label> <strong>Etudiants:</strong> </label>
		   <?php
		       $t = 0;
		       foreach($classes as $class){
				   $students = $db->getStudent($class["id"]);
				   $t +=count($students);
		   ?>
		           <tr> <td class="label"><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(count($students));?>/<?php echo($class["capacite"]);?></td> </tr>
		   <?php
		       }
		   ?>
		       <tr> <td><strong>Total</strong> </td> <td><?php echo($t);?> etudiants</td> </tr>
       </div>
       
       <div class="list">
		   
		   <table class="table">
			   <label><strong> Professeurs: </strong> </label>
			   <?php
			   $t = 0;
		       foreach($classes as $class){
				   $profs = $db->getProf($class["id"]);
				   $t +=count($profs);
			   ?>
			           <tr> <td class="label"><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(count($profs));?> </td> </tr>
			   <?php
			       }
			   ?>
			    <tr> <td><strong>Total</strong> </td> <td><?php echo($t);?> professeurs</td> </tr>
		   </table>
       </div>
  </div>
  
</body>
</html>
  
