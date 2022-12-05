<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();
$cid = "";

if(!empty($_POST["libelle"]) && !empty($_POST["capacity"])){
   if(!empty($_POST["id"])){
	  $cid = $_POST["id"];
   }
   
   if($db->newClass($_POST["libelle"], $_POST["capacity"], $cid)){
	   echo("<center><span  class='text-success notif' >success</span></center>");
   }else{
	   echo("<center><span class='text-danger notif'>failed</span></center>");
   }
}


if(!empty($_GET["delete"])){
   if($db->deleteClasse($_GET["delete"])){
	   $tmp = htmlentities($_GET["delete"]);
	   echo("<center><span  class='text-success notif' >Classe at id:{$tmp} delete with success.</span></center>");
   }else{
	   echo("<center><span  class='text-danger notif' >Failed to delete the class.</span></center>");
   }	
}

$classes = $db->getclass();
$cid = "";
$cclass = null;


if(!empty($_GET["edit"])){
	
	foreach($classes as $class)
	{
		if($_GET["edit"]==$class["id"])
		{
			$cclass = $class;
			$cid = $_GET["edit"];
		}
	}
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Classes</title>
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
	  <a href="classe.php" class="active">Classe</a>
	  <a href="student.php">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="course.php">Matière</a>
	  <a href="admin.php">Admin</a>
	  <a href="logout.php">Quitter</a>
  </div>


<div class="content">
	
	<div class="input">
     <form action="classe.php" class="form-horizontal" method="post">
		 <?php
		     if($cid!=""){
			
		 ?>
		     <input type="hidden" name="id" value="<?php echo($cid);?>" required />
		     <div class="form-group">
			    <label class="control-label ">ID: <?php echo($cid);?>(edit)</label>
	         </div>
		     
		 <?php 
		     }
		 ?>
		 <div class="form-group">
			 <label class="control-label " for="libelle">Libelle: </label>
			 <div col="col-sm-10">
			   <input type="text" placeholder="Libelle" class="form-control" id="libelle" name="libelle" value="<?php echo($cclass["libelle"]);?>" required />
			 </div>
	    </div>
		<div class="form-group capacity">
			 <label class="control-label" for="capacity">Capacité: </label>
			 <div col="col-sm-10">
			   <input type="text" placeholder="Capacité" class="form-control" id="capacity" name="capacity" value="<?php echo($cclass["capacite"]);?>" required />
			 </div>
		</div>
		 <div class="form- group">
		    <div class="col-sm-offset-2 col-sm-10">
		        <input type="submit" value="Add" class="btn btn-primary"/>
		    </div>
		 </div>
	</form>
	</div>
	
	<table class="table list">
		 <th>ID</th><th>Libelle</th><th>Capacité</th> <th>Action</th>
<?php
         foreach($classes as $class){
?>
		  <tr> <td><?php echo(htmlentities($class["id"]));?></td> <td><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(htmlentities($class["capacite"]));?></td> <td> <a href="index.php?delete=<?php echo($class["id"]);?>"><button class="btn btn-danger">Delete</button></a> <a href="index.php?edit=<?php echo($class["id"]);?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
<?php
	     }
?>
	</table>
	
</div> 
	<script src="js/jquery.js"></script>
	<script src="js/notif.js"></script>
</body>

</html>
