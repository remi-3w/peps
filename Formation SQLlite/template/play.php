<?php

use JetBrains\PhpStorm\ExpectedValues;

include('header.php');
include('../template/functions/DateToFrench.php');

                //Ouvrir ou crÃ©er la base de donnÃ©es member
                $db = new PDO('sqlite:db.SQLite');
                //Activer les exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT * FROM matchs LEFT JOIN teams on matchs.team1_id = teams.id ';
                $stmt = $db->prepare($sql);
                $stmt->execute();
                //extaire les donnÃ©es
                $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
                //Parcourir la liste des membres
               
                

// $file = "http://peps/template/data.json";
// // mettre le contenu du fichier dans une variable
// $data = file_get_contents($file);
// // décoder le flux JSON
// $obj = json_decode($data, true);
// // accéder à l'élément approprié
// // $equipe1 = $obj["rounds"][0]["matches"][0]["team1"]["code"];
// // $equipe2 = $obj["rounds"][0]["matches"][0]["team2"]["code"];
// // $nextmatch = "$equipe1 - $equipe2";
// ?>

<div class="hero-ranking border-peps fontsaira mt-5 p-5  ">
    <div class="col-12">
        <table class="table table-borderless col-12   ">
            <tbody >
                <?php             

    // var_dump($matchs);
                //Boucler dans la BDD et écrire les données dans la table html 
                foreach ($matchs as $i => $match) {                                         
                        // $nummatch = $match["num"];
                                                                 
                        $equipe1 = $match["name"];
                        $matchid = $match["id"];

                        $equipe2 = $match["name"];
                        $rencontre = "$equipe1 - $equipe2";
                        $date = $match["date"];
                        echo "<tr>";
                        echo "<td>";
                        echo dateToFrench("$date", 'l j F Y');
                        echo "</td>";
                        //"<td> $date </td>";
                        echo "<td> $rencontre</td>";
                        echo "<td>" . $match["score_team1"] . " - " . $match["score_team2"] . "</td>";
                  
                    echo "<td><form id='Form' action='/template/functions/enregistrerScore.php' method='POST'></td>";
                    echo "<input type='hidden' name='nummatch' value='$matchid'   id='nummatch'>"; // input caché pour envoyer le num du match dans la requete du formulaire
                    echo "<td><input type='number' placeholder=' ?' name='score1' id='score1' max='30' min='0' step='1' > </n>";
                    echo "<input type='number' placeholder = ' ? ' name='score2' id='score1' max='20' min='0' step='1'></td>";
                    echo "<td><button id='btnSubmit' type='submit' class='btn btn-play'> Valider <img src='/assets/dice.png'> </button> </td>";
                    echo "</form>";
                    echo "</tr>";
                 }
                ?>


            </tbody>
        </table>
    </div>

 
    </div>