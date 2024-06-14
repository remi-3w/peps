<?php
		try{
		$db= new PDO('sqlite:functions/db.sqlite');
	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();
  	 	die();
	};


?>