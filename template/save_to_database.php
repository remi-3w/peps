<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numMatch = $_POST['nummatch'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];

    // Ouvrir la base de données SQLite
    $db = new SQLite3('my_database.db');

    // Préparer et exécuter une requête d'insertion ou de mise à jour
    $query = $db->prepare('INSERT OR REPLACE INTO scores (nummatch, score1, score2) VALUES (:nummatch, :score1, :score2)');
    $query->bindValue(':nummatch', $numMatch, SQLITE3_INTEGER);
    $query->bindValue(':score1', $score1, SQLITE3_INTEGER);
    $query->bindValue(':score2', $score2, SQLITE3_INTEGER);
    $query->execute();

    // Fermer la base de données
    $db->close();

    // Envoyer une réponse JSON indiquant le succès
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // Envoyer une réponse JSON indiquant une erreur
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
