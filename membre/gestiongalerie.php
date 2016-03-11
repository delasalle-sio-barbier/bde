<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        {
            // si l'action est une ajout d'album
            if (@$_GET['action'] == 'ajoutalbum') {
                echo '<h1>Création d\'un album</h1><hr>';
            if(!empty($_POST) && isset($_POST['upload'])) { // si formulaire soumis
                require '../include/connectbdd.php';
                $requete = "INSERT INTO album (titre, dateCreation, url) ";
                $requete .= " VALUES (:titre, CURDATE(), :url)";
                $req=$bdd->prepare($requete);
                $req->execute(array('titre'=>$_POST['titre'], 'url'=>$_POST['url']));
                $req->closeCursor();
                echo "L'album a bien été créé !";
            } else { ?>

            <form method="post">
                <div ng-app="module">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="titre"> Titre de l'album : </label>
                            <input class="form-control" type="text" ng-model="titre"  name="titre">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="url"> URL : </label>
                            <input class="form-control" type="text" ng-value="titre | modif | lowercase" name="url">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-large btn-primary" name="upload" type="submit">Envoyer</button>
                        </div>
                    </div>
                </div>
                </form>

                <?php
                }
            }
            // si l'action est une ajout de photo dans un album
            elseif (@$_GET['action'] == 'ajoutphoto') {
                echo '<h1>Ajout de photo dans l\'album : </h1>';
                // a faire
            }

            // si l'action est une liste des photos
            elseif (@$_GET['action'] == 'listephoto') {
                echo '<h1>Liste des photos de l\'album : </h1>';
                        require '../include/connectbdd.php';
        $numPhoto = $_GET["id"];
        $requete = "SELECT * FROM photo WHERE numALbum = '$numPhoto' ORDER BY numPhoto";
        $req = $bdd->prepare($requete);
        $req->execute();
        $compteur = 0;
        while ($row = $req->fetch()) {
            $numPhoto = $row['numPhoto'];
            echo '<li class="col-lg-2 col-md-2 col-sm-4 col-xs-4 col-xxs-12">';
            echo '<img class="img-responsive" src="../style/images/galerie/'.$row["urlPhoto"].'">';
            echo '<div class="text-center" style="margin-top: 5px;"><a href="gestiongalerie.php?action=supprimerphoto&numPhoto='.$numPhoto.'" title="Supprimer la photo" style="color:red"><i class="fa fa-trash"></i></a></div>';

        }
        $req->closeCursor();
            }
            // si l'action est une suppression d'album avec les photos avec
            elseif (@$_GET['action'] == 'supprimeralbum') {
                require '../include/connectbdd.php';
                $requeteAlbum = "DELETE FROM album WHERE numAlbum = " . $_GET['id'] . ";";
                $requetePhoto = "DELETE FROM photo WHERE numAlbum = " . $_GET['id'] . ";";
                $reqPhoto = $bdd->prepare($requetePhoto);
                $reqAlbum = $bdd->prepare($requeteAlbum);

                $reqAlbum->execute();
                $reqPhoto->execute();
                echo '<h1>Suppression d\'un album : </h1><hr>';
                echo "La suppression de l'album avec tous les photos a bien été effectuée !";
                header('refresh:5; url=gestiongalerie.php');
                ob_flush();
                $reqPhoto->closeCursor();
                $reqAlbum->closeCursor();
            }
            // si l'action est une suppression de photo d'un album
            elseif (@$_GET['action'] == 'supprimerphoto') {
                require '../include/connectbdd.php';
                $requetePhoto = "DELETE FROM photo WHERE numPhoto = " . $_GET['numPhoto'] . ";";
                $reqPhoto = $bdd->prepare($requetePhoto);
                $reqPhoto->execute();
                echo '<h1>Suppression d\'une photo : </h1><hr>';
                echo "La suppression de la photo a bien été effectuée !";
                header('refresh:5; url=gestiongalerie.php');
                ob_flush();
                $reqPhoto->closeCursor();
            }
            else {
                echo '<h1>Gestion de la galerie</h1><hr>'; ?>
                <button type="button" class="btn btn-primary"><a href="gestiongalerie.php?action=ajoutalbum" style="color:white;">Créer un nouvel album</a></button><br><br>
                <?php
                // Select des idées pour le tableau
                require '../include/connectbdd.php';
                $requete = "SELECT * FROM album";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '
            <table class="table">
                <tr>
                    <th>Album</th>
                     <th>Nombres de photos</th>
                    <th>Options</th>
                </tr>';
                while ($row = $req->fetch()) {
                    echo '
                <tr>
                    <td>'.$row['titre'].'</td>
                    <td>0 photos</td>

                    <td>'; ?>
                        <a href="gestiongalerie.php?action=ajoutphoto&id=<?php echo $row['numAlbum']; ?>" title="Ajouter des photos" style="color:green"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="gestiongalerie.php?action=listephoto&id=<?php echo $row['numAlbum']; ?>" title="Liste des photos" style="color:blue"><i class="fa fa-list"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="gestiongalerie.php?action=supprimeralbum&id=<?php echo $row['numAlbum']; ?>" title="Supprimer l'album" style="color:red"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php
                }
                echo '</table>';
                $req->closeCursor();
            }

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

<!-- script pour gérer le select de l'album -->
<script>
function change_valeur() {
select = document.getElementById("listealbum");
choice = select.selectedIndex;
urlredirection = 'gestiongalerie.php?numAlbum='+select.options[choice].value;
document.location.href=urlredirection;
}
</script>
