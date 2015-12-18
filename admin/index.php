<!DOCTYPE html>
	
<head>
<meta charset="utf-8">
<title>Signage v0.5</title>

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


<script type="text/javascript">
$( document ).ready(function() {
	$("#tabs").tabs();
	$("#myDropzoneForm").validationEngine();
});
</script>

</head>
<body>
<div id="tabs">
	<ul>
	<li><a href="#tabs-1">Ajouter un slide</a></li>
	<li><a href="#tabs-2">Liste des slides</a></li>
	<li><a href="#tabs-3">Slides obsolètes</a></li>
	<li><a href="#tabs-4">Message défilant</a></li>
	<li><a href="#tabs-5">Paramètrage</a></li>
	</ul>
	
	<div id="tabs-1"><?php include('tab1.php') ?></div>
	<div id="tabs-2"><?php include('tab2.php') ?></div>
	<div id="tabs-3"><?php include('tab3.php') ?></div>
	<div id="tabs-4"><?php include('tab4.php') ?></div>
	<div id="tabs-5"><?php include('tab5.php') ?></div>
</div>
</body>
</html>
