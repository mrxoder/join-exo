<?php

    InitializerControls::loadTemplate("header") ;
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 mt-5 shadow p-3">
                <form id="myFormConnect" class="form-group ">
                    <input name="username" placeholder="Pseudo" type="text" class="form-control mb-2">
                    <input name="pwd" placeholder="Mot de passe" type="password" class="form-control mb-2">
                    <input type="submit" class="btn btn-primary btn-block" value="Se connecter">
                    <p class="mt-3 float-right">
                        Besoin d'un compte ? <a href="#" data-toggle="modal" data-target="#myModal">S'inscrire</a></p>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>






<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Inscription</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form id="myFormRegister" class="form-group">
                
                <input type="text" name="name" class="form-control mb-2" placeholder="Name"> 
                <input type="text" name="username" class="form-control mb-2" placeholder="Username"> 
                <input type="password" class="form-control mb-2" placeholder="Mot de passe" name="pwd">
                
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <input type="submit" value="S'inscrire" class="btn btn-info btn-block">
            </form>
        </div>

        </div>
    </div>
</div>



<?php

    InitializerControls::loadTemplate("footer") ;

?>
