<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        {
            echo '<h1>Gestion de la boite à idée</h1>';

            // Select des idées pour le tableau
            require '../include/connectbdd.php';
            $requete = "SELECT * FROM idee";
            $req = $bdd->prepare($requete);
            $req->execute();
            echo '
            <table class="table">
                <tr>
                    <th>Message</th>
                    <th>Hashtag</th>
                    <th>Auteur</th>
                    <th>Classe</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>';
            while ($row = $req->fetch()) {
                echo '
                <tr>
                    <td>'.$row['texte'].'</td>
                    <td>'.$row['hashtag'].'</td>
                    <td>'.$row['auteur'].'</td>
                    <td>'.$row['classe'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>
                        <a href="#" title="Modifier l\'idée" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                        <a href="#" title="Valider l\'idée" style="color:green"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                        <a href="#" title="Supprimer l\'idée" style="color:red"><i class="fa fa-trash"></i></a>
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
    </div><br> <!-- /container -->
<?php include('../include/footer.php'); ?>