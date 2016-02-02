<?php
// On charge le fichier des fonctions
include_once('function.php');

$slideDBFile = __dataStore__ . $ds .'slideDB.ini';
$slideDB = parse_ini_file($slideDBFile,true);

if(!empty($_POST['aSupprimer'])) {
    foreach($_POST['aSupprimer'] as $check) {
		rename('..' .$ds . end(explode($ds,__dataStore__ )) . $ds . $check,'..' .$ds . end(explode($ds,__dataStore__ )) . $ds . dirname($check).$ds.'old_'.basename($check));
    }
    /* génération des slides */
	include('manage.php');
	touch(__install_DIR__ . $ds.'forceRefresh.txt');
}

?>

<div id="wrapper" >	
	<div class="form_description" >
		<h1>Gestion des slides</h1>
		<p>Gestion de l'affichage des slides visibles</p>
	</div>
	
	<form id="deleteForm" class="" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>" method="post" onSubmit="if(!confirm('Etes-vous sure de supprimer ces slides?')){return false;}">
			
		<div class="table">
			<?php foreach($slideDB as $key => $val){ ?>
			<div class="row">
				<div class="cell cell1"><img class="img" height="150px" width="266.7px" src="
					<?php
					if ($slideDB[$key]['path'] == "image"){
						echo '..' .$ds . end(explode($ds,__dataStore__ )) . $ds . $slideDB[$key]['path'] . $ds . 'thumb_'.$key;
					} else {
						echo 'img' . $ds . 'video.png';
					}
					?>"></div>
				<div class="cell cell2">
					<h2><?php echo $slideDB[$key]['titreSlide'] ?></h2>
					<?php echo $slideDB[$key]['description'] ?>
				</div>
				<div class="cell cell3"><INPUT type="checkbox" name="aSupprimer[]" value="<?php echo $slideDB[$key]['path'].$ds.$key ?>"> Supprimer<br><br><font color="red"><?php if ($slideDB[$key]['dateDebut'] > time()){ echo '(affichage prévu le   ' . date('d M. Y à H:i:s',$slideDB[$key]['dateDebut']) . ')'; } ?></font></div>
			</div>
			<?php } ?>
			
		</div>
	
		<div class="clearBoth save" >
			<input class="submit" type="submit" value="Supprimer" id="suppButton" name="suppButton" />
		</div>
		
	</form>		
</div>
