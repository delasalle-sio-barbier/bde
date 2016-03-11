<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Start Section
================================================== -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="lp-element">
                <h1>Evenements<br></h1>
                <?php
                require 'include/connectbdd.php';
                if (!empty($_GET['url'])) {
                    $requete = 'SELECT * FROM evenement WHERE url = '.$_GET['url'];
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $resultat = $req->fetch();
                    echo '<div class="tableauaccueil">';
                    echo '  <div style="float: left;">';
                    echo '      <strong>' . $resultat['titre'] . '<br>Lieu : ' . $resultat['lieu'] . '</strong>';
                    echo '  </div>';
                    echo '  <div style="float: right;">';
                    echo '      <strong>Du ' . Outils::date_fr(strtotime($resultat['dateDebut'])) . '<br>au ' . Outils::date_fr(strtotime($resultat['dateFin'])) . '</strong>';
                    echo '  </div><br><br><hr>';
                    echo $resultat['texte'];
                    echo '</div>';
                }else {
                    require 'include/connectbdd.php';
                    $requete = 'SELECT numEvenement, titre, texte, lieu, dateDebut, dateFin, url FROM evenement ORDER BY numEvenement DESC';
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    while ($row = $req->fetch()) {
                        echo '<div class="tableauaccueil">';
                        echo '  <div style="float: left;">';
                        echo '      <strong><a href="agenda/' .$row['url'].'/">' . $row['titre'] . '</a></strong>';
                        echo '      <br>Lieu : ' . $row['lieu'] . '</strong>';
                        echo '  </div>';
                        echo '  <div style="float: right;">';
                        echo '      <strong>Du ' . Outils::date_fr(strtotime($row['dateDebut'])) . '<br>au ' . Outils::date_fr(strtotime($row['dateFin'])) . '</strong>';
                        echo '  </div><br><br><hr>';
                        $chaine = $row['texte'];
                        $len = 200;

                        if (strlen($chaine) >= $len) {
                            echo $chaine = substr($chaine, 0, $len) . "...";
                            echo '<p style="text-align: right;"><a href="evenement.php?numEvenement=' . $row['numEvenement'] . '">En savoir plus ››</a></p>';
                        } else {
                            echo $row['texte'];
                        }
                        echo '</div>';
                    }
                }
                $req->closeCursor();
                ?>
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Section -->
<br>
<?php include('include/footer.php'); ?>