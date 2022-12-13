<?php


class course{
	
	public  function __construct(){
		$this->db = new Database();
		$this->sql = new sql();
	}
	
	public function index(){
		InitializerControls::loadViews("course");
	}
	
	public function update(){
		$res = null;
		
		if(empty($_POST["id"])){
			
			$res = $this->db->insert("matiere")
			->parametters(["coefficient", "nommatiere", "description"])
		    ->execute([$_POST["coef"], $_POST["name"], $_POST["descr"]]);
		    
			
		}else{
			
			$res = $this->db->update("matiere")
			->parametters(["coefficient", "nommatiere", "description"])
			->where("id","=")
			->execute([$_POST["coef"],$_POST["name"], $_POST["descr"], $_POST["id"]]);
			
		}
		
		if($res){
			echo(json_encode(["status"=>"success"]));
		}else{
			echo(json_encode(["status"=>"failed"]));
		}
		
	}
	
	
	public function getlist(){
		$res = $this->sql->getcourses();
		echo(json_encode(["status"=>"success", "data"=>$res]));
	}
	
	
	public function delete($id){
		
		$courses = $this->sql->getprofbycourse($id);
		
		$res = false;
		
		if(count($courses)==0){
			$res = $this->db->delete("matiere")
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
		
		$res = $this->db->select("matiere")
		->where("id", "=")
		->execute([$id]);
		echo(json_encode(["status"=>"success", "data"=>$res]));
		
	}
	
}

?>
