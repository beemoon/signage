<?php

// On charge le fichier des fonctions
include_once('function.php');

// controle du prochain refresh
include(__install_DIR__ . $ds.'nextTime.inc');

/* create slide.inc */

// 1- On récupere tout les fichiers (images, videos)
$imageDir= __dataStore__  . '/image';
$videoDir= __dataStore__  . '/video';
$scanned_imageDir = preg_grep('/^([^.])/',scandir($imageDir));
$scanned_videoDir = preg_grep('/^([^.])/',scandir($videoDir));

$allSlide=array_merge($scanned_imageDir,$scanned_videoDir);
sort($allSlide);


// 2- On controle et Renomme/Supprime les slides obsolètes
$now=time();
$slideDBFile = __dataStore__ . $ds .'slideDB.ini';
$slideDB = parse_ini_file($slideDBFile,true);


foreach($slideDB as $key => $val){
	if ($slideDB[$key]['dateFin'] < $now && $slideDB[$key]['dateFin'] > 0) {
		// on renomme/supprime le fichier
		unlink(__dataStore__ . $ds . $slideDB[$key]['path'] . $ds . $key);
		unlink(__dataStore__ . $ds . $slideDB[$key]['path'] . $ds . 'thumb_'.$key);
		$slideDB = delFromSlideDB($key,__dataStore__ . $ds .'slideDB.ini');
	} 
	
	// suppression des slides préfixés par old_ 
	if (file_exists(__dataStore__ . $ds . $slideDB[$key]['path'] . $ds . 'old_' . $key)) {
		unlink(__dataStore__ . $ds . $slideDB[$key]['path'] . $ds . 'old_' . $key);
		unlink(__dataStore__ . $ds . $slideDB[$key]['path'] . $ds . 'thumb_'.$key);
		$slideDB = delFromSlideDB($key,__dataStore__ . $ds .'slideDB.ini');
	}  
}

// 3- On prépare le contenu du slide.inc
$slideDisplay = array();
$codec = array('ogg','ogv','ebm','mp4');
$myString = "";

/* 
 * note pour les videos
 * 		https://developer.mozilla.org/fr/docs/Web/HTML/formats_media_support
 * 	
 * seul les formats VP8 ou 9 avec Ogg/Ogv (WebM) en natif (et H.264 (mp4), avec un decodeur tier)
 * sont supporté par HTML5
 * 
 */


foreach($slideDB as $key => $val){
	//echo 'date de debut de '. $key .': ' . $slideDB[$key]['dateDebut'] .'<br>';
	$slideExt = substr($key,-3);
	
	
	if ($slideDB[$key]['dateDebut'] <= $now) {
		$slideDisplay[] = end(explode($ds,__dataStore__ )) . $ds . $slideDB[$key]['path'] . $ds . $key;
		if (in_array($slideExt,$codec)) {
			
		 $myString .='
<div class="video">
<img src="data/image/pattern.jpg" alt="" />
<video controls width="1920" height="1080">
<source src="' . end(explode($ds,__dataStore__ )) . $ds . $slideDB[$key]['path'] . $ds . $key;
					
		 switch ($slideExt) {
			case 'ebm':
				$myString .=' " type="video/webm" />';
				break;
			case 'mp4':
				$myString .=' " type="video/mp4" />';
				break;
			case 'ogg':
				$myString .=' "" type="video/ogg" />';
				break;
			case 'ogv':
				$myString .=' "" type="video/ogg" />';
				break;
		 }
					
		 $myString .='
Your browser does not support HTML5 videos.
</video>
</div>'."\n";
		

		} else {
			$myString .= '<img src="' . end(explode($ds,__dataStore__ )) . $ds . $slideDB[$key]['path'] . $ds . $key . '" alt="" />'."\n";
		}
		
		
	}    
}

$x = array();
while (count(explode("\n", trim($myString,"\n"))) <= 2){
	$i = rand (0, 9);
	while(!in_array($i,$x)){
		$x[] = $i;
		$myString .= '<img src="' . end(explode($ds,__dataStore__ )) . $ds . 'default' . $ds . $i . '.jpg' . '" alt="" />'."\n";
	}
}

// ecriture du slinde.inc
file_put_contents(__install_DIR__ . $ds.'slides.inc',$myString);

// On détermine le prochain reload
$slideTime = array();
foreach($slideDB as $key => $val){
	if ($slideDB[$key]['dateDebut'] > time()){
		$slideTime[] = $slideDB[$key]['dateDebut'];
	}
	if ($slideDB[$key]['dateFin'] > 0) {
		$slideTime[] = $slideDB[$key]['dateFin'];
	}
}
sort($slideTime);

$demainMois = date('n', strtotime('+1 days'));
$demainJours = date('j', strtotime('+1 days'));
$demainAnnee = date('Y', strtotime('+1 days'));

$demain3H = mktime(__nextRefresh__,0,0,$demainMois,$demainJours,$demainAnnee);

if ((!isset($slideTime[0])) || ($slideTime[0]> $demain3H)){
	file_put_contents(__install_DIR__ . $ds.'nextTime.inc','<?php $_next='. $demain3H .'; ?>');
} else {
	file_put_contents(__install_DIR__ . $ds.'nextTime.inc','<?php $_next='. $slideTime[0] .'; ?>');
}


?>
