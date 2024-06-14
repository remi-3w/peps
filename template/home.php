<?php
include(dirname(__FILE__) . '/header.php');
if ($_SESSION)
{
     include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
};

    $sql = 'SELECT * FROM users ORDER BY score DESC limit 3';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    if ($_SESSION) {?>
<div class="container col-8 ">
  <div class="livetoast col-12 z-1" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning">
                    <img src="..." class="rounded me-2" alt="⭐">
                    <strong class="me-auto">Information</strong>
                    <small> J-5 </small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-warning">
                    Choisis l'équipe gagnante et prend un bonus de 300 points
                </div>
        </div>


	        <table id="my-chart" class="charts-css data-spacing-10 column col-12">
                <thead>
                    <tr class="tablehead">
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Points</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    <tr>
                        <th scope="row">2</th>                       
                        <td class ="row graph">
                            <a class="text-white d-flex justify-content-center" href="http://peps/template/showpronoplayer.php"><?php echo $users[1]['username'];?></a> 
                               <span class="medal d-flex justify-content-center">🥈</span>
                               <span class="data d-flex justify-content-center">200 </span>
                        </td>                        
                    </tr>
                    <tr>
                        <th scope="row"> 1 </th>                        
                        <td class="row" style="--size: calc( 80 / 100 );">
                            <a class="text-white d-flex justify-content-center" href="http://peps/template/showpronoplayer.php"><?php echo $users[0]['username']; ?></a>
                            <span class="medal d-flex justify-content-center">🥇</span>
                            <span class="data d-flex justify-content-center"> 400 </span>                              
                        </td>
                        
                    </tr>
                    <tr>
                        <th scope="row"> 3 </th>
                        <td class="row" style="--size: calc( 40 / 100 );">
                            <a class="text-white d-flex justify-content-center" href="http://peps/template/showpronoplayer.php"><?php echo $users[2]['username'];?></a>
                              <span class="medal d-flex justify-content-center">🥉</span>
                              <span class="data d-flex justify-content-center"> 200 </span>
                        </td>                        
                    </tr>
                </tbody>
            </table>                    
        </div>    </div>
  <?php
    } else { ?>
        <div class="m-auto col-10 py-3 row d-flex justify-content-evenly">
            <div class=" col-12 col-lg-6 col-xl-6 col-sm-6">			
                <img class="image-hero d-flex justify-content-center align-items-center col-lg-10 img-fluid" src="../assets/img/FIFA-Womens-World-Cup-2023-Embleme.jpg">
            </div>
            <div class="col-12 col-lg-6 col-xl-6 col-sm-6 hero-text d-flex justify-content-evenly">
                <div class="row d-flex justify-content-center">
                <h2 class="h2 fw-bold fontsaira ">Pari entre potes</h2>
                <p class=" col-lg-12 col-xl-12  text-hero col-xl-5 align-items-center fontsaira"> <b>Aligne</b> les scores de tous les matchs du tournoi et <b>hisses</b> toi à la meilleur place du classement</p>
                <i class=" col-3 far fa-futbol fa-spin fa-3x d-flex justify-content-center align-items-center"></i>  
            </div>
        </div>
        <div class="py-5 col-12 d-flex justify-content-center">
            <div class="col-3 d-flex justify-content-center ">
                <a class="btn btn-outline-warning btn-lg fontSaira subs" href="/template/subscribe.php" role="button">S'inscrire</a>
            </div>
        </div>

    <?php }?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>

</html>
 