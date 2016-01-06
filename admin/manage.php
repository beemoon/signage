<?php
include_once('function.php');
$storeFolder = '../data';

$ds = DIRECTORY_SEPARATOR;



/* create slide.inc */

// 1- On récupere tout les fichiers (images, videos)
$imageDir= $storeFolder . '/image';
$videoDir= $storeFolder . '/video';
$scanned_imageDir = preg_grep('/^([^.])/',scandir($imageDir));
$scanned_videoDir = preg_grep('/^([^.])/',scandir($videoDir));

$allSlide=array_merge($scanned_imageDir,$scanned_videoDir);
sort($allSlide);

/*
print('<pre>');
print_r($allSlide);
print('</pre>');
*/

// 2- On controle et Renomme/Supprime les slides obsolètes
$now=time();
$slideDBFile = $storeFolder. $ds .'slideDB.ini';
$slideDB = parse_ini_file($slideDBFile,true);

/*
print('<pre>');
print_r($slideDB);
print('</pre>');
*/

foreach($slideDB as $key => $val){
	//echo 'date de fin de '. $key .': ' . $slideDB[$key]['dateFin'] .'<br>';
	if ($slideDB[$key]['dateFin'] < $now && $slideDB[$key]['dateFin'] > 0) {
		// on renome/supprime le fichier
		//rename($storeFolder . $ds . $slideDB[$key]['path'] . $ds . $key,$storeFolder . $ds . $slideDB[$key]['path'] . $ds . 'old_'.$key);
		unlink($storeFolder . $ds . $slideDB[$key]['path'] . $ds . $key);
		delFromSlideDB($key,$storeFolder. $ds .'slideDB.ini');
	}    
}

// 3- On créer le slide.inc
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
		$slideDisplay[] = substr($storeFolder . $ds . $slideDB[$key]['path'] . $ds . $key,3);
		if (in_array($slideExt,$codec)) {
			
		 $myString .='
<div class="video">
<img src="data/image/pattern.jpg" alt="" />
<video controls width="1920" height="1080">
<source src="' . substr($storeFolder . $ds . $slideDB[$key]['path'] . $ds . $key,3);
					
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
			$myString .= '<img src="' . substr($storeFolder . $ds . $slideDB[$key]['path'] . $ds . $key,3) . '" alt="" />'."\n";
		}
		
		file_put_contents('../slides.inc',$myString);
	}    
}

/*		
print('<pre>');
print_r($slideDisplay);
print('</pre>');
*/

// Quand on recharge la page web
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

$demain = date('m-d-Y', strtotime('+1 days'));
$demain3H = mktime (3,0,0,$demain);
if ($slideTime[0]> $demain3H){
	file_put_contents('../refreshtime.inc',3);
} else{
	file_put_contents('../refreshtime.inc',$slideTime[0]);
}
//define('_REFRESHTIME_',$slideTime[0]);

/*
print('<pre>');
print_r($slideTime);
print('</pre>');
*/

// Comment on recharge la page web a partir du serveur ?????
//http://raspberrypi.stackexchange.com/questions/10571/refresh-chromium-browser-by-shell-script-with-xdotool-via-php

?>
