<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>


<div class="container">
    <h1>Contact</h1><hr>
    <p class="text-center">Ce formulaire vous permet de contacter le bureau du BDE.</p>

    <form action="contactok.php" method="post">
        <div class="row">
            <div class="col-lg-12">
                <label for="message">Objet du message : </label>
                <input class="form-control" type="text" placeholder="Objet" name="titre">
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <label for="message">E-mail :</label>
                <input class="form-control" type="email" placeholder="E-mail" name="email">
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <label for="message">Commentaire : </label>
                <textarea class="form-control" rows="5" placeholder="Saisissez votre message ici"  name="message"></textarea>
            </div>
        </div><br>
        <div class="row text-center">
            <button class="btn btn-large btn-warning" type="submit">Envoyer votre message</button>
        </div>
    </form>
</div> <!-- /container -->
<?php include('include/footer.php'); ?>