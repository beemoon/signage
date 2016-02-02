<?php
// On charge le fichier des fonctions
include_once('function.php');

// On détermine les paramètres
define('__myINSTALLDIR__',dirname(__DIR__));
$confINI['install_DIR'][0] = __myINSTALLDIR__;
$confINI['install_DIR'][1] = "Répertoire racine de l'application";
$confINI['admin_DIR'][0] = __myINSTALLDIR__ . DIRECTORY_SEPARATOR . "admin";
$confINI['admin_DIR'][1] = "Répertoire admin de l'appliation";
$confINI['dataStore'][0] = __myINSTALLDIR__ . DIRECTORY_SEPARATOR . "data";
$confINI['dataStore'][1] = "Répertoire de stockage des slides et vidéos";

$confINI['nbSlide'][0] = "5";
$confINI['nbSlide'][1] = "Nombre de slide affiché (inactif)";
$confINI['speedSlide'][0] = "4000";
$confINI['speedSlide'][1] = "vitesse de transition entre les slides (inactif)";
$confINI['maxLen'][0] = "180";
$confINI['maxLen'][1] = "Nombre de caractère pour le texte déroulant";
$confINI['minSpace'][0] = "10";
$confINI['minSpace'][1] = "espace entre les messages déroulants";
/*
$confINI['IDscreen1'][0] = "195.83.81.45";
$confINI['IDscreen1'][1] = "ID de l'écran 1 (inactif)";
$confINI['IDscreen2'][0] = "195.83.81.xx";
$confINI['IDscreen2'][1] = "ID de l'écran 2 (inactif)";
*/

print('<pre>');
print_r($confINI);
print('</pre>');


// On met a jour les paramètres
write_slideDB($confINIFile,$confINI);

?>
