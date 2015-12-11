<?php
// -------------------------------------------------------------------------------------------------------------------------
//                                         boite � outils de fonctions courantes
//                       Auteur : JM Cartron                       Derni�re modification : 21/5/2015
// -------------------------------------------------------------------------------------------------------------------------

// liste des m�thodes statiques de cette classe (dans l'ordre d'apparition dans le fichier) :

// estUnCodePostalValide    : validation d'un code postal (il doit comporter 5 chiffres)
// estUneAdrMailValide      : validation d'une adresse mail
// estUnNumTelValide        : validation d'un num�ro de t�l�phone (5 groupes de 2 chiffres EVENTUELLEMENT s�par�s)
// estUneDateValide         : validation d'une date (format jj/mm/aaaa ou bien jj-mm-aaaa)
// corrigerDate             : remplace les "/" par des "-"
// corrigerVille            : met la ville en majuscules et remplace les "SAINT" par "St"
// corrigerPrenom           : met en majuscules le premier caract�re, et le caract�re qui suit un �ventuel tiret
// corrigerTelephone        : met le num�ro sous la forme de 5 groupes de 2 chiffres s�par�s par des points
// convertirEnDateUS        : convertit une date fran�aise (j/m/a) au format US (a-m-j)
// convertirEnDateFR        : convertit une date US (a-m-j) au format Fran�ais (j/m/a)
// envoyerMail              : envoyer un mail � un destinataire
// creerMdp                 : cr�er un mot de passe al�atoire de 8 caract�res

// ce fichier est destin� � �tre inclus dans les pages PHP qui ont besoin des fonctions qu'il contient
// 2 possibilit�s pour inclure ce fichier :
//     include_once ('Class.Outils.php');
//     require_once ('Class.Outils.php');

// ces m�thodes statiques sont appel�es avec la notation suivante :
//     Outils::methode(parametres);

// d�but de la classe Outils
class Outils
{
    // fournit true si $codePostalAvalider est un code postal valide (5 chiffres), false sinon
    public static function estUnCodePostalValide($codePostalAvalider)
    {	// utilisation d'une expression r�guli�re pour v�rifier un code postal :
        $EXPRESSION = "#^[0-9]{5,5}$#";
        // on retourne true si le code est bon, mais aussi si le code est vide :
        if ( preg_match ( $EXPRESSION , $codePostalAvalider ) == true || $codePostalAvalider == "" ) return true; else return false;
    }

    // fournit true si $adrMailAvalider est une adresse valide, false sinon
    public static function  estUneAdrMailValide ($adrMailAvalider)
    {	// utilisation d'une expression r�guli�re pour v�rifier une adresse mail :
        $EXPRESSION = "#^.+@.+\\..+$#";
        // on retourne true si l'adresse est bonne, mais aussi si l'adresse est vide :
        if ( preg_match ( $EXPRESSION , $adrMailAvalider) == true || $adrMailAvalider == "" ) return true; else return false;
    }

    // fournit true si $numTelAvalider est un num�ro de t�l�phone valide, false sinon
    public static function  estUnNumTelValide ($numTelAvalider)
    {	// utilisation d'une expression r�guli�re pour v�rifier un num�ro de t�l�phone :
        $EXPRESSION = "#^([0-9]{2,2}( |\\.|-|_|,|/)?){4,4}[0-9]{2,2}$#";
        // on retourne true si le num�ro est bon, mais aussi si le num�ro est vide :
        if ( preg_match ( $EXPRESSION , $numTelAvalider) == true || $numTelAvalider == "" ) return true; else return false;
    }

    // fournit true si $laDateAvalider est une date valide (format jj/mm/aaaa ou bien jj-mm-aaaa), false sinon
    public static function estUneDateValide ($laDateAvalider)
    {	// on retourne true si la date est vide :
        if ( $laDateAvalider == "" ) return true;

        // utilisation d'une expression r�guli�re pour v�rifier le format de la date :
        $EXPRESSION = "#^[0-9]{2,2}(/|-)[0-9]{2,2}(/|-)[0-9]{4,4}$#";
        if ( preg_match ( $EXPRESSION , $laDateAvalider) == false) return false;

        // jusque l�, tout va bien ! on extrait les 3 sous-chaines et on les convertit en 3 entiers :
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
            {   // cas du mois de f�vrier
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

    // met en majuscules le premier caract�re, et le caract�re qui suit un �ventuel tiret (le reste en minuscules)
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

    // met le num�ro sous la forme de 5 groupes de 2 chiffres s�par�s par des points
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

    // La fonction dateUS convertit une date fran�aise (j/m/a) au format US (a-m-j)
    // par exemple, le param�tre '16/05/2007' donnera '2007-05-16'
    public static function convertirEnDateUS ($laDate)
    {	$tableau = explode ("/", $laDate);		// on extrait les segments de la chaine $laDate s�par�s par des "/"
        $jour = $tableau[0];
        $mois = $tableau[1];
        $an = $tableau[2];
        return ($an . "-" . $mois . "-" . $jour);		// on les reconcat�ne dans un ordre diff�rent
    }

    // La fonction dateFR convertit une date US (a-m-j) au format Fran�ais (j/m/a)
    // par exemple, le param�tre '2007-05-16' donnera '16/05/2007'
    public static function convertirEnDateFR ($laDate)
    {	$tableau = explode ("-", $laDate);		// on extrait les segments de la chaine $laDate s�par�s par des "/"
        $an = $tableau[0];
        $mois = $tableau[1];
        $jour = $tableau[2];
        return ($jour . "/" . $mois . "/" . $an);		// on les reconcat�ne dans un ordre diff�rent
    }

    // envoie un mail � un destinataire
    // retourne true si envoi correct, false en cas de probl�me d'envoi
    public static function  envoyerMail ($adresseDestinataire, $sujet, $message, $adresseEmetteur)
    {	// utilisation d'une expression r�guli�re pour v�rifier si c'est une adresse Gmail :
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

    // cr�e un mot de passe al�atoire de 8 caract�res (4 syllabes avec 1 consonne et 1 voyelle)
    public static function creerMdp ()
    {   $consonnes = "bcdfghjklmnpqrstvwxz";
        $voyelles = "aeiouy";
        $mdp = "";
        // on construit 4 syllabes de 2 caract�res
        for ($i = 1 ; $i <= 4 ; $i++)
        {   // on tire d'abord une consonne (position al�atoire entre 0 et le nombre de consonnes - 1)
            $position = rand (0, strlen($consonnes)-1);
            // on r�cup�re la consonne correspondant � la position dans $consonnes
            $unCaract = substr ($consonnes, $position, 1);
            // on ajoute cette consonne au mot de passe
            $mdp = $mdp . $unCaract;
            // puis on tire une voyelle (position al�atoire entre 0 et le nombre de voyelles - 1)
            $position = rand (0, strlen($voyelles)-1);
            // on r�cup�re la voyelle correspondant � la position dans $voyelles
            $unCaract = substr ($voyelles, $position, 1);
            // on ajoute cette voyelle au mot de passe
            $mdp = $mdp . $unCaract;
        }
        return $mdp;
    }
} // fin de la classe Outils

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces apr�s la balise de fin de script !!!!!!!!!!!!
