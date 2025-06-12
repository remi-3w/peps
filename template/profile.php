<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include_once('../template/functions/lateralNavbar.php');

$sql = 'SELECT * FROM users ORDER BY score DESC;';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-md p-3 profile-list-page">
    <div class="row justify-content-center">
        <?php foreach($users as $user): 
            $picture = $user['picture'];
            $username = $user['username'];
            $avatar_path = '../assets/img/fixture.png';
            if ($picture !== 'fixture' && !empty($picture)) {
                $avatar_path = '../assets/img/userfile/' . rawurlencode($username) . '/' . rawurlencode($picture);
            }

            // Compter les pronostics
            $predictions_count_stmt = $db->prepare("SELECT COUNT(*) as count FROM matchs_users WHERE user_id = :user_id");
            $predictions_count_stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
            $predictions_count_stmt->execute();
            $predictions_count = $predictions_count_stmt->fetch(PDO::FETCH_ASSOC)['count'];
        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
            <div class="card profile-card text-white w-100">
                <div class="position-relative text-center pt-3">
                    <img class="card-img-top img-fluid rounded-circle mx-auto d-block mb-2" 
                         src="<?php echo htmlspecialchars($avatar_path); ?>" 
                         alt="Avatar de <?php echo htmlspecialchars($username); ?>" 
                         style="width: 100px; height: 100px; object-fit: cover;">

                    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user['id']): ?>
                        <button type="button" class="btn btn-sm btn-dark edit-avatar-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modal-avatar-<?php echo $user['id']; ?>" 
                                style="position: absolute; top: 5px; right: 5px;">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    <?php endif; ?>
                </div>

                 <div class="card-body text-center">
                    <h5 class="card-title mb-1 fs-6"><?php echo htmlspecialchars($username); ?></h5>
                    <p class="mb-1 fs-6">Score : <strong><?php echo $user['score']; ?></strong></p>
                    <p class="mb-0 fs-6"><strong><?php echo $predictions_count; ?></strong> pronostic(s)</p>
                </div>
                <?php if (isset($_SESSION["flash"]) && $_SESSION['user']['id'] == $user['id']): ?>
                    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                        <div class="alert alert-<?php echo $type; ?> mx-3 my-2 fs-7">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $message; ?>
                        </div>
                    <?php endforeach; unset($_SESSION['flash']); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal pour changer la photo -->
        <div class="modal fade" id="modal-avatar-<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $user['id']; ?>" aria-hidden="true">
          <div class="modal-dialog">
            <form class="modal-content" enctype="multipart/form-data" action="/template/functions/importAvatar.php" method="post">
              <div class="modal-header">
                <h5 class="modal-title text-dark" id="modalLabel-<?php echo $user['id']; ?>">Modifier votre photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                  <div class="mb-3">
                      <label for="formFile-<?php echo $user['id']; ?>" class="form-label text-dark">Choisissez une nouvelle image :</label>
                      <input class="form-control" name="userfile" type="file" id="formFile-<?php echo $user['id']; ?>">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
              </div>
            </form>
          </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>
