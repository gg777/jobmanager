<?php

/* Démarage d'une session nécéssaire pour récupérer la valeur générée d'une page a l'autre */
session_start();

/* On créer une valeur qui sera notre code secret a saisir */
$code = '';

/* On crée une chaine de 5 caractéres pris au hasard au sein d'une chaine aléatoire codé pour avoir des caractéres alpha-numérique */
$code = substr( sha1( mt_rand() ), 0, 5 );

/* On définit une variable de session nomée $_SESSION['code'] que l'on réutilisera plus tard */
$_SESSION['code_antispam']= md5( $code );

/* On crée une image de 65 pixels par 25 pixels */
$width = 65;
$height = 25;

/* Création de l'image */
$img = imageCreate( $width, $height );
$background_color = imageColorAllocate( $img, 0, 0, 0 );
$text_color = imageColorAllocate( $img, 255, 255, 255 );
$code_police= 8;

/* Définition des entétes - Pas de mise en cache pour les proxy et Mime type du fichier envoyé */
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( "Content-type: image/jpeg" );

/* incorporation de la variable variable $code dans l'image */
imageString( $img, $code_police, ( $width - imageFontWidth( $code_police ) *strlen( $code ) ) / 2, 5, $code, $text_color);
$fonts = 'arial.ttf';

/* Export de l'image */
imagejpeg( $img, '', 20 );

/* Destruction de l'image en mémoire */
imageDestroy( $img );