<?php if (isset($_POST['nav-select'])) {header("Location: " . $_POST['nav-select']);} ?>
<!doctype html>
<html dir="ltr" lang="<?php echo $this->cms->admin->lang; ?>">
	<head>
		<meta charset="utf-8" />		
		<title>Safanòria CMS<?php echo ' | ' . $this->current['page_title']; ?></title>
		<meta name="robots" content="noindex, nofollow, noarchive" />		
		<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
		
		<!-- css -->	
		<link rel="stylesheet" type="text/css" media="screen, handheld" href="/public/resources/admin/css/basic.css" />
		<link rel="stylesheet" type="text/css" href="/public/resources/admin/css/mobile.css" media="only screen and (min-width: 320px) and (max-width: 800px)" />
		<link rel="stylesheet" type="text/css" href="/public/resources/admin/css/desktop.css" media="only screen and (min-width: 800px)" />
		
		<!-- Tiny MCE script -->
		<script type="text/javascript" src="/public/resources/admin/js/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript">
			tinyMCE.init({
				theme : "advanced",
				mode : "textareas",
				theme_advanced_buttons1 : "bold, italic, underline, strikethrough, separator, bullist, numlist, separator, link, unlink, image, separator, undo, redo",
				theme_advanced_buttons2 : "cut, copy, paste, removeformat,separator, sub, sup, separator, charmap, code",
				theme_advanced_buttons3 : "",
				relative_urls : false
			});
		</script>
		<!-- /Tiny MCE script -->
	</head>
	<body>
		<div id="wrapper">
			<head>
				<nav role="top navigation">
					<ul id="nav-top">
						<li>Hola <?php echo $this->cms->admin->first_name; ?></li>
						<li><a href="<?php echo $this->cms->url['logout']; ?>"><?php echo $this->message('logout'); ?></a></li>
					</ul>
				</nav>
				<nav role="primary navigation">
					<ul id="nav-list" class="desktop clear">
						<li <?php echo $this->is_current('publish', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['publish']; ?>">Publicar</a>
							<ul class="dropdown">
								<li <?php echo $this->is_current('add-section', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-section']; ?>">Seccions</a></li>
								<li <?php echo $this->is_current('add-post', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-post']; ?>">Posts</a></li>
								<li <?php echo $this->is_current('add-category', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-category']; ?>">Categories</a></li>
								<li <?php echo $this->is_current('add-media', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['add-media']; ?>">Media</a></li>
							</ul>
						</li>
						<li <?php echo $this->is_current('edit', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['edit']; ?>">Editar</a>
							<ul class="dropdown">
								<li <?php echo $this->is_current('sections', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['sections']; ?>">Seccions</a></li>
								<li <?php echo $this->is_current('posts', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['posts']; ?>">Posts</a></li>
								<li <?php echo $this->is_current('categories', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['categories']; ?>">Categories</a></li>
								<li <?php echo $this->is_current('media', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['media']; ?>">Media</a></li>
							</ul>
						</li>
						<li <?php echo $this->is_current('trash', array('class'=>'current')); ?>><a href="<?php echo $this->cms->url['trash']; ?>">Trash</a></li>
					</ul>
					
					<form id="nav-select" class="basic mobile" method="post" action="">
						<select name="nav-select" class="nav-select">
							<option selected="selected">Menú</option>
							<option value="<?php echo $this->cms->url['sections']; ?>">Seccions</option>
							<option value="<?php echo $this->cms->url['posts']; ?>">Posts</option>
							<option value="<?php echo $this->cms->url['categories']; ?>">Categories</option>
							<option value="<?php echo $this->cms->url['media']; ?>">Media</option>
						</select>
						<input type="submit" name="submit-nav" id="submit-nav" value="Ves" />
					</form>
					
				</nav>	
			</head>
			<div id="page">
				<p class="admin_located">
					<a href="<?php echo $this->cms->url['index']; ?>">home</a>
					 > <a href="<?php echo $this->cms->url[$this->current['page']]; ?>"><?php echo $this->current['page']; ?></a>
					 <?php echo isset($this->current['action']) ? ' > ' . $this->current['action']: ''; ?>
				</p>
				<h1><?php echo $this->current['page_title']; ?></h1>
				<?php if($this->messenger->got_global_message()): ?>
					<div id="global-message" class="<?php echo $this->messenger->message_class(); ?>">
						<p><?php echo $this->messenger->global_message($this->cms->admin->lang); ?></p>
					</div>
				<?php endif; ?>