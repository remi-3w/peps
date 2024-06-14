<?php
try {
    // Connexion à la base de données SQLite
    $db = new PDO('sqlite:db.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionnez les matchs et les utilisateurs associés
    $sql = "SELECT * FROM matchs AS m INNER JOIN matchs_users AS mu ON m.id = mu.match_id";
    $matchs = $db->query($sql);
    $matchs->setFetchMode(PDO::FETCH_ASSOC);
    $matchs = $matchs->fetchAll();

    // Parcourez les matchs et mettez à jour les scores des utilisateurs
    foreach ($matchs as $match) {
        $id = $match['user_id'];
        $scoreteam1user = $match['score_team1'];
        $scoreteam2user = $match['score_team2'];
        $realscoreteam1 = $match['real_score_team1'];
        $realscoreteam2 = $match['real_score_team2'];

        // Obtenez le score actuel de l'utilisateur depuis la base de données
        $sql = 'SELECT score FROM users WHERE id = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $score = $row['score'];

        // Test1 : Le score parfait est trouvé
        if ($scoreteam1user == $realscoreteam1 && $scoreteam2user == $realscoreteam2) {
            $score += 50;
        }

        // Test2 : Trouver l'équipe gagnante ou un match nul
        if (($realscoreteam1 == $realscoreteam2) && ($scoreteam1user == $scoreteam2user)) {
            $score += 30;
        } elseif (($scoreteam2user - $scoreteam1user) * ($realscoreteam2 - $realscoreteam1) > 0) {
            $score += 30;
        }

        // Test3 : Nombre de buts marqués
        if ($scoreteam1user + $scoreteam2user == $realscoreteam1 + $realscoreteam2) {
            $score += 20;
        }

        // Mettez à jour le score total de l'utilisateur dans la base de données
        $sql = 'UPDATE users SET score = :score WHERE id = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':score', $score, PDO::PARAM_INT);
        $stmt->execute();
    }
} catch (PDOException $e) {
    // Gestion des erreurs de base de données
    echo "Erreur : " . $e->getMessage();
}

?>