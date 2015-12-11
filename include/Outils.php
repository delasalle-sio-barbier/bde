<?php
// -------------------------------------------------------------------------------------------------------------------------
//                                         boite à outils de fonctions courantes
//                       Auteur : JM Cartron                       Dernière modification : 21/5/2015
// -------------------------------------------------------------------------------------------------------------------------

// liste des méthodes statiques de cette classe (dans l'ordre d'apparition dans le fichier) :

// estUnCodePostalValide    : validation d'un code postal (il doit comporter 5 chiffres)
// estUneAdrMailValide      : validation d'une adresse mail
// estUnNumTelValide        : validation d'un numéro de téléphone (5 groupes de 2 chiffres EVENTUELLEMENT séparés)
// estUneDateValide         : validation d'une date (format jj/mm/aaaa ou bien jj-mm-aaaa)
// corrigerDate             : remplace les "/" par des "-"
// corrigerVille            : met la ville en majuscules et remplace les "SAINT" par "St"
// corrigerPrenom           : met en majuscules le premier caractère, et le caractère qui suit un éventuel tiret
// corrigerTelephone        : met le numéro sous la forme de 5 groupes de 2 chiffres séparés par des points
// convertirEnDateUS        : convertit une date française (j/m/a) au format US (a-m-j)
// convertirEnDateFR        : convertit une date US (a-m-j) au format Français (j/m/a)
// envoyerMail              : envoyer un mail à un destinataire
// creerMdp                 : créer un mot de passe aléatoire de 8 caractères

// ce fichier est destiné à être inclus dans les pages PHP qui ont besoin des fonctions qu'il contient
// 2 possibilités pour inclure ce fichier :
//     include_once ('Class.Outils.php');
//     require_once ('Class.Outils.php');

// ces méthodes statiques sont appelées avec la notation suivante :
//     Outils::methode(parametres);

// début de la classe Outils
class Outils
{
    // fournit true si $codePostalAvalider est un code postal valide (5 chiffres), false sinon
    public static function estUnCodePostalValide($codePostalAvalider)
    {	// utilisation d'une expression régulière pour vérifier un code postal :
        $EXPRESSION = "#^[0-9]{5,5}$#";
        // on retourne true si le code est bon, mais aussi si le code est vide :
        if ( preg_match ( $EXPRESSION , $codePostalAvalider ) == true || $codePostalAvalider == "" ) return true; else return false;
    }

    // fournit true si $adrMailAvalider est une adresse valide, false sinon
    public static function  estUneAdrMailValide ($adrMailAvalider)
    {	// utilisation d'une expression régulière pour vérifier une adresse mail :
        $EXPRESSION = "#^.+@.+\\..+$#";
        // on retourne true si l'adresse est bonne, mais aussi si l'adresse est vide :
        if ( preg_match ( $EXPRESSION , $adrMailAvalider) == true || $adrMailAvalider == "" ) return true; else return false;
    }

    // fournit true si $numTelAvalider est un numéro de téléphone valide, false sinon
    public static function  estUnNumTelValide ($numTelAvalider)
    {	// utilisation d'une expression régulière pour vérifier un numéro de téléphone :
        $EXPRESSION = "#^([0-9]{2,2}( |\\.|-|_|,|/)?){4,4}[0-9]{2,2}$#";
        // on retourne true si le numéro est bon, mais aussi si le numéro est vide :
        if ( preg_match ( $EXPRESSION , $numTelAvalider) == true || $numTelAvalider == "" ) return true; else return false;
    }

    // fournit true si $laDateAvalider est une date valide (format jj/mm/aaaa ou bien jj-mm-aaaa), false sinon
    public static function estUneDateValide ($laDateAvalider)
    {	// on retourne true si la date est vide :
        if ( $laDateAvalider == "" ) return true;

        // utilisation d'une expression régulière pour vérifier le format de la date :
        $EXPRESSION = "#^[0-9]{2,2}(/|-)[0-9]{2,2}(/|-)[0-9]{4,4}$#";
        if ( preg_match ( $EXPRESSION , $laDateAvalider) == false) return false;

        // jusque là, tout va bien ! on extrait les 3 sous-chaines et on les convertit en 3 entiers :
        $chaine1 = substr ($laDateAvalider, 0, 2);
        $chaine2 = substr ($laDateAvalider, 3, 2);
        $chaine3 = substr ($laDateAvalider, 6, 4);
        $jour = (int)($chaine1);
        $mois = (int)($chaine2);
        $an = (int)($chaine3);

        // test des valeurs
        if ( $mois < 0 || $mois > 12 || $jour < 0 || $jour > 31 )
            return false;
        else
        {   // cas des mois de 30 jours
            if ( ( $mois == 4 || $mois == 6 || $mois == 9 || $mois == 11 ) && ( $jour > 30 ) )
                return false;
            else
            {   // cas du mois de février
                // % est l'op?rateur modulo ; il permet de tester si $an est multiple de 4, de 100 ou de 400
                $bissextile = (($an % 4) == 0 && ($an % 100) != 0) || ($an % 400) == 0;
                if ( $mois == 2 && $bissextile == false && $jour > 28 )
                    return false;
                else
                {   if ( $mois == 2 && $bissextile == false && $jour > 29 )
                {   return false;
                }
                }
            }
        }
        // si on arrive ici, c'est que la date est bonne :
        return true;
    }

    // remplace les "/" par des "-"
    public static function corrigerDate ($laDate)
    {
        $temporaire = str_replace ("-", "/", $laDate);
        return $temporaire;
    }

    // met la ville en majuscules et remplace les "SAINT" par "St"
    public static function corrigerVille ($laVille)
    {
        $temporaire = strtoupper ($laVille);
        $temporaire = str_replace ("SAINTE ", "Ste ", $temporaire);
        $temporaire = str_replace ("SAINTE-", "Ste ", $temporaire);
        $temporaire = str_replace ("SAINT ", "St ", $temporaire);
        $temporaire = str_replace ("SAINT-", "St ", $temporaire);
        return $temporaire;
    }

    // met en majuscules le premier caractère, et le caractère qui suit un éventuel tiret (le reste en minuscules)
    public static function corrigerPrenom ($lePrenom)
    {	if ($lePrenom != "")
    {	$longueur = strlen($lePrenom);
        $position = strpos($lePrenom, "-");
        if ($position == "")
        {	$partie1 = substr ($lePrenom, 0 , 1);
            $partie2 = substr ($lePrenom, 1 , $longueur-1);
            $lePrenom = strtoupper($partie1) . strtolower($partie2);
        }
        else
        {	$partie1 = substr ($lePrenom, 0 , 1);
            $partie2 = substr ($lePrenom, 1 , $position-1);
            $partie3 = substr ($lePrenom, $position + 1, 1);
            $partie4 = substr ($lePrenom, $position + 2, $longueur-$position-2);
            $lePrenom = strtoupper($partie1) . strtolower($partie2) . "-" . strtoupper($partie3) . strtolower($partie4);
        }
    }
        return $lePrenom;
    }

    // met le numéro sous la forme de 5 groupes de 2 chiffres séparés par des points
    public static function corrigerTelephone ($leNumero)
    {	$temporaire = $leNumero;
        $temporaire = str_replace (" ", "", $temporaire);	// supprime les espaces
        $temporaire = str_replace (".", "", $temporaire);	// supprime les points
        $temporaire = str_replace (",", "", $temporaire);	// supprime les virgules
        $temporaire = str_replace ("-", "", $temporaire);	// supprime les tirets
        $temporaire = str_replace ("_", "", $temporaire);	// supprime les underscore
        $temporaire = str_replace ("/", "", $temporaire);	// supprime les slash

        if (strlen($temporaire) == 10 )		// il ne doit rester que les 10 chiffres...
        {   $resultat =             substr ($temporaire, 0, 2) . ".";
            $resultat = $resultat . substr ($temporaire, 2, 2) . ".";
            $resultat = $resultat . substr ($temporaire, 4, 2) . ".";
            $resultat = $resultat . substr ($temporaire, 6, 2) . ".";
            $resultat = $resultat . substr ($temporaire, 8, 2);
            return $resultat;
        }
        else
        {   return $leNumero;
        }
    }

    // La fonction dateUS convertit une date française (j/m/a) au format US (a-m-j)
    // par exemple, le paramètre '16/05/2007' donnera '2007-05-16'
    public static function convertirEnDateUS ($laDate)
    {
        return date("Y-m-d", $laDate); //Affiche 28-12-2006
    }

    // La fonction dateFR convertit une date US (a-m-j) au format Français (j/m/a)
    // par exemple, le paramètre '2007-05-16' donnera '16/05/2007'
    public static function convertirEnDateFR ($laDate)
    {
        return date("d/m/Y", $laDate); //Affiche 28/12/2006
    }

    // La fonction dateHeureUS convertit une dateHeure française (j/m/a h:m:s) au format US (a-m-j h:m:s)
    // par exemple, le paramètre '16/05/2007' donnera '2007-05-16'
    public static function convertirEnDateHeureUS ($laDateHeure)
    {
        return date("Y-m-d H:i:s", $laDateHeure); //Affiche 28/12/2006 22:45:34
    }

    // La fonction dateHeureFR convertit une dateHeure US (a-m-j h:m:s) au format Français (j/m/a h:m:s)
    // par exemple, le paramètre '2007-05-16' donnera '16/05/2007'
    public static function convertirEnDateHeureFR ($laDateHeure)
    {
        return date("d/m/Y H:i:s", $laDateHeure); //Affiche 28/12/2006 22:45:34
    }

    // La fonction dateHeureFR convertit une dateHeure US (a-m-j h:m:s) au format Français (j/m/a h:m:s)
    // par exemple, le paramètre '2007-05-16' donnera '16/05/2007'
    public static function heureFormatFR ($laDateHeure)
    {
        setlocale (LC_TIME, 'fr_FR');
        return strftime("%A %d %B %Y %T");
    }

    public static function date_fr($time = null, $format = 'l j F Y, H:i'){
        if(empty($time)) $time = time();

        $date = date($format, $time);

        $jour_en = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
        $jour_fr = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");

        $mois_en = array("January","February","March","April","May","June","July","August","September","October","November","December");
        $mois_fr = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

        $date = str_replace($jour_en, $jour_fr, $date);
        $date = str_replace($mois_en, $mois_fr, $date);

        return $date;
    }

    // envoie un mail à un destinataire
    // retourne true si envoi correct, false en cas de problème d'envoi
    public static function  envoyerMail ($adresseDestinataire, $sujet, $message, $adresseEmetteur)
    {	// utilisation d'une expression régulière pour vérifier si c'est une adresse Gmail :
        if ( preg_match ( "#^.+@gmail\.com$#" , $adresseDestinataire) == true)
        {	// on commence par enlever les points dans l'adresse gmail car ils ne sont pas pris en compte
            $adresseDestinataire = str_replace(".", "", $adresseDestinataire);
            // puis on remet le point de "@gmail.com"
            $adresseDestinataire = str_replace("@gmailcom", "@gmail.com", $adresseDestinataire);
        }
        // envoi du mail avec la fonction mail de PHP
        $ok = mail($adresseDestinataire , $sujet , $message, "From: " . $adresseEmetteur);
        return $ok;
    }

    // crée un mot de passe aléatoire de 8 caractères (4 syllabes avec 1 consonne et 1 voyelle)
    public static function creerMdp ()
    {   $consonnes = "bcdfghjklmnpqrstvwxz";
        $voyelles = "aeiouy";
        $mdp = "";
        // on construit 4 syllabes de 2 caractères
        for ($i = 1 ; $i <= 4 ; $i++)
        {   // on tire d'abord une consonne (position aléatoire entre 0 et le nombre de consonnes - 1)
            $position = rand (0, strlen($consonnes)-1);
            // on récupère la consonne correspondant à la position dans $consonnes
            $unCaract = substr ($consonnes, $position, 1);
            // on ajoute cette consonne au mot de passe
            $mdp = $mdp . $unCaract;
            // puis on tire une voyelle (position aléatoire entre 0 et le nombre de voyelles - 1)
            $position = rand (0, strlen($voyelles)-1);
            // on récupère la voyelle correspondant à la position dans $voyelles
            $unCaract = substr ($voyelles, $position, 1);
            // on ajoute cette voyelle au mot de passe
            $mdp = $mdp . $unCaract;
        }
        return $mdp;
    }
} // fin de la classe Outils

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!
