<?php include('header.php');
?>
<div class="cont">
    <h1 class="text-white">Inscription</h1>
    <div class=" m-auto hero-subscribing border-peps fontsaira mt-5">
        <form id="formuser" class="cont form-group row" action="functions/enregistrerUser.php" method="post">
            <div class="form-group row m-3">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nom</label>
                <div class="col-sm-10">
                    <input type="name" name="username" class="form-control form-control-lg " id="colFormLabelLg" placeholder="ex : Bruno">
                </div>
            </div>
            <div class=" form-group row m-3">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder=" ex: Bruno@peps.com">
                </div>
            </div>
            <div class="form-group row m-3 ">
                <label for="colFormLabelLg" class="col-sm-2 form-label col-form-label-lg">Password </label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=" * * * * * *">
                </div>
            </div>
            <button type="submit" class="btn btn-validate justify-content-center fontSaira ">Valider</button>
        </form>
    </div>
</div>