<?php
    session_start() ;
    const URL = "http://localhost/school/" ;
    
    include "Core/autoload.php" ;
    
    
	if(!empty($_GET['action']) ) {
	     Root::executer($_GET['action']) ;
	}else {
	     if(empty($_SESSION["username"])){ 
			 InitializerControls::loadViews("login");
	     }else{
			 InitializerControls::loadViews("index") ;// Page par defaut:
		 }
	}
    
