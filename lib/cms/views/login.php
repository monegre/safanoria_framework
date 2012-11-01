<html>
	<head>
		<meta charset="utf-8" />
		<title>Login</title>
		<meta name="robots" content="noindex, nofollow, noarchive" />		
		<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
		<link rel="stylesheet" type="text/css"  href="/public/resources/admin/css/login.css" />
	</head>
	<body>
		<div id="login">
			<h1>Login</h1>
			<?php if($this->messenger->got_global_message()): ?>
				<div class="global-message">
					<h2><?php echo $this->messenger->global_message($_SESSION['global_message']); ?></h2>
				</div>
			<?php endif; ?>
		
			<form class="login" action="<?php echo $this->cms->url['login']; ?>" method="post">	
				<fieldset>
					<label for="email">Email</label>
					<input type="text" name="email" id="email" placeholder="Email" value="" />
				</fieldset>
				<fieldset>
					<label for="password">Password</label>
					<input type="password" name="password" id="password" placeholder="Password" value="" />
				</fieldset>
				<fieldset>
					<input type="submit" name="submit" value="Submit" />
				</fieldset>
				<!--<p><a href="#">Forgot your password?</a></p>-->
			</form>
		</div>
		<p class="copyright">Safanòria CMS © 2012 | <?php echo $this->version(); ?></p>
	</body>
</html>