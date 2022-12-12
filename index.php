<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}

include("autoload.php");

$routes = new controls\routes();
$db = new models\sql();
$controller = new controls\controller($db);

if(!empty($_POST["page"]) && in_array($_POST["page"], $routes->value)){
	
	$page = $_POST["page"];
	
	call_user_func(array($controller, $_POST["page"]));
	
	
}else{
	
	$controller->index();
}


?>
