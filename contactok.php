<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
    <div class="container">
        <?php
        if (!empty($_SESSION['id'])) //les membres doivent êtres connectés
        {
            /* il faut que toutes les variables du formulaire existent*/
            if(isset($_POST['titre']) && isset($_POST['email']) && isset($_POST['message'])) {
                    /*il faut que tous les champs soient renseignes*/
                if($_POST['titre']!="" && $_POST['email']!="" && $_POST['message']!="") {
                    $boundary = "-----=" . md5( uniqid ( rand() ) );
                    $headers = "Reply-to: \"bde-delasalle.com\"<contact@bde-delasalle.com>\n";
                    $headers .= "From: \"bde-delasalle.com\"<contact@bde-delasalle.com>\n";
                    //NOTE: l'adresse email indiquée dans le header From doit etre l'adresse absolue du serveur qui envoie les messages, et peut etre differente de votre adresse de contact si vous etes par exemple sur un serveur dedié partagé. dans mon cas l'adresse specifiee ici est <webusers@mail.nomduserveur.com>
                    $headers .= "MIME-Version: 1.0\n";
                    $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"";

                    $destinataire = 'delasalle.sio.barbier.p@gmail.com';

                    $subject = 'Contact BDE : '. $_POST['titre'];

                    $message  = $_POST['message'].'<br><br> Email : '.$_POST['email'];

                    mail($destinataire, $subject, $message, $headers);

                    ?>
                    <div class="alert alert-success">
                        <strong>Succès :</strong> Votre message a bien été envoyé ! <br> Nous y réponderont le plus rapidement possible.
                    </div>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                        <!--
                        var redirection = 'window.location.replace("contact.php");';
                        setTimeout(redirection,4000);
                        // -->
                    </script>
                    <div class="alert alert-danger">
                        <strong>Erreur :</strong> Il faut remplir tous les champs !
                    </div>
                <?php
                }
            } else {
            ?>
                <script type="text/javascript">
                    <!--
                    var redirection = 'window.location.replace("contact.php");';
                    setTimeout(redirection,4000);
                    // -->
                </script>
                <div class="alert alert-danger">
                    <strong>Erreur :</strong> Une erreur s'est produite !
                </div>
            <?php
            }
        } else {
        ?>
            <script type="text/javascript">
                <!--
                var redirection = 'window.location.replace("login.php");';
                setTimeout(redirection,4000);
                // -->
            </script>
            <div class="alert alert-danger">
                <strong>Erreur :</strong> Vous devez vous connecter pour accéder à cette page !
            </div>
            <?php
        }
        ?>
    </div> <!-- /container -->
<?php include('include/footer.php'); ?>