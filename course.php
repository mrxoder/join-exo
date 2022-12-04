
<?php


session_start();

include("db.php");

if(empty($_SESSION["username"])){ header("location: login.php");}

$db = new sql();
$classes = $db->getclass();


$cid = "";
if(!empty($_GET["edit"])){
	
	$cid = $_GET["edit"];
}

if(!empty($_GET["delete"])){
	$idx = htmlentities($_GET["delete"]);
	if($db->deleteCourse($_GET["delete"])){
	   echo("<center><span  class='text-success notif' >Course id {$idx} delete with success.</span></center>");
    }else{
	   echo("<center><span class='text-danger notif'>Failed to delete course id {$idx}.</span></center>");
    }
    
}

if(!empty($_POST["name"]) && !empty($_POST["coef"])){
	
	$descr = "";
	$id = "";
	if(!empty($_POST["descr"])){ $descr=$_POST["descr"];}
	if(!empty($_POST["id"])){ $id=$_POST["id"];}
	
	if($db->newCourse($_POST["name"],$_POST["coef"],$descr, $id)){
	   echo("<center><span  class='text-success notif' >Success</span></center>");
    }else{
	   echo("<center><span class='text-danger notif'>Failed!</span></center>");
    }
	
}

$courses=$db->getcourses();
$ccourse = Null;
if($cid!=""){
	foreach($courses as $c){
		if($c["id"]==$cid){
			$ccourse = $c;
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Professeur</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.38" />
	<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="style.css" />
	<style>
		 .input{
            margin: 2% 0 0 2%;
         }
    </style>
</head>

<body class="bg-light">
	 
  <div class="sidebar">
	  <a href="#"  >School</a>
	  <a href="index.php"  >Classe</a>
	  <a href="student.php">Etudiant</a>
	  <a href="prof.php">Professeur</a>
	  <a href="course.php" class="active">Matière</a>
	  <a href="logout.php">Quitter</a>
  </div>


<div class="content">
  <div class="input">
     <form action="course.php" class="form-horizontal" method="post">
		 
		 <?php
		    if(!empty($ccourse)){
		 ?>
		        <input type="hidden" name="id" value="<?php echo($ccourse["id"]); ?>" />
				<div class="form-group">
				   <label class="control-label " >ID: <?php echo($ccourse["id"]); ?>(edit)</label>
			    </div>
	    <?php
		    }
		?>
	    
		 <div class="form-group">
			 <label class="control-label " for="nom">Matière: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="Matière" class="form-control" id="nom" name="name" value="<?php echo($ccourse["nommatiere"]); ?>"/>
			 </div>
	    </div>
		 <div class="form-group">
			 <label class="control-label " for="coef">Coefficient: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="Coefficient" class="form-control" id="coef" name="coef" value="<?php echo($ccourse["coefficient"]); ?>"/>
			 </div>
	    </div>
	    
		
		
		<div class="form-group">
			 <label class="control-label " for="description">Description: </label>
			 <div col="col-sm-10">
			   <textarea type="text" style="width:40%;"  class="form-control" id="description" name="descr"><?php echo($ccourse["description"]); ?></textarea>
			 </div>
	    </div>
		
		
		
		
	    <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		        <input type="submit" value="Add" class="btn btn-primary"/>
		    </div>
		 </div>
	   </form>
	</div>
	
	<table class="table list" id="list">
		 <th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>
		 <?php
		   foreach($courses as $course){
		 ?>
		      <tr> <td><?php echo($course["id"]); ?></td> <td><?php echo(htmlentities($course["nommatiere"])); ?></td> <td><?php echo(htmlentities($course["coefficient"])); ?></td> <td><?php echo(htmlentities($course["description"])); ?></td> <td><a href="?delete=<?php echo($course["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="?edit=<?php echo($course["id"]); ?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
	     <?php
		   }
		 ?>
	</table>
</div>



<script src="js/jquery.js"></script>
<script src="js/notif.js"></script>

</body>
</html>
