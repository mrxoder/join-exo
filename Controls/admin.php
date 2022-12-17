<?php

class admin{
	
	public function __construct(){
		$this->db = new Database();
	}
	public function index(){
		InitializerControls::loadViews("admin") ;
	}
	
	public function get(){
		
		$res = $this->db->select("users")
		->where("username", "=")
		->execute([$_SESSION["username"]]);
		if($res){
			echo(json_encode( ["status"=>"success", "username"=>($res[0]->username), "name"=>($res[0]->name) ] ));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
	}
	
	public function update(){
		
		$credential = $this->db->select("users")
		->where("username" ,"=")
		->execute([$_SESSION['username']]) ; 
		
		$res = false;
		
		if(password_verify($_POST["currentpwd"],$credential[0]->password) && !empty($_POST["npwd"]) && !empty($_POST["retype"]) ){
			
			if($_POST["npwd"] == $_POST["retype"]){
				
				$res = $this->db->update("users")
				->parametters(["name","password"])
				->where("username", "=")
				->execute([$_POST["name"], password_hash($_POST["npwd"], 1), $_SESSION["username"]]);
				
			}
		}
		
		
		if($res){
			echo(json_encode( ["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
		
	}
}

?>
