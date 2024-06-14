<?php
// date du jour formatée en français et en version FULL ex: Jeudi 10 mars 2022
$nowFormatFr = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$now = $nowFormatFr->format(time()); // date du jour formatée en français

//Ouvrir ou crÃ©er la base de donnÃ©es member
$db = new PDO('sqlite:db.SQLite');
//Activer les exceptions
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM teams';
$stmt = $db->prepare($sql);
$stmt->execute();
//extaire les donnÃ©es
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
//Parcourir la liste des membres
foreach ($teams as $row) {
    echo 'ID' . $row['id'] . ' Nom ' . $row['name'];
}


// try {
//     $pdo = new PDO('sqlite:' . dirname(__FILE__) . '/db.SQLite');
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT


// } catch (Exception $e) {
//     echo "Impossible d'accéder à la base de données SQLite : " . $e->getMessage();
//     die();
//     $stmt = $pdo->prepare("SELECT * FROM teams" );
//     $stmt->execute(array('id' => 'id'));
//     $result = $stmt->fetchAll();
//     var_dump($result);
//     print_r($result);
//     echo $result;
// };


// recuperer les informations des matchs et les afficher en fonction de la date
$file = "http://peps/template/data.json";
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file);
// décoder le flux JSON
$obj = json_decode($data, true);
// accéder à l'élément approprié


$timestampnow = datefmt_parse($nowFormatFr, $now); // date du jour formatée en timestamp
//var_dump($timestampnow);// ex 1646870400
$matchday = $obj["rounds"][0]["matches"][0]["date"];
$timestampmatchday = strtotime($matchday); // parse une date au format string  au format INT
// var_dump($timestampmatchday) ; // affiche ex: 1528934400 
$equipe1 = $obj["rounds"][0]["matches"][0]["team1"]["code"];
$equipe2 = $obj["rounds"][0]["matches"][0]["team2"]["code"];
$nextmatch = "$equipe1 - $equipe2";


// comparer la date du jour avec la date du match et retourner un resulat 
// if ($timestampmatchday <= $timestampnow) {
//     //echo ("$nextmatch");
// } else {
//     echo ("Match terminé");
// }

// opération ternaire qui affiche soit le prochaine match ou le message de fin de match
// echo $timestampmatchday <= $timestampnow ? "$nextmatch" : "Match terminé";
?>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>acceuil</title>
</head>

<body>
    <div class="container-fluid m-0 p-0 ">
        <div class="row align-items-center">
            <div class="col-4 hero-logo  border-peps">
                <!-- version text du logo -->
                <!-- TODO ajouter la police -->
                <a href="https://www.remimouton.com/peps/home" id="linkhome">
                    <h3 class=" fontsaira ">PEP'S</h3>
                </a>
                <!-- version image du logo -->
                <!--  <a href="/template/home.php">
                    <img src="../assets/Logo.svg"> -->
            </div>

            <div class="col-6 column">
                <h1 class="currentDate fontsaira "><?php print_r($now); ?></h1>
                <div class="info row alert-primary d-inline-flex " role="alert">
                    <h2 class="text-light fontsaira">Prochain match:</h2>
                    <h1 class=" fontsaira fst-italic"><?php print_r($nextmatch) ?></h1>
                </div>
            </div>
            <div class="col-2 row align-items-center d-inline-flex">
                <img class="mx-auto d-block" style="width:64px" src=" ../assets/france.pixelartsf.png" alt="Rain Drops">
                <a class="text-center" href="/template/subscribe.php">Login</a>
            </div>
        </div>
    </div>