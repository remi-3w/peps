<?php
include_once('../header.php');
try{	
		$db= new PDO('sqlite:db.sqlite');
	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();

  	 die();
	}    
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {         
          $name = $_POST['username'];
          $name = strip_tags($name);
          $email = $_POST['email'];
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               die("l'adresse email n'est pas valide");
          }
          $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);  
          $sql = 'INSERT INTO users (username, email, password ) VALUES (?, ?, ?)';
          $stmt = $db->prepare($sql);
          
          $stmt->execute(array($name, $email, $password));
          header('Location: ' . '/peps/template/connexion.php');             
          };
 