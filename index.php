<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Start Hero Section
================================================== -->
<section id="hero" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>BDE<br><span class="lighter">Lycée De La Salle</span></h1>
                    <p class="lead">
                        <?php
                        require 'include/connectbdd.php';
                        $requete = "SELECT texte FROM contenu WHERE titre = 'MessageBienvenue'";
                        $req = $bdd->prepare($requete);
                        $req->execute();
                        $row = $req->fetch();
                        echo $row["texte"];
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img src="style/images/logo_bde.png" height="575" width="575">
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Hero -->

<!-- Start Contenu Section
================================================== -->
<section id="contenu" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>News<br></h1>
                    <?php
                    $requete = 'SELECT numNews, titre, texte, date FROM news LIMIT 3';
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    while ($row = $req->fetch()) {
                        echo '<div class="tableauaccueil">';
                        echo '  <div style="float: left;">';
                        echo '      <strong>' . $row['titre'] . '</strong>';
                        echo '  </div>';
                        echo '  <div style="float: right;">';
                        echo '      <strong>' . $row['date'] . '</strong>';
                        echo '  </div><br><hr>';
                        echo    $row['texte'];
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>Agenda<br></h1>
                    <?php
                    $requete = 'SELECT numEvenement, titre, texte, lieu, dateDebut, dateFin FROM evenement LIMIT 3';
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    while ($row = $req->fetch()) {
                        echo '<div class="tableauaccueil">';
                        echo '  <div style="float: left;">';
                        echo '      <strong>' . $row['titre'] . '<br>Lieu : '.$row['lieu'].'</strong>';
                        echo '  </div>';
                        echo '  <div style="float: right;">';
                        echo '      <strong>Du ' . $row['dateDebut'] . '<br>au '.$row['dateFin'].'</strong>';
                        echo '  </div><br><br><hr>';
                        echo    $row['texte'];
                        echo '</div>';
                    }
                    $req->closeCursor();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Contenu -->

<!-- Start Contenu Section
================================================== -->
<section id="idee_sondage" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                Boite à idées ici
            </div>
            <div class="col-md-4">
                Sondage ici
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Contenu -->
<?php include('include/footer.php'); ?>
