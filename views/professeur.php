<?php


namespace views;

class professeur{
	
	public function __construct($var=[]){
		$this->var = $var;
		
		$this->header();
		new sidebar((new \controls\routes())->value, "professeur");
		$this->content();
		$this->script();
		$this->footer();
	}
	
	public function header(){
?>
	        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<title>Professeur</title>
<?php		
		include("header.html");
	}
	
	
	public function content(){
		$classes = $this->var["classes"];
		$courses = $this->var["courses"];
		$cclass = $this->var["cclass"];
		$profs = $this->var["profs"];
?>
 <div class="content">
  <div class="input">
     <form action="index.php?page=professeur&class=<?php echo($cclass); ?>" class="form-horizontal" method="post">
        
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
			   <input type="text" placeholder="lieu" style="width:40%; margin-top:1%;"class="form-control" id="lieu" name="lieu" value="<?php echo($cprof["lieu"]); ?>" required/>
			 </div> 
		</div>
		
		<div class="form-group">
			 <label class="control-label " for="matiere">Competence: </label>
			 <div col="col-sm-10">
			   <select style="width:40%;" class="form-control" id="matiere" name="matiere">
				  <option value="">Not defined</option>
			      <?php
			        
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
			   <select style="width:40%;" class="form-control" id="classe" name="classe">
				   
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
		    <div class="col-sm-offset-2 col-sm-5">
		        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
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
				      <li class="nav-item <?php echo($active); ?>"><a href="index.php?page=professeur&class=<?php echo($class["id"]);?>" class="nav-link"><?php echo(htmlentities($class["libelle"]));?></a></li>
		   <?php }  ?>
		   
       </ul>
    </nav>
	
	<table class="table list" id="list">
		 <th>ID</th> <th>Nom</th> <th>Naissance</th> <th>Adresse</th> <th>Competence</th> <th>Classe</th> <th>Action</th>
		 <?php
				foreach($profs as $prof){
				  	  $prof["naissance"] = str_replace("#", " ", $prof["naissance"]);
		   ?>  
		 <tr> <td><?php echo($prof["id"]); ?></td> <td><?php echo($prof["nom"]); ?></td> <td><?php echo($prof["naissance"]); ?></td> <td><?php echo($prof["adresse"]); ?></td> <td><?php echo($prof["nomMatiere"]); ?></td> <td><?php echo($prof["libelle"]); ?></td> <td> <a href="index.php?page=professeur&delete=<?php echo($prof["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="index.php?page=professeur&edit=<?php echo($prof["id"]); ?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
	     <?php 
	        }
	     ?>

	</table>
   
   
</div>
	
     
<?php	
	}
	
	public function script(){
		?>
		<script src="public/js/jquery.js"></script>
        <script src="public/js/notif.js"></script>

		<?php
	}
	
	public function footer(){
		?>
		</body>
		</html>
		<?php
	}
	
}

?>
