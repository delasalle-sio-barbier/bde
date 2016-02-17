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
        echo '<h1>Modifier message de bienvenue</h1><hr>';
        require '../include/connectbdd.php';
        if (!empty($_POST)) {
            $requete = "UPDATE `contenu`";
            $requete .= " SET `texte`=:texte";
            $requete .= " WHERE titre = 'MessageBienvenue'";
            $req=$bdd->prepare($requete);
            $req->execute(array('texte'=>$_POST['texte']));
            $req->closeCursor();
            echo 'Le message de bienvenue a bien été modifié !';
        } else {
            $requete = "SELECT texte FROM contenu WHERE titre = 'MessageBienvenue'";
            $req = $bdd->prepare($requete);
            $req->execute();
            $donnee = $req->fetch();
            ?>
            <form method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <textarea class="form-control" rows="5" id="mytextarea" name="texte"><?php echo $donnee['texte'] ?></textarea>
                    </div>
                </div><br>
                <div class="row">
                    <button class="btn btn-large btn-primary" type="submit">Envoyer</button>
                </div>
            </form>
            <?php
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
</div> <!-- /container -->
<?php include('../include/footer.php'); ?>