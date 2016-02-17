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
                $requete = 'SELECT numEvenement, titre, texte, lieu, dateDebut, dateFin FROM evenement ORDER BY numEvenement DESC';
                $req = $bdd->prepare($requete);
                $req->execute();
                while ($row = $req->fetch()) {
                    echo '<div class="tableauaccueil">';
                    echo '  <div style="float: left;">';
                    echo '      <strong>' . $row['titre'] . '<br>Lieu : '.$row['lieu'].'</strong>';
                    echo '  </div>';
                    echo '  <div style="float: right;">';
                    echo '      <strong>Du ' . Outils::date_fr(strtotime($row['dateDebut'])) . '<br>au '.Outils::date_fr(strtotime($row['dateFin'])).'</strong>';
                    echo '  </div><br><br><hr>';
                    echo    $row['texte'];
                    echo '</div>';
                }
                $req->closeCursor();
                ?>
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Section -->
<?php include('include/footer.php'); ?>