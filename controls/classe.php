<?php




if(!empty($_GET["delete"])){
   if($db->deleteClasse($_GET["delete"])){
	   $tmp = htmlentities($_GET["delete"]);
	   echo("<center><span  class='text-success notif' >Classe at id:{$tmp} delete with success.</span></center>");
   }else{
	   echo("<center><span  class='text-danger notif' >Failed to delete the class.</span></center>");
   }	
}

$classes = $db->getclass();
$cid = "";
$cclass = null;


if(!empty($_GET["edit"])){
	
	foreach($classes as $class)
	{
		if($_GET["edit"]==$class["id"])
		{
			$cclass = $class;
			$cid = $_GET["edit"];
		}
	}
}


$view = new views\classe(["cid"=>$cid, "cclass"=>$cclass, "classes"=>$classes]);


?>
