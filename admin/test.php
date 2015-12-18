<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Demo</title>
<link rel="stylesheet" type="text/css" href="css/dropzone.css"/> 
<link rel="stylesheet" type="text/css" href="css/upload.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css" />

<script type="text/javascript" src="js/dropzone.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/datetimepicker.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-fr.js"></script>

<script>	
Dropzone.options.myDropzone = {
            url: "upload.php",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            acceptedFiles: "image/*",

            init: function () {

                var submitButton = document.querySelector("#submit-all");
                var wrapperThis = this;

                submitButton.addEventListener("click", function () {
                    wrapperThis.processQueue();
                });

                this.on("addedfile", function (file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-lg dark'>Remove File</button>");

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        wrapperThis.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });

                this.on('sendingmultiple', function (data, xhr, formData) {
                    formData.append("Username", $("#Username").val());
                });
            }
        };
</script>

</head>
<body>


<form action="/" enctype="multipart/form-data" method="POST">
<input type="text" id ="Username" name ="Username" />
<div class="dropzone" id="my-dropzone" name="mainFileUploader">
	<div class="fallback">
		<input name="file" type="file" multiple />
	</div>
</div>
</form>
<div>
  <button type="submit" id="submit-all"> upload </button>
</div>



</body>
</html>
