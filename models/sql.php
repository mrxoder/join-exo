<?php 

namespace models;

class sql{
	
	private static $dbs=null;
	
	function __construct(){
          
		  $this->host = "localhost";//sql host
		  $this->user = "root";//sql user
		  $this->pwd = "";//sql password
		  $this->dbname = "school";//sql database name
		  if(is_null(self::$dbs)){
		     self::$dbs = $this->connect();
		  }
		  $this->db = self::$dbs;
	}
	
	private function connect(){
			
		    $host = "mysql:host={$this->host};dbname={$this->dbname}";
			try{
				$sql = new \PDO($host, $this->user, $this->pwd);
			    return $sql;
			}catch(PDOException $e){
				  return False;
			}
    }
	
	public function insert($table, $data){
		
		$keys = array_keys($data);
		$q = [];
		$values = array_values($data);
		for($i=0;$i<count($keys);$i++){
		    array_push($q, "?");
		}
		$sqlreq = "insert into {$table}(". implode(",", $keys) .") value(".implode(",", $q).")";
		
		$prep = $this->db->prepare($sqlreq);
		return $prep->execute($values);
		
	}
	
    public function checkTable($tab){
		$prep = $this->db->prepare("select 1 from $tab limit 1");
		return $prep->execute();
	}
	
	public function newuser($user, $pwd, $name, $id=""){
		   $db = $this->db;
		   $pwd  = password_hash($pwd, 1);
		   if($id==""){
			   
		       return $this->insert("users", ["username"=>$user, "password"=>$pwd, "name"=>$name]);
		       
		   }else{
			   $prep = $db->prepare("update users set username=?, password=?, name=? where id=?");
		       return $prep->execute([$user, $pwd, $name, $id]);
		   }
	}
	
	public function newstudent($name,$birth, $parent, $addr, $class, $description="", $id=""){
		   
		   $db = $this->db;
		   $classdb = $this->getclass();
		   
		   $cclass = null;
		   foreach($classdb as $item){
			   if($item["id"]==$class){
			      $class= $item;
			   }
		   }
		   if($cclass){ return false;}
		   
		   
		   if($id==""){
			   
			   if( count($this->getStudent($class["id"])) >= (int)($class["capacite"])){ 
				   
				   return False;
			   }
			   
			   return $this->insert("etudiant", [ "nom"=>$name, 
				   "naissance"=>$birth,
				   "parents"=>$parent,
				   "adresse"=>$addr,
				   "idclasse"=>$class["id"],
				   "description"=>$description
			   ]);
			   
		   }else{
			   $prep = $db->prepare("update etudiant set nom=?, naissance=?, parents=?, adresse=?, idclasse=?, description=? where id=?");
			   return $prep->execute([$name,$birth, $parent, $addr, $class["id"], $description, $id]);
		   }
	}
	
	
	public function newprof($name, $birth, $course, $addr, $class, $id=""){
		   
		   $db = $this->db;
		   $classdb = $this->getclass();
		   
		   $cclass = null;
		   foreach($classdb as $item){
			   if($item["id"]==$class){
			      $class= $item;
			   }
		   }
		   if($cclass){ return false;}
		   
		   
		   if($id==""){
			   return $this->insert("professeur", ["nom"=>htmlentities($name),"naissance"=>$birth, "adresse"=>htmlentities($addr), "idmatiere"=>$course, "idclasse"=>$class["id"]]);
		   }else{
			   $prep = $db->prepare("update professeur set nom=?, naissance=?, adresse=?, idmatiere=?, idclasse=? where id=?");
			   return $prep->execute([htmlentities($name),$birth, htmlentities($addr), $course,$class["id"], $id]);
		   }
		   
	}
	
	public function newClass($libelle, $capacity, $id=""){
		$classes = $this->getclass();
		$db = $this->db;
		
		if($id==""){
			return $this->insert("classe", ["libelle"=>$libelle, "capacite"=>$capacity]);
		}else{
			$prep = $db->prepare("update classe set libelle=?,capacite=? where id=?");
			return $prep->execute([$libelle, $capacity, $id]);
	    }
	}
	
	public function newCourse($name, $coef, $descr, $id=""){
		$db = $this->db;
		if($id==""){
			
			return $this->insert("matiere", ["nommatiere"=>htmlentities($name), "coefficient"=>$coef, "description"=>htmlentities($descr)]);
		}else{
			
			$prep = $db->prepare("update matiere set nommatiere=?,coefficient=?,description=? where id=?");
			return $prep->execute([htmlentities($name), $coef, htmlentities($descr), $id]);
	    }
	}
	
	
	public function getclass(){
		$db = $this->db;
		$prep = $db->prepare("select * from classe");
		$prep->execute();
		return $prep->fetchAll();   
	}
	
	public function getcourses(){
		$db = $this->db;
		$prep = $db->prepare("select * from matiere");
		$prep->execute();
		return $prep->fetchAll();
	}
	
	public function getStudent($classid){
		   $db = $this->db;
		   $prep = $db->prepare("select etudiant.id,nom,naissance,parents,description,adresse,classe.id as classId,classe.libelle from etudiant inner join classe on etudiant.idclasse=classe.id where classe.id=?");
		   $prep->execute([$classid]);
		   
		   return $prep->fetchAll();
	}
	
	public function getProf($classid){
		   $db = $this->db;
		   $prep = $db->prepare("select professeur.id,nom,naissance,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where classe.id=?");
		   $prep->execute([$classid]);
		   
		   return $prep->fetchAll();
	}
	
	public function getProfBycourse($courseId){
		   $db = $this->db;
		   $prep = $db->prepare("select professeur.id,nom,naissance,adresse,classe.id as classId,matiere.id as matiereId, matiere.nomMatiere,classe.libelle from professeur inner join classe on professeur.idclasse=classe.id INNER JOIN matiere ON professeur.idmatiere=matiere.id where matiere.id=?");
		   $prep->execute([$courseId]);
		   
		   return $prep->fetchAll();
	}
	
	public function getUser($user){
		$prep = $this->db->prepare("select * from users where username=?");
		$prep->execute([$user]);
		return $prep->fetch();
	}
	
	
	public function deleteClasse($id){
		$students = $this->getStudent($id);
		$profs = $this->getProf($id);
		if(!count($student)>0 || !count($prof)>0){
			return False;
		}
		$prep = $this->db->prepare("DELETE FROM classe WHERE id=?");
		return $prep->execute([$id]);
	}
	
	public function deleteCourse($id){
		if(count($this->getProfBycourse($id))>0){ return false;}
		$prep = $this->db->prepare("DELETE FROM matiere WHERE id=?");
		return $prep->execute([$id]);
		
		
	}
	
	public function deleteStudent($id){
		$prep = $this->db->prepare("DELETE FROM etudiant WHERE id=?");
		return $prep->execute([$id]);
	}
	
	public function deleteProf($id){
		$prep = $this->db->prepare("DELETE FROM professeur WHERE id=?");
		return $prep->execute([$id]);
	}
	
	
	public function login($user, $pwd){
		$dbpwd  = $this->getUser($user)["password"];
		return password_verify($pwd, $dbpwd);
	}
	
}
	
?>
