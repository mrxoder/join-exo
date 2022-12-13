<?php
    function loader($class) {
        if(file_exists("Controls/".$class.".php")) {
            include "Controls/".$class.".php" ;
        }
        else if(file_exists("Models/".$class.".php")){
            include "Models/".$class.".php" ;
        }
        else if(file_exists("Core/".$class.".php")) {
            include "Core/".$class.".php" ;
        }
    }
    spl_autoload_register("loader") ;

?>
