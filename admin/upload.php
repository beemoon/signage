<?php

include('function.php');
$storeFolder = '../data';
$allowedType = array('image', 'video');

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
		$uniqueID = time();
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
		$slideInf['path'] = $_type[0];
			
    /* end */
    
    // rename to unique filename (timestamp)
    $targetFileName = $path_parts['filename'] . '.' . $path_parts['extension'];
    $targetFile =  $targetPath. $ds . $_type[0] . $ds . $targetFileName;
    //$targetFile =  $targetPath. $ds . $_type[0] . $ds . $uniqueID . '.' . $path_parts['extension'];
    
    move_uploaded_file($tempFile,$targetFile);	
	
	/* 
	 * Traitement des fichiers PDF dans le repertoire temp
	 * avant suppression 
	 */
	if ($path_parts['extension'] == "pdf"){
		$_type[0] = 'image';
		if(!is_dir($targetPath. $ds . $_type[0])){
		  mkdir($targetPath. $ds . $_type[0],0777);
		  chmod($targetPath. $ds . $_type[0],0777);
		}
		
		$targetFileName = $path_parts['filename'] . '.jpg';
		pdftojpg($targetFile,$targetPath. $ds . $_type[0] . $ds . $targetFileName);
		$slideInf['path'] = $_type[0];
		
		// rename to unique filename (timestamp)
		//$targetFile = $targetPath. $ds . $_type[0] . $ds . $uniqueID . '.jpg';
		//rename($targetPath. $ds . $_type[0] . $ds . $path_parts['filename'] . '.jpg',$targetFile);
	}
	
	// ajoute la description du slide
	$slideInf['description']=nl2br(htmlentities($_POST['descriptif'],ENT_QUOTES));
	
	chmod($targetFile, 0777);
	
	/* On vide le repertoire temp et on le supprime */
	if(is_dir($targetPath. $ds . 'temp') && count(glob($targetPath. $ds . 'temp' . $ds .'*'))!=0){
	  array_map('unlink', glob($targetPath. $ds . 'temp' . $ds .'*'));
	  rmdir($targetPath. $ds . 'temp');
	}
	
	addToSlideDB($targetFileName,$slideInf,$storeFolder. $ds .'slideDB.ini');
	
}

/* fichier de log pour controle */
//file_put_contents($targetPath. $ds . $_type[0] . $ds . $path_parts['filename'].'.txt', print_r($slideInf,true));
//file_put_contents($storeFolder. $ds .'debug.ini',print_r($slideInf,true));

/* génération des slides */
include('manage.php');

?>
