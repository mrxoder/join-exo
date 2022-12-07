
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
	
	$view = new views\course(["classes"=>$classes, "ccourse"=>$ccourse, "courses"=>$courses]);
	
	
?>
