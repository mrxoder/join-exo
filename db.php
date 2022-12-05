<?php 

class sql{
	
	function __construct(){
          //sql config
		  $this->host = "localhost";//sql host
		  $this->user = "root";//sql user
		  $this->pwd = "";//sql password
		  $this->dbname = "school";//sql database name
		  $this->db = $this->connect();
	}
	
	private function connect(){
				
		    $host = "mysql:host={$this->host};dbname={$this->dbname}";
			try{
				$sql = new PDO($host, $this->user, $this->pwd);
			    return $sql;
			}catch(PDOException $e){
				  return False;
			}
    }
	
    public checkTable($tab){
		$prep = $this->db->prepare("select 1 from $tab limit 1");
		return $prep->execute();
	}
	
	public function newuser($user, $pwd, $name, $id=""){
		   $db = $this->db;
		   $pwd  = password_hash($pwd, 1);
		   if($id==""){
		       $prep = $db->prepare("insert into users(username, password, name) value(?, ?, ?)");
		       return $prep->execute([$user, $pwd, $name]);
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
			   
			   $prep = $db->prepare("insert into etudiant(nom, naissance, parents, adresse, idclasse, description) value(?,?,?,?,?,?)");
			   return $prep->execute([$name,$birth, $parent, $addr, $class["id"], $description]);
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
			   
			   $prep = $db->prepare("insert into professeur(nom, naissance, adresse, idmatiere, idclasse) value(?,?,?,?,?)");
			   return $prep->execute([$name,$birth, $addr, $course, $class["id"]]);
		   }else{
			   $prep = $db->prepare("update professeur set nom=?, naissance=?, adresse=?, idmatiere=?, idclasse=? where id=?");
			   return $prep->execute([$name,$birth, $addr, $course,$class["id"], $id]);
		   }
		   
	}
	
	public function newClass($libelle, $capacity, $id=""){
		$classes = $this->getclass();
		$db = $this->db;
		
		if($id==""){
			
			$prep = $db->prepare("insert into classe(libelle, capacite) value(?, ?)");
			return $prep->execute([$libelle, $capacity]);
		}else{
			$prep = $db->prepare("update classe set libelle=?,capacite=? where id=?");
			return $prep->execute([$libelle, $capacity, $id]);
	    }
	}
	
	public function newCourse($name, $coef, $descr, $id=""){
		$db = $this->db;
		if($id==""){
			$prep = $db->prepare("insert into matiere(nommatiere, coefficient, description) value(?, ?, ?)");
			return $prep->execute([$name, $coef, $descr]);
		}else{
			echo("update");
			$prep = $db->prepare("update matiere set nommatiere=?,coefficient=?,description=? where id=?");
			return $prep->execute([$name, $coef, $descr, $id]);
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
	
	public function getUser($user){
		$prep = $this->db->prepare("select * from users where username=?");
		$prep->execute([$user]);
		return $prep->fetch();
	}
	
	
	public function deleteClasse($id){
		$prep = $this->db->prepare("DELETE FROM classe WHERE id=?");
		return $prep->execute([$id]);
	}
	
	public function deleteCourse($id){
		$prep = $this->db->prepare("DELETE FROM matiere WHERE id=?");
		return $prep->execute([$id]);
	}
	
	public function deleteStudent($id){
		$prep = $this->db->prepare("DELETE FROM etudiant WHERE id=?");
		return $prep->execute([$id]);
	}
	
	
	public function login($user, $pwd){
		$dbpwd  = $this->getUser($user)["password"];
		return password_verify($pwd, $dbpwd);
	}
	
}
	
?>
