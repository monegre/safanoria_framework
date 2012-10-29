<?php if (isset($_POST['nav-select'])) {header("Location: " . $_POST['nav-select']);} ?>
<!doctype html>
<html dir="ltr" lang="<?php echo $this->administrator->html['lang']; ?>">
	<head>
		<meta charset="utf-8" />		
		<title>Safanòria CMS<?php echo ' | ' . $this->current['page_title']; ?></title>
		<meta name="robots" content="noindex, nofollow, noarchive" />		
		<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
		
		<!-- css 	
		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/admin/css/basic.css" />
		<link rel="stylesheet" type="text/css" href="/public/resources/admin/css/mobile.css" media="only screen and (min-width: 320px) and (max-width: 800px)" />
		<link rel="stylesheet" type="text/css" href="/public/resources/admin/css/desktop.css" media="only screen and (min-width: 800px)" />
		-->

		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/admin/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/admin/css/bootstrap-responsive.css" />

		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/admin/css/basic.css" />
		
		<!-- Bootstrap Image Gallery styles -->
		<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="/public/resources/admin/css/jquery.fileupload-ui.css">
		<!-- CSS adjustments for browsers with JavaScript disabled
		<noscript><link rel="stylesheet" href="/public/resources/admin/css/jquery.fileupload-ui-noscript.css"></noscript> -->


		<!-- Tiny MCE script -->
		<script type="text/javascript" src="/public/resources/admin/js/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript">
			tinyMCE.init({
				theme : "simple",
				mode : "textareas",
				theme_advanced_buttons3 : "fontselect,fontsizeselect",
				editor_deselector : "no_editor",
				relative_urls : false
			});
		</script>
		<!-- /Tiny MCE script -->
	</head>
	<body>
		<header>
			<nav class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div id="wrapper">
						<a class="brand" href="/">My Website</a>
						<ul class="nav">
							<?php if(count(Section::all()) > 0): ?>
							<li class="dropdown">
								<a href="<?php echo $this->cms->url['publish']; ?>" class="dropdown-toggle" data-toggle="dropdown">
									Publicar
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li <?php echo $this->is_current('add-section', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-section']; ?>">Seccions</a></li>
									<li <?php echo $this->is_current('add-post', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-post']; ?>">Posts</a></li>
									<li <?php echo $this->is_current('add-category', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-category']; ?>">Categories</a></li>
									<li <?php echo $this->is_current('add-media', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-media']; ?>">Media</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="<?php echo $this->cms->url['edit']; ?>" class="dropdown-toggle" data-toggle="dropdown">
									Editar
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li <?php echo $this->is_current('sections', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['sections']; ?>">Seccions</a></li>
									<li <?php echo $this->is_current('posts', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['posts']; ?>">Posts</a></li>
									<li <?php echo $this->is_current('categories', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['categories']; ?>">Categories</a></li>
									<li <?php echo $this->is_current('media', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['media']; ?>">Media</a></li>
								</ul>
							</li>
							<li <?php echo $this->is_current('trash', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['trash']; ?>">Trash</a></li>
							
							<?php endif; ?>
							<li><a href="">Hola <?php echo $this->administrator->html['first_name']; ?></a></li>
							<li class="pull-right"><a href="<?php echo $this->cms->url['logout']; ?>"><?php echo $this->message('logout'); ?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>	
		<div id="wrapper">
			<div id="page">
				<p class="admin_located">
					<a href="<?php echo $this->cms->url['index']; ?>">home</a>
					 > <a href="<?php echo $this->cms->url[$this->current['page']]; ?>"><?php echo $this->current['page']; ?></a>
					 <?php echo isset($this->current['action']) ? ' > ' . $this->current['action']: ''; ?>
				</p>
				<h1><?php echo $this->current['page_title']; ?></h1>
				<?php if($this->messenger->got_global_message()): ?>
					<div id="global-message" class="alert <?php echo $this->messenger->message_class(); ?>">
						<?php echo $this->messenger->global_message($this->administrator->clean['lang']); ?>
						<button type="button" class="close" data-dismiss="alert">×</button>
					</div>
				<?php endif; ?>