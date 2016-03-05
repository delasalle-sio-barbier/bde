<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<style>
    body {
        background-color:#fed84f;!important;
    }
</style>
<!-- Start Hero Section
================================================== -->
<section id="hero" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <img class="img-responsive" src="style/images/logo_bde.png">
            </div>
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>Bureau Des Etudiants<br><span class="lighter">Lycée De La Salle</span></h1>
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
        </div>
    </div>
</section>


<!-- ==================================================
End Hero -->

<!-- Start Contenu Section
================================================== -->
<svg id="curveDownColor" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
    <path d="M0 0 C 50 100 80 100 100 0 Z" />
</svg>
<section id="contenuaccueil" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>News<br></h1>
                    <?php
                    $requete = 'SELECT numNews, titre, texte, date FROM news ORDER BY date DESC LIMIT 3';
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
                        $chaine = $row['texte'];
                        $len = 250;

                        if (strlen($chaine) >= $len) {
                            echo $chaine = substr($chaine,0,$len) . "..." ;
                            echo '<p style="text-align: right;"><a href="news.php?numNews='.$row['numNews'].'">En savoir plus ››</a></p>';
                        } else {
                            echo $row['texte'];
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="lp-element">
                    <h1>Événements<br></h1>
                    <?php
                    $requete = 'SELECT numEvenement, titre, texte, lieu, dateDebut, dateFin FROM evenement ORDER BY numEvenement DESC LIMIT 3';
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    while ($row = $req->fetch()) {
                        echo '<div class="tableauaccueil">';
                        echo '  <div style="float: left;">';
                        echo '      <strong>' . $row['titre'] . '<br>Lieu : '.$row['lieu'].'</strong>';
                        echo '  </div>';
                        echo '  <div style="float: right;">';
                        echo '      <strong>Du ' . Outils::convertirEnDateFR(strtotime($row['dateDebut'])) . '<br>au '.Outils::convertirEnDateFR(strtotime($row['dateFin'])).'</strong>';
                        echo '  </div><br><br><hr>';
                        $chaine = $row['texte'];
                        $len = 200;

                        if (strlen($chaine) >= $len) {
                            echo $chaine = substr($chaine,0,$len) . "..." ;
                            echo '<p style="text-align: right;"><a href="evenement.php?numEvenement='.$row['numEvenement'].'">En savoir plus ››</a></p>';
                        } else {
                            echo $row['texte'];
                        }
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
<svg id="clouds" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
    <path d="M-5 100 Q 0 20 5 100 Z
         M0 100 Q 5 0 10 100
         M5 100 Q 10 30 15 100
         M10 100 Q 15 10 20 100
         M15 100 Q 20 30 25 100
         M20 100 Q 25 -10 30 100
         M25 100 Q 30 10 35 100
         M30 100 Q 35 30 40 100
         M35 100 Q 40 10 45 100
         M40 100 Q 45 50 50 100
         M45 100 Q 50 20 55 100
         M50 100 Q 55 40 60 100
         M55 100 Q 60 60 65 100
         M60 100 Q 65 50 70 100
         M65 100 Q 70 20 75 100
         M70 100 Q 75 45 80 100
         M75 100 Q 80 30 85 100
         M80 100 Q 85 20 90 100
         M85 100 Q 90 50 95 100
         M90 100 Q 95 25 100 100
         M95 100 Q 100 15 105 100 Z"></path>
</svg>
<section id="idee" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Boite à idées<br></h1>
                <div id="carousel-example" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <div class="carousel-inner row text-center">
                                <?php
                                $requete = 'SELECT * FROM idee WHERE statut = 1';
                                $req = $bdd->prepare($requete);
                                $req->execute();
                                $compteur = 0;
                                while ($row = $req->fetch()) {
                                    if ($compteur == 0)
                                        echo '<div class="item active">';
                                    else
                                        echo '<div class="item">';
                                    echo '  <div class="carousel-content">';
                                    echo '      <div>';
                                    echo "          <p>".$row['texte']."<br>";
                                    echo "          <b>".$row['hashtag']."</b></p><p>".$row['auteur']." - ".$row['classe']."</p>";
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                    $compteur++;
                                }
                                $req->closeCursor();
                                ?>
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
