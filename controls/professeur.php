
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




$profs   = $db->getProf($cclass);

$view = new views\professeur(["profs"=>$profs, "cclass"=>$cclass, "classes"=>$classes, "courses"=>$courses]);

?>
