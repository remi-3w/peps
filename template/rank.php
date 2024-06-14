<?php
include('header.php');
include_once(dirname(__FILE__) . '/functions/lateralNavbar.php');

$sql = 'SELECT * FROM users ORDER BY score DESC ';
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchall();
?>
<div class="container mx-auto p-1 col-12 col-xl-9 ">
<h1 class ="text-white">Classement</h1>
    <div class="hero-ranking fontsaira">
        <table class="table table-borderless align-middle">
            <thead>
                <tr class="tablehead">
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($users as $user) {
                    $userid = $user['id'];
                    $username = $user["username"]
                ?>
                    <tr>
                        <th scope="row"><?php echo $i++; ?></th>
                        <td>
                            <a href="/template/showpronoplayer.php?ID= <?php echo $userid;?>"><?php echo $username;?></a>
                        </td>
                        <td>
                            <?php echo $user["score"]; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>