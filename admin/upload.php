<?php

include('function.php');
$storeFolder = '../data';
$allowedType = array('image', 'video','audio');

$ds = DIRECTORY_SEPARATOR;
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];        
    $mimeType = mime_content_type($tempFile);
	$_type = explode("/",$mimeType);
	if (!in_array($_type[0], $allowedType)) {
		$_type[0] = 'temp';
	}
	$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    if(!is_dir($targetPath. $ds . $_type[0])){
	  mkdir($targetPath. $ds . $_type[0],0777);
	  chmod($targetPath. $ds . $_type[0],0777);
	}
    
    $path_parts = pathinfo($_FILES['file']['name']); 
    
    /* prepare information to record slide    */
		$slideInf['duree']=$_POST['duree'];
		
		$format = 'Y/m/d H:i';
		$dateStart = DateTime::createFromFormat($format, $_POST['date_timepicker_start']);
		$slideInf['dateDebut']=$dateStart->getTimestamp();
		
		if ($slideInf['duree']=="temporaire"){
			$dateEnd = DateTime::createFromFormat($format, $_POST['date_timepicker_end']);
			$slideInf['dateFin']=$dateEnd->getTimestamp();
		}else{
			$slideInf['dateFin']="000";
		}
		$slideInf['titreSlide']=$_POST['titreSlide'];
		$slideInf['description']=$_POST['descriptif'];
		
		file_put_contents($targetPath. $ds . $_type[0] . $ds . $path_parts['filename'].'.txt', print_r($slideInf,true));
    /* end */
    
    //$targetFile =  $targetPath. $ds . $_type[0] . $ds . $path_parts['filename'] . '.' . $path_parts['extension'];
    // rename to unique filename (timestamp)
    $targetFile =  $targetPath. $ds . $_type[0] . $ds . $slideInf['dateDebut'].'_'.$slideInf['dateFin']. '.' . $path_parts['extension'];
    
	move_uploaded_file($tempFile,$targetFile);	
	chmod($targetFile, 0777);
	
	/* 
	 * Traitement des fichiers PDF dans le repertoire temp
	 * avant suppression 
	 */
	if ($path_parts['extension'] == "pdf"){
		/*
		if(!is_dir($targetPath. $ds . $path_parts['extension'])){
		  mkdir($targetPath. $ds . $path_parts['extension'],0777);
		  chmod($targetPath. $ds . $path_parts['extension'],0777);
		}
		// move file		
		rename($targetFile,$targetPath. $ds . $path_parts['extension'] . $ds . $_FILES['file']['name']);
		*/
		if(!is_dir($targetPath. $ds . 'image')){
		  mkdir($targetPath. $ds . 'image',0777);
		  chmod($targetPath. $ds . 'image',0777);
		}
		pdftojpg($targetFile,$targetPath. $ds . 'image' . $ds . $path_parts['filename'] . '.jpg');
		chmod($targetPath. $ds . 'image' . $ds . $path_parts['filename'] . '.jpg', 0777);
		// rename to unique filename (timestamp)
		rename($targetPath. $ds . 'image' . $ds . $path_parts['filename'] . '.jpg',$targetPath. $ds . 'image' . $ds . $slideInf['dateDebut'].'_'.$slideInf['dateFin'] . '.jpg');
	}
	 
	/* On vide le repertoire temp et on le supprime */
	if(is_dir($targetPath. $ds . 'temp') && count(glob($targetPath. $ds . 'temp' . $ds .'*'))!=0){
	  array_map('unlink', glob($targetPath. $ds . 'temp' . $ds .'*'));
	  rmdir($targetPath. $ds . 'temp');
	}
     
}

/* create slide.inc */

// 1- On récupere tout les fichiers (images, videos)

// 2- On controle leur durée de validité

// 3- On créer le slide.inc


// Comment on recharge la page web ?????

?>
