<?php

class students{
	
	
	public  function  __construct(){
		$this->db = new Database();
		$this->sql = new sql();
	}
	
	public function index(){
		InitializerControls::loadViews("student");
	}
	
	public function update(){
		
		$res = null;
		if(empty($_POST["id"])){
			
			$res = $this->db->insert("etudiant")
			->parametters(["nom","naissance", "adresse", "parents", "idclasse", "gender", "description"])
		    ->execute([ $_POST["nom"], $_POST["date"]."#".htmlentities($_POST["lieu"]), $_POST["addr"], htmlentities($_POST["pnom"])."#".htmlentities($_POST["mnom"]), $_POST["classe"], $_POST["gender"], $_POST["descr"]]);
			
		}else{
			
			$res = $this->db->update("etudiant")
			->parametters(["nom","naissance", "adresse", "parents", "idclasse","gender", "description"])
			->where("id","=")
			->execute([ $_POST["nom"], $_POST["date"]."#".htmlentities($_POST["lieu"]), $_POST["addr"],  htmlentities($_POST["pnom"])."#".htmlentities($_POST["mnom"]) , $_POST["classe"], $_POST["gender"], $_POST["descr"], $_POST["id"]]);
			
		}
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
	}
	
	
	public function getlist($classid){
		
		$res = $this->sql->getstudents($classid);
		
		echo(json_encode(["status"=>"success", "data"=>$res]));
	}
	
	public function delete($id){
		
		$res = $this->db->delete("etudiant")
		->where("id", "=")
		->execute([$id]);
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
	}
	
	
	public function get($classid, $id){
		
		$res = $this->db->select("etudiant")
		->where("id", "=")
		->execute([$id]);
		echo(json_encode(["status"=>"success", "data"=>$res]));
	}
	
}


?>
