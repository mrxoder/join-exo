<?php

include("autoload.php");

class install{
	
	function __construct(){
		
		$this->tab = ["users", "etudiant", "professeur", "classe", "matiere"];
	    $this->db = new models\sql();
	    if(!$this->db){ return ["status"=>False, "message"=>"Failed to connect to database server."];}
	    if(!$this->checkTable()){
			$this->createTables();
			header("location: index.php");
		}else{
			
		}
	    
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
		$req["user"] = "CREATE TABLE `users` ( `id` int(11) NOT NULL AUTO_INCREMENT, `username` varchar(32) NOT NULL UNIQUE,`password` varchar(200) NOT NULL,`name` varchar(150) NOT NULL, PRIMARY KEY(id))";
		$req["etudiant"]="CREATE TABLE `professeur` (`id` int(11) NOT NULL AUTO_INCREMENT,`nom` varchar(100) DEFAULT NULL,`naissance` varchar(100) DEFAULT NULL,`adresse` varchar(100) DEFAULT NULL,`idmatiere` int(11) DEFAULT NULL,`idclasse` int(11) DEFAULT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
		$req["professeur"]="CREATE TABLE `professeur` (`id` int(11) NOT NULL AUTO_INCREMENT,`nom` varchar(100) DEFAULT NULL,`naissance` varchar(100) DEFAULT NULL,`adresse` varchar(100) DEFAULT NULL,`idmatiere` int(11) DEFAULT NULL,`idclasse` int(11) DEFAULT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
		$req["classe"]="CREATE TABLE `classe` (`id` int(11)  NOT NULL AUTO_INCREMENT,`libelle` varchar(100) NOT NULL UNIQUE,`capacite` int(11) DEFAULT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
		$req["matiere"]="CREATE TABLE `matiere` ( `id` int(11) NOT NULL AUTO_INCREMENT,`coefficient` int(11) NOT NULL,`nommatiere` varchar(100) DEFAULT NULL UNIQUE,`description` varchar(100) DEFAULT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    }
     
}




?>
