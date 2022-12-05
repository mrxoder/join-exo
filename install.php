<?php

include("db.php");

class install{
	
	function __construct(){
		
		$this->tab = ["users", "etudiant", "professeur", "classe", "matiere"];
	    $this->db = new sql();
	    if(!$this->db){ return ["status"=>False, "message"=>"Failed to connect to database server."];}
	}
	
	public function checkTables(){
		$result = [];
		foreach($this->tab as $tb){
		    $result[$tb] = $this->db->checkTable($tb);
		}
		
		return $result;
	}
	
	public function createTables(){
		$req = [];
		$req["user"] = "CREATE TABLE `users` ( `id` int(11) NOT NULL, `username` varchar(32) NOT NULL UNIQUE,`password` varchar(200) NOT NULL,`name` varchar(150) NOT NULL)";
		
		
    }
}


?>
