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
            echo '<h1>Création d\'un album</h1><hr>';
            if(!empty($_POST) && isset($_POST['upload'])) { // si formulaire soumis
                $url = str_replace(" ","-",$_POST['titre']);
                $url = strtr($url, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
                $url = strtr($url, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
                require '../include/connectbdd.php';
                $requete = "INSERT INTO album (titre, dateCreation, url) ";
                $requete .= " VALUES (:titre, CURDATE(), :url)";
                $req=$bdd->prepare($requete);
                $req->execute(array('titre'=>$_POST['titre'], 'url'=>$url));
                $req->closeCursor();
                echo "L'album a bien été créé !";
            } else { ?>
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <input class="form-control" type="text" placeholder="Titre" name="titre">
                        </div>
                    </div><br>
                    <div class="row">
                        <button class="btn btn-large btn-primary" name="upload" type="submit">Envoyer</button>
                    </div>
                </form>
                <?php
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
    </div> <!-- /container -->
<?php include('../include/footer.php'); ?>