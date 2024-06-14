<?php
session_start();
try{	
     $db= new PDO('sqlite:db.sqlite');
} 
     catch (PDOException $e) 
{
       print "Erreur : " . $e->getMessage();

   die();
	}    
     // si il ya une requete en Post
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // var_dump($_SESSION);          
          $score1 = (int)$_POST['score1']; 
          $score2 = (int)$_POST['score2'];  
          $num = (string)$_POST['nummatch'];
          $user_id = (string)$_SESSION['user']['id'];       
          $data = $db->prepare('SELECT * FROM matchs WHERE id = :num');
          $data->bindValue(':num', $num, PDO::PARAM_INT);         
          $data->execute();
          $matchexist = $data->fetchALL();
               
            if ($matchexist) {
               //die('les données existes deja');
               $sql = 'UPDATE matchs SET real_score_team1 = :score1, real_score_team2 = :score2 WHERE id = :num';
               $stmt = $db->prepare($sql);
               $stmt->bindValue(':num', $num, PDO::PARAM_INT);               
               $stmt->bindValue(':score1', $score1, PDO::PARAM_INT);
               $stmt->bindValue(':score2', $score2, PDO::PARAM_INT);
               $stmt->execute();
          
          }else{
              // die('les données n existe pas');
               $sql = 'INSERT INTO matchs (real_score_team1, real_score_team2) VALUES ( $score1, $score2)';
               $stmt = $db->prepare($sql);
               $stmt->bindValue(':score1', $score1, PDO::PARAM_INT,);
               $stmt->bindValue(':score2', $score2, PDO::PARAM_INT,);
               $stmt->bindValue(':num', $num, PDO::PARAM_INT,);
               $stmt->bindValue(':id_user', $user_id, PDO::PARAM_INT,);         
               $stmt->execute(array($num, $user_id, $score1, $score2));
               }

          require_once "compareMatchsToScore.php";    
          header('Location: ' . '/template/realScore.php');             
          };
 