<?php
// durée de la session à 30 minutes
session_set_cookie_params('1800','/',$_SERVER['HTTP_HOST']);

$SID = session_id();
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session');


if(isset($_POST['logout']) and (strtolower($_POST['logout']) == 'logout')) {
	session_unset();
	session_destroy();
	header("location:http://".$_SERVER['HTTP_HOST'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])));
	
} else {

	
	if ($_SESSION['connected']!=1){
		
		$_SESSION['parentURL']="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		if (basename($_SERVER['PHP_SELF'])=='index.php' || basename($_SERVER['PHP_SELF'])=='admin.php'){
			header("location:http://".$_SERVER['HTTP_HOST'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT']))."/simpleLogin/login.php");
		}else{
			header("location:http://".$_SERVER['HTTP_HOST'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])));
		}
		
}
}
?>
