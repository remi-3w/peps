<?php include(dirname(__FILE__) . '/header.php'); 

$users_for_rank = []; // Default to empty
if (isset($db)) { // Ensure $db is available before using it
    $sql = 'SELECT id, username, score FROM users ORDER BY score DESC '; // Removed unused columns for this page
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users_for_rank = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $users_for_rank = []; // Initialize $users_for_rank as empty array if $db is not available
    // Optionally, set an error message to display
    // $error_message = "Database connection is not available.";
}

?>

<div class="page-wrapper container-fluid px-0">
    <div class="row flex-nowrap gx-0">

        <?php
        // Sidebar column (conditionally included)
        if (isset($_SESSION['user'])) { // More specific check
            include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
        }
        ?>

        <main class="col pt-2 main-content <?php if (isset($_SESSION['user'])) { echo 'main-content-area-with-sidebar ps-md-2'; } ?>">
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
            <div class="home-page-inner-content p-0">
                <div class="container-fluid"> 
                  <div class="livetoast col-12 z-1" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem;"> </div>
                <div class="toast-header bg-warning">
                    <img src="..." class="rounded me-2" alt="⭐">
                    <strong class="me-auto">Information</strong>
                    <small> J-5 </small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-warning">
                    Choisis l'équipe gagnante et prend un bonus de 300 points
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
            <?php } else {
                
                // Non-logged-in view ?>
                <div class="hero-banner d-flex align-items-center justify-content-center text-center text-white">
  <div class="hero-content px-4">
    <h1 class="display-4 fw-bold">⚽ Qui aura le flair du champion ?</h1>
    <p class="lead">Prédit les scores, défie tes amis et grimpe au sommet du classement. À toi de jouer !</p>
    <a href="/template/subscribe.php" class="btn btn-warning btn-lg mt-3">Commencer le tournoi</a>
  </div>
</div>
            </div>
            <?php } ?>

        <div class="page-wrapper container-fluid px-0">
    <div class="row flex-nowrap gx-0">

        <?php
        // Sidebar column (conditionally included)
        if (isset($_SESSION['user'])) {
            include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
        }
        ?>

        <main class="col pt-2 main-content-area <?php if (isset($_SESSION['user'])) { echo 'main-content-area-with-sidebar ps-md-2'; } ?>">
            <?php if (isset($_SESSION['user'])): // Only show ranking if user is logged in ?>
            <div class="container-md p-3 rank-page-container">
                <h1 class="text-white text-center">Classement</h1>
                <?php /* if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; */ ?>
                <div class="table-responsive fontsaira">
                    <table class="table table-bordered align-middle text-white table-striped table-hover"> <?php // Added table-bordered ?>
                        <thead class="thead-dark"> <?php // Added thead-dark for styling consistency ?>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($users_for_rank)) {
                                $i = 1;
                                foreach ($users_for_rank as $user_rank_item) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i++; ?></th>
                                    <td>
                                        <a href="/template/showpronoplayer.php?ID=<?php echo $user_rank_item['id'];?>"><?php echo htmlspecialchars($user_rank_item['username']);?></a>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($user_rank_item['score']); ?>
                                    </td>
                                </tr>
                            <?php
                                } // end foreach
                            } else { // if $users_for_rank is empty
                                echo '<tr><td colspan="3" class="text-center">Aucun utilisateur trouvé ou erreur de base de données.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; // End of conditional display for ranking ?>
        </main>

    </div><!-- /.row -->
</div><!-- /.page-wrapper -->
        </main>

    </div><!-- /.row -->
</div><!-- /.page-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>

</html>
 