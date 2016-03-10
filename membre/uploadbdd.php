<?php
header('Content-Type: text/html; charset=UTF-8');
include('../include/head.php'); ?>
<?php include('../include/menu.php'); ?>
<div class="container">
    <?php
    function convertir_utf8($url){
        $contenu_fichier_non_utf8 ='';
        $file_content = file_get_contents($url);
        if(preg_match('/./u', $file_content)){
            return ('Fichier en UTF-8');
        }else{
            if (file_exists($url)) {
                $inF = fopen($url,"r");
                while (!feof($inF)) {
                    $contenu_fichier_non_utf8.= fgets($inF, 4096);
                }
                $contenu_fichier_modifier_en_utf8 = utf8_encode ($contenu_fichier_non_utf8);
            }
            $fichier = fopen($url,'w+');
            fputs($fichier,$contenu_fichier_modifier_en_utf8);
            fclose($fichier);
            return 'Fichier Converti en UTF-8 !';
        }
    }

    if(isset($_SESSION['numMembre']) && $_SESSION['privilege'] == 'owner') {
        echo '<h1>Ajout des membres</h1><hr>';
        // Connexion à la BDD
        require '../include/connectbdd.php';
        // UPLOAD DU FICHIER CSV, vérification et insertion en BASE
        if ($_FILES["file"]["type"] != "application/vnd.ms-excel") {
            die("Ce n'est pas un fichier de type .csv");
        } elseif (is_uploaded_file($_FILES['file']['tmp_name'])) {
            convertir_utf8($_FILES['file']['tmp_name']);
            //Process the CSV file
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            $data = fgetcsv($handle, 1000, ";"); //Remove if CSV file does not have column headings
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $req = $bdd->prepare('INSERT INTO membre (nom, prenom, classe, email, identifiant, mdp) VALUES (:nom,:prenom,:classe,:email,:identifiant,:mdp)');
                $req->execute(array('nom' => $data[0], 'prenom' => $data[1], 'classe' => $data[2], 'email' => $data[3], 'identifiant' => $data[4], 'mdp' => $data[5]));
            }
            echo 'Les nouveaux membres ont été ajoutés';
        } else {
            die("Vous ne devriez pas être là");
        }
        $req->closeCursor();
    }
    ?>
</div><br> <!-- /container -->
<?php include('../include/footer.php'); ?>
