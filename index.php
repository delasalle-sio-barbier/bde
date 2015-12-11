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
                        $req->closeCursor();
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
                <h1>News<br></h1>
                <div class="tableaunewsaccueil">
                    <div style="float: left;">
                        <strong>Titre</strong>
                    </div>
                    <div style="float: right;">
                        <strong>Date de la news</strong>
                    </div>
                    <br><hr>
                    Texte
                </div>
                <div class="tableaunewsaccueil">
                    <div style="float: left;">
                        <strong>Titre</strong>
                    </div>
                    <div style="float: right;">
                        <strong>Date de la news</strong>
                    </div>
                    <br><hr>
                    Texte
                </div>
                <div class="tableaunewsaccueil">
                    <div style="float: left;">
                        <strong>Titre</strong>
                    </div>
                    <div style="float: right;">
                        <strong>Date de la news</strong>
                    </div>
                    <br><hr>
                    Texte
                </div>
            </div>
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>Agenda<br></h1>
                    <div class="tableaunewsaccueil">
                        <div style="float: left;">
                            <strong>Titre</strong>
                        </div>
                        <div style="float: right;">
                            <strong>Date de la news</strong>
                        </div>
                        <br><hr>
                        Texte
                    </div>
                    <div class="tableaunewsaccueil">
                        <div style="float: left;">
                            <strong>Titre</strong>
                        </div>
                        <div style="float: right;">
                            <strong>Date de la news</strong>
                        </div>
                        <br><hr>
                        Texte
                    </div>
                    <div class="tableaunewsaccueil">
                        <div style="float: left;">
                            <strong>Titre</strong>
                        </div>
                        <div style="float: right;">
                            <strong>Date de la news</strong>
                        </div>
                        <br><hr>
                        Texte
                    </div>
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
