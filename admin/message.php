<?php
// On charge le fichier des fonctions
include_once('function.php');

$maxLen = __maxLen__;
$minSpace = __minSpace__;
$myString = $_POST['message'];

$charSpaceTmp = '-';
$nbCharmyString =  mb_strlen($myString) + $minSpace;
$charEnPlus = $maxLen % $nbCharmyString / (floor($maxLen / $nbCharmyString));

// On ajoute les espaces minimales en chaque chaine
if($nbCharmyString <= ($maxLen + $minSpace)){
	for ($i = 1; $i <= $minSpace; $i++) {
		$myString .= $charSpaceTmp;
	}
	if($maxLen % $nbCharmyString != 0){
		for ($i = 1; $i <= $charEnPlus; $i++) {
			$myString .= $charSpaceTmp;
		}
	}
	
}

// On ajoute les espaces supplémentaires entre chaque chaine
if(floor($maxLen / $nbCharmyString)>1 && floor($maxLen / $nbCharmyString)<$maxLen){
	$finalString='';
	for ($i = 1; $i <= floor($maxLen / $nbCharmyString); $i++) {
		$finalString .= $myString;
	}
} else {
	$finalString = $myString;
}

// On complete la fin de ligne avec les espaces
$spaceLeft = $maxLen - mb_strlen($finalString);
if (($maxLen - mb_strlen($finalString)) > 0){
	for ($i = 1; $i <= $spaceLeft; $i++) {
		$finalString .= $charSpaceTmp;
	}
}

// On ecrit le fichier à inclure
file_put_contents(__install_DIR__ . $ds.'message.inc',str_replace($charSpaceTmp,"&nbsp;",$finalString.":::"));

?>
