<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        {
            echo '<h1>Gestion des news</h1><hr>'; ?>
            <button type="button" class="btn btn-warning" value="Paiement" onclick="window.location.href='newnews.php'">Créer une nouvelle news</button>
            <?php
            // Select des idées pour le tableau
            require '../include/connectbdd.php';
            $requete = "SELECT * FROM news";
            $req = $bdd->prepare($requete);
            $req->execute();
            echo '<br>
            <table class="table"><br>
                <tr>
                    <th>Titre</th>
                    <th>Texte</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>';
            while ($row = $req->fetch()) {
                echo '
                <tr>
                    <td>'.$row['titre'].'</td>
                    <td>'.substr($row['texte'],0,50).'...</td>
                    <td>'.$row['date'].'</td>
                    <td>
                        <a href="#" title="Modifier la news" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                        <a href="#" title="Supprimer la news" style="color:red"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                ';
            }
            echo '</table>';
            $req->closeCursor();
        }
        else
        {
            ?>
            <div class="panel panel-danger">
                <div class="panel-heading">Erreur : Vous n'avez pas l'accès à cette page. Vous n'êtes pas admin ou vous n'êtes pas connectés !</div>
            </div>
            <?php
        }
        ?>
    </div> <!-- /container -->
<?php include('../include/footer.php'); ?>