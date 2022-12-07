<?php


namespace views;

class school{
	
	public function __construct($var=[]){
		$this->var=$var;
	}
	
	public function header(){
		include("schoolheader.html");
	}
	
	public function content(){
		$classes = $this->var["classes"];
		$db = $this->var["db"];
?>
			<div class="content">
				   
				   <div style="margin:4% 0 0 0;"><label> <strong>Etudiants:</strong> </label>
				   <div class="list half" id="student">
			         <table class="table">
					   <?php
					       $t = 0;
					       foreach($classes as $class){
							   $students = $db->getStudent($class["id"]);
							   $t +=count($students);
					   ?>
					           <tr> <td ><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(count($students));?>/<?php echo($class["capacite"]);?></td> </tr>
					   <?php
					       }
					   ?>
					       
					   </table>
			       </div>
			       <ul class="list-group">
					   <li class="list-group-item"><strong >Total</strong> <span><?php echo($t);?>  etudiants</span></li> 
				   </ul></div>
			       
			       <div style="margin:4% 0 0 0;">
					   <label><strong> Professeurs: </strong> </label>
			         <div class="list half" id="prof">
					   <table class="table">
						   <?php
						   $t = 0;
					       foreach($classes as $class){
							   $profs = $db->getProf($class["id"]);
							   $t +=count($profs);
						   ?>
						           <tr> <td><?php echo(htmlentities($class["libelle"]));?></td> <td><?php echo(count($profs));?> </td> </tr>
						   <?php
						       }
						   ?>
						    
					   </table>
			          </div>
			          <ul class="list-group">
					    <li class="list-group-item"><strong >Total</strong> <span><?php echo($t);?>  professeurs</span></li> 
				      </ul>
			       </div>
			       
			  </div>

<?php		
	}

    public function script(){
?>
         <script src="public/js/jquery.js"></script>
         <script src="public/js/style.js"></script>
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
