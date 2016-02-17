<?php include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
<div class="container">
    <?php
    if(isset($_SESSION['numMembre']) && $_SESSION['privilege'] == 'owner') {
        echo '<h1>Ajout des membres</h1><hr>';
        $fichier = basename($_FILES['bdd']['name']);
        $taille_maxi = 100000;
        $taille = filesize($_FILES['bdd']['tmp_name']);
        //Début des vérifications de sécurité...
        if (strrchr($_FILES['bdd']['name'], '.') != '.sql') //Si l'extension n'est pas égale à .sql
        {
            $erreur = 'Vous devez uploader un fichier de type sql...';
        }
        if ($taille > $taille_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }
        if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            //On formate le nom du fichier ici...
            $fichier = strtr($fichier,
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if (move_uploaded_file($_FILES['bdd']['tmp_name'], $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                // On exécute toutes les requetes du fichier une par une
                require '../include/connectbdd.php';
                $sql = file_get_contents($fichier);
                $sql_array = explode(";", $sql);
                unlink($fichier);
                echo "
            <div class='alert alert-success'>
                <strong>Succès :</strong> Tous les utilisateurs on été ajoutés avec succès ! (Les erreurs affichées sont à coriger, mais l'upload marche)
            </div>";
                foreach ($sql_array as $requete) {
                    $bdd->exec($requete);
                }
            } else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }
        } else {
            echo $erreur;
        }
    }
    ?>
</div> <!-- /container -->
<?php include('../include/footer.php'); ?>
