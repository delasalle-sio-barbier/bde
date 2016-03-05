<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>

    <!-- Script TinyMCE -->
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 200,
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
                echo '<h1>Création d\'une news</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['titre']) && !empty($_POST['url'])) && (isset($_POST['texte']))) {
                        require '../include/connectbdd.php';
                        $requete = "INSERT INTO news (titre, texte, date, url, numCategorie) ";
                        $requete .= " VALUES (:titre, :texte, CURDATE(), :url, 1)";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'url' => $_POST['url']));
                        echo "La news a bien été créée !";
                        header('refresh:5; url=gestionnews.php');
                        ob_flush();
                        $req->closeCursor();
                    }else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionnews.php?action=ajout');
                        ob_flush();
                    }
                } else { ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="titre"> Titre de la news : </label>
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
                echo '<h1>Modication d\'une news</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['titre']) && !empty($_POST['url'])) && (isset($_POST['texte']))) {
                        require '../include/connectbdd.php';

                        $requete = "UPDATE news SET titre = :titre, texte = :texte, url = :url WHERE numNews = ".$_GET['id'].";";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'url' => $_POST['url']));
                        echo "La news a bien été modifiée !";
                        header('refresh:5; url=gestionnews.php');
                        ob_flush();
                        $req->closeCursor();
                    }else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionnews.php?action=modifier');
                        ob_flush();
                    }
                } else {
                    require '../include/connectbdd.php';
                    $numNews = $_GET['id'];
                    $requete = "SELECT * FROM news WHERE numNews = '$numNews';";
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $donnees = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="titre"> Titre de la news : </label>
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
                $requete = "DELETE FROM news WHERE numNews = " . $_GET['id'] . ";";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '<h1>Suppression d\'une news</h1><hr>';
                echo "La suppression de la news a bien été effectuée !";
                header('refresh:5; url=gestionnews.php');
                ob_flush();
                $req->closeCursor();
            }
            else {
                echo '<h1>Gestion des news</h1><hr>'; ?>
                <button type="button" class="btn btn-warning" value="Paiement" onclick="window.location.href='gestionnews.php?action=ajout'">Créer une nouvelle news</button>
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
                                <a href="gestionnews.php?action=modifier&id='.$row['numNews'].'" title="Modifier la news" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                <a href="gestionnews.php?action=supprimer&id='.$row['numNews'].'" title="Supprimer la news" style="color:red"><i class="fa fa-trash"></i></a>
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