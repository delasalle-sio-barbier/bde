<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Start Section
================================================== -->
    <section class="container galerie">
        <div class="row">
            <h1>Albums</h1><hr>
        </div>
        <ul class="row">
            <?php
            require 'include/connectbdd.php';
            // SELECT D'UNE IMAGE POUR L'ALBUM
            $requete = 'SELECT urlPhoto FROM photo GROUP BY numAlbum;';
            $req = $bdd->prepare($requete);
            $req->execute();
            $tab_img = array();
            while ($row = $req->fetch()) {
                array_push($tab_img, $row['urlPhoto']);
            }

            // SELECT DE TOUTES LES INFOS DE L'ALBUM
            $requete = 'SELECT numAlbum, titre, dateCreation, url FROM album ORDER BY numAlbum ASC';
            $req = $bdd->prepare($requete);
            $req->execute();
            $compteur = 0;
            while ($row = $req->fetch()) {
                echo '<li class="col-lg-2 col-md-2 col-sm-4 col-xs-4 col-xxs-12">';
                if(empty($tab_img[$compteur])) {
                    echo '  <a href="galerie/'.$row['url'].'/"><img class="img-responsive" src="style/images/galerie/image_vide.png"></a>';
                } else{
                    echo '  <a href="galerie/'.$row['url'].'/"><img class="img-responsive" src="style/images/galerie/'.$tab_img[$compteur].'"></a>';
                }
                echo '  <div class="text">'.$row["titre"].'</div>';
                echo '</li>';
                $compteur += 1;
                if ($compteur % 6 == 0) {
                    echo '<li class="clearfix visible-lg  visible-md"></li><br class="visible-lg visible-md">';
                } elseif ($compteur % 3 == 0) {
                    echo '<li class="clearfix visible-xs visible-sm"></li><br class="visible-xs visible-sm">';
                }
            }
            $req->closeCursor();
            ?>
        </ul>
    </section> <!-- /container -->
<!-- ==================================================
End Section -->
<?php include('include/footer.php'); ?>