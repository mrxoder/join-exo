function data_form(name) {


    this.name_form = name.trim();

    // verifier si tous les champs sont bien rempli

    this.verify = function() {
            var etat = true;
            $("#" + this.name_form + " .obligatoire").each(function() {
                var ceci = $(this);
                // console.log(ceci) ;
                if (ceci.val() == "") {
                    etat = false;
                    // CSS afaka ovaina
                    ceci.css("border","#ee5c23 1px solid") ;
                } else {
                    ceci.css("border", "");
                }

            });
            // console.log(etat) ;
            return etat;
        }
        // envoye des données
    this.sendInfo = function(uri, callback1,callback2=null) {

        // console.log(this.getDataSend());
        $.ajax({
            url: uri,
            type: 'post',
            data: this.getDataSend(),
            success: function(data) {

                callback1(data);
            },
            error: function(donnee) {
                if(callback2!=null) {
                    callback2(donnee) ;
                }
                
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'ERREUR',
                    text: 'Erreur de connexion au serveur !',
                    showConfirmButton: false

                }) ;
            }


        });


    }
    this.getDataSend = function() {
        // données à envoyer à PhP
        var dataSend = "";
        var cpt = 0;
        // parcours de tous les inputs et les selects dans la form
        $("#" + this.name_form + " input, #" + this.name_form + " select, #" + this.name_form + " textarea").each(function() {
            var ceci = $(this);
            if (cpt == 0) {
                dataSend += ceci.attr("id") + "=" + ceci.val();
            } else {
                dataSend += "&" + ceci.attr("id") + "=" + ceci.val();
            }
            cpt++;


        });
        return dataSend;
    }

}

function forDelete(valeur) {

    this.sendInfo = function(uri, callback) {

        // console.log(this.getDataSend());
        $.ajax({
            url: uri,
            type: 'post',
            data: "id=" + valeur,
            success: function(data) {

                callback(data);
            },
            error: function() {

                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'ERREUR',
                    text: 'Erreur de connexion au serveur !',
                    showConfirmButton: false

                })
            }


        });


    }
}
//affiche
function forSearch(valeur) {

    this.sendInfo = function(uri, callback) {


        $.ajax({
            url: uri,
            type: 'post',
            data: "value=" + valeur,
            dataType: "json",
            success: function(data) {
                console.log(data) ;
                callback(data);
            },
            error: function() {

                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'ERREUR',
                    text: 'Erreur de connexion au serveur !',
                    showConfirmButton: false

                })
            }


        });


    }
}

function forSearchParam(valeur) {

    this.sendInfo = function(uri, callback) {


        $.ajax({
            url: uri,
            type: 'post',
            data: valeur,
            dataType: "json",
            success: function(data) {

                callback(data);
            },
            error: function() {

                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'ERREUR',
                    text: 'Erreur de connexion au serveur !',
                    showConfirmButton: false

                })
            }


        });


    }
}

function forSearchAjax(valeur) {

    this.sendInfo = function(uri, callback) {


        $.ajax({
            url: uri,
            type: 'post',
            data: valeur,
            success: function(data) {

                callback(data);
            },
            error: function() {}


        });


    }
}