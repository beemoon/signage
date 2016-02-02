<?php
// On charge le fichier des fonctions
include_once('function.php');


if(!empty($_POST['confButton'])) {
    /* mise à jour de la conf */
	$confINI = $_POST['confINI'];
	define('__myINSTALLDIR__',dirname(__DIR__));
	$confINI['install_DIR'][0] = __myINSTALLDIR__;
	$confINI['install_DIR'][1] = "Répertoire racine de l'application (non modifiable)";
	$confINI['admin_DIR'][0] = __myINSTALLDIR__ . DIRECTORY_SEPARATOR . "admin";
	$confINI['admin_DIR'][1] = "Répertoire admin de l'appliation (non modifiable)";
	$confINI['dataStore'][0] = __myINSTALLDIR__ . DIRECTORY_SEPARATOR . "data";
	$confINI['dataStore'][1] = "Répertoire de stockage des slides et vidéos (non modifiable)";
	write_slideDB($confINI,$confINIFile);
	touch('../forceRefresh.txt');
}

// On defini les constantes
foreach($confINI as $key=>$val){
	define('__'.$key.'__', $confINI[$key][0]);	
}

?>
<div id="wrapper" >	
	<div class="form_description" >
		<h1>Paramétrages</h1>
		<p>Paramétrage de l'application</p>
	</div>
	
	
	<form id="confForm" class="" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>" method="post" onSubmit="if(!confirm('Etes-vous sure de mettre à jour la configuration?')){return false;}">
			
		<div class="table">
			<?php foreach($confINI as $key=>$val){ ?>
						<div class="row">
							<div class="cell cell12"><?php echo $key ?><br>&nbsp;&nbsp;&nbsp;<?php echo $confINI[$key][1] ?><input name="confINI[<?php echo $key ?>][1]" type="hidden" value="<?php echo $confINI[$key][1] ?>"></div>
							<div class="cell cell2"><input name="confINI[<?php echo $key ?>][0]" type="text" value="<?php echo $confINI[$key][0] ?>" size="30"></div>
						</div>
			<?php } ?>
			<div class="row">
				<div class="cell cell1">Ajouter ou modifier des utilisateurs</div>
				<div class="cell cell2"><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].substr(dirname(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])).'/simpleLogin/admin.php' ?>"><input class="submit" type="text" value="Se connecter" size="30" readonly /></a></div>
			</div>
		</div>
	
		<div class="clearBoth save" >
			<input class="submit" type="submit" value="Enregistrer" id="confButton" name="confButton" />
		</div>
		
	</form>		
	
	
		
</div>
