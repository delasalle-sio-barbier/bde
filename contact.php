<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
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
    <h1>Contact</h1><br>
    Ce formulaire vous permet de contacter le bureau du BDE<br>
    <hr>
    <form action="contactok.php" method="post">
        <div class="row">
            <div class="col-lg-6">
                <input class="form-control" type="text" placeholder="Titre" name="titre">
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-6">
                <input class="form-control" type="email" placeholder="E-mail" name="email">
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-6">
                <label for="message">Commentaire</label>
                <textarea class="form-control" rows="5" id="mytextarea" name="message"></textarea>
            </div>
        </div><br>
        <div class="row">
            <button class="btn btn-large btn-primary" type="submit">Envoyer</button>
        </div>
    </form>
</div> <!-- /container -->
<?php include('include/footer.php'); ?>