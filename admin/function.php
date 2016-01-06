<?php
function pdftojpg($pdfFile,$jpgFile){
	/*  
	 * imagemagick and php5-imagick required 
	 * 
	 * all options for imagick: 
	 *           http://php.net/manual/fr/class.imagick.php 
	 * 
	 */
	
	
	$pdf_file   = $pdfFile;
	$save_to    = $jpgFile;
	 
	$img = new imagick();
	 
	//this must be called before reading the image, otherwise has no effect - "-density {$x_resolution}x{$y_resolution}"
	//this is important to give good quality output, otherwise text might be unclear
	$img->setResolution(200,200);
	 
	//read the pdf
	$img->readImage("{$pdf_file}[0]");
	 
	//reduce the dimensions - scaling will lead to black color in transparent regions
	$img->scaleImage(1920,1080);
	 
	//set new format
	$img->setCompressionQuality(80);
	$img->setImageFormat('jpg');
	 
	// -flatten option, this is necessary for images with transparency, it will produce white background for transparent regions
	$img = $img->flattenImages();
	 
	//save image file
	$img->writeImages($save_to, false);

	//clean
	$img->clear(); 
	$img->destroy();
	
}

/* http://php.net/manual/fr/function.parse-ini-file.php#94414 */
function write_slideDB($array, $file){
    $res = array();
    foreach($array as $key => $val){
        if(is_array($val)){
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
        $res[] = "";
    
    }
    safefilerewrite($file, implode("\r", $res));
}

function safefilerewrite($fileName, $dataToSave){    
	if ($fp = fopen($fileName, 'w')){
        $startTime = microtime();
        do {
			$canWrite = flock($fp, LOCK_EX);
			// If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
			if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime()-$startTime) < 1000));

        //file was locked so now we can store information
        if ($canWrite){
			fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

}

function addToSlideDB($slideID,$newSlide,$slideDBFile){
	if (file_exists($slideDBFile)){
		copy($slideDBFile, $slideDBFile . '.bkp');
		$slideDB = parse_ini_file($slideDBFile,true);
		$slideDB[$slideID]=$newSlide;
		write_slideDB($slideDB, $slideDBFile);
	} else {
		$slideDB = array();
		$slideDB[$slideID]=$newSlide;
		write_slideDB($slideDB, $slideDBFile);
	}
	
}

function delFromSlideDB($slideID,$slideDBFile){
	if (file_exists($slideDBFile)){
		copy($slideDBFile, $slideDBFile . '.bkp');
		$slideDB = parse_ini_file($slideDBFile,true);
		unset($slideDB[$slideID]);
		write_slideDB($slideDB, $slideDBFile);
	}
}
?>
