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
		$message = "";
		
		if(empty($_POST["id"])){
			if(!$this->sql->getprofcnc($_POST["matiere"], $_POST["classe"])){
				$res = $this->db->insert("professeur")
				->parametters(["nom","naissance", "adresse", "idmatiere", "idclasse"])
			    ->execute([htmlentities( $_POST["nom"]), htmlentities($_POST["date"])."_".htmlentities($_POST["lieu"]), htmlentities($_POST["addr"]), htmlentities($_POST["matiere"]), htmlentities($_POST["classe"])]);
			}else{
				$message = "Within a class, 1 professor for 1 course";
			}
		}else{
			
			$prf = $this->sql->getprofcnc($_POST["matiere"], $_POST["classe"]);
			
			for($i=0;$i<count($prf);$i++){
				if($prf[$i]->id==$_POST["id"]){
			       unset($prf[$i]);
			    }
			}
			
			
			
			if(count($prf)==0){
				$res = $this->db->update("professeur")
				->parametters(["nom","naissance", "adresse", "idmatiere", "idclasse","gender"])
				->where("id","=")
				->execute([ $_POST["nom"], $_POST["date"]."_".htmlentities($_POST["lieu"]), $_POST["addr"], $_POST["matiere"], $_POST["classe"], $_POST["gender"], $_POST["id"]]);
			}else{
				$message = "Within a class, 1 professor for 1 course";
			}
		}
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed", "message"=>$message]));
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
