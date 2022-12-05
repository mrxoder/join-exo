<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}
include("db.php");
$db = new sql();

$classes = $db->getclass();

$cclass = "";
if(!empty($_GET["class"])){
	
	$cclass = $_GET["class"];
}else{
	$cclass = $classes[0]["id"];
}


if(!empty($_GET["delete"])){
	$id = $_GET["delete"];
	if($db->deleteStudent($id)){
		 $id = htmlentities($id);
	     echo("<center><span  class='text-success notif' >Student id $id delete with success.</span></center>");
	}else{
		 $id = htmlentities($id);
	     echo("<center><span  class='text-danger notif' >Failed to delete student id $id.</span></center>");
	}
}else{
	
}


if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["pnom"]) && !empty($_POST["mnom"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
	$description = "";
	$cid = "";
	if(!empty($_POST["descr"])){ $description = $_POST["descr"];}
	if(!empty($_POST["id"])){ $cid = $_POST["id"];}
	
	if($db->newstudent($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $_POST["pnom"]."#".$_POST["mnom"], $_POST["addr"], $_POST["classe"], $description, $cid)){
	    echo("<center><span  class='text-success notif' >Success.</span></center>");
	}else{
	     echo("<center><span  class='text-danger notif' >Failed.</span></center>");
	}
	
}

$students = $db->getStudent($cclass);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Student</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="style.css" />
    
    <style>
		 .input{
           margin: 2% 0 0 15%;
         }
    </style>
</head>

<body class="bg-light">
	 
  <div class="sidebar">
	  <a href="index.php">School</a>
	  <a href="classe.php"  >Classe</a>
	  <a href="student.php" class="active">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="course.php">Matière</a>
	  <a href="admin.php">Admin</a>
	  <a href="logout.php">Quitter</a>
  </div>


<div class="content">
    
    <div class="input">
     <form action="?class=<?php echo(htmlentities($cclass));?>" class="form-horizontal" method="post">
		 
		 
		 <?php
	        $student = null;
	        if(!empty($_GET["edit"])){
				
				foreach($students as $item){
					if($_GET["edit"]==$item["id"]){
					   $student = $item;
					   $birth = explode("#", $item["naissance"]);
					   $student["date"] = $birth[0];
					   $student["lieu"] = $birth[1];
					   $parent = explode("#", $item["parents"]);
					   $student["pnom"] = $parent[0];
					   $student["mnom"] = $parent[1];
					   break;
					}
			    }
			    
       ?>
		       <input type="hidden" name="id" value="<?php echo($student["id"]); ?>"/>
		       <div class="form-group">
					  <label class="control-label ">ID: <?php echo($student["id"]);?>(edit)</label>
			   </div>
    <?php } ?>
		 
		 <div class="form-group">
			 <label class="control-label " for="nom">Nom: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="Nom et prenom" class="form-control" id="nom" name="nom"  value="<?php echo(htmlentities($student["nom"])); ?>" required />
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label" for="date">Date et Lieu de naissance: </label>
			 <div col="col-sm-10">
			   <input type="date" style="width:40%;" class="form-control" id="date" name="date" value="<?php echo(htmlentities($student["date"])); ?>" required />
			 </div>
			 <div col="col-sm-10">
			   <input type="text" placeholder="lieu" style="width:40%;"class="form-control" id="lieu" name="lieu" value="<?php echo(htmlentities($student["lieu"])); ?>" required />
			 </div> 
		</div>
		
		<div class="form-group">
			 <label class="control-label " for="parents">Parents: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="Père" class="form-control" id="parent" name="pnom" value="<?php echo(htmlentities($student["pnom"])); ?>" required />
			   <input type="text" style="width:40%;" placeholder="Mère" class="form-control"  name="mnom" value="<?php echo(htmlentities($student["mnom"])); ?>" required />
			 </div>
	    </div>
		
		<div class="form-grsoup">
			 <label class="control-label " for="description">Description: </label>
			 <div col="col-sm-10">
			   <textarea type="text" style="width:40%;"  class="form-control" id="description" name="descr"> <?php echo(htmlentities($student["description"]));?> </textarea>
			 </div>
	    </div>
		
		
		<div class="form-group">
			 <label class="control-label " for="addr">Addresse: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="adresse" class="form-control" id="addr" name="addr" value="<?php echo(htmlentities($student["adresse"])); ?>" required />
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label " for="classe">Classe: </label>
			 <div col="col-sm-10">
				 
			   <select style="width:30%;" class="form-control" id="classe" name="classe">
				   <?php
				       
				       foreach($classes as $class){
						   $s = "";
						   if(!empty($student)){
							   
							   if($class["id"]==$student["classId"]){
								   $s = "selected";
							   }
						   }else{
							   if($class["id"]==$cclass){
								   $s = "selected";
							   }
						   }
				   ?>
				      <option value="<?php echo($class["id"]);?>" <?php echo($s); ?>> <?php echo(htmlentities($class["libelle"]));?></option>
				   <?php } ?>
				   
			   </select>
			 </div>
	    </div>
		
		 <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		        <input type="submit" value="Add" class="btn btn-primary"/>
		    </div>
		 </div>
	   </form>
	</div>
	
	<nav class="navbar navbar-expand">
       <ul class="navbar-nav">
		   <?php
				foreach($classes as $class){
				  $active = "";
				  if($cclass==$class["id"]){
					  $active = "active";
				  }	  
		   ?>      
				      <li class="nav-item <?php echo($active); ?>"><a href="student.php?class=<?php echo($class["id"]);?>#list" class="nav-link"><?php echo(htmlentities($class["libelle"]));?></a></li>
		   <?php }  ?>
		   
		   
		   
       </ul>
    </nav>
	
	<table class="table list" id="list">
		 <th>ID</th> <th>Nom</th> <th>Naissance</th> <th>Adresse</th> <th>Classe</th> <th>Parents</th>  <th>Description</th> <th>Action</th>
		 
		 <?php
		     if(!empty($students)){
				
				foreach($students as $i){ 
					$i["naissance"] = str_replace("#", " ", $i["naissance"]);
					$i["parents"] = str_replace("#", ", ", $i["parents"]);
		?>
		            <tr><td><?php echo($i["id"]); ?></td> <td><?php echo(htmlentities($i["nom"])); ?></td> <td><?php echo(htmlentities($i["naissance"])); ?></td> <td><?php echo($i["adresse"]); ?></td> <td><?php echo($i["libelle"]); ?></td> <td><?php echo($i["parents"]); ?></td>  <td><?php echo(htmlentities($i["description"])); ?></td> <td> <a href="?delete=<?php echo($i["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="?edit=<?php echo("{$i['id']}&class={$i['classId']}"); ?>"> <button class="btn btn-success">Edit</button></a> </td> </tr>
	    <?php  } }?>
	</table>
   
   
</div> 
<script src="js/jquery.js"></script>
	<script src="js/notif.js"></script>
</body>
</html>
