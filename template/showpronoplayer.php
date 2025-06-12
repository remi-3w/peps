<?php
include('header.php');
include_once(dirname(__FILE__) . '/functions/DateToFrench.php');

$target_user = null;
$user_predictions = [];
$all_matches = [];
$error_message = '';

function getPredictionResult(int $real_s1, int $real_s2, int $user_s1, int $user_s2): array {
    if ($user_s1 === $real_s1 && $user_s2 === $real_s2) {
        return ['icon' => '✅', 'points' => 50];
    }
    if (($real_s1 === $real_s2 && $user_s1 === $user_s2) ||
        (($real_s1 - $real_s2) * ($user_s1 - $user_s2) > 0)) {
        return ['icon' => '⭐', 'points' => 30];
    }
    return ['icon' => '🟥', 'points' => 0];
}

if (!isset($_GET['ID']) || !filter_var($_GET['ID'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
    $error_message = "ID utilisateur invalide ou manquant.";
} else {
    $target_user_id = (int)$_GET['ID'];

    if (!isset($db) || !$db instanceof PDO) {
        error_log("DB object check failed.");
        die("CRITICAL ERROR: Connexion à la base de données invalide.");
    }

    $user_stmt = $db->prepare("SELECT id, username, score FROM users WHERE id = :id");
    $user_stmt->bindParam(':id', $target_user_id, PDO::PARAM_INT);
    $user_stmt->execute();
    $target_user = $user_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$target_user) {
        $error_message = "Utilisateur non trouvé.";
    } else {
        $matches_stmt = $db->query(
            "SELECT m.id AS match_id, m.date AS match_date, m.real_score_team1, m.real_score_team2,
                    t1.name AS team1_name, t1.code AS team1_code,
                    t2.name AS team2_name, t2.code AS team2_code
             FROM matchs m
             JOIN teams t1 ON m.team1_id = t1.id
             JOIN teams t2 ON m.team2_id = t2.id
             ORDER BY m.date ASC"
        );
        $all_matches = $matches_stmt->fetchAll(PDO::FETCH_ASSOC);

        $predictions_stmt = $db->prepare(
            "SELECT match_id, score_team1, score_team2
             FROM matchs_users
             WHERE user_id = :user_id"
        );
        $predictions_stmt->bindParam(':user_id', $target_user_id, PDO::PARAM_INT);
        $predictions_stmt->execute();
        $preds = $predictions_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($preds as $pred) {
            $user_predictions[$pred['match_id']] = $pred;
        }
    }
}
?>

<div class="page-wrapper container-fluid px-0">
    <div class="row flex-nowrap gx-0">
        <?php if (isset($_SESSION['user'])) {
            include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
        } ?>
        <main class="col pt-2 main-content-area <?php echo isset($_SESSION['user']) ? 'main-content-area-with-sidebar ps-md-2' : ''; ?>">
            <div class="container-md p-3 showpronoplayer-inner-content">
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                <?php elseif ($target_user): ?>
                    <h1 class="mb-3 text-white">Pronostics de <?php echo htmlspecialchars($target_user['username']); ?></h1>
                    <h4 class="mb-4 text-white">Score Total : <?php echo htmlspecialchars($target_user['score']); ?></h4>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-white fontsaira">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Équipe 1</th>
                                    <th scope="col">Équipe 2</th>
                                    <th scope="col">Pronostic</th>
                                    <th scope="col">Score Réel</th>
                                    <th scope="col">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($all_matches)): ?>
                                    <tr><td colspan="6" class="text-center">Aucun match trouvé.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($all_matches as $match): ?>
                                        <?php
                                            $prediction_display = '-';
                                            $real_score_display = '-';
                                            $points_display = '-';

                                            if (isset($user_predictions[$match['match_id']])) {
                                                $pred = $user_predictions[$match['match_id']];
                                                $prediction_display = htmlspecialchars($pred['score_team1']) . ' - ' . htmlspecialchars($pred['score_team2']);
                                            }

                                            if (isset($match['real_score_team1'], $match['real_score_team2'])) {
                                                $real_score_display = htmlspecialchars($match['real_score_team1']) . ' - ' . htmlspecialchars($match['real_score_team2']);
                                            }

                                            $formatted_date = function_exists('dateToFrench') ? dateToFrench($match['match_date'], 'l j F Y') : htmlspecialchars($match['match_date']);

                                            if (isset($match['real_score_team1'], $match['real_score_team2'], $user_predictions[$match['match_id']])) {
                                                $result = getPredictionResult(
                                                    (int)$match['real_score_team1'],
                                                    (int)$match['real_score_team2'],
                                                    (int)$user_predictions[$match['match_id']]['score_team1'],
                                                    (int)$user_predictions[$match['match_id']]['score_team2']
                                                );
                                                $points_display = $result['icon'] . ' ' . $result['points'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $formatted_date; ?></td>
                                            <td><?php echo htmlspecialchars($match['team1_name']); ?> (<?php echo htmlspecialchars($match['team1_code']); ?>)</td>
                                            <td><?php echo htmlspecialchars($match['team2_name']); ?> (<?php echo htmlspecialchars($match['team2_code']); ?>)</td>
                                            <td>
    <?php
    $match_date = strtotime($match['match_date']);
    //$match_date = $now;
        $now = time() ;
       

        $can_edit = false;
        $has_prediction = isset($user_predictions[$match['match_id']]);

        if ($has_prediction) {
            $score1 = htmlspecialchars($user_predictions[$match['match_id']]['score_team1']);
            $score2 = htmlspecialchars($user_predictions[$match['match_id']]['score_team2']);
            echo "<span class='position-relative score-display'>$score1 - $score2";

            if ($match_date < $now) {
                $can_edit = true;
                echo " <a href='edit_prediction.php?match_id={$match['match_id']}&user_id={$target_user_id}' class='edit-icon text-decoration-none ms-2' title='Modifier'><span class='text-warning'>✏️</span></a>";
            }

            echo "</span>";
        } else {
            if ($match_date < $now) {
                echo "<a href='edit_prediction.php?match_id={$match['match_id']}&user_id={$target_user_id}' class='btn btn-sm btn-success'>Jouer</a>";
            } else {
                echo "-";
            }
        }
    ?>
</td>
                                            <td><?php echo $real_score_display; ?></td>
                                            <td><?php echo $points_display; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>
