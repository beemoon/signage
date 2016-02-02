<?php
/*
 * Controle d'acces très basique sans base de donnée
 * 
 * Les login et mots de passe sont stockés dans un fichier texte
 * sous la forme:
 *
 *    login::passwd
 *
 * un par ligne
 *
 * valeur de retours TRUE ou FALSE
 *
 * paramètres:
 * 		$login:	le login
 * 		$password: le mot de passe associé au login
 *
 * by www.beemoon.fr
 *
 */
 
function checkAccess($login,$password){

// Fichier des login et mots de passe
$accountFile="usersList/users.acl";
if (basename($_SESSION['parentURL'])=='admin.php'){
$accountFile="usersList/admin.acl";
}
// Renvoie toutes les erreurs sauf les warning
error_reporting(E_ALL ^ E_WARNING);

$fp = fopen ($accountFile, "r");

// to emulate the before_needle php V5.3
function strstrb($h,$n){
    return array_shift(explode($n,$h,2));
}

if ($fp){
	$passwordArray = array();				
	while (!feof($fp)){
		$line = fgets ($fp);
		
		// Only after php V5.3
			//$loginFind = strstr($line, '::', true);
		// Before php V5.3
			$loginFind = strstrb($line, '::');
		
		$pwdFind = substr(strstr($line, '::'),2);
			if ($loginFind==$login){
				$passwordArray[] = trim($pwdFind);
			}
		}

	if (count($passwordArray)>0) {
		if (in_array($password,$passwordArray)) {
			return true;
		}else{
			return false;
		}
	}
	
}else{
	echo "Pas de liste d'utilisateurs!";
}
fclose($fp);
return false;		
}

?>