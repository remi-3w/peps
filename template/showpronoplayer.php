<?php
include('header.php'); // For DB, session, basic HTML head
include_once(dirname(__FILE__) . '/functions/DateToFrench.php'); // Likely needed for dates

if (isset($_SESSION['user'])) { // Check if any user is logged in to show navbar
    include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
}

// Initialize variables to hold fetched data
$target_user = null;
$user_predictions = []; // Will be an array keyed by match_id
$all_matches = [];
$error_message = '';

// Get and validate target user ID
if (!isset($_GET['ID']) || !filter_var($_GET['ID'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
    $error_message = "ID utilisateur invalide ou manquant.";
} else {
    $target_user_id = (int)$_GET['ID'];

    if (!isset($db) || !$db instanceof PDO) {
        error_log("DB object check failed in showpronoplayer.php. \$db is not a valid PDO object."); // Log to Docker/PHP error log
        die("CRITICAL ERROR: Database connection object (\$db) is not available or not a valid PDO object in showpronoplayer.php. Please check header.php and functions/connexion.php. Also check PHP/Docker logs for more details.");
    }

    // Fetch target user's details
    $user_stmt = $db->prepare("SELECT id, username, score FROM users WHERE id = :id");
    $user_stmt->bindParam(':id', $target_user_id, PDO::PARAM_INT);
    $user_stmt->execute();
    $target_user = $user_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$target_user) {
        $error_message = "Utilisateur non trouvé.";
    } else {
        // Fetch all matches with team names, ordered by date
        // Ensure team codes are fetched for potential future use (e.g. flags)
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

        // Fetch all predictions for the target user
        $predictions_stmt = $db->prepare(
            "SELECT match_id, score_team1, score_team2
             FROM matchs_users
             WHERE user_id = :user_id"
        );
        $predictions_stmt->bindParam(':user_id', $target_user_id, PDO::PARAM_INT);
        $predictions_stmt->execute();
        $preds = $predictions_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organize predictions by match_id for easier lookup
        foreach ($preds as $pred) {
            $user_predictions[$pred['match_id']] = $pred;
        }
    }
}
?>

<div class="container-md p-3 showpronoplayer-page-container">
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php elseif ($target_user): ?>
        <h1 class="mb-3 text-white">Pronostics de <?php echo htmlspecialchars($target_user['username']); ?></h1>
        <h4 class="mb-4 text-white">Score Total: <?php echo htmlspecialchars($target_user['score']); ?></h4>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered text-white fontsaira">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Équipe 1</th>
                        <th scope="col">Équipe 2</th>
                        <th scope="col">Son Pronostic</th>
                        <th scope="col">Score Réel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_matches)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun match trouvé.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($all_matches as $match): ?>
                            <?php
                                $prediction_display = "-";
                                if (isset($user_predictions[$match['match_id']])) {
                                    $pred = $user_predictions[$match['match_id']];
                                    $prediction_display = htmlspecialchars($pred['score_team1']) . " - " . htmlspecialchars($pred['score_team2']);
                                }

                                $real_score_display = "-";
                                if (isset($match['real_score_team1']) && isset($match['real_score_team2'])) {
                                    $real_score_display = htmlspecialchars($match['real_score_team1']) . " - " . htmlspecialchars($match['real_score_team2']);
                                }

                                $formatted_date = function_exists('dateToFrench') ? dateToFrench($match['match_date'], 'l j F Y') : htmlspecialchars($match['match_date']);

                                $row_class = '';
                                if (isset($match['real_score_team1']) && isset($match['real_score_team2']) && isset($user_predictions[$match['match_id']])) {
                                    $user_pred = $user_predictions[$match['match_id']];
                                    $user_s1 = (int)$user_pred['score_team1'];
                                    $user_s2 = (int)$user_pred['score_team2'];
                                    $real_s1 = (int)$match['real_score_team1'];
                                    $real_s2 = (int)$match['real_score_team2'];

                                    if ($user_s1 === $real_s1 && $user_s2 === $real_s2) {
                                        $row_class = 'table-success'; // Perfect score
                                    } elseif (($real_s1 === $real_s2 && $user_s1 === $user_s2) || (($real_s1 - $real_s2) * ($user_s1 - $user_s2) > 0)) {
                                        $row_class = 'table-info'; // Correct outcome
                                    }
                                }
                            ?>
                            <tr class="<?php echo $row_class; ?>">
                                <td><?php echo $formatted_date; ?></td>
                                <td><?php echo htmlspecialchars($match['team1_name']); ?> (<?php echo htmlspecialchars($match['team1_code']); ?>)</td>
                                <td><?php echo htmlspecialchars($match['team2_name']); ?> (<?php echo htmlspecialchars($match['team2_code']); ?>)</td>
                                <td><?php echo $prediction_display; ?></td>
                                <td><?php echo $real_score_display; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
             </div>
                  </div>     </div>
    <?php else: ?>
        <?php // This case should ideally be caught by $error_message, but as a fallback: ?>
        <div class="alert alert-info" role="alert">
            Chargement des informations du joueur...
        </div>
    <?php endif; ?>



