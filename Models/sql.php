<?php

class sql{
	
	public function __construct(){
		$this->db = new Database();
	}
	
	
	public function getclass(){
		$res = $this->db->select("classe")
		->execute([]);
		return $res;   
	}
	
	public function getcourses(){
		$res = $this->db->select("matiere")
		->execute();
		return $res;
	}
	
	public function getstudents($classid){
		   $db = $this->db;
		   $res = $db->customSelect("select etudiant.id,nom,gender,naissance,parents,description,adresse,classe.id as classId,classe.libelle from etudiant inner join classe on etudiant.idclasse=classe.id where classe.id=?", [$classid]);
		   return $res;
	}
	
	public function getProf($classid){
		
	       $db = $this->db;
		   $res = $db->customSelect("select professeur.id,nom,naissance,gender,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where classe.id=?", [$classid]);
		   return $res;
	}
	
	public function getprofbycourse($courseid){
		   $db = $this->db;
		   $res = $db->customSelect("select professeur.id,nom,naissance,gender,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where matiere.id=?", [$courseid]);
		   return $res;
	}
	
	public function format($arr){
		return 1;
	}
	
	
}

?>
