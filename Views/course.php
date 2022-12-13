<div class="input">
 <form id="form" class="form-horizontal" method="post">
	 <input id="id" name="id" type="hidden" value=""/>
	 <div class="form-group">
		 <label class="control-label " for="nom">Matière: </label>
		 <div col="col-sm-10">
		   <input type="text" style="width:40%;" placeholder="Matière" class="form-control" id="nom" name="name" value=""/>
		 </div>
    </div>
	 <div class="form-group">
		 <label class="control-label " for="coef">Coefficient: </label>
		 <div col="col-sm-10">
		   <input type="text" style="width:40%;" placeholder="Coefficient" class="form-control" id="coef" name="coef" value=""/>
		 </div>
    </div>
    
	
	
	<div class="form-group">
		 <label class="control-label " for="description">Description: </label>
		 <div col="col-sm-10">
		   <textarea type="text" style="width:40%;"  class="form-control" id="description" name="descr"></textarea>
		 </div>
    </div>
	
	
	
	
    <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-5">
	        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
	    </div>
	 </div>
   </form>
</div>

<table class="table list" id="list">
	 <th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>
	 
</table>
