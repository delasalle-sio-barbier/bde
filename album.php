<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Start Section
================================================== -->
    <section class="container galerie">
        <div class="row">
            <h1><center>Albums</center></h1><hr>
        </div>
        <ul class="row">
            <?php
            require 'include/connectbdd.php';
            $requete = 'SELECT numAlbum, titre, dateCreation, imageAlbum FROM album ORDER BY dateCreation DESC';
            $req = $bdd->prepare($requete);
            $req->execute();
            $compteur = 0;
            while ($row = $req->fetch()) {
                echo '<li class="col-lg-2 col-md-2 col-sm-4 col-xs-4 col-xxs-12">';
                echo '  <a href="galerie.php?numAlbum='.$row['numAlbum'].'"><img class="img-responsive" src="style/images/galerie/'.$row["imageAlbum"].'"></a>';
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