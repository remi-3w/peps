<?php include_once(dirname(__FILE__) . '/header.php');
?>


<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-7">
        <div class="card auth-card">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-5">
              <form id="form-login" class="col-12" action="functions/login.php" method="post">
                <p class="text-white mb-5">Connexion</p>
                <div class="form-outline form-white mb-4">
                  <label for="connexion-email" class="form-label form-label-lg">Email</label>
                  <div class="input-group">
                    <span class="input-group-text">@</span>
                    <input type="email" name="email" class="form-control form-control-lg" id="connexion-email" placeholder="email">
                  </div>
                </div>
                <div class="form-outline form-white mb-4">
                  <label for="connexion-password" class="form-label form-label-lg">Password </label>
                  <div class="input-group">
                  <span class="input-group-text"><i class="fa-regular fa-shield-check"></i></span>
                    <input type="password" name="password" class="form-control form-control-lg" id="connexion-password" placeholder=" * * * * * *">
                  </div>
                </div>                
                <button type="submit" class="btn btn-primary btn-md px-4">Valider ✔</button>
              </form>
              <div>
                <p class="linktocreate mt-3">QUOIIII? Pas encore de compte? <a href="subscribe.php" class="fw-bold">Créer</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>