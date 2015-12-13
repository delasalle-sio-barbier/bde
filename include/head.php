<?php session_start(); ?>
<html lang="fr">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">

        <title>BDE - Lycée De La Salle</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>

        <?php
        if (strstr($_SERVER['REQUEST_URI'], '/membre/')){?>
            <!-- Style du thème -->
            <link rel="stylesheet" href="../style/style.css">

            <!-- TyniMCE -->
            <script type="text/javascript" src="../include/tinymce/tinymce.min.js"></script>

            <!-- Favicons -->
            <link rel="shortcut icon" href="../style/images/logo_bde.png">
        <?php } else { ?>
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