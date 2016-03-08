<?php session_start(); ?>
<html lang="fr">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8" name="viewport" content="width=device-width">

        <title>BDE - Lycée de La Salle</title>

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Icones FontAwesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>

        <?php
        if (strstr($_SERVER['REQUEST_URI'], '/membre/')){?>
            <base href="http://localhost/bde/membre/">

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="../style/bootstrap.min.css">

            <!-- Latest compiled and minified JavaScript -->
            <script src="../style/js/bootstrap.min.js"></script>

            <!-- Style du thème -->
            <link rel="stylesheet" href="../style/style.css">

            <!-- TyniMCE -->
            <script type="text/javascript" src="../include/tinymce/tinymce.min.js"></script>

            <!-- Favicons -->
            <link rel="shortcut icon" href="../style/images/logo_bde.png">
        <?php } else { ?>
            <base href="http://localhost/bde/">

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="style/bootstrap.min.css">

            <!-- Latest compiled and minified JavaScript -->
            <script src="style/js/bootstrap.min.js"></script>

            <!-- Style du thème -->
            <link rel="stylesheet" href="style/style.css">

            <!-- TyniMCE -->
            <script type="text/javascript" src="include/tinymce/tinymce.min.js"></script>

            <!-- Favicons -->
            <link rel="shortcut icon" href="style/images/logo_bde.png">

        <?php
            if (basename($_SERVER['PHP_SELF']))
                echo '<script src="include/Galerie.js"></script>';
        } ?>
    </head>
    <body>
    <?php
    if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
        require_once('../include/Outils.php');
    } else {
        require_once('include/Outils.php');
    }
    ?>
    <div id="wrap"> <!-- Ouverture de la div wrap pour le footer -->
