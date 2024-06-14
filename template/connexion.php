<?php include_once(dirname(__FILE__) . '/header.php');
?>


<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-7">
        <div class="card hero-subscribing text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-5">
              <form id="formuser" class="col-12 row" action="functions/login.php" method="post">
                <p class="text-white-50 mb-5">Connexion</p>
                <div class="form-outline form-white mb-4">
                  <label for="colFormLabelLg" class="col-4 col-sm-4  col-form-label col-form-label-lg">Email</label>
                  <div class="input-group mb-3 ">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" name="email" class="form-control" id="colFormLabelLg" placeholder="email">
                  </div>
                </div>
                <div class="form-outline form-white mb-4">
                  <label for="colFormLabelLg" class="col-8 col-sm-8 form-label col-form-label-lg">Password </label>
                  <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-shield-check">@*</i></span>
                    <input type="password" name="password" class=" form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=" * * * * * *">
                  </div>
                </div>                
                <button type="submit" class="btn btn-outline-light btn-lg px-5">Valider ✔</button>
              </form>
              <div>
                <p id="linktocreate" class=" linktocreate mt-3">Pas encore de compte? <a href="subscribe.php" class="text-white-50 fw-bold">Créer</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>