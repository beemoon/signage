<?php		
// On efface les informations de session.
  	session_start();    	
  	session_unset();
	session_destroy();
	header("location:http://".$_SERVER['HTTP_HOST'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])));
?>
