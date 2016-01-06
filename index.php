<!DOCTYPE html>
<!--

Pour la video
youtub: http://stackoverflow.com/questions/17717048/pause-youtube-video-on-next-slide-using-cycle-plugin
http://jquery.malsup.com/cycle/pause.html

options:
http://jquery.malsup.com/cycle/options.html

PDF to JPG:
http://php.net/manual/fr/imagick.readimage.php

Compression du code:
https://htmlcompressor.com/compressor/

free images:
https://pixabay.com/

box overlay:
http://jacklmoore.com/colorbox

convertisseur video:
http://video.online-convert.com/fr/convertir-en-webm

-->


<!--[if lt IE 7]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class='no-js' lang='en'>
	<!--<![endif]-->
	<head>
		<meta charset='utf-8' />
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
		<title>Signage v0.5</title>
		
		<meta content='' name='description' />
		<meta content='' name='author' />
		
		<meta name="distribution" content="global" />
		<meta name="language" content="en" />
		<meta content='width=device-width, initial-scale=1.0' name='viewport' />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="favicon.png" />
		
		<link rel="stylesheet" href="lib/css/jquery.maximage.css?v=1.2" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="lib/css/screen.css?v=1.2" type="text/css" media="screen" charset="utf-8" />
		
		<!--[if lt IE 9]><script src="lib/js/html5.js"></script><![endif]-->
		<link rel="stylesheet" href="lib/skin/default/clock.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="lib/skin/default/banner.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="lib/skin/default/others.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="lib/css/colorbox.css" />
		
		
		<!--[if IE 6]>
			<style type="text/css" media="screen">
				/*I don't feel like messing with pngs for this browser... sorry*/
				#gradient {display:none;}
			</style>
		<![endif]-->	

</head>

	<body>
	
		<div id="clock">
			<div id="Date"></div>
			<ul>
				<li id="hours"> </li>
				<li id="point">:</li>
				<li id="min"> </li>
				<li id="point">:</li>
				<li id="sec"> </li>
			</ul>
		</div>
		<div class="banner">
			<span class="defile" style="color:red" data-text="Bonne année 2016...... Bonne année 2016...... Bonne année 2016...... Bonne année 2016...... Bonne année 2016......">
			  Bonne année 2016...... Bonne année 2016...... Bonne année 2016...... Bonne année 2016...... Bonne année 2016......
			</span>
		</div>
		<img id="cycle-loader" src="lib/img/ajax-loader.gif" />
			
		<div id="maximage">
			<?php include('slides.inc'); ?>		
		</div>
		
		
		<script src="lib/js/jquery.js"></script>
		<script src="lib/js/jquery.cycle.all.js" type="text/javascript" charset="utf-8"></script>
		<script src="lib/js/jquery.maximage.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="lib/js/jquery.colorbox.js"></script>
		<script type="text/javascript" src="lib/js/clock.js"></script>
		
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	_myClock();						
});

$(function(){
	$('#maximage').maximage({
		cycleOptions: {
			fx: 'fade',
			speed: 4000, // Has to match the speed for CSS transitions in jQuery.maximage.css (lines 30 - 33)
			timeout: 15000, // durée affichage d'un slide
			//prev: '#arrow_left',
			//next: '#arrow_right',
			pause: 0,
			pauseOnPagerHover: 0,
			before: function(last,current){
				if(!$.browser.msie){
					// Start HTML5 video when you arrive
					if($(current).find('video').length > 0) {
						$('#maximage').cycle('pause');
						$(current).find('video')[0].play();
						$('video').on('ended',function(){
							  $('#maximage').cycle('resume');
							});							
					}
				}
			},
			after: function(last,current){
				if(!$.browser.msie){
					// Pauses HTML5 video when you leave it
					if($(last).find('video').length > 0) {
						$(last).find('video')[0].pause();
					}
				}
			}
		},
		onFirstImageLoaded: function(){
			jQuery('#cycle-loader').hide();
			jQuery('#maximage').fadeIn('fast');
		}
	});

	// Helper function to Fill and Center the HTML5 Video
	jQuery('video,object').maximage('maxcover');

	// To show it is dynamic html text
	jQuery('.in-slide-content').delay(1200).fadeIn();
});

// Reload page
// a une date et heure donnée
//refreshPageNextDayAt(new Date(2015,11,15,12,05));
// a une heure donnée pour le lendemain
refreshPageNextDayAt(<?php include('refreshtime.inc'); ?>);

// Affiche une page web ou un slide (image) par dessus le slideshow			
function overSlide(_type,url,date) {
	var _now = new Date().getTime();
	var d1 = date.getTime();
	var diffTime = d1-_now;
 
	if (diffTime <= 0 ){
		// http://jacklmoore.com/colorbox
		if (_type=="iframe"){
		$.colorbox({iframe:true, href:url, width:"100%", height:"100%"});
		}
		if (_type=="photo"){
		$.colorbox({photo:true, href:url, width:"100%", height:"100%"});
		}
	}
};

// Recharge la page
function refreshPageNextDayAt(date) {
	var _now = new Date().getTime();
	if (typeof date === "object"){
		//new Date(year, month, day, hours, minutes, seconds, milliseconds);
		var refreshDate=date;
	}
	
	if (typeof date === "number" && date < 24){
		var refreshDate=new Date(_now.getFullYear(), _now.getMonth(), _now.getDate()+1,date);
	}
	
	if (typeof date === "number" && date > _now){
		var refreshDate=date;
	}
	
	//alert(refreshDate);
    setTimeout(function() { window.location.reload(true); }, refreshDate.getTime()-_now.getTime());
}

</script>






  </body>
  
</html>