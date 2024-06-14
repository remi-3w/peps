<?php

//$db = new PDO('sqlite:db.sqlite');

//Activer les exceptions
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	try{
 	 	
		$db= new PDO('sqlite:db.sqlite');
		
		//return $db;

	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();

  	 die();
	}



?>