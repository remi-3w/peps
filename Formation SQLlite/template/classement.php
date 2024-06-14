<?php
include('header.php');
$file = "http://peps/template/users.json";
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); // string JSON
$obj = json_decode($data, true);

?>


<div class="hero-ranking border-peps fontsaira ">
    <table class="table table-borderless container">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">Nom</th>
                <th scope="col">points</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $pts= array_column($obj, 'pts'); //va chercher la key pts dans l'objet Json           
                $objtrie = array_multisort($pts, SORT_DESC, $obj); // trie l'objet Json par pts ordre croissant
            
            // vérifie si il ya des données.
            if( empty($objtrie)){
             echo "pas de données";
            }
            else{
                  $i=1;
                   foreach ($obj as $key => $value){
                         $position = $i++;
                $username = $value['username'];
                $points = $value['pts'];
                echo "<tr>";
                echo "<td>$position</td>";
                echo "<td>$username</td>";
                echo "<td>$points</td>";
                echo "</tr>";
                   }
                }
            ?>
            
        </tbody>
    </table>


</div>"