<?php

namespace views;

class course{
	
	public function __construct($var=[]){
		$this->var = $var;
		$this->header();
		new sidebar((new \controls\routes())->value, "course");
		$this->content();
		$this->script();
		$this->footer();
	}
	
	public function header(){
		include("courseheader.html");
	}
	
	public function content(){
		$ccourse = $this->var["ccourse"];
		$courses = $this->var["courses"];
		$classes = $this->var["classes"];
		
?>
		        <div class="content">
		  <div class="input">
		     <form action="index.php?page=course" class="form-horizontal" method="post">
				 
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
				    <div class="col-sm-offset-2 col-sm-5">
				        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
				    </div>
				 </div>
			   </form>
			</div>
			
			<table class="table list" id="list">
				 <th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>
				 <?php
				   foreach($courses as $course){
				 ?>
				      <tr> <td><?php echo($course["id"]); ?></td> <td><?php echo(htmlentities($course["nommatiere"])); ?></td> <td><?php echo(htmlentities($course["coefficient"])); ?></td> <td><?php echo(htmlentities($course["description"])); ?></td> <td><a href="index.php?page=course&delete=<?php echo($course["id"]); ?>"><button class="btn btn-danger">Delete</button></a> <a href="index.php?page=course&edit=<?php echo($course["id"]); ?>"><button class="btn btn-success">Edit</button></a> </td> </tr>
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
