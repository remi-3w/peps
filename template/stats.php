<?php
include('header.php');
include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
?>

<div class="col-8 container-fluid p-3 global-stats-page-container">
    <h1 class="text-white text-center my-4">Statistiques Globales du Tournoi</h1>

    <div class="stats-section my-5">
        <h2 class="text-white">Statistiques Générales</h2>
        <div id="overall-stats">
            <?php
            // Ensure $db is available (should be from header.php)
            if (isset($db)) {
                // Total Predictions
                $total_predictions_stmt = $db->query('SELECT COUNT(*) as total_predictions FROM matchs_users;');
                $total_predictions_result = $total_predictions_stmt->fetch(PDO::FETCH_ASSOC);
                $total_predictions = $total_predictions_result ? $total_predictions_result['total_predictions'] : 0;

                // Most Frequent Scoreline
                $most_frequent_score_stmt = $db->query(
                    'SELECT score_team1, score_team2, COUNT(*) as frequency
                     FROM matchs_users
                     GROUP BY score_team1, score_team2
                     ORDER BY frequency DESC
                     LIMIT 1;'
                );
                $most_frequent_score_result = $most_frequent_score_stmt->fetch(PDO::FETCH_ASSOC);

                echo "<p class='text-white'>Nombre total de pronostics enregistrés : <strong>" . htmlspecialchars($total_predictions) . "</strong></p>";

                if ($most_frequent_score_result) {
                    $scoreline = htmlspecialchars($most_frequent_score_result['score_team1']) . " - " . htmlspecialchars($most_frequent_score_result['score_team2']);
                    $frequency = htmlspecialchars($most_frequent_score_result['frequency']);
                    echo "<p class='text-white'>Score le plus fréquemment pronostiqué : <strong>" . $scoreline . "</strong> (vu " . $frequency . " fois)</p>";
                } else {
                    echo "<p class='text-white'>Aucun pronostic n'a encore été fait pour déterminer le score le plus fréquent.</p>";
                }

            } else {
                echo "<p class='text-white'>Erreur de connexion à la base de données.</p>";
            }
            ?>
        </div>
    </div>

    <div class="stats-section my-5">
        <h2 class="text-white">Classement - Parieurs Parfaits</h2>
        <div id="perfect-predictions-leaderboard">
            <?php
            if (isset($db)) {
                $perfect_stmt = $db->query(
                    'SELECT
                        u.username,
                        COUNT(mu.match_id) AS perfect_predictions_count
                    FROM
                        users u
                    JOIN
                        matchs_users mu ON u.id = mu.user_id
                    JOIN
                        matchs m ON mu.match_id = m.id
                    WHERE
                        m.real_score_team1 IS NOT NULL AND m.real_score_team2 IS NOT NULL
                        AND mu.score_team1 = m.real_score_team1
                        AND mu.score_team2 = m.real_score_team2
                    GROUP BY
                        u.id, u.username
                    HAVING
                        COUNT(mu.match_id) > 0
                    ORDER BY
                        perfect_predictions_count DESC
                    LIMIT 10;' // Limiting to top 10, adjust as needed
                );
                $perfect_predictors = $perfect_stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($perfect_predictors) {
                    echo "<ol class='list-group list-group-numbered'>";
                    foreach ($perfect_predictors as $predictor) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>";
                        echo "<div class='ms-2 me-auto'>" . htmlspecialchars($predictor['username']) . "</div>";
                        echo "<span class='badge bg-primary rounded-pill'>" . htmlspecialchars($predictor['perfect_predictions_count']) . "</span>";
                        echo "</li>";
                    }
                    echo "</ol>";
                } else {
                    echo "<p class='text-white'>Aucun utilisateur avec des pronostics parfaits pour le moment, ou aucun match terminé n'a encore de scores réels enregistrés.</p>";
                }
            } else {
                echo "<p class='text-white'>Erreur de connexion à la base de données.</p>";
            }
            ?>
        </div>
    </div>

    <div class="stats-section my-5">
        <h2 class="text-white">Classement - Meilleurs Oracles (Bon Résultat)</h2>
        <div id="outcome-predictor-leaderboard">
            <?php
            if (isset($db)) {
                $oracle_stmt = $db->query(
                    'SELECT
                        u.username,
                        SUM(CASE
                            WHEN (m.real_score_team1 = m.real_score_team2 AND mu.score_team1 = mu.score_team2) THEN 1
                            WHEN ((m.real_score_team1 - m.real_score_team2) * (mu.score_team1 - mu.score_team2) > 0) THEN 1
                            ELSE 0
                        END) AS correct_outcomes_count,
                        COUNT(mu.match_id) AS total_predictions_on_concluded_matches
                    FROM
                        users u
                    JOIN
                        matchs_users mu ON u.id = mu.user_id
                    JOIN
                        matchs m ON mu.match_id = m.id
                    WHERE
                        m.real_score_team1 IS NOT NULL AND m.real_score_team2 IS NOT NULL
                    GROUP BY
                        u.id, u.username
                    HAVING
                        COUNT(mu.match_id) > 0
                    ORDER BY
                        ( CAST(SUM(CASE
                            WHEN (m.real_score_team1 = m.real_score_team2 AND mu.score_team1 = mu.score_team2) THEN 1
                            WHEN ((m.real_score_team1 - m.real_score_team2) * (mu.score_team1 - mu.score_team2) > 0) THEN 1
                            ELSE 0
                        END) AS REAL) / COUNT(mu.match_id) ) DESC,
                        correct_outcomes_count DESC
                    LIMIT 10;' // Limiting to top 10
                );
                $oracle_predictors = $oracle_stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($oracle_predictors) {
                    echo "<ol class='list-group list-group-numbered'>";
                    foreach ($oracle_predictors as $predictor) {
                        $percentage = 0;
                        if ($predictor['total_predictions_on_concluded_matches'] > 0) {
                            $percentage = ($predictor['correct_outcomes_count'] / $predictor['total_predictions_on_concluded_matches']) * 100;
                        }
                        echo "<li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>";
                        echo "<div class='ms-2 me-auto'>" . htmlspecialchars($predictor['username']) . "</div>";
                        echo "<span class='badge bg-success rounded-pill'>" . round($percentage, 2) . "%</span>";
                        echo "<small class='ms-2 text-white-50'>(" . htmlspecialchars($predictor['correct_outcomes_count']) . "/" . htmlspecialchars($predictor['total_predictions_on_concluded_matches']) . ")</small>";
                        echo "</li>";
                    }
                    echo "</ol>";
                } else {
                    echo "<p class='text-white'>Aucun utilisateur avec des résultats significatifs pour le moment, ou aucun match terminé n'a encore de scores réels enregistrés.</p>";
                }
            } else {
                echo "<p class='text-white'>Erreur de connexion à la base de données.</p>";
            }
            ?>
        </div>
    </div>

    <div class="stats-section my-5">
        <h2 class="text-white">Analyse par Match (Exemple)</h2>
        <div id="match-deep-dive">
            <?php
            if (isset($db)) {
                $match_dive_stmt = $db->query(
                    'SELECT
                        m.id AS match_id,
                        t1.name AS team1_name,
                        t2.name AS team2_name,
                        m.real_score_team1,
                        m.real_score_team2
                    FROM
                        matchs m
                    JOIN
                        teams t1 ON m.team1_id = t1.id
                    JOIN
                        teams t2 ON m.team2_id = t2.id
                    WHERE
                        m.real_score_team1 IS NOT NULL AND m.real_score_team2 IS NOT NULL
                    ORDER BY
                        m.id DESC
                    LIMIT 1;'
                );
                $match_to_analyze = $match_dive_stmt->fetch(PDO::FETCH_ASSOC);

                if ($match_to_analyze) {
                    $match_id = $match_to_analyze['match_id'];
                    $team1_name = htmlspecialchars($match_to_analyze['team1_name']);
                    $team2_name = htmlspecialchars($match_to_analyze['team2_name']);
                    $real_score_team1 = htmlspecialchars($match_to_analyze['real_score_team1']);
                    $real_score_team2 = htmlspecialchars($match_to_analyze['real_score_team2']);

                    echo "<h4 class='text-white'>Analyse du match : " . $team1_name . " vs " . $team2_name . "</h4>";
                    echo "<p class='text-white'>Score réel : <strong>" . $real_score_team1 . " - " . $real_score_team2 . "</strong></p>";

                    // Total predictions for this match
                    $total_preds_stmt = $db->prepare('SELECT COUNT(*) as count FROM matchs_users WHERE match_id = :match_id;');
                    $total_preds_stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
                    $total_preds_stmt->execute();
                    $total_preds_count = $total_preds_stmt->fetch(PDO::FETCH_ASSOC)['count'];

                    if ($total_preds_count > 0) {
                        // Most common prediction
                        $common_pred_stmt = $db->prepare(
                            'SELECT score_team1, score_team2, COUNT(*) as frequency
                             FROM matchs_users WHERE match_id = :match_id
                             GROUP BY score_team1, score_team2 ORDER BY frequency DESC LIMIT 1;'
                        );
                        $common_pred_stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
                        $common_pred_stmt->execute();
                        $common_pred = $common_pred_stmt->fetch(PDO::FETCH_ASSOC);
                        if ($common_pred) {
                            echo "<p class='text-white'>Pronostic le plus courant : <strong>" . htmlspecialchars($common_pred['score_team1']) . " - " . htmlspecialchars($common_pred['score_team2']) . "</strong> (par " . htmlspecialchars($common_pred['frequency']) . " utilisateurs)</p>";
                        }

                        // Correct outcome percentage
                        $correct_outcome_stmt = $db->prepare(
                           "SELECT COUNT(*) as count FROM matchs_users mu
                            WHERE mu.match_id = :match_id AND
                            (
                                (mu.score_team1 = :rs1 AND mu.score_team2 = :rs2) OR -- Perfect match implies correct outcome
                                ( (:rs1 = :rs2) AND (mu.score_team1 = mu.score_team2) ) OR -- Correct draw
                                ( (:rs1 > :rs2 AND mu.score_team1 > mu.score_team2) ) OR -- Correct team1 win
                                ( (:rs1 < :rs2 AND mu.score_team1 < mu.score_team2) ) -- Correct team2 win
                            )"
                        );
                        $correct_outcome_stmt->execute([
                            ':match_id' => $match_id,
                            ':rs1' => $match_to_analyze['real_score_team1'],
                            ':rs2' => $match_to_analyze['real_score_team2']
                        ]);
                        $correct_outcome_count = $correct_outcome_stmt->fetch(PDO::FETCH_ASSOC)['count'];
                        $correct_outcome_perc = ($correct_outcome_count / $total_preds_count) * 100;
                        echo "<p class='text-white'>Pourcentage de pronostics avec le bon résultat : <strong>" . round($correct_outcome_perc, 2) . "%</strong></p>";

                        // Perfect score percentage
                        $perfect_score_stmt = $db->prepare(
                            'SELECT COUNT(*) as count FROM matchs_users
                             WHERE match_id = :match_id AND score_team1 = :real_score_team1 AND score_team2 = :real_score_team2;'
                        );
                        $perfect_score_stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
                        $perfect_score_stmt->bindParam(':real_score_team1', $match_to_analyze['real_score_team1'], PDO::PARAM_INT);
                        $perfect_score_stmt->bindParam(':real_score_team2', $match_to_analyze['real_score_team2'], PDO::PARAM_INT);
                        $perfect_score_stmt->execute();
                        $perfect_score_count = $perfect_score_stmt->fetch(PDO::FETCH_ASSOC)['count'];
                        $perfect_score_perc = ($perfect_score_count / $total_preds_count) * 100;
                        echo "<p class='text-white'>Pourcentage de pronostics parfaits : <strong>" . round($perfect_score_perc, 2) . "%</strong></p>";

                    } else {
                        echo "<p class='text-white'>Aucun pronostic enregistré pour ce match.</p>";
                    }
                } else {
                    echo "<p class='text-white'>Aucun match terminé avec scores réels n'a été trouvé pour l'analyse.</p>";
                }
            } else {
                echo "<p class='text-white'>Erreur de connexion à la base de données.</p>";
            }
            ?>
        </div>
    </div>

    <div class="stats-section my-5">
        <h2 class="text-white">Match le Plus Surprenant</h2>
        <div id="most-surprising-match">
            <?php
            if (isset($db)) {
                $all_concluded_matches_stmt = $db->query(
                    'SELECT
                        m.id AS match_id, t1.name AS team1_name, t2.name AS team2_name,
                        m.real_score_team1, m.real_score_team2
                    FROM matchs m
                    JOIN teams t1 ON m.team1_id = t1.id
                    JOIN teams t2 ON m.team2_id = t2.id
                    WHERE m.real_score_team1 IS NOT NULL AND m.real_score_team2 IS NOT NULL;'
                );
                $concluded_matches = $all_concluded_matches_stmt->fetchAll(PDO::FETCH_ASSOC);

                $most_surprising_match_details = null;
                $min_correct_percentage = 101; // Start higher than 100%

                if ($concluded_matches) {
                    foreach ($concluded_matches as $match_data) {
                        $current_match_id = $match_data['match_id'];
                        $rs1 = $match_data['real_score_team1'];
                        $rs2 = $match_data['real_score_team2'];

                        $total_preds_stmt = $db->prepare('SELECT COUNT(*) as count FROM matchs_users WHERE match_id = :match_id;');
                        $total_preds_stmt->bindParam(':match_id', $current_match_id, PDO::PARAM_INT);
                        $total_preds_stmt->execute();
                        $total_preds_count = $total_preds_stmt->fetch(PDO::FETCH_ASSOC)['count'];

                        if ($total_preds_count > 0) {
                            $correct_outcome_stmt = $db->prepare(
                               "SELECT COUNT(*) as count FROM matchs_users mu
                                WHERE mu.match_id = :match_id AND
                                (
                                    (mu.score_team1 = :rs1 AND mu.score_team2 = :rs2) OR
                                    ( (:rs1 = :rs2) AND (mu.score_team1 = mu.score_team2) ) OR
                                    ( (:rs1 > :rs2 AND mu.score_team1 > mu.score_team2) ) OR
                                    ( (:rs1 < :rs2 AND mu.score_team1 < mu.score_team2) )
                                )"
                            );
                            $correct_outcome_stmt->execute([':match_id' => $current_match_id, ':rs1' => $rs1, ':rs2' => $rs2]);
                            $correct_outcome_count = $correct_outcome_stmt->fetch(PDO::FETCH_ASSOC)['count'];

                            $current_correct_percentage = ($correct_outcome_count / $total_preds_count) * 100;

                            if ($current_correct_percentage < $min_correct_percentage) {
                                $min_correct_percentage = $current_correct_percentage;
                                $most_surprising_match_details = $match_data;
                                $most_surprising_match_details['percentage'] = $current_correct_percentage;
                            }
                        }
                    }

                    if ($most_surprising_match_details) {
                        echo "<h4 class='text-white'>Match le Plus Surprenant : " . htmlspecialchars($most_surprising_match_details['team1_name']) . " vs " . htmlspecialchars($most_surprising_match_details['team2_name']) . "</h4>";
                        echo "<p class='text-white'>Score réel : <strong>" . htmlspecialchars($most_surprising_match_details['real_score_team1']) . " - " . htmlspecialchars($most_surprising_match_details['real_score_team2']) . "</strong></p>";
                        echo "<p class='text-white'>Seulement <strong>" . round($most_surprising_match_details['percentage'], 2) . "%</strong> des participants ont correctement prédit le résultat de ce match !</p>";
                    } else {
                        echo "<p class='text-white'>Pas assez de données pour déterminer un match surprenant (nécessite des matchs terminés avec pronostics).</p>";
                    }
                } else {
                    echo "<p class='text-white'>Aucun match terminé avec scores réels trouvé pour analyse.</p>";
                }
            } else {
                echo "<p class='text-white'>Erreur de connexion à la base de données.</p>";
            }
            ?>
        </div>
    </div>

</div>

<?php
// include('footer.php'); // If you have a common footer
?>
</div>
        </main>

       </main>
    </div>
</div>
