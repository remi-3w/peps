<?php
include(dirname(__FILE__) . '/header.php');
if ($_SESSION)
{
     include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
};

    $sql = 'SELECT * FROM users ORDER BY score DESC limit 3';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    if ($_SESSION) {?>
<div class="container col-8 ">
  <div class="livetoast col-12 z-1" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning">
                    <img src="..." class="rounded me-2" alt="⭐">
                    <strong class="me-auto">Information</strong>
                    <small> J-5 </small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-warning">
                    Choisis l'équipe gagnante et prend un bonus de 300 points
                </div>
        </div>

    <div class="top-players-podium row text-center mt-4 mb-4">
        <?php if (isset($users[1])): // 2nd Place - Visually Left ?>
            <?php
                $username1 = $users[1]['username'];
                $picture1 = $users[1]['picture'];
                $avatar1_path = '../assets/img/fixture.png';
                if ($picture1 !== 'fixture' && !empty($picture1)) {
                    $avatar1_path = '../assets/img/userfile/' . rawurlencode($username1) . '/' . rawurlencode($picture1);
                }
            ?>
            <div class="col-md-4 order-md-1 order-2 player-podium-slot">
                <div class="player-card podium-second">
                    <img src="<?php echo htmlspecialchars($avatar1_path); ?>" alt="<?php echo htmlspecialchars($username1); ?> Avatar" class="player-avatar img-fluid rounded-circle mx-auto d-block mb-2">
                    <h5 class="player-name"><?php echo htmlspecialchars($username1); ?> 🥈</h5>
                    <p class="player-score">Score: <?php echo htmlspecialchars($users[1]['score']); ?></p>
                    <a href="showpronoplayer.php?ID=<?php echo $users[1]['id']; ?>" class="btn btn-sm btn-outline-light">Voir Pronos</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($users[0])): // 1st Place - Visually Center ?>
            <?php
                $username0 = $users[0]['username'];
                $picture0 = $users[0]['picture'];
                $avatar0_path = '../assets/img/fixture.png';
                if ($picture0 !== 'fixture' && !empty($picture0)) {
                    $avatar0_path = '../assets/img/userfile/' . rawurlencode($username0) . '/' . rawurlencode($picture0);
                }
            ?>
            <div class="col-md-4 order-md-2 order-1 player-podium-slot">
                <div class="player-card podium-first">
                    <img src="<?php echo htmlspecialchars($avatar0_path); ?>" alt="<?php echo htmlspecialchars($username0); ?> Avatar" class="player-avatar img-fluid rounded-circle mx-auto d-block mb-2">
                    <h5 class="player-name"><?php echo htmlspecialchars($username0); ?> 🥇</h5>
                    <p class="player-score">Score: <?php echo htmlspecialchars($users[0]['score']); ?></p>
                    <a href="showpronoplayer.php?ID=<?php echo $users[0]['id']; ?>" class="btn btn-sm btn-outline-light">Voir Pronos</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($users[2])): // 3rd Place - Visually Right ?>
            <?php
                $username2 = $users[2]['username'];
                $picture2 = $users[2]['picture'];
                $avatar2_path = '../assets/img/fixture.png';
                if ($picture2 !== 'fixture' && !empty($picture2)) {
                    $avatar2_path = '../assets/img/userfile/' . rawurlencode($username2) . '/' . rawurlencode($picture2);
                }
            ?>
            <div class="col-md-4 order-md-3 order-3 player-podium-slot">
                <div class="player-card podium-third">
                    <img src="<?php echo htmlspecialchars($avatar2_path); ?>" alt="<?php echo htmlspecialchars($username2); ?> Avatar" class="player-avatar img-fluid rounded-circle mx-auto d-block mb-2">
                    <h5 class="player-name"><?php echo htmlspecialchars($username2); ?> 🥉</h5>
                    <p class="player-score">Score: <?php echo htmlspecialchars($users[2]['score']); ?></p>
                    <a href="showpronoplayer.php?ID=<?php echo $users[2]['id']; ?>" class="btn btn-sm btn-outline-light">Voir Pronos</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>    </div>
  <?php
    } else { ?>
        <div class="m-auto col-10 py-3 row d-flex justify-content-evenly">
            <div class=" col-12 col-lg-6 col-xl-6 col-sm-6">			
                <img class="image-hero d-flex justify-content-center align-items-center col-lg-10 img-fluid" src="../assets/img/FIFA-Womens-World-Cup-2023-Embleme.jpg">
            </div>
            <div class="col-12 col-lg-6 col-xl-6 col-sm-6 hero-text d-flex justify-content-evenly">
                <div class="row d-flex justify-content-center">
                <h2 class="h2 fw-bold fontsaira ">Pari entre potes</h2>
                <p class=" col-lg-12 col-xl-12  text-hero col-xl-5 align-items-center fontsaira"> <b>Aligne</b> les scores de tous les matchs du tournoi et <b>hisses</b> toi à la meilleur place du classement</p>
                <i class=" col-3 far fa-futbol fa-spin fa-3x d-flex justify-content-center align-items-center"></i>  
            </div>
        </div>
        <div class="py-5 col-12 d-flex justify-content-center">
            <div class="col-3 d-flex justify-content-center ">
                <a class="btn btn-outline-warning btn-lg fontSaira subs" href="/template/subscribe.php" role="button">S'inscrire</a>
            </div>
        </div>

    <?php }?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>

</html>
 