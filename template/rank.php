<?php
include('header.php');
// $db should be available from header.php
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
        if (isset($_SESSION['user'])) {
            include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
        }
        ?>

        <main class="col <?php echo isset($_SESSION['user']) ? 'ps-md-2' : ''; ?> pt-2 main-content-area">
            <div class="container-md p-3 rank-page-container">
                <h1 class="text-white text-center">Classement</h1>
                <?php /* if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; */ ?>
                <?php // The div with class "hero-ranking fontsaira" was removed to simplify, apply fontsaira to table or container if needed ?>
                <div class="table-responsive fontsaira"> <?php // Added fontsaira here if it was important ?>
                    <table class="table table-borderless align-middle text-white table-striped table-hover"> <?php // Removed duplicate fontsaira ?>
                        <thead>
                            <tr class="tablehead">
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
        </main>

    </div><!-- /.row -->
</div><!-- /.page-wrapper -->

<?php // No </body> or </html> needed here if header.php opens them and a potential footer closes them. ?>
