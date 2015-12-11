<?php session_start(); ?>
<html lang="fr">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">

        <title>BDE - Lycée De La Salle</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>

        <?php
        if (strstr($_SERVER['REQUEST_URI'], '/membre/')){?>
            <!-- Style du thème -->
            <link rel="stylesheet" href="../style/style_theme.css">

            <!-- TyniMCE -->
            <script type="text/javascript" src="../include/tinymce/tinymce.min.js"></script>

            <!-- Favicons -->
            <link rel="shortcut icon" href="../style/images/logo_bde.png">
        <?php } else { ?>
            <!-- Style du thème -->
            <link rel="stylesheet" href="style/style_theme.css">

            <!-- TyniMCE -->
            <script type="text/javascript" src="include/tinymce/tinymce.min.js"></script>

            <!-- Favicons -->
            <link rel="shortcut icon" href="style/images/logo_bde.png">
        <?php } ?>
    </head>
    <body>
    <?php
    if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
        require_once('../include/Outils.php');
    } else {
        require_once('include/Outils.php');
    }
    ?>