<?php

namespace views;



class sidebar{
	
	public function __construct($routes, $active=""){
?>

<div class="sidebar">

<?php
        foreach($routes as $route){
			$class = "";
			if($route==$active){
				$class = " class='active' ";
			}
?>
            <a href="index.php?page=<?php echo($route);?>" <?php echo($class);?>> <?php echo(ucfirst($route));?> </a>
<?php
		}
?>

</div>	

<?php		
	}
}
?>
