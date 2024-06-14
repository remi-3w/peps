<?php 

session_start();
unset($_SESSION['user']);
// $msg['flash']['info'] = "vous êtes bien déconnecté";     
// $_SESSION = array();
header('Location: ' . '/template/home.php');

?>