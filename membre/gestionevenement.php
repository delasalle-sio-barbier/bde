<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        {
            echo '<h1>Gestion des évenements</h1><hr>';?>
            <a href="newevenement.php" style="text-decoration : underline;">Créer un nouvel évenement</a>
            <?php
        }
        else
        {
            ?>
            <div class="panel panel-danger">
                <div class="panel-heading">Erreur : Vous n'avez pas l'accès à cette page. Vous n'êtes pas admin ou vous n'êtes pas connectés !</div>
            </div>
            <?php
        }
        ?>
    </div> <!-- /container -->
    <br>
<?php include('../include/footer.php'); ?>