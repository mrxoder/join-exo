<?php

    class UserControls {
        public function index() {
            echo " " ;
        }
        
        public function register() {
            $db = new Database() ;
            $db->insert("users")
               ->parametters(["name","username","password"])
               ->execute([$_POST['name'],$_POST['username'], password_hash($_POST['pwd'],1)]) ;
            if($db){
              echo "Success" ;
		    }
        }

        public function connect() {
            $db = new Database() ;
            $res = $db->select("users")
                      ->where("username" ,"=")
                      ->execute([$_POST['username']]) ;
            
            if(password_verify($_POST["pwd"], ($res[0])->password )) {
                echo "users" ;
                $_SESSION["username"] = ($res[0])->username;
            }else{
                echo "not-users" ;
            }
        }
    }
