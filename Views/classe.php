

<div class="input">
 
 <form class="form-horizontal" id="form" method="post">
	 <input id="id" name="id" type="hidden" value=""/>
	 <div class="form-group">
		 <label class="control-label " for="libelle">Libelle: </label>
		 <div col="col-sm-10">
		   <input type="text" placeholder="Libelle" class="form-control" id="libelle" name="libelle" value="" required />
		 </div>
    </div>
	<div class="form-group capacity">
		 <label class="control-label" for="capacity">Capacité: </label>
		 <div col="col-sm-10">
		   <input type="text" placeholder="Capacité" class="form-control" id="capacity" name="capacity" value="" required />
		 </div>
	</div>
	 <div class="form- group">
	    <div class="col-sm-offset-2 col-sm-5">
	        <input type="submit" value="Add" class="btn btn-primary" style="width: 50%;float: right;"/>
	    </div>
	 </div>
</form>
</div>

<table class="table list" id="list">
	 <th>ID</th><th>Libelle</th><th>Capacité</th> <th>Action</th>
</table>

<script src="public/js/classe.js"></script>

