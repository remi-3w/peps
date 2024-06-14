<?php
include_once(dirname(__FILE__) . '/header.php');
if ($_SESSION) {
include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
};

try{
 	 	
		$db= new PDO('sqlite:functions/db.sqlite');
		
		//return $db;

	} 
		catch (PDOException $e) 
	{
  		print "Erreur : " . $e->getMessage();

  	 die();
	}
    $sql = 'SELECT * FROM users ORDER BY score DESC limit 3';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    if ($_SESSION) {
        echo '<div class=" d-flex-block text-center mt-2 text-white align-items-end row col-9 justify-content-around">';
        foreach ($users as $i => $user) {

            echo '<div class="col-3 text-center">';
            echo '<div>';
            echo $user['username'];
            echo '</div>';
            echo '<img src="../assets/img/max.png" alt="logo" class="img-fluid">';
            echo '<div id="rank' . $i . '" class="col-12">';
            echo $user['score'] . ' ' . 'points';
            echo ' </div>';
            echo '</div>';
        };
        
        echo '</div>';
        echo '</body>';
        echo '</html>';
    } else {
        echo '

<div class="col-12 py-3 row justify-content-center">
    <div class="col-12 col-lg-6 col-xl-6 col-sm-6 d-flex justify-content-center">			
        <img class="col-lg-12 img-fluid logowc2022" src="../assets/img/uefa-f-2022.png">
    </div>
    <div class="col-12 col-lg-6 col-xl-6 col-sm-6 hero-text">
        <div class="row d-flex justify-content-center">
        <h2 class="h2 fw-bold fontsaira ">Pari entre potes</h2>
        <p class="text-hero col-xl-5 align-items-center fontsaira"> <b>Aligne</b> les scores de tous les matchs du tournoi et <b>hisses</b> toi à la meilleur place du classement</p>
        <i class="col-xl-7 hero-icon-ranking"></i>        
    </div>    
</div>
<div class="py-5 col-3 justify-content-center">
    <a class="btn btn-outline-warning btn-lg fontSaira subs" href="./subscribe.php" role="button">S\'inscrire</a>
</div>
</body>';

}
?>