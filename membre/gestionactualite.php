<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>

    <!-- Script TinyMCE -->
    <script>
        tinymce.init({
            selector: "textarea",
            language : "fr_FR",
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>

    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))
        {
            // si l'action est un ajout
            if (@$_GET['action'] == 'ajout') {
                echo '<h1>Création d\'une actualité</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['titre']) && !empty($_POST['url'])) && (isset($_POST['texte']))) {
                        require '../include/connectbdd.php';
                        $requete = "INSERT INTO actualite (titre, texte, date, url, numCategorie) ";
                        $requete .= " VALUES (:titre, :texte, CURDATE(), :url, 1)";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'url' => $_POST['url']));
                        echo "L'actualité a bien été créée !";
                        header('refresh:5; url=gestionactualite.php');
                        ob_flush();
                        $req->closeCursor();
                    }else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionactualite.php?action=ajout');
                        ob_flush();
                    }
                } else { ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="titre"> Titre de l'actualité : </label>
                                <input class="form-control" type="text" placeholder="Titre" name="titre">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="url"> URL : </label>
                                <input class="form-control" type="text" placeholder="Url" name="url">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="texte"> Texte : </label>
                                <textarea class="form-control" rows="10" id="mytextarea" name="texte"></textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-large btn-primary" type="submit">Envoyer</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            }
            // si l'action est une modification
            elseif (@$_GET['action'] == 'modifier') {
                echo '<h1>Modication d\'une actualite</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['titre']) && !empty($_POST['url'])) && (isset($_POST['texte']))) {
                        require '../include/connectbdd.php';

                        $requete = "UPDATE actualite SET titre = :titre, texte = :texte, url = :url WHERE numActualite = ".$_GET['id'].";";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'url' => $_POST['url']));
                        echo "L'actualité a bien été modifiée !";
                        header('refresh:5; url=gestionactualite.php');
                        ob_flush();
                        $req->closeCursor();
                    }else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionactualite.php?action=modifier');
                        ob_flush();
                    }
                } else {
                    require '../include/connectbdd.php';
                    $numActualite = $_GET['id'];
                    $requete = "SELECT * FROM actualite WHERE numActualite = '$numActualite';";
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $donnees = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="titre"> Titre de l'actualité : </label>
                                <input class="form-control" type="text" value="<?php echo $donnees['titre']; ?>" name="titre">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="url"> URL : </label>
                                <input class="form-control" type="text" value="<?php echo $donnees['url']; ?>" name="url">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="texte"> Texte : </label>
                                <textarea class="form-control" rows="5" id="mytextarea" name="texte"><?php echo $donnees['texte'] ?></textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-large btn-primary" type="submit">Modifier</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            }
            // si l'action est une supprésion
            elseif (@$_GET['action'] == 'supprimer') {
                require '../include/connectbdd.php';
                $requete = "DELETE FROM actualite WHERE numActualite = " . $_GET['id'] . ";";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '<h1>Suppression d\'une actualité</h1><hr>';
                echo "La suppression de l'actualité a bien été effectuée !";
                header('refresh:5; url=gestionactualite.php');
                ob_flush();
                $req->closeCursor();
            }
            else {
                echo '<h1>Gestion des actualités</h1><hr>'; ?>
                <button type="button" class="btn btn-warning" value="Paiement" onclick="window.location.href='gestionactualite.php'">Créer une nouvelle actualité</button>
                <?php
                // Select des idées pour le tableau
                require '../include/connectbdd.php';
                $requete = "SELECT * FROM actualite";
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
                                <a href="gestionactualite.php?action=modifier&id='.$row['numActualite'].'" title="Modifier l\'actualite" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                <a href="gestionactualite.php?action=supprimer&id='.$row['numActualite'].'" title="Supprimer l\'actualite" style="color:red"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        ';
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