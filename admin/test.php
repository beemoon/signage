<!DOCTYPE html>
	
<head>
<meta charset="utf-8">
<title>Signage v0.5</title>


<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dropzone.css"/>
<script type="text/javascript" src="js/dropzone.js"></script>


<body>
	
<form id="my-awesome-dropzone" >
	
	<div class="dropzone dz-clickable" id="myDrop">
    <div class="dz-default dz-message" data-dz-message="">
        <span>Drop files here to upload</span>
    </div>
</div>


  <!-- Now setup your input fields -->
  <input type="text" name="username" />

  <button type="submit">Submit data and files!</button>
</form>



<script>
Dropzone.autoDiscover = false;
$("div#myDrop").dropzone({ 
	url: "upload2.php",
	maxFiles: 1,
	paramName: 'file',
  maxFilesize: 10, //mb
  acceptedFiles: 'image/*',
  addRemoveLinks: true,
  autoProcessQueue: false,// used for stopping auto processing uploads
  autoDiscover: false,
});
</script>
</body>
</html>
