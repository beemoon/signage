<?php
// durée de la session à 30 minutes
session_set_cookie_params('1800','/',$_SERVER['HTTP_HOST']);

// On récupère la session si elle existe
$SID = session_id();
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session');

if($_SESSION['parentURL']=='') {exit('Vous ne pouvez pas vous connecter directement sur cette page!');}
if($_SESSION['connected'] == '1') {exit('Vous êtes déjà connecté!');}

$_SESSION['err'] = ''; $exit = false;
do {
    //    check if form was previously submitted
    if(isset($_POST['submit']) and isset($_POST['SID']) and ($_POST['SID'] !== session_id())) {
        $ret = null; $exit = true; break; }
    //    break out of do-while if form has not been submitted yet
    if(empty($_POST['submit'])) break;
    //    process form data if user hit form "submit" button
    if(isset($_POST['submit'])) {
        $ret = validate_form();
        //    ret will be error message if form validation failed
        if(is_string($ret)) { $_SESSION['err'] = $ret; break; }
        //    ret will be array of cleaned form values if validation passed
        if(is_array($ret)) { session_regenerate_id(true); $exit = true; break; }
    }
} while(false);

if($exit) display_receipt($ret);
$exit and exit;

function validate_form() {
	require_once('fonctions.php');
    $_login = htmlspecialchars($_POST['log']);    //    clean POST data
    $_passwd = htmlspecialchars($_POST['pwd']);    //    clean POST data
    if((checkAccess($_login,$_passwd)) === true) { 		
    return array('login' => $_login, 'connected' => '1');
    }
    if (basename($_SESSION['parentURL'])=='admin.php'){
	$message="Les informations de connexion ne sont pas correctes ou vous n'êtes pas autorisé à gérer les utilisateurs, veuillez réessayer !";
	} else {
	$message="Les informations de connexion ne sont pas correctes, veuillez réessayer !";
	}
    return $message;
}

function display_receipt($msg) {
    if($msg === null) echo 'Vous êtes déjà connecté!';
    if(is_array($msg)) {
    	$_SESSION['login'] = htmlspecialchars($_POST['log']);
    	$_SESSION['connected'] = 1;
    	header("location:".$_SESSION['parentURL']."");
    }
    return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR">
<head>
	<title>Connexion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="robots" content="noindex,nofollow"/>
	<link rel="stylesheet" id="login-css" href="css/style.css" type="text/css" media="all"/>
	<script type="text/javascript" src="js/mootools-1.2.4-core.js"></script>
	<script type="text/javascript" src="js/mootools-1.2.4.2-more.js"></script>
	
	<script type="text/javascript" src="js/formcheck/lang/fr.js"> </script>
	<script type="text/javascript" src="js/formcheck/formcheck.js"> </script>
	
	<link rel="stylesheet" href="js/formcheck/theme/classic/formcheck.css" type="text/css" media="screen" />
	
	<script type="text/javascript">
    window.addEvent('domready', function(){
        new FormCheck('loginform');
    });   
	</script>

</head>
<body class="login">
<div id="login">
<h1><a href="" title="">Identification</a></h1>
<form name="loginform" id="loginform" action="http://<?php echo $_SERVER['HTTP_HOST'], $_SERVER['PHP_SELF']; ?>" method="post">
	<p>
		<label>Identifiant<br/>
		<input name="log" id="user_login" class="input validate['required']" size="20" tabindex="10" type="text" value="<?php isset($_SESSION["name"]) and print $_SESSION["name"]; ?>"/></label>
	</p>
	<p>
		<label>Mot de passe<br/>
		<input name="pwd" id="user_pass" class="input validate['required']" value="" size="20" tabindex="20" type="password" value="<?php isset($_SESSION["great"]) and print $_SESSION["great"]; ?>"/></label>
	</p>
	<p class="submit">
		<input type="hidden" name="SID" value="<?php echo session_id(); ?>">
		<input name="submit" id="submit" class="button-primary" value="Se connecter" tabindex="100" type="submit"/>
	</p>
	<div id="copyright"><a href="img/signature.png" title="copyright" alt="copyright"><img src="img/signature.png" /></a><div class="text">Powered by www.beemoon.fr</div></div>
</form>
<?php if ($_SESSION['err'] != ''){ ?>
<div id="message"><?php echo $_SESSION['err']; ?></div>
<?php } ?>
<b>
<br/>
</b>
</div>

<script type="text/javascript">
function attempt_focus(){
	setTimeout( function(){ try{
	d = document.getElementById('user_login');
	d.value = '';
	d.focus();
	} catch(e){}
	}, 200);
}
attempt_focus();
</script>

</body>
</html>
