<?php
    class Root {

        public static function executer($url) {
            /**
             * si url = class -> appel index dans la class
             * si url = class/method -> appel class et method
             * si url = class/method/param1/param2 -> appel class, method et param1/param2
             * 
             * 
             */
            if(strpos($url,"/") > -1) {
                // url est de la forme class/method/...
                $url = explode("/",$url) ;
                if(count($url) > 2) {
                    // Misy parametre 
                    $class = $url[0] ;
                    $method = $url[1] ;
                    $param = [] ;
                    for($i = 2; $i < count($url); $i++) {
                        array_push($param, $url[$i]) ;
                    }
                    if(file_exists("Controls/".$class.".php")) {
                        if(method_exists($class,$method)) {
                            $reflect = new ReflectionMethod($class,$method) ;
                            $reflect->invokeArgs(new $class,$param) ;
                        }
                        else {
                            InitializerControls::loadViews("errors/error404") ;
                        }
                    }
                    else {
                        InitializerControls::loadViews("errors/error404") ;
                    }
                    
                }
                else {
                    // tsy misy parametre
                    $class = $url[0] ;
                    $method = $url[1] ;
                    if(file_exists("Controls/".$class.".php")) {
                        if(method_exists($class,$method)) {
                            $reflect = new ReflectionMethod($class,$method) ;
                            $reflect->invoke(new $class) ;
                        }
                        else {
                            InitializerControls::loadViews("errors/error404") ;
                        }
                    }
                    else {
                        InitializerControls::loadViews("errors/error404") ;
                    }
                }
            }
            else {
                // url est de la forme class
                if(file_exists("Controls/".$url.".php")) {
                    if(method_exists($url,"index")) {
                        $reflect = new ReflectionMethod($url,"index") ;
                        $reflect->invoke(new $url) ;
                    }
                    else {
                        InitializerControls::loadViews("errors/error404") ;
                    }
                }
                else {
                    InitializerControls::loadViews("errors/error404") ;
                }
            }
        }
            
            
        
    }
