<?php
  
  
  if($_SERVER["SERVER_ADDR"] != $_SERVER["REMOTE_ADDR"]){   
	  
	  $view = new views\admin();
	  $view->accessdenied();
	  
  }else{
	  
	  
	  $view = new views\admin(["db"=>$db, "user"=>$user]);
	  $view->header();
	  new views\sidebar($routes->value, "admin");
      $view->content();
      $view->script();
      $view->footer();
}
?>

