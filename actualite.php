<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Start Section
================================================== -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="lp-element">
                <h1>Actualités<br></h1>
                <?php
                require 'include/connectbdd.php';
                if (!empty($_GET['url'])) {
                    $url = $_GET['url'];
                    $requete = "SELECT numActualite, titre, texte, date, url FROM actualite WHERE url = '$url';";
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $resultat = $req->fetch();
                    echo '<div class="tableauaccueil">';
                    echo '  <div style="float: left;">';
                    echo '      <strong>' . $resultat['titre'] . '</strong>';
                    echo '  </div><br><hr>';
                    echo $resultat['texte'];
                    echo '<br><div style="text-align: right;">';
                    echo '<strong>Publiée le ' . Outils::convertirEnDateFR(strtotime($resultat['date'])) . ' par l\'équipe du BDE</strong><br>';
                    echo '</div>';
                    echo '</div>';
                }else{
                    $requete = 'SELECT numActualite, titre, texte, date, url FROM actualite ORDER BY date DESC';
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    while ($row = $req->fetch()) {
                        echo '<div class="tableauaccueil">';
                        echo '  <div style="float: left;">';
                        echo '      <strong><a href="article/' .$row['url'].'/">' . $row['titre'] . '</a></strong>';
                        echo '  </div>';
                        echo '  <div style="float: right;">';
                        echo '      <strong>' . Outils::date_fr(strtotime($row['date']), 'l j F Y') . '</strong>';
                        echo '  </div><br><hr>';
                        $chaine = $row['texte'];
                        $len = 200;
                        echo $chaine = substr($chaine,0,$len) . "..." ;
                        echo '<p style="text-align: right;"><a href="article/' .$row['url'].'/">En savoir plus ››</a></p>';
                        echo '</div>';
                    }
                }
                $req->closeCursor();
                ?>
            </div>
        </div>
    </div><br>
</section>
<!-- ==================================================
End Section -->
<br>
<?php include('include/footer.php'); ?>
