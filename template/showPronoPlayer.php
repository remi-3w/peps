<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include(dirname(__FILE__) . '/functions/lateralNavbar.php');

$sql = 'SELECT m.date, m.id, m.team1_id, m.team2_id, t1.code AS equipe1, t2.code AS equipe2 FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id = t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id WHERE m.date = "2023-07-20";';
$stmt = $db->prepare($sql);
$stmt->execute();
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
$date = $matchs[0]['date'][0];
$timestampmatchday = strtotime($date); // date du match en time stamp


$sql = 'SELECT m.date, m.id, m.team1_id, m.team2_id, t1.code AS equipe1, t2.code AS equipe2 FROM matchs AS m INNER JOIN teams as t1 ON m.team1_id = t1.id INNER JOIN teams AS t2 ON m.team2_id = t2.id;';
$stmt = $db->prepare($sql);
$stmt->execute();
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

$sql = 'SELECT * FROM users ORDER BY id ASC ';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchall();
$player = $users[$_GET['ID'] - 1]['username'];

$sql = 'SELECT *
FROM matchs_users AS mu 
INNER JOIN matchs as m ON m.id = mu.user_id WHERE mu.user_id = ' . $_GET["ID"] . '  ORDER BY mu.match_id ASC';
$stmt = $db->prepare($sql);
$stmt->execute();
$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
?>
<div class="container mx-auto p-1 col-12 col-xl-9 ">
     <h1 class ="text-white">Pronostic de <?php echo $player ?></h1>
    <div class=" fontsaira">
       
        <table class="table table-borderless align-middle">
            <thead>
                <tr class="tablehead">
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Match</th>
                    <th scope="col">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $j = 0; 
                
                foreach ($matchs as $match) 
                {
                    $equipe1 = $match['equipe1'];
                    $equipe2 = $match['equipe2'];
                    $matchid = $match['id'];
                    $date = $match['date'];?>
                   
                    <tr>
                    <th scope="row">
                    <?php echo $i++;?>
                    </th>
                    <td><?php echo dateToFrench("$date", 'l j F');?></td>
                    <td><?php echo "$equipe1 - $equipe2";?></td>
                        <td>
                    <?php
                    if (isset($datas[$j]['score_team1']) && ($datas[$j]['match_id'] == ($i))) {
                        echo "$datas[$j]['score_team1'] - $datas[$j]['score_team2']";                       
                        $j++;
                    } else {
                        echo "pas de pronostic";
                        $j++;
                    }
                }?>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>