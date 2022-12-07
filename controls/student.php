<?php


$classes = $db->getclass();

$cclass = "";
if(!empty($_GET["class"])){
	
	$cclass = $_GET["class"];
}else{
	if(count($classes)>0){
	  $cclass = $classes[0]["id"];
    }
}


if(!empty($_GET["delete"])){
	$id = $_GET["delete"];
	if($db->deleteStudent($id)){
		 $id = htmlentities($id);
	     echo("<center><span  class='text-success notif' >Student id $id delete with success.</span></center>");
	}else{
		 $id = htmlentities($id);
	     echo("<center><span  class='text-danger notif' >Failed to delete student id $id.</span></center>");
	}
}else{
	
}


if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["pnom"]) && !empty($_POST["mnom"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
	$description = "";
	$cid = "";
	if(!empty($_POST["descr"])){ $description = $_POST["descr"];}
	if(!empty($_POST["id"])){ $cid = $_POST["id"];}
	
	if($db->newstudent($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $_POST["pnom"]."#".$_POST["mnom"], $_POST["addr"], $_POST["classe"], $description, $cid)){
	    echo("<center><span  class='text-success notif' >Success.</span></center>");
	}else{
	     echo("<center><span  class='text-danger notif' >Failed.</span></center>");
	}
	
}

$students = $db->getStudent($cclass);

$view = new views\student(["classes"=>$classes, "cclass"=>$cclass, "students"=>$students]);

?>
