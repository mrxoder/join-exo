<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}

include("autoload.php");

$routes = new controls\routes();
$db = new models\sql();
$controller = new controls\controller($db);

if(!empty($_POST["page"]) && in_array($_POST["page"], $routes->value)){
	$page = $_POST["page"];
	switch($page){
		case "admin":
		   $controller->admin();
		break;
		case "classe":
		   $controller->classe();
		break;
		case "student":
		   $controller->student();
		break;
		case "professor":
		   $controller->professor();
		break;
		case "school":
		   $controller->school();
		break;
		case "logout":
		   $controller->logout();
		break;
		case "course":
		   $controller->course();
		break;
	}
}else{
	
	$controller->index();
}


?>
