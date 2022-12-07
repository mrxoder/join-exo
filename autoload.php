<?php 


function load($class){
	
	$class = str_replace("\\","/", $class);
	$file = "{$class}.php";
	if(file_exists($file)){
	  include($file);
    }
	
}

spl_autoload_register("load");
