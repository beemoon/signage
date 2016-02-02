<?php
// On charge le fichier des fonctions
include_once('function.php');

if($_POST['forceRefresh'] == 1){
	if (isset($_POST['message'])){
		include('message.php');
	}
	touch('../forceRefresh.txt');
}
$_message = explode("&",file_get_contents('../message.inc'));

?>
<div id="wrapper" >	
	<div class="form_description" >
		<h1>Message déroulant</h1>
		<p>Gestion du message déroulant</p>
	</div>
	
	<form id="forceRefresh" name="forceRefresh" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>" method="post">
		<div id="">
			<h2>Message déroulant</h2> nombre de caractère saisie: <span id="nbCar">0</span> / <?php  echo (__maxLen__ - __minSpace__); ?>
			<input id="message" name="message" type="test" maxlength="<?php  echo (__maxLen__ - __minSpace__ +1); ?>" size="110" value="<?php  echo $_message[0]; ?>" onkeypress="compter(document.forms['forceRefresh'])">
		</div>
		<input id="forceRefresh" name="forceRefresh" type="hidden" value="1">
		<br /><br />
		<div class="clearBoth save" >
			<input class="refresh" type="submit" value="Actualiser" id="refreshButton" name="refreshButton" />
		</div>
	</form>

			
</div>
<script type = "text/javascript">
function compter(f) {
   var max=<?php  echo (__maxLen__ - __minSpace__); ?>;
   var txt=f.message.value;
   var nb=txt.length;
   var reste=max-nb;
if (nb>max) { 
      alert("Vous avez dépassé le nombre maximal de caractères qui est de " + max +".");
      f.message.value=txt.substring(0,max);
      nb=max;
   }
   document.getElementById("nbCar").innerHTML = nb;
   //f.nbcar.value=nb;
   //f.restcar.value=reste;
}
</script>
