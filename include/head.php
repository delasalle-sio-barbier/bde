<?php session_start(); ?>
<html lang="fr">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8" name="viewport" content="width=device-width">

        <title>BDE - Lycée de La Salle</title>
        <meta name="Content-Type" content="UTF-8">
        <meta name="Content-Language" content="fr">
        <meta name="description" content="Site officiel du Bureau des Elèves du Lycée de la salle à Rennes">
        <meta name="keywords" content="bde, bureau des étudiants, dls, rennes, pole superieur, pole, superieur, bts, prepa, etudiant, lycée de la salle, rennes ">
        <meta name="Copyright" content="Association Bureau des étudiants">
        <meta name="Author" content="Étudiants du pôle supérieur du lycée de la salle">
        <meta name="Publisher" content="Équipe du BDE">
        <meta name="Identifier-Url" content="www.dls-bde.fr">
        <meta name="Reply-To" content="adm@lycee-delasalle.com">
        <meta name="Revisit-After" content="10 days">
        <meta name="Robots" content="all">
        <meta name="Rating" content="general">
        <meta name="Distribution" content="global">
        <meta name="Geography" content="Rennes">


        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Icones FontAwesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>

        <!-- Framework AngularJS -->
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script>
            String.prototype.replaceAll = function(search, replacement) {
                //ajout de la fonction replaceAll
                var target = this;
                return target.replace(new RegExp(search, 'g'), replacement);
            };

            var app = angular.module('module', []);//Le module

            app.filter('modif',function(){//le filtre = fct qui modifie
                return function(input) {

                    input = input.replaceAll(" " , "-");
                    input = input.replaceAll("'" , "-");
                    input = input.replaceAll("é" , "e");
                    input = input.replaceAll("à" , "a");
                    input = input.replaceAll("è" , "e");
                    input = input.replaceAll("ù" , "u");
                    input = input.replaceAll("î" , "i");
                    input = input.replaceAll("ï" , "i");
                    input = input.replaceAll("ç" , "c");
                    return input;
                }
            });
        </script>

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
