<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include_once('../template/functions/lateralNavbar.php');

$sql = 'SELECT * FROM users ASC;';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$timestampnow; // date du jour en timestamps



 
?>
<div class="row container mx-auto p-1 col-8 col-xl-9 ">
    <?php
foreach($users as $user){
    $picture = $user['picture'];     
    
    // die();
    $firstname = $user['username'];
    //$avatar = $user['avatar'];
    if(($picture) !== "fixture"){
      $avatar = "../assets/img/userfile/". $_SESSION['user']['pseudo'] ."/" . $picture; // $filename = la donnée en BDD
      
    }else{
      $avatar = "../assets/img/fixture.png" ;
           
    }




?>

<div class="d-flex col-6 card p-2 m-4 text-white" style="width: 20rem;">
  <div class="position-relative">
    <img class="card-img-top" src="<?php echo $avatar?> " alt="Card image cap">
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="position-relative text-white top-0 end-0 translate-middle bi bi-pencil-fill">Edit avatar </i>
    </button>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title text-dark fs-5" id="exampleModalLabel">Nouvelle photo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form enctype="multipart/form-data" action="/template/functions/importAvatar.php" method="post">
        <div class="mb-3">
            <label for="formFile " class="text-dark form-label">Importer une image.</label>
            <input class="form-control" name = "userfile" type="file" id="formFile">
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php     
        if (isset($_SESSION["flash"])) {
            foreach ($_SESSION['flash'] as $type => $message) : ?>              
                <div id="alert" class="alert alert-<?= $type; ?> infoMessage">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= $message; ?>
                </div>
        <?php
            endforeach;
            unset($_SESSION['flash']);
        }
        ?>
  </div>
  <div class="profile-card-body p-0">
    <h2 class="card-title"> <?php echo $firstname ?> </h2>
      <p class="card-text"><bold>12</bold> pronostique enregistré</p>
      <p class="card-text"> <bold>6</bold> score parfait</p>
      <p class="card-text"> #6 au classement général  </p>
    
  </div>
</div>

<?php };?></div>