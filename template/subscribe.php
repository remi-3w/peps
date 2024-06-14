<?php include_once(dirname(__FILE__) . '/header.php');
?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-7">
                <div class="card hero-subscribing text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <form id="formuser" class="col-12 row" action="functions/registerUser.php" method="post">
                                <p class="text-white-50 mb-5">Création compte</p>
                                <div class="form-outline form-white mb-4">
                                    <label for="colFormLabelLg" class="col-4 col-sm-4  col-form-label col-form-label-lg">Nom</label>
                                    <div class="">
                                        <input type="name" name="username" class="form-control form-control-lg " id="colFormLabelLg" placeholder="ex : Bruno">
                                    </div>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="colFormLabelLg" class="col-4 col-sm-4  col-form-label col-form-label-lg">Email</label>
                                    <div class="">
                                        <input type="email" name="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder=" ex: Bruno@peps.com">
                                    </div>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="colFormLabelLg" class="col-8 col-sm-8 form-label col-form-label-lg">Password </label>
                                    <div class="">
                                        <input type="password" name="password" class=" form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=" * * * * * *">
                                    </div>
                                </div>                               
                                <button type="submit" class="btn btn-outline-light btn-lg px-5">Valider</button>
                            </form>
                            <div>
                                <p id="linktocreate" class="linktocreate mt-3">Déja un compte? <a href="connexion.php" class="text-white-50 fw-bold">Connectes-toi</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>