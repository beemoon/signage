<?php
// On charge le fichier de conf
$confINIFile = $_SERVER['DOCUMENT_ROOT'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])) . DIRECTORY_SEPARATOR .'conf' . DIRECTORY_SEPARATOR . 'config.ini';
if (is_file($confINIFile)){
	$confINI = parse_ini_file($confINIFile,true);
} else {
	$confINI = array();
}

// On defini les constantes
foreach($confINI as $key=>$val){
	define('__'.$key.'__', $confINI[$key][0]);	
}

$ds = DIRECTORY_SEPARATOR;


if($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'].'index.php' !== __install_DIR__.$ds.'index.php'){
	include($_SERVER['DOCUMENT_ROOT'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])) . DIRECTORY_SEPARATOR ."simpleLogin/beeProtect.php");
}

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
    //chmod($file,0777);
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
	return $slideDB;
	
}

function delFromSlideDB($slideID,$slideDBFile){
	if (file_exists($slideDBFile)){
		copy($slideDBFile, $slideDBFile . '.bkp');
		$slideDB = parse_ini_file($slideDBFile,true);
		unset($slideDB[$slideID]);
		write_slideDB($slideDB, $slideDBFile);
		return $slideDB;
	}
}

function createThumbs( $imagesSrc,$thumbWidth,$ratio){
		try
	{
	        /*** the image file ***/
	        $image = $imagesSrc;
	
	        /*** a new imagick object ***/
	        $im = new Imagick();
	
	        /*** ping the image ***/
	        $im->pingImage($image);
	        
	        $width = $im->getImageWidth();
			$height = $im->getImageHeight();
			if ($width < $height){
				$height = $im->getImageWidth();
				$width = $im->getImageHeight();
			}
			
			// calculate thumbnail size
			if (!isset($ratio)){
				$ratio = round($width / $height,2);
			}
			$new_width = $thumbWidth;
			$new_height = $new_width / $ratio;
			
	        /*** read the image into the object ***/
	        $im->readImage( $image );
	
	        /*** thumbnail the image ***/
	        $im->thumbnailImage( $new_width, $new_height,true );
	
	        /*** Write the thumbnail to disk ***/
	        $im->writeImage( dirname($imagesSrc).'/'.'thumb_'.basename($imagesSrc ) );
	
	        /*** Free resources associated with the Imagick object ***/
	        $im->destroy();
	        return dirname($imagesSrc).'/'.'thumb_'.basename($imagesSrc );
	        
	}
	catch(Exception $e)
	{
	        print $e->getMessage();
	        return $imagesSrc;
	}
  

}
?>
