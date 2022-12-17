<?php

class classe{
	
	public function __construct(){
		$this->db = new Database();
		$this->sql = new sql();
	}
	
	public function index(){
		InitializerControls::loadViews("classe");
	}
	
	public function update(){
		$res = null;
		if(empty($_POST["id"])){
			
			$res = $this->db->insert("classe")
			->parametters(["libelle", "capacite"])
		    ->execute([ $_POST["libelle"], $_POST["capacity"] ]);
			
		}else{
			
			$res = $this->db->update("classe")
			->parametters(["libelle", "capacite"])
			->where("id","=")
			->execute([$_POST["libelle"], $_POST["capacity"], $_POST["id"]]);
			
		}
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
		
	}
	
	
	public function getlist(){
		
		$res = $this->db->select("classe")
		->execute();
		echo(json_encode(["status"=>"success", "data"=>$res]));
	}
	
	public function delete($id){
		
		$student = $this->sql->getstudents($id);
		$profs  = $this->sql->getProf($id);
		
		$res = false;
		
		if(count($student)==0 && count($profs)==0 ){
		
			$res = $this->db->delete("classe")
			->where("id", "=")
			->execute([$id]);
	    }
	    
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
		
	}
	
	public function get($id){
		$res = $this->db->select("classe")
		->where("id", "=")
		->execute([$id]);
		
		echo(json_encode(["status"=>"success", "data"=>$res]));
	}
	
}

?>
