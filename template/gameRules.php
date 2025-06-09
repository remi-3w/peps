<?php
include('header.php');
include('../template/functions/DateToFrench.php');
include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');
?>

<div class="lateralnav mx-auto col-9 col-xl-9 my-0 p-xl-5 p-4 col border-peps hero fontsaira d-flex col-xl-8 row ">
    <h3>Bienvenue sur Pep's !</h3>
    <p>Pep’s est votre plateforme pour pronostiquer les scores des matchs de la coupe du monde 2022. Affrontez les autres participants et montrez vos talents de pronostiqueur !</p>
    <h4>Principes clés :</h4>
    <ul>
        <li><strong>Gratuit et sans influence :</strong> Contrairement à de nombreuses plateformes, Pep's est gratuit et n'affiche pas de côtes pour ne pas influencer vos choix.</li>
        <li><strong>Simplicité :</strong> Nous affichons le strict minimum pour une expérience de jeu claire et directe.</li>
        <li><strong>Convivialité :</strong> Parfait pour jouer entre amis !</li>
    </ul>
    <h3>Comment est-ce que je gagne ?</h3>
        <p>Pour gagner, proposez le plus possible de bons résultats aux matchs. Chaque bon résultat vous permet d’accumuler des points.</p>
    <h3>Quand est-ce que le jeu se termine ?</h3>
        <p>Le jeu se termine à la fin de la coupe du monde 2022. Le gagnant est celui qui aura accumulé le plus de points.</p>
    <h3>Que faire à chaque tour de jeu ?</h3>
       <p> À tout moment, vous pouvez renseigner ou modifier le score d’un match à venir.</br>
        <span class="text-danger">Attention : Il n’est plus possible de modifier un score le jour J du match.</span></p>
    <h3>Règles d'attribution des points</h3>
    <p>Accumulez des points en fonction de la précision de vos pronostics :</p>
    <div class="col-12 col-xl-7 mx-auto">
        <table class="table table-striped align-middle">
            <caption>Barème des Points</caption>
            <thead class="text-center">
                <tr>
                    <th scope="col">SCORE EXACT</th>
                    <th scope="col">NOMBRE DE BUT DANS LA RENCONTRE</th>
                    <th scope="col">EQUIPE GAGNANT</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td scope="col">50 points</td>
                    <td scope="col">30 points</td>
                    <td scope="col">20 points</td>
                </tr>
            </tbody>
        </table>
    </div> <!-- This closes div class="col-12 col-xl-7 mx-auto" -->

    <div class="text-center mt-5 mb-3">
        <a href="play.php" class="btn btn-primary btn-lg">Jouer Maintenant !</a>
    </div>

</div> <!-- This closes div class="lateralnav mx-auto col-9 col-xl-9 my-0 p-xl-5 p-4 col border-peps hero fontsaira d-flex col-xl-8 row " -->