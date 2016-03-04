<?php include('../include/head.php'); ?><?php include('../include/menu.php'); ?><div class="container">    <?php    /* si le membre est connecte*/    if(isset($_SESSION['numMembre']) && ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner'))    {        echo '<h1>Espace administration</h1><hr>';        echo '<h3>Bonjour '.$_SESSION['prenom'].' '.$_SESSION['nom'].' !</h3><br>Vous êtes sur votre espace d\'administration. C\'est ici que vous pouvez gérer le site.<br><br>';?>        <ul>            <li><a href="editmsgbienvenue.php" style="text-decoration : underline;">Modifier message de bienvenue</a></li>            <li><a href="gestionnews.php" style="text-decoration : underline;">Gestion des news</a></li>            <li><a href="gestionevenement.php" style="text-decoration : underline;">Gestion des évenements</a></li>            <li><a href="gestiongalerie.php" style="text-decoration : underline;">Gestion de la galerie</a></li>            <li><a href="gestionboiteaidee.php" style="text-decoration : underline;">Gestion de la boîte à idées</a></li>        </ul><br><br>        <?php if($_SESSION['privilege'] == 'owner') { ?>            <h1>Espace super-administration</h1><hr>            <h3>Gestion des informations des membres</h3>            <ul>                <li>Modifier les informations des membre en <a href="editmembre.php" style="text-decoration : underline; font-weight: bold;">cliquant ici</a></li>            </ul>            <h3>Gestion de la BDD membre</h3>            <ul>                <li>Supprimer tous les membres actuels en <a href="#confirmation" data-toggle="modal" style="text-decoration : underline; font-weight: bold;">cliquant ici</a></li>                <li>                    Ajout des nouveaux membres avec un fichier .sql de ce type (mdp en sha1) : <br>                    <i>INSERT INTO `membre` (`nom`, `prenom`, `email`, `identifiant`, `mdp`)<br>                        VALUES ('POINTIER', 'Julie', 'pointier.j@lyceedelasalle.fr', 'pointier.j', 'f865b53623b121fd34ee5426c792e5c33af8c227'),<br>                        ('MARCHAND', 'Aurélien', 'marchand.a@lyceedelasalle.fr', 'marchand.a', 'd033e22ae348aeb5660fc2140aec35850c4da997');</i>                    <form method="POST" action="uploadbdd.php" enctype="multipart/form-data">                        <!-- On limite le fichier à 100Ko -->                        <input type="hidden" name="MAX_FILE_SIZE" value="100000">                        <input type="file" name="bdd">                        <input type="submit" name="envoyer" value="Envoyer le fichier">                    </form>                </li>            </ul>        <?php        }    }    else    {        ?>        <div class="panel panel-danger">            <div class="panel-heading">Erreur : Vous n'avez pas l'accès à cette page. Vous n'êtes pas admin ou vous n'êtes pas connectés !</div>        </div>        <?php    }    ?>    <!-- Confirmation suppression BDD -->    <div class="modal fade" id="confirmation" role="dialog">        <div class="modal-dialog">            <div class="modal-content">                <div class="modal-header">                    <h2>Confirmation</h2>                </div>                <div class="modal-body">                    Etes-vous sûr de vouloir supprimer tous les membres dans la base de données ?<br>                    <b>Cette action sera irréversible !</b>                </div>                <div class="modal-footer">                    <a class="btn btn-danger" href="deletemembre.php">Supprimer</a>                    <a class="btn btn-default" data-dismiss="modal">Annuler</a>                </div>            </div>        </div>    </div></div> <!-- /container --><?php include('../include/footer.php'); ?>