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
	
	public function newstudent($username,$class, $name=""){
		   
		   $db = $this->db;
		   $user_id = ($this->getUser($username))["id"];
		   $classdb = $this->getclass();
		   $class_id = null;
		   foreach($classdb as $item){
			   if($item["class_name"]==$class){
			      $class_id = $item["id"];
			   }
		   }
		   if(!$user_id || $class_id==null){ return false;}
		   
		   if(empty($this->getStudent($user_id))){
			   $prep = $db->prepare("insert into students(user_id, class_id) value(?, ?)");
			   if($prep->execute([$user_id, $class_id])){
				   return $this->setrole("student", $username);
			   }
		   }else{
			   $prep = $db->prepare("update students set class_id=? where user_id=?");
			   $prep->execute([$class_id, $user_id]);
		   }
		   if(!empty($name)){
			  $this->changename($username, $name);
		   }
		   
		   return true;
		   
	}
	
	public function newprof($class, $course, $username, $name){
		   $db = $this->db;
		   $user_id = ($this->getUser($username))["id"];
		   $classdb = $this->getclass();
		   $coursedb = $this->getcourses();
		   $class_id = null;
		   $course_id = null;
		   foreach($classdb as $item){
			   if($item["class_name"]==$class){
			      $class_id = $item["id"];
			      break;
			   }
		   }
		   foreach($coursedb as $item){
			   if($item["course_name"]==$course){
			      $course_id = $item["id"];
			      break;
			   }
		   }
		   
		   if((!$user_id) || $class_id==null|| $course_id==null){ return false;}
		   
		   if(empty($this->getProf($user_id))){
		       $prep = $db->prepare("insert into prof(user_id, course_id, class_id) value(?, ?, ?)");
		       $prep->execute([$user_id, $course_id, $class_id]);
		       return $this->setrole("prof", $username);
		   }else{
			 
			  $prep = $db->prepare("update prof set class_id=?,course=? where user_id=?");
			  $prep->execute([$class_id, $course,$user_id]);
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
		   $prep = $db->prepare("SELECT users.id,username,password,name,role,classes.class_name FROM `users` INNER JOIN students ON users.id=students.user_id INNER JOIN classes on students.class_id=classes.id WHERE username=?");
		   $prep->execute([$username]);
		   $data = $prep->fetch();
		   if(empty($data)){
			  $prep = $db->prepare("SELECT users.id,username,password,name,role,classes.class_name,courses.course_name FROM `users` INNER JOIN prof ON users.id=prof.user_id INNER JOIN classes on prof.class_id=classes.id INNER JOIN courses ON prof.course_id=courses.id WHERE username=?");
		      $prep->execute([$username]);
		      $data = $prep->fetch();
		      if(empty($data)){
				 $prep = $db->prepare("SELECT * FROM users where username=?");
				 $prep->execute([$username]);
		         $data = $prep->fetch();
			  }
		   }   
		   return $data;
	}
	
	public function getclassStudent($classid){
		$db = $this->db;
		$prep = $db->prepare("SELECT users.id,username,name,role,classes.class_name FROM `users` INNER JOIN students ON users.id=students.user_id INNER JOIN classes on students.class_id=classes.id WHERE students.class_id=?");
	    $prep->execute([$classid]);
	    return $prep->fetchAll();
	}
	
	public function getclassProf($classid){
		$db = $this->db;
		$prep = $db->prepare("SELECT users.id,username,name,role,classes.class_name,courses.course_name FROM `users` INNER JOIN prof ON users.id=prof.user_id INNER JOIN classes on prof.class_id=classes.id INNER JOIN courses ON prof.course_id=courses.id WHERE prof.class_id=?");
	    $prep->execute([$classid]);
	    return $prep->fetchAll();
	}
	
	public function getclass(){
		$db = $this->db;
		$prep = $db->prepare("select * from classes");
		$prep->execute();
		return $prep->fetchAll();   
	}
	
	public function getcourses(){
		$db = $this->db;
		$prep = $db->prepare("select * from courses");
		$prep->execute();
		return $prep->fetchAll();
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
		$dbpwd  = $this->getUser($user)["password"];
		return password_verify($pwd, $dbpwd);
	}
	
	
}
	
?>
