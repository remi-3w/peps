<?php
// include_once(dirname(__FILE__) . '../header.php');
try{
 	 	
		$db= new PDO('sqlite:db.sqlite');
		
		//return $db;

	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();

  	 die();
	}



  
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {          
         
          $email = $_POST['email'];
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               header('Location: ' . '/template/connexion.php');             
               die("l'adresse email n'est pas valide");
          } 

          $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);
          // die($password);
 
          $sql = 'SELECT id, username, email, password, is_admin FROM users WHERE email = :email';
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
          $stmt->execute();
          $user = $stmt->fetch();
        
          if (!$user){
              // header('Location: ' . '/template/connexion.php');
               die("l'utilisateur ou le mot de passe n'est pas valide");
          }

          if (!password_verify($_POST["password"], $user["password"])) {
               //header('Location: ' . '/template/connexion.php');            
               die("le mot de passe n'est pas valide");
          }
          session_start();
          $_SESSION['user'] = [
               "id" => $user["id"],
               "pseudo" => $user["username"],
               "email" => $user["email"],
               "is_admin" => $user["is_admin"]
          ];
     
          header('Location: ' . '/template/home.php');             
          };

 