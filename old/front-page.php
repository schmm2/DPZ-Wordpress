<!doctype html>
<html lang="de">
	<head>
		<?php
			wp_head();
		?>
	
		<title><?php bloginfo('name'); ?></title>	
		  		  	
	  	<!-- meta -->
	  
	  	<meta http-equiv="X-UA-Compatible" content="IE=9">
	  	<meta charset="utf-8">
	  	<meta name="description" content="dropzone-productions">
	  	<meta name="author" content="dropzone-productions">	  	
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">


	  	
	  	<!--[if IE 9]>
	  		<link rel="stylesheet" href="css/ie9.css">
	  		<link rel="stylesheet" href="css/blendmode-fallback.css">	
		<![endif]-->
	  	
	  	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />	
	  	  	
	  	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri()?>/css/img/favicon-dpz-white.png" />	
	 
	</head>

	<body>
		<div id="frontpage-container">
			<div id="info-container">
				<div id="logo">
					<a href="http://dropzone-productions.ch/">
						<img src="<?php echo get_template_directory_uri()?>/css/img/dZP-Logo-BlackonWhite.png"></img>
					</a>
				</div>			
				<div id="contact">
					<h6>Hallo</h6>
					<h7>Willkommen bei dropZone-Productions</h7>
					<p>Habt Ihr fragen?</br>Wir freuen uns auf eure Nachricht</p> 
					<div id="contact-table">
						<div class="row">
							<div><i class="fa fa-envelope-o "></i></div>
							<div><a href="mailto:dropZone-Productions@outlook.com" target="_top">dropZone-Productions@outlook.com</a></div>
						</div>
						<div class="row">
							<div><i class="fa fa-location-arrow"></i></div>
							<div><a href="https://www.google.ch/maps/place/Stauffacherstrasse+75,+3014+Bern" target="_blank">Stauffacherstrasse 75</br>CH-3014 Bern</a></div>
						</div>
					</div>
				</div>	
			</div>
			
			<div id="section-container">		
				<div id="studio" class="section">	
					<div class="section-img">
						<div class="section-title">Studio</div>
					</div>
				</div>
				<div id="video" class="section">					
					<div class="section-img">
						<div class="section-title">Video</div>
					</div>
				</div>
				<div id="event" class="section">
					<a style="display:block" href="https://lucid-reality.ch/">
						<div class="section-img">
							<div class="section-title">Event Management</div>
						</div>
					</a>
				</div>
				<div id="dropzone" class="section">					
					<div class="section-img">
						<div class="section-title">dropZone</div>
					</div>
				</div>
				<div id="gaming" class="section">
					<div class="section-img">
						<div class="section-title">Gaming</div>
					</div>
				</div>	
			</div>
			<!--- IE fallback -->
			<div class="clear"></div>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/blendmode-fallback.js"></script>
	</body>
</html>