
<?php


session_start();

include("db.php");

if(empty($_SESSION["username"])){ header("location: login.php");}

$db = new sql();
$classes = $db->getclass();
$courses = $db->getcourses();

$cclass = "";

if(!empty($_GET["class"])){
	$cclass = $_GET["class"];
}else{
	$cclass = $classes[0]["id"];
}

//nom date lieu matiere addr classe=2

if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
	$id = "";
	if(!empty($_POST["id"])){
		$id = $_POST["id"];
	}
	
	if($db->newprof($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $_POST["matiere"], $_POST["addr"], $_POST["classe"], $id)){
	    echo("<center><span  class='text-success notif' >Success.</span></center>");
	}else{
	     echo("<center><span  class='text-danger notif' >Failed.</span></center>");
	}
	
}


$profs   = $db->getProf($cclass);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Professeur</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<meta http-equiv="viewport" content="width=device-width" />
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
	  <a href="index.php"  >School</a>
	  <a href="classe.php"   >Classe</a>
	  <a href="student.php">Etudiant</a>
	  <a href="prof.php" class="active">Professeur</a>
	  <a href="course.php">Matière</a>
	  <a href="admin.php">Admin</a>
	  <a href="logout.php">Quitter</a>
  </div>


 <div class="content">
  <div class="input">
     <form action="?class=<?php echo($cclass); ?>" class="form-horizontal" method="post">
        
		 <?php
	        $cprof = null;
	        if(!empty($_GET["edit"])){
				
				foreach($profs as $prof){
					if($_GET["edit"]==$prof["id"]){
						$cprof = $prof;
						$br = explode("#", $cprof["naissance"]);
						$cprof["date"] = $br[0];
						$cprof["lieu"] = $br[1];
					}
				}
				
			    if($cprof!=null){
		  ?>
			     <div class="form-group">
					 <label class="control-label " >ID: <?php echo($cprof["id"]); ?>(edit)</label>
					 <input type="hidden" name="id" value="<?php echo($cprof["id"]); ?>" />
		         </div>
		 <?php
		        }
		    }
		 ?>
		 <div class="form-group">
			 <label class="control-label " for="nom">Nom: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" value="<?php echo($cprof["nom"]); ?>" placeholder="Nom et prenom" class="form-control" id="nom" name="nom" required/>
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label" for="date">Date et Lieu de naissance: </label>
			 <div col="col-sm-10">
			   <input type="date" style="width:40%;" class="form-control" id="date" name="date" value="<?php echo($cprof["date"]); ?>" required/>
			 </div>
			 <div col="col-sm-10">
			   <input type="text" placeholder="lieu" style="width:40%;"class="form-control" id="lieu" name="lieu" value="<?php echo($cprof["lieu"]); ?>" required/>
			 </div> 
		</div>
		
		<div class="form-group">
			 <label class="control-label " for="matiere">Competence: </label>
			 <div col="col-sm-10">
			   <select style="width:30%;" class="form-control" id="matiere" name="matiere">
				  <option value="">Not defined</option>
			      <?php
			        var_dump($cprof);
					foreach($courses as $course){
					   $s = "";
					   if($course["id"]==$cprof["matiereId"]){
					       $s = "selected";
					   }
			      ?>      
				       <option value="<?php echo(htmlentities($course["id"])); ?>"  <?php echo($s); ?>> <?php echo(htmlentities($course["nommatiere"])); ?> </option>
				  <?php
			        }
			      ?>
			   </select>
			 </div>
	    </div>
		
		
		<div class="form-group">
			 <label class="control-label " for="addr">Addresse: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="adresse" class="form-control" id="addr" name="addr" value="<?php echo(htmlentities($cprof["adresse"])); ?>" required/>
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label " for="classe">Classe: </label>
			 <div col="col-sm-10">
			   <select style="width:30%;" class="form-control" id="classe" name="classe">
				   
				   <?php
				       
				       foreach($classes as $class){
						   $s = "";
						   
						   if($class["id"]==$cprof["idclasse"]){
								   $s = "selected";
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
				      <li class="nav-item <?php echo($active); ?>"><a href="prof.php?class=<?php echo($class["id"]);?>" class="nav-link"><?php echo(htmlentities($class["libelle"]));?></a></li>
		   <?php }  ?>
		   
       </ul>
    </nav>
	
	<table class="table list" id="list">
		 <th>ID</th> <th>Nom</th> <th>Naissance</th> <th>Adresse</th> <th>Competence</th> <th>Classe</th> <th>Action</th>
		 <?php
				foreach($profs as $prof){
				  	  $prof["naissance"] = str_replace("#", " ", $prof["naissance"]);
		   ?>  
		 <tr> <td><?php echo($prof["id"]); ?></td> <td><?php echo($prof["nom"]); ?></td> <td><?php echo($prof["naissance"]); ?></td> <td><?php echo($prof["adresse"]); ?></td> <td><?php echo($prof["nomMatiere"]); ?></td> <td><?php echo($prof["libelle"]); ?></td> <td> <a href="?delete=<?php echo($prof["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="?edit=<?php echo($prof["id"]); ?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
	     <?php 
	        }
	     ?>

	</table>
   
   
</div>



<script src="js/jquery.js"></script>
<script src="js/notif.js"></script>

</body>
</html>
