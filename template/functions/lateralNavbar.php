<?php
$sql = 'SELECT * FROM users ORDER BY id ASC ';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchall();
$sql = 'SELECT *
FROM matchs_users AS mu ORDER BY id ASC';
?>

<div class="lateralnav col-auto col-sm-3 col-md-3 col-lg-2 px-0 px-sm-2 vh-100 overflow-auto sticky-top">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-1 pt-2">
        <div class="col-12 col-lg-12 col-xl-12">
            <p class="currentDate fontsaira fw-bold text-center m-auto "><?php print_r($now); ?></p1>
        </div>
                <ul class="nav nav-pills nav-fill flex-column mb-sm-auto mb-0 align-items-sm-start" id="menu">
                    <p class="d-flex align-items-center pb-3 mb-md-0 me-md-auto">
                        <span class="fs-5 d-none d-sm-inline">Pages</span>
                    </p>
                    <li>
                        <a href="../template/home.php" class=" nav-link col align-middle px-0">
                            <i class="fs-4 bi-house"></i>
                            <span class="ms-1 d-none d-sm-inline">Acceuil</span>
                        </a>
                    </li>
                    <li>
                        <a href="../template/play.php" class="nav-link px-0 align-middle">
                            <i class="bi bi-joystick"></i> <span class="ms-1 d-none d-sm-inline">Jouer</span> </a>

                    </li>
                    <li class="dropdown">
                        <a href="" type="button" class="nav-link dropdown-toggle px-0 align-middle" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Pronos</span></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($users as $user) {
                                $userId = $user['id'];
                            ?>
                            <a href =/template/showpronoplayer.php?ID<?php echo "=".$userId;?>>
                                <li class="list-item dropdown-item" ><?php echo $user['username'];?></li>
                            </a>
                            <?php } ?>
                        </ul>

                    </li>
                    <li>
                        <a href="../template/rank.php" class="nav-link px-0 align-middle">
                            <i class="bi bi-bar-chart-line"></i> <span class="ms-1 d-none d-sm-inline">Classement</span></a>
                    </li>

                    <hr class="divider-menu" />

                    <p class="d-flex align-items-center pb-3 mb-md-0 me-md-auto ">
                        <span class="fs-5 d-none d-sm-inline">Infos</span>
                    </p>

                    <li>
                        <a href="../template/gamerules.php" class="nav-link px-0 align-middle ">
                            <i class="bi bi-columns-gap"></i> <span class="ms-1 d-none d-sm-inline">Règles</span></a>

                    </li>
                    <li>
                        <a  href="../template/profile.php" class="nav-link px-0 align-middle">
                            <i class="fa fa-user"></i><span class="ms-1 d-none d-sm-inline">Profile</span></a>
                    </li>
                    <li>
                        <a href="../template/functions/logout.php" class="nav-link px-0 align-middle text-danger">
                            <i class="fs-4 bi-people text-danger"></i> <span class="ms-1 d-none d-sm-inline ">Déconnexion</span> </a>
                    </li>

                </ul>

                <?php if ($_SESSION && $_SESSION["user"]["id"] == 2) {
                    echo '<a href="../template/realScore.php"><img class="ball" src=" ../assets/img/ball.png" alt="ball"></a> ';
                };
                ?>
                <div class="dropdown pb-4">
                    <p href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php                   
                        $picture = $picture = $users[$id - 1]['picture'];
                        $avatar = "../assets/img/userfile/". $_SESSION['user']['pseudo'] ."/" . $picture; // $filename = la donnée en BDD
                        $firstname = $_SESSION['user']['pseudo']
                     ?>

                    <img src=<?php echo $avatar ?> alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $firstname ?></span>
                    </p>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="../template/live.php"> LIVE 🔴</a></li>
                        <li><a class="dropdown-item" href="../template/profile.php">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout.php">Sign out</a></li>
                    </ul>
                </div>
            <!-- Note: The original file was missing closing divs for container-fluid and row.
                 This refactoring makes the navbar self-contained as a single column div. -->
    </div>
</div>