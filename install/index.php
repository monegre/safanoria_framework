<?php
/**
 * Safanòria installer
 * 
 * Checks if server settings are ok for Safanòria's install
 *
 * @package Safanòria
 */

session_start();

/** Display errors. False by default */
$display_errors = TRUE;
if ($display_errors == TRUE) {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
}

/** 
 * First of all, define a language for the installation 
 */
$default_lang = "ca";
$install_lang = (empty($_SESSION['lang'])) ? $default_lang : $_SESSION['lang'];
$path_to_lang = "/app/langs/";

/** 
 * Include necessary files 
 */
require_once (dirname(dirname(__FILE__)) . '/app/libraries/database.php' );
require_once (dirname(dirname(__FILE__)) . '/app/libraries/functions.php' );
require_once (dirname(dirname(__FILE__)) . '/app/libraries/message.php' );
require_once (dirname(dirname(__FILE__)) . $path_to_lang . $install_lang . '/install.php' );

/** 
 * Vars used along the installation script 
 */
$warnings = array();
$errors = array();
$file = array();
$content = array();

/** $next_step needs to handle different type of actions */
// User wants to quit installation
if (isset($_POST['quit'])) {
	$next_step = "quit";
} else {
	// Language isn't set yet
	if (empty($_SESSION['next'])) {
		$next_step = "lang";
	} 
	// Redifine step value
	else {
		$next_step = $_SESSION['next'];
	}
}

/**
 * Array of documents to be created during installation
 */
$file['config'] = dirname(dirname(__FILE__)) . "/config/config.php";
$file['htaccess_root'] = dirname(dirname(__FILE__)) . "/.htaccess";
$file['htaccess_public'] = dirname(dirname(__FILE__)) . "/public/.htaccess";

/**
 * Array of documents to be created during installation
 */
$content['root_htaccess'] = "<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule    ^$    public/    [L]
    RewriteRule    (.*) public/$1   [L]
</IfModule>";

$content['public_htaccess'] = "<IfModule mod_rewrite.c>
RewriteEngine On
 
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
 
# Rewrite all other URLs to index.php/URL
RewriteRule ^(.*)$ index.php?url=$1 [PT,L]

</IfModule>

<IfModule !mod_rewrite.c>
	ErrorDocument 404 index.php
</IfModule>

#ErrorDocument 404 /views/404.php";


/** 
 * Installation begins 
 */
switch ($next_step) 
{
	// Installation language
	case 'lang':
		if (!isset($_SESSION['lang'])) 
		{
			if (isset($_POST['lang'])) 
			{
				$_SESSION['lang'] = $_POST['lang'];
				$_SESSION['next'] = "server-settings";
				redirect_with_message(array("url"=>"/install"));
			} else 
			{
				require_once( dirname(dirname(__FILE__)) . $path_to_lang . $default_lang . '/install.php' );		
			}
		} 
		break;
	// Server settings
	case 'server-settings':
		if (!extension_loaded("mysqli")) {
			$errors['mysqli'] = $safanoria['install']['mysqli_missing'];
		} 
		if (get_magic_quotes_gpc()) {
			$warnings['magic'] = $safanoria['install']['magic_quotes_gpc_on'];
		} 
		if (!ini_get('file_uploads')) {
			$warnings['file_uploads'] = "PHP does not have file uploads enabled. This will severely limit Safanòria's functionality.";
		} 
		if (intval(ini_get('upload_max_filesize')) < 4) {
			$warnings['upload_max_filesize'] = "Max upload filesize is currently less than 4MB. 8MB or higher is recommended.";
		} 
		if (intval(ini_get('post_max_size')) < 4) {
			$warnings['post_max_size'] = "Max POST size (post_max_size in php.ini) is currently less than 4MB. 8MB or higher is recommended.";
		} 
		if (intval(ini_get('memory_limit')) < 32) {
			$warnings['memory_limit'] = "PHP's memory limit is currently under 32MB. Safanòria recommends at least 32MB of memory be available to PHP.";
		} 
		if (!ini_get('short_open_tag')) {
			$warnings['short_open_tag'] = "PHP does not currently allow short_open_tags. Safanòria will attempt to override this at runtime but you may need to enable it in php.ini manually.";
		} 
		
		// Check there are no fatal errors before next step
		if (isset($_POST['next'])) {
			if (count($errors) === 0) 
			{
				$_SESSION['next'] = "database";
				header("Location: /install");
			} 
			else 
			{
				redirect_with_message(array("url"=>"/install", "message"=>$safanoria['install']['must_correct_setting']));
			}
		}
		break;
	// Database
	case 'database':
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['next'])) 
		{
			if ( !empty($_POST['db_name']) && !empty($_POST['db_user']) && !empty($_POST['db_pass']) && !empty($_POST['db_host']) ) 
			{
				// Some filter should go in here
				$clean['db_host'] = $_POST['db_host']; 
				$clean['db_user'] = $_POST['db_user']; 
				$clean['db_pass'] = $_POST['db_pass']; 
				$clean['db_name'] = $_POST['db_name'];
				$clean['db_charset'] = "";
				
				// Connect to database
				$db = db($clean['db_host'], $clean['db_user'], $clean['db_pass'], $clean['db_name']);
				
				// Create Tables
				$sql_queries = explode(";",file_get_contents( dirname(dirname(__FILE__)) . "/db/base.sql") );
				foreach ($sql_queries as $query) 
				{
					$query = trim($query);
					if ($query != "") 
					{
						$db->query($query);
						if ($db->connect_errno) 
						{
						    echo "Failed to connect to MySQL: " . $db->connect_error;
						} 
					}
				}
					
				$query = "INSERT INTO sf_config 
								(
								db_name, 
								db_user, 
								db_pass, 
								db_host, 
								db_charset
								) 
						  VALUES(
						  		'{$clean['db_name']}',
						  		'{$clean['db_user']}',
						  		'{$clean['db_pass']}',
						  		'{$clean['db_host']}',
						  		'{$clean['db_charset']}'
						  		)";
				
				$db->query($query);
						
				function create_file($file,$contents = "") {
					file_put_contents($file,$contents);
					chmod($file,0777);
				}		
				
				$find = array(
					"[db_name]",
					"[db_user]",
					"[db_pass]",
					"[db_host]"
				);
				
				$replace = array(
					$clean['db_name'],
					$clean['db_user'],
					$clean['db_pass'],
					$clean['db_host']
				);
				
					
				$config_file = create_file($file['config'],str_replace($find,$replace,file_get_contents("files/config.model.php")));
							
				
				
				
				if ($db->errno === 0) {
					$_SESSION['next'] = "custom-tables";
					redirect_with_message(array("url"=>"/install", "message"=>$safanoria['install']['base_tables_created']));
					exit;
				} else {
					redirect_with_message(array("url"=>"/install", "message"=>$safanoria['install']['could_not_update_db']));
					exit;
				}
			
			} else {
				redirect_with_message(array("url"=>"/install", "message"=>$safanoria['install']['check_db_info']));
			}
			
		}
		break;
	case 'custom-tables':
		break;
	case 'quit':
		session_destroy();
		header("Location: /install");
		break;
	default:
		exit('Install of Safanòria has quit because of an illegal action');
}
	
?>
<!doctype html>
<html dir="ltr" lang="<?php echo $install_lang; ?>">
	<head>
		<meta charset="utf-8" />		
		<title>Safanòria installation</title>
		<meta name="robots" content="noindex, nofollow, noarchive" />		
		<meta name="author" content="Carles Jove i Buxeda @ http://joanielena.cat" />
		<link rel="stylesheet" href="css/install.css" type="text/css" />
	</head>
	<body>
		
		<h1><?php echo $safanoria['install']['h1']; ?></h1>
		
		<?php if (got_global_message()): ?>
			<?php echo the_global_message(); ?>
		<?php endif; ?>
		
		<?php if ( $next_step == "lang" ): ?>
			<p><?php echo $safanoria['install']['intro']; ?></p>
			<form method="post" id="lang" action="">
				<select id="lang" name="lang">
					<option value="ca">Català</option>
					<option value="es">Castellano</option>
				</select>
				<input type="submit" name="next" value="<?php echo $safanoria['install']['next']; ?>" />
			</form>
		<?php endif; ?>
		
		<?php if ( $next_step == "server-settings" ): ?>
			<p><?php echo $safanoria['install']['server-settings']; ?></p>
			<ol class="check-list">
				<li class="<?php echo check_list_class("mysqli"); ?>"><b>Mysql extension</b> <?php echo check_list_message("mysqli", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("magic"); ?>"><b>Magic quotes</b> <?php echo check_list_message("magic", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("file_uploads"); ?>"><b>File uploads</b> <?php echo check_list_message("file_uploads", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("upload_max_filesize"); ?>"><b>Upload max filesize</b> <?php echo check_list_message("upload_max_filesize", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("post_max_size"); ?>"><b>Post max size</b> <?php echo check_list_message("post_max_size", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("memory_limit"); ?>"><b>Memory limit</b> <?php echo check_list_message("memory_limit", $safanoria['install']['setting_is_ok']); ?></li>
				<li class="<?php echo check_list_class("short_open_tag"); ?>"><b>Short open tag</b> <?php echo check_list_message("short_open_tag", $safanoria['install']['setting_is_ok']); ?></li>
			</ol>
							
			<form method="post" action="">
				<input type="submit" name="quit" value="<?php echo $safanoria['install']['quit']; ?>" />
				<input type="submit" name="next" value="<?php echo $safanoria['install']['next']; ?>" />
			</form>
		<?php endif; ?>
		
		<?php if ( $next_step == "database" ): ?>
			<p><?php echo $safanoria['install']['database']; ?></p>
			<form method="post" action="">
				<fieldset>
					<legend>Database info</legend>
					<div>
						<label for="db_name">Database name</label>
						<input type="text" name="db_name" id="db_name" value="" />
					</div>
					<div>
						<label for="db_user">Database user</label>
						<input type="text" name="db_user" id="db_user" value="" />
					</div>
					<div>
						<label for="db_pass">Database pass</label>
						<input type="password" name="db_pass" id="db_pass" value="" />
					</div>
					<div>
						<label for="db_host">Database host</label>
						<input type="text" name="db_host" id="db_host" value="localhost" />
					</div>
				</fieldset>				
				<input type="submit" name="quit" value="<?php echo $safanoria['install']['quit']; ?>" />
				<input type="submit" name="next" value="<?php echo $safanoria['install']['next']; ?>" />
			</form>
		<?php endif; ?>
		
		<?php if ( $next_step == "custom-tables" ): ?>
			<?php echo $safanoria['install']['custom_tables']; ?>
			<form method="post" action="">
						
				<input type="submit" name="quit" value="<?php echo $safanoria['install']['quit']; ?>" />
				<input type="submit" name="next" value="<?php echo $safanoria['install']['next']; ?>" />
			</form>
		<?php endif; ?>
		
	</body>
</html>