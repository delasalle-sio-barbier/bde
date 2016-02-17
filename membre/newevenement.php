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
        echo '<h1>Création d\'un évenement</h1><hr>';
        if (!empty($_POST)) {
            $dateDebut = $_POST['dateDebut'].' '.$_POST['timeDebut'].':00';
            $dateFin = $_POST['dateFin'].' '.$_POST['timeFin'].':00';
            require '../include/connectbdd.php';
            $requete = "INSERT INTO evenement (titre, texte, lieu, dateDebut, dateFin, numCategorie) ";
            $requete .= " VALUES (:titre, :texte, :lieu, :dateDebut, :dateFin, 1)";
            $req=$bdd->prepare($requete);
            $req->execute(array('titre'=>$_POST['titre'], 'texte'=>$_POST['texte'], 'lieu'=>$_POST['lieu'], 'dateDebut'=>$dateDebut, 'dateFin'=>$dateFin));
            echo "L'évenement a bien été créé !";
            $req->closeCursor();
        } else { ?>
            <form method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <input class="form-control" type="text" placeholder="Titre" name="titre">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-6">
                        <input class="form-control" type="text" placeholder="Lieu" name="lieu">
                    </div>
                </div><br>
                Début :
                <div class="row">
                    <div class="col-lg-3">
                        <input class="form-control" type="date" name="dateDebut">
                    </div>
                    <div class="col-lg-3">
                        <input class="form-control" type="time" name="timeDebut">
                    </div>
                </div><br>
                Fin :
                <div class="row">
                    <div class="col-lg-3">
                        <input class="form-control" type="date" name="dateFin">
                    </div>
                    <div class="col-lg-3">
                        <input class="form-control" type="time" name="timeFin">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-6">
                        <textarea class="form-control" rows="5" id="mytextarea" name="texte"></textarea>
                    </div>
                </div><br>
                <div class="row">
                    <button class="btn btn-large btn-primary" type="submit">Envoyer</button>
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