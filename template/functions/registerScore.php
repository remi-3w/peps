<?php
session_start();
    try {
        $db = new PDO('sqlite:db.sqlite');
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage();

        die();
    }
    $nowFormatFr = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
    $now = $nowFormatFr->format(time()); 
    $timestampnow = datefmt_parse($nowFormatFr, $now); 
    $timestampnow;
    var_dump($timestampnow);

         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             // var_dump($_SESSION);
             $score1 = (int)$_POST['score1'];
             $score2 = (int)$_POST['score2'];
             $num = (string)$_POST['nummatch'];
             $user_id = (string)$_SESSION['user']['id'];
             $score_update = $timestampnow;
            //  var_dump($score_update);
            //  die();

             $data = $db->prepare('SELECT * FROM matchs_users WHERE user_id = :user_id  AND match_id = :num');
             $data->bindValue(':num', $num, PDO::PARAM_INT);
             $data->bindValue(':user_id', $user_id, PDO::PARAM_INT);
             $data->execute();
             $matchexist = $data->fetchALL();

             if ($matchexist) {
                 $sql = 'UPDATE matchs_users SET score_team1 = :score1, score_team2 = :score2,score_update =:scoreupdate WHERE user_id = :user_id AND match_id = :num';
                 $stmt = $db->prepare($sql);
                 $stmt->bindValue(':num', $num, PDO::PARAM_INT);
                 $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                 $stmt->bindValue(':score1', $score1, PDO::PARAM_INT);
                 $stmt->bindValue(':score2', $score2, PDO::PARAM_INT);
                 $stmt->bindValue(':score_update', $score_update, PDO::PARAM_INT);
                 $stmt->execute();

             } else {
                 $sql = 'INSERT INTO matchs_users (match_id, user_id, score_team1, score_team2, score_update) VALUES ($num, $user_id, $score1, $score2, $score_update)';
                 $stmt = $db->prepare($sql);
                 $stmt->bindValue(':score1', $score1, PDO::PARAM_INT);
                 $stmt->bindValue(':score2', $score2, PDO::PARAM_INT);
                 $stmt->bindValue(':num', $num, PDO::PARAM_INT);
                 $stmt->bindValue(':score_update', $score_update, PDO::PARAM_INT);
                 $stmt->bindValue(':id_user', $user_id, PDO::PARAM_INT);
                 $stmt->execute(array($num, $user_id, $score1, $score2));
             }
             $_SESSION['flash']['success'] = "Le score est bien enregistré !";
             header('Location: ' . '../play.php');
         }

         ?>

         <script>
            showtoast();
         </script>
    