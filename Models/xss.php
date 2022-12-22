<?php

class xss{
	
	public function sanitize($arr){
		foreach($arr as $key => $value){
			if(is_string($value)){
			  $array[$key] = htmlentities($value);
		    }
		}
		return $arr;
	}
} 

?>
