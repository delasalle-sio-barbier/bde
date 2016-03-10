<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
<div class="container">
    <?php
    /* si le membre est connecte*/
    if(isset($_SESSION['numMembre']) && $_SESSION['privilege'] == 'owner')
    {
        echo '<h1>Modifier un membre</h1><hr>';
        require '../include/connectbdd.php';
        if (!empty($_POST)) {   // Si on a sélectionné un membre
            if (isset($_POST['email']) && !empty($_POST['email'] && !empty($_POST['numMembre']))) {   // Si on a sélectionné un membre
            $req = $bdd->prepare('UPDATE membre SET email = :email WHERE numMembre = :numMembre');
            $req->execute(array('email' => $_POST['email'], 'numMembre' => $_POST['numMembre']));
            echo "L'email du membre a bien été modifié !";
            }elseif (!empty($_POST['mdp'] && !empty($_POST['mdp2']) && !empty($_POST['numMembre']))) {   // Si on a sélectionné un membre
                if ($_POST['mdp'] == $_POST['mdp2']){
                    /*on crypte le mot de passe pour faire le test*/
                    $mdphache = sha1($_POST['mdp']);
                    $req = $bdd->prepare('UPDATE membre SET mdp = :mdp WHERE numMembre = :numMembre');
                    $req->execute(array('mdp' => $mdphache, 'numMembre' => $_POST['numMembre']));
                    echo 'Le mot de passe du membre a bien été modifié !';
                }else{
                    echo 'Les 2 mots de passes sont différents !';
                }
            }
        }elseif (!empty($_GET['numMembre'])) {  // Si on a sélectionné un membre
            if (!empty($_GET['action']) && $_GET['action'] == 'supprimer') { // Si on a demandé la suppression du membre
                $requete = "DELETE FROM membre WHERE numMembre = ".$_GET['numMembre'];
                $req = $bdd->prepare($requete);
                $req->execute();
                echo "L'utilisateur a bien été supprimé !";
            } else { // Si on n'a pas demandé la suppression du membre
                $requete = "SELECT * FROM membre WHERE numMembre = ".$_GET['numMembre'];
                $req=$bdd->prepare($requete);
                $req->execute();
                $resultat=$req->fetch();
                echo "<h3>Utilisateur ".$resultat['prenom']." ".$resultat['nom']."</h3>";
                ?>
                <form method="post">
                    Email :
                    <div class="row">
                        <div class="col-lg-5">
                            <input class="form-control" type="text" name="email" value="<?php echo $resultat['email'] ?>">
                        </div>
                        <input type="hidden" name="numMembre" value="<?php echo $_GET['numMembre'] ?>">
                        <div class="col-lg-2">
                            <button class="btn btn-large btn-primary" type="submit">Mettre à jour</button>
                        </div>
                    </div><br>
                </form>
                <form method="post">
                    Mot de passe :
                    <div class="row">
                        <div class="col-lg-5">
                            <input class="form-control" type="password" name="mdp" placeholder="Nouveau mot de passe">
                        </div>
                        <div class="col-lg-5">
                            <input class="form-control" type="password" name="mdp2" placeholder="Confirmer nouveau mot de passe">
                        </div>
                        <input type="hidden" name="numMembre" value="<?php echo $_GET['numMembre'] ?>">
                        <div class="col-lg-2">
                            <button class="btn btn-large btn-primary" type="submit">Mettre à jour</button>
                        </div>
                    </div><br>
                </form>
                <button type="button" class="btn btn-danger"><a href="editmembre.php?numMembre=<?php echo $_GET['numMembre'] ?>&action=supprimer" style="color:white;">Supprimer l'utilisateur</a></button>
        <?php
            }
        } else { // Sinon on affiche la sélection de membre
            echo '
            <form method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <select id="listemembre" name="membre" onchange="change_valeur()">
                        <option>Membre</option>';
            $requete = "SELECT * FROM membre";
            $req = $bdd->prepare($requete);
            $req->execute();
            while ($row = $req->fetch()) {
                echo '<option value="'.$row['numMembre'].'">'.$row['prenom'].' '.$row['nom'].'</option>';
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

<!-- script pour gérer le select du membre -->
<script>
function change_valeur() {
select = document.getElementById("listemembre");
choice = select.selectedIndex
urlredirection = 'editmembre.php?numMembre='+select.options[choice].value;
document.location.href=urlredirection
}
</script>