<?php
    
    class InitializerControls {
        public static function loadViews($page) {
            include "Views/".$page.".php" ;
        }


        public static function loadCSS($css) {
            // $css est un tableau
            for($i = 0; $i < count($css); $i++) {
                echo "<link rel='stylesheet' href='".URL."Publics/css/".$css[$i].".css'>" ;
            }
        }

        public static function loadJS($js) {
            for($i = 0; $i < count($js); $i++) {
                echo "<script src='".URL."Publics/js/".$js[$i].".js'></script>" ;
            }
        }

        public static function loadTemplate($page) {
            include "Views/template-parts/".$page.".php" ;
        }
    }

?>
