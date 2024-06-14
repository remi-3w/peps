     <?php
     $conn = new PDO('sqlite:../db.sqlite');
     //Activer les exceptions
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // Check connection
     if (!$conn) {
          die("Échec de la connexion : " . mysqli_connect_error());
     }

     echo "Connexion réussie";
     
          //on recupère les données du formulaire
                
          $score1 = $_POST['score1']; 
          $score2 = $_POST['score2'];
   
          $num = $_POST['nummatch'];
  
          $sql=$conn->prepare( "UPDATE matchs SET score_team1 = $score1 , score_team2 = $score2 WHERE id = $num ");
  
          $sql->execute();
     //           header('Location: ' . '../home' . '.php');
     //    die(); 
           
      


     
      
      
   

     ?>