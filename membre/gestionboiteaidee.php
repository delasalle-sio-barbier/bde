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
                header('refresh:0; url=index.php');
                ob_flush();
            }
            // si l'action est une modification
            elseif (@$_GET['action'] == 'modifier') {
                echo '<h1>Modication d\'une idée</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['texte']) && !empty($_POST['hashtag'])) && (isset($_POST['classe']))) {
                        require '../include/connectbdd.php';

                        $requete = "UPDATE idee SET texte = :texte, hashtag = :hashtag, classe = :classe WHERE numIdee = ".$_GET['id'].";";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('texte' => $_POST['texte'], 'hashtag' => $_POST['hashtag'], 'classe' => $_POST['classe']));
                        echo "L'idée a bien été modifiée !";
                        header('refresh:5; url=gestionboiteaidee.php');
                        ob_flush();
                        $req->closeCursor();
                    }else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionboiteaidee.php?action=modifier');
                        ob_flush();
                    }
                } else {
                    require '../include/connectbdd.php';
                    $numIdee = $_GET['id'];
                    $requete = "SELECT * FROM idee WHERE numIdee = '$numIdee';";
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $donnees = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="texte"> Texte : </label>
                                <input class="form-control" type="text" value="<?php echo $donnees['texte']; ?>" name="texte">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="hashtag"> Hashtag : </label>
                                <input class="form-control" type="text" value="<?php echo $donnees['hashtag']; ?>" name="hashtag">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="classe"> Classe : </label>
                                <input class="form-control" type="text" value="<?php echo $donnees['classe']; ?>" name="classe">
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
                $requete = "DELETE FROM idee WHERE numIdee = " . $_GET['id'] . ";";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '<h1>Suppression d\'une idée</h1><hr>';
                echo "La suppression de l'idée a bien été effectuée !";
                header('refresh:5; url=gestionboiteaidee.php');
                ob_flush();
                $req->closeCursor();
            }

            // si l'action est une vaidation
            elseif (@$_GET['action'] == 'validation') {
                require '../include/connectbdd.php';

                if ($_GET['statut'] == 0) {
                    $requete = "UPDATE idee SET statut = :statut WHERE numIdee = ".$_GET['id'].";";
                    $req = $bdd->prepare($requete);
                    $req->execute(array('statut' => $_GET['statut']));
                    echo "L'idée a bien été désactivée !";
                    header('refresh:1; url=gestionboiteaidee.php');
                    ob_flush();
                    $req->closeCursor();
                } else {
                    $requete = "UPDATE idee SET statut = :statut WHERE numIdee = ".$_GET['id'].";";
                    $req = $bdd->prepare($requete);
                    $req->execute(array('statut' => $_GET['statut']));
                    echo "L'idée a bien été validée !";
                    header('refresh:1; url=gestionboiteaidee.php');
                    ob_flush();
                    $req->closeCursor();
                }
            }

            else {
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
                    <td>'; ?>
                        <a href="gestionboiteaidee.php?action=modifier&id=<?php echo $row['numIdee']; ?>" title="Modifier l'idée" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                    <?php
                    if ($row['statut'] == 1) {
                        ?>
                            <a href="gestionboiteaidee.php?action=validation&id=<?php echo $row['numIdee']; ?>&statut=0" title="Enlever la validation" style="color:green"><i class="fa fa-times"></i></a>&nbsp;&nbsp;&nbsp;
                        <?php
                    } else {
                         ?>
                            <a href="gestionboiteaidee.php?action=validation&id=<?php echo $row['numIdee']; ?>&statut=1" title="Valider l'idée" style="color:purple"><i class="fa fa-check"></i></a>&nbsp;&nbsp;&nbsp;
                         <?php
                    }
                    ?>
                        <a href="gestionboiteaidee.php?action=supprimer&id=<?php echo $row['numIdee']; ?>" title="Supprimer l'idée" style="color:red"><i class="fa fa-trash"></i></a>
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