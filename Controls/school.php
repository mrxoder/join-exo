<?php


class school{
	
	public function index(){
		InitializerControls::loadViews("school");
	}
	
	public function getlist(){
		$db = new sql();
		$classes = $db->getclass();
		
	    $total_st = 0;
	    $total_prf = 0;
	    $sts = [];
	    $profs = [];
	    
        foreach($classes as $class){
		   $students = $db->getstudents($class->id);
		   
		   $total_st += count($students);
		   $tmp = 0;
		   $profs = $db->getProf($class->id);
		   
		   $total_prf += count($profs);
		   array_push($sts, [ "name"=>$class->libelle, "capacite"=>$class->capacite, "students"=>count($students), "profs"=>count($profs) ]);
		}
	    echo(json_encode([ "status"=>"success", "data"=>$sts, "totalst"=>$total_st, "totalprf"=>$total_prf ]));
	    
	}
	
}

?>
