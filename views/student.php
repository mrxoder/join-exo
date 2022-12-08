<?php


namespace views;

class student{
	
	public function __construct($var=[]){
		$this->var = $var;
		
		$this->header();
		new sidebar((new \controls\routes())->value, "student");
		$this->content();
		$this->script();
		$this->footer();
	}
	
	public function header()
	{
?>

		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		
		<head>
			<title>Student</title>
<?php
		include("header.html");
	}
	
	
	public function content(){
		$students = $this->var["students"];
		$classes = $this->var["classes"];
		$cclass = $this->var["cclass"];
?>
<div class="content">
    
    <div class="input">
     <form id="form" class="form-horizontal" method="post">
		 
		 
		 <?php
	        //foreach students
			    
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
			   <input type="text" placeholder="lieu" style="width:40%; margin-top:1%;"class="form-control" id="lieu" name="lieu" value="<?php echo(htmlentities($student["lieu"])); ?>" required />
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
				 
			   <select style="width:40%;" class="form-control" id="classe" name="classe">
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
				      <li class="nav-item <?php echo($active); ?>"><a href="index.php?page=student&class=<?php echo($class["id"]);?>" class="nav-link"><?php echo(htmlentities($class["libelle"]));?></a></li>
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
		            <tr><td><?php echo($i["id"]); ?></td> <td><?php echo(htmlentities($i["nom"])); ?></td> <td><?php echo(htmlentities($i["naissance"])); ?></td> <td><?php echo($i["adresse"]); ?></td> <td><?php echo($i["libelle"]); ?></td> <td><?php echo($i["parents"]); ?></td>  <td><?php echo(htmlentities($i["description"])); ?></td> <td> <a href="index.php?page=professeur&delete=<?php echo($i["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="index.php?page=professeur&edit=<?php echo("{$i['id']}&class={$i['classId']}"); ?>"> <button class="btn btn-success">Edit</button></a> </td> </tr>
	    <?php  } }?>
	</table>
   
   
</div> 
<?php		
		
	}
	
	public function script(){
		?>
		<script src="public/js/jquery.js"></script>
        <script src="public/js/notif.js"></script>
        <script src="public/js/student.js"></script>

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
