<?php 


function load($class){
	
	$class = str_replace("\\","/");
	include("../{$class}.php");
	
}

spl_autoload_register($class);
