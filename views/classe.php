<?php


namespace views;

class classe{
	
	public function __construct($var=[]){
		$this->var = $var;
		
		$this->header();
		new sidebar((new \controls\routes())->value, "classe");
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
	<title>Classe</title>
<?php
		include("header.html");
	}	
	
	public function content(){
		$classes = $this->var["classes"];
		$cclass = $this->var["cclass"];
		$cid = $this->var["cid"];
?>
        <div class="content">
	
			<div class="input">
		     <form action="index.php?page=classe" class="form-horizontal" method="post">
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
				    <div class="col-sm-offset-2 col-sm-5">
				        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
				    </div>
				 </div>
			</form>
			</div>
			
			<table class="table list">
				 <th>ID</th><th>Libelle</th><th>Capacité</th> <th>Action</th>
		<?php
		         foreach($classes as $class){
		?>
				  <tr> <td><?php echo(htmlentities($class["id"]));?></td> <td><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(htmlentities($class["capacite"]));?></td> <td> <a href="index.php?page=classe&delete=<?php echo($class["id"]);?>"><button class="btn btn-danger">Delete</button></a> <a href="index.php?page=classe&edit=<?php echo($class["id"]);?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
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
