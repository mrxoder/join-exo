<?php

session_start();
if(empty($_SESSION["username"])){ header("location: login.php");}

include("autoload.php");

$routes = new controls\routes();

$page = null;


if(!empty($_GET["page"]) && in_array($_GET["page"], $routes->value)){
	$page = $_GET["page"];
}

if(is_null($page)){ $page=$routes->value[0];}

$routes = new controls\routes();
$db = new models\sql();

include("controls/$page.php");


?>
