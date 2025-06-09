<?php include(dirname(__FILE__) . '/header.php'); ?>

<div class="page-wrapper container-fluid px-0">
    <div class="row flex-nowrap gx-0">

        <?php
        // Sidebar column (conditionally included)
        if (isset($_SESSION['user'])) { // More specific check
            include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
        }
        ?>

        <main class="col pt-2 main-content-area <?php if (isset($_SESSION['user'])) { echo 'main-content-area-with-sidebar ps-md-2'; } ?>">
            <?php
            if (isset($_SESSION['user'])) { // Content for logged-in users
                // Fetch top 3 users for the podium - only if logged in
                // Ensure $db is available from header.php
                if (isset($db)) {
                    $sql_podium = 'SELECT id, username, score, picture FROM users ORDER BY score DESC LIMIT 3'; // Renamed SQL variable
                    $stmt_podium = $db->prepare($sql_podium);
                    $stmt_podium->execute();
                    $users = $stmt_podium->fetchAll(PDO::FETCH_ASSOC); // Keep $users for now, will update podium later if needed
                } else {
                    $users = [];
                }
            ?>
            <div class="home-page-inner-content p-3">
                <div class="container-fluid"> {/* Using container-fluid for wider content with sidebar */}
                  <div class="livetoast col-12 z-1" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem;">
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
                </div> <!-- Closes .container-fluid from logged-in view -->
            </div> <!-- Closes .home-page-inner-content from logged-in view -->
            <?php } else { // Non-logged-in view ?>
                <div class="home-page-inner-content p-0">
                    <div class="container-fluid vh-100 d-flex flex-column justify-content-center"> {/* Centering content */}
                        <div class="m-auto col-12 py-3 row d-flex justify-content-evenly home-hero-section align-items-center"> {/* home-hero-section remains for existing CSS */}
            <div class=" col-12 col-lg-6 col-xl-6 text-center">
                <img class="image-hero img-fluid" src="../assets/img/FIFA-Womens-World-Cup-2023-Embleme.jpg" alt="FIFA Women's World Cup 2023 Logo">
            </div>
            <div class="col-12 col-lg-6 col-xl-6 hero-text p-4 rounded">
                <div class="row d-flex justify-content-center">
                <h2 class="h2 fw-bold fontsaira ">Pari entre potes</h2>
                <p class="col-lg-10 col-xl-10 mx-auto text-hero fontsaira"> <b>Aligne</b> les scores de tous les matchs du tournoi et <b>hisse</b> toi à la meilleure place du classement</p>
                <i class="col-auto far fa-futbol fa-spin fa-3x d-block mx-auto my-3"></i>
            </div>
        </div>
        <div class="py-5 col-12 d-flex justify-content-center">
            <div class="col-md-4 col-sm-6 col-8 d-flex justify-content-center subs-button-container">
                <a class="btn btn-outline-warning btn-lg fontSaira subs w-100" href="/template/subscribe.php" role="button">S'inscrire</a>
            </div>
        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </main>

    </div><!-- /.row -->
</div><!-- /.page-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>

</html>
 