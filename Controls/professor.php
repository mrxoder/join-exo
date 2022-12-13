<?php

class professor{
	
	
	public  function __construct(){
		$this->db = new Database();
		$this->sql = new sql();
	}
	
	public function index(){
		InitializerControls::loadViews("professor");
	}
	
	
	public function update(){
		
		$res = null;
		if(empty($_POST["id"])){
			
			$res = $this->db->insert("professeur")
			->parametters(["nom","naissance", "adresse", "idmatiere", "idclasse"])
		    ->execute([ $_POST["nom"], $_POST["date"]."#".htmlentities($_POST["lieu"]), $_POST["addr"], $_POST["matiere"], $_POST["classe"]]);
			
		}else{
			
			$res = $this->db->update("professeur")
			->parametters(["nom","naissance", "adresse", "idmatiere", "idclasse","gender"])
			->where("id","=")
			->execute([ $_POST["nom"], $_POST["date"]."#".htmlentities($_POST["lieu"]), $_POST["addr"], $_POST["matiere"], $_POST["classe"], $_POST["gender"], $_POST["id"]]);
			
		}
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
		
	}
	
	public function getlist($classid){
		
		$res = $this->sql->getProf($classid);
		echo(json_encode(["status"=>"success", "data"=>$res]));
		
	}
	
	
	public function delete($id){
		
		return $this->db->delete("professeur")
		->where("id", "=")
		->execute([$id]);
		
	}
	
	
	public function get($classid,$id){
		
		$res = $this->db->select("professeur")
		->where("id", "=")
		->execute([$id]);
		echo(json_encode(["status"=>"success", "data"=>$res]));
		
	}
	
	
}


?>
