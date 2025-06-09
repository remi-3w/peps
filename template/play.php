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
<div class="container-md p-1 play-page-container">
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
echo htmlspecialchars($winteam) ?></h1>
        <div class="table-responsive">
            <table class="mx-auto table table-borderless">
                <tbody>
                    <?php
                    $sql = 'SELECT m.date, m.id, m.team1_id, m.team2_id, t1.code AS equipe1_code, t1.name AS equipe1_name, t2.code AS equipe2_code, t2.name AS equipe2_name FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id =  t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id ORDER BY m.date ASC;';
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // $timestampnow should be defined, assuming it's set in header or earlier in script
                    // For safety, let's ensure $timestampnow is available here or use time()
                    $current_time_for_check = isset($timestampnow) ? $timestampnow : time();

                    foreach ($matchs as $match) {
                        $date = $match["date"];
                        $timestampmatchday = strtotime($date);
                        $equipe1_name = $match['equipe1_name']; // Use full name for display
                        $equipe2_name = $match['equipe2_name']; // Use full name for display
                        $equipe1_code = $match['equipe1_code']; // For potential use like flags
                        $equipe2_code = $match['equipe2_code']; // For potential use like flags
                        $matchid = $match['id'];

                        $sql_score = 'SELECT mu.score_team1, mu.score_team2, mu.score_update FROM matchs_users AS mu WHERE mu.match_id = :matchid AND mu.user_id = :user_id';
                        $stmt_score = $db->prepare($sql_score);
                        $stmt_score->bindValue(':matchid', $matchid, PDO::PARAM_INT);
                        $stmt_score->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
                        $stmt_score->execute();
                        $matchScore = $stmt_score->fetch();
                        $stmt_score->closeCursor();

                        $score1 = $matchScore ? $matchScore['score_team1'] : 0;
                        $score2 = $matchScore ? $matchScore['score_team2'] : 0;
                        $score_update = $matchScore ? $matchScore['score_update'] : null;
                    ?>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal-<?php echo $matchid; ?>" tabindex="-1" aria-labelledby="myModalLabel-<?php echo $matchid; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="functions/registerScore.php">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel-<?php echo $matchid; ?>"><?php echo htmlspecialchars($equipe1_name)." VS ".htmlspecialchars($equipe2_name); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="nummatch" value="<?php echo $matchid; ?>">
                                            <div class="row align-items-center text-center g-2">
                                                <div class="col-sm-5 team-name-modal"><?php echo htmlspecialchars($equipe1_name); ?></div>
                                                <div class="col-6 col-sm-3">
                                                    <input class="form-control myInput score-input-modal" type="number" placeholder="?" name="score1" id="score1-<?php echo $matchid; ?>" max="20" min="0" step="1">
                                                </div>
                                                <div class="col-6 col-sm-3">
                                                    <input class="form-control myInput score-input-modal" type="number" placeholder="?" name="score2" id="score2-<?php echo $matchid; ?>" max="20" min="0" step="1">
                                                </div>
                                                <div class="col-sm-5 team-name-modal order-sm-last"><?php echo htmlspecialchars($equipe2_name); ?></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <tr class='match-row align-items-center'>
                            <td class='mdate'><?php echo dateToFrench($date, 'l j F');?></td>
                            <td class='score'><?php echo htmlspecialchars($equipe1_name) . " - " . htmlspecialchars($equipe2_name); ?></td>
                            <td class='score'><?php echo htmlspecialchars($score1) . " - " . htmlspecialchars($score2) ; ?></td>
                            <?php
                            if ($timestampmatchday < $current_time_for_check) { // Use defined current time
                            ?>
                                <td><p class="close-game">Il n'est plus possible de pronostiquer</p></td>
                            <?php } else { ?>
                                <td>
                                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal-<?php echo $matchid; ?>">Jouer</button>
                                </td>
                            <?php } ?>
                            <td><?php if ($score_update !== null){
                                   echo htmlspecialchars($score_update);
                                 }else{
                                   echo "Pas de prono";
                                 }; ?></td>
                            <td>
                                 <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast-<?php echo $matchid; ?>">
                                     <div class="toast-header">
                                         <strong class="me-auto">Notification</strong>
                                         <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                     </div>
                                     <div class="toast-body">
                                         ✅ Score enregistré.
                                     </div>
                                 </div>
                            </td>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


