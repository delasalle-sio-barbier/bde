<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
<div class="container">
    <?php
    if(isset($_SESSION['numMembre']) && $_SESSION['privilege'] == 'owner') {
        echo '<h1>Suppression des membres</h1><hr>';
        echo "Tous les membres ont bien été supprimés";
        require '../include/connectbdd.php';
        $requete = " DELETE FROM membre ";
        $bdd->exec($requete);
    }
    ?>
</div> <!-- /container -->
<?php include('../include/footer.php'); ?>