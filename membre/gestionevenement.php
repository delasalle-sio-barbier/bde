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
                echo '<h1>Création d\'un évenement</h1><hr>';
                if (!empty($_POST)) {
                    if ((isset($_POST['titre']) && !empty($_POST['lieu'])) && (isset($_POST['texte'])) && (isset($_POST['dateDebut'])) && (isset($_POST['dateFin']))
                        && (isset($_POST['timeDebut'])) && (isset($_POST['timeFin']))
                    ) {
                        $dateDebut = $_POST['dateDebut'] . ' ' . $_POST['timeDebut'] . ':00';
                        $dateFin = $_POST['dateFin'] . ' ' . $_POST['timeFin'] . ':00';
                        require '../include/connectbdd.php';
                        $requete = "INSERT INTO evenement (titre, texte, lieu, dateDebut, dateFin, numCategorie) ";
                        $requete .= " VALUES (:titre, :texte, :lieu, :dateDebut, :dateFin, 1)";
                        $req = $bdd->prepare($requete);
                        $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'lieu' => $_POST['lieu'], 'dateDebut' => $dateDebut, 'dateFin' => $dateFin));
                        echo "L'évenement a bien été créé !";
                        header('refresh:5; url=gestionevenement.php');
                        ob_flush();
                        $req->closeCursor();
                    } else {
                        echo '<b>Erreur d\'ajout : </b><br>Au moins un des champs est vide.';
                        header('refresh:5; url=gestionevenement.php?action=ajout');
                        ob_flush();
                    }
                } else { ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="tire"> Titre de l'évènement : </label>
                                <input class="form-control" type="text" placeholder="Titre" name="titre">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="lieu"> Lieu : </label>
                                <input class="form-control" type="text" placeholder="Lieu" name="lieu">
                            </div>
                        </div><br>
                        <label for="debut"> Début : </label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-control" type="date" name="dateDebut">
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" type="time" name="timeDebut">
                            </div>
                        </div><br>
                        <label for="fin"> Fin : </label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-control" type="date" name="dateFin">
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" type="time" name="timeFin">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="debut"> Début : </label>
                                <textarea class="form-control" rows="5" id="mytextarea" name="texte"></textarea>
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
                echo '<h1>Modication d\'un évènement</h1><hr>';
                if (!empty($_POST)) {
                    require '../include/connectbdd.php';

                    $requete = "UPDATE evenement SET titre = :titre, texte = :texte, lieu = :lieu, dateDebut = :dateDebut, dateFin = :dateFin WHERE numEvenement = ".$_GET['id'].";";
                    $req = $bdd->prepare($requete);
                    $dateDebut = $_POST['dateDebut']." ".$_POST['timeDebut'];
                    $dateFin = $_POST['dateFin']." ".$_POST['timeFin'];
                    $req->execute(array('titre' => $_POST['titre'], 'texte' => $_POST['texte'], 'lieu' => $_POST['lieu'], 'dateDebut' => $dateDebut, 'dateFin' => $dateFin));
                    echo "L'évènement a bien été modifiée !";
                    header('refresh:5; url=gestionevenement.php');
                    ob_flush();
                    $req->closeCursor();
                } else {
                    require '../include/connectbdd.php';
                    $numEvenement = $_GET['id'];
                    $requete = "SELECT * FROM evenement WHERE numEvenement = '$numEvenement';";
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $donnees = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="tire"> Titre de l'évènement : </label>
                                <input class="form-control" type="text" placeholder="Titre" value="<?php echo $donnees['titre']; ?>" name="titre">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="lieu"> Lieu : </label>
                                <input class="form-control" type="text" placeholder="Lieu" value="<?php echo $donnees['lieu']; ?>" name="lieu">
                            </div>
                        </div><br>
                        <label for="debut"> Début : </label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-control" type="date" value="<?php echo $donnees['dateDebut']; ?>" name="dateDebut">
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" type="time" value="<?php echo $donnees['dateDebut']; ?>" name="timeDebut">
                            </div>
                        </div><br>
                        <label for="fin"> Fin : </label>
                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-control" type="date" <?php echo $donnees['dateFin']; ?> name="dateFin">
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" type="time" <?php echo $donnees['dateFin']; ?> name="timeFin">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="debut"> Début : </label>
                                <textarea class="form-control" rows="5" id="mytextarea" name="texte"><?php echo $donnees['texte']; ?></textarea>
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
                $requete = "DELETE FROM evenement WHERE numEvenement = " . $_GET['id'] . ";";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '<h1>Suppression d\'une actualité</h1><hr>';
                echo "La suppression de l'évènement a bien été effectuée !";
                header('refresh:5; url=gestionevenement.php');
                ob_flush();
                $req->closeCursor();
            }
            else {
                echo '<h1>Gestion des évènements</h1><hr>'; ?>
                <button type="button" class="btn btn-primary"><a href="gestionevenement.php?action=ajout" style="color:white;">Créer un nouvel évènement</a></button>
                <?php
                // Select des idées pour le tableau
                require '../include/connectbdd.php';
                $requete = "SELECT * FROM evenement";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '<br>
            <table class="table"><br>
                <tr>
                    <th>Titre</th>
                    <th>Texte</th>
                    <th>Lieu</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Options</th>
                </tr>';
                while ($row = $req->fetch()) {
                    echo '
                <tr>
                    <td>'.$row['titre'].'</td>
                    <td>'.substr($row['texte'],0,50).'...</td>
                    <td>'.$row['lieu'].'</td>
                    <td>'.$row['dateDebut'].'</td>
                    <td>'.$row['dateFin'].'</td>
                    <td>
                        <a href="gestionevenement.php?action=modifier&id='.$row['numEvenement'].'" title="Modifier l\'évènement" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                        <a href="gestionevenement.php?action=supprimer&id='.$row['numEvenement'].'" title="Supprimer l\'évènement" style="color:red"><i class="fa fa-trash"></i></a>
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