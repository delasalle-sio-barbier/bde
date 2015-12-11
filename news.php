<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<br><br><br>
<!-- Start Section
================================================== -->
<section id="contenu" class="section">
    <div class="container">
        <div class="row">
            <div class="lp-element">
                <h1>News<br></h1>
                <?php
                require 'include/connectbdd.php';
                $requete = 'SELECT numNews, titre, texte, date FROM news ORDER BY date DESC';
                $req = $bdd->prepare($requete);
                $req->execute();
                while ($row = $req->fetch()) {
                    echo '<div class="tableauaccueil">';
                    echo '  <div style="float: left;">';
                    echo '      <strong>' . $row['titre'] . '</strong>';
                    echo '  </div>';
                    echo '  <div style="float: right;">';
                    echo '      <strong>' . Outils::date_fr(strtotime($row['date']), 'l j F Y') . '</strong>';
                    echo '  </div><br><hr>';
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
