<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include_once('../template/functions/lateralNavbar.php');

$sql = 'SELECT * FROM users ORDER BY score DESC;';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$timestampnow; // date du jour en timestamps



 
?>
<div class="container-md p-3 profile-list-page">
    <div class="row">
    <?php
    foreach($users as $user){
        $picture = $user['picture'];
        $loop_user_username = $user['username']; // Use this for alt text and path
        $avatar_path = '../assets/img/fixture.png'; // Default path
        if ($picture !== 'fixture' && !empty($picture)) {
            // Assuming $loop_user_username is the correct directory name component
            $avatar_path = '../assets/img/userfile/' . rawurlencode($loop_user_username) . '/' . rawurlencode($picture);
        }

        // Fetch predictions count for the current user
        $predictions_count_stmt = $db->prepare("SELECT COUNT(*) as count FROM matchs_users WHERE user_id = :user_id");
        $predictions_count_stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
        $predictions_count_stmt->execute();
        $predictions_count = $predictions_count_stmt->fetch(PDO::FETCH_ASSOC)['count'];

        // $firstname variable is fine, or just use $loop_user_username or $user['username'] directly
        $firstname = $loop_user_username;
    ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card profile-card text-white">
                <div class="position-relative"> <!-- This div is for positioning the edit button if needed, or can be merged with card-img-top's parent -->
                    <img class="card-img-top img-fluid rounded-circle mx-auto d-block mb-2 mt-3" src="<?php echo htmlspecialchars($avatar_path); ?>" alt="<?php echo htmlspecialchars($loop_user_username); ?> Avatar" style="width: 100px; height: 100px; object-fit: cover;">
                    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user['id']): ?>
                        <button type="button" class="btn btn-dark edit-avatar-btn" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $user['id']; ?>" style="position: absolute; top: 5px; right: 5px; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal-<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $user['id']; ?>" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title text-dark fs-5" id="exampleModalLabel-<?php echo $user['id']; ?>">Nouvelle photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                      <form enctype="multipart/form-data" action="/template/functions/importAvatar.php" method="post">
                        <div class="mb-3">
                            <label for="formFile-<?php echo $user['id']; ?>" class="text-dark form-label">Importer une image.</label>
                            <input class="form-control" name="userfile" type="file" id="formFile-<?php echo $user['id']; ?>">
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                      </div>
                    </form> <!-- Closing form tag for modal -->
                    </div>
                  </div>
                </div>
                <?php
                // Flash messages - consider moving outside the card if they are general, or style appropriately if inside
                if (isset($_SESSION["flash"]) && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user['id'] ) { // Show flash only on relevant user's card
                    foreach ($_SESSION['flash'] as $type => $message) : ?>
                        <div id="alert-<?php echo $user['id']; ?>" class="alert alert-<?php echo $type; ?> infoMessage mx-2">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?php echo $message; ?>
                        </div>
                <?php
                    endforeach;
                    unset($_SESSION['flash']); // Unset flash after displaying
                }
                ?>
                <div class="card-body profile-card-body-custom text-center"> <!-- Added text-center -->
                    <h2 class="card-title h5"><?php echo htmlspecialchars($firstname); ?></h2> <!-- Changed h2 to h5 for card context -->
                    <p class="card-text">Score: <strong><?php echo htmlspecialchars($user['score']); ?></strong></p>
                    <p class="card-text"><strong><?php echo $predictions_count; ?></strong> pronostic(s) enregistré(s)</p>
                    <!-- Commented out for now:
                    <p class="card-text"><strong>X</strong> score parfait</p>
                    <p class="card-text">#Y au classement général</p>
                    -->
                </div>
            </div>
        </div>
    <?php };?>
    </div> <!-- Close .row -->
</div>