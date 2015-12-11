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
                        echo '      <strong>' . Outils::convertirEnDateFR(strtotime($row['date'])) . '</strong>';
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
                        echo '      <strong>Du ' . Outils::convertirEnDateHeureFR(strtotime($row['dateDebut'])) . '<br>au '.Outils::convertirEnDateHeureFR(strtotime($row['dateFin'])).'</strong>';
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
                <h1>Boite à idées<br></h1>
                <div id="carousel-example" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="carousel-content">
                                        <div>
                                            <h3>Titre1</h3>
                                            <p>Boite à idée1</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="carousel-content">
                                        <div>
                                            <h3>Titre2</h3>
                                            <p>Boite à idée2</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="carousel-content">
                                        <div>
                                            <h3>Titre3</h3>
                                            <p>Boite à idée3</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Controls --> <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                Sondage ici
            </div>
        </div>
    </div>
</section>
<!-- ==================================================
End Contenu -->

<!-- ==================================================
Script du Slider de boite à idées -->
<script>
    setCarouselHeight('#carousel-example');

    function setCarouselHeight(id)
    {
        var slideHeight = [];
        $(id+' .item').each(function()
        {
            // add all slide heights to an array
            slideHeight.push($(this).height());
        });

        // find the tallest item
        max = Math.max.apply(null, slideHeight);

        // set the slide's height
        $(id+' .carousel-content').each(function()
        {
            $(this).css('height',max+'px');
        });
    }
</script>

<?php include('include/footer.php'); ?>
