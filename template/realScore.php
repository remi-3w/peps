<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');


?>
<div class="col col-xl-9 container hero-ranking border-peps fontsaira mt-5 p-2">
    <div class=" col-12 col-xl-12">
        <table class="table table-borderless col-12 col-xl-12">
            <tbody >
            <?php
                $sql = 'SELECT m.date, m.id, m.team1_id, m.team2_id, m.real_score_team1, m.real_score_team2,t1.code AS equipe1, t2.code AS equipe2 FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id =  t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id ORDER BY m.date ASC;';
               // $sql = 'SELECT * FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id =  t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id ORDER BY m.date ASC;';
                $stmt = $db->prepare($sql);
                $stmt->execute();                
                $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($matchs as $i => $match){
                      //var_dump($match); 
                                       
                    $date = $match['date'];
		            $timestampmatchday = strtotime($date); // date du match en time stamp                    
                    $equipe1 = $match['equipe1'];
                    $equipe2 = $match['equipe2'];                 
                    $matchid = $match['id'];                                       
                    $score1 = $match['real_score_team1'];
                    $score2 = $match['real_score_team2'];
                    
                    if ($match){
                        $score1 = $match['real_score_team1'];
                        $score2 = $match['real_score_team2'];
                    }else{
                        $score1 = 0;
                        $score2 = 0;
                    }
                    echo "<tr><td class='col-4 ml-3'>"; 
                    echo dateToFrench("$date", 'l j F');
                    echo "</td>";
                    echo "<td class=' col-2' > $equipe1 - $equipe2 </td>";
                    echo "<td class =' col-2'> $score1 - $score2 </td>";
                    echo "<form id='Form' action='../template/functions/registerRealScore.php' method='POST'>";
                    echo "<td class ='col-2'><input type='hidden' name='nummatch' value= $matchid  id='nummatch'>"; // input caché pour envoyer le num du match dans la requete du formulaire
                    echo "<input type='number' placeholder =' ? ' name='score1' id='score1' max='20' min='0' step='1' >";
                    echo "<input type='number' placeholder = ' ? ' name='score2' id='score1' max='20' min='0' step='1'></td>";
                    echo "<td><button id='btnSubmit' type='submit' class='btn btn-play btnrealscore'> Valider <img class='dice' src='/peps/assets/img/dice.png'> </button> </td>";
                    echo "</form>";
                    echo "</tr>";
                };
            ?>
            </tbody>
        </table>
    </div>
</div>