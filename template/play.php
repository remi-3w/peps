<?php

include('header.php');
include('../template/functions/DateToFrench.php');
if (!$_SESSION) {
    header('Location: ' . '/template/home.php');
} else {
    include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
}
?>
<script type="text/javascript">window.setTimeout("document.getElementById('alert').style.display='none';", 2000);

function showtoast(){
   var toast = document.getElementById("toat");
toast.classList.add("show");
}





</script>
<div class="container mx-auto p-1 col-10 col-xl-9">
    <div class="hero-ranking fontsaira col-12">
        <?php
        if (isset($_SESSION["flash"])) {
            foreach ($_SESSION['flash'] as $type => $message) : ?>              
                <div id="alert" class="fade-out alert alert-<?= $type; ?> infoMessage">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= $message; ?>
                </div>
        <?php
            endforeach;
            unset($_SESSION['flash']);
        }
?>  </div>
    <div>
        <h1 class ="text-white info-bonus">Points bonus ⭐<?php  $winteam = "Mexique";
echo $winteam ?></h1>
        <table class="mx-auto table table-borderless ">
            <tbody>
                <?php
        $sql = 'SELECT m.date, m.id, m.team1_id, m.team2_id, t1.code AS equipe1, t2.code AS equipe2 FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id =  t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id ORDER BY m.date ASC;';
$stmt = $db->prepare($sql);
$stmt->execute();
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
$timestampnow; // date du jour en timestamps
foreach ($matchs as $match) {
    $date = $match["date"];
    $timestampmatchday = strtotime($date); // date du match en time stamp
    $equipe1 = $match['equipe1'];
    $equipe2 = $match['equipe2'];
    $matchid = $match['id'];
    $sql = 'SELECT  mu.score_team1, mu.score_team2, mu.score_update FROM matchs_users AS mu WHERE mu.match_id = :matchid AND mu.user_id = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':matchid', $matchid, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $stmt->execute();
    $matchScore = $stmt->fetch();
    $stmt->closeCursor();
    if ($matchScore) {
        $score1 = $matchScore['score_team1'];
        $score2 = $matchScore['score_team2'];
        $score_update = $matchScore['score_update'];
    } else {
        $score1 = 0;
        $score2 = 0;
    }
    ?>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal-<?php echo $matchid; ?>" tabindex="-1" aria-labelledby="myModal-<?php echo $matchid; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModal-<?php echo $matchid; ?>"><?php echo "$equipe1"." VS ". "$equipe2"; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                        <form class="form-inline" id="form" method="POST" action ="functions/registerScore.php">
                               <p class=" col-3"><?php echo "$equipe1"; ?></p>
                            <input type="hidden" name="nummatch" id="nummatch" value=<?php echo $matchid; ?> >
                            <input class="myInput col-3" type="number" placeholder="?" name="score1" id="score1" max="20" min="0" step="1">
                            <input class="myInput col-3" type="number" placeholder="?" name="score2" id="score2" max="20" min="0" step="1">
                            <p class="col-3"><?php echo "$equipe2"; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary" id="submit">Valider</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
                    <tr class='col-12 d-flex align-items-center'><td class='col-4 col-xl-4 ml-3 mdate'>
                    <?php echo dateToFrench("$date", 'l j F');?>
                    </td>            
                    <td class='score col-3 col-xl-2' ><?php echo "$equipe1 - $equipe2"; ?></td>
                    <td class ='score col-1 col-xl-1'><?php echo "$score1 - $score2" ; ?></td>
                   <?php
                        $timestampmatchday = strtotime($date); // date du match en time stamp
                        $timestampnow; // date du jour en timestamps
                        if ($timestampmatchday > $timestampnow) {?>
                        <td class ="col-5 col-xl-6"><p class="close-game"> il n'est plus possible de pronostiquer</p></td>
                        <?php } else { ?>
                               <td class="col-2"> <input type="hidden" id="nummatch" name="nummatch" value="<?php echo $matchid ?>">
                               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal-<?php echo $matchid; ?>">jouer</button>
                               
                             </td>
                            
                             <td class ='col-3 col-xl-3'><?php if ($score_update !== null){
                                echo $score_update ; 
                             }else{
                                echo " il n'y a pas eu de prono " ;
                             }; ?></td>
                             <td class="col-3">
                             <div class="toast " role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="..." class="rounded me-2" alt="...">
                                    <strong class="me-auto">Bootstrap</strong>
                                    <small>11 mins ago</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    ✅ Score enregisté.
                                </div>
                            </div>
                                </td>                  
                    <?php }; ?>
                   </tr>
                   <?php }; ?>
            </tbody>
        </table>
    </div>
</div>


