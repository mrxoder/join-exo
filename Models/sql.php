<?php

class sql{
	
	public function __construct(){
		$this->db = new Database();
		$this->sanitizer = new xss();
	}
	
	public function len($table){
		
		$n = $this->db->countRow($table)
		->execute();
		return $n;
	}
	
	
	public function getclass(){
		$res = $this->db->select("classe")
		->limit(10)
		->execute([]);
		return $this->sanitizer->sanitize($res);   
	}
	
	
	public function getcourses(){
		$res = $this->db->select("matiere")
		->limit(10)
		->execute();
		return $this->sanitizer->sanitize($res);
	}
	
	public function getstudents($classid){
		   $db = $this->db;
		   $res = $db->customSelect("select etudiant.id,nom,gender,naissance,parents,description,adresse,classe.id as classId,classe.libelle from etudiant inner join classe on etudiant.idclasse=classe.id where classe.id=? order by etudiant.id desc limit 10", [$classid]);
		   return $this->sanitizer->sanitize($res);
	}
	
	public function getProf($classid){
		   
	       $db = $this->db;
		   $res = $db->customSelect("select professeur.id,nom,naissance,gender,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where classe.id=? order by professeur.id desc limit 10", [$classid]);
		   
		   return $this->sanitizer->sanitize($res);
	}
	
	public function getprofbycourse($courseid){
		   $db = $this->db;
		   $res = $db->customSelect("select professeur.id,nom,naissance,gender,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where matiere.id=? order by professeur.id desc limit 10", [$courseid]);
		   return $this->sanitizer->sanitize($res);
	}
	
	public function getprofcnc($courseid, $classid){
		   $db = $this->db;
		   $res = $db->customSelect("select professeur.id,nom,naissance,gender,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where matiere.id=? and classe.id=?", [$courseid, $classid]);
		   return $this->sanitizer->sanitize($res);
	}
	
	public function format($arr){
		return 1;
	}
	
	
}

?>
