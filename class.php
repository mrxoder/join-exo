<?php

session_start();
include("db.php");

$title = "";
$db = new sql();

$classes = $db->getclass();
$user = $db->getUser($_SESSION["username"]);

$ccl = null;

if(!empty($_GET["class"])){
   foreach($classes as $item){
	   if($item["class_name"]==$_GET["class"]){
	      $ccl = $item;
	      break;
	   }
   }  
}else{
   header("location: class.php?class={$user["class_name"]}");
}

if($ccl!=null){
	$title = $ccl["class_name"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo($title);?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	
	<style>
		.tb{
			width: 50%;
			margin: 3% 0 0 10%;
		}
	    table{
		  width: 80%;
		  padding: 0 2% 0 2%;	
		}
		
		.tb label{
		   float: left;
		} 
		
		tr{
		  padding: 1% 0 0 0;
		}
	</style>
	
</head>
<body>

<?php

if($ccl!=null){
	
	$students = $db->getclassStudent($ccl["id"]);
	$profs = $db->getclassProf($ccl["id"]);
?>
	<div class="tb" align="center">
		<label>Student: </label>
		<table class="table" >
			<th>Name</th> <th>Class</th>
<?php
    
    foreach($students as $student){
		$classname="";
		if($student["username"]==$_SESSION["username"]){ $classname="info"; }
?>
       <tr class="<?php echo($classname);?>"> <td><?php echo(htmlentities($student["name"]));?></td> <td><?php echo(htmlentities($student["class_name"]));?></td> </tr>
<?
	}
?>
		</table>
	</div>
	
	<div class="tb" align="center">
		<label>Prof: </label>
		<table class="table" >
			<th>Name</th> <th>Class</th> <th>Teach</th>
<?php
    foreach($profs as $prof){
		$classname="";
		if($prof["username"]==$_SESSION["username"]){ $classname="active"; }
?>
            <tr class="<?php echo($classname);?>"> <td><?php echo(htmlentities($prof["name"]));?></td> <td><?php echo(htmlentities($prof["class_name"]));?></td> <td><?php echo(htmlentities($prof["course_name"]));?></td> </tr>
<?
	}
?>
		</table>
	</div>
	
	
	
<?php	
}
?>
	
	<div><a href="index.php">Home</a> <a href="logout.php">Logout</a></div>
</body>
</html>

