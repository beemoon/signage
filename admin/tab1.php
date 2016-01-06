<div id="wrapper" >	
	<div class="form_description" >
		<h1>Paramètres d'affichage</h1>
		<p>Informations pour la gestion et l'affichage du slide</p>
	</div>
	
	<div id="drop">				
	<form id="myDropzoneForm" class="dropzone" enctype="multipart/form-data" >
		<div class="fallback">
			<input id="file" name="file" type="file" class="descriptif" />
		</div>
					
			<div id="titre">
				<h2>Titre</h2>
				<input id="titreSlide" name="titreSlide">
			</div>
			 
			<div id="centerContent">
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
	</div>
	
	
	<div class="clearBoth save" >
		<input class="submit" type="submit" value="Enregistrer" id="saveButton" name="saveButton" disabled />&nbsp;&nbsp;&nbsp;<input id="cancelButton" name="cancelButton" class="cancelButton" type="button" value="Annuler" />
	</div>		
</div>

<script type="text/javascript">

 var currentDate = new Date();
 var month = currentDate.getMonth();
 var day = currentDate.getDate();
 var year = currentDate.getFullYear();
 
 jQuery.datetimepicker.setLocale('fr');
 jQuery(function(){
	 
 jQuery('#date_timepicker_start').datetimepicker({
  formatDate:'Y/m/d h:i',
  lang:'fr',
  minTime:'8:00',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
   })
  },
  timepicker:true,
  allowTimes:[
  '8:00','8:30','9:00', '9:30','10:00','10:30','11:00','11:30','12:00','12:30',
  '13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'
  ]
 });
 jQuery('#date_timepicker_start').datetimepicker({value:new Date(year, month, day, '00', '01')});

 jQuery('#date_timepicker_end').datetimepicker({
  formatDate:'Y/m/d h:i',
  lang:'fr',
  minTime:'8:00',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
   })
  },
  timepicker:true,
  allowTimes:[
  '8:00','8:30','9:00', '9:30','10:00','10:30','11:00','11:30','12:00','12:30',
  '13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'
  ]
 });
 
 
});


/* Conf de la zone Dropzone */
Dropzone.options.myDropzoneForm = false;
Dropzone.options.myDropzoneForm = {
	autoProcessQueue: false,
	acceptedFiles: "image/*,video/webm,,video/mp4,video/ogg,application/pdf",
	url:"upload.php",
	uploadMultiple: false,
	parallelUploads: 100,
    maxFiles: 100,
	maxFilesize: 5,
				
	init: function() {
			var myZone = this;
			
			document.querySelector("#saveButton").addEventListener("click", function(e) {
				if ($("#myDropzoneForm").validationEngine('validate')){
					e.preventDefault();
					e.stopPropagation();
					myZone.processQueue();
					};
				});
			
			this.on("maxfilesexceeded", function(file){
				alert('Vous ne pouvez pas uploader plus de 1 fichier!');
			});
				
			this.on("success", function (file, response) {
				alert('Ajout ok');
				location.reload(true);
			});	
			
			this.on("addedfile", function(file) {
				$( "#saveButton" ).prop( "disabled", false );	
				if (file.type.match('video.*')) {
				this.emit("thumbnail", file, "img/video.png");
				}
				if (file.type.match('application/pdf')) {
				this.emit("thumbnail", file, "img/pdf.png");
				}
				$('#titreSlide').val(file.name);
			});
			
			/*			
			this.on("sendingmultiple", function() {
			  
			});			
			this.on("successmultiple", function(files, response) {
				alert('Ajout ok');
				location.reload(true);
			});
			this.on("errormultiple", function(files, response) {
			  
			});
			*/
					
	}
    	
};


/* Evenements sur le formulaire*/
$("#permanent").click(function() {
	$( "#date_timepicker_start" ).prop( "disabled", true );
	$( "#date_timepicker_end" ).prop( "disabled", true );	 
	});
		
$("#temporaire").click(function() {
	$( "#date_timepicker_start" ).prop( "disabled", false );
	$( "#date_timepicker_end" ).prop( "disabled", false );	 
	});
	
$("#cancelButton").click(function() {
	location.reload(true);
});
	
</script>
