<?php include_once(dirname(__FILE__) . '/header.php');
?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-7">
                <div class="card auth-card">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <form id="form-subscribe" class="col-12" action="functions/registerUser.php" method="post">
                                <p class="text-white mb-5">Création compte</p>
                                <div class="form-outline form-white mb-4">
                                    <label for="subscribe-username" class="form-label form-label-lg">Nom</label>
                                    <div class="">
                                        <input type="name" name="username" class="form-control form-control-lg" id="subscribe-username" placeholder="ex : Bruno">
                                    </div>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="subscribe-email" class="form-label form-label-lg">Email</label>
                                    <div class="">
                                        <input type="email" name="email" class="form-control form-control-lg" id="subscribe-email" placeholder=" ex: bruno@peps.com">
                                    </div>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="subscribe-password" class="form-label form-label-lg">Password </label>
                                    <div class="">
                                        <input type="password" name="password" class="form-control form-control-lg" id="subscribe-password" placeholder=" * * * * * *">
                                    </div>
                                </div>                               
                                <button type="submit" class="btn btn-primary btn-md px-4">Valider</button>
                            </form>
                            <div>
                                <p class="linktocreate mt-3">Déja un compte? <a href="connexion.php" class="fw-bold">Connectes-toi</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>