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

?>
