<html>
	<head>
		<meta charset="utf-8" />
		<title>Benvinguda a Safanòria</title>
		<style>
			body {
				background: #F5F5F5;
				text-align: center;
			}
			div {
				background: white;
				padding: 50px;
				border: 1px solid #333;
				width: 400px;
				position: absolute;
				left: 50%;
				top: 30%;
				margin-left: -250px;
			}
		</style>
	</head>
	<div>
		<h1><?php echo $this->message("welcome_page_title"); ?></h1>
		<p><?php echo $this->message("welcome_page_body"); ?></p>
		<p style="font-size: small;"><?php echo $this->message("welcome_page_location"); ?></p>
		<p style="font-size: small;">Safanòria <?php echo $this->version; ?></p>
	</div>
</html>