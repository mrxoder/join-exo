<?php 

class sql{
	
	function __construct($host="localhost", $user="root", $pwd="", $dbname="school"){
				  $this->host = $host;
				  $this->user = $user;
				  $this->pwd = $pwd;
				  $this->dbname = $dbname;
				  $this->db = $this->connect();
	 			  
	}
	
	private function connect(){
				
		    $host = "mysql:host={$this->host};dbname={$this->dbname}";
			try{
				$sql = new PDO($host, $this->user, $this->pwd);
			    return $sql;
			}catch(PDOException $e){
				  return Null;
			}
    }
		
	public function newuser($user, $pwd, $name){
		   $db = $this->db;
		   $pwd  = password_hash($pwd, 1);
		   $prep = $db->prepare("insert into users(username, password, name) value(?, ?, ?)");
		   return $prep->execute([$user, $pwd, $name]);
	}
	
	public function newstudent($username, $grade, $mention, $name=""){
		   
		   $db = $this->db;
		   $user_id = ($this->getUser($username))["id"];
		   if(!$user_id){ return false;}
		   
		   if(($this->getStudent($user_id))["user_id"]!=$user_id){
			   $prep = $db->prepare("insert into students(user_id, grade, mention) value(?, ?, ?)");
			   if($prep->execute([$user_id, $grade, $mention])){
				   return $this->setrole("student", $username);
			   }
		   }else{
			   $prep = $db->prepare("update users set grade=?, mention=? where id=?");
			   $prep->execute([$grade, $mention, $user_id]);
		   }
		   if(!empty($name)){
			  $this->changename($username, $name);
		   }
		   
		   return true;
		   
	}
	
	public function newprof($course, $username, $name){
		   $db = $this->db;
		   $user_id = ($this->getUser($username))["id"];
		   if(!$user_id){ return false;}
		   
		   if(!($this->getProf($user_id))){
		     $prep = $db->prepare("insert into prof(user_id, course) value(?, ?)");
		     $prep->execute([$user_id, $course]);
		     return $this->setrole("prof", $username);
		   }else{
			 
			 $prep = $db->prepare("update prof set course=? where user_id=?");
			 $prep->execute([$course, $user_id]);
		   }   
		   
		   if(!empty($name)){
			  $this->changename($username, $name);
		   }
		   return true;
		   
	}
	
	public function changename($username, $name)
	{
		$db = $this->db;
	    $prep = $db->prepare("update users set name=? where username=?");
	    return $prep->execute([$name, $username]);
	}
	
	public function getUser($username){
		   $db = $this->db;
		   $prep = $db->prepare("select * from users where username=?");
		   $prep->execute([$username]);
		   
		   return $prep->fetch();
	}
	
	public function getStudent($id){
		   $db = $this->db;
		   $prep = $db->prepare("select * from students where user_id=?");
		   $prep->execute([$id]);
		   
		   return $prep->fetch();
	}
	
	public function getProf($id){
		   $db = $this->db;
		   $prep = $db->prepare("select * from prof where user_id=?");
		   $prep->execute([$id]);
		   
		   return $prep->fetch();
	}
	
	
	
	public function userid($username){
		   $db = $this->db;
		   $prep = $db->prepare("select id from users where username=?");
		   $prep->execute([$username]);
		   return $prep->fetch();
	}
	
	
	public function setrole($role, $username){
		$db = $this->db;
	    $prep = $db->prepare("update users set role=? where username=?");
	    return $prep->execute([$role, $username]);
	}
	
	public function login($user, $pwd){
		$dbpwd  = ($this->getUser($user))["password"];
		return password_verify($pwd, $dbpwd);
	}
	
	
}
	
?>
