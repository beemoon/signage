<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Demo</title>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/dropzone.css"/>
<link rel="stylesheet" type="text/css" href="css/upload.css"/>
<script type="text/javascript" src="js/dropzone.js"></script>

<link rel="stylesheet" type="text/css" href="css/datetimepicker.css"/>
<script type="text/javascript" src="js/datetimepicker.js"></script>

<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css" />
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-fr.js"></script>

<!--script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script-->

</head>
<body>
<div id="wrapper" >
	
	<div class="form_description">
		<h1>Paramètres d'affichage</h1>
		<p>Informations pour la gestion et l'affichage du slide</p>
	</div>

	<form id="myDropzoneForm" class="dropzone" enctype="multipart/form-data" method="post" action="upload2.php"> 
	<div id="centerContent">
				  
	   <div id="drop" >
			<div id="dropHere" >
				<div class="dz-message"></div>
				<div class="fallback">
					<input id="file" name="file2" type="file" class="descriptif" />
					
				</div>
			</div>
			
			<div id="titre">
				<h2>Titre</h2>
				<input id="titreSlide" name="titreSlide">
			</div>	 
		</div>
		
		<div id="content" >
			<div class="affichage">
				<h2>Durée d'affichage</h2>
				<div id="dureeAff">
					<input id="temporaire" name="duree" class="radio" type="radio" value="temporaire" checked />
					<label class="choice">Temporaire (date et heure)</label>
					<div class="inputDate">
						du <input id="date_timepicker_start" name="date_timepicker_start" type="text" > au <input id="date_timepicker_end" name="date_timepicker_end"class="validate[required]" value="" type="text">
					</div>
				</div>
				<div>
					<input id="permanent" name="duree" class="radio" type="radio" value="permanent"/>
					<label class="choice" >Permanent</label>
				</div>
			</div>
			
			<div id="descriptif">
				<h2>Descriptif (optionnel mais conseillé)</h2>
				<div>
					<textarea id="descriptifTxt" name="descriptif" class="descriptif"></textarea>
				</div>
			</div>
		</div>				
				
	</div>
	</form>
	
	<div class="clearBoth save" >
		<input class="submit" type="submit" value="Enregistrer" id="saveButton" name="saveButton" />&nbsp;&nbsp;&nbsp;<input id="cancelButton" name="cancelButton" class="cancelButton" type="button" value="Annuler" />
	</div>

</div>
<script>
                 Dropzone.options.myDropzoneForm = {
// url does not has to be written if we have wrote action in the form tag but i have mentioned here just for convenience sake 
          url: 'upload2.php', 
          autoProcessQueue: false, // this is important as you dont want form to be submitted unless you have clicked the submit button
          autoDiscover: false,
          paramName: 'file', // this is optional Like this one will get accessed in php by writing $_FILE['pic'] // if you dont specify it then bydefault it taked 'file' as paramName eg: $_FILE['file'] 
          previewsContainer: '#dropHere', // we specify on which div id we must show the files
          clickable: "#dropHere", // this tells that the dropzone will not be clickable . we have to do it because v dont want the whole form to be clickable 
          accept: function(file, done) {
            console.log("uploaded");
            done();
          },
         error: function(file, msg){
            alert(msg);
          },
          init: function() {

              var myDropzone = this;
            //now we will submit the form when the button is clicked
            $("saveButton").on('click',function(e) {
               e.preventDefault();
               myDropzone.processQueue(); // this will submit your form to the specified action path
              // after this, your whole form will get submitted with all the inputs + your files and the php code will remain as usual 
        //REMEMBER you DON'T have to call ajax or anything by yourself, dropzone will take care of that
            });

          } // init end

        };

        </script>



</body>
</html>
