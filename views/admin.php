<?php

namespace views;

class admin{
	
	function __construct($var=[]){
		$this->var = $var;
	}
	
	public function accessdenied(){
		include("access.html");
	}
	
	public function header(){
		include("adminheader.html");
	}
	
	public function content(){
           $db = $this->var["db"];
           $user = $this->var["user"];
?>
		   <div class="content">
<?php
				
				if(!empty($_POST["name"]) && !empty($_POST["currentpwd"]) && !empty($_POST["npwd"]) && !empty($_POST["retype"]) ){
				    if($_POST["retype"]!=$_POST["npwd"]){
						echo("<center><span class='text-danger notif'>Password confirmation doesn't match.</span></center>");
						return false;
					}
					
					if($db->login($_SESSION["username"], $_POST["currentpwd"])){
					   if($db->newuser($_SESSION["username"], $_POST["npwd"], $_POST["name"], $user["id"])){
						    header("location: admin.php?message=The account is up to date.");
					   }else{ echo("<center><span class='text-danger notif'>Failed to update the account.</span></center>");}
					}else{ echo("<center><span class='text-danger notif'>Incorrect current password.</span></center>");}
			    }
			   
			    if(!empty($_GET["message"])){
					$m = htmlentities($_GET["message"]);
					echo("<center><span class='text-primary notif'>$m</span></center>");
				}
				
				?>
				<div class="input">
				<form action="index.php?page=admin" class="form-horizontal" method="post">
					
					<div class="form-group">
						 <ul class="list-group" style="width:40%;">
						   <li class="list-group-item control-label " for="name">Username:  <?php echo(htmlentities($user["username"])); ?></li>
						 </ul>
				    </div>
				    
					<div class="form-group">
						 <label class="control-label " for="name">Name: </label>
						 <div col="col-sm-10">
						   <input type="text" placeholder="name" class="form-control" id="name" name="name" value="<?php echo(htmlentities($user["name"])); ?>" required />
						 </div>
				    </div>
					<div class="form-group">
						 <label class="control-label " for="pwd">Current Password: </label>
						 <div col="col-sm-10">
						   <input type="password" placeholder="Current Password" class="form-control" id="pwd" name="currentpwd" required />
						 </div>
				    </div>
					<div class="form-group">
						 <label class="control-label " for="npwd">New password: </label>
						 <div col="col-sm-10">
						   <input type="password" placeholder="New Password" class="form-control" id="npwd" name="npwd" required />
						 </div>
				    </div>
				    
					<div class="form-group">
						 <label class="control-label " for="confirm">Retype, new password: </label>
						 <div col="col-sm-10">
						   <input type="password" placeholder="Retype, new password" class="form-control" id="confirm" name="retype" required />
						 </div>
				    </div>
					<div class="form-group">
						 <div col="col-sm-5">
						   <input type="submit" class="btn btn-primary" value="Save" style="width: 30%;"/>
						 </div>
				    </div>
				    
				</form>
				</div>
			</div>
<?php
	}
	
	
	public function script(){
		
?>
       <script src="public/js/jquery.js"></script>
	   <script src="public/js/notif.js"></script>
<?php		
	}
	
	public function footer(){
?>
        </body></html>
<?php
	}
}

?>
