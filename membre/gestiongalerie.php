<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        { ?>
            <h1>Gestion de la galerie</h1><hr>
            <ul>
                <li><a href="newalbum.php" style="text-decoration : underline;">Créer un nouvel album</a></li>
            </ul>
            <?php require '../include/connectbdd.php';?>
            <br><br><hr>
            <?php
            if(!empty($_POST) && isset($_POST['upload']) && !empty($_GET['numAlbum'])) { // si formulaire soumis
                $content_dir = '../style/images/galerie/'; // dossier où sera déplacé le fichier

                $tmp_file = $_FILES['fichier']['tmp_name'];

                // on vérifie maintenant l'extension
                $type_file = $_FILES['fichier']['type'];

                if( !is_uploaded_file($tmp_file) ) {
                    echo "Le fichier est introuvable";
                } elseif( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') ) {
                    echo "Le fichier n'est pas une image";
                } else {
                    // on copie le fichier dans le dossier de destination
                    $taille_chaine = strlen($_FILES['fichier']['name']);
                    $name_file = substr($_FILES['fichier']['name'], 0, -4).'-'.time().'.'.substr($_FILES['fichier']['type'], -3);

                    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
                    {
                        echo "Impossible de copier le fichier dans $content_dir";
                    } else{
                        echo "L'image a bien été ajoutée";
                        $req = $bdd->prepare('INSERT INTO photo (nomPhoto, urlPhoto, numAlbum) VALUES (:nomPhoto,:urlPhoto,:numAlbum)');
                        $req->execute(array('nomPhoto' => $_POST['nomPhoto'], 'urlPhoto' => $name_file, 'numAlbum' => $_POST['numAlbum']));
                    }
                }
            } elseif (!empty($_GET['numAlbum'])) {  // Si on a sélectionné un album
                $requete = "SELECT titre FROM album WHERE numAlbum = ".$_GET['numAlbum'];
                $req = $bdd->prepare($requete);
                $req->execute();
                $resultat = $req->fetch();
                echo "<h3>Ajouter une nouvelle photo dans l'album ".$resultat['titre']."</h3>"?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <input class="form-control" type="text" placeholder="Nom de la photo (optionnel)" name="nomPhoto">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="file" name="fichier" size="30">
                        </div>
                    </div><br>
                    <input type="hidden" name="numAlbum" value="<?php echo $_GET['numAlbum'] ?>">
                    <div class="row">
                        <button class="btn btn-large btn-primary" name="upload" type="submit">Envoyer</button>
                    </div>
                </form>
            <?php
            } else { // Sinon on affiche la sélection de membre
                echo '
                <h3>Ajouter une nouvelle photo</h3>
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <select id="listealbum" name="membre" onchange="change_valeur()">
                                <option>Album</option>';
                                $requete = "SELECT * FROM album";
                                $req = $bdd->prepare($requete);
                                $req->execute();
                                while ($row = $req->fetch()) {
                                    echo '<option value="'.$row['numAlbum'].'">'.$row['titre'].'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                </form>
                <?php
            }
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

<!-- script pour gérer le select de l'album -->
<script>
function change_valeur() {
select = document.getElementById("listealbum");
choice = select.selectedIndex;
urlredirection = 'gestionGalerie.php?numAlbum='+select.options[choice].value;
document.location.href=urlredirection;
}
</script>
