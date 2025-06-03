<?php
session_start();
include_once(dirname(__FILE__) . '/functions/connexion.php');

$nowFormatFr = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$now = $nowFormatFr->format(time());
$timestampnow = datefmt_parse($nowFormatFr, $now);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
<!--*** CSS *** #}-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">	
    <link href="../assets/css/chartcss.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="http://fonts.cdnfonts.com/css/bruno-ace" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Saira&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e41c5169c9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../assets/Js/toast.js" async></script>
    <script src="script.js" async></script>
    <title>Pep's</title>
</head>

<body>
<div class="d-flex justify-content-around col-12 py-5">
        <div class="row col-lg-4 col-xl-4 hero-logo border-peps">
            <a href="./home.php" id="linkhome" class="bruno col-lg-12 col-12">
                PEP'S
            </a>
        </div>
        <div class="col-xl-2 row">
            <?php if ($_SESSION) {
                ?>
                <div class="text-center text-white">
                <?php echo $_SESSION["user"]["pseudo"];?>
                </div>
                <?php
                $sql = 'SELECT * FROM users';
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);          
                $id = $_SESSION['user']['id'];              
                $picture = $users[$id - 1]['picture'];
                $firstname = $users[$id]['username'];
                    if(($picture) !== "fixture"){
                    $avatar = "../assets/img/userfile/". $_SESSION['user']['pseudo'] ."/" . $picture; // $filename = la donnée en BDD
                    
                    }else{
                    $avatar = "../assets/img/fixture.png" ;                        
                    }?>

                <img class="imglogin m-auto" src= <?php echo $avatar ?>>
            <?php } else {
            ?>
            <a href="./connexion.php"><button class="btn btn-primary btn-lg ">Connexion</button></a>
            <?php       
            }          
            if (isset($msg["flash"])) {
                foreach ($msg['flash'] as $type => $message) : 
                ?>
                    <div id="alert" class="alert alert-<?= $type; ?> infoMessage"><a class="close">X</span></a>
                        <?= $message; ?>
                    </div>
            <?php
                endforeach;
                unset($_SESSION['flash']);
            }
            ?>
        </div>
    </div>






    
   