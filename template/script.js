     // Sélectionnez tous les éléments avec la classe "myInput"
var inputs = document.getElementsByClassName("myInput");

// Boucle à travers les éléments sélectionnés
for (var i = 0; i < inputs.length; i++) {
    // Ajoutez un écouteur d'événement "change" à chaque élément
    inputs[i].addEventListener("change", function(e) {
        e.preventDefault();

        // Créez un objet FormData à partir du formulaire (utilisez l'ID "form")
        var form = document.getElementById("form");
        var data = new FormData(form);
        console.log("les valeurs envoyées : ", data);
        var xhr = new XMLHttpRequest();
        var res;
    

        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.response !== undefined) {
                        console.log("état de la requete:" + xhr.readyState)
                        console.log("status de la requete:" + xhr.status)
                        console.log("réponse du serveur : " + xhr.response);
                        }                   
                        if (!res) {
                            console.log("Score enregistré avec succès !");
                        } else {
                            alert(res.msg);
                        }
                            } else {
                                alert("Erreur lors de la requête : " + xhr.status);
                            }
            }
        };

        xhr.open("POST", "functions/registerScore.php", true); // Assurez-vous du bon chemin
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);

        return false;
    });
}

