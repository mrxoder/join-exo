
<?php


$classes = $db->getclass();
$courses = $db->getcourses();

$cclass = "";

if(!empty($_GET["class"])){
	$cclass = $_GET["class"];
}else{
	if(count($classes)>0){
	  $cclass = $classes[0]["id"];
    }
}

//nom date lieu matiere addr classe=2

if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
	$id = "";
	$matiere = "";
	if(!empty($_POST["id"])){
		$id = $_POST["id"];
	}
	if(!empty($_POST["matiere"])){
		$matiere = $_POST["matiere"];
	}
	
	if($db->newprof($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $matiere, $_POST["addr"], $_POST["classe"], $id)){
	    echo("<center><span  class='text-success notif' >Success.</span></center>");
	}else{
	     echo("<center><span  class='text-danger notif' >Failed.</span></center>");
	}
	
}


$profs   = $db->getProf($cclass);

$view = new views\professeur(["profs"=>$profs, "cclass"=>$cclass, "classes"=>$classes, "courses"=>$courses]);

?>
