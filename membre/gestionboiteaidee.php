<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
    <div class="container">
        <?php
        /* si le membre est connecte*/
        if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner')) {
            require '../include/connectbdd.php';
            echo '<h1>Gestion de la boite à idée</h1><hr>';

            if (!empty($_POST) && !empty($_POST['texte']) && !empty($_POST['hashtag']) && !empty($_POST['auteur']) && !empty($_POST['classe'])){    // Si un formulaire est rempli
                $req = $bdd->prepare("UPDATE idee SET texte = '".$_POST['texte']."', hashtag = '".$_POST['hashtag']."', auteur = '".$_POST['auteur']."', classe = '".$_POST['classe']."' WHERE numIdee = ".$_GET['numIdee']);
                $req->execute();
                $req->closeCursor();
                ob_start();
                header("Location: gestionboiteaidee.php");
                ob_end_flush();
            } elseif (!empty($_GET['action']) && !empty($_GET['numIdee'])){     // Si on a sélectionné un menu
                if ($_GET['action'] == 'valider'){             // Si on veut modifier l'idée
                    $req = $bdd->prepare('UPDATE idee SET statut = 1 WHERE numIdee = '.$_GET['numIdee']);
                    $req->execute();
                    $req->closeCursor();
                    ob_start();
                    header("Location: gestionboiteaidee.php");
                    ob_end_flush();
                } elseif ($_GET['action'] == 'modifier'){        // Si on veut valider l'idée
                    $requete = "SELECT * FROM idee WHERE numIdee = ".$_GET['numIdee'];
                    $req = $bdd->prepare($requete);
                    $req->execute();
                    $resultat = $req->fetch();
                    echo '<form method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                Texte :
                                <input class="form-control" type="text" value="'.$resultat['texte'].'" name="texte">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                            Hashtag :
                                <input class="form-control" type="text" value="'.$resultat['hashtag'].'" name="hashtag">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                            Auteur :
                                <input class="form-control" type="text" value="'.$resultat['auteur'].'" name="auteur" maxlength="255">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                            Classe :
                                <input class="form-control" type="text" value="'.$resultat['classe'].'" name="classe" maxlength="255">
                            </div>
                        </div><br>
                        <div class="row">
                            <button class="btn btn-large btn-primary" type="submit">Modifier</button>
                        </div>
                    </form>';
                    $req->closeCursor();
                } elseif ($_GET['action'] == 'supprimer'){      // Si on veut supprimer l'idée
                    $requete = " DELETE FROM idee WHERE numIdee = ".$_GET['numIdee'];
                    $bdd->exec($requete);
                    ob_start();
                    header("Location: gestionboiteaidee.php");
                    ob_end_flush();
                }
            } else {
                // Select des idées pour le tableau
                $requete = "SELECT * FROM idee";
                $req = $bdd->prepare($requete);
                $req->execute();
                echo '
                <table class="table">
                    <tr>
                        <th>Texte</th>
                        <th>Hashtag</th>
                        <th>Auteur</th>
                        <th>Classe</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Menu</th>
                    </tr>';
                while ($row = $req->fetch()) {
                    if ($row['statut'] == 0) $statut='En attente';
                    elseif ($row['statut'] == 1) $statut='Validée';
                    echo '
                    <tr>
                        <td>' . $row['texte'] . '</td>
                        <td>' . $row['hashtag'] . '</td>
                        <td>' . $row['auteur'] . '</td>
                        <td>' . $row['classe'] . '</td>
                        <td>' . $row['date'] . '</td>';
                        switch ($row['statut']) {
                            case 0:
                                echo '<td>En attente</td>
                                      <td>
                                          <a href="gestionboiteaidee.php?action=valider&numIdee=' . $row['numIdee'] . '" title="Valider l\'idée" style="color:green"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                                          <a href="gestionboiteaidee.php?action=modifier&numIdee=' . $row['numIdee'] . '" title="Modifier l\'idée" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                          <a href="gestionboiteaidee.php?action=supprimer&numIdee=' . $row['numIdee'] . '" title="Supprimer l\'idée" style="color:red"><i class="fa fa-trash"></i></a>
                                      </td>';
                                break;
                            case 1:
                                echo '<td>Validée</td>
                                      <td>
                                          <a href="gestionboiteaidee.php?action=modifier&numIdee=' . $row['numIdee'] . '" title="Modifier l\'idée" style="color:orange"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                          <a href="gestionboiteaidee.php?action=supprimer&numIdee=' . $row['numIdee'] . '" title="Supprimer l\'idée" style="color:red"><i class="fa fa-trash"></i></a>
                                      </td>';
                                break;
                            default:
                                echo 'test';
                                break;
                        }
                    echo '</tr>';
                }
                echo '</table>';
                $req->closeCursor();
            }
        } else{
            ?>
            <div class="panel panel-danger">
                <div class="panel-heading">Erreur : Vous n'avez pas l'accès à cette page. Vous n'êtes pas admin ou vous n'êtes pas connectés !</div>
            </div>
            <?php
        }
        ?>
    </div><br> <!-- /container -->
<?php include('../include/footer.php'); ?>
