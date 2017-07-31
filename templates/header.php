<!DOCTYPE html>
<html lang="fi">
<head>
  <title>Client | Property Maintenance</title>
  <meta charset="UTF-8">
  <meta name="description" content="PHPkesa (normaali harjoitustyö)">
  <meta name="author" content="Jani Suista">
  <meta name="robots" content="noindex,nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">  
  <link rel="stylesheet" href="<?= PATH ?>/assets/css/style.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>	
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <![endif]-->
</head> <!-- end of head-->
<body class="content">
	<?php if(!isset($_GET['mode'])): ?>
	<div id="preloader">
		<div id="status">
			<img src="assets/gfx/Rolling_Red.svg">
		</div>
	</div>
	<?php endif; ?>
	<div class="page-wrapper container">
		<?php 
			if(!empty($_SESSION['errors'])){
				foreach($_SESSION['errors'] as $error){
					printf('<p class="error_msg">Virhe: %s</p>',$error);
				}
				unset($_SESSION['errors']);
			}
		?>
		