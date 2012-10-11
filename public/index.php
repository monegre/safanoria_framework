<?php 
/** 
 * This file loads the config.php file, which will set some basics
 * Config.php will load settings.php, which will define paths to files and load all of necessary libraries
 *
 * This file also calls de Routing() function, which calls the correspondent controller
 */

if (file_exists(dirname(dirname(__FILE__)) . '/config/config.php')) 
{
	require_once ( dirname(dirname(__FILE__)) . '/config/config.php' );
}
else 
{
	exit('We could not find the config file. Safanoria needs this file in order to run. This is a fatal error.');
}


/** Get the $url and send it to the router */
$url = isset($_GET['url']) ? $_GET['url'] : "home";
new Router($url);
