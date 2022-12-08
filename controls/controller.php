<?php


namespace controls;

class controller{
	
	public function __construct($db){
		$this->db = $db;
		$this->classes = $db->getclass();
	}
	
	public function admin(){
		
		$db = $this->db;	
		
		if(!empty($_POST["action"])){
			
			switch($_POST["action"]){
				
				case "update":
					if(!empty($_POST["name"]) && !empty($_POST["currentpwd"]) && !empty($_POST["npwd"]) && !empty($_POST["retype"]) ){
					    if($_POST["retype"]!=$_POST["npwd"]){
							echo(json_encode(["status"=>"fail", "message"=>"Password confirmation doesn't match."]));
						}
						
						if($db->login($_SESSION["username"], $_POST["currentpwd"])){
						   if($db->newuser($_SESSION["username"], $_POST["npwd"], $_POST["name"], $user["id"])){
							    echo(json_encode(["status"=>"success", "message"=>"Saved."]));
							    
						   }else{ 
							    echo(json_encode(["status"=>"fail", "message"=>"Failed to update the account."]));
						   }
						}else{ 
							echo(json_encode(["status"=>"fail", "message"=>"Incorrect current password."]));
							
						}
				   }
				break;
				
				case "get":
				    $user = $db->getUser($_SESSION["username"]);
				    if($user){
				       echo(json_encode([
				           "status"=>"success", 
				           "name"=>$user["name"],
				           "username"=>$user["username"]
				           ]));
				    }else{
					   echo(json_encode(["status"=>"fail"]));
					}
			    break;
			}
			    			   
		}else{
			 include("views/admin.html");
		}
	}
	
	public function school(){
		
		$db = $this->db;
		
		if(!empty($_POST["action"])){
			
			switch($_POST["action"]){
				case "getinfo":
				    
				    $classes = $db->getclass();
				    $total_st = 0;
				    $total_prf = 0;
				    $sts = [];
				    $profs = [];
			        foreach($classes as $class){
					   $students = $db->getStudent($class["id"]);
					   $total_st +=count($students);
					   $profs = $db->getProf($class["id"]);
					   $total_prf +=count($profs);
					   array_push($sts, [ "name"=>$class["libelle"], "capacite"=>$class["capacite"], "students"=>count($students), "profs"=>count($profs) ]);
					}
				    echo(json_encode([ "status"=>"success", "data"=>$sts, "totalst"=>$total_st, "totalprf"=>$total_prf ]));
				    
				break;
				
			}
			
		}else{
			 include("views/school.html");
		}
	}
	
	public function classe(){
		$db = $this->db;
		
		if(!empty($_POST["action"])){
			
			switch($_POST["action"]){
				case "update":
				    
				    $cid = "";

					if(!empty($_POST["libelle"]) && !empty($_POST["capacity"])){
						   if(!empty($_POST["id"])){
							   $cid = $_POST["id"];
						   }
						   
						   if($db->newClass($_POST["libelle"], $_POST["capacity"], $cid)){
							   echo(json_encode(["status"=>"success"]));
						   }else{
							   echo(json_encode(["status"=>"fail"]));
						   }
					}
					
				    break;
				    
				case "getlist":
				    $classes = $this->classes;
				    echo(json_encode(["status"=>"success", "data"=>$classes]));
				break;
				
				case "edit":
				    
				    if(!empty($_POST["id"])){
						
						foreach($classes as $class)
						{
							if($_POST["id"]==$class["id"])
							{
								$cclass = $class;
								echo(json_encode(["status"=>"success", "libelle"=>$cclass["libelle"], "id"=>$cclass["id"], "capacite"=>$cclass["capacite"] ]));
								break;
							}
						}
						
					}
					
					break;
			    
			    
			    case "delete":
				    
				    if(!empty($_POST["id"])){
						
						if($db->deleteClasse($_POST["id"])){
							echo(json_encode(["status"=>"success"]));
						}else{
							echo(json_encode(["status"=>"fail"]));
						}
						
					}
			        break;
			}    
			
	    }else{
			include("views/classe.html");
		}
	}
	
	public function student(){
		$db = $this->db;
		
		if(!empty($_POST["action"])){
			
			$classes = $db->getclass();
			 
			switch($_POST["action"]){
				
				case "edit":
				     if(!empty($_POST["id"]) && $_POST["classid"]){
				        $students = $db->getStudent($_POST["classid"]);
						foreach($students as $item){
							if($_POST["id"]==$item["id"]){
							   echo(json_encode(["status"=>"success", "data"=>$item]));
							   break;
							}
					    }
					}
				break;
				
				case "delete":
				    if(!empty($_POST["id"])){
						if($db->deleteStudent($_POST["id"])){
							echo(json_encode(["status"=>"success"]));
						}else{
							echo(json_encode(["status"=>"fail"]));
						}
					}
				break;
				
				case "update":
				    
				    if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["pnom"]) && !empty($_POST["mnom"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
							$description = "";
							$cid = "";
							if(!empty($_POST["descr"])){ $description = $_POST["descr"];}
							if(!empty($_POST["id"])){ $cid = $_POST["id"];}
							
							if($db->newstudent($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $_POST["pnom"]."#".$_POST["mnom"], $_POST["addr"], $_POST["classe"], $description, $cid)){
							    echo(json_encode(["status"=>"success"]));
							}else{
							     echo(json_encode(["status"=>"fail"]));
							}
					}
				    
				break;
				
				case "getlist":
				    if(!empty($_POST["classid"])){
						$students = $db->getStudent($_POST["classid"]);
						echo(json_encode(["status"=>"success", "data"=>$students]));
					}
				break;
				
			}
			
		}else{
			include("views/student.html");
		}
	}
	
	public function course(){
		
		$db = $this->db;
		
		if(!empty($_POST["action"])){
			
			$classes = $db->getclass();
			 
			switch($_POST["action"]){
				
				case "edit":
				break;
				
				case "delete":
				break;
				
				case "getlist":
				break;
				
				case "update":
				break;
				
			}
		}else{
			include("views/course.html");
		}
		
	}
	
	public function professor(){
		$db = $this->db;
		
		if(!empty($_POST["action"])){
			
			$classes = $db->getclass();
			
			switch($_POST["action"]){
				
				case "edit":
				     if(!empty($_POST["id"]) && $_POST["classid"]){
				        $profs = $db->getProf($_POST["classid"]);
						foreach($profs as $item){
							if($_POST["id"]==$item["id"]){
							   echo(json_encode(["status"=>"success", "data"=>$item]));
							   break;
							}
					    }
					 }
				break;
				
				
				case "delete":
				     
				     if($_POST["id"]){
						 
						 if($db->deleteProf($_POST["id"])){
							 echo(json_encode(["status"=>"success"]));
						 }else{
							 echo(json_encode(["status"=>"fail"]));
						 }
					 }
				     
				break;
				
				case "update":
				    
				    if(!empty($_POST["nom"]) && !empty($_POST["date"]) && !empty($_POST["lieu"]) && !empty($_POST["addr"]) && !empty($_POST["classe"])){
						$id = "";
						$matiere = "";
						if(!empty($_POST["id"])){
							$id = $_POST["id"];
						}
						if(!empty($_POST["matiere"])){
							$matiere = $_POST["matiere"];
						}
						
						if($db->newprof($_POST["nom"], $_POST["date"]."#".$_POST["lieu"], $matiere, $_POST["addr"], $_POST["classe"], $id)){
						    echo(json_encode(["status"=>"success"]));
						}else{
						     echo(json_encode(["status"=>"fail"]));
						}
						
					}
				    
				break;
				
				case "getlist":
				    if(!empty($_POST["classid"])){
						$profs = $db->getProf($_POST["classid"]);
						echo(json_encode(["status"=>"success", "data"=>$profs]));
					}
				break;
			}
		}else{
			include("views/prof.html");
		}
	}
	
	
	public function index(){
		include("views/index.html");
	}
}
    
    
?>
