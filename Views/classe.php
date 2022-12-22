

 <div class="input"> 
 <form class="form-horizontal" id="form" method="post">
	 
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

<!--ul class="pagination">
	    <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
	    <li class="page-item btn-rounded"><a class="page-link" href="#">1</a></li>
	    <li class="page-item"><a class="page-link" href="#">2</a></li>
	    <li class="page-item"><a class="page-link" href="#">3</a></li>
	    <li class="page-item"><a class="page-link" href="#">></a></li>
</ul-->
    



<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Edit</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form id="edit" class="form-group">
                <input type="hidden" name="id" value="" id="id"/>
                <div class="form-group">
				 <label class="control-label " for="libelle">Libelle: </label>
				 <div col="col-sm-10">
				   <input type="text" placeholder="Libelle" style="width:100%;" class="form-control" id="editlibelle" name="libelle" value="" required />
				 </div>
			</div>
			
			<div class="form-group capacity">
				 <label class="control-label" for="capacity">Capacité: </label>
				 <div col="col-sm-10">
				   <input type="text" placeholder="Capacité" style="width:100%;" class="form-control" id="editcapacity" name="capacity" value="" required />
				 </div>
			</div>
                
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
         <input type="submit" form="edit" value="Save" class="btn btn-primary" />
            </form>
        </div>

        </div>
    </div>
</div>

