<!doctype html>
<html dir="ltr" lang="es">
	<head>
		<meta charset="utf-8" />		
		<title>Guadalupe Iserte Aznar</title>
		<meta name="robots" content="index, follow" />		
		<meta name="description" content="" />
		<meta name="author" content="Carles Jove i Buxeda @ http://joanielena.cat" />

		<!-- Viewport -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0;" />

		<!-- CSS -->	
		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/app/css/basic.css" />
		<link rel="stylesheet" type="text/css" href="/public/resources/app/css/mobile.css" media="only screen and (min-width: 320px) and (max-width: 800px)" />
		<link rel="stylesheet" type="text/css" href="/public/resources/app/css/desktop.css" media="only screen and (min-width: 800px)" />
	
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<link rel="stylesheet" type="text/css" href="/public/resources/app/css/desktop.css" media="all" />
		<![endif]-->
		
		<!-- Fonts -->
	</head>
	<body>
		<div id="wrapper">
			<h1><a href="/">Guadalupe Iserte Aznar</a></h1>
			<nav>
				<ul class="nolist clear">
					<?php foreach($this->menus as $menu): ?>
					<li><a href="<?php echo $this->url->link_to($menu->identifier); ?>"><?php echo $menu->title; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>