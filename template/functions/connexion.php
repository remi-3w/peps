<?php
		try{
		$db= new PDO('sqlite:' . __DIR__ . '/db.sqlite');
	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();
  	 	die();
	};


?>