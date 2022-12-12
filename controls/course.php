
<?php

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
	
	
	
	$courses=$db->getcourses();
	$ccourse = Null;
	if($cid!=""){
		foreach($courses as $c){
			if($c["id"]==$cid){
				$ccourse = $c;
			}
		}
	}
	
	$view = new views\course(["classes"=>$classes, "ccourse"=>$ccourse, "courses"=>$courses]);
	
	
?>
