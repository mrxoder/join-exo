<div class="input">
     <form class="form-horizontal" id="form" method="post">

		 <input id="id" name="id" type="hidden" value=""/>
		 <div class="form-group">
			 <label class="control-label " for="nom">Nom: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" value="" placeholder="Nom et prenom" class="form-control" id="nom" name="nom" required/>
			 </div>
	    </div>
	    
	    <div class="form-group">
			 <label class="control-label " for="sex">Gender: </label>
			 <div col="col-sm-5">
			    <select class="form-control" style="width:40%;" name="gender" id="gender">
					<option value="male">Male</option>
					<option value="female">Female</option>
			    </select>
			 </div>
	    </div>
	    
		<div class="form-group">
			 <label class="control-label" for="date">Date et Lieu de naissance: </label>
			 <div col="col-sm-10">
			    <input type="date" style="width:40%;" class="form-control" id="date" name="date" value="" max="2020-01-01" min="1970-01-01" required/>
			 </div>
			 <div col="col-sm-10">
			    <input type="text" placeholder="lieu" style="width:40%; margin-top:1%;" class="form-control" id="lieu" name="lieu" value="" required/>
			 </div> 
		</div>
		
		<div class="form-group">
			 <label class="control-label " for="matiere">Competence: </label>
			 <div col="col-sm-10">
			   <select style="width:40%;" class="form-control" id="matiere" name="matiere">
				  <option value="">Not defined</option>
			   </select>
			 </div>
	    </div>
		
		
		<div class="form-group">
			 <label class="control-label" for="addr">Addresse: </label>
			 <div col="col-sm-10">
			   <input type="text" style="width:40%;" placeholder="adresse" class="form-control" id="addr" name="addr" value="" required/>
			 </div>
	    </div>
	    
		
		 <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-5">
		        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
		    </div>
		 </div>
	   </form>
	</div>
	
	<div >
			 <label class="control-label " for="classe">Classe: </label>
			 <div col="col-sm-10">
			   <select style="width:40%;" form="form" class="form-control" id="classe" name="classe">
				   
			   </select>
			 </div>
	</div>
		
	
	<table class="table list" id="list">
		 <th>ID</th> <th>Nom</th> <th>Naissance</th> <th>Adresse</th> <th>Competence</th> <th>Classe</th> <th>Action</th>
		 
</table>
   
